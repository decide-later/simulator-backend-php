<?php


namespace app\engine;
use app\models\Savepoint;
use http\Exception\RuntimeException;

class Engine
{
    private $stateSource;

    public function __construct(StateSource $stateSource)
    {
        $this->stateSource = $stateSource;
    }

    public function getCurrentState(): State
    {
        $savepoint = $this->findOrCreateSavepoint();
        return $this->stateSource->getState($savepoint->state);
    }

    public function transit(string $transitionName, array $fields): void
    {
        $transition = $this->getCurrentState()->getTransition($transitionName);

        if ($callback = $transition->getCallback()) {
            $target = $callback($fields);
        } else {
            $target = $transition->getTarget();
        }

        $savepoint = $this->findOrCreateSavepoint();
        $savepoint->state = $target;
        if (!$savepoint->save()) {
            throw new \RuntimeException('Unable to save savepoint: ' . json_encode($savepoint->getErrors()));
        }
    }

    private function findOrCreateSavepoint(): Savepoint
    {
        $savepoint = Savepoint::find()->where(['user_id' => 1, 'script' => $this->stateSource->getName()])->one();
        if (!$savepoint) {
            $savepoint = new Savepoint();
            $savepoint->user_id = 1;
            $savepoint->script = $this->stateSource->getName();
            $savepoint->state = State::START;
        }
        return $savepoint;
    }
}
