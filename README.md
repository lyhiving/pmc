PHP MongoDB Club
======================

学习MongoDB，练习之作。


##开发环境:   
Apache/2.2.14  
MongoDB v2.0.5  
PHP 5.3.1  
MongoDB Support 1.2.10

##配置 ：
###app/config.php   
 
// 网站地址
define("BASE_PATH", "http://localhost");  
// 网站目录
define("APP_PATH", "");  //二级目录请填写，例子：define("APP_PATH", "/pmc");

其他的配置 看文件注释！

###.htaccess

RewriteEngine On  
RewriteBase /pmc // 网站根目录请删除本行，二级目录跟APP_PATH一样  
RewriteCond %{REQUEST_FILENAME} !-f   
RewriteCond %{REQUEST_FILENAME} !-d  
RewriteRule ^(.*)$ index.php/$1 [L]  

*第一个注册用户拥有管理权限！*

**学习交流之用，请勿正式建站！**
[http://www.lapland.name](http://www.lapland.name)

