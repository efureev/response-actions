<?php

declare(strict_types=1);

namespace ResponseActions;

use ResponseActions\Actions\Action;

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

    public function initResponseActions(Action ...$action): static
    {
        $this->responseActions = new ResponseAction(StatusEnum::Nothing, ...$action);

        return $this;
    }
}
