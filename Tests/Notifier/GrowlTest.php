<?php

/**
 * Test class for Testy_Notifier_Growl.
 * Generated by PHPUnit on 2011-10-22 at 23:00:50.
 */
class Testy_Notifier_GrowlTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Testy_Notifier_Growl
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp() {
        $this->_object = new Testy_Notifier_Growl();
    }

    /**
     * Test simple notify
     */
    public function testNotify() {
        $this->assertInstanceOf('Testy_AbstractNotifier', $this->_object->notify($this->getMock('Testy_Project'), Testy_AbstractNotifier::SUCCESS, ''));
    }

    /**
     * Test text formatting
     */
    public function testformatMessage() {
        $this->assertEquals(Testy_AbstractNotifier::SUCCESS, $this->_object->formatMessage(Testy_AbstractNotifier::SUCCESS));

        $sTest = implode(array_fill(0, 1024, 'A'));
        $this->assertEquals(256, strlen($this->_object->formatMessage($sTest)));

        //$sTest = 'Test \033[32mdone\033[0m Test \033[32;12mdone\033[0m';
        //$this->assertEquals('Test done Test done', $this->_object->formatMessage($sTest));
    }
}
