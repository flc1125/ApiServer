# API服务端架构代码

[TOC]

## 1. 部署说明

> 现有API基于laravel框架开发，本次介绍也针对laravel。可根据文档自行调整，以适用其他框架下使用

### 1.1. 数据库相关

执行如下SQL语句

```sql
CREATE TABLE `prefix_apps` (
  `id` INT(10) NOT NULL AUTO_INCREMENT COMMENT '自增长',
  `app_id` VARCHAR(60) NOT NULL COMMENT 'appid',
  `app_secret` VARCHAR(100) NOT NULL COMMENT '密钥',
  `app_name` VARCHAR(200) NOT NULL COMMENT 'app名称',
  `app_desc` TEXT COMMENT '描述',
  `status` TINYINT(2) DEFAULT '0' COMMENT '生效状态',
  `created_at` INT(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` INT(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `app_id` (`app_id`),
  KEY `status` (`status`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT='应用表';
```

### 1.2. 目录相关

|标题|路径|
|----|----|
|API核心目录|`app/Services/ApiServer/`|
|API接口目录|`app/Services/ApiServer/Response/`|
|apps数据库模型|`app/Models/App.php`|
|路由配置|`app/Http/routes.php`|
|API入口控制器|`app/Http/Controllers/Api/RouterController.php`|

## 2. API文档及开发规范

### 2.1. API调用协议

#### 2.1.1. 请求地址及请求方式

> 请求地址：`/api/router`;
>
> 请求方式：`POST`/`GET`

#### 2.1.2. 公共参数

|参数名|类型|是否必须|描述|
|----|----|----|----|
|app_id|string|是|应用ID|
|method|string|是|接口名称|
|format|string|否|回调格式，默认：json（目前仅支持）|
|sign_method|string|否|签名类型，默认：md5（目前仅支持）|
|nonce|string|是|随机字符串，长度1-32位任意字符|
|sign|string|是|签名字符串，参考[签名规则](#签名规则)|

#### 2.1.3. 业务参数

> API调用除了必须包含公共参数外，如果API本身有业务级的参数也必须传入，每个API的业务级参数请考API文档说明。

#### 2.1.4. 签名规则

- 对所有API请求参数（包括公共参数和请求参数，但除去`sign`参数），根据参数名称的ASCII码表的顺序排序。如：`foo=1, bar=2, foo_bar=3, foobar=4`排序后的顺序是`bar=2, foo=1, foo_bar=3, foobar=4`。
- 将排序好的参数名和参数值拼装在一起，根据上面的示例得到的结果为：bar2foo1foo_bar3foobar4。
- 把拼装好的字符串采用utf-8编码，使用签名算法对编码后的字节流进行摘要。如果使用`MD5`算法，则需要在拼装的字符串前后加上app的`secret`后，再进行摘要，如：md5(secret+bar2foo1foo_bar3foobar4+secret)
- 将摘要得到的字节结果使用大写表示

#### 2.1.5. 返回结果

```json
// 成功
{
    "status": true,
    "code": "200",
    "msg": "成功",
    "data": {
        "time": "2016-08-02 12:07:09"
    }
}

// 失败
{
    "status": false,
    "code": "1001",
    "msg": "[app_id]缺失"
}
```

### 2.2. API开发规范

#### 2.2.1. API接口命名规范（method）

- 接口名称统一小写字母
- 多单词用`.`隔开
- 对应的类文件（目录：`app/Services/ApiServer/Response/`）；以接口名去`.`，再首字母大写作为类名及文件名。如接口名：`user.add`，对应的类文件及类名为：`UserAdd`
- 接口命名规范
    - 命名字母按功能或模块从大到小划分，依次编写；如后台用户修改密码：'admin.user.password.update'
    - 字母最后单词为操作。查询:`get`;新增:`add`;更新:`update`;删除:`delete`;上传:`upload`;等

#### 2.2.2. 错误码

> 错误码配置：`app/Services/ApiServer/Error.php`

命名规范：

|类型|长度|说明|
|----|----|----|
|系统码|3|同`http状态码`|
|公共错误码|4|公共参数错误相关的错误码|
|业务错误码|6+|2位业务码+4位错误码，不足补位|

现有错误码：

|错误码|错误内容|
|----|----|
|200|成功|
|400|未知错误|
|401|无此权限|
|500|服务器异常|
|1001|[app_id]缺失|
|1002|[app_id]不存在或无权限|
|1003|[method]缺失|
|1004|[format]错误|
|1005|[sign_method]错误|
|1006|[sign]缺失|
|1007|[sign]签名错误|
|1008|[method]方法不存在|
|1009|run方法不存在，请联系管理员|
|1010|[nonce]缺失|
|1011|[nonce]必须为字符串|
|1012|[nonce]长度必须为1-32位|

#### 2.2.3. API DEMO 示例

文件路径：`app/Services/ApiServer/Response/Demo.php`