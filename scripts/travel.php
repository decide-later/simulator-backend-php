<?php

use app\engine\Flags;
use app\engine\Html;
use app\engine\Script;
use app\engine\State;

$html = new Html(__DIR__ . '/travel');

class States {
    public const START = 'start';
    public const TOO_DANGEROUS = 'too_dangerous';
    public const VISA = 'visa';
    public const AIRPORT = 'airport';
    public const LATE = 'late';
    public const VISA_FAIL = 'visa_fail';
    public const FLY = 'fly';
}

$script = new Script('travel', [
    States::START => State::content($html->get('start'))
        ->transition('too_dangeous', 'В Дамаск', States::TOO_DANGEROUS)
        ->transition('visa_munich', 'В Мюнхен', States::VISA),

    States::TOO_DANGEROUS => State::content('Не очень хорошая идея. Обстановка в Сирии сейчас совсем не для путешествий.')
        ->transition('try_again', 'Попробуй ещё раз', states::START),

    States::VISA => State::content('Едем в Мюнхен! Делаем визу?')
        ->transition('visa_yes', 'Да', function(array $fields) {
            Flags::write('visa_fail', 0);
            return States::AIRPORT;
        })
        ->transition('visa_no', 'Нет', function (array $fields) {
            Flags::write('visa_fail', 1);
            return States::AIRPORT;
        }),

    States::AIRPORT => State::content('Вы в аэророту. Идём на паспортный контроль?')
        ->transition('border_go', 'Идём', function (array $fields) {
            $visaFail = Flags::read('visa_fail');
            if ($visaFail) {
                return States::VISA_FAIL;
            }

            return States::FLY;
        })
        ->transition('border_late', 'Ой не', 'late'),


    States::LATE => State::content('Вы опозлали на самолёт.')
        ->transition('try_again', 'Попробуй ещё раз', States::AIRPORT),
    States::VISA_FAIL => State::content($html->get('visa_fail'))
        ->transition('try_again', 'Попробуй ещё раз', States::VISA),
    States::FLY => State::content('Полетели!')
        ->transition('restart', 'Ещё раз?', States::START)
]);

return $script;
