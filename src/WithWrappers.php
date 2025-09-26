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
        return new self(StatusEnum::SUCCESS)->addAction(new Message($message));
    }

    public static function errorMessage(string $message): self
    {
        return new self(StatusEnum::ERROR)->addAction(new Message($message));
    }

    public static function warningMessage(string $message): self
    {
        return new self(StatusEnum::WARNING)->addAction(new Message($message));
    }

    public static function infoMessage(string $message): self
    {
        return new self(StatusEnum::INFO)->addAction(new Message($message));
    }

    public static function cmd(?string $description = null): self
    {
        return new self(StatusEnum::NOTHING)->addAction(Command::pending($description));
    }

    public static function cmdFailed(?string $description = null): self
    {
        return new self(StatusEnum::ERROR)->addAction(Command::makeFailed($description));
    }

    public static function cmdDone(?string $description = null): self
    {
        return new self(StatusEnum::SUCCESS)->addAction(Command::makeDone($description));
    }

    public static function redirect(string $url, string $target = Redirect::TARGET_BLANK, int $code = 302): self
    {
        return new self(StatusEnum::NOTHING)->addAction(new Redirect($url, $target, $code));
    }

    public static function download(string $url, string $name, array $params = []): self
    {
        return new self(StatusEnum::NOTHING)->addAction(new Download($url, $name, $params));
    }

    public static function event(string $event, array $params = []): self
    {
        return new self(StatusEnum::NOTHING)->addAction(new Event($event, $params));
    }
}
