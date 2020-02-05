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
     * @param array $lists
     * @param $id_name
     * @param $p_id_name
     * @param string $childKey
     * @return array
     */
    public static function quadraticArrayToTreeData(array $lists,$id_name, $p_id_name)
    {
        $lists = self::quadraticArraySort($lists,$p_id_name);
        $map = [];
        $res = [];
        foreach ($lists as $id => &$item) {
            $pid = &$item[$p_id_name];
            $map[$item[$id_name]] = &$item;
            if (!isset($map[$pid])) {
                $res[$id] = &$item;
            } else {
                $pItem = &$map[$pid];
                $pItem['children'][] = &$item;
            }
        }
        return $res;
    }

    /**
     * 二维度数组排序
     * @param $array
     * @param $field
     * @return array
     */
    public static function quadraticArraySort(array $array, $field)
    {
        $new_array = array();
        foreach ($array as $k => $v) {
            $v['children'] = [];
            if(isset($new_array[$v[$field]])){
                $new_array[$v[$field] + 1] = $v;
                continue;
            }
            $new_array[$v[$field]] = $v;
        }

        return $new_array;
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
}
