<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
 
class FleximgTest extends PHPUnit_Extensions_SeleniumTestCase
{
    protected function setUp()
    {
        $this->setBrowser('*firefox');
        $this->setBrowserUrl('http://127.0.0.1/');
    }
 
    public function testLoadPage()
    {
        $this->open('http://127.0.0.1/tests/testpage.html');

        $this->waitForPageToLoad ( "30000" );

        $this->assertTitle('Fleximg.js Testpage');
    }

    /**
     * @depends testLoadPage
     */
    public function testFileCreation()
    {
        cmd('sudo chmod -R 777 img/fleximg_scale');
        $this->assertTrue(file_exists('img/fleximg_scale/300/0/img/test.jpg'));
    }

    public function testFileSize()
    {

        
        $this->assertTrue(($image->getImageWidth() == 300));
    }
}
?>