<?php

declare(strict_types=1);

namespace ResponseActions\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\MessageTypeEnum;
use ResponseActions\ResponseAction;
use ResponseActions\StatusEnum;

final class MessageActionTest extends TestCase
{
    #[Test]
    public function makeInfo(): void
    {
        $ra = new ResponseAction(StatusEnum::INFO);
        self::assertFalse($ra->isNothing());
        self::assertFalse($ra->isError());
        self::assertTrue($ra->is(StatusEnum::INFO));
        self::assertCount(0, $ra->actions());
        self::assertEquals(
            [
                'status' => StatusEnum::INFO,
            ],
            $ra->toArray()
        );
    }

    #[Test]
    public function successMessage(): void
    {
        $ra = ResponseAction::successMessage('Operation has done!');

        self::assertTrue($ra->is(StatusEnum::SUCCESS));
        self::assertCount(1, $ra->actions());
        self::assertEquals(
            [
                'actions' => [
                    [
                        'name'    => 'message',
                        'order'   => 0,
                        'message' => 'Operation has done!',
                        'type'    => MessageTypeEnum::SUCCESS,
                    ],
                ],
                'status'  => StatusEnum::SUCCESS,
            ],
            $ra->toArray()
        );
    }
}
