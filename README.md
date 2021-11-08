<h3 align="center">PHP系统树图</h3>

<p align="center">
<a href="https://github.com/ydtg1993/dendrogram"><img src="https://img.shields.io/badge/dendrogram-v2.0-orange.svg" alt="v2.0"></a>
<a href="https://github.com/ydtg1993/dendrogram"><img src="https://img.shields.io/badge/laravel-5.*-yellow.svg" alt="laravel 5.*"></a>
<a href="https://github.com/ydtg1993/dendrogram"><img src="https://img.shields.io/badge/PHP-%3E%3D5.6-blue.svg" alt="PHP>=5.6"></a>
</p>

    PHP系统树图可快速的处理无限极分类的业务需求 提供两种不同的数据结构和三种视图类型
    
    2.1：
        1.版本修视图图标bug
        2.视图 方法名称修改 buildCatalog buildRhizome ==》 buildHorizontal buildVertical
        3.buildHorizontal buildVertical buildSelect getTreeData 方法增加数据缓存 默认：-1不缓存 0永久缓存 0>缓存n秒
        4.视图路由参数router变更为非必要  传递router路由参数视图会自动绑定点击节点修改,增加按钮时的弹窗表单
        5.可绑定的按钮事件 节点标签按钮dendrogram.bindClassEnvent('dendrogram-tab',事件,回调方法) 节点新增按钮dendrogram.bindClassEnvent('dendrogram-grow',事件,回调方法)
        6.弹窗增加可自定义配置项dendrogram.form.settings 
<table> 
    <tr>
        <th style="text-align:center;">数据结构</th>
        <td style="text-align:left;">adjacency list</td>
        <td style="text-align:left;">nested sets</td>
    </tr>
    <tr>
        <th style="text-align:left;">视图类型</td>
        <td style="text-align:left;">横向视图 Horizontal</td>
        <td style="text-align:left;">竖向视图 Vertical</td>
        <td style="text-align:left;">级联下拉列表 select</td>
    </tr>
</table>

![example](https://github.com/ydtg1993/dendrogram/blob/master/image/view.png)
![example](https://github.com/ydtg1993/dendrogram/blob/master/image/select.png)

### 1.安装
`composer require dendrogram/dendrogram:v2.1`

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
            <td style="text-align:left;">buildHorizontal</td>
            <td style="text-align:left;">生成横向视图</td>
            <td style="text-align:left;"><b>id</b>:根节点id <br/><b>column</b>: 节点展示记录字段名<br/><b>cache</b>: 缓存时间 [开发目录权限chmod -R 0777 vendor/dendrogram/]<br/><b>router</b>: 修改节点数据路由[POST方式] </td>
            <td style="text-align:left;"><b>html文本</b></br><i>如果没有传递router路由参数不会自动绑定点击节点修改,增加按钮时的弹窗表单</i><hr/>自定义js代码块</br><i>绑定事件到节点的标签tab,添加按钮grow：dendrogram.bindClassEnvent('dendrogram-tab',事件,回调方法)</br> dendrogram.bindClassEnvent('dendrogram-grow',事件,回调方法)</i><br/><br/><i>可以对表单内容自定义的设置：dendrogram.form.settings</i><br/>
         <br/>* settings结构为数组对象： [setting,setting,...]
         <br/>* 输入框setting 普通对象：
         <br/>* {    column:记录列明 必填,
         <br/>*      label:输入框标签 选填,
         <br/>*      type:输入框类型 选填,
         <br/>*      attribute:输入框属性参数 选填,
         <br/>*      options:当类setting的类型type为radio或者checkbox时的选项参数 选填
         <br/>* }
         <br/>*
         <br/>* setting中 type类型：text textarea hidden disable radio checkbox 默认text
         <br/>* options结构为数组对象 [] option为普通对象 {label:选项标签 必填,value:选项值 必填}
            </td>
        </tr>
        <tr>
            <td style="text-align:left;">buildVertical</td>
            <td style="text-align:left;">生成竖向视图</td>
            <td style="text-align:left;"><b>id</b>: 根节点id <br/><b>column</b>: 节点展示记录字段名<br/><b>cache</b>: 缓存时间 <br/><b>router</b>: 修改节点数据路由[POST方式] </td>
            <td style="text-align:left;"><b>同上 可参考test目录下的expamle样例</b></td>
        </tr>
        <tr>
            <td style="text-align:left;">buildSelect</td>
            <td style="text-align:left;">生成级联下拉列表</td>
            <td style="text-align:left;"><b>id</b>: 根节点id 根节点id <br/><b>label</b>: 列表选项显示值(记录字段名) <br/><b>value</b>: 列表选项值(记录字段名) <br/><b>default </b>: 列表选项默认值(级联数组对应值) <br/><b>cache</b>: 缓存时间 -1不缓存 0永久缓存 0>缓存n秒</td>
            <td style="text-align:left;"><b>html文本</b><br/><i>获取选项结果事件的值：js中调用dendrogramUS.storage()获取选择结果值的数组</i> 
                <br/><i>点击选项事件回调方法：js中调用dendrogramUS.callback = function(){}</i></td>
        </tr>
        <tr>
            <td style="text-align:left;">operateNode</td>
            <td style="text-align:left;">节点操作</td>
            <td style="text-align:left;"><b>action</b>: 增删改标识 [添加记录:add 修改: update 删除: delete]<br/><b>data</b>: 修改节点记录的传参[post方式]</td>
    <td style="text-align:left;"><b>boolean</b></td>
        </tr>
        <tr>
            <td style="text-align:left;">getTreeData</td>
            <td style="text-align:left;">获取结构型数据</td>
            <td style="text-align:left;"><b>id</b>: 根节点id <br/><b>cache</b>: 缓存时间 [-1不缓存 0永久缓存 0>缓存n秒]</td>
            <td style="text-align:left;"><b>array</b></td>
        </tr>
    </tbody>
</table>

```
可参考test目录下面的测试样例
```

##### 获取数据
![example](https://github.com/ydtg1993/dendrogram/blob/master/image/data.png)

