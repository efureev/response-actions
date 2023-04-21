<?php

declare(strict_types=1);

namespace ResponseActions\Tests;

use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\Message;
use ResponseActions\ResponseAction;
use ResponseActions\StatusEnum;

final class ResponseActionTest extends TestCase
{
    /**
     * @test
     */
    public function create(): void
    {
        $ra = new ResponseAction();
        self::assertTrue($ra->isNothing());
        self::assertFalse($ra->isError());
        self::assertCount(0, $ra->actions());
        self::assertEquals([
            'status' => ''
        ], $ra->toArray());
    }

    /**
     * @test
     */
    public function createSuccess(): void
    {
        $ra = new ResponseAction(StatusEnum::Success);
        self::assertFalse($ra->isNothing());
        self::assertFalse($ra->isError());
        self::assertTrue($ra->is(StatusEnum::Success));
        self::assertCount(0, $ra->actions());
        self::assertEquals([
            'actions' => [
                'status' => 'success'
            ]
        ], $ra->wrap('actions'));
    }

    /**
     * @test
     */
    public function errorMessages(): void
    {
        $ra = ResponseAction::errorMessage('Operation has failed!')
            ->addAction(Message::info('Try to restart page'))
            ->withExtra(['value' => 12]);

        self::assertTrue($ra->is(StatusEnum::Error));
        self::assertCount(2, $ra->actions());
        self::assertEquals([
            'actionMessage' =>
                [
                    'actions' => [
                        [
                            'name' => 'message',
                            'order' => 0,
                            'message' => 'Operation has failed!',
                            'type' => 'error',
                        ],
                        [
                            'name' => 'message',
                            'order' => 0,
                            'message' => 'Try to restart page',
                            'type' => 'info',
                        ]
                    ],
                    'status' => 'error',
                    'extra' => ['value' => 12]
                ]
        ], $ra->wrap());
    }
}
