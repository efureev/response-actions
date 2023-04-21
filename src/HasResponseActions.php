<?php

declare(strict_types=1);

namespace ResponseActions;

trait HasResponseActions
{
    protected ResponseAction $responseActions;

    public function setResponseActions(ResponseAction $responseAction): static
    {
        $this->responseActions = $responseAction;

        return $this;
    }

    public function responseActions(): ResponseAction
    {
        return $this->responseActions;
    }
}
