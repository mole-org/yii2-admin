<?php
namespace yii\helpers;

use yii\helpers\BaseUrl;

class Url extends BaseUrl
{
    public static function simple($url, $params = [])
    {
        $url = preg_replace_callback(
            '/:\w+/', 
            function($matches) use (&$params) {
                $key = substr($matches[0], 1);
                if (isset($params[$key])) {
                    $str = urlencode($params[$key]);
                    unset($params[$key]);
                    return $str;
                }
    
                return '';
            }, 
            $url
        );
    
        $url = preg_replace('#/{2,}#', '/', $url);
        $url = rtrim($url, '/');
        if ($params) {
            $url .= '?' . http_build_query($params);
        }
    
        return $url;
    }
} 