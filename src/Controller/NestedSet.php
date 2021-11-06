<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 下午 2:40
 */

namespace DenDroGram\Controller;

use DenDroGram\Helpers\Func;
use DenDroGram\Model\NestedSetModel;
use DenDroGram\ViewModel\NestedSetCatalogViewModel;
use DenDroGram\ViewModel\NestedSetRhizomeSetViewModel;

class NestedSet implements Structure
{
    /**
     * 生成横向视图
     *
     * @param int $id 根节点ID
     * @param array $column 显示的字段
     * @param int $cache 缓存时间 默认：-1不缓存 0永久缓存 0>缓存n秒
     * @param string $router 操作节点路由
     * @return mixed
     * @throws \Exception
     */
    public function buildHorizontal($id, array $column = ['name'], $cache = -1, $router = '')
    {
        $css = file_get_contents(__DIR__ . '/../Static/dendrogram.css');
        $js = file_get_contents(__DIR__ . '/../Static/dendrogram.js');
        $js = sprintf($js, $router);

        $data = Func::getCache("NestedSet-Horizontal-{$id}", $cache, function () use ($id) {
            return NestedSetModel::getChildren($id);
        });
        $html = (new NestedSetCatalogViewModel($column))->index($data);
        $view = <<<EOF
<style>%s</style>
<script>%s</script>
%s
<div id="mongolia"></div>
<script>dendrogram.tree.init();</script>
EOF;
        return sprintf($view, $css, $js, $html);
    }

    /**
     * 生成竖向视图
     *
     * @param int $id 根节点ID
     * @param array $column 显示的字段
     * @param int $cache 缓存时间 默认：-1不缓存 0永久缓存 0>缓存n秒
     * @param string $router 操作节点路由
     * @return mixed
     * @throws \Exception
     */
    public function buildVertical($id, array $column = ['name'], $cache = -1, $router = '')
    {
        $css = file_get_contents(__DIR__ . '/../Static/dendrogram.css');
        $js = file_get_contents(__DIR__ . '/../Static/dendrogram.js');
        $js = sprintf($js, $router);

        $data = Func::getCache("NestedSet-Vertical-{$id}", $cache, function () use ($id) {
            return NestedSetModel::getChildren($id);
        });
        $html = (new NestedSetRhizomeSetViewModel($column))->index($data);
        $view = <<<EOF
<style>%s</style>
<script>%s</script>
<div class="dendrogram dendrogram-rhizome dendrogram-animation-fade">
%s
<div class="clear_both"></div>
</div>
<div id="mongolia"></div>
<script>dendrogram.tree.init();</script>
EOF;
        return sprintf($view, $css, $js, $html);
    }

    /**
     * 生成级联下拉列表
     *
     * @param int $id 根节点ID
     * @param string $label 列表选项显示字段 [对应记录字段]
     * @param string $value 列表选项值 [对应记录字段]
     * @param array $default 显示的字段默认值 [根据数据维度填入相应元素个数]
     * @param int $cache 缓存时间 默认：-1不缓存 0永久缓存 0>缓存n秒
     * @return mixed
     * @throws \Exception
     */
    public function buildSelect($id, $label, $value, array $default = [], $cache = -1)
    {
        $css = file_get_contents(__DIR__ . '/../Static/dendrogramUnlimitedSelect.css');
        $js = file_get_contents(__DIR__ . '/../Static/dendrogramUnlimitedSelect.js');
        $js = sprintf($js, $label, $value, json_encode($default));

        $data = Func::getCache("NestedSet-Select-{$id}", $cache, function () use ($id) {
            return NestedSetModel::getChildren($id);
        });
        self::makeTeeData($data, $tree);
        $tree = json_encode(current($tree));
        $view = <<<EOF
<style>%s</style>
<div id="dendrogram-unlimited-select"></div>
<script>%s dendrogramUS.create(%s);</script>
EOF;
        return sprintf($view, $css, $js, $tree);
    }

    /**
     * 获取数据结构
     *
     * @param int $id 根节点ID
     * @param int $cache 缓存时间 默认：-1不缓存 0永久缓存 0>缓存n秒
     * @return mixed
     * @throws \Exception
     */
    public function getTreeData($id, $cache = -1)
    {
        $data = Func::getCache("NestedSet-TreeData-{$id}", $cache, function () use ($id) {
            return NestedSetModel::getChildren($id);
        });
        self::makeTeeData($data, $tree);
        return current($tree);
    }

    private static function makeTeeData(&$array, &$branch = [])
    {
        if (empty($array)) {
            return;
        }

        if (empty($branch)) {
            $item = array_shift($array);
            $item['children'] = [];
            $branch[] = $item;
            if (!empty($array)) {
                self::makeTeeData($array, $branch);
            }
            return;
        }

        foreach ($branch as $k => &$b) {
            $b['children'] = [];
            $shoot = [];
            foreach ($array as $key => $value) {
                if (($b['layer'] + 1) == $value['layer'] && $b['left'] < $value['left'] && $b['right'] > $value['left']) {
                    $value['children'] = [];
                    $shoot[] = $value;
                    unset($array[$key]);
                }
            }

            if (!empty($array) && !empty($shoot)) {
                self::makeTeeData($array, $shoot);
                $b['children'] = $shoot;
            } elseif (empty($array) && !empty($shoot)) {
                self::makeTeeData($array, $shoot);
                $b['children'] = $shoot;
            }
        }
    }

    /**
     * 操作节点方法
     *
     * @param string $action 增删改标识 [添加记录:add 修改: update 删除: delete]
     * @param array $data 修改节点记录的传参[post方式]
     * @return mixed
     * @throws \Exception
     */
    public function operateNode($action, $data)
    {
        if ($action == 'add' && isset($data['p_id'])) {
            return NestedSetModel::add($data);
        } elseif ($action == 'update' && isset($data['id'])) {
            return NestedSetModel::where('id', $data['id'])->update($data);
        } elseif ($action == 'delete' && isset($data['id'])) {
            return NestedSetModel::deleteAll($data['id']);
        }
        return false;
    }
}
