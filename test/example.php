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
     * 1. 目录树视图
     */
    function catalog()
    {
        /*数据类型可直接使用
        *AdjacencyList::class 或 NestedSet::class 进行切换
        */
        echo (new \DenDroGram\Controller\DenDroGram(\DenDroGram\Controller\AdjacencyList::class))->buildCatalog(1, 'http://operateCatalogRouter...');
    }

    /**
     * 节点操作方法 路由POST方式
     * 目录树视图
     */
    function operateCatalog()
    {
        $action = $_POST['action'];
        $data = $_POST['data'];
        /**
         *数据结构要保持与创建时一致
         */
        (new \DenDroGram\Controller\DenDroGram(\DenDroGram\Controller\AdjacencyList::class))->operateNode($action, $data);
    }

    /**
     * 2. 根茎视图
     */
    function rhizome()
    {
        /*数据类型可直接使用
        *AdjacencyList::class 或 NestedSet::class 进行切换
        */
        echo (new \DenDroGram\Controller\DenDroGram(\DenDroGram\Controller\NestedSet::class))->buildRhizome(1, 'http://operateCatalogRouter...');
    }

    /**
     * 节点操作方法 路由POST方式
     * 根茎视图
     */
    function operateRhizome()
    {
        $action = $_POST['action'];
        $data = $_POST['data'];
        (new \DenDroGram\Controller\DenDroGram(\DenDroGram\Controller\NestedSet::class))->operateNode($action, $data);
    }

    /**
     * 3.下拉列表视图
     * 此视图下只能选择 无法操作节点
     */
    function select()
    {
        /*
         * 生产下拉列表选择器
         * 选择结果可通在js中调用 dendrogramUS.storage()
         * */
        echo (new \DenDroGram\Controller\DenDroGram(\DenDroGram\Controller\NestedSet::class))->buildSelect(1);
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
