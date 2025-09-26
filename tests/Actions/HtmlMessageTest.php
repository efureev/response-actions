<?php

namespace ResponseActions\Tests\Actions;

use JsonSerializable;
use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\HtmlMessage;
use ResponseActions\Actions\MessageTypeEnum;
use Stringable;

class HtmlMessageTest extends TestCase
{
    /**
     * Test that the name() method returns 'htmlMessage'.
     */
    public function testNameReturnsHtmlMessage(): void
    {
        $htmlMessage = new HtmlMessage('Test message');
        $this->assertSame('htmlMessage', $htmlMessage->name());
    }

    /**
     * Test that __construct initializes correctly with a Stringable input and default type.
     */
    public function testConstructWithStringableAndDefaultType(): void
    {
        $stringableMessage = new class () implements Stringable {
            public function __toString(): string
            {
                return 'Stringable message';
            }
        };

        $htmlMessage = new HtmlMessage($stringableMessage);

        $this->assertSame($stringableMessage, $htmlMessage->message);
        $this->assertSame(MessageTypeEnum::NOTHING, $htmlMessage->getType());
    }

    /**
     * Test that __construct initializes correctly with a JsonSerializable input and a custom type.
     */
    public function testConstructWithJsonSerializableAndCustomType(): void
    {
        $jsonSerializableMessage = new class () implements JsonSerializable {
            public function jsonSerialize(): array
            {
                return ['message' => 'JsonSerializable message'];
            }
        };

        $htmlMessage = new HtmlMessage($jsonSerializableMessage, MessageTypeEnum::INFO);

        $this->assertSame($jsonSerializableMessage, $htmlMessage->message);
        $this->assertSame(MessageTypeEnum::INFO, $htmlMessage->getType());
    }

    /**
     * Test that __construct initializes correctly with a string input and a custom type.
     */
    public function testConstructWithStringAndCustomType(): void
    {
        $message     = 'This is a test string message';
        $htmlMessage = new HtmlMessage($message, MessageTypeEnum::SUCCESS);

        $this->assertSame($message, $htmlMessage->message);
        $this->assertSame(MessageTypeEnum::SUCCESS, $htmlMessage->getType());
    }

    /**
     * Test the info() method creates an HtmlMessage with the correct type and message.
     */
    public function testInfoCreatesHtmlMessageWithInfoType(): void
    {
        $message     = 'This is an info message';
        $htmlMessage = HtmlMessage::info($message);

        $this->assertInstanceOf(HtmlMessage::class, $htmlMessage);
        $this->assertSame($message, $htmlMessage->message);
        $this->assertSame(MessageTypeEnum::INFO, $htmlMessage->getType());
    }

    /**
     * Test the success() method creates an HtmlMessage with the correct type and message.
     */
    public function testSuccessCreatesHtmlMessageWithSuccessType(): void
    {
        $message     = 'This is a success message';
        $htmlMessage = HtmlMessage::success($message);

        $this->assertInstanceOf(HtmlMessage::class, $htmlMessage);
        $this->assertSame($message, $htmlMessage->message);
        $this->assertSame(MessageTypeEnum::SUCCESS, $htmlMessage->getType());
    }

    /**
     * Test the error() method creates an HtmlMessage with the correct type and message.
     */
    public function testErrorCreatesHtmlMessageWithErrorType(): void
    {
        $message     = 'This is an error message';
        $htmlMessage = HtmlMessage::error($message);

        $this->assertInstanceOf(HtmlMessage::class, $htmlMessage);
        $this->assertSame($message, $htmlMessage->message);
        $this->assertSame(MessageTypeEnum::ERROR, $htmlMessage->getType());
    }

    /**
     * Test the warn() method creates an HtmlMessage with the correct type and message.
     */
    public function testWarnCreatesHtmlMessageWithWarningType(): void
    {
        $message     = 'This is a warning message';
        $htmlMessage = HtmlMessage::warn($message);

        $this->assertInstanceOf(HtmlMessage::class, $htmlMessage);
        $this->assertSame($message, $htmlMessage->message);
        $this->assertSame(MessageTypeEnum::WARNING, $htmlMessage->getType());
    }
}
