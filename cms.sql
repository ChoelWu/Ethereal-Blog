/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50721
Source Host           : localhost:3306
Source Database       : cms

Target Server Type    : MYSQL
Target Server Version : 50721
File Encoding         : 65001

Date: 2018-08-28 09:56:48
*/

SET FOREIGN_KEY_CHECKS=0;

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
INSERT INTO `cms_menu` VALUES ('MENU_201807081232405884', '系统管理', '1', '0', 'gears', '1000', '#', '1', '2018-07-08 12:32:40', '2018-07-08 14:41:30');
INSERT INTO `cms_menu` VALUES ('MENU_201807121319237643', '菜单管理', '2', 'MENU_201807081232405884', 'tasks', '1011', 'admin/menu/index', '1', '2018-07-12 13:19:23', '2018-07-12 13:19:23');
INSERT INTO `cms_menu` VALUES ('MENU_201807121320122812', '用户管理', '2', 'MENU_201807081232405884', 'user', '1012', 'admin/user/index', '1', '2018-07-12 13:20:12', '2018-07-12 13:20:12');
INSERT INTO `cms_menu` VALUES ('MENU_201808150058084292', '角色管理', '2', 'MENU_201807081232405884', 'vcard', '1013', 'admin/role/index', '1', '2018-08-15 00:58:08', '2018-08-15 00:58:08');
INSERT INTO `cms_menu` VALUES ('MENU_201808150654154758', '权限规则', '2', 'MENU_201807081232405884', 'list-alt', '1014', 'admin/rule/index', '1', '2018-08-15 06:54:15', '2018-08-15 06:58:32');
INSERT INTO `cms_menu` VALUES ('MENU_201808270946388356', '测试菜单', '1', '0', 'book', '2000', 'text', '1', '2018-08-27 09:46:38', '2018-08-27 09:46:38');

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
INSERT INTO `cms_role` VALUES ('ROLE_201808270734035809', '管理员', '1', '2018-08-27 07:34:03', '2018-08-27 07:34:03');
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
INSERT INTO `cms_rule` VALUES ('RULE_201808250222121966', '菜单显示', 'admin/menu/index', 'MENU_201807121319237643', '0100', '1', '2018-08-25 02:22:12', '2018-08-25 02:25:10');
INSERT INTO `cms_rule` VALUES ('RULE_201808250222362469', '添加菜单', 'admin/menu/add', 'MENU_201807121319237643', '0101', '1', '2018-08-25 02:22:36', '2018-08-25 02:25:22');
INSERT INTO `cms_rule` VALUES ('RULE_201808250226004819', '编辑菜单', 'admin/menu/edit', 'MENU_201807121319237643', '0102', '1', '2018-08-25 02:26:00', '2018-08-25 02:40:16');
INSERT INTO `cms_rule` VALUES ('RULE_201808250227073506', '删除菜单', 'admin/menu/delete', 'MENU_201807121319237643', '0103', '1', '2018-08-25 02:27:07', '2018-08-25 02:27:07');
INSERT INTO `cms_rule` VALUES ('RULE_201808250229128549', '修改菜单状态', 'admin/menu/update_status', 'MENU_201807121319237643', '0104', '1', '2018-08-25 02:29:12', '2018-08-25 02:29:12');
INSERT INTO `cms_rule` VALUES ('RULE_201808250230067306', '获取菜单级别', 'admin/menu/get_menu_level', 'MENU_201807121319237643', '0105', '1', '2018-08-25 02:30:06', '2018-08-25 02:30:06');
INSERT INTO `cms_rule` VALUES ('RULE_201808250230507623', '用户列表显示', 'admin/user/index', 'MENU_201807121320122812', '0200', '1', '2018-08-25 02:30:50', '2018-08-25 02:30:50');
INSERT INTO `cms_rule` VALUES ('RULE_201808250233539347', '添加用户', 'admin/user/add', 'MENU_201807121320122812', '0201', '1', '2018-08-25 02:33:53', '2018-08-25 02:33:53');
INSERT INTO `cms_rule` VALUES ('RULE_201808250234299011', '修改用户', 'admin/user/edit', 'MENU_201807121320122812', '0202', '1', '2018-08-25 02:34:29', '2018-08-25 02:34:29');
INSERT INTO `cms_rule` VALUES ('RULE_201808250235376083', '用户头像上传', 'admn/user/upload', 'MENU_201807121320122812', '0203', '1', '2018-08-25 02:35:37', '2018-08-25 02:35:37');
INSERT INTO `cms_rule` VALUES ('RULE_201808250236139314', '删除用户', 'admin/user/delete', 'MENU_201807121320122812', '0204', '1', '2018-08-25 02:36:13', '2018-08-25 02:36:13');
INSERT INTO `cms_rule` VALUES ('RULE_201808250238146110', '角色授权', 'admin/role/authorize', 'MENU_201808150058084292', '0305', '1', '2018-08-25 02:38:14', '2018-08-25 02:42:42');
INSERT INTO `cms_rule` VALUES ('RULE_201808250239178260', '角色列表显示', 'admin/role/index', 'MENU_201808150058084292', '0300', '1', '2018-08-25 02:39:17', '2018-08-25 02:39:17');
INSERT INTO `cms_rule` VALUES ('RULE_201808250239491074', '添加角色', 'admin/role/add', 'MENU_201808150058084292', '0301', '1', '2018-08-25 02:39:49', '2018-08-25 02:39:49');
INSERT INTO `cms_rule` VALUES ('RULE_201808250240473046', '修改角色', 'admin/role/edit/', 'MENU_201808150058084292', '0302', '1', '2018-08-25 02:40:47', '2018-08-25 02:40:47');
INSERT INTO `cms_rule` VALUES ('RULE_201808250241319108', '删除角色', 'admin/role/delete', 'MENU_201808150058084292', '0303', '1', '2018-08-25 02:41:31', '2018-08-25 02:41:31');
INSERT INTO `cms_rule` VALUES ('RULE_201808250243294119', '用户账号状态更新', 'admin/user/update_status', 'MENU_201807121320122812', '0205', '1', '2018-08-25 02:43:29', '2018-08-25 02:43:29');
INSERT INTO `cms_rule` VALUES ('RULE_201808250244273468', '修改角色状态', 'admin/role/update_status', 'MENU_201808150058084292', '0304', '1', '2018-08-25 02:44:27', '2018-08-25 02:44:27');
INSERT INTO `cms_rule` VALUES ('RULE_201808250247075817', '权限规则显示', 'admin/rule/index', 'MENU_201808150654154758', '0400', '1', '2018-08-25 02:47:07', '2018-08-25 02:47:07');
INSERT INTO `cms_rule` VALUES ('RULE_201808250247391247', '添加规则', 'admin/rule/add', 'MENU_201808150654154758', '0401', '1', '2018-08-25 02:47:39', '2018-08-25 02:47:39');
INSERT INTO `cms_rule` VALUES ('RULE_201808250248081073', '修改规则', 'admin/rule/edit', 'MENU_201808150654154758', '0402', '1', '2018-08-25 02:48:08', '2018-08-25 02:48:08');
INSERT INTO `cms_rule` VALUES ('RULE_201808250248312986', '删除规则', 'admin/rule/delete', 'MENU_201808150654154758', '0403', '1', '2018-08-25 02:48:31', '2018-08-25 02:48:31');
INSERT INTO `cms_rule` VALUES ('RULE_201808250249077536', '修改规则状态', 'admin/rule/update_status', 'MENU_201808150654154758', '0404', '1', '2018-08-25 02:49:07', '2018-08-25 02:49:07');

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
  `header_img` varchar(50) DEFAULT NULL COMMENT '头像',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_user
-- ----------------------------
INSERT INTO `cms_user` VALUES ('USER_201807190229242575', 'admin', '吴超', 'fa5edb3a4496e51e24e6155de9cc696e', null, null, null, '775669127@qq.com', '18894330931', '1', 'user/header_img/201807190229245b4ff78440d3d.png', '2018-07-19 02:29:24', '2018-07-30 01:32:52');
INSERT INTO `cms_user` VALUES ('USER_201807230214379184', 'choel', 'DedanlionWu', 'fa5edb3a4496e51e24e6155de9cc696e', null, null, null, '775669127@qq.com', '18894330931', '1', 'user/header_img/201807240804165b56dd806f3ef.jpg', '2018-07-23 02:14:37', '2018-07-24 08:04:16');
INSERT INTO `cms_user` VALUES ('USER_201807230244166701', 'wuchao', '吴超', 'b7bbf4fd0a96103338e63cc9b8332019', null, null, null, '775669127@qq.com', '18894330931', '0', '', '2018-07-23 02:44:16', '2018-07-24 08:05:13');
