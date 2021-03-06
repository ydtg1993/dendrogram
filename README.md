<h3 align="center">PHP系统树图</h3>

<p align="center">
<a href="https://github.com/ydtg1993/dendrogram"><img src="https://img.shields.io/badge/dendrogram-v2.0-orange.svg" alt="v2.0"></a>
<a href="https://github.com/ydtg1993/dendrogram"><img src="https://img.shields.io/badge/laravel-5.*-yellow.svg" alt="laravel 5.*"></a>
<a href="https://github.com/ydtg1993/dendrogram"><img src="https://img.shields.io/badge/PHP-%3E%3D5.6-blue.svg" alt="PHP>=5.6"></a>
</p>

    PHP系统树图可快速的处理无限极分类的业务需求 提供两种不同的数据结构和三种视图类型
    
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
        <td style="text-align:left;">下拉列表 select</td>
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

##### 生成对象
        /*adjacency list数据结构*/
        new DenDroGram(AdjacencyList::class)
        
        /*nested set数据结构*/
        new DenDroGram(NestedSet::class)

##### 调用方法
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
            <td style="text-align:left;">根节点id <br/>操作节点的路由POST方式 <br/>节点显示字段</td>
            <td style="text-align:left;">html文本</td>
        </tr>
        <tr>
            <td style="text-align:left;">buildRhizome</td>
            <td style="text-align:left;">生成根茎视图</td>
            <td style="text-align:left;">根节点id <br/>修改节点路由[POST]<br/>节点显示字段</td>
            <td style="text-align:left;">html文本</td>
        </tr>
        <tr>
            <td style="text-align:left;">buildSelect</td>
            <td style="text-align:left;">生成下拉列表</td>
            <td style="text-align:left;">根节点id <br/>列表选项显示字段 <br/>列表选项值 <br/>列表选项默认值</td>
            <td style="text-align:left;">html文本 <br/>获取选项结果可在js中调用dendrogramUS.storage() 
                <br/>点击选项回调方法dendrogramUS.callback()</td>
        </tr>
        <tr>
            <td style="text-align:left;">operateNode</td>
            <td style="text-align:left;">节点操作</td>
            <td style="text-align:left;">action增删改标识 [add添加 update修改 delete删除]<br/>data节点post传参</td>
            <td style="text-align:left;">返回boolean</td>
        </tr>
        <tr>
            <td style="text-align:left;">getTreeData</td>
            <td style="text-align:left;">获取结构型数据</td>
            <td style="text-align:left;">根节点id</td>
            <td style="text-align:left;">返回array</td>
        </tr>
    </tbody>
</table>

##### 获取数据
![example](https://github.com/ydtg1993/dendrogram/blob/master/image/data.png)

