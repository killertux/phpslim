<?php
class PhpSlim_Tests_StatementExecutorTest extends PhpSlim_Tests_TestCase
{
    private $_executor;

    public function setUp(): void
    {
        $this->_executor = new PhpSlim_StatementExecutor();
    }

    public function testRequireAClass()
    {
        $this->_executor->addModule('MyModule');
        try {
            $this->_executor->requireClass('MyModule_MyClass');
            $this->fail();
        } catch (PhpSlim_SlimError $exception) {
            $message = 'COULD_NOT_INVOKE_CONSTRUCTOR MyModule_MyClass[0]';
            $errorMessage = PhpSlim::tagErrorMessage($exception->getMessage());
            $this->assertErrorMessage($message, $errorMessage);
        }
    }

    public function testRequireAnExistingClass()
    {
        $this->_executor->addModule('TestModule');
        $class = $this->_executor->requireClass('TestSlim');
        $this->assertEquals('TestModule_TestSlim', $class);
    }

    public function testRequireAnExistingClassWithoutModule()
    {
        $class = $this->_executor->requireClass('TestModule_TestSlim');
        $this->assertEquals('TestModule_TestSlim', $class);
    }

    public function testRequireANonExistingClassWithoutModule()
    {
        $this->expectException(PhpSlim_SlimError::class);
        $this->expectExceptionMessage("message:<<COULD_NOT_INVOKE_CONSTRUCTOR TestSlim[0]>>");
        $this->_executor->requireClass('TestSlim');
    }
}
