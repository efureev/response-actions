<?php

namespace ResponseActions\Tests;

use PHPUnit\Framework\Attributes\Test;
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
    #[Test]
    public function jsonSerializeReturnsSuccessValue()
    {
        $status = StatusEnum::SUCCESS;
        $this->assertSame('success', $status->jsonSerialize());
    }

    /**
     * Test that jsonSerialize returns the correct value for INFO.
     */
    #[Test]
    public function jsonSerializeReturnsInfoValue()
    {
        $status = StatusEnum::INFO;
        $this->assertSame('info', $status->jsonSerialize());
    }

    /**
     * Test that jsonSerialize returns the correct value for ERROR.
     */
    #[Test]
    public function jsonSerializeReturnsErrorValue()
    {
        $status = StatusEnum::ERROR;
        $this->assertSame('error', $status->jsonSerialize());
    }

    /**
     * Test that jsonSerialize returns the correct value for WARNING.
     */
    #[Test]
    public function jsonSerializeReturnsWarningValue()
    {
        $status = StatusEnum::WARNING;
        $this->assertSame('warning', $status->jsonSerialize());
    }

    /**
     * Test that jsonSerialize returns the correct value for NOTHING.
     */
    #[Test]
    public function jsonSerializeReturnsNothingValue()
    {
        $status = StatusEnum::NOTHING;
        $this->assertSame('', $status->jsonSerialize());
    }


    /**
     * Test that isNothing returns true for the NOTHING status.
     */
    #[Test]
    public function isNothingReturnsTrueForNothing()
    {
        $status = StatusEnum::NOTHING;
        $this->assertTrue($status->isNothing());
    }

    /**
     * Test that isSuccess returns true for the SUCCESS status.
     */
    #[Test]
    public function isSuccessReturnsTrueForSuccessStatus()
    {
        $status = StatusEnum::SUCCESS;
        $this->assertTrue($status->isSuccess());
    }

    /**
     * Test that isSuccess returns false for other statuses.
     */
    #[Test]
    public function isSuccessReturnsFalseForOtherStatuses()
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
    #[Test]
    public function isErrorReturnsTrueForErrorStatus()
    {
        $status = StatusEnum::ERROR;
        $this->assertTrue($status->isError());
    }

    /**
     * Test that isInfo returns true for the INFO status.
     */
    #[Test]
    public function isInfoReturnsTrueForInfoStatus()
    {
        $status = StatusEnum::INFO;
        $this->assertTrue($status->isInfo());
    }

    /**
     * Test that isInfo returns false for other statuses.
     */
    #[Test]
    public function isInfoReturnsFalseForOtherStatuses()
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
    #[Test]
    public function isErrorReturnsFalseForOtherStatuses()
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
    #[Test]
    public function isWarningReturnsTrueForWarningStatus()
    {
        $status = StatusEnum::WARNING;
        $this->assertTrue($status->isWarning());
    }

    /**
     * Test that isWarning returns false for other statuses.
     */
    #[Test]
    public function isWarningReturnsFalseForOtherStatuses()
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
    #[Test]
    public function isNothingReturnsFalseForOtherStatuses()
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
