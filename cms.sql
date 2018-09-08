/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50721
Source Host           : localhost:3306
Source Database       : cms

Target Server Type    : MYSQL
Target Server Version : 50721
File Encoding         : 65001

Date: 2018-09-08 10:41:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cms_article
-- ----------------------------
DROP TABLE IF EXISTS `cms_article`;
CREATE TABLE `cms_article` (
  `id` varchar(32) NOT NULL,
  `title` varchar(100) NOT NULL COMMENT '标题',
  `is_title_bold` char(1) DEFAULT '0' COMMENT '标题加粗 0-不加粗 1-加粗',
  `is_title_italic` char(1) DEFAULT '0' COMMENT '标题加粗 0-不倾斜 1-倾斜',
  `title_color` char(7) DEFAULT '' COMMENT '标题颜色',
  `user_id` varchar(32) DEFAULT NULL COMMENT '作者',
  `nav_id` varchar(32) DEFAULT NULL COMMENT '所属导航',
  `tag_id` varchar(32) DEFAULT '0' COMMENT '所属标签',
  `view_number` int(11) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `thumb_img` varchar(100) DEFAULT NULL COMMENT '缩略图',
  `is_top` char(1) NOT NULL DEFAULT '0' COMMENT '是否置顶 1-是 0-否',
  `summary` varchar(600) DEFAULT '0' COMMENT '文章简介',
  `source` varchar(50) DEFAULT '' COMMENT '来源',
  `content` text COMMENT '内容',
  `publish_date` date DEFAULT NULL COMMENT '发布日期',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态 1-未发布（默认） 2-已发布 0-删除',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_article_title` (`title`),
  KEY `idx_article_user_id` (`user_id`) USING BTREE,
  KEY `idx_article_tag_id` (`tag_id`) USING BTREE,
  KEY `idx_article_nav_id` (`nav_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_article
-- ----------------------------
INSERT INTO `cms_article` VALUES ('ARTICLE_201809060209077253', '陌上花开，可缓缓归矣', '0', '0', '', null, 'NAV_201809030640057728', '1', '0', null, '0', '用最简单的代码，实现瀑布流布局，没有繁琐的css，没有jq，只需要做到以下就可以实现瀑布流的效果。思路很简单，看成是三列布局，分别用三个ul来调用。帝国cms列表模板', 'Choel', '<p>用最简单的代码，实现瀑布流布局，没有繁琐的css，没有jq，只需要做到以下就可以实现瀑布流的效果。思路很简单，看成是三列布局，分别用三个ul来调用。帝国cms列表模板用最简单的代码，实现瀑布流布局，没有繁琐的css，没有jq，只需要做到以下就可以实现瀑布流的效果。思路很简单，看成是三列布局，分别用三个ul来调用。帝国cms列表模板用最简单的代码，实现瀑布流布局，没有繁琐的css，没有jq，只需要做到以下就可以实现瀑布流的效果。思路很简单，看成是三列布局，分别用三个ul来调用。帝国cms列表模板用最简单的代码，实现瀑布流布局，没有繁琐的css，没有jq，只需要做到以下就可以实现瀑布流的效果。思路很简单，看成是三列布局，分别用三个ul来调用。帝国cms列表模板用最简单的代码，实现瀑布流布局，没有繁琐的css，没有jq，只需要做到以下就可以实现瀑布流的效果。思路很简单，看成是三列布局，分别用三个ul来调用。帝国cms列表模板用最简单的代码，实现瀑布流布局，没有繁琐的css，没有jq，只需要做到以下就可以实现瀑布流的效果。思路很简单，看成是三列布局，分别用三个ul来调用。帝国cms列表模板<br></p>', '2018-09-06', '2', '2018-09-06 02:09:07', '2018-09-06 02:35:01');
INSERT INTO `cms_article` VALUES ('ARTICLE_201809060338035337', '[ Laravel 5.6 文档 ] 数据库操作 —— 查询构建', '0', '0', '', null, 'NAV_201809050936235569', 'TAG_201809051007124367', '0', null, '0', '[ Laravel 5.6 文档 ] 数据库操作 —— 查询构建', '学院君', null, '2018-09-06', '2', '2018-09-06 03:38:03', '2018-09-06 03:38:23');

-- ----------------------------
-- Table structure for cms_authorize
-- ----------------------------
DROP TABLE IF EXISTS `cms_authorize`;
CREATE TABLE `cms_authorize` (
  `id` varchar(32) NOT NULL,
  `role_id` varchar(32) NOT NULL COMMENT '角色id',
  `rules` text COMMENT '规则权限id',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_authorize_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_authorize
-- ----------------------------
INSERT INTO `cms_authorize` VALUES ('AUTHORIZE_201808300334128529', 'ROLE_201808300246497861', 'admin/menu/index,admin/menu/edit,admin/menu/delete,admin/menu/update_status,admin/menu/get_menu_level', '2018-08-30 03:34:12', '2018-08-30 03:34:12');

-- ----------------------------
-- Table structure for cms_content_module
-- ----------------------------
DROP TABLE IF EXISTS `cms_content_module`;
CREATE TABLE `cms_content_module` (
  `id` varchar(32) NOT NULL,
  `name` varchar(30) NOT NULL COMMENT '变量名称',
  `type` char(1) NOT NULL DEFAULT '0' COMMENT '模块类型 0-普通列表 1-首页图 2-广告标语',
  `nav_id` varchar(32) DEFAULT NULL COMMENT '关联',
  `number` int(11) NOT NULL DEFAULT '4' COMMENT '内容数量',
  `single_length` int(11) DEFAULT '20' COMMENT '单条长度',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态 1-启用 0-禁用',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_content_module_name` (`name`),
  KEY `idx_content_module_nav_id` (`nav_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_content_module
-- ----------------------------
INSERT INTO `cms_content_module` VALUES ('1', '12313', '0', 'NAV_201809030640057728', '4', '20', '1', null, '2018-09-08 01:33:47');
INSERT INTO `cms_content_module` VALUES ('123121', 'index_par', '1', '0', '10', '100', '1', '2018-09-11 18:04:13', '2018-09-08 01:33:47');
INSERT INTO `cms_content_module` VALUES ('CONTENTMODULE_201809080133477348', '111', '0', 'NAV_201809050939183546', '222', '222', '1', '2018-09-08 01:33:47', '2018-09-08 01:33:47');

-- ----------------------------
-- Table structure for cms_menu
-- ----------------------------
DROP TABLE IF EXISTS `cms_menu`;
CREATE TABLE `cms_menu` (
  `id` varchar(32) NOT NULL COMMENT '菜单id',
  `name` varchar(30) NOT NULL COMMENT '菜单名称',
  `level` char(1) NOT NULL DEFAULT '1' COMMENT '菜单级别',
  `parent_id` char(32) NOT NULL DEFAULT '0' COMMENT '菜单父栏目编号',
  `icon` varchar(20) DEFAULT NULL COMMENT '菜单图标',
  `sort` varchar(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `url` varchar(50) DEFAULT NULL COMMENT '菜单地址',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '菜单状态，0-停用1-启用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_menu_parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_menu
-- ----------------------------
INSERT INTO `cms_menu` VALUES ('MENU_201808300232288030', '系统管理', '1', '0', 'gears', '0100', '#', '1', '2018-08-30 02:32:28', '2018-08-30 02:32:28');
INSERT INTO `cms_menu` VALUES ('MENU_201808300237076705', '菜单管理', '2', 'MENU_201808300232288030', 'book', '0101', 'admin/menu/index', '1', '2018-08-30 02:37:07', '2018-08-30 02:37:07');
INSERT INTO `cms_menu` VALUES ('MENU_201808300240082440', '权限管理', '2', 'MENU_201808300232288030', 'toggle-on', '0102', 'admin/rule/index', '1', '2018-08-30 02:40:08', '2018-09-08 02:34:32');
INSERT INTO `cms_menu` VALUES ('MENU_201808300241344594', '角色管理', '2', 'MENU_201808300232288030', 'user', '0103', 'admin/role/index', '1', '2018-08-30 02:41:34', '2018-08-30 02:41:34');
INSERT INTO `cms_menu` VALUES ('MENU_201808300242103500', '用户管理', '2', 'MENU_201808300232288030', 'vcard-o', '0104', 'admin/user/index', '1', '2018-08-30 02:42:10', '2018-09-08 02:35:13');
INSERT INTO `cms_menu` VALUES ('MENU_201809010226592963', '网站基本信息', '2', 'MENU_201808300232288030', 'gear', '0105', 'admin/info/index', '1', '2018-09-01 02:26:59', '2018-09-08 02:38:20');
INSERT INTO `cms_menu` VALUES ('MENU_201809010246201199', '内容管理', '1', '0', 'files-o', '0200', '#', '1', '2018-09-01 02:46:20', '2018-09-01 02:46:20');
INSERT INTO `cms_menu` VALUES ('MENU_201809010252314085', '导航管理', '2', 'MENU_201809010246201199', 'sitemap', '0201', 'admin/nav/index', '1', '2018-09-01 02:52:31', '2018-09-01 02:52:31');
INSERT INTO `cms_menu` VALUES ('MENU_201809010315324304', '文章管理', '2', 'MENU_201809010246201199', 'file', '0203', 'admin/article/index', '1', '2018-09-01 03:15:32', '2018-09-05 09:43:25');
INSERT INTO `cms_menu` VALUES ('MENU_201809050943051002', '标签管理', '2', 'MENU_201809010246201199', 'tag', '0202', 'admin/tag/index', '1', '2018-09-05 09:43:05', '2018-09-05 09:43:35');
INSERT INTO `cms_menu` VALUES ('MENU_201809070741541677', '模块管理', '2', 'MENU_201809010246201199', 'window-maximize', '0204', 'admin/module/index', '1', '2018-09-07 07:41:54', '2018-09-08 02:37:21');
INSERT INTO `cms_menu` VALUES ('MENU_201809080228053901', '微信管理', '1', '0', 'wechat', '0300', 'admin/wechat/index', '1', '2018-09-08 02:28:05', '2018-09-08 02:28:05');
INSERT INTO `cms_menu` VALUES ('MENU_201809080228528828', '评论管理', '2', 'MENU_201809010246201199', 'comment', '0205', 'admin/comment/index', '1', '2018-09-08 02:28:52', '2018-09-08 02:28:52');
INSERT INTO `cms_menu` VALUES ('MENU_201809080230029492', '博客基本信息', '2', 'MENU_201809010246201199', 'info', '0206', 'admin/index_info/index', '1', '2018-09-08 02:30:02', '2018-09-08 02:37:48');
INSERT INTO `cms_menu` VALUES ('MENU_201809080240134377', '用户信息管理', '1', '0', 'vcard', '0400', 'admin/user_info/index', '1', '2018-09-08 02:40:13', '2018-09-08 02:40:13');

-- ----------------------------
-- Table structure for cms_nav
-- ----------------------------
DROP TABLE IF EXISTS `cms_nav`;
CREATE TABLE `cms_nav` (
  `id` varchar(32) NOT NULL COMMENT '导航id',
  `name` varchar(30) NOT NULL COMMENT '导航名称',
  `level` char(1) NOT NULL DEFAULT '1' COMMENT '导航级别',
  `parent_id` char(32) NOT NULL DEFAULT '0' COMMENT '导航父栏目编号',
  `icon` varchar(20) DEFAULT NULL COMMENT '导航图标',
  `sort` varchar(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `thumb_img` varchar(100) DEFAULT NULL COMMENT '缩略图',
  `summary` varchar(600) DEFAULT NULL COMMENT '导航简介',
  `url` varchar(50) DEFAULT NULL COMMENT '导航地址',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '导航状态，0-停用1-启用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_nav_parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_nav
-- ----------------------------
INSERT INTO `cms_nav` VALUES ('NAV_201809030640057728', '导航一', '1', '0', 'book', '0100', null, null, 'www.baidu.com', '1', '2018-09-03 06:40:05', '2018-09-03 06:40:05');
INSERT INTO `cms_nav` VALUES ('NAV_201809050936235569', '导航二', '1', '0', 'book', '0200', null, null, 'https://www.baidu.com', '1', '2018-09-05 09:36:23', '2018-09-05 09:36:33');
INSERT INTO `cms_nav` VALUES ('NAV_201809050939183546', '导航三', '1', '0', 'gear', '0300', null, null, 'www.baidu.com', '1', '2018-09-05 09:39:18', '2018-09-05 09:39:18');

-- ----------------------------
-- Table structure for cms_role
-- ----------------------------
DROP TABLE IF EXISTS `cms_role`;
CREATE TABLE `cms_role` (
  `id` varchar(32) NOT NULL COMMENT '角色ID编号',
  `role_name` varchar(30) NOT NULL COMMENT '角色名称',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '角色状态 1-启用 0-停用 默认为1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cms_role
-- ----------------------------
INSERT INTO `cms_role` VALUES ('ROLE_201808300246497861', '角色一', '1', '2018-08-30 02:46:49', '2018-08-30 02:46:49');
INSERT INTO `cms_role` VALUES ('1', '管理员', '1', '2018-08-15 06:29:28', '2018-08-15 06:46:00');
INSERT INTO `cms_role` VALUES ('ROLE_201809040927107504', 'ceshi', '1', '2018-09-04 09:27:10', '2018-09-04 09:27:10');

-- ----------------------------
-- Table structure for cms_rule
-- ----------------------------
DROP TABLE IF EXISTS `cms_rule`;
CREATE TABLE `cms_rule` (
  `id` varchar(32) NOT NULL,
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '路由名称',
  `route` varchar(60) NOT NULL DEFAULT '/' COMMENT '路由规则',
  `menu_id` varchar(32) NOT NULL DEFAULT '0' COMMENT '所属菜单',
  `sort` varchar(4) DEFAULT '0' COMMENT '规则序号',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态 1-启用 2-禁用',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_rule_menu_id` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_rule
-- ----------------------------
INSERT INTO `cms_rule` VALUES ('RULE_201808300243148041', '菜单列表', 'admin/menu/index', 'MENU_201808300237076705', '0101', '1', '2018-08-30 02:43:14', '2018-08-30 02:43:14');
INSERT INTO `cms_rule` VALUES ('RULE_201808300243505712', '添加菜单', 'admin/menu/add', 'MENU_201808300237076705', '0102', '1', '2018-08-30 02:43:50', '2018-08-30 02:43:50');
INSERT INTO `cms_rule` VALUES ('RULE_201808300244237279', '修改菜单', 'admin/menu/edit', 'MENU_201808300237076705', '0103', '1', '2018-08-30 02:44:23', '2018-08-30 02:44:23');
INSERT INTO `cms_rule` VALUES ('RULE_201808300245038976', '删除菜单', 'admin/menu/delete', 'MENU_201808300237076705', '0104', '1', '2018-08-30 02:45:03', '2018-08-30 02:45:03');
INSERT INTO `cms_rule` VALUES ('RULE_201808300245335999', '修改菜单状态', 'admin/menu/update_status', 'MENU_201808300237076705', '0105', '1', '2018-08-30 02:45:33', '2018-08-30 02:45:33');
INSERT INTO `cms_rule` VALUES ('RULE_201808300245588259', '获取菜单状态', 'admin/menu/get_menu_level', 'MENU_201808300237076705', '0106', '1', '2018-08-30 02:45:58', '2018-08-30 02:45:58');
INSERT INTO `cms_rule` VALUES ('RULE_201808300246294010', '权限列表', 'admin/rule/index', 'MENU_201808300240082440', '0201', '1', '2018-08-30 02:46:29', '2018-08-30 02:46:29');

-- ----------------------------
-- Table structure for cms_tag
-- ----------------------------
DROP TABLE IF EXISTS `cms_tag`;
CREATE TABLE `cms_tag` (
  `id` varchar(32) NOT NULL,
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '路由规则',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态 1-启用 0-禁用',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_tag
-- ----------------------------
INSERT INTO `cms_tag` VALUES ('1', '标签1', '1', null, '2018-09-05 10:06:26');
INSERT INTO `cms_tag` VALUES ('TAG_201809051007124367', '标签2', '1', '2018-09-05 10:07:12', '2018-09-05 10:07:12');
INSERT INTO `cms_tag` VALUES ('TAG_201809051008111335', '标签3', '1', '2018-09-05 10:08:11', '2018-09-05 10:08:11');

-- ----------------------------
-- Table structure for cms_user
-- ----------------------------
DROP TABLE IF EXISTS `cms_user`;
CREATE TABLE `cms_user` (
  `id` varchar(32) NOT NULL,
  `account` varchar(20) NOT NULL COMMENT '账户名',
  `nickname` varchar(30) NOT NULL COMMENT '昵称',
  `password` char(32) NOT NULL COMMENT '密码',
  `identify` char(100) DEFAULT NULL COMMENT '第二身份',
  `token` char(100) DEFAULT NULL COMMENT '令牌',
  `deadline` datetime DEFAULT NULL COMMENT '令牌过期时间',
  `e_mail` varchar(30) DEFAULT NULL COMMENT '电子邮件',
  `phone` varchar(20) DEFAULT NULL COMMENT '电话',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `header_img` varchar(100) DEFAULT NULL COMMENT '头像',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_user
-- ----------------------------
INSERT INTO `cms_user` VALUES ('1', 'admin', 'superadmin', '35e078bcb1e78a69c9a88acbe79cefc2', 'YjE2OTQ4MWFiNWViM2MzMzE1MzBmZTVlYjZhOTgzNzY=', 'bc7235a51e34c1d3ebfddeb538c20c71', '2018-09-15 00:51:45', '775669127@qq.com', '18894330931', '1', 'static/admin/img/admin.png', '2018-07-19 02:29:24', '2018-09-08 00:51:45');
INSERT INTO `cms_user` VALUES ('USER_201808300301297631', 'choel', 'choel', 'c712d1741bc27b73cb27eb9d0149165e', 'MmEyYTEyNjFjNmUzNjI0MGQ1MWYyZDUzMmZlNzE4NzQ=', 'bd4da34a1b327d0d35bad998ef535b02', '2018-09-07 03:53:33', 'choel_wu@foxmail.com', '18894330931', '1', 'uploads/user/header_img/201808300307175b875f654f594.jpg', '2018-08-30 03:01:29', '2018-08-31 03:53:33');

-- ----------------------------
-- Table structure for cms_user_role
-- ----------------------------
DROP TABLE IF EXISTS `cms_user_role`;
CREATE TABLE `cms_user_role` (
  `id` varchar(32) NOT NULL,
  `user_id` varchar(32) NOT NULL COMMENT '用户id',
  `role_id` varchar(32) NOT NULL COMMENT '角色id',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_role_user_id` (`user_id`),
  KEY `idx_user_role_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_user_role
-- ----------------------------
INSERT INTO `cms_user_role` VALUES ('1', '1', '1', null, null);
INSERT INTO `cms_user_role` VALUES ('USERROLE_201808300301296704', 'USER_201808300301297631', 'ROLE_201808300246497861', '2018-08-30 03:01:29', '2018-08-30 03:10:21');
