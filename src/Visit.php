<?php

namespace HilyahTech\Visitor;

class Visit
{

    public function browserDetection()
    {
        return new BrowserDetection();
    }
    
    public function ip()
    {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = @$_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        
        return $ip;
    }
    
    public function browser()
    {
        return $this->browserDetection()->getBrowser();
    }
    
    public function keyBrowser()
    {
        return $this->browserDetection()->getKeyBrowser();
    }

    public function version()
    {
        return $this->browserDetection()->getVersion();
    }

    public function platform()
    {
        return $this->browserDetection()->getPlatform();
    }

    public function keyPlatform()
    {
        return $this->browserDetection()->getKeyPlatform();
    }

    public function userAgent()
    {
        return $this->browserDetection()->getUserAgent();
    }

    public function country()
    {
        return $this->browserDetection()->getCountry();
    }

    public function countryCode()
    {
        $browserlang = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2) : null;
        return $browserlang;
    }

    public function getCountryCode($key)
    {
        return $this->browserDetection()->getCountry($key);
    }

}
