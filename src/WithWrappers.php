<?php

declare(strict_types=1);

namespace ResponseActions;

use ResponseActions\Actions\Command;
use ResponseActions\Actions\Download;
use ResponseActions\Actions\Event;
use ResponseActions\Actions\Message;
use ResponseActions\Actions\Redirect;

/**
 * @mixin ResponseAction
 */
trait WithWrappers
{
    public static function successMessage(string $message): self
    {
        return self::make(StatusEnum::Success)->addAction(Message::make($message));
    }

    public static function errorMessage(string $message): self
    {
        return self::make(StatusEnum::Error)->addAction(Message::make($message));
    }

    public static function warningMessage(string $message): self
    {
        return self::make(StatusEnum::Warning)->addAction(Message::make($message));
    }

    public static function infoMessage(string $message): self
    {
        return self::make(StatusEnum::Info)->addAction(Message::make($message));
    }

    public static function cmd(?string $description = null): self
    {
        return self::make(StatusEnum::Nothing)->addAction(Command::pending($description));
    }

    public static function cmdFailed(?string $description = null): self
    {
        return self::make(StatusEnum::Error)->addAction(Command::makeFailed($description));
    }

    public static function cmdDone(?string $description = null): self
    {
        return self::make(StatusEnum::Success)->addAction(Command::makeDone($description));
    }

    public static function redirect(string $url, string $target = Redirect::TARGET_BLANK, int $code = 302): self
    {
        return self::make(StatusEnum::Nothing)->addAction(Redirect::make($url, $target, $code));
    }

    public static function download(string $url, string $name, array $params = []): self
    {
        return self::make(StatusEnum::Nothing)->addAction(Download::make($url, $name, $params));
    }

    public static function event(string $event, array $params = []): self
    {
        return self::make(StatusEnum::Nothing)->addAction(Event::make($event, $params));
    }
}
