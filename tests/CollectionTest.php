<?php

declare(strict_types=1);

namespace ResponseActions\Tests;

use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\Action;
use ResponseActions\Actions\Message;
use ResponseActions\Collection;

final class CollectionTest extends TestCase
{
    /**
     * @test
     */
    public function add(): void
    {
        $collection = new Collection(Message::info('Hey'));

        self::assertCount(1, $collection);
        $actions = $collection->all();

        /** @var Action $action */
        $action = array_shift($actions);
        self::assertEquals('message', $action->name());
        self::assertEquals(0, $action->order());
    }

    /**
     * @test
     */
    public function actionsNonOrder(): void
    {
        $collection = new Collection(Message::info('Info'), Message::success('Success'));

        self::assertCount(2, $collection);

        self::assertEquals([
            [
                'name' => 'message',
                'order' => 0,
                'message' => 'Info',
                'type' => 'info',
            ],
            [
                'name' => 'message',
                'order' => 0,
                'message' => 'Success',
                'type' => 'success',
            ]
        ], $collection->toArray());
    }

    /**
     * @test
     */
    public function actionsOrder(): void
    {
        $collection = new Collection(Message::info('Info')->setOrder(3), Message::success('Success'));

        self::assertCount(2, $collection);

        self::assertEquals([
            [
                'name' => 'message',
                'order' => 0,
                'message' => 'Success',
                'type' => 'success',
            ],
            [
                'name' => 'message',
                'order' => 3,
                'message' => 'Info',
                'type' => 'info',
            ],
        ], $collection->toArray());
    }

    /**
     * @test
     */
    public function actionsUnderZeroOrder(): void
    {
        $collection = new Collection(Message::info('Info')->setOrder(-3), Message::success('Success'));

        self::assertCount(2, $collection);

        self::assertEquals([
            [
                'name' => 'message',
                'order' => -3,
                'message' => 'Info',
                'type' => 'info',
            ],
            [
                'name' => 'message',
                'order' => 0,
                'message' => 'Success',
                'type' => 'success',
            ],

        ], $collection->toArray());
    }
}
