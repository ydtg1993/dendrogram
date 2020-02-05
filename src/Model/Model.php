<?php
/**
 * Created by PhpStorm.
 * User: ydtg1
 * Date: 2019/1/13
 * Time: 18:13
 */
namespace DenDroGram\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection;

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = config('dendrogram.connection','mysql');
    }
}