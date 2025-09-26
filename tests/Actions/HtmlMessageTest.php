<?php

namespace ResponseActions\Tests\Actions;

use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\HtmlMessage;
use ResponseActions\Actions\MessageTypeEnum;

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
     * Test the info() method creates an HtmlMessage with the correct type and message.
     */
    public function testInfoCreatesHtmlMessageWithInfoType(): void
    {
        $message = 'This is an info message';
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
        $message = 'This is a success message';
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
        $message = 'This is an error message';
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
        $message = 'This is a warning message';
        $htmlMessage = HtmlMessage::warn($message);

        $this->assertInstanceOf(HtmlMessage::class, $htmlMessage);
        $this->assertSame($message, $htmlMessage->message);
        $this->assertSame(MessageTypeEnum::WARNING, $htmlMessage->getType());
    }
}