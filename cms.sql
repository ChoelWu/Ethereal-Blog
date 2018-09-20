/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50721
Source Host           : localhost:3306
Source Database       : cms

Target Server Type    : MYSQL
Target Server Version : 50721
File Encoding         : 65001

Date: 2018-09-20 16:12:56
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
INSERT INTO `cms_authorize` VALUES ('AUTHORIZE_201809200214488089', 'ROLE_201809200214399049', 'admin/menu/index,admin/menu/add', '2018-09-20 02:14:48', '2018-09-20 02:14:48');

-- ----------------------------
-- Table structure for cms_blog
-- ----------------------------
DROP TABLE IF EXISTS `cms_blog`;
CREATE TABLE `cms_blog` (
  `id` varchar(32) NOT NULL,
  `title` varchar(50) NOT NULL COMMENT '博客名',
  `footer` varchar(100) DEFAULT NULL COMMENT '博客页脚',
  `slogan` varchar(150) DEFAULT NULL COMMENT '标语',
  `user_name` varchar(32) DEFAULT NULL COMMENT '用户中文名',
  `user_open_img` varchar(200) DEFAULT NULL COMMENT '公开头像',
  `user_profession` varchar(100) DEFAULT NULL COMMENT '职业',
  `user_announce` varchar(200) DEFAULT NULL COMMENT '声明',
  `user_bak` varchar(600) DEFAULT NULL COMMENT '用户备注信息',
  `user_wechat` varchar(50) DEFAULT NULL COMMENT '用户公开微信',
  `user_QQ` varchar(30) DEFAULT NULL COMMENT '用户公开QQ',
  `user_weibo` varchar(30) DEFAULT NULL COMMENT '用户公开微博',
  `user_email` varchar(50) DEFAULT NULL COMMENT '用户公开邮箱',
  `user_github` varchar(50) DEFAULT NULL COMMENT '用户公开github',
  `status` char(1) DEFAULT '1' COMMENT '博客使用状态  1-启用  0-禁用',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_blog
-- ----------------------------
INSERT INTO `cms_blog` VALUES ('1', '和解', 'Copyright Example Company © 2014-2017', '和过去和解吧', 'Charlse', '1111', '码农', '和过去和解吧', '和过去和解吧', 'wuchao775669127', '775669127', 'echo_去踏马的梦', 'choel_wu@foxmail.com', 'https://github.com/ChoelWu', '1', null, '2018-09-14 07:31:47');

-- ----------------------------
-- Table structure for cms_comment
-- ----------------------------
DROP TABLE IF EXISTS `cms_comment`;
CREATE TABLE `cms_comment` (
  `id` varchar(32) NOT NULL,
  `user_id` varchar(32) NOT NULL COMMENT '用户id',
  `article_id` varchar(32) NOT NULL COMMENT '文章id',
  `content` varchar(900) NOT NULL COMMENT '评论内容',
  `type` char(1) NOT NULL DEFAULT '1' COMMENT '1-评论 2-回复',
  `response_id` varchar(32) NOT NULL DEFAULT '' COMMENT '回复的信息的id',
  `praise` int(11) NOT NULL DEFAULT '0' COMMENT '赞数',
  `is_top` char(1) NOT NULL DEFAULT '0' COMMENT '是否置顶 0-不置顶   1-置顶',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态 1-正常 0-删除',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_comment_user_id` (`user_id`),
  KEY `idx_comment_article_id` (`article_id`),
  KEY `idx_comment_response_id` (`response_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_comment
-- ----------------------------
INSERT INTO `cms_comment` VALUES ('1', 'USER_201808300301297631', 'ARTICLE_201809060209077253', 'Support for adding emoji into textarea or editable div, automatic identification of element types.如果是textarea，则选择表情后插入表情代码，如果是可编辑div，则直接插入表情图片', '2', '1', '0', '0', '1', null, '2018-09-11 07:41:47');

-- ----------------------------
-- Table structure for cms_comment_sensitive_word
-- ----------------------------
DROP TABLE IF EXISTS `cms_comment_sensitive_word`;
CREATE TABLE `cms_comment_sensitive_word` (
  `id` varchar(50) NOT NULL,
  `word` varchar(30) NOT NULL DEFAULT '' COMMENT '敏感词',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_comment_sensitive_word
-- ----------------------------

-- ----------------------------
-- Table structure for cms_content_module
-- ----------------------------
DROP TABLE IF EXISTS `cms_content_module`;
CREATE TABLE `cms_content_module` (
  `id` varchar(32) NOT NULL,
  `name` varchar(30) NOT NULL COMMENT '变量名称',
  `type` char(1) NOT NULL DEFAULT '0' COMMENT '模块类型 0-普通列表 1-首页图 2-广告标语',
  `attach` varchar(32) DEFAULT NULL COMMENT '关联',
  `number` int(11) NOT NULL DEFAULT '4' COMMENT '内容数量',
  `single_length` int(11) DEFAULT '20' COMMENT '单条长度',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态 1-启用 0-禁用',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_content_module_name` (`name`),
  KEY `idx_content_module_nav_id` (`attach`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_content_module
-- ----------------------------
INSERT INTO `cms_content_module` VALUES ('CONTENTMODULE_201809080133477348', '111', '0', 'NAV_201809050939183546', '222', '222', '1', '2018-09-08 01:33:47', '2018-09-08 07:31:45');

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
INSERT INTO `cms_menu` VALUES ('MENU_201809170945076852', '系统管理', '1', '0', 'gears', '0100', '#', '1', '2018-09-17 09:45:07', '2018-09-17 09:53:48');
INSERT INTO `cms_menu` VALUES ('MENU_201809170949541218', '菜单管理', '2', 'MENU_201809170945076852', 'book', '0101', 'admin/menu/index', '1', '2018-09-17 09:49:54', '2018-09-17 09:49:54');
INSERT INTO `cms_menu` VALUES ('MENU_201809171004587602', '权限管理', '2', 'MENU_201809170945076852', 'toggle-on', '0102', 'admin/rule/index', '1', '2018-09-17 10:04:58', '2018-09-17 10:04:58');
INSERT INTO `cms_menu` VALUES ('MENU_201809171006384106', '角色管理', '2', 'MENU_201809170945076852', 'user', '0103', 'admin/role/index', '1', '2018-09-17 10:06:38', '2018-09-17 10:14:54');
INSERT INTO `cms_menu` VALUES ('MENU_201809171011194587', '用户管理', '2', 'MENU_201809170945076852', 'vcard', '0104', 'admin/user/index', '1', '2018-09-17 10:11:19', '2018-09-20 06:54:45');
INSERT INTO `cms_menu` VALUES ('MENU_201809171014254189', '网站配置', '2', 'MENU_201809170945076852', 'cog', '0105', 'admin/system/index', '1', '2018-09-17 10:14:25', '2018-09-18 01:57:24');
INSERT INTO `cms_menu` VALUES ('MENU_201809171015532971', '内容管理', '1', '0', 'list-alt', '0200', '#', '1', '2018-09-17 10:15:53', '2018-09-18 01:44:36');
INSERT INTO `cms_menu` VALUES ('MENU_201809171017179259', '标签管理', '2', 'MENU_201809171015532971', 'tag', '0201', 'admin/tag/index', '1', '2018-09-17 10:17:17', '2018-09-17 10:17:17');
INSERT INTO `cms_menu` VALUES ('MENU_201809171018023947', '文章管理', '2', 'MENU_201809171015532971', 'file', '0202', 'admin/article/index', '1', '2018-09-17 10:18:02', '2018-09-18 01:21:51');
INSERT INTO `cms_menu` VALUES ('MENU_201809180124108985', '评论管理', '2', 'MENU_201809171015532971', 'commenting', '0203', 'admin/comment/index', '1', '2018-09-18 01:24:10', '2018-09-18 01:29:41');
INSERT INTO `cms_menu` VALUES ('MENU_201809180128538134', '微信管理', '1', '0', 'wechat', '0300', '#', '1', '2018-09-18 01:28:53', '2018-09-18 01:41:28');
INSERT INTO `cms_menu` VALUES ('MENU_201809180131136245', '博客管理', '1', '0', 'sliders', '0400', '#', '1', '2018-09-18 01:31:13', '2018-09-18 01:43:10');
INSERT INTO `cms_menu` VALUES ('MENU_201809180132544430', '导航管理', '2', 'MENU_201809180131136245', 'sitemap', '0401', 'admin/nav/index', '1', '2018-09-18 01:32:54', '2018-09-18 01:32:54');
INSERT INTO `cms_menu` VALUES ('MENU_201809180133473179', '模块管理', '2', 'MENU_201809180131136245', 'window-maximize', '0404', 'admn/model/index', '1', '2018-09-18 01:33:47', '2018-09-18 02:05:14');
INSERT INTO `cms_menu` VALUES ('MENU_201809180134259385', '海报管理', '2', 'MENU_201809180131136245', 'picture-o', '0402', 'admin/poster/index', '1', '2018-09-18 01:34:25', '2018-09-18 02:05:41');
INSERT INTO `cms_menu` VALUES ('MENU_201809180135387109', '广告位管理', '2', 'MENU_201809180131136245', 'bullhorn', '0403', 'admin/slogan/index', '1', '2018-09-18 01:35:38', '2018-09-18 02:05:31');
INSERT INTO `cms_menu` VALUES ('MENU_201809180145441655', '博客配置', '2', 'MENU_201809180131136245', 'wrench', '0405', 'admin/blog/index', '1', '2018-09-18 01:45:44', '2018-09-18 01:55:42');
INSERT INTO `cms_menu` VALUES ('MENU_201809180159359421', '个人信息', '1', '0', 'user-circle', '0500', 'admin/info/index', '1', '2018-09-18 01:59:35', '2018-09-18 01:59:53');

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
-- Table structure for cms_poster
-- ----------------------------
DROP TABLE IF EXISTS `cms_poster`;
CREATE TABLE `cms_poster` (
  `id` varchar(32) NOT NULL,
  `title` varchar(100) NOT NULL COMMENT '海报标题',
  `summary` varchar(900) NOT NULL COMMENT '简介',
  `url` varchar(200) DEFAULT NULL COMMENT '链接地址',
  `img` varchar(100) NOT NULL COMMENT '图片地址',
  `is_top` char(1) NOT NULL DEFAULT '0' COMMENT '是否置顶 0-不置顶   1-置顶',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态 1-启用 0-禁用',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_poster_title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_poster
-- ----------------------------
INSERT INTO `cms_poster` VALUES ('2', '百年师大喜迎7000多名2018级新同学', '初秋金城，瓜果飘香。9月3日，西北师范大学迎来自全国各地的2018级新生。4242名本科生，134名预科生，161名专升本，2680名硕士研究生，124名博士研究生，179名留学生怀揣着对大学生活的憧憬，迈入百年学府西北师范大学。', 'https://www.nwnu.edu.cn/upload/420180903071031.jpg', 'https://www.nwnu.edu.cn/upload/420180903071031.jpg', '0', '1', null, null);
INSERT INTO `cms_poster` VALUES ('POSTER_201809120354093603', '西北师大联合主办第二届中国与中亚人文交流与合作国际论坛', '在“一带一路”倡议提出5周年之际，为了深入发掘中国与中亚国家在丝绸之路上交往的历史，进一步加强中国与中亚国家的人文交流与合作，9月7日至10日，第二届中国与中亚人文交流与合作国际论坛在甘肃敦煌召开，该论坛是2018年丝绸之路（敦煌）国际文化博览会系列活动之一。', 'http://news.nwnu.edu.cn/index.php/content/3619.html', 'uploads/poster/img/201809120354095b988de15bf24.png', '0', '1', '2018-09-12 03:54:09', '2018-09-12 03:54:09');
INSERT INTO `cms_poster` VALUES ('POSTER_201809120357376007', '西北师大张新艳同学荣获亚运会女子3000米障碍赛第四名', '在8月27日举行的2018年雅加达亚运会女子3000米障碍赛中，西北师范大学体育学院2018级研究生张新艳以9分46秒30的优异成绩勇夺第四名，为祖国和母校赢得了荣誉。', 'http://news.nwnu.edu.cn/index.php/content/3536.html', 'uploads/poster/img/201809120357375b988eb149881.jpg', '0', '1', '2018-09-12 03:57:37', '2018-09-12 03:57:37');
INSERT INTO `cms_poster` VALUES ('POSTER_201809120556174792', '百年师大喜迎7000多名2018级新同学', '初秋金城，瓜果飘香。9月3日，西北师范大学迎来自全国各地的2018级新生。4242名本科生，134名预科生，161名专升本，2680名硕士研究生，124名博士研究生，179名留学生怀揣着对大学生活的憧憬，迈入百年学府西北师范大学。', 'http://news.nwnu.edu.cn/Index.php/jinqiyaowen/3561.html', 'uploads/poster/img/201809120556175b98aa81838ee.jpg', '1', '1', '2018-09-12 05:56:17', '2018-09-12 07:12:53');
INSERT INTO `cms_poster` VALUES ('POSTER_201809120559328741', '百年师大喜迎7000多名2018级新同学', '广东籍的尹同学参观完校园后，感叹到：“学校智慧餐厅快捷安全、菜品繁多。我很喜欢这里，想更快地熟悉校园环境，尽快融入其中。” “第一次带孩子出远门，我们对报到流程不熟悉，有点紧张。学校迎新工作做得很好，一进校门就有志愿者接待、帮忙搬行李、指引道路。”一位新生家长告诉记者。', 'http://news.nwnu.edu.cn/Index.php/jinqiyaowen/3561.html', 'uploads/poster/img/201809120559325b98ab44b4e7a.jpg', '0', '0', '2018-09-12 05:59:32', '2018-09-12 07:16:45');

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
INSERT INTO `cms_role` VALUES ('1', '管理员', '1', '2018-08-15 06:29:28', '2018-08-15 06:46:00');
INSERT INTO `cms_role` VALUES ('ROLE_201809200214399049', '角色一', '1', '2018-09-20 02:14:39', '2018-09-20 02:14:39');

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
INSERT INTO `cms_rule` VALUES ('RULE_201809190059417617', '菜单列表', 'admin/menu/index', 'MENU_201809170949541218', '0101', '1', '2018-09-19 00:59:41', '2018-09-19 01:01:28');
INSERT INTO `cms_rule` VALUES ('RULE_201809190100446897', '新增菜单', 'admin/menu/add', 'MENU_201809170949541218', '0102', '1', '2018-09-19 01:00:44', '2018-09-19 01:44:41');

-- ----------------------------
-- Table structure for cms_slogan
-- ----------------------------
DROP TABLE IF EXISTS `cms_slogan`;
CREATE TABLE `cms_slogan` (
  `id` varchar(32) NOT NULL,
  `title` varchar(100) NOT NULL COMMENT '标题',
  `url` varchar(100) DEFAULT NULL COMMENT '链接地址',
  `img` varchar(100) NOT NULL COMMENT '图片地址',
  `is_top` char(1) NOT NULL DEFAULT '0' COMMENT '是否置顶 0-不置顶   1-置顶',
  `summary` varchar(900) DEFAULT NULL COMMENT '内容简要',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态 1-启用 0-禁用',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_slogan_title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_slogan
-- ----------------------------
INSERT INTO `cms_slogan` VALUES ('SLOGAN_201809120742006010', '广告位招租', 'www.baidu.com', '', '0', '广告位招租www.baidu.com', '1', '2018-09-12 07:42:00', '2018-09-12 07:42:00');

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
INSERT INTO `cms_tag` VALUES ('1', '标签1', '1', null, '2018-09-20 07:30:21');
INSERT INTO `cms_tag` VALUES ('TAG_201809051007124367', '标签2', '1', '2018-09-05 10:07:12', '2018-09-05 10:07:12');
INSERT INTO `cms_tag` VALUES ('TAG_201809200736563658', '标签', '1', '2018-09-20 07:36:56', '2018-09-20 07:36:56');
INSERT INTO `cms_tag` VALUES ('TAG_201809200803574928', '标签12', '1', '2018-09-20 08:03:57', '2018-09-20 08:04:07');

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
INSERT INTO `cms_user` VALUES ('USER_201808300301297631', 'choel', 'choel', 'c712d1741bc27b73cb27eb9d0149165e', 'MmEyYTEyNjFjNmUzNjI0MGQ1MWYyZDUzMmZlNzE4NzQ=', 'bd4da34a1b327d0d35bad998ef535b02', '2018-09-07 03:53:33', 'choel_wu@foxmail.com', '18894330931', '1', 'uploads/user/header_img/201808300307175b875f654f594.jpg', '2018-08-30 03:01:29', '2018-09-20 07:03:04');
INSERT INTO `cms_user` VALUES ('USER_201809200304303012', '775669127', '吴超', '85e3d6db536aa151732b356349b6a09f', null, null, null, '775669127@qq.com', '18894330931', '1', 'uploads/user/header_img/201809200611185ba33a0649de0.jpg', '2018-09-20 03:04:30', '2018-09-20 06:11:18');
INSERT INTO `cms_user` VALUES ('USER_201809200304308286', '7756691272', '吴超', '34d097964f8c2784a0f0543d26c00471', null, null, null, '775669127@qq.com', '18894330931', '1', 'uploads/user/header_img/201809200612355ba33a535a123.jpg', '2018-09-20 03:04:30', '2018-09-20 06:25:18');
INSERT INTO `cms_user` VALUES ('USER_201809200617453504', 'laowu', '123123', 'b88b88ac72cd19189aa3b45e72a7970f', null, null, null, '775669127@qq.com', '18894330931', '1', 'uploads/user/header_img/201809200617455ba33b895b645.jpg', '2018-09-20 06:17:45', '2018-09-20 06:17:45');

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
INSERT INTO `cms_user_role` VALUES ('USERROLE_201809200304306466', 'USER_201809200304303012', '选择角色', '2018-09-20 03:04:30', '2018-09-20 03:07:57');
INSERT INTO `cms_user_role` VALUES ('USERROLE_201809200304308312', 'USER_201809200304308286', 'ROLE_201809200214399049', '2018-09-20 03:04:30', '2018-09-20 06:50:32');
INSERT INTO `cms_user_role` VALUES ('USERROLE_201809200617452926', 'USER_201809200617453504', '选择角色', '2018-09-20 06:17:45', '2018-09-20 06:17:45');
