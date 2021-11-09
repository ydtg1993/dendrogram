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
        echo (new \DenDroGram\Controller\DenDroGram(\DenDroGram\Controller\AdjacencyList::class))->buildHorizontal(1,['name'],-1,'节点操作url');
        /*如果没有传递router参数:节点操作url 视图不会有默认的修改,新增弹窗表单*/

        /* 1.绑定事件到节点的标签tab,添加按钮grow：*/
        /*dendrogram.bindClassEnvent('dendrogram-tab',事件,回调方法); */
        /*dendrogram.bindClassEnvent('dendrogram-grow',事件,回调方法);*/
/*
    <script>
        $(function() {
            dendrogram.bindClassEnvent('dendrogram-tab','click',function(){
                alert('触发点击标签按钮事件')
            });

            dendrogram.bindClassEnvent('dendrogram-grow','click',function(){
                alert('触发点击增添按钮事件')
            });
        });
    </script>
*/

        /* 2.传递router参数:节点操作url 可以对表单内容做基本的设置 dendrogram.form.settings*/
        /*
         * settings结构为数组对象 [setting,setting,...]
         * 输入框setting为普通对象 {
         *      column:'记录字段 必填',
         *      label:'输入框标签 选填',
         *      type:'输入框类型 选填',
         *      attribute:'输入框属性参数 选填',
         *      options:'当类setting的类型type为radio或者checkbox时的选项参数 选填'
         * }
         *
         * setting中 type类型：text textarea hidden disable radio checkbox 默认text
         * options结构为数组对象 [] option为普通对象 {label:'选项标签 必填',value:'选项值 必填'}
         * 多选checkbox的值以逗号为分割(仅支持字符串字段类型) 例如:选项1,选项2,...
         * */
/*
<script>
    $(function() {
        //配置表单内容设置
        dendrogram.form.settings = [
            {column:'id',label:'编号',type:"disable"},
            {column:'name',label:'名称',type:'textarea',attribute:''},
            {column:'layer',label:'层级',type:'checkbox',options:[{label:'顶级',value:0}, {label:'次级',value:1},{label:'三级',value:2}]},
            {column:'sort',label:'排序'}
        ];
    });
</script>
*/

        /**
        <script>
        $(function() {
        //1.如果没有传router参数
        dendrogram.bindClassEnvent('dendrogram-tab',事件,回调方法);
        //3.配置表单内容设置
        dendrogram.form.settings = [
            {column:'id',label:'编号',type:"disable"},
            {column:'name',label:'名称',type:'textarea',attribute:''},
            {column:'layer',label:'层级',type:'checkbox',options:[{label:'顶级',value:0}, {label:'次级',value:1},{label:'三级',value:2}]},
            {column:'sort',label:'排序'}
        ];

        });
        </script>
         */
        exit;
    }

    /**
     * 节点操作方法 POST方式
     */
    function operateHorizontal()
    {
        $action = $_POST['action'];
        $data = $_POST['data'];
        /**
         *数据结构要保持与创建时一致
         */
        $result = (new \DenDroGram\Controller\DenDroGram(\DenDroGram\Controller\AdjacencyList::class))->operateNode($action, $data);
        return json_encode($result);
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
     * 3.级联下拉列表
     * dendrogramUS.storage() 获取当前列表选中的值
     * dendrogramUS.callback 点击事件处罚的回调方法
     */
    function select()
    {
        echo (new \DenDroGram\Controller\DenDroGram(\DenDroGram\Controller\NestedSet::class))->buildSelect(1);
        /**
        <script>
            $(function() {
            var data = dendrogramUS.storage();
            console.log(data)
            dendrogramUS.callback = function() {
            var data = dendrogramUS.storage()
            console.log(data)
            alert('处罚点击事件回调 当前选中值:'+data);
            }
            });
        </script>
         */
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
