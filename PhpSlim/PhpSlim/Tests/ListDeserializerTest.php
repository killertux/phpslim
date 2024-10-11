<?php
class PhpSlim_Tests_ListDeserializerTest extends PhpSlim_Tests_TestCase
{
    private $_list;

    public function setUp(): void
    {
        $this->_list = array();
    }

    public function testMbSubstr()
    {
        $this->assertEquals('gä', mb_substr('jürgän', 3, 2));
    }

    public function testMbCanBeConcatenated()
    {
        $string = 'ä';
        $this->assertEquals(2, strlen($string));
        $this->assertEquals(1, mb_strlen($string));
        $concat = substr($string, 0, 1) . substr($string, 1, 1);
        $this->assertSame($string, $concat);
    }

    public function testExceptionDeserializeNullString()
    {
        $this->expectException(PhpSlim_ListDeserializer_SyntaxError::class);
        $this->expectExceptionMessage("Can't deserialize null");
        $this->deserialize(null);
    }

    public function testExceptionDeserializeEmptyString()
    {
        $this->expectException(PhpSlim_ListDeserializer_SyntaxError::class);
        $this->expectExceptionMessage("Can't deserialize empty string");
        $this->deserialize('');
    }

    public function testExceptionDeserializeStringThatDoesNotStartWithABracket()
    {
        $this->expectException(PhpSlim_ListDeserializer_SyntaxError::class);
        $this->expectExceptionMessage("Serialized list has no starting [");
        $this->deserialize('hello');
    }

    public function testExceptionDeserializeStringThatDoesNotEndWithABracket()
    {
        $this->expectException(PhpSlim_ListDeserializer_SyntaxError::class);
        $this->expectExceptionMessage("Serialized list has no ending ]");
        $this->deserialize('[000000:');
    }

    public function testStringWithLengthWithMoreThanSizCharacters()
    {
        $this->assertEquals(['ola'], $this->deserialize('[000001:0000000003:ola]'));
    }

    public function testDeserializeAnEmptyList()
    {
        $this->check();
    }

    public function testDeserializeAListWithOneInteger()
    {
        $this->_list = array(1);
        $this->check();
    }

    public function testDeserializeAListWithBrackets()
    {
        $this->_list = array('[1]');
        $this->check();
    }

    public function testDeserializeAListWithColon()
    {
        $this->_list = array('a:b');
        $this->check();
    }

    public function testDeserializeAListWithOneElement()
    {
        $this->_list = array('hello');
        $this->check();
    }

    public function testDeserializeAListWithTwoElements()
    {
        $this->_list = array('hello', 'bob');
        $this->check();
    }

    public function testDeserializeAListWithMultiByteCharacters()
    {
        $this->_list = array('tschüß', array('bob', 'micah'), 'today');
        $this->check();
    }

    public function testDeserializeSublists()
    {
        $this->_list = array('hello', array('bob', 'micah'), 'today');
        $this->check();
    }

    public function testDeserializeListsWithAMultibyteString()
    {
        $this->_list = array('Köln');
        $this->check();
    }

    public function testDeserializeListsOfStringsThatEndWithAMultibyteString()
    {
        $this->_list = array('Kö');
        $this->check();
    }

    private function check()
    {
        $serialized = $this->serialize($this->_list);
        $deserialized = $this->deserialize($serialized);
        $this->assertEquals($this->_list, $deserialized);
    }

    private function deserialize($string)
    {
        return PhpSlim_ListDeserializer::deserialize($string);
    }

    private function serialize(array $list)
    {
        return PhpSlim_ListSerializer::serialize($list);
    }
}
