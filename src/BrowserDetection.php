<?php

namespace HilyahTech\Visitor;

class BrowserDetection
{

    /**
     * User agent.
     * 
     * @var string $userAgent
     */
    private $userAgent;

    /**
     * Browser name.
     * 
     * @var string $BrowserName
     */
    private $BrowserName;

    /**
     * Browser version.
     * 
     * @var string $browserVersion
     */
    private $browserVersion;

    /**
     * Platform name.
     * 
     * @var string $platformName
     */
    private $platformName;

    /**
     * All browser's name (47).
     * 
     * @var array $browsers
     */
    private $browsers = [
        'amaya' => 'Amaya',
        'Arora' => 'Arora',
        'Avant Browser' => 'Avant Browser',
        'Beamrise' => 'Beamrise',
        'BOLT' => 'BOLT',
        'Camino' => 'Camino',
        'Chimera' => 'Chimera',
        'Chrome' => 'Google Chrome',
        'Dillo' => 'Dillo',
        'Epiphany' => 'Epiphany',
        'EudoraWeb' => 'EudoraWeb',
        'Firebird' => 'Firebird',
        'Firefox' => 'Firefox',
        'Galeon' => 'Galeon',
        'hotjava' => 'HotJava',
        'IBrowse' => 'IBrowse',
        'icab' => 'iCab',
        'Iceape' => 'Iceape',
        'Iceweasel' => 'Iceweasel',
        'Internet Explorer' => 'Internet Explorer',
        'iTunes' => 'iTunes',
        'Kindle' => 'Kindle',
        'Konqueror' => 'Konqueror',
        'Links' => 'Links',
        'Lynx' => 'Lynx',
        'Maxthon' => 'Maxthon',
        'Midori' => 'Midori',
        'Mozilla' => 'Mozilla',
        'MSIE' => 'Internet Explorer',
        'Namoroka' => 'Namoroka',
        'Netscape' => 'Netscape',
        'NetSurf' => 'NetSurf',
        'OmniWeb' => 'OmniWeb',
        'Opera' => 'Opera',
        'OPR' => 'Opera',
        'Phoenix' => 'Phoenix',
        'QupZilla' => 'QupZilla',
        'Safari' => 'Safari',
        'SeaMonkey' => 'SeaMonkey',
        'shadowfox' => 'ShadowFox',
        'Shiira' => 'Shiira',
        'Silk' => 'Silk',
        'Swiftfox' => 'Swiftfox',
        'Trident\/7.0' => 'Internet Explorer 11',
        'UCBrowser' => 'UCBrowser',
        'Uzbl' => 'Uzbl',
        'wOSBrowser' => 'wOSBrowser',
    ];

    /**
     * All platform's name (22).
     * 
     * @return array $platforms
     */
    private $platforms = [
        'android' => 'Android',
        'BeOS' => 'BeOS',
        'BlackBerry' => 'BlackBerry',
        'Dillo' => 'Linux',
        'DragonFly' => 'DragonFlyBSD',
        'FreeBSD' => 'FreeBSD',
        'iPad' => 'iPad',
        'iPhone' => 'iPhone',
        'iPod' => 'iPod',
        'linux' => 'Linux',
        'mac' => 'Apple',
        'NetBSD' => 'NetBSD',
        'Nokia' => 'Nokia',
        'OS\/2' => 'OS/2',
        'OpenBSD' => 'OpenBSD',
        'OpenSolaris' => 'OpenSolaris',
        'PalmOS' => 'PalmOS',
        'RebelMouse' => 'RebelMouse',
        'SunOS' => 'SunOS',
        'UNIX' => 'UNIX',
        'win' => 'Windows',
        'windows' => 'Windows',
    ];

    /**
     * Construct
     */
    public function __construct()
    {
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
        
        foreach ($this->browsers as $pattern => $name) {
            if (preg_match("/" . $pattern . "/i", $this->userAgent, $match)) {
                
                $this->BrowserName = $name;

                // finally get the correct version number
                $known = array('Version', $pattern, 'other');
                $pattern_version = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

                // we have no matching number just continue
                if (!preg_match_all($pattern_version, $this->userAgent, $matches));

                // see how many we have
                $i = count($matches['browser']);

                if ($i != 1) {
                    
                    @$this->browserVersion =
                        strripos($this->userAgent, "Version") < strripos($this->userAgent, $pattern)
                        ? $matches['version'][0] : $matches['version'][1];

                } else {
                    $this->browserVersion = $matches['version'][0];
                }

                break;
            }
        }

        foreach ($this->platforms as $key => $platform) {
            if (stripos($this->userAgent, $key) !== false) {
                $this->platformName = $platform;
                break;
            }
        }

    }

    /**
     * Retrieve browser's name.
     * 
     * @return string
     */
    public function getBrowser(): string
    {
        return $this->BrowserName ?: 'unknown';
    }

    /**
     * Retrieve browser version.
     * @return string
     */
    public function getVersion(): string
    {
        return $this->browserVersion;
    }

    /**
     * Retrieve platform's name.
     * 
     * @return string
     */
    public function getPlatform(): string
    {
        return $this->platformName ?: 'unknown';
    }

    /**
     * Retrieve agent.
     * 
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->userAgent ?: '';
    }

    /**
     * Retrieve country.
     * 
     * @return string
     */
    public function getCountry($key = null)
    {
        $cc = new CountryCode();

        $key = is_null($key)
            ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)
            : $key;
        
        $key = strtoupper($key);

        if (array_key_exists($key, $cc->getCountry())) {
            return $cc->getCountry()[$key];
        }

        return 'unknown';
    }

}
