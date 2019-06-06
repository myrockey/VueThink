DROP TABLE IF EXISTS `es_picture`;
CREATE TABLE `es_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id自增',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '图片名称',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片链接',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='图片表';

DROP TABLE IF EXISTS `es_readtime`;
CREATE TABLE IF NOT EXISTS `es_readtime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态2表示已读',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='消息已读表';

DROP TABLE IF EXISTS `es_driver`;
CREATE TABLE `es_driver` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `service_name` varchar(40) NOT NULL DEFAULT '' COMMENT '服务标识',
  `driver_name` varchar(20) NOT NULL DEFAULT '' COMMENT '驱动标识',
  `config` text NOT NULL COMMENT '配置',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='插件表';

DROP TABLE IF EXISTS `es_file`;
CREATE TABLE `es_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `savename` varchar(100) NOT NULL DEFAULT '' COMMENT '保存名称',
  `savepath` varchar(255) NOT NULL DEFAULT '' COMMENT '文件保存路径',
  `ext` char(10) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mime` char(50) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '远程地址',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文件表';



DROP TABLE IF EXISTS `es_hook`;
CREATE TABLE `es_hook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `describe` varchar(255) NOT NULL COMMENT '描述',
  `addon_list` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子挂载的插件 ''，''分割',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='钩子表';


INSERT INTO `es_hook` VALUES ('28', 'ArticleEditor', '富文本编辑器', 'Editor', '1', '0', '0');
INSERT INTO `es_hook` VALUES ('29', 'ImgUpload', '图片上传钩子', 'Imginput', '1', '0', '0');

DROP TABLE IF EXISTS `es_addon`;
CREATE TABLE `es_addon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '插件名或标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '中文名称',
  `describe` varchar(255) NOT NULL DEFAULT '' COMMENT '插件描述',
  `config` text NOT NULL COMMENT '配置',
  `author` varchar(40) NOT NULL DEFAULT '' COMMENT '作者',
  `version` varchar(20) NOT NULL DEFAULT '' COMMENT '版本号',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `has_adminlist` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='插件表';

INSERT INTO `es_addon` VALUES(27, 'Editor', '文本编辑器', '富文本编辑器', '{"editor_resize_type":"1","editor_height":"300px"}', 'Bigotry', '1.0', 1, 0, 1502868284, 1502868284);
INSERT INTO `es_addon` VALUES(28, 'Imginput', '图片上传', '图片上传插件，可支持拖动图片及批量上传', '', 'Bigotry', '1.0', 1, 0, 1502868284, 1502868284);


