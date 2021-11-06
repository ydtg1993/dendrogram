<?php
/**
 * Created by PhpStorm.
 * User: Hikki
 * Date: 2018/11/27 0027
 * Time: 下午 5:55
 */
require_once __DIR__.'/../autoload.php';

class TestDendrogram
{
    /**
     * 1. 横向视图
     */
    function horizontal()
    {
        /*数据类型可直接使用
        *AdjacencyList::class 或 NestedSet::class 进行切换
        */
        echo (new \DenDroGram\Controller\DenDroGram(\DenDroGram\Controller\AdjacencyList::class))->buildHorizontal(1);
        exit;
    }

    /**
     * 节点操作方法 路由POST方式
     */
    function operateHorizontal()
    {
        $action = $_POST['action'];
        $data = $_POST['data'];
        /**
         *数据结构要保持与创建时一致
         */
        (new \DenDroGram\Controller\DenDroGram(\DenDroGram\Controller\AdjacencyList::class))->operateNode($action, $data);
    }

    /**
     * 2. 竖向视图
     */
    function vertical()
    {
        /*数据类型可直接使用
        *AdjacencyList::class 或 NestedSet::class 进行切换
        */
        echo (new \DenDroGram\Controller\DenDroGram(\DenDroGram\Controller\NestedSet::class))->buildVertical(1);
        exit;
    }

    /**
     * 节点操作方法 路由POST方式
     * 根茎视图
     */
    function operateVertical()
    {
        $action = $_POST['action'];
        $data = $_POST['data'];
        (new \DenDroGram\Controller\DenDroGram(\DenDroGram\Controller\NestedSet::class))->operateNode($action, $data);
    }

    /**
     * 3.级联下拉列表
     */
    function select()
    {
        echo (new \DenDroGram\Controller\DenDroGram(\DenDroGram\Controller\NestedSet::class))->buildSelect(1);
        exit;
    }

    /**
     * 4.获取结构型数据
     * @throws Exception
     */
    function getData()
    {
        $data = (new \DenDroGram\Controller\DenDroGram(\DenDroGram\Controller\NestedSet::class))->getTreeData(1);
        var_dump($data);
    }
}
