<?php

class AppAutoloader extends RfTestCase
{
    public function testAppAutoloader()
    {
        $result = \Rf\Hoge\Hage::doSomething();
        $this->assertEquals('hage', $result);
    }
}