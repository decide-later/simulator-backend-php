<?php

use app\engine\Flags;
use app\engine\Script;
use app\engine\State;
use app\engine\Transition;

$script = new Script('travel', [
    'start' => State::content('Вы хотите в путешествие. Куда поедем?')
        ->transition('too_dangeous', 'В Дамаск', 'too_dangeous')
        ->transition('visa_munich', 'В Мюнхен', 'visa'),

    'too_dangeous' => State::content('Не очень хорошая идея. Обстановка в Сирии сейчас совсем не для путешествий.')
        ->transition('try_again', 'Попробуй ещё раз', 'start'),

    'visa' => State::content('Едем в Мюнхен! Делаем визу?')
        ->transition('visa_yes', 'Да', function(array $fields) {
            Flags::write('visa_fail', 0);
            return 'airport';
        })
        ->transition('visa_no', 'Нет', function (array $fields) {
            Flags::write('visa_fail', 1);
            return 'airport';
        }),

    'airport' => State::content('Вы в аэророту. Идём на паспортный контроль?')
        ->transition('border_go', 'Идём', function (array $fields) {
            $visaFail = Flags::read('visa_fail');
            if ($visaFail) {
                return 'visa_fail';
            }

            return 'fly';
        })
        ->transition('border_late', 'Ой не', 'late'),


    'late' => State::content('Вы опозлали на самолёт.')
        ->transition('try_again', 'Попробуй ещё раз', 'airport'),
    'visa_fail' => State::content('Вас не пустили. Мюнхен в ЕС, нужно было делать визу.')
        ->transition('try_again', 'Попробуй ещё раз', ''),
    'fly' => State::content('Полетели!')
        ->transition('restart', 'Ещё раз?', 'start')
]);

return $script;
