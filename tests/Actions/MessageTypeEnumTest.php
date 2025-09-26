<?php

namespace ResponseActions\Tests\Actions;

use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\MessageTypeEnum;

/**
 * Test class for MessageTypeEnum's methods, including jsonSerialize, isNothing, and isWarning.
 */
class MessageTypeEnumTest extends TestCase
{
    /**
     * Test that jsonSerialize returns the correct value for the SUCCESS case.
     */
    public function testJsonSerializeReturnsSuccessValue(): void
    {
        $enum = MessageTypeEnum::SUCCESS;
        $this->assertSame('success', $enum->jsonSerialize());
    }

    /**
     * Test that isNothing returns true for the NOTHING case.
     */
    public function testIsNothingReturnsTrueForNothing(): void
    {
        $enum = MessageTypeEnum::NOTHING;
        $this->assertTrue($enum->isNothing());
    }

    /**
     * Test that isNothing returns false for all other cases.
     */
    public function testIsNothingReturnsFalseForOtherCases(): void
    {
        $this->assertFalse(MessageTypeEnum::SUCCESS->isNothing());
        $this->assertFalse(MessageTypeEnum::INFO->isNothing());
        $this->assertFalse(MessageTypeEnum::ERROR->isNothing());
        $this->assertFalse(MessageTypeEnum::WARNING->isNothing());
    }

    /**
     * Test that jsonSerialize returns the correct value for the INFO case.
     */
    public function testJsonSerializeReturnsInfoValue(): void
    {
        $enum = MessageTypeEnum::INFO;
        $this->assertSame('info', $enum->jsonSerialize());
    }

    /**
     * Test that jsonSerialize returns the correct value for the ERROR case.
     */
    public function testJsonSerializeReturnsErrorValue(): void
    {
        $enum = MessageTypeEnum::ERROR;
        $this->assertSame('error', $enum->jsonSerialize());
    }

    /**
     * Test that jsonSerialize returns the correct value for the WARNING case.
     */
    public function testJsonSerializeReturnsWarningValue(): void
    {
        $enum = MessageTypeEnum::WARNING;
        $this->assertSame('warning', $enum->jsonSerialize());
    }

    /**
     * Test that jsonSerialize returns the correct value for the NOTHING case.
     */
    public function testJsonSerializeReturnsNothingValue(): void
    {
        $enum = MessageTypeEnum::NOTHING;
        $this->assertSame('', $enum->jsonSerialize());
    }

    /**
     * Test that isWarning returns true for the WARNING case.
     */
    public function testIsWarningReturnsTrueForWarning(): void
    {
        $enum = MessageTypeEnum::WARNING;
        $this->assertTrue($enum->isWarning());
    }

    /**
     * Test that isSuccess returns true for the SUCCESS case.
     */
    public function testIsSuccessReturnsTrueForSuccess(): void
    {
        $enum = MessageTypeEnum::SUCCESS;
        $this->assertTrue($enum->isSuccess());
    }

    /**
     * Test that isSuccess returns false for all other cases.
     */
    public function testIsSuccessReturnsFalseForOtherCases(): void
    {
        $this->assertFalse(MessageTypeEnum::INFO->isSuccess());
        $this->assertFalse(MessageTypeEnum::ERROR->isSuccess());
        $this->assertFalse(MessageTypeEnum::WARNING->isSuccess());
        $this->assertFalse(MessageTypeEnum::NOTHING->isSuccess());
    }

    /**
     * Test that isWarning returns false for all other cases.
     */
    public function testIsWarningReturnsFalseForOtherCases(): void
    {
        $this->assertFalse(MessageTypeEnum::SUCCESS->isWarning());
        $this->assertFalse(MessageTypeEnum::INFO->isWarning());
        $this->assertFalse(MessageTypeEnum::ERROR->isWarning());
        $this->assertFalse(MessageTypeEnum::NOTHING->isWarning());
    }

    /**
     * Test that isInfo returns true for the INFO case.
     */
    public function testIsInfoReturnsTrueForInfo(): void
    {
        $enum = MessageTypeEnum::INFO;
        $this->assertTrue($enum->isInfo());
    }

