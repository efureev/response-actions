<?php

namespace ResponseActions\Tests\Actions;

use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\Message;
use ResponseActions\Actions\MessageTypeEnum;

class MessageTest extends TestCase
{
    /**
     * Tests that toActionArray returns an array with only the message
     * when the type is NOTHING and there are no extra fields.
     */
    public function testToActionArrayWithoutTypeAndExtra(): void
    {
        $message = new Message("Test message", MessageTypeEnum::NOTHING);

        $result = $this->invokeToActionArray($message);

        $expected = [
            'message' => 'Test message',
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests that toActionArray includes the 'type' key when the type is not NOTHING.
     */
    public function testToActionArrayWithType(): void
    {
        $message = new Message("Test message", MessageTypeEnum::SUCCESS);

        $result = $this->invokeToActionArray($message);

        $expected = [
            'message' => 'Test message',
            'type' => MessageTypeEnum::SUCCESS,
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests that toActionArray includes the 'extra' key when extra fields are added.
     */
    public function testToActionArrayWithExtra(): void
    {
        $message = new Message("Test message", MessageTypeEnum::NOTHING);
        $message->withExtra(['key1' => 'value1', 'key2' => 'value2']);

        $result = $this->invokeToActionArray($message);

        $expected = [
            'message' => 'Test message',
            'extra' => [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
        ];

        $this->assertEquals($expected, $result);
        $this->assertEquals('message', (string)$message);
    }

    /**
     * Tests that toActionArray includes both 'type' and 'extra' keys when present.
     */
    public function testToActionArrayWithTypeAndExtra(): void
    {
        $message = new Message("Test message", MessageTypeEnum::INFO);
        $message->withExtra(['key1' => 'value1']);

        $result = $this->invokeToActionArray($message);

        $expected = [
            'message' => 'Test message',
            'type' => MessageTypeEnum::INFO,
            'extra' => [
                'key1' => 'value1',
            ],
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests that the error method creates a Message with the ERROR type.
     */
    public function testErrorCreatesErrorMessageType(): void
    {
        $message = Message::error('This is an error message');

        $result = $this->invokeToActionArray($message);

        $expected = [
            'message' => 'This is an error message',
            'type' => MessageTypeEnum::ERROR,
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests that the warn method creates a Message with the WARNING type.
     */
    public function testWarnCreatesWarningMessageType(): void
    {
        $message = Message::warn('This is a warning message');

        $result = $this->invokeToActionArray($message);

        $expected = [
            'message' => 'This is a warning message',
            'type' => MessageTypeEnum::WARNING,
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests that toActionArray returns an empty extra field when no extra fields exist.
     */
    public function testToActionArrayWithNoExtra(): void
    {
        $message = new Message("Test message", MessageTypeEnum::ERROR);

        $result = $this->invokeToActionArray($message);

        $expected = [
            'message' => 'Test message',
            'type' => MessageTypeEnum::ERROR,
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Helper function to invoke the protected toActionArray method.
     */
    private function invokeToActionArray(Message $message): array
    {
        $reflection = new \ReflectionClass($message);
        $method = $reflection->getMethod('toActionArray');
        $method->setAccessible(true);
        return $method->invoke($message);
    }

    /**
     * Tests that setType updates the message type successfully.
     */
    public function testSetTypeUpdatesTheMessageType(): void
    {
        $message = new Message("Test message", MessageTypeEnum::NOTHING);

        $message->setType(MessageTypeEnum::SUCCESS);

        $this->assertEquals(MessageTypeEnum::SUCCESS, $message->getType());
    }

    /**
     * Tests that setType correctly updates the message type to various MessageTypeEnum values.
     */
    public function testSetTypeWithDifferentValues(): void
    {
        $message = new Message("Test message", MessageTypeEnum::NOTHING);

        $message->setType(MessageTypeEnum::WARNING);
        $this->assertEquals(MessageTypeEnum::WARNING, $message->getType());

        $message->setType(MessageTypeEnum::INFO);
        $this->assertEquals(MessageTypeEnum::INFO, $message->getType());

        $message->setType(MessageTypeEnum::ERROR);
        $this->assertEquals(MessageTypeEnum::ERROR, $message->getType());
    }
}
