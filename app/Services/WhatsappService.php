<?php

namespace App\Services;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverExpectedCondition; 
use Facebook\WebDriver\WebDriverBy; 
use Facebook\WebDriver\WebDriverKeys; 

class WhatsappService
{

    public $drive = null;

    public $user_agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36';


    public function config()
    {

    }

    public function create($chromeProfilePath, $host = 'http://localhost:4444/wd/hub')
    {
        if(!$chromeProfilePath){
            $chromeProfilePath = "./storage/app/chrome/ProfileTeste/";
        }

        $options = new ChromeOptions();
        $options->addArguments(array(
            'user-data-dir='.$chromeProfilePath,
            'window-size=1200x700',
            //'headless',
            'user-agent='.$this->user_agent,
        ));

        // start Chrome with 5 second timeout
        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        $this->driver = RemoteWebDriver::create($host, $capabilities, 5000);

        return $this;
    }

    public function createBySessionID($id, $host = 'http://localhost:4444/wd/hub')
    {
        $this->driver = RemoteWebDriver::createBySessionID($id, $host);
        return $this;
    }

    public function createWhatsappSession()
    {
        $this->driver->get('https://web.whatsapp.com/');

        $this->driver->wait(40)->until(
            WebDriverExpectedCondition::presenceOfAllElementsLocatedBy(
                WebDriverBy::xpath('//input[@name="rememberMe"]')
            )
        );

        return $this;
    }

    public function getWhatsappQRCodeFile()
    {
        $screenshot_file = $this->takeScreenshot($this->driver->findElement(WebDriverBy::xpath('//img[@alt="Scan me!"]')));

        return $screenshot_file;
    }
   
    public function getWhatsappQRCodeBase64()
    {
        $imageBase64 = $this->driver->findElement(WebDriverBy::xpath('//img[@alt="Scan me!"]'));

        return $imageBase64->getAttribute('src');
    }

    public function sendMessage($number, $message)
    {
        $this->driver->get('https://wa.me/' . $number);

        $this->driver->wait(40)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::xpath('//*[@id="action-button"]')
            )
        );

        $this->driver->findElement(WebDriverBy::xpath('//*[@id="action-button"]'))->click();

        sleep(4);

        $this->driver->wait(40)->until(
            WebDriverExpectedCondition::presenceOfAllElementsLocatedBy(
                WebDriverBy::xpath('//span[@title]')
            )
        );

        sleep(5);

        $input_box = $this->driver->findElement(WebDriverBy::xpath('//*[@id="main"]/footer/div[1]/div[2]/div/div[2]'));
        $input_box->click();

        // set message and ENTER
        $text = $message;

        $input_box->sendKeys($text);
        $input_box->sendKeys(WebDriverKeys::ENTER);


    }

    public function takeScreenshot($element=null) {
        // Change the Path to your own settings
        $screenshot = './storage/app/screenshot/' . time() . ".png";

        if( ! (bool) $element) {
            return $screenshot;
        }

        $element_screenshot = './storage/app/screenshot/' . time() . ".png"; // Change the path here as well
        
        $element_width = $element->getSize()->getWidth();
        $element_height = $element->getSize()->getHeight();
        
        $element_src_x = $element->getLocationOnScreenOnceScrolledIntoView()->getX();
        $element_src_y = $element->getLocationOnScreenOnceScrolledIntoView()->getY();

        // Change the driver instance
        $this->driver->takeScreenshot($screenshot);
        if(! file_exists($screenshot)) {
            throw new Exception('Could not save screenshot');
        }
        
        // Create image instances
        $src = imagecreatefrompng($screenshot);
        $dest = imagecreatetruecolor($element_width, $element_height);

        // Copy
        imagecopy($dest, $src, 0, 0, (int) ceil($element_src_x), (int) ceil($element_src_y), (int) ceil($element_width), (int) ceil($element_height));
        
        imagepng($dest, $element_screenshot);
        
        // unlink($screenshot); // unlink function might be restricted in mac os x.
        
        if( ! file_exists($element_screenshot)) {
            throw new Exception('Could not save element screenshot');
        }
        
        return $element_screenshot;
    }

    public function getSessionID()
    {
        return $this->driver->getSessionID();
    }

    public function getAllSessions()
    {
        return RemoteWebDriver::getAllSessions();
    }

    public function close()
    {
        $this->driver->quit();
    }


}
