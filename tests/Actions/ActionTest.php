<?php

namespace ResponseActions\Tests\Actions;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\Action;

class ActionTest extends TestCase
{
    /**
     * Tests that the name method in Action returns the expected string.
     */
    #[Test]
    public function nameReturnsExpectedValue()
    {
        $expectedName = 'TestAction';

        // Mock the Action interface
        $mockAction = $this->createMock(Action::class);
        $mockAction->method('name')->willReturn($expectedName);

        $this->assertSame($expectedName, $mockAction->name());
    }
}
