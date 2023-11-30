<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

/**
 * @method static static make(string $url, string $target = self::TARGET_BLANK, int $code = 302)
 */
class Redirect extends AbstractAction
{
    public const TARGET_SELF   = '_self';
    public const TARGET_BLANK  = '_blank';
    public const TARGET_TOP    = '_top';
    public const TARGET_PARENT = '_parent';

    public const TYPE_NATIVE = 'native';
    public const TYPE_ROUTER = 'router';

    public function __construct(
        protected string $url,
        protected string $target = self::TARGET_BLANK,
        protected int $code = 302,
        protected string $type = self::TYPE_NATIVE
    ) {
    }

    /**
     * @return array{url:string, target:string, code: int}
     */
    protected function toActionArray(): array
    {
        return [
            'url'    => $this->url,
            'target' => $this->target,
            'type'   => $this->type,
            'code'   => $this->code,
        ];
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public static function pushToRoute(string $url): self
    {
        return new self($url, type: self::TYPE_ROUTER);
    }
}
