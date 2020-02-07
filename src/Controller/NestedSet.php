<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 下午 2:40
 */

namespace DenDroGram\Controller;

use DenDroGram\Model\NestedSetModel;
use DenDroGram\ViewModel\NestedSetCatalogViewModel;
use DenDroGram\ViewModel\NestedSetRhizomeSetViewModel;

class NestedSet implements Structure
{
    /**
     * @param $id
     * @param $router
     * @param array $column
     * @return mixed|string
     */
    public function buildCatalog($id,$router, array $column = ['name'])
    {
        $css = file_get_contents(__DIR__.'/../Static/dendrogram.css');
        $js = file_get_contents(__DIR__.'/../Static/dendrogram.js');
        $js = sprintf($js,$router);

        $data = NestedSetModel::getChildren($id);
        $html = (new NestedSetCatalogViewModel($column))->index($data);
        $view = <<<EOF
<style>%s</style>
<script>%s</script>
%s
<div id="mongolia"></div>
<script>dendrogram.tree.init();</script>
EOF;
        return sprintf($view,$css,$js,$html);
    }

    /**
     * @param $id
     * @param $router
     * @param array $column
     * @return mixed|string
     */
    public function buildRhizome($id,$router,array $column = ['name'])
    {
        $css = file_get_contents(__DIR__.'/../Static/dendrogram.css');
        $js = file_get_contents(__DIR__.'/../Static/dendrogram.js');
        $js = sprintf($js,$router);

        $data = NestedSetModel::getChildren($id);
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
        return sprintf($view,$css,$js,$html);
    }

    public function buildSelect($id,$label,$value,array $default = [])
    {
        $css = file_get_contents(__DIR__ . '/../Static/dendrogramUnlimitedSelect.css');
        $js = file_get_contents(__DIR__ . '/../Static/dendrogramUnlimitedSelect.js');
        $js = sprintf($js,$label,$value,json_encode($default));
        $tree = json_encode($this->getTreeData($id));
        $view = <<<EOF
<style>%s</style>
<div id="dendrogram-unlimited-select"></div>
<script>%s dendrogramUS.create(%s);</script>
EOF;
        return sprintf($view,$css,$js,$tree);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTreeData($id)
    {
        $data = NestedSetModel::getChildren($id);
        self::makeTeeData($data,$tree);
        return current($tree);
    }

    private static function makeTeeData(&$array, &$branch = [])
    {
        if(empty($array)){
            return;
        }

        if (empty($branch)) {
            $item = array_shift($array);
            $item['children'] = [];
            $branch[] = $item;
            if (!empty($array)) {
                self::makeTeeData($array,$branch);
            }
            return;
        }

        foreach ($branch as $k=>&$b) {
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
                self::makeTeeData($array,$shoot);
                $b['children'] = $shoot;
            }elseif (empty($array) && !empty($shoot)){
                self::makeTeeData($array,$shoot);
                $b['children'] = $shoot;
            }
        }
    }

    /**
     * @param $action
     * @param $data
     * @return bool
     */
    public function operateNode($action,$data)
    {
        if($action == 'add' && isset($data['p_id'])){
            return NestedSetModel::add($data);
        }elseif ($action == 'update' && isset($data['id'])){
            return NestedSetModel::where('id',$data['id'])->update($data);
        }elseif ($action == 'delete' && isset($data['id'])){
            return NestedSetModel::deleteAll($data['id']);
        }
        return false;
    }
}
