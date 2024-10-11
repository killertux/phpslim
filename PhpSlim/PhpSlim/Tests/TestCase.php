<?php
abstract class PhpSlim_Tests_TestCase extends \PHPUnit\Framework\TestCase
{
    protected function assertErrorMessage($message, $result)
    {
        $this->assertStringContainsString(
            PhpSlim::EXCEPTION_TAG . 'message:<<' . $message . '>>', $result
        );
    }

    protected function assertErrorMessageOpenEnd($message, $result)
    {
        $this->assertStringContainsString(
            PhpSlim::EXCEPTION_TAG . 'message:<<' . $message, $result
        );
    }

    protected function assertStopTestMessage($message, $result)
    {
        $this->assertStringContainsString(
            PhpSlim::EXCEPTION_STOP_TEST_TAG .
            'message:<<' . $message . '>>', $result
        );
    }
}

