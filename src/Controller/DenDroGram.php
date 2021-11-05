<?php
/**
 * Created by PhpStorm.
 * User: ydtg1
 * Date: 2019/1/28
 * Time: 12:39
 */

namespace DenDroGram\Controller;


use DenDroGram\ViewModel\ViewModel;

class DenDroGram implements Structure
{
    /**
     * @var Structure
     */
    private $instance;

    public function __construct($structure)
    {
        $this->instance = new $structure;
        if(!($this->instance instanceof Structure)){
            throw new \Exception('import instance is not instanceof structure');
        }

    }

    /**
     * 生成目录式视图
     *
     * 根节点ID
     * @param $id
     * 操作节点路由
     * @param $router
     * 显示的字段
     * @param array $column
     * @param int $cache
     * @return mixed
     * @throws \Exception
     */
    public function buildCatalog($id,$router, array $column = ['name'], $cache = -1)
    {
        try {
            $result = $this->instance->buildCatalog($id,$router, $column, $cache);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
        return $result;
    }

    /**
     * 生成茎状图
     *
     * 根节点ID
     * @param $id
     * 操作节点路由
     * @param $router
     * 显示的字段
     * @param array $column
     * @param int $cache
     * @return mixed
     * @throws \Exception
     */
    public function buildRhizome($id,$router, array $column = ['name'], $cache = -1)
    {
        try {
            $result = $this->instance->buildRhizome($id,$router, $column, $cache);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
        return $result;
    }

    /**
     * 生成下拉列表
     *
     * 根节点ID
     * @param $id
     * 列表选项显示字段
     * @param string $label
     * 列表选项值
     * @param string $value
     * 显示的字段默认值 根据层级深度填入元素个数
     * @param array $default
     * @param int $cache
     * @return mixed
     * @throws \Exception
     */
    public function buildSelect($id,$label = 'name',$value = 'id',array $default = [], $cache = -1)
    {
        try {
            $result = $this->instance->buildSelect($id,$label,$value,$default, $cache);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
        return $result;
    }

    /**
     * 获取数据结构
     * @param $id
     * @return mixed
     * @param int $cache
     * @throws \Exception
     */
    public function getTreeData($id, $cache = -1)
    {
        try {
            $result = $this->instance->getTreeData($id, $cache);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
        return $result;
    }

    /**
     * 操作节点方法
     * @param $action
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function operateNode($action, $data)
    {
        try {
            $result = $this->instance->operateNode($action, $data);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
        return $result;
    }

}