    /**
     * Test that the is method returns true for the matching case.
     */
    public function testIsReturnsTrueForMatchingCase(): void
    {
        $this->assertTrue(MessageTypeEnum::SUCCESS->is(MessageTypeEnum::SUCCESS));
        $this->assertTrue(MessageTypeEnum::INFO->is(MessageTypeEnum::INFO));
        $this->assertTrue(MessageTypeEnum::ERROR->is(MessageTypeEnum::ERROR));
        $this->assertTrue(MessageTypeEnum::WARNING->is(MessageTypeEnum::WARNING));
        $this->assertTrue(MessageTypeEnum::NOTHING->is(MessageTypeEnum::NOTHING));
    }

    /**
     * Test that the is method returns false for different cases.
     */
    public function testIsReturnsFalseForDifferentCases(): void
    {
        $this->assertFalse(MessageTypeEnum::SUCCESS->is(MessageTypeEnum::INFO));
        $this->assertFalse(MessageTypeEnum::SUCCESS->is(MessageTypeEnum::ERROR));
        $this->assertFalse(MessageTypeEnum::SUCCESS->is(MessageTypeEnum::WARNING));
        $this->assertFalse(MessageTypeEnum::SUCCESS->is(MessageTypeEnum::NOTHING));

        $this->assertFalse(MessageTypeEnum::INFO->is(MessageTypeEnum::SUCCESS));
        $this->assertFalse(MessageTypeEnum::INFO->is(MessageTypeEnum::ERROR));
        $this->assertFalse(MessageTypeEnum::INFO->is(MessageTypeEnum::WARNING));
        $this->assertFalse(MessageTypeEnum::INFO->is(MessageTypeEnum::NOTHING));

        $this->assertFalse(MessageTypeEnum::ERROR->is(MessageTypeEnum::SUCCESS));
        $this->assertFalse(MessageTypeEnum::ERROR->is(MessageTypeEnum::INFO));
        $this->assertFalse(MessageTypeEnum::ERROR->is(MessageTypeEnum::WARNING));
        $this->assertFalse(MessageTypeEnum::ERROR->is(MessageTypeEnum::NOTHING));

        $this->assertFalse(MessageTypeEnum::WARNING->is(MessageTypeEnum::SUCCESS));
        $this->assertFalse(MessageTypeEnum::WARNING->is(MessageTypeEnum::INFO));
        $this->assertFalse(MessageTypeEnum::WARNING->is(MessageTypeEnum::ERROR));
        $this->assertFalse(MessageTypeEnum::WARNING->is(MessageTypeEnum::NOTHING));

        $this->assertFalse(MessageTypeEnum::NOTHING->is(MessageTypeEnum::SUCCESS));
        $this->assertFalse(MessageTypeEnum::NOTHING->is(MessageTypeEnum::INFO));
        $this->assertFalse(MessageTypeEnum::NOTHING->is(MessageTypeEnum::ERROR));
        $this->assertFalse(MessageTypeEnum::NOTHING->is(MessageTypeEnum::WARNING));
    }

    /**
     * Test that isInfo returns false for all other cases.
     */
    public function testIsInfoReturnsFalseForOtherCases(): void
    {
        $this->assertFalse(MessageTypeEnum::SUCCESS->isInfo());
        $this->assertFalse(MessageTypeEnum::ERROR->isInfo());
        $this->assertFalse(MessageTypeEnum::WARNING->isInfo());
        $this->assertFalse(MessageTypeEnum::NOTHING->isInfo());
    }

    /**
     * Test that isError returns true for the ERROR case.
     */
    public function testIsErrorReturnsTrueForError(): void
    {
        $enum = MessageTypeEnum::ERROR;
        $this->assertTrue($enum->isError());
    }

    /**
     * Test that isError returns false for all other cases.
     */
    public function testIsErrorReturnsFalseForOtherCases(): void
    {
        $this->assertFalse(MessageTypeEnum::SUCCESS->isError());
        $this->assertFalse(MessageTypeEnum::INFO->isError());
        $this->assertFalse(MessageTypeEnum::WARNING->isError());
        $this->assertFalse(MessageTypeEnum::NOTHING->isError());
    }
}