<?php

namespace service\components\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Exception;

class AnonymousBehavior extends Behavior
{
    private $userAgents;
    private $proxies;

    /**
     * Returns random user agent string.
     *
     * User agent strings are loaded from useragentswitcher.xml (@see https://github.com/miketaylr/useragent-switcher-xml).
     * Path to useragentswitcher.xml is set in service params file (@see service/config/params.php).
     *
     * @return string
     */
    public function getRandomUserAgent()
    {
        if (empty($this->userAgents)) {
            $cache = Yii::$app->getCache();
            if ($cache != null) {
                $this->userAgents = $cache->get('AnonymousBehavior.userAgents');
            }
            if (empty($this->userAgents)) {
                $xml = simplexml_load_file(Yii::$app->params['useragentXml']);

                foreach ($xml->folder as $folder) {
                    if (preg_match('/Browsers - (\w+)/', $folder['description'], $matches)) {
                        $userAgent = (isset($matches[1])) ? trim($matches[1]) : null;
                        if ($userAgent) {
                            $this->userAgents[$userAgent] = array();
                            foreach ($folder->useragent as $useragent) {
                                $this->userAgents[$userAgent][] = (string)$useragent['useragent'];
                            }
                        }
                    }
                }

                if ($cache != null) {
                    $cache->add('AnonymousBehavior.userAgents', $this->userAgents);
                }
            }
        }

        if (empty($this->userAgents)) {
            return null;
        }

        $os = array_keys($this->userAgents);
        $os = $os[rand(0, count($os) - 1)];
        $osUserAgents = $this->userAgents[$os];
        return $osUserAgents[rand(0, count($osUserAgents) - 1)];
    }

    /**
     * Returns random proxy server.
     *
     * Proxies are loaded from xml file proxylist.xml.
     * Path to proxylist.xml is set in service params file (@see service/config/params.php).
     *
     * @return string
     */
    public function getRandomProxy()
    {
        if (empty($this->proxies)) {
            $cache = Yii::$app->getCache();
            if ($cache != null) {
                $this->proxies = $cache->get('AnonymousBehavior.proxies');
            }
            if (empty($this->proxies)) {
                $xml = simplexml_load_file(Yii::$app->params['proxiesXml']);

                foreach ($xml->proxy as $proxy) {
                    $_proxy = [];

                    $url = null;
                    $usrPwd = null;

                    if ((string)$proxy->protocol && (string)$proxy->ip) {
                        $url = $proxy->protocol.'://'.$proxy->ip;

                        if ((string)$proxy->port) {
                            $url .= ':'.$proxy->port;
                        }
                        if ((string)$proxy->username && (string)$proxy->password) {
                            $usrPwd = base64_encode($proxy->username.':'.$proxy->password);
                        }

                        $_proxy['protocol'] = (string)$proxy->protocol;
                        $_proxy['ip'] = (string)$proxy->ip;
                        $_proxy['port'] = (string)$proxy->port;
                        $_proxy['user'] = isset($proxy->username) ? (string)$proxy->username : null;
                        $_proxy['password'] = isset($proxy->password) ? (string)$proxy->password : null;
                        $_proxy['url'] = $url;
                        $_proxy['usrpwd'] = $usrPwd;
                        $_proxy['reqAuth'] = ($usrPwd != null);

                        $this->proxies[] = $_proxy;
                    }
                }

                if ($cache != null) {
                    $cache->add('AnonymousBehavior.proxies', $this->proxies);
                }
            }
        }

        if (empty($this->proxies)) {
            return null;
        }

        return (object)$this->proxies[rand(0, count($this->proxies) - 1)];
    }
}
