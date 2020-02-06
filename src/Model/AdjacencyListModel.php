<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/21 0021
 * Time: 下午 5:35
 */

namespace DenDroGram\Model;

class AdjacencyListModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'dendrogram_adjacency';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = ['id','p_id'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('dendrogram.adjacency_table','dendrogram_adjacency');
    }

    public static function getChildren($id,$order = 'ASC')
    {
        $data = self::whereRaw("FIND_IN_SET(id,(select * from (select dendrogramAdjacencyGetChildren($id) as ids) ids))")->orderBy('layer', $order)->orderBy('sort', 'DESC')->orderBy('id', 'ASC')->get();
        if(!$data){
            return [];
        }
        return $data->toArray();
    }

    public static function deleteAll($id)
    {
        return self::whereRaw("FIND_IN_SET(id,dendrogramAdjacencyGetChildren($id))")->delete();
    }
}
