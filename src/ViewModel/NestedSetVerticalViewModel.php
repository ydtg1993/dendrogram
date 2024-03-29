<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 下午 3:47
 */

namespace DenDroGram\ViewModel;

use DenDroGram\Helpers\Func;

class NestedSetVerticalViewModel extends ViewModel
{
    private $root = <<<EOF
<ul>%s</ul>
EOF;

    private $branch = <<<EOF
<ul style="display:%s">%s</ul>
EOF;

    private $leaf = <<<EOF
<li>
    <div data-v=%s data-sign=%d class="dendrogram-vertical-branch">
            <a href="javascript:void(0);" class="dendrogram-switch">
                %s
             </a>
             <button class="dendrogram-tab" href="javascript:void(0);">
                %s
             </button>
         <a href="#form" class="dendrogram-grow">
            %s
         </a>
    </div>
    %s
</li>
EOF;

    private $leaf_apex = <<<EOF
<li>
    <div data-v=%s class="dendrogram-vertical-branch">
         <a href="javascript:void(0);" class="dendrogram-ban">
            %s
         </a>
             <button class="dendrogram-tab" href="javascript:void(0);">
                %s
             </button>
         <a href="#form" class="dendrogram-grow">
            %s
         </a>
    </div>
</li>
EOF;

    public function __construct($column)
    {
        parent::__construct($column);
    }

    public function index($data)
    {
        if($this->sign){
            $this->branch = Func::firstSprintf($this->branch,'block');
        }else{
            $this->branch = Func::firstSprintf($this->branch,'none');
        }
        $this->makeTree($data,$tree);
        $this->tree_view.=$this->form;
        return $this->tree_view;
    }

    /**
     * @param $array
     * @param array $tree
     */
    private function makeTree(&$array, &$tree = [])
    {
        if(empty($array)){
            return;
        }

        if (empty($tree)) {
            $item = array_shift($array);
            $item['children'] = [];
            $tree[] = $item;
            if (empty($array)) {
                //no children
                $this->tree_view = sprintf($this->root,
                    sprintf($this->leaf_apex,json_encode($item),$this->icon['ban'],$this->makeColumn($item),$this->icon['grow'],''));
                return;
            } else {
                $left_button = $this->sign ? $this->icon['shrink'] : $this->icon['expand'];
                $this->tree_view = sprintf($this->root,
                    sprintf($this->leaf,json_encode($item),(int)$this->sign,$left_button,$this->makeColumn($item),$this->icon['grow'],$this->branch));
            }
        }

        foreach ($tree as &$branch) {
            $shoot = [];
            foreach ($array as $key => $value) {
                if (($branch['layer'] + 1) == $value['layer'] && $branch['left'] < $value['left'] && $branch['right'] > $value['left']) {
                    $value['children'] = [];
                    $branch['children'][] = $value;
                    unset($array[$key]);
                    if (!$this->hasChildren($value,$array)) {
                        //无子节点
                        $shoot[] = $this->makeBranch($value, false);
                    } else {
                        $shoot[] = $this->makeBranch($value);
                    }
                }
            }

            if (!empty($branch['children']) && $array) {
                $this->tree_view = Func::firstSprintf($this->tree_view, join('', $shoot));
                $this->makeTree($array, $branch['children']);
            } elseif (!empty($branch['children'])) {
                $this->tree_view = Func::firstSprintf($this->tree_view, join('', $shoot));
            }
        }
    }

    private function hasChildren($item,$data)
    {
        foreach ($data as $key => $value) {
            if(($item['layer'] + 1) == $value['layer'] && $item['left'] < $value['left'] && $item['right'] > $value['right']){
                return true;
            }
        }
        return false;
    }

    private function makeColumn($data)
    {
        $text = '<div class="text">%s</div>';
        $html = '';
        foreach ($this->column as $column){
            $html.=sprintf($text,isset($data[$column])?$data[$column]:'');
        }
        return $html;
    }

    /**
     * 枝
     * @param $data
     * @param bool $node
     * @return string
     */
    private function makeBranch($data, $node = true)
    {
        if ($node) {
            $left_button = $this->sign ? $this->icon['shrink'] : $this->icon['expand'];
            return sprintf($this->leaf, json_encode($data),$this->sign,$left_button, $this->makeColumn($data),$this->icon['grow'], $this->branch);
        }
        return sprintf($this->leaf_apex, json_encode($data),$this->icon['ban'], $this->makeColumn($data),$this->icon['grow'], '');
    }
}
