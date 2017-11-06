<?php

namespace Tests\AppBundle\Folder;
use PHPUnit\Framework\TestCase;

class ExempleClassTest extends TestCase {
    
    public function testExemple() {
        $serializer = $this->getMockBuilder('JMS\Serializer\Serializer')->disableOriginalConstructor()->getMock();
            
        $classToTest = new ExempleClass($serializer);
    }
}
