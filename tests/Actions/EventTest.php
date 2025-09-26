<?php

namespace ResponseActions\Tests\Actions;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\Event;

class EventTest extends TestCase
{
    /**
     * Test that toActionArray() correctly returns the event name and parameters.
     */
    #[Test]
    public function toActionArrayReturnsCorrectStructure(): void
    {
        $eventName = 'user.login';
        $params    = [
            'userId'    => 42,
            'timestamp' => '2025-09-26T10:00:00Z',
        ];

        $event = new Event($eventName, $params);

        $expected = [
            'event'  => $eventName,
            'params' => $params,
        ];

        $this->assertSame($expected, $this->invokeToActionArray($event));
        $this->assertEquals('event', (string)$event);
    }

    /**
     * Test that toActionArray() correctly handles empty parameters.
     */
    #[Test]
    public function toActionArrayHandlesEmptyParameters(): void
    {
        $eventName = 'user.logout';

        $event = new Event($eventName);

        $expected = [
            'event'  => $eventName,
            'params' => [],
        ];

        $this->assertSame($expected, $this->invokeToActionArray($event));
    }

    /**
     * Helper method to invoke the protected toActionArray() method.
     */
    private function invokeToActionArray(Event $event): array
    {
        $reflection = new \ReflectionClass($event);
        $method     = $reflection->getMethod('toActionArray');
        $method->setAccessible(true);

        return $method->invoke($event);
    }
}
