<?php

namespace app\controllers;

use app\engine\Engine;
use app\engine\NoTransition;
use app\engine\Transition;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class ApiController extends Controller
{
    private function getEngine(): Engine
    {
        $script = require Yii::getAlias('@app/scripts/travel.php');
        return new Engine($script);
    }

    public function actionStateGet()
    {
        $state = $this->getEngine()->getCurrentState();

        $response = [
            'name' => $state->getName(),
            'content' => $state->getContent(),
        ];

        foreach ($state->getTransitions() as $transition) {
            /* @var $transition Transition */
            $response['transitions'][] = [
                'name' => $transition->getName(),
                'title' => $transition->getTitle(),
            ];
        }

        return $response;
    }

    public function actionStateTransit()
    {
        $transitionName = Yii::$app->request->getBodyParam('to');
        if (empty($transitionName)) {
            throw new BadRequestHttpException('"to" parameter is required');
        }

        $fields = Yii::$app->request->getBodyParam('fields');
        if ($fields === null) {
            $fields = [];
        }

        if (!is_array($fields)) {
            throw new BadRequestHttpException('"fields" parameter should be an array.');
        }

        try {
            $this->getEngine()->transit($transitionName, $fields);
        } catch (NoTransition $e) {
            Yii::$app->response->setStatusCode(400);
            return [
                'success' => false,
                'reason' => $e->getMessage(),
            ];
        }

        return [
          'success' => true
        ];
    }
}