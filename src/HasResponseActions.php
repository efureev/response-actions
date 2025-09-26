<?php

declare(strict_types=1);

namespace ResponseActions;

use ResponseActions\Actions\Action;

trait HasResponseActions
{
    private const StatusEnum DEFAULT_STATUS = StatusEnum::NOTHING;

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
        $this->responseActions = new ResponseAction(self::DEFAULT_STATUS, ...$action);

        return $this;
    }

    public function initResponseActionsWithStatus(StatusEnum $status, Action ...$action): static
    {
        $this->responseActions = new ResponseAction($status, ...$action);

        return $this;
    }
}
