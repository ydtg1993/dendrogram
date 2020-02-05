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
     * @return mixed
     */
    public function buildCatalog($id,$router,array $column = ['name']);

    /**
     * @param $id
     * @param $router
     * @param array $column
     * @return mixed
     */
    public function buildRhizome($id,$router,array $column = ['name']);

    /**
     * @param $id
     * @param $label
     * @param $value
     * @return mixed
     */
    public function buildSelect($id,$label,$value);

    /**
     * @param $id
     * @return mixed
     */
    public function getTreeData($id);

    /**
     * @param $action
     * @param $data
     * @return mixed
     */
    public function operateNode($action,$data);
}
