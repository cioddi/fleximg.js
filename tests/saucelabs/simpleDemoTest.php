<?php

require_once 'vendor/autoload.php';

define("TRAVIS_BUILD_NUMBER", getenv('TRAVIS_BUILD_NUMBER'));

class simpleDemoTest extends Sauce\Sausage\WebDriverTestCase
{
    protected $base_url = 'http://127.0.0.1/';
    protected $build = TRAVIS_BUILD_NUMBER;

    public static $browsers = array(
        // array(
        //     'browserName' => 'iphone',
        //     'desiredCapabilities' => array(
        //         'version' => '6.0',
        //         'platform' => 'OS X 10.8'
        //     )
        // )
        // ,array(
        //     'browserName' => 'iphone',
        //     'desiredCapabilities' => array(
        //         'version' => '5.1',
        //         'platform' => 'OS X 10.8'
        //     )
        // ),
        array(
            'browserName' => 'ipad',
            'desiredCapabilities' => array(
                'version' => '6.0',
                'platform' => 'OS X 10.8'
            )
        )
        ,array(
            'browserName' => 'ipad',
            'desiredCapabilities' => array(
                'version' => '5.1',
                'platform' => 'OS X 10.8'
            )
        ),
        array(
            'browserName' => 'firefox',
            'desiredCapabilities' => array(
                'version' => '',
                'platform' => 'Windows 8'
            )
        ),
        array(
            'browserName' => 'chrome',
            'desiredCapabilities' => array(
                'version' => '',
                'platform' => 'Windows 8'
            )
        ),array(
            'browserName' => 'android',
            'desiredCapabilities' => array(
                'version' => '4.0',
                'platform' => 'Linux'
            )
        ),array(
            'browserName' => 'internet explorer',
            'desiredCapabilities' => array(
                'version' => '10',
                'platform' => 'Windows 8'
            )
        ),array(
            'browserName' => 'internet explorer',
            'desiredCapabilities' => array(
                'version' => '9',
                'platform' => 'Windows 7'
            )
        ),array(
            'browserName' => 'opera',
            'desiredCapabilities' => array(
                'version' => '',
                'platform' => 'Windows 7'
            )
        ),
        array(
            'browserName' => 'firefox',
            'desiredCapabilities' => array(
                'version' => '',
                'platform' => 'Windows 7'
            )
        ),
        array(
            'browserName' => 'chrome',
            'desiredCapabilities' => array(
                'version' => '',
                'platform' => 'Windows 7'
            )
        ),
        array(
            'browserName' => 'chrome',
            'desiredCapabilities' => array(
                'version' => '',
                'platform' => 'Linux'
            )
        ),
        array(
            'browserName' => 'firefox',
            'desiredCapabilities' => array(
                'version' => '',
                'platform' => 'Linux'
            )
        ),
        array(
            'browserName' => 'chrome',
            'desiredCapabilities' => array(
                'version' => '',
                'platform' => 'OS X 10.8'
            )
        ),
        array(
            'browserName' => 'safari',
            'desiredCapabilities' => array(
                'version' => '6',
                'platform' => 'OS X 10.8'
            )
        ),
        array(
            'browserName' => 'firefox',
            'desiredCapabilities' => array(
                'version' => '',
                'platform' => 'OS X 10.6'
            )
        )
    );
    

    public function setUpPage()
    {

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
        $this->assertContains('/500/',$this->byCss('.img_1')->attribute('src'));

    }

    public function testFleximgInitiation()
    {

        $this->assertContains('/400/',$this->byCss('#img_2')->attribute('src'));

    }
}
?>