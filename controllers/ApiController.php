<?php

namespace app\controllers;

use yii\rest\Controller;

class ApiController extends Controller
{
    public function actionStateGet()
    {
        return [
          "name" => "in_airplane",
          "type" => "regular",
          "transitions" => [
            "name" => "jump_off",
            "title" => "Открыть люк и выпрыгнуть",
          ],
          "content" => "Some multiline content in mixed markdown and HTML",
          "fields" => [
            "name" => "bla-bla",
            "type" => "input",
            "validator" => null,
          ],
        ];
    }

    public function actionStateTransit()
    {
        return [
          'success' => true
        ];
    }
}