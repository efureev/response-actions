<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

/**
 * @method static static make(string $event, array $params = [])
 */
class Event extends AbstractAction
{
    use WithParams;

    public function __construct(
        protected string $event,
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
