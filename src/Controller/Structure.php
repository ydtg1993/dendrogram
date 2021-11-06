<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 下午 2:43
 */

namespace DenDroGram\Controller;

interface Structure
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
    public function buildHorizontal($id, array $column = ['name'], $cache = -1, $router = '');

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
    public function buildVertical($id, array $column = ['name'], $cache = -1, $router = '');

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
    public function buildSelect($id, $label, $value, array $default = [], $cache = -1);

    /**
     * 获取数据结构
     *
     * @param int $id 根节点ID
     * @param int $cache 缓存时间 默认：-1不缓存 0永久缓存 0>缓存n秒
     * @return mixed
     * @throws \Exception
     */
    public function getTreeData($id, $cache = -1);

    /**
     * 操作节点方法
     *
     * @param string $action 增删改标识 [添加记录:add 修改: update 删除: delete]
     * @param array $data 修改节点记录的传参[post方式]
     * @return mixed
     * @throws \Exception
     */
    public function operateNode($action, $data);
}
