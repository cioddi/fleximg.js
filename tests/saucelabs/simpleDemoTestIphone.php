<?php

require_once 'vendor/autoload.php';

class simpleDemoTest extends Sauce\Sausage\WebDriverTestCase
{
    protected $base_url = 'http://127.0.0.1/';
    protected $build = '';

    public static $browsers = array(
        array(
            'browserName' => 'iphone',
            'desiredCapabilities' => array(
                'version' => '6.0',
                'platform' => 'OS X 10.8'
            )
        )
        ,array(
            'browserName' => 'iphone',
            'desiredCapabilities' => array(
                'version' => '5.1',
                'platform' => 'OS X 10.8'
            )
        )
    );

    public function setUpPage()
    {
        $this->setBuild(getenv('TRAVIS_BUILD_NUMBER'));
        echo 'TRAVIS_BUILD_NUMBER';
        echo $this->build = getenv('TRAVIS_BUILD_NUMBER');

        $this->url('http://127.0.0.1/demos/saucelabs.php');
    }

    public function testInitialSrcSetting()
    {
        $this->assertContains('/fleximg_scale/',$this->byCss('.img_1')->attribute('src'));

    }


    public function testReSrcSetting()
    {

        $this->byCss('#set_width_500')->click();
        sleep(2);
        $this->assertContains('/800/',$this->byCss('.img_1')->attribute('src'));

    }
}
