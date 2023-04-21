<?php

declare(strict_types=1);

namespace ResponseActions;

trait HasResponseActions
{
    protected ResponseAction $responseAction;

    public function setActionMessage(ResponseAction $responseAction): static
    {
        $this->responseAction = $responseAction;

        return $this;
    }

    public function actionMessage(): ResponseAction
    {
        return $this->responseAction;
    }
}
