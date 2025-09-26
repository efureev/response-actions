<?php

declare(strict_types=1);

namespace ResponseActions\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\Command;
use ResponseActions\Actions\CommandStatus;
use ResponseActions\ResponseAction;
use ResponseActions\StatusEnum;

final class CommandActionTest extends TestCase
{
    #[Test]
    public function create(): void
    {
        $action = new Command(CommandStatus::Done);

        self::assertEquals('cmd', $action->name());
        self::assertEquals(0, $action->order());
        self::assertEquals([
            'name' => 'cmd',
            'order' => 0,
            'status' => CommandStatus::Done,
        ], $action->toArray());
    }

    #[Test]
    public function make(): void
    {
        $action = Command::makeFailed('Test');

        self::assertEquals('cmd', $action->name());
        self::assertEquals(0, $action->order());
        self::assertEquals([
            'name' => 'cmd',
            'order' => 0,
            'status' => CommandStatus::Failed,
            'description' => 'Test',
        ], $action->toArray());
    }

    #[Test]
    public function makeCmdDone(): void
    {
        $ra = ResponseAction::cmdDone();
        self::assertFalse($ra->isError());
        self::assertCount(1, $ra->actions());
        self::assertEquals([
            'actions' => [
                [
                    'name' => 'cmd',
                    'order' => 0,
                    'status' => CommandStatus::Done,
                ]
            ],
            'status' => StatusEnum::SUCCESS
        ], $ra->toArray());
    }
}
