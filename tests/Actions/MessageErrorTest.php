<?php

namespace ResponseActions\Tests\Actions;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\MessageError;

class MessageErrorTest extends TestCase
{
    /**
     * Tests the `hasNoCode` method when the code is a null value.
     */
    #[Test]
    public function hasNoCodeReturnsTrueWhenCodeIsNull(): void
    {
        $messageError = new MessageError("Test message", null);
        $reflection   = new \ReflectionClass($messageError);
        $method       = $reflection->getMethod('hasNoCode');
        $method->setAccessible(true);

        $this->assertTrue($method->invoke($messageError));
    }

    /**
     * Tests the `hasNoCode` method when the code is an empty string.
     */
    #[Test]
    public function hasNoCodeReturnsTrueWhenCodeIsEmptyString(): void
    {
        $messageError = new MessageError("Test message", "");
        $reflection   = new \ReflectionClass($messageError);
        $method       = $reflection->getMethod('hasNoCode');
        $method->setAccessible(true);

        $this->assertTrue($method->invoke($messageError));
    }

    /**
     * Tests the `hasNoCode` method when the code is an empty integer (0).
     */
    #[Test]
    public function hasNoCodeReturnsTrueWhenCodeIsEmptyInteger(): void
    {
        $messageError = new MessageError("Test message", 0);
        $reflection   = new \ReflectionClass($messageError);
        $method       = $reflection->getMethod('hasNoCode');
        $method->setAccessible(true);

        $this->assertTrue($method->invoke($messageError));
    }

    /**
     * Tests the `hasNoCode` method when the code is a non-empty string.
     */
    #[Test]
    public function hasNoCodeReturnsFalseWhenCodeIsNonEmptyString(): void
    {
        $messageError = new MessageError("Test message", "error_code");
        $reflection   = new \ReflectionClass($messageError);
        $method       = $reflection->getMethod('hasNoCode');
        $method->setAccessible(true);

        $this->assertFalse($method->invoke($messageError));
    }

    /**
     * Tests the `hasNoCode` method when the code is a non-empty integer.
     */
    #[Test]
    public function hasNoCodeReturnsFalseWhenCodeIsNonEmptyInteger(): void
    {
        $messageError = new MessageError("Test message", 123);
        $reflection   = new \ReflectionClass($messageError);
        $method       = $reflection->getMethod('hasNoCode');
        $method->setAccessible(true);

        $this->assertFalse($method->invoke($messageError));
    }
}
