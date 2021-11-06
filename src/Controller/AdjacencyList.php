<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 下午 2:40
 */

namespace DenDroGram\Controller;

use DenDroGram\Helpers\Func;
use DenDroGram\Model\AdjacencyListModel;
use DenDroGram\ViewModel\AdjacencyListCatalogViewModel;
use DenDroGram\ViewModel\AdjacencyListRhizomeViewModel;

class AdjacencyList implements Structure
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

        $data = Func::getCache("AdjacencyList-Horizontal-{$id}", $cache, function () use ($id) {
            return AdjacencyListModel::getChildren($id);
        });
        $html = (new AdjacencyListCatalogViewModel($column))->index($data);
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

        $data = Func::getCache("AdjacencyList-Vertical-{$id}", $cache, function () use ($id) {
            return AdjacencyListModel::getChildren($id);
        });
        $html = (new AdjacencyListRhizomeViewModel($column))->index($data);
        $view = <<<EOF
<style>%s</style>
<script>%s</script>
<div class="dendrogram dendrogram-rhizome dendrogram-animation-fade">
%s
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

        $data = Func::getCache("AdjacencyList-Select-{$id}", $cache, function () use ($id) {
            return AdjacencyListModel::getChildren($id, 'DESC');
        });
        $tree = json_encode(self::makeTeeData($data));
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
        $data = Func::getCache("AdjacencyList-TreeData-{$id}", $cache, function () use ($id) {
            return AdjacencyListModel::getChildren($id, 'DESC');
        });
        return self::makeTeeData2($data);
    }

    private static function makeTeeData($data)
    {
        $tempDeepArray = [];
        foreach ($data as $item) {
            $item['children'] = [];
            $tempDeepArray[$item['layer']][$item['p_id']][] = $item;
        }
        foreach ($tempDeepArray as $layer => $boundary) {
            $nextLayer = $layer - 1;
            foreach ($tempDeepArray[$layer] as $p_id => $list) {
                if (!isset($tempDeepArray[$nextLayer])) {
                    break;
                }

                foreach ($tempDeepArray[$nextLayer] as $b_k => $nextBoundaryList) {
                    foreach ($nextBoundaryList as $i_k => $item) {
                        if (empty($tempDeepArray[$layer])) {
                            break(2);
                        }
                        if ($item['id'] !== $p_id) {
                            continue;
                        }
                        $tempDeepArray[$nextLayer][$b_k][$i_k]['children'] = $list;
                        unset($tempDeepArray[$layer][$p_id]);
                    }
                }
            }
        }
        return current(current(current(array_filter($tempDeepArray))));
    }

    private static function makeTeeData2($data)
    {
        $tempDeepArray = [];
        foreach ($data as $item) {
            $item['child'] = [];
            $tmpData = ['id' => $item['id'], 'name' => $item['name'], 'child' => null];
            $tempDeepArray[$item['layer']][$item['p_id']][] = $tmpData;
        }

        foreach ($tempDeepArray as $layer => $boundary) {
            $nextLayer = $layer - 1;
            foreach ($tempDeepArray[$layer] as $p_id => $list) {
                if (!isset($tempDeepArray[$nextLayer])) {
                    break;
                }

                foreach ($tempDeepArray[$nextLayer] as $b_k => $nextBoundaryList) {
                    foreach ($nextBoundaryList as $i_k => $item) {
                        if (empty($tempDeepArray[$layer])) {
                            break(2);
                        }
                        if ($item['id'] !== $p_id) {
                            continue;
                        }
                        $tempDeepArray[$nextLayer][$b_k][$i_k]['child'] = $list;
                        unset($tempDeepArray[$layer][$p_id]);
                    }
                }
            }
        }
        return current(current(current(array_filter($tempDeepArray))));
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
        if ($action == 'add') {
            $parent = AdjacencyListModel::where('id', $data['p_id'])->first();
            if (!$parent) {
                $data['layer'] = 0;
            } else {
                $data['layer'] = $parent->layer + 1;
            }
            return AdjacencyListModel::insertGetId($data);
        } elseif ($action == 'update' && isset($data['id'])) {
            return AdjacencyListModel::where('id', $data['id'])->update($data);
        } elseif ($action == 'delete' && isset($data['id'])) {
            return AdjacencyListModel::deleteAll($data['id']);
        }
        return false;
    }

}
