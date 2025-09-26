<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

class Redirect extends AbstractAction
{
    public const string TARGET_SELF   = '_self';
    public const string TARGET_BLANK  = '_blank';
    public const string TARGET_TOP    = '_top';
    public const string TARGET_PARENT = '_parent';

    public const string TYPE_NATIVE = 'native';
    public const string TYPE_ROUTER = 'router';

    private const int DEFAULT_HTTP_CODE = 302;

    public function __construct(
        protected string $url,
        protected string $target = self::TARGET_BLANK,
        protected int $code = self::DEFAULT_HTTP_CODE,
        protected string $type = self::TYPE_NATIVE
    ) {
    }

    public function name(): string
    {
        return 'redirect';
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

    public function withType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @deprecated Use router() named constructor instead.
     */
    public static function pushToRoute(string $url): self
    {
        return self::router($url);
    }

    public static function router(string $url): self
    {
        return new self($url, type: self::TYPE_ROUTER);
    }

    public static function native(string $url, string $target = self::TARGET_BLANK, int $code = self::DEFAULT_HTTP_CODE): self
    {
        return new self($url, $target, $code, self::TYPE_NATIVE);
    }
}
