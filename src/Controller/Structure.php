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
     * @param $id
     * @param $router
     * @param array $column
     * @param int $cache
     * @return mixed
     */
    public function buildCatalog($id, $router, array $column = ['name'], $cache = -1);

    /**
     * @param $id
     * @param $router
     * @param array $column
     * @param int $cache
     * @return mixed
     */
    public function buildRhizome($id, $router, array $column = ['name'], $cache = -1);

    /**
     * @param $id
     * @param $label
     * @param $value
     * 显示的字段默认值 根据层级深度填入元素个数
     * @param array $default
     * @param int $cache
     * @return mixed
     */
    public function buildSelect($id, $label, $value, array $default = [], $cache = -1);

    /**
     * @param $id
     * @param int $cache
     * @return mixed
     */
    public function getTreeData($id, $cache = -1);

    /**
     * @param $action
     * @param $data
     * @return mixed
     */
    public function operateNode($action, $data);
}
