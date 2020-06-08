<?php
namespace Kbone;

/**
 * Class Application
 * @method static \Kbone\Api\Mail mail($config)
 * @method static \Kbone\Api\File file($config)
 */
class Application
{
    private static $config = array(
        'host' => 'https://mp.u7c.cn'
    );

    public static function __callStatic($name, $config){
        $application = "\\Kbone\\Api\\" . ucfirst($name);
        $config = array_merge(self::$config, $config[0]);
        return new $application($config);
    }
}