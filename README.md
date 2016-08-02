# API服务端架构代码

[TOC]

## 部署说明

### 说明

> 现有API基于laravel框架开发，本次介绍也针对laravel。可根据文档自行调整，以适用其他框架下使用

### 数据库相关

执行如下SQL语句

```sql
CREATE TABLE `prefix_apps` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增长',
  `app_id` varchar(60) NOT NULL COMMENT 'appid',
  `app_secret` varchar(100) NOT NULL COMMENT '密钥',
  `app_name` varchar(200) NOT NULL COMMENT 'app名称',
  `app_desc` text COMMENT '描述',
  `status` tinyint(2) DEFAULT '0' COMMENT '生效状态',
  `created_at` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `app_id` (`app_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='应用表';
```

### 目录相关



## API文档及开发规范

### API调用协议

#### 请求地址及请求方式

> 请求地址：`/api/router`;
> 请求方式：`POST`/`GET`

#### 公共参数

|参数名|类型|是否必须|描述|
|----|----|----|----|
|app_id|string|是|应用ID|
|method|string|是|接口名称|
|format|string|否|回调格式，默认：json（目前仅支持）|
|sign_method|string|否|签名类型，默认：md5（目前仅支持）|
|nonce|string|是|随机字符串，长度1-32位任意字符|
|sign|string|是|签名字符串，参考[签名规则](#签名规则)|

#### 业务参数

> API调用除了必须包含公共参数外，如果API本身有业务级的参数也必须传入，每个API的业务级参数请考API文档说明。

#### 签名规则

- 对所有API请求参数（包括公共参数和请求参数，但除去`sign`参数），根据参数名称的ASCII码表的顺序排序。如：`foo=1, bar=2, foo_bar=3, foobar=4`排序后的顺序是`bar=2, foo=1, foo_bar=3, foobar=4`。
- 将排序好的参数名和参数值拼装在一起，根据上面的示例得到的结果为：bar2foo1foo_bar3foobar4。
- 把拼装好的字符串采用utf-8编码，使用签名算法对编码后的字节流进行摘要。如果使用`MD5`算法，则需要在拼装的字符串前后加上app的`secret`后，再进行摘要，如：md5(secret+bar2foo1foo_bar3foobar4+secret)
- 将摘要得到的字节结果使用大写表示

#### 返回结果

```json
// 成功
{
    
}
```