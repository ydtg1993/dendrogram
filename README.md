<h3 align="center">PHP系统树图</h3>

<p align="center">
<a href="https://github.com/ydtg1993/dendrogram"><img src="https://img.shields.io/badge/dendrogram-v2.0-orange.svg" alt="v2.0"></a>
<a href="https://github.com/ydtg1993/dendrogram"><img src="https://img.shields.io/badge/laravel-5.*-yellow.svg" alt="laravel 5.*"></a>
<a href="https://github.com/ydtg1993/dendrogram"><img src="https://img.shields.io/badge/PHP-%3E%3D5.6-blue.svg" alt="PHP>=5.6"></a>
</p>

    PHP系统树图可快速的处理无限极分类的业务需求 提供两种不同的数据结构和三种视图类型
    
    2.1：
        1.版本修复级联选择器展示图标bug
        2.buildCatalog buildRhizome buildSelect getTreeData 方法增加数据缓存 默认：-1不缓存 0永久缓存 0>缓存n秒
    
<table> 
    <tr>
        <th style="text-align:center;">数据结构</th>
        <td style="text-align:left;">adjacency list</td>
        <td style="text-align:left;">nested sets</td>
    </tr>
    <tr>
        <th style="text-align:left;">视图类型</td>
        <td style="text-align:left;">目录 catalog</td>
        <td style="text-align:left;">茎状 rhizome</td>
        <td style="text-align:left;">级联下拉列表 select</td>
    </tr>
</table>

![example](https://github.com/ydtg1993/dendrogram/blob/master/image/view.png)
![example](https://github.com/ydtg1993/dendrogram/blob/master/image/select.png)

### 1.安装
`composer require dendrogram/dendrogram:v2.0`

### 2.配置
首先往Laravel应用中注册ServiceProvider，打开文件config/app.php，在providers中添加一项：

    'providers' => [
        DenDroGram\DendrogramServiceProvider::class
    ]

### 3.发布
然后发布拓展包的配置文件，使用如下命令：

`php artisan vendor:publish`

    会在config目录下会生成dendrogram.php的配置文件

### 4.数据导入
`php artisan migrate`

    两表四个自定义函数 表名可先行在配置文件中修改.以保持与自定义函数内的表名一致
    
    migrations下增加中国城市sql文件
    由于查询节点过多需要配置mysql
    SET GLOBAL group_concat_max_len = 20460;
    

### 数据结构概述

##### adjacency结构 以父节点为基准的链式查询 增删容易 查询不便

![config](https://github.com/ydtg1993/dendrogram/blob/master/image/adjacency.png)

##### nested结构 以左右值包容形式 增删不便 查询容易

![config](https://github.com/ydtg1993/dendrogram/blob/master/image/nested.png)

### code说明

##### 1.生成对象
        /*adjacency list数据结构*/
        new DenDroGram(AdjacencyList::class)
        
        /*nested set数据结构*/
        new DenDroGram(NestedSet::class)
        
        两种不同数据结构分别对应两张表，请根据实际业务场景选择
##### 2.调用方法
<table>
    <thead>
        <tr>
            <th style="text-align:center;">调用方法</th>
            <th style="text-align:left;">方法说明</th>
            <th style="text-align:left;">方法参数</th>
            <th style="text-align:left;">返回内容</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align:left;">buildCatalog</td>
            <td style="text-align:left;">生成目录式结构树</td>
            <td style="text-align:left;"><b>id</b>:根节点id <br/><b>router</b>: 修改节点数据路由[POST方式] <br/><b>column</b>: 节点展示记录字段名<br/><b>cache</b>: 缓存时间</td>
            <td style="text-align:left;">html文本</td>
        </tr>
        <tr>
            <td style="text-align:left;">buildRhizome</td>
            <td style="text-align:left;">生成根茎视图</td>
            <td style="text-align:left;"><b>id</b>: 根节点id <br/><b>router</b>: 修改节点数据路由[POST方式] <br/><b>column</b>: 节点展示记录字段名<br/><b>cache</b>: 缓存时间</td>
            <td style="text-align:left;">html文本</td>
        </tr>
        <tr>
            <td style="text-align:left;">buildSelect</td>
            <td style="text-align:left;">生成下拉列表</td>
            <td style="text-align:left;"><b>id</b>: 根节点id 根节点id <br/><b>label</b>: 列表选项显示值(记录字段名) <br/><b>value</b>: 列表选项值(记录字段名) <br/><b>default </b>: 列表选项默认值(级联数组对应值) <br/><b>cache</b>: 缓存时间 -1不缓存 0永久缓存 0>缓存n秒</td>
            <td style="text-align:left;">html文本 <br/>获取选项结果可在js中调用dendrogramUS.storage() 
                <br/>点击选项回调方法dendrogramUS.callback()</td>
        </tr>
        <tr>
            <td style="text-align:left;">operateNode</td>
            <td style="text-align:left;">节点操作</td>
            <td style="text-align:left;"><b>action</b>: 增删改标识 [添加记录:add 修改: update 删除: delete]<br/><b>data</b>: 修改节点记录的传参[post方式]</td>
            <td style="text-align:left;">返回boolean</td>
        </tr>
        <tr>
            <td style="text-align:left;">getTreeData</td>
            <td style="text-align:left;">获取结构型数据</td>
            <td style="text-align:left;"><b>id</b>: 根节点id <br/><b>cache</b>: 缓存时间 [-1不缓存 0永久缓存 0>缓存n秒]</td>
            <td style="text-align:left;">返回array</td>
        </tr>
    </tbody>
</table>

```
可参考test目录下面的测试样例
```

##### 获取数据
![example](https://github.com/ydtg1993/dendrogram/blob/master/image/data.png)

