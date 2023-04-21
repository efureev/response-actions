<?php

declare(strict_types=1);

namespace ResponseActions\Tests;

use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\Command;
use ResponseActions\Actions\CommandStatus;
use ResponseActions\ResponseAction;

final class CommandActionTest extends TestCase
{
    /**
     * @test
     */
    public function create(): void
    {
        $action = new Command(CommandStatus::Done);

        self::assertEquals('command', $action->name());
        self::assertEquals(0, $action->order());
        self::assertEquals([
            'name' => 'command',
            'order' => 0,
            'status' => 'done',
        ], $action->toArray());
    }

    /**
     * @test
     */
    public function make(): void
    {
        $action = Command::failed('Test');

        self::assertEquals('command', $action->name());
        self::assertEquals(0, $action->order());
        self::assertEquals([
            'name' => 'command',
            'order' => 0,
            'status' => 'failed',
            'description' => 'Test',
        ], $action->toArray());
    }

    /**
     * @test
     */
    public function makeCmdDone(): void
    {
        $ra = ResponseAction::cmdDone();
        self::assertFalse($ra->isError());
        self::assertCount(1, $ra->actions());
        self::assertEquals([
            'actions' => [
                [
                    'name' => 'command',
                    'order' => 0,
                    'status' => 'done',
                ]
            ],
            'status' => 'success'
        ], $ra->toArray());
    }
}
