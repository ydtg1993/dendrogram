<?php

namespace DenDroGram\Helpers;

class Func
{
    /**
     * 多条件查询二维数组索引
     *
     * @param $array
     * @param array $params
     * @return bool|int|string
     */
    public static function quadraticArrayGetIndex(array $array, array $params)
    {
        $index = false;
        foreach ($array as $key => $item) {
            $add = true;
            foreach ($params as $field => $value) {
                if ($item[$field] != $value) {
                    $add = false;
                }
            }
            if ($add) {
                $index = $key;
                break;
            }
        }

        return $index;
    }

    /**
     * 首位sprintf
     * @param $string
     * @param string $aim
     * @param $value
     * @return bool|string
     */
    public static function firstSprintf($string, $value, $aim = '%s')
    {
        $position = strpos($string, $aim);
        $len = strlen($aim);
        $left = substr($string, 0, $position + $len);
        $right = substr($string, $position + $len);
        return sprintf($left, $value) . $right;
    }

    public static function getCache($file, $cache, $func)
    {
        if($cache < 0){
            return $func();
        }
        $dir = __DIR__ . '/../../cache/';
        if(!is_dir($dir)){
            mkdir($dir);
        }
        $file = $dir . $file;
        $now = time();
        if (file_exists($file)) {
            $content = (array)json_decode(file_get_contents($file),true);
            if ($cache == 0) {
                return $content['data'];
            }
            if($now > $content['expire']){
                $data = $func();
                $content = ['data' => $data, 'expire' => $now + $cache];
                file_put_contents($file,json_encode($content));
                return $data;
            }
            return $content['data'];
        }
        $data = $func();
        $content = ['data' => $data, 'expire' => $now + $cache];
        file_put_contents($file,json_encode($content));
        return $data;
    }
}
