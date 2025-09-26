<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

use function array_merge;

class Download extends AbstractAction
{
    use WithParams;

    /**
     * @param array<string, mixed> $params
     */
    public function __construct(
        protected string $url,
        protected string $name,
        array $params = []
    ) {
        $this->params = $params;
    }

    public function name(): string
    {
        return 'download';
    }

    /**
     * @return array{url:string, file:string, params?: array<string, mixed>}|array<'file'|'params'|'url'>
     */
    protected function toActionArray(): array
    {
        return array_merge(
            [
                'url'  => $this->url,
                'file' => $this->name,
            ],
            !empty($this->params) ? ['params' => $this->params] : []
        );
    }
}
