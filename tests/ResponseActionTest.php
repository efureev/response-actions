<?php

declare(strict_types=1);

namespace ResponseActions\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\Message;
use ResponseActions\Actions\MessageTypeEnum;
use ResponseActions\ResponseAction;
use ResponseActions\StatusEnum;

final class ResponseActionTest extends TestCase
{
    #[Test]
    public function create(): void
    {
        $ra = new ResponseAction();
        self::assertTrue($ra->isNothing());
        self::assertFalse($ra->isError());
        self::assertCount(0, $ra->actions());
        self::assertEquals(
            [
                'status' => StatusEnum::NOTHING,
            ],
            $ra->toArray()
        );
    }

    #[Test]
    public function createSuccess(): void
    {
        $ra = new ResponseAction(StatusEnum::SUCCESS);
        self::assertFalse($ra->isNothing());
        self::assertFalse($ra->isError());
        self::assertTrue($ra->is(StatusEnum::SUCCESS));
        self::assertCount(0, $ra->actions());
        self::assertEquals(
            [
                'actions' => [
                    'status' => StatusEnum::SUCCESS,
                ],
            ],
            $ra->wrap('actions')
        );
    }

    #[Test]
    public function errorMessages(): void
    {
        $ra = ResponseAction::errorMessage('Operation has failed!')
            ->addAction(Message::info('Try to restart page'))
            ->withExtra(['value' => 12]);

        self::assertTrue($ra->is(StatusEnum::ERROR));
        self::assertCount(2, $ra->actions());
        self::assertEquals(
            [
                '_responseAction' =>
                [
                    'actions' => [
                        [
                            'name'    => 'message',
                            'order'   => 0,
                            'message' => 'Operation has failed!',
                            'type'    => MessageTypeEnum::ERROR,
                        ],
                        [
                            'name'    => 'message',
                            'order'   => 0,
                            'message' => 'Try to restart page',
                            'type'    => MessageTypeEnum::INFO,
                        ],
                    ],
                    'status'  => StatusEnum::ERROR,
                    'extra'   => ['value' => 12],
                ],
            ],
            $ra->wrap()
        );
    }

    #[Test]
    public function setResponseKey_updatesResponseKey(): void
    {
        $ra = new ResponseAction();
        $ra->setResponseKey('new_key');
        self::assertEquals('new_key', $ra->responseKey());
    }

    #[Test]
    public function setResponseKey_affectsWrapOutput(): void
    {
        $ra = new ResponseAction();
        $ra->setResponseKey('custom_key');
        $output = $ra->wrap();

        self::assertArrayHasKey('custom_key', $output);
        self::assertEquals(['status' => StatusEnum::NOTHING], $output['custom_key']);
    }

    #[Test]
    public function testToEncodedString_withDefaultEncoding(): void
    {
        $ra      = new ResponseAction(StatusEnum::SUCCESS);
        $encoded = $ra->toEncodedString();

        self::assertNotNull($encoded);
        self::assertEquals(
            \ResponseActions\Utils\B64::encodeUrlSafe($ra->toString()),
            $encoded
        );
    }

    #[Test]
    public function testToEncodedString_withStandardBase64Encoding(): void
    {
        $ra      = new ResponseAction(StatusEnum::SUCCESS);
        $encoded = $ra->toEncodedString(null, 'b64');

        self::assertNotNull($encoded);
        self::assertEquals(
            \ResponseActions\Utils\B64::encode($ra->toString()),
            $encoded
        );
    }

    #[Test]
    public function testToEncodedString_withInvalidEncodingAlgorithm(): void
    {
        $this->expectException(\ResponseActions\Exceptions\InvalidStringEncoder::class);

        $ra = new ResponseAction(StatusEnum::ERROR);
        $ra->toEncodedString(null, 'invalid_alg');
    }
}
