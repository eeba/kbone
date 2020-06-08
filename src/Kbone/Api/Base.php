<?php

namespace Kbone\Api;

use \Curl\Curl;

abstract class Base {
    const HOST = 'https://mp.u7c.cn';

    const SUCCESS_CODE = 2000000;
    
    protected $config  = null;

    public function __construct($config = array()) {
        if($config){
            $config['time'] = time();
            $this->config = $config;
        }
    }

    /**
     * 发起请求
     * @param $method
     * @param $url
     * @param array $params
     * @param array $file
     * @return mixed
     * @throws \Exception
     */
    public function request($method, $url, array $params, $file = array())
    {
        if (!$this->config['key'] || !$this->config['secret']) {
            throw new \Exception("没有配置");
        }

        $query = array(
            'key' => $this->config['key'],
            't' => $this->config['time'],
            'm' => $this->sign($params),
        );
        $url = self::HOST . $url . "?" . http_build_query($query);

        if ($file) {
            if (file_exists($file['path'])) {
                $curl_file = new \CURLFile($file['path']);
                if ($file['name']) {
                    $curl_file->setPostFilename($file['name']);
                }
                $params['file'] = $curl_file;
            }
        }

        $curl = new Curl();
        if (strtolower($method) == 'post') {
            $result = $curl->post($url, $params);
        } else {
            $result = $curl->get($url, $params);
        }
        return $result;
    }

    /**
     * 生成签名
     * @param array $params
     * @return string
     */
    private function sign(array $params = array())
    {
        ksort($params, SORT_STRING);
        $sign = $this->config['key'] . $this->config['secret'] . $this->config['time'] . implode('', $params);
        return md5($sign);
    }
}