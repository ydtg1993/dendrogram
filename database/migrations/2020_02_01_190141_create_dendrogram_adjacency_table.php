<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDendrogramAdjacencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = config('dendrogram.adjacency_table','dendrogram_adjacency');
        Schema::create($table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('p_id')->default(0)->comment('父节点id');
            $table->string('name')->default('')->comment('节点名称');
            $table->integer('layer')->default(0)->comment('层级');
            $table->integer('sort')->default(0)->comment('排序 同级有效');
        });

        \Illuminate\Support\Facades\DB::table($table)->insert([
            ["id"=>1,"p_id"=>0,"layer"=>0,"name"=>"中国"],
            ["id"=>2,"p_id"=>1,"layer"=>1,"name"=>"四川"],
            ["id"=>3,"p_id"=>1,"layer"=>1,"name"=>"北京"],
            ["id"=>4,"p_id"=>2,"layer"=>2,"name"=>"成都"],
            ["id"=>5,"p_id"=>2,"layer"=>2,"name"=>"绵阳"]
        ]);

        $sql = <<<EOF
CREATE FUNCTION `dendrogramAdjacencyGetChildren`(rootId INT)
RETURNS LONGTEXT

BEGIN
DECLARE sTemp LONGTEXT;
DECLARE sTempChd LONGTEXT;

SET sTemp = '';
SET sTempChd =cast(rootId as CHAR);

WHILE sTempChd is not null DO
SET sTemp = concat(sTemp,',',sTempChd);
SELECT group_concat(id) INTO sTempChd FROM $table where FIND_IN_SET(p_id,sTempChd)>0;
END WHILE;
RETURN sTemp;
END
EOF;
        \Illuminate\Support\Facades\DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = config('dendrogram.adjacency_table','dendrogram_adjacency');
        Schema::dropIfExists($table);
    }
}
