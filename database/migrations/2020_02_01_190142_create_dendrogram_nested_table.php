<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDendrogramNestedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = config('dendrogram.nested_table','dendrogram_nested');
        Schema::create($table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('节点名称');
            $table->integer('left')->default(0)->comment('左值');
            $table->integer('right')->default(0)->comment('右值');
            $table->integer('layer')->default(0)->comment('层级');
            $table->integer('sort')->default(0)->comment('排序 同级有效');
        });

        \Illuminate\Support\Facades\DB::table($table)->insert([
            ["id"=>1,"left"=>1,"right"=>22,"layer"=>0,"name"=>"衣服"],
            ["id"=>2,"left"=>2,"right"=>9,"layer"=>1,"name"=>"男衣"],
            ["id"=>3,"left"=>10,"right"=>21,"layer"=>1,"name"=>"女衣"],
            ["id"=>4,"left"=>3,"right"=>8,"layer"=>2,"name"=>"正装"],
            ["id"=>5,"left"=>4,"right"=>5,"layer"=>3,"name"=>"衬衫"],
            ["id"=>6,"left"=>6,"right"=>7,"layer"=>3,"name"=>"夹克"],
            ["id"=>7,"left"=>11,"right"=>16,"layer"=>2,"name"=>"裙子"],
            ["id"=>8,"left"=>17,"right"=>18,"layer"=>2,"name"=>"短裙"],
            ["id"=>9,"left"=>19,"right"=>20,"layer"=>2,"name"=>"开衫"],
        ]);

        $sql = <<<EOF
CREATE FUNCTION `dendrogramNestedIncrement`(pId INT)
RETURNS INT

BEGIN
	DECLARE lft,rgt int;
	SET lft = 0;
	SET rgt = 0;
	SELECT `left`,`right` INTO lft,rgt FROM $table WHERE id = pId;
	UPDATE $table SET `left`=`left`+2,`right`=`right`+2 WHERE `left` > rgt;
	UPDATE $table SET `right`=`right`+2 WHERE `right`>= rgt AND `left` <= lft;
RETURN rgt;
END
EOF;
        \Illuminate\Support\Facades\DB::unprepared($sql);

        $sql = <<<EOF
CREATE FUNCTION `dendrogramNestedReduction`(distance INT,lft INT ,rgt INT)
RETURNS INT

BEGIN
	UPDATE $table SET `right`=`right` - distance WHERE `right` > rgt AND `left` < lft;
	UPDATE $table SET `left`=`left` - distance,`right`=`right` - distance WHERE `left` > rgt;
RETURN rgt;
END
EOF;
        \Illuminate\Support\Facades\DB::unprepared($sql);

        $sql = <<<EOF
CREATE FUNCTION `dendrogramNestedLayer`(pId INT)
RETURNS INT

BEGIN
	DECLARE result,lft,rgt int default 0;
	IF EXISTS (SELECT 1 FROM $table WHERE id=pId) THEN BEGIN
	SELECT `left`, `right` INTO lft, rgt FROM $table WHERE id=pId;
	SELECT count(*) INTO result FROM $table WHERE `left` <= lft and `right` >= rgt;
	return result;END;
	END IF;
	RETURN 0;
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
        $table = config('dendrogram.nested_table','dendrogram_nested');
        Schema::dropIfExists($table);
    }
}
