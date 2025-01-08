<?php

class MiddlewareSetup extends RfTestCase
{
    public function testSetup()
    {
        $result = \Rfmw\Hoge\Hage::doSomething();
        $this->assertEquals('hage', $result);
    }
}