<?php

namespace ResponseActions\Tests;

use PHPUnit\Framework\TestCase;
use ResponseActions\StatusEnum;

/**
 * Test class for StatusEnum's jsonSerialize method.
 */
class StatusEnumTest extends TestCase
{
    /**
     * Test that jsonSerialize returns the correct value for SUCCESS.
     */
    public function testJsonSerializeReturnsSuccessValue()
    {
        $status = StatusEnum::SUCCESS;
        $this->assertSame('success', $status->jsonSerialize());
    }

    /**
     * Test that jsonSerialize returns the correct value for INFO.
     */
    public function testJsonSerializeReturnsInfoValue()
    {
        $status = StatusEnum::INFO;
        $this->assertSame('info', $status->jsonSerialize());
    }

    /**
     * Test that jsonSerialize returns the correct value for ERROR.
     */
    public function testJsonSerializeReturnsErrorValue()
    {
        $status = StatusEnum::ERROR;
        $this->assertSame('error', $status->jsonSerialize());
    }

    /**
     * Test that jsonSerialize returns the correct value for WARNING.
     */
    public function testJsonSerializeReturnsWarningValue()
    {
        $status = StatusEnum::WARNING;
        $this->assertSame('warning', $status->jsonSerialize());
    }

    /**
     * Test that jsonSerialize returns the correct value for NOTHING.
     */
    public function testJsonSerializeReturnsNothingValue()
    {
        $status = StatusEnum::NOTHING;
        $this->assertSame('', $status->jsonSerialize());
    }


/**
 * Test that isNothing returns true for the NOTHING status.
 */
    public function testIsNothingReturnsTrueForNothing()
    {
        $status = StatusEnum::NOTHING;
        $this->assertTrue($status->isNothing());
    }

    /**
     * Test that isSuccess returns true for the SUCCESS status.
     */
    public function testIsSuccessReturnsTrueForSuccessStatus()
    {
        $status = StatusEnum::SUCCESS;
        $this->assertTrue($status->isSuccess());
    }

    /**
     * Test that isSuccess returns false for other statuses.
     */
    public function testIsSuccessReturnsFalseForOtherStatuses()
    {
        $statuses = [
            StatusEnum::INFO,
            StatusEnum::ERROR,
            StatusEnum::WARNING,
            StatusEnum::NOTHING,
        ];

        foreach ($statuses as $status) {
            $this->assertFalse($status->isSuccess());
        }
    }

    /**
     * Test that isError returns true for the ERROR status.
     */
    public function testIsErrorReturnsTrueForErrorStatus()
    {
        $status = StatusEnum::ERROR;
        $this->assertTrue($status->isError());
    }

    /**
     * Test that isInfo returns true for the INFO status.
     */
    public function testIsInfoReturnsTrueForInfoStatus()
    {
        $status = StatusEnum::INFO;
        $this->assertTrue($status->isInfo());
    }

    /**
     * Test that isInfo returns false for other statuses.
     */
    public function testIsInfoReturnsFalseForOtherStatuses()
    {
        $statuses = [
            StatusEnum::SUCCESS,
            StatusEnum::ERROR,
            StatusEnum::WARNING,
            StatusEnum::NOTHING,
        ];

        foreach ($statuses as $status) {
            $this->assertFalse($status->isInfo());
        }
    }

    /**
     * Test that isError returns false for other statuses.
     */
    public function testIsErrorReturnsFalseForOtherStatuses()
    {
        $statuses = [
            StatusEnum::SUCCESS,
            StatusEnum::INFO,
            StatusEnum::WARNING,
            StatusEnum::NOTHING,
        ];

        foreach ($statuses as $status) {
            $this->assertFalse($status->isError());
        }
    }

    /**
     * Test that isWarning returns true for the WARNING status.
     */
    public function testIsWarningReturnsTrueForWarningStatus()
    {
        $status = StatusEnum::WARNING;
        $this->assertTrue($status->isWarning());
    }

    /**
     * Test that isWarning returns false for other statuses.
     */
    public function testIsWarningReturnsFalseForOtherStatuses()
    {
        $statuses = [
            StatusEnum::SUCCESS,
            StatusEnum::INFO,
            StatusEnum::ERROR,
            StatusEnum::NOTHING,
        ];

        foreach ($statuses as $status) {
            $this->assertFalse($status->isWarning());
        }
    }

    /**
 * Test that isNothing returns false for other statuses.
 */
    public function testIsNothingReturnsFalseForOtherStatuses()
    {
        $statuses = [
        StatusEnum::SUCCESS,
        StatusEnum::INFO,
        StatusEnum::ERROR,
        StatusEnum::WARNING,
        ];

        foreach ($statuses as $status) {
            $this->assertFalse($status->isNothing());
        }
    }
}
