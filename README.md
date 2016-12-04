# CI_Shop_Project

![](https://img.shields.io/badge/Shop-develop-green.svg)
&nbsp;&nbsp;
![](https://img.shields.io/badge/Codeigniter-PHP-blue.svg)
<br><br>
使用Codeigniter开发的一套商城系统

## 目录介绍

* application：项目应用目录，存放前后台的模型，控制器，视图以及相关配置信息，值得一提的是扩展了CI的核心类，类库和函数库。

 * config：项目的配置文件夹，包括自动加载配置，url路由设置，常量设置，数据库配置等。

 * controller： 控制器目录，前台控制器在admin文件夹下，后台控制器在当前文件夹下

 * models：模型目录，前后台共用一套模型完成对数据库的增删改查操作。

 * views：视图目录，这里只存放后台视图文件，前台视图文件在根目录下的themes文件夹中

 * core：扩展CI的核心类，里面包含三个类，加载器类，前台控制器类和后台控制器类。

 * libraries：扩展CI的类库，里面包含一个扩展的分页类，使界面显示更加友好。

 * helpers：扩展CI的函数库，里面包含一个扩展的验证码辅助函数，使验证码工作效率更高。

 * language：项目语言包文件，在此文件夹中导入了中文语言包。

* system：CI框架的系统文件夹，为了框架系统稳定运行，依据官方文档，此文件夹不做任何修改。

* public：公共资源文件夹，此文件夹下存放前台css，js，images资源便于CI框架进行访问和使用。同时引入了文本编辑器fckeditor，并把用户上传的文件保存至uploads文件夹下。

* themes：前台视图文件夹，此文件夹下存放前台视图，并将视图分主题存放，支持网页更换主题功能。

* index.php：CI框架入口文件，注意是单入口。

* db.sql：数据库导出文件，部署应用前应导入到自己的数据库中。

## 项目链接

* [ecshop官方论坛](http://www.ecshop.com)

* [Codeigniter中国社区](http://codeigniter.org.cn)
