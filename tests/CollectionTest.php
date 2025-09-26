<?php

declare(strict_types=1);

namespace ResponseActions\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\Action;
use ResponseActions\Actions\Message;
use ResponseActions\Actions\MessageTypeEnum;
use ResponseActions\Collection;

final class CollectionTest extends TestCase
{
    #[Test]
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

    #[Test]
    public function actionsNonOrder(): void
    {
        $collection = new Collection(Message::info('Info'), Message::success('Success'));

        self::assertCount(2, $collection);

        self::assertEquals([
            [
                'name' => 'message',
                'order' => 0,
                'message' => 'Info',
                'type' => MessageTypeEnum::INFO,
            ],
            [
                'name' => 'message',
                'order' => 0,
                'message' => 'Success',
                'type' => MessageTypeEnum::SUCCESS,
            ]
        ], $collection->toArray());
    }

    #[Test]
    public function actionsOrder(): void
    {
        $collection = new Collection(Message::info('Info')->withOrder(3), Message::success('Success'));

        self::assertCount(2, $collection);

        self::assertEquals([
            [
                'name' => 'message',
                'order' => 0,
                'message' => 'Success',
                'type' => MessageTypeEnum::SUCCESS,
            ],
            [
                'name' => 'message',
                'order' => 3,
                'message' => 'Info',
                'type' => MessageTypeEnum::INFO,
            ],
        ], $collection->toArray());
    }

    #[Test]
    public function actionsUnderZeroOrder(): void
    {
        $collection = new Collection(Message::info('Info')->withOrder(-3), Message::success('Success'));

        self::assertCount(2, $collection);

        self::assertEquals([
            [
                'name' => 'message',
                'order' => -3,
                'message' => 'Info',
                'type' => MessageTypeEnum::INFO,
            ],
            [
                'name' => 'message',
                'order' => 0,
                'message' => 'Success',
                'type' => MessageTypeEnum::SUCCESS,
            ],

        ], $collection->toArray());
    }

    #[Test]
    public function testJsonSerialize(): void
    {
        $collection = new Collection(Message::info('Info')->withOrder(1), Message::success('Success'));

        $expectedJson = json_encode([
            [
                'name' => 'message',
                'order' => 0,
                'message' => 'Success',
                'type' => MessageTypeEnum::SUCCESS,
            ],
            [
                'name' => 'message',
                'order' => 1,
                'message' => 'Info',
                'type' => MessageTypeEnum::INFO,
            ],
        ]);

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($collection));
    }

    #[Test]
    public function testGetIterator(): void
    {
        $collection = new Collection(
            Message::info('Info')->withOrder(2),
            Message::success('Success')->withOrder(1)
        );

        $iterator = $collection->getIterator();

        $items = iterator_to_array($iterator);

        self::assertCount(2, $items);

        self::assertEquals('Info', $items[0]->toArray()['message']);
        self::assertEquals('Success', $items[1]->toArray()['message']);
    }
}
