<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

use function array_merge;

/**
 * @method static static make(string $url, string $name, array $params = [])
 */
class Download extends AbstractAction
{
    use WithParams;

    public function __construct(
        protected string $url,
        protected string $name,
        array $params = []
    ) {
        $this->params = $params;
    }

    /**
     * @return array{url:string, name:string, params: array<string, mixed>}|array{url:string, name:string}
     */
    protected function toActionArray(): array
    {
        return array_merge(
            [
                'url'  => $this->url,
                'file' => $this->name,
            ],
            count($this->params) === 0 ? [] : ['params' => $this->params]
        );
    }
}
