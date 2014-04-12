<?php

// 以下为内部返回码定义
// 角色定义
define('Role_Shop', 101);
define('Role_User', 102);
define('Role_Ant', 103);

define('SYS_BUSY', '-1'); // 系统繁忙
define('STATUS_SUCCESS', '0'); // 请求成功

define('ILLIGAL_TOKEN', '40001'); // 获取access_token时AppSecret错误，或者access_token无效
define('ILLEGAL_TICKET', '40002'); // 不合法的凭证类型
define('ILLEGAL_OPENID', '40003'); // 不合法的OpenID
define('ILLIGAL_MEDIA', '40004'); // 不合法的媒体文件类型
define('ILLIGAL_FILE_TYPE', '40005'); // 不合法的文件类型
define('ILLIGAL_FILE_SIZE', '40006'); // 不合法的文件大小
define('ILLIGAL_MEDIAID', '40007'); // 不合法的媒体文件id
define('ILLIGAL_MSG_TYPE', '40008'); // 不合法的消息类型
define('ILLIGAL_PIC_SIZE', '40009'); // 不合法的图片文件大小
define('ILLIGAL_VOR_SIZE', '40010'); // 不合法的语音文件大小
define('ILLIGAL_VOD_SIZE', '40011'); // 不合法的视频文件大小
define('ILLIGAL_TUB_SIZE', '40012'); // 不合法的缩略图文件大小
define('ILLIGAL_APPID', '40013'); // 不合法的APPID
define('ILLIGAL_ACCESSTOKEN', '40014'); // 不合法的access_token
define('ILLIGAL_MENU_TYPE', '40015'); // 不合法的菜单类型
define('ILLIGAL_BUTT_NUM1', '40016'); // 不合法的按钮个数
define('ILLIGAL_BUTT_NUM2', '40017'); // 不合法的按钮个数
define('ILLIGAL_BUTT_NAME', '40018'); // 不合法的按钮名字长度
define('ILLIGAL_BUTT_KEY', '40019'); // 不合法的按钮KEY长度
define('ILLIGAL_BUTT_URL', '40020'); // 不合法的按钮URL长度
define('ILLIGAL_MENU_VER', '40021'); // 不合法的菜单版本号
define('ILLIGAL_SUBMENU', '40022'); // 不合法的子菜单级数
define('ILLIGAL_SUBBUTTNUM', '40023'); // 不合法的子菜单按钮个数
define('ILLIGAL_SUBBUTTTYPE', '40024'); // 不合法的子菜单按钮类型
define('ILLIGAL_SUBBUTTNAME', '40025'); // 不合法的子菜单按钮名字长度
define('ILLIGAL_SUBBUTTKEY', '40026'); // 不合法的子菜单按钮KEY长度
define('ILLIGAL_SUBBUTTURL', '40027'); // 不合法的子菜单按钮URL长度
define('ILLIGAL_MENUUSER', '40028'); // 不合法的自定义菜单使用用户
define('ILLIGAL_OAUTH', '40029'); // 不合法的oauth_code
define('ILLIGAL_REFRESHTOKEN', '40030'); // 不合法的refresh_token
define('ILLIGAL_OPENIDLIST', '40031'); // 不合法的openid列表
define('ILLIGAL_LISTLONG', '40032'); // 不合法的openid列表长度
define('ILLIGAL_CHARSET', '40033'); // 不合法的请求字符，不能包含\uxxxx格式的字符
define('ILLIGAL_PARA', '40035'); // 不合法的参数
define('ILLIGAL_FORMAT', '40038'); // 不合法的请求格式
define('ILLIGAL_URLSIZE', '40039'); // 不合法的URL长度
define('ILLIGAL_GROUPID', '40050'); // 不合法的分组id
define('ILLIGAL_GROUPNAME', '40051'); // 分组名字不合法

define('NO_TOKEN_PARA', '41001'); // 缺少access_token参数
define('NO_APPID_PARA', '41002'); // 缺少appid参数
define('NO_REFERSH_PARA', '41003'); // 缺少refresh_token参数
define('NO_SECRET_PARA', '41004'); // 缺少secret参数
define('NO_MEDIA_CONTENT', '41005'); // 缺少多媒体文件数据
define('NO_MEDIAID_PARA', '41006'); // 缺少media_id参数
define('NO_SUBMENU_CONTENT', '41007'); // 缺少子菜单数据
define('NO_AUTH_CODE', '41008'); // 缺少oauth code
define('NO_OPENOID', '41009'); // 缺少openid
define('NO_ORDER_ID', '41010'); // 缺少openid
define('NO_JSON_KEY', '41011' );//缺少必要的json键值

define('TIMEOUT_ACCESS_TOKEN', '42001'); // access_token超时
define('TIMEOUT_REFRESH_TOKEN', '42002'); // refresh_token超时
define('TIMEOUT_OAUTH_CODE', '42003'); // oauth_code超时

define('NEED_GET', '43001'); // 需要GET请求
define('NEED_POST', '43002'); // 需要POST请求
define('NEED_HTTPS', '43003'); // 需要HTTPS请求
define('NEED_RECEIVR_FOLLOW', '43004'); // 需要接收者关注
define('NEED_FRIEND_RELATION', '43005'); // 需要好友关系

define('EMPTY_MEDIA_FILE', '44001'); // 多媒体文件为空
define('EMPTY_POST_CONTENT', '44002'); // POST的数据包为空
define('EMPTY_NEWS', '44003'); // 图文消息内容为空
define('EMPTY_TEXT', '44004'); // 文本消息内容为空

define('LIMIT_MEDIA_SIZE', '45001'); // 多媒体文件大小超过限制
define('LIMIT_MSG_CONTENT', '45002'); // 消息内容超过限制
define('LIMIT_TITLE_CONTENT', '45003'); // 标题字段超过限制
define('LIMIT_DESC_CONTENT', '45004'); // 描述字段超过限制
define('LIMIT_URL_CONTENT', '45005'); // 链接字段超过限制
define('LIMIT_PICURL_CONTENT', '45006'); // 图片链接字段超过限制
define('LIMIT_VOR_TIME', '45007'); // 语音播放时间超过限制
define('LIMIT_NEWS_CONTENT', '45008'); // 图文消息超过限制
define('LIMIT_API_ACCESS', '45009'); // 接口调用超过限制
define('LIMIT_MENU_NUM', '45010'); // 创建菜单个数超过限制
define('LIMIT_REPLY_TIME', '45015'); // 回复时间超过限制
define('LIMIT_SYS_GROUP', '45016'); // 系统分组，不允许修改
define('LIMIT_GROUP_NAME', '45017'); // 分组名字过长
define('LIMIT_GROUP_NUM', '45018'); // 分组数量超过上限

define('UNAVAIL_MEDIA_CONTENT', '46001'); // 不存在媒体数据
define('UNAVAIL_MENU_VER', '46002'); // 不存在的菜单版本
define('UNAVAIL_MENU_CONTENT', '46003'); // 不存在的菜单数据
define('UNAVAIL_USER', '46004'); // 不存在的用户
define('UNAVAIL_NEW_ORDER', '46005'); // 不允许新订单

define('ERROR_CONTENT', '47001'); // 解析JSON/XML内容错误
define('NO_ACCESS_TO_FUNC', '48001'); // api功能未授权
define('NO_ACCESS_TO_API', '50001'); // 用户未授权该api

?>