<?php

namespace ResponseActions\Tests\Actions;

use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\Command;
use ResponseActions\Actions\CommandStatus;

class CommandTest extends TestCase
{
    /**
     * Tests the 'done' method when a description is provided.
     */
    public function testDoneWithDescription(): void
    {
        $description = 'Task completed successfully';
        $command = new Command();
        $command->done($description);

        $this->assertEquals(CommandStatus::Done, $this->getStatus($command));
        $this->assertEquals($description, $this->getDescription($command));
    }

    /**
     * Tests the 'failed' method when a description is provided.
     */
    public function testFailedWithDescription(): void
    {
        $description = 'Task failed due to error';
        $command = new Command();
        $command->failed($description);

        $this->assertEquals(CommandStatus::Failed, $this->getStatus($command));
        $this->assertEquals($description, $this->getDescription($command));
    }

    /**
     * Tests the 'done' method when no description is provided.
     */
    public function testDoneWithoutDescription(): void
    {
        $command = new Command();
        $command->done();

        $this->assertEquals(CommandStatus::Done, $this->getStatus($command));
        $this->assertNull($this->getDescription($command));
    }

    /**
     * Tests the 'failed' method when no description is provided.
     */
    public function testFailedWithoutDescription(): void
    {
        $command = new Command();
        $command->failed();

        $this->assertEquals(CommandStatus::Failed, $this->getStatus($command));
        $this->assertNull($this->getDescription($command));
    }

    /**
     * Tests the 'setStatus' method to set the status to 'Done'.
     */
    public function testSetStatusToDone(): void
    {
        $command = new Command();
        $reflection = new \ReflectionMethod($command, 'setStatus');
        $reflection->setAccessible(true);
        $reflection->invoke($command, CommandStatus::Done);

        $this->assertEquals(CommandStatus::Done, $this->getStatus($command));
    }

    /**
     * Tests the 'setStatus' method to set the status to 'Failed'.
     */
    public function testSetStatusToFailed(): void
    {
        $command = new Command();
        $reflection = new \ReflectionMethod($command, 'setStatus');
        $reflection->setAccessible(true);
        $reflection->invoke($command, CommandStatus::Failed);

        $this->assertEquals(CommandStatus::Failed, $this->getStatus($command));
    }

    /**
     * Tests the 'setStatus' method to set the status to 'Pending'.
     */
    public function testSetStatusToPending(): void
    {
        $command = new Command();
        $reflection = new \ReflectionMethod($command, 'setStatus');
        $reflection->setAccessible(true);
        $reflection->invoke($command, CommandStatus::Pending);

        $this->assertEquals(CommandStatus::Pending, $this->getStatus($command));
    }

    /**
     * Tests the 'setDescription' method by setting a non-null value.
     */
    public function testSetDescriptionWithValue(): void
    {
        $description = 'This is a test description';
        $command = new Command();
        $command->setDescription($description);

        $this->assertEquals($description, $this->getDescription($command));
    }

    /**
     * Tests the 'setDescription' method by setting a null value.
     */
    public function testSetDescriptionToNull(): void
    {
        $command = new Command();
        $command->setDescription(null);

        $this->assertNull($this->getDescription($command));
    }

    /**
     * Helper method to get the private 'status' property of the Command.
     */
    private function getStatus(Command $command): CommandStatus
    {
        $reflection = new \ReflectionClass($command);
        $property = $reflection->getProperty('status');
        $property->setAccessible(true);

        return $property->getValue($command);
    }

    /**
     * Helper method to get the private 'description' property of the Command.
     */
    private function getDescription(Command $command): ?string
    {
        $reflection = new \ReflectionClass($command);
        $property = $reflection->getProperty('description');
        $property->setAccessible(true);

        return $property->getValue($command);
    }

    /**
     * Tests the 'makeDone' method when a description is provided.
     */
    public function testMakeDoneWithDescription(): void
    {
        $description = 'Completed successfully using makeDone';
        $command = Command::makeDone($description);

        $this->assertEquals(CommandStatus::Done, $this->getStatus($command));
        $this->assertEquals($description, $this->getDescription($command));
    }

    /**
     * Tests the 'isFailed' method returns true when the status is Failed.
     */
    public function testIsFailedWhenTrue(): void
    {
        $command = new Command(CommandStatus::Failed);

        $this->assertTrue($command->isFailed());
    }

    /**
     * Tests the 'isFailed' method returns false when the status is not Failed.
     */
    public function testIsFailedWhenFalse(): void
    {
        $command = new Command(CommandStatus::Done);

        $this->assertFalse($command->isFailed());
    }

    /**
     * Tests the 'makeDone' method when no description is provided.
     */
    public function testMakeDoneWithoutDescription(): void
    {
        $command = Command::makeDone();

        $this->assertEquals(CommandStatus::Done, $this->getStatus($command));
        $this->assertNull($this->getDescription($command));
    }

    /**
     * Tests the 'pending' method when a description is provided.
     */
    public function testPendingWithDescription(): void
    {
        $description = 'Task is pending execution';
        $command = Command::pending($description);

        $this->assertEquals(CommandStatus::Pending, $this->getStatus($command));
        $this->assertEquals($description, $this->getDescription($command));
    }

    /**
     * Tests the 'pending' method when no description is provided.
     */
    public function testPendingWithoutDescription(): void
    {
        $command = Command::pending();

        $this->assertEquals(CommandStatus::Pending, $this->getStatus($command));
        $this->assertNull($this->getDescription($command));
    }
}