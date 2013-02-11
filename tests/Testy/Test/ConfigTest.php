<?php
/**
 * Test class for Config.
 * Generated by PHPUnit on 2011-12-10 at 20:00:10.
 */
namespace Testy\Test;

class ConfigTest extends \PHPUnit_Framework_TestCase {

    /**
     * The test-object
     *
     * @var \Testy\Config
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp() {
        $this->_object = new \Testy\Config('testy.json.dist');
    }

    /**
     * Test config-creation
     */
    public function testGet() {
        $oConfig = $this->_object->get();
        $this->assertInstanceOf('\\stdClass', $oConfig);
    }

    /**
     * Test the update-check
     */
    public function testWasUpdated() {
        $this->_object->get();
        $this->assertTrue($this->_object->wasUpdated());

        $this->_object->get();
        $this->assertFalse($this->_object->wasUpdated());
    }

    /**
     * Test that a exception is thrown, if an error occurs
     */
    public function testException() {
        try {
            new \Testy\Config();
            $this->fail('An exception should be raised, when creating a config-builder without file');
        }
        catch(\Exception $e) {
            $this->assertEquals($e->getMessage(), \Testy\Config::ERROR);
        }
    }
}