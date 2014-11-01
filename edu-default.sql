/*
Navicat MySQL Data Transfer

Source Server         : 本机
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : edu-default

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2014-11-01 01:47:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `edu_class`
-- ----------------------------
DROP TABLE IF EXISTS `edu_class`;
CREATE TABLE `edu_class` (
  `edu_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组ID',
  `edu_name` varchar(255) NOT NULL DEFAULT '' COMMENT '用户组名',
  `edu_read` int(11) DEFAULT '0' COMMENT '阅读权',
  `edu_write` int(11) DEFAULT '0' COMMENT '发帖权',
  `edu_delete` int(11) DEFAULT '0' COMMENT '删贴权',
  `edu_update` int(11) DEFAULT '0' COMMENT '贴修改权',
  PRIMARY KEY (`edu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of edu_class
-- ----------------------------
INSERT INTO `edu_class` VALUES ('1', '游客', '1', '0', '0', '0');
INSERT INTO `edu_class` VALUES ('2', '注册用户', '1', '1', '0', '1');
INSERT INTO `edu_class` VALUES ('3', '管理员', '1', '1', '1', '1');

-- ----------------------------
-- Table structure for `edu_essay`
-- ----------------------------
DROP TABLE IF EXISTS `edu_essay`;
CREATE TABLE `edu_essay` (
  `edu_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `edu_user_id` bigint(20) NOT NULL COMMENT '发表用户ID',
  `edu_title` varchar(500) NOT NULL DEFAULT '标题',
  `edu_text` text NOT NULL COMMENT '文章',
  `edu_type` int(10) unsigned DEFAULT '1' COMMENT '文章类型,图文还是纯文本等等',
  `edu_count` int(11) unsigned DEFAULT '0' COMMENT '阅读次数',
  `edu_essayclass_id` int(11) DEFAULT '1',
  `edu_time` timestamp NULL DEFAULT NULL COMMENT '发表时间',
  PRIMARY KEY (`edu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of edu_essay
-- ----------------------------
INSERT INTO `edu_essay` VALUES ('1', '1', '标题', '内容1', '1', null, '1', '2014-10-26 00:00:00');
INSERT INTO `edu_essay` VALUES ('2', '1', '标题', '内容2', '1', null, '2', '2014-10-26 00:00:00');
INSERT INTO `edu_essay` VALUES ('3', '1', '标题', '内容3', '1', null, '1', '2014-10-26 00:00:00');
INSERT INTO `edu_essay` VALUES ('4', '1', '标题', '内容4', '1', null, '3', '2014-10-26 00:00:00');
INSERT INTO `edu_essay` VALUES ('5', '1', '标题', '内容5', '1', null, '4', '2014-10-26 00:00:00');
INSERT INTO `edu_essay` VALUES ('6', '1', '标题', '内容6', '1', null, '1', '2014-10-26 00:00:00');
INSERT INTO `edu_essay` VALUES ('7', '1', '标题', '内容7', '1', null, '4', '2014-10-26 00:00:00');
INSERT INTO `edu_essay` VALUES ('8', '1', '标题', '内容8', '1', null, '1', '2014-10-26 00:00:00');
INSERT INTO `edu_essay` VALUES ('9', '1', '标题', '内容9', '1', null, '2', '2014-10-26 00:00:00');
INSERT INTO `edu_essay` VALUES ('12', '1', '测试', '测试1', '1', '0', '1', null);
INSERT INTO `edu_essay` VALUES ('13', '1', '标题', '测试', '1', '0', '1', null);

-- ----------------------------
-- Table structure for `edu_essayclass`
-- ----------------------------
DROP TABLE IF EXISTS `edu_essayclass`;
CREATE TABLE `edu_essayclass` (
  `edu_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章分类ID',
  `edu_order` int(10) unsigned DEFAULT '1',
  `edu_name` varchar(255) NOT NULL DEFAULT '' COMMENT '分类名称',
  `edu_summary` varchar(255) DEFAULT NULL COMMENT '分类简介',
  `edu_up_id` int(10) unsigned DEFAULT '1',
  `edu_show` int(11) unsigned DEFAULT '1',
  PRIMARY KEY (`edu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of edu_essayclass
-- ----------------------------
INSERT INTO `edu_essayclass` VALUES ('1', '5', '默认分类', '', '1', '0');
INSERT INTO `edu_essayclass` VALUES ('2', '2', '校园新闻', '', '1', '1');
INSERT INTO `edu_essayclass` VALUES ('3', '1', '政务公开', '公务公开', '1', '1');
INSERT INTO `edu_essayclass` VALUES ('4', '3', '网上办事', '', '1', '1');
INSERT INTO `edu_essayclass` VALUES ('5', '4', '家长留言', '', '1', '1');
INSERT INTO `edu_essayclass` VALUES ('6', '999', '默认', '', '1', '0');
INSERT INTO `edu_essayclass` VALUES ('7', '999', '默认', '', '1', '0');
INSERT INTO `edu_essayclass` VALUES ('8', '999', '默认', '', '1', '0');
INSERT INTO `edu_essayclass` VALUES ('9', '999', '默认', '', '1', '0');
INSERT INTO `edu_essayclass` VALUES ('10', '999', '默认', '', '1', '0');

-- ----------------------------
-- Table structure for `edu_label`
-- ----------------------------
DROP TABLE IF EXISTS `edu_label`;
CREATE TABLE `edu_label` (
  `edu_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '标签ID',
  `edu_name` varchar(255) NOT NULL COMMENT '标签名称',
  `edu_values` varchar(255) DEFAULT NULL COMMENT '标签内容',
  `edu_memo` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`edu_id`,`edu_name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of edu_label
-- ----------------------------
INSERT INTO `edu_label` VALUES ('1', 'EDU-WEBNAME', 'EDUCATION 教育学院', '网站名称');
INSERT INTO `edu_label` VALUES ('2', 'EDU-HOMETITLE', '我们的友谊', '首页LOGO标题');
INSERT INTO `edu_label` VALUES ('3', 'EDU-HOMETEXT', '曾经许多人说过大学里的同学之间不会有真正的友谊。因为太熟悉，也因为有太多的利益之争，名利之累，更因为四年之后，大家天各一方，会逐渐把彼此遗忘。  然而，我却不以为然。大学生之间是有友谊的。我想只要你真诚待你的同学，那么你的同学必然回报你以真诚。唯独此，无论是同学之间的友谊还是同事、亲人之间的友谊都会固若金汤。', '首页LOGO内容');
INSERT INTO `edu_label` VALUES ('4', 'EDU-HOMELOGO', 'shuji.jpg', '首页LOGO图片');

-- ----------------------------
-- Table structure for `edu_nav`
-- ----------------------------
DROP TABLE IF EXISTS `edu_nav`;
CREATE TABLE `edu_nav` (
  `edu_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `edu_name` varchar(255) NOT NULL,
  `edu_link` varchar(255) NOT NULL,
  `edu_show` int(11) DEFAULT '1',
  `edu_order` int(11) DEFAULT '999',
  PRIMARY KEY (`edu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of edu_nav
-- ----------------------------
INSERT INTO `edu_nav` VALUES ('1', '学校概况', '.?/index/read', '1', '2');
INSERT INTO `edu_nav` VALUES ('2', '政务公开', '.?/index/list', '1', '1');
INSERT INTO `edu_nav` VALUES ('3', '网上办事', '.?/index/list', '1', '3');
INSERT INTO `edu_nav` VALUES ('4', '校园风采', '.?/index', '1', '4');
INSERT INTO `edu_nav` VALUES ('5', '默认', '.', '0', '999');
INSERT INTO `edu_nav` VALUES ('6', '默认', '.', '0', '999');
INSERT INTO `edu_nav` VALUES ('7', '默认', '.', '0', '999');
INSERT INTO `edu_nav` VALUES ('9', '默认', '.', '0', '999');
INSERT INTO `edu_nav` VALUES ('10', '默认', '.', '0', '999');

-- ----------------------------
-- Table structure for `edu_sign_log`
-- ----------------------------
DROP TABLE IF EXISTS `edu_sign_log`;
CREATE TABLE `edu_sign_log` (
  `edu_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `edu_text` text COMMENT '用户签名内容',
  `edu_user_id` bigint(20) unsigned NOT NULL COMMENT '用户ID',
  `edu_time` datetime NOT NULL COMMENT '更改时间',
  PRIMARY KEY (`edu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of edu_sign_log
-- ----------------------------

-- ----------------------------
-- Table structure for `edu_user`
-- ----------------------------
DROP TABLE IF EXISTS `edu_user`;
CREATE TABLE `edu_user` (
  `edu_id` bigint(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `edu_user` varchar(255) NOT NULL COMMENT '用户账号',
  `edu_passwd` varchar(255) NOT NULL COMMENT '用户密码',
  `edu_name` varchar(255) NOT NULL COMMENT '用户昵称',
  `edu_sign` varchar(255) NOT NULL DEFAULT '' COMMENT '用户签名',
  `edu_class_id` int(11) unsigned DEFAULT '1' COMMENT '用户等级',
  PRIMARY KEY (`edu_id`),
  KEY `账号索引` (`edu_id`,`edu_user`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of edu_user
-- ----------------------------
INSERT INTO `edu_user` VALUES ('1', 'admin', '', '', '', '3');
INSERT INTO `edu_user` VALUES ('2', 'root', '', '', '', '2');
