/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50721
Source Host           : localhost:3306
Source Database       : cms

Target Server Type    : MYSQL
Target Server Version : 50721
File Encoding         : 65001

Date: 2018-08-30 19:08:25
*/

SET FOREIGN_KEY_CHECKS=0;

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
INSERT INTO `cms_menu` VALUES ('MENU_201808300240082440', '权限管理', '2', 'MENU_201808300232288030', 'user', '0102', 'admin/rule/index', '1', '2018-08-30 02:40:08', '2018-08-30 02:40:08');
INSERT INTO `cms_menu` VALUES ('MENU_201808300241344594', '角色管理', '2', 'MENU_201808300232288030', 'user', '0103', 'admin/role/index', '1', '2018-08-30 02:41:34', '2018-08-30 02:41:34');
INSERT INTO `cms_menu` VALUES ('MENU_201808300242103500', '用户管理', '2', 'MENU_201808300232288030', 'user', '1014', 'admin/user/index', '1', '2018-08-30 02:42:10', '2018-08-30 02:42:10');
INSERT INTO `cms_menu` VALUES ('MENU_201808300321167235', '测试菜单', '1', '0', 'book', '0200', '#', '1', '2018-08-30 03:21:16', '2018-08-30 03:30:52');

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
INSERT INTO `cms_role` VALUES ('1', '超级管理员', '1', '2018-08-15 06:29:28', '2018-08-15 06:46:00');

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
-- Table structure for cms_user
-- ----------------------------
DROP TABLE IF EXISTS `cms_user`;
CREATE TABLE `cms_user` (
  `id` varchar(32) NOT NULL,
  `account` varchar(20) NOT NULL COMMENT '账户名',
  `nickname` varchar(30) NOT NULL COMMENT '昵称',
  `password` char(32) NOT NULL COMMENT '密码',
  `identify` char(32) DEFAULT NULL COMMENT '第二身份',
  `token` char(32) DEFAULT NULL COMMENT '令牌',
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
INSERT INTO `cms_user` VALUES ('1', 'admin', '超级管理员', '35e078bcb1e78a69c9a88acbe79cefc2', null, null, null, '775669127@qq.com', '18894330931', '1', 'user/header_img/201807190229245b4ff78440d3d.png', '2018-07-19 02:29:24', '2018-08-29 02:37:16');
INSERT INTO `cms_user` VALUES ('USER_201808300301297631', 'choel', 'choel', 'c712d1741bc27b73cb27eb9d0149165e', null, null, null, 'choel_wu@foxmail.com', '18894330931', '1', 'uploads/user/header_img/201808300307175b875f654f594.jpg', '2018-08-30 03:01:29', '2018-08-30 03:10:21');

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
