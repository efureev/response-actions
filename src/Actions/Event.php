<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

class Event extends AbstractAction
{
    use WithParams;

    public function __construct(
        protected string $event,
        /** @var array<string, mixed> $params */
        array $params = []
    ) {
        $this->params = $params;
    }

    public function name(): string
    {
        return 'event';
    }

    /**
     * @return array{event:string, params:array<string,mixed>}
     */
    protected function toActionArray(): array
    {
        return [
            'event'  => $this->event,
            'params' => $this->params,
        ];
    }
}
