<?php

declare(strict_types=1);

namespace ResponseActions\Tests;

use PHPUnit\Framework\TestCase;
use ResponseActions\ResponseAction;
use ResponseActions\StatusEnum;

final class MessageActionTest extends TestCase
{
    /**
     * @test
     */
    public function makeInfo(): void
    {
        $ra = ResponseAction::make(StatusEnum::Info);
        self::assertFalse($ra->isNothing());
        self::assertFalse($ra->isError());
        self::assertTrue($ra->is(StatusEnum::Info));
        self::assertCount(0, $ra->actions());
        self::assertEquals([
            'status' => 'info'
        ], $ra->toArray());
    }

    /**
     * @test
     */
    public function successMessage(): void
    {
        $ra = ResponseAction::successMessage('Operation has done!');

        self::assertTrue($ra->is(StatusEnum::Success));
        self::assertCount(1, $ra->actions());
        self::assertEquals([
            'actions' => [
                [
                    'name' => 'message',
                    'order' => 0,
                    'message' => 'Operation has done!',
                    'type' => 'success',
                ]
            ],
            'status' => 'success'
        ], $ra->toArray());
    }
}