DROP TABLE IF EXISTS `es_usergrade`;
CREATE TABLE IF NOT EXISTS `es_usergrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '名称',
  `score` int(11) NOT NULL COMMENT '等级所需积分',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='会员等级表';

DROP TABLE IF EXISTS `es_user`;
CREATE TABLE IF NOT EXISTS `es_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `point` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `expoint1` int(11) DEFAULT '0' COMMENT '扩展积分1',
  `expoint2` int(11) DEFAULT '0' COMMENT '扩展积分2',
  `expoint3` int(11) DEFAULT '0' COMMENT '扩展积分3',
  `userip` varchar(32) NOT NULL COMMENT 'IP',
  `nickname` char(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `username` varchar(32) NOT NULL COMMENT '名称',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `userhead` varchar(100) DEFAULT '/public/images/default.png' COMMENT '头像',
  `usermail` varchar(32) NOT NULL COMMENT '邮箱',
  `mobile` varchar(11) DEFAULT '' COMMENT '手机',
  `regtime` varchar(32) NOT NULL COMMENT '注册时间',
  `grades` tinyint(1) NOT NULL DEFAULT '0' COMMENT '等级',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '验证1表示正常2邮箱验证3手机认证5手机邮箱全部认证',
  `userhome` varchar(32) DEFAULT NULL COMMENT '家乡',
  `statusdes` varchar(200) DEFAULT NULL COMMENT '描述',
  `description` varchar(200) DEFAULT NULL COMMENT '描述',
  `last_login_time` varchar(20) DEFAULT '0' COMMENT '最后登陆时间',
  `last_login_ip` varchar(50) DEFAULT '' COMMENT '最后登录IP',
  `salt` varchar(20) DEFAULT NULL COMMENT 'salt',
  `leader_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '上级会员ID',
  `is_share_member` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否共享会员',
  `is_inside` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为后台使用者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE,
  UNIQUE KEY `usermail` (`usermail`) USING BTREE
)ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

INSERT INTO `es_user` VALUES
(1, 0, 0, 0, 0, '127.0.0.1', 'admin', 'admin', '0dfc7612f607db6c17fd99388e9e5f9c', '/public/images/default.png', 'admin@admin.com', '', '1496145982', 0, 0, 1, NULL, NULL, NULL,'1500629119', '127.0.0.1', '1dFlxLhiuLqnUZe9kA', '0', '0', '1');





DROP TABLE IF EXISTS `es_auth_group`;
CREATE TABLE `es_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键',
  `module` varchar(20) NOT NULL DEFAULT '' COMMENT '用户组所属模块',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '用户组名称',
  `describe` varchar(80) NOT NULL DEFAULT '' COMMENT '描述信息',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户组状态：为1正常，为0禁用,-1为删除',
  `rules` varchar(1000) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id，多个规则 , 隔开',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='权限组表';


DROP TABLE IF EXISTS `es_auth_group_access`;
CREATE TABLE `es_auth_group_access` (
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户组id',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组授权表';




DROP TABLE IF EXISTS `es_config`;
CREATE TABLE `es_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置标题',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置选项',
  `describe` varchar(255) NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `value` text NOT NULL COMMENT '配置值',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

INSERT INTO `es_config` VALUES(1, 'WEB_SITE_TITLE', 1, '网站标题', 1, '', '网站标题前台显示标题', 1378898976, 1492276847, 1, 'EasySNS极简社区', 3);
INSERT INTO `es_config` VALUES(2, 'WEB_SITE_DESCRIPTION', 2, '网站描述', 1, '', '网站搜索引擎描述', 1378898976, 1492276843, 1, '', 100);
INSERT INTO `es_config` VALUES(3, 'WEB_SITE_KEYWORD', 2, '网站关键字', 1, '', '网站搜索引擎关键字', 1378898976, 1492276839, 1, 'EasySNS极简社区', 99);
INSERT INTO `es_config` VALUES(4, 'WEB_SITE_CLOSE', 4, '关闭站点', 1, '0:关闭,1:开启', '站点关闭后其他用户不能访问，管理员可以正常访问', 1378898976, 1492273146, 1, '1', 1);
INSERT INTO `es_config` VALUES(9, 'config_type_list', 3, '配置类型列表', 3, '', '主要用于数据解析和页面表单的生成', 1378898976, 1492275785, 1, '0:数字\r\n1:字符\r\n2:文本\r\n3:数组\r\n4:枚举', 100);
INSERT INTO `es_config` VALUES(10, 'WEB_SITE_ICP', 1, '网站备案号', 1, '', '设置在网站底部显示的备案号，如“沪ICP备12007941号-2', 1378900335, 1492276833, 1, 'asdas', 9);
INSERT INTO `es_config` VALUES(20, 'config_group_list', 3, '配置分组', 3, '', '配置分组', 1379228036, 1492275841, 1, '1:基础\r\n2:数据\r\n3:系统\r\n4:扩展\r\n5:邮箱', 100);
INSERT INTO `es_config` VALUES(21, 'HOOKS_TYPE', 3, '钩子的类型', 4, '', '类型 1-用于扩展显示内容，2-用于扩展业务处理', 1379313397, 1492272816, -1, '1:视\r\n\r\n图\r\n2:控制器', 100);
INSERT INTO `es_config` VALUES(22, 'AUTH_CONFIG', 3, 'Auth配置', 4, '', '自定义Auth.class.php类配置', 1379409310, 1492272794, -1, 'AUTH_ON:1\r\r\n\r\n\nAUTH_TYPE:2', 100);
INSERT INTO `es_config` VALUES(23, 'OPEN_DRAFTBOX', 4, '是否开启草稿功能', 2, '0:关闭草稿功能\r\n1:开启草稿功能\r\n', '新增文章时的草稿功能配置', 1379484332, 1492272799, 1, '1', 2);
INSERT INTO `es_config` VALUES(24, 'DRAFT_AOTOSAVE_INTERVAL', 1, '自动保存草稿时间', 2, '', '自动保存草稿的时间间隔，单位：秒', 1379484574, 1492272804, 0, '60', 3);
INSERT INTO `es_config` VALUES(25, 'list_rows', 0, '每页数据记录数', 2, '', '数据每页显示记录数', 1379503896, 1492276739, 1, '10', 1);
INSERT INTO `es_config` VALUES(26, 'USER_ALLOW_REGISTER', 4, '是否允许用户注册', 1, '0:关闭注册\r\n1:允许注册', '是否开放用户注册', 1379504487, 1492272822, 1, '1', 3);
INSERT INTO `es_config` VALUES(28, 'DATA_BACKUP_PATH', 1, '数据库备份根路径', 4, '', '路径必须以 / 结尾', 1381482411, 1492273011, 1, './data/', 5);
INSERT INTO `es_config` VALUES(29, 'DATA_BACKUP_PART_SIZE', 1, '数据库备份卷大小', 4, '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', 1381482488, 1492272902, 1, '20971520', 7);
INSERT INTO `es_config` VALUES(30, 'DATA_BACKUP_COMPRESS', 4, '数据库备份文件是否启用压缩', 4, '0:不压缩\r\n1:启用压缩', '压缩备份文件需要PHP环境支持\r\n\r\ngzopen,gzwrite函数', 1381713345, 1492272906, 1, '1', 9);
INSERT INTO `es_config` VALUES(31, 'DATA_BACKUP_COMPRESS_LEVEL', 4, '数据库备份文件压缩级别', 4, '1:普通\r\n4:一般\r\n9:最高', '数据库备份文件的压缩级别，该配置\r\n\r\n在开启压缩时生效', 1381713408, 1492272910, 1, '9', 10);
INSERT INTO `es_config` VALUES(32, 'DEVELOP_MODE', 4, '开启开发者模式', 3, '0:关闭\r\n1:开启', '是否开启开发者模式', 1383105995, 1492272922, 1, '1', 11);
INSERT INTO `es_config` VALUES(33, 'allow_url', 3, '不受权限验证的url', 3, '', '', 1386644047, 1492276816, 1, '0:file/pictureupload\r\n1:addon/execute\r\n2:index/adminindex\r\n3:index/home\r\n4:user/changePass', 100);
INSERT INTO `es_config` VALUES(34, 'DENY_VISIT', 3, '超管专限控制器方法', 1, '', '仅超级管理员可访问的控制器方法', 1386644141, 1492272998, -1, '0:Addons/addhook\r\n1:Addons/edithook\r\n2:Addons/delhook\r\n3:Addons/updateHook', 100);
INSERT INTO `es_config` VALUES(35, 'REPLY_LIST_ROWS', 1, '回复列表每页条数', 2, '', '', 1386645376, 1492273230, -1, '10', 0);
INSERT INTO `es_config` VALUES(36, 'ADMIN_ALLOW_IP', 2, '后台允许访问IP', 3, '', '多个用逗号分隔，如果不配置表示不限制IP访问', 1387165454, 1492276749, 1, '', 12);
INSERT INTO `es_config` VALUES(37, 'SHOW_PAGE_TRACE', 4, '是否显示页面Trace', 3, '0:关闭\r\n1:开启', '是否显示页面Trace信息', 1387165685, 1492275918, 1, '0', 1);
INSERT INTO `es_config` VALUES(43, 'empty_list_describe', 1, '数据列表为空时的描述信息', 2, '', '', 1492278127, 1492278127, 1, 'aOh! 暂时还没有数据~', 0);
INSERT INTO `es_config` VALUES(44, 'trash_config', 3, '回收站配置', 3, '', 'key为模型名称，值为显示列。', 1492312698, 1492925148, 1, 'Config:name\r\nAuthGroup:name\r\nUser:nickname\r\nMenu:name\r\nAddon:name\r\nPicture:name', 0);
INSERT INTO `es_config` VALUES(45, 'yzm_list', 3, '验证码配置', 3, '', '1注册2登录3忘记密码4后台登录', 1378898976, 1492275785, 1, '1\r\n2\r\n3\r\n4', 100);
INSERT INTO `es_config` VALUES(46, 'Cache_open', 4, '是否开启缓存机制', 2, '0:关闭缓存\r\n1:开启缓存\r\n', '缓存开关', 1379484332, 1492272799, 1, '0', 4);

INSERT INTO `es_config` VALUES ('47', 'cache_max_number', '1', '缓存最大数量', '2', '', '允许缓存的最大数量', '1494222635', '1502504402', '1', '1000', '5');
INSERT INTO `es_config` VALUES ('48', 'cache_clear_interval_time', '1', '缓存回收时间', '2', '', '缓存时间以秒计算', '1494222635', '1502504402', '1', '600', '6');
INSERT INTO `es_config` VALUES(49, 'OPEN_ROUTER', 4, '是否开启路由功能', 3, '0:关闭路由功能\r\n1:开启路由功能\r\n', '前台路由功能配置', 1379484332, 1492272799, 1, '1', 1);
INSERT INTO `es_config` VALUES ('50', 'site_tpl', '1', '前台模板', '1', '', '模板名称', '1494222635', '1502504402', '1', 'simple', '0');
INSERT INTO `es_config` VALUES(51, 'WEB_SITE_FOOTER', 2, '底部代码', 1, '', '可以添加统计代码等', 1378898976, 1492276843, 1, '', 100);

INSERT INTO `es_config` VALUES ('52', 'upload_file_ext', '1', '附件上传后缀限制', '3', '', '多个后缀名请用半角逗号隔开', '1494222635', '1502504402', '1', 'doc', '0');
INSERT INTO `es_config` VALUES ('53', 'upload_file_size', '1', '附件上传大小限制', '3', '', '单位为字节', '1494222635', '1502504402', '1', '2048000', '0');

INSERT INTO `es_config` VALUES(54, 'point_type_list', 3, '积分规则类型列表', 3, '', '主要用于积分规则的管理', 1378898976, 1492275785, 1, 'login:登录\r\nreg:注册\r\ndocupload:文档上传\r\ndocdown:文档下载\r\ndocxs:文档悬赏', 100);
INSERT INTO `es_config` VALUES(55, 'keyword_list', 3, '关键词列表', 3, '', '一行一个', 1378898976, 1492275785, 1, '学习\r\n讲话', 100);

INSERT INTO `es_config` VALUES ('56', 'storage_driver', '1', '存储驱动', '2', '', '若无需使用云存储则为空', '1494222635', '1502504402', '1', '', '5');


INSERT INTO `es_config` VALUES(57, 'scoretype_list', 3, '积分类型列表', 3, '', '一行一个', 1378898976, 1492275785, 1, 'point:财富值\r\nexpoint1:经验值', 100);

INSERT INTO `es_config` VALUES ('58', 'upload_picture_ext', '1', '图片上传后缀限制', '3', '', '多个后缀名请用半角逗号隔开', '1494222635', '1502504402', '1', 'jpg,gif,png', '0');
INSERT INTO `es_config` VALUES ('59', 'upload_picture_size', '1', '图片上传大小限制', '3', '', '单位为字节', '1494222635', '1502504402', '1', '2048000', '0');

INSERT INTO `es_config` VALUES(60, 'emot_list', 3, '表情列表', 3, '', '一行一个', 1378898976, 1492275785, 1, '__PUBLIC_IMG__/emotion/emot01.gif', 100);

INSERT INTO `es_config` VALUES ('61', 'web_url', '1', '网站域名', '1', '', '含http://,如果是子目录也需要填写，后面加上/', '1494222635', '1502504402', '1', 'http://es.imzaker.com/zaker/', '0');

INSERT INTO `es_config` VALUES ('62', 'mailserver', '1', '邮箱服务器', '5', '', '邮箱服务器', '1494222635', '1502504402', '1', 'smtp.qq.com', '0');

INSERT INTO `es_config` VALUES ('63', 'mailport', '1', '邮箱端口', '5', '', '根据不同邮箱介绍进行设置', '1494222635', '1502504402', '1', '587', '0');


INSERT INTO `es_config` VALUES ('64', 'mailusername', '1', '邮箱用户名', '5', '', '邮箱用户名', '1494222635', '1502504402', '1', '', '0');

INSERT INTO `es_config` VALUES ('65', 'mailpassword', '1', '邮箱密码', '5', '', '邮箱密码', '1494222635', '1502504402', '1', '', '0');

INSERT INTO `es_config` VALUES ('66', 'mailname', '1', '发信签名', '5', '', '发信时签名', '1494222635', '1502504402', '1', 'EasySNS', '0');

DROP TABLE IF EXISTS `es_menu`;
CREATE TABLE `es_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `module` char(20) NOT NULL DEFAULT '' COMMENT '模块',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `is_hide` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `icon` char(30) NOT NULL DEFAULT '' COMMENT '图标',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=155 DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- ----------------------------
-- Records of es_menu
-- ----------------------------

INSERT INTO `es_menu` VALUES ('1', '系统管理', '0', '4', 'admin', 'config/group', '0', 'fa-wrench', '1', '1491578008', '9');
INSERT INTO `es_menu` VALUES ('2', '内容管理', '0', '4', 'admin', 'content/index', '0', 'fa-newspaper-o', '1', '1491578008', '9');
INSERT INTO `es_menu` VALUES ('3', '用户管理', '0', '3', 'admin', 'user/index', '0', 'fa-user', '1', '1491837091', '1');
INSERT INTO `es_menu` VALUES ('4', '扩展管理', '0', '3', 'admin', 'user/index', '0', 'fa-object-group', '1', '1491837091', '1');




INSERT INTO `es_menu` VALUES ('5', '插件列表', '4', '3', 'admin', 'addon/addonlist', '0', 'fa-microchip', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('6', '钩子列表', '4', '2', 'admin', 'addon/hooklist', '0', 'fa-anchor', '1', '1492000451', '0');
INSERT INTO `es_menu` VALUES ('7', '服务列表', '4', '1', 'admin', 'service/servicelist', '0', 'fa-server', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('8', '菜单列表', '1', '5', 'admin', 'menu/menulist', '0', 'fa-asl-interpreting', '1', '1491318724', '0');






INSERT INTO `es_menu` VALUES ('9', '回收站', '1', '2', 'admin', 'trash/trashlist', '0', 'fa-recycle', '1', '1492320214', '1492311462');
INSERT INTO `es_menu` VALUES ('901', '数据列表', '9', '1', 'admin', 'trash/trashDataList', '0', 'fa-inbox', '1', '1491318724', '0');
INSERT INTO `es_menu` VALUES ('902', '数据删除', '9', '1', 'admin', 'trash/trashDataDel', '0', 'fa-inbox', '1', '1491318724', '0');
INSERT INTO `es_menu` VALUES ('903', '数据恢复', '9', '1', 'admin', 'trash/restoreData', '0', 'fa-inbox', '1', '1491318724', '0');


INSERT INTO `es_menu` VALUES ('10', '备份数据', '1', '1', 'admin', 'database/databaseList', '0', 'fa-inbox', '1', '1491318724', '0');
INSERT INTO `es_menu` VALUES ('1001', '备份数据', '10', '1', 'admin', 'database/export', '0', 'fa-inbox', '1', '1491318724', '0');
INSERT INTO `es_menu` VALUES ('1002', '优化表', '10', '1', 'admin', 'database/optimize', '0', 'fa-inbox', '1', '1491318724', '0');
INSERT INTO `es_menu` VALUES ('1003', '修复表', '10', '1', 'admin', 'database/repair', '0', 'fa-inbox', '1', '1491318724', '0');



INSERT INTO `es_menu` VALUES ('11', '还原数据', '1', '0', 'admin', 'database/importList', '0', 'fa-undo', '1', '1491318724', '0');
INSERT INTO `es_menu` VALUES ('1101', '还原数据库', '11', '0', 'admin', 'database/import', '0', 'fa-undo', '1', '1491318724', '0');
INSERT INTO `es_menu` VALUES ('1102', '删除数据库', '11', '0', 'admin', 'database/delete', '0', 'fa-undo', '1', '1491318724', '0');
INSERT INTO `es_menu` VALUES ('1103', '下载备份', '11', '0', 'admin', 'database/download', '0', 'fa-undo', '1', '1491318724', '0');



INSERT INTO `es_menu` VALUES ('12', '配置管理', '1', '4', 'admin', 'config/configlist', '0', 'fa-gears', '1', '1491668183', '0');
INSERT INTO `es_menu` VALUES ('1201', '系统配置', '1', '6', 'admin', 'config/setting', '0', 'fa-gear', '1', '1491668183', '0');
INSERT INTO `es_menu` VALUES ('1202', '配置编辑', '12', '0', 'admin', 'config/configedit', '1', '', '1', '1491674180', '0');
INSERT INTO `es_menu` VALUES ('1203', '配置删除', '12', '0', 'admin', 'config/configDel', '1', '', '1', '1491674201', '0');
INSERT INTO `es_menu` VALUES ('1204', '配置添加', '12', '0', 'admin', 'config/configadd', '0', 'fa-plus', '1', '1491666947', '0');
INSERT INTO `es_menu` VALUES ('1205', '配置批量删除', '12', '0', 'admin', 'config/configAlldel', '1', '', '1', '1491674201', '0');


INSERT INTO `es_menu` VALUES ('13', '会员列表', '3', '3', 'admin', 'user/memberList', '0', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1301', '会员添加', '13', '3', 'admin', 'user/memberAdd', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1302', '会员编辑', '13', '3', 'admin', 'user/memberEdit', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1303', '会员批量删除', '13', '3', 'admin', 'user/memberAlldel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1304', '会员删除', '13', '3', 'admin', 'user/memberDel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1305', '会员授权', '13', '3', 'admin', 'user/memberAuth', '1', 'fa-id-card-o', '1', '1491837214', '0');


INSERT INTO `es_menu` VALUES ('14', '会员等级', '3', '2', 'admin', 'usergrade/usergradeList', '0', 'fa-signal', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1401', '会员等级添加', '14', '3', 'admin', 'usergrade/usergradeAdd', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1402', '会员等级编辑', '14', '3', 'admin', 'usergrade/usergradeEdit', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1403', '会员等级批量删除', '14', '3', 'admin', 'usergrade/usergradeAlldel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1404', '会员等级删除', '14', '3', 'admin', 'usergrade/usergradeDel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1405', '会员等级授权', '14', '3', 'admin', 'usergrade/usergradeAuth', '1', 'fa-id-card-o', '1', '1491837214', '0');


INSERT INTO `es_menu` VALUES ('15', '权限管理', '3', '1', 'admin', 'auth/authgroupList', '0', 'fa-suitcase', '1', '1492000451', '0');
INSERT INTO `es_menu` VALUES ('1501', '权限组添加', '15', '3', 'admin', 'auth/authgroupAdd', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1502', '权限组编辑', '15', '3', 'admin', 'auth/authgroupEdit', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1503', '权限组批量删除', '15', '3', 'admin', 'auth/authgroupAlldel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1504', '权限组删除', '15', '3', 'admin', 'auth/authgroupDel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1505', '权限组授权', '15', '3', 'admin', 'auth/authmenuAuth', '1', 'fa-id-card-o', '1', '1491837214', '0');


INSERT INTO `es_menu` VALUES ('16', '前台导航', '1', '4', 'admin', 'nav/navList', '0', 'fa-life-bouy', '1', '1491668183', '0');
INSERT INTO `es_menu` VALUES ('1601', '导航添加', '16', '3', 'admin', 'nav/navAdd', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1602', '导航编辑', '16', '3', 'admin', 'nav/navEdit', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1603', '导航批量删除', '16', '3', 'admin', 'nav/navAlldel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1604', '导航删除', '16', '3', 'admin', 'nav/navDel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1605', '导航状态更新', '16', '3', 'admin', 'nav/navCstatus', '1', 'fa-id-card-o', '1', '1491837214', '0');

INSERT INTO `es_menu` VALUES ('17', '评论数据', '2', '3', 'admin', 'comment/commentlist', '0', 'fa-comments-o', '1', '1491318724', '0');
INSERT INTO `es_menu` VALUES ('1701', '评论编辑', '17', '3', 'admin', 'comment/commentEdit', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1702', '评论批量删除', '17', '3', 'admin', 'comment/commentAlldel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1703', '评论删除', '17', '3', 'admin', 'comment/commentDel', '1', 'fa-id-card-o', '1', '1491837214', '0');



INSERT INTO `es_menu` VALUES ('18', '消息列表', '2', '2', 'admin', 'message/messagelist', '0', 'fa-volume-up', '1', '1491318724', '0');
INSERT INTO `es_menu` VALUES ('1801', '消息添加', '18', '3', 'admin', 'message/messageAdd', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1802', '消息编辑', '18', '3', 'admin', 'message/messageEdit', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1803', '消息批量删除', '18', '3', 'admin', 'message/messageAlldel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1804', '消息删除', '18', '3', 'admin', 'message/messageDel', '1', 'fa-id-card-o', '1', '1491837214', '0');


INSERT INTO `es_menu` VALUES ('19', '积分规则', '1', '3', 'admin', 'pointrule/pointruleList', '0', 'fa-eercast', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1901', '规则添加', '19', '3', 'admin', 'pointrule/pointruleAdd', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1902', '规则编辑', '19', '3', 'admin', 'pointrule/pointruleEdit', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1903', '规则批量删除', '19', '3', 'admin', 'pointrule/pointruleAlldel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('1904', '规则删除', '19', '3', 'admin', 'pointrule/pointruleDel', '1', 'fa-id-card-o', '1', '1491837214', '0');

INSERT INTO `es_menu` VALUES ('20', '积分记录', '1', '3', 'admin', 'point_note/point_noteList', '0', 'fa-eercast', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2001', '记录添加', '20', '3', 'admin', 'point_note/point_noteAdd', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2002', '记录编辑', '20', '3', 'admin', 'point_note/point_noteEdit', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2003', '记录批量删除', '20', '3', 'admin', 'point_note/point_noteAlldel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2004', '记录删除', '20', '3', 'admin', 'point_note/point_noteDel', '1', 'fa-id-card-o', '1', '1491837214', '0');

INSERT INTO `es_menu` VALUES ('21', '小组管理', '2', '5', 'admin', 'group/grouplist', '0', 'fa-empire', '1', '1491318724', '0');
INSERT INTO `es_menu` VALUES ('2101', '小组添加', '21', '3', 'admin', 'group/groupAdd', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2102', '小组编辑', '21', '3', 'admin', 'group/groupEdit', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2103', '小组批量删除', '21', '3', 'admin', 'group/groupAlldel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2104', '小组删除', '21', '3', 'admin', 'group/groupDel', '1', 'fa-id-card-o', '1', '1491837214', '0');


INSERT INTO `es_menu` VALUES ('22', '帖子管理', '2', '5', 'admin', 'topic/topiclist', '0', 'fa-file-pdf-o', '1', '1491318724', '0');
INSERT INTO `es_menu` VALUES ('2202', '帖子编辑', '22', '3', 'admin', 'topic/topicEdit', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2203', '帖子批量删除', '22', '3', 'admin', 'topic/topicAlldel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2204', '帖子删除', '22', '3', 'admin', 'topic/topicDel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2205', '帖子状态更新', '22', '3', 'admin', 'topic/topicCstatus', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2206', '帖子推送', '22', '3', 'admin', 'topic/topicTuisong', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2207', '帖子审核', '22', '3', 'admin', 'topic/topicSh', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2208', '帖子批量审核', '22', '3', 'admin', 'topic/topicAllSh', '1', 'fa-id-card-o', '1', '1491837214', '0');





INSERT INTO `es_menu` VALUES ('24', '小组分类', '2', '5', 'admin', 'groupcate/groupcatelist', '0', 'fa-buysellads', '1', '1491318724', '0');
INSERT INTO `es_menu` VALUES ('2401', '小组分类添加', '24', '3', 'admin', 'groupcate/groupcateAdd', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2402', '小组分类编辑', '24', '3', 'admin', 'groupcate/groupcateEdit', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2403', '小组分类批量删除', '24', '3', 'admin', 'groupcate/groupcateAlldel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2404', '小组分类删除', '24', '3', 'admin', 'groupcate/groupcateDel', '1', 'fa-id-card-o', '1', '1491837214', '0');

INSERT INTO `es_menu` VALUES ('25', '文章分类', '2', '5', 'admin', 'articlecate/articlecatelist', '0', 'fa-puzzle-piece', '1', '1491318724', '0');
INSERT INTO `es_menu` VALUES ('2501', '文章分类添加', '25', '3', 'admin', 'articlecate/articlecateAdd', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2502', '文章分类编辑', '25', '3', 'admin', 'articlecate/articlecateEdit', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2503', '文章分类批量删除', '25', '3', 'admin', 'articlecate/articlecateAlldel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2504', '文章分类删除', '25', '3', 'admin', 'articlecate/articlecateDel', '1', 'fa-id-card-o', '1', '1491837214', '0');


INSERT INTO `es_menu` VALUES ('26', '文章管理', '2', '5', 'admin', 'article/articlelist', '0', 'fa-sticky-note-o', '1', '1491318724', '0');
INSERT INTO `es_menu` VALUES ('2601', '文章添加', '26', '3', 'admin', 'article/articleAdd', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2602', '文章编辑', '26', '3', 'admin', 'article/articleEdit', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2603', '文章批量删除', '26', '3', 'admin', 'article/articleAlldel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2604', '文章删除', '26', '3', 'admin', 'article/articleDel', '1', 'fa-id-card-o', '1', '1491837214', '0');
INSERT INTO `es_menu` VALUES ('2605', '文章状态更新', '26', '3', 'admin', 'article/articleCstatus', '1', 'fa-id-card-o', '1', '1491837214', '0');

DROP TABLE IF EXISTS `es_topic`;
CREATE TABLE IF NOT EXISTS `es_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL COMMENT '小组所属分类',
  `tid` int(11) NOT NULL COMMENT '上级小组',
  `uid` int(11) NOT NULL COMMENT '用户',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `choice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '精贴',
  `settop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '顶置',
  `praise` int(11) NOT NULL DEFAULT '0' COMMENT '赞',
  `view` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `reply` int(11) NOT NULL DEFAULT '0' COMMENT '回复',
  `keywords` varchar(100) DEFAULT NULL  COMMENT '关键词',
  `description` varchar(200) DEFAULT NULL  COMMENT '描述',
  `content` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `es_article`;
CREATE TABLE IF NOT EXISTS `es_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL COMMENT '上级',
  `uid` int(11) NOT NULL COMMENT '用户',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `choice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '精贴',
  `settop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '顶置',
  `praise` int(11) NOT NULL DEFAULT '0' COMMENT '赞',
  `view` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `keywords` varchar(100) NOT NULL COMMENT '关键词',
  `description` varchar(200) NOT NULL COMMENT '描述',
  `content` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `es_articlecate`;
CREATE TABLE IF NOT EXISTS `es_articlecate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '分类名称',
  `describe` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `cover_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '封面图片id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据状态',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='文章分类表';



DROP TABLE IF EXISTS `es_comment`;
CREATE TABLE IF NOT EXISTS `es_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '上级评论',
  `gid` int(11) NOT NULL COMMENT '小组id',
  `uid` int(11) NOT NULL COMMENT '所属会员',
  `fid` int(11) NOT NULL COMMENT '所属帖子',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `praise` int(11) DEFAULT '0' COMMENT '赞',
  `reply` int(11) DEFAULT '0' COMMENT '回复',
  `floor` int(11) DEFAULT '2' COMMENT '楼层',
  `content` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='评论表';





DROP TABLE IF EXISTS `es_groupcate`;
CREATE TABLE `es_groupcate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(100) NOT NULL COMMENT '分类名称',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据状态',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS `es_group`;
CREATE TABLE IF NOT EXISTS `es_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '小组ID',
  `pid` int(11) NOT NULL COMMENT '小组所属分类',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '小组名称',
  `choice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐小组',
  `membercount` int(11) NOT NULL DEFAULT '0' COMMENT '小组成员数',
  `topiccount` int(11) NOT NULL DEFAULT '0' COMMENT '话题数',
  `describe` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `cover_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '封面图片id',
  `bg_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '背景图片id',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '组长id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据状态',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='小组表';


DROP TABLE IF EXISTS `es_user_group`;
CREATE TABLE IF NOT EXISTS `es_user_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'group的id',
  `grade` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0表示普通会员1表示副组长2表示组长',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='小组用户表';


DROP TABLE IF EXISTS `es_message`;
CREATE TABLE IF NOT EXISTS `es_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '所属会员',
  `touid` int(11) NOT NULL DEFAULT '0' COMMENT '发送对象',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1系统消息2帖子动态',
  `content` text NOT NULL COMMENT '内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态2表示已读',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='消息表';

DROP TABLE IF EXISTS `es_readmessage`;
CREATE TABLE IF NOT EXISTS `es_readmessage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员',
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT '消息id',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='消息已读表';


DROP TABLE IF EXISTS `es_nav`;
CREATE TABLE `es_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` tinyint(3) unsigned NOT NULL COMMENT '顶部还是底部',
  `sid` tinyint(3) unsigned NOT NULL COMMENT '内部还是外部',
  `name` varchar(20) NOT NULL COMMENT '导航名称',
  `alias` varchar(20) DEFAULT '' COMMENT '导航别称',
  `link` varchar(255) DEFAULT '' COMMENT '导航链接',
  `icon` varchar(255) DEFAULT '' COMMENT '导航图标',
  `target` varchar(10) DEFAULT '' COMMENT '打开方式',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='导航表';


INSERT INTO `es_nav` (`id`, `pid`, `name`, `alias`, `link`, `icon`, `target`, `status`, `sort`, `sid`, `update_time`, `create_time`) VALUES
(1, 1, '小组', 'Group', 'Group/glist', 'wenda', '_blank', 1, 0, 1, 0, 0);
INSERT INTO `es_nav` (`id`, `pid`, `name`, `alias`, `link`, `icon`, `target`, `status`, `sort`, `sid`, `update_time`, `create_time`) VALUES
(2, 1, '首页', 'Home', 'Index/index', 'home', '_blank', 1, 2, 1, 0, 0);

DROP TABLE IF EXISTS `es_usercz`;
CREATE TABLE `es_usercz` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
  `did` int(11) unsigned NOT NULL COMMENT '目标id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据状态',
  `cid` tinyint(1) NOT NULL DEFAULT '1' COMMENT '内容类型1为帖子2小组3用户',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1为下载2为浏览',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户操作';



DROP TABLE IF EXISTS `es_zan`;
CREATE TABLE `es_zan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL COMMENT '用户',
  `sid` int(11) unsigned NOT NULL COMMENT '对方id或者帖子id或者回复的id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  0 好友  1 帖子点赞2 评论点赞3收藏4分类订阅',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户操作表';


DROP TABLE IF EXISTS `es_point_note`;
CREATE TABLE `es_point_note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `controller` varchar(255) NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1为增加2为减少',
  `score` int(10) NOT NULL,
  `itemid` varchar(11) NOT NULL DEFAULT '0' COMMENT '表示帖子或者其他各种类型的主键id',
  `infouid` varchar(11) NOT NULL DEFAULT '0' COMMENT '规则id或者受益人uid',
  `scoretype` varchar(30) NOT NULL DEFAULT '' COMMENT '积分类型',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据状态',
  PRIMARY KEY (`id`)
)ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `es_log`;
CREATE TABLE `es_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `controller` varchar(255) NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `username` varchar(55) NOT NULL,
  `add_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `es_point_rule`;
CREATE TABLE IF NOT EXISTS `es_point_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则ID',
  `controller` varchar(30) NOT NULL DEFAULT '' COMMENT '规则名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1为增加2为减少',
  `score` varchar(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `scoretype` varchar(30) NOT NULL DEFAULT '' COMMENT '积分类型',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='积分规则表';


DROP TABLE IF EXISTS `es_searchword`;
CREATE TABLE IF NOT EXISTS `es_searchword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '热搜关键词',
  `num` int(20) NOT NULL DEFAULT '1' COMMENT '搜索次数',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据状态',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='热搜表';


DROP TABLE IF EXISTS `es_raty_user`;
CREATE TABLE `es_raty_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `itemid` int(11) NOT NULL COMMENT '内容id',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1电影2音乐3帖子',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;