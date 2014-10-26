/*
Navicat MySQL Data Transfer

Source Server         : 本机
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : edu-default

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2014-10-26 13:56:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `edu_class`
-- ----------------------------
DROP TABLE IF EXISTS `edu_class`;
CREATE TABLE `edu_class` (
`edu_id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户组ID' ,
`edu_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户组名' ,
`edu_read`  int(11) NULL DEFAULT 0 COMMENT '阅读权' ,
`edu_write`  int(11) NULL DEFAULT 0 COMMENT '发帖权' ,
`edu_delete`  int(11) NULL DEFAULT 0 COMMENT '删贴权' ,
`edu_update`  int(11) NULL DEFAULT 0 COMMENT '贴修改权' ,
PRIMARY KEY (`edu_id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=4
CHECKSUM=0
ROW_FORMAT=Dynamic
DELAY_KEY_WRITE=0

;

-- ----------------------------
-- Records of edu_class
-- ----------------------------
BEGIN;
INSERT INTO `edu_class` (`edu_id`, `edu_name`, `edu_read`, `edu_write`, `edu_delete`, `edu_update`) VALUES ('1', '游客', '1', '0', '0', '0'), ('2', '注册用户', '1', '1', '0', '1'), ('3', '管理员', '1', '1', '1', '1');
COMMIT;

-- ----------------------------
-- Table structure for `edu_essay`
-- ----------------------------
DROP TABLE IF EXISTS `edu_essay`;
CREATE TABLE `edu_essay` (
`edu_id`  bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文章ID' ,
`edu_user_id`  bigint(20) NOT NULL COMMENT '发表用户ID' ,
`edu_title`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '标题' ,
`edu_text`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章' ,
`edu_count`  int(11) UNSIGNED NULL DEFAULT 0 COMMENT '阅读次数' ,
`edu_essayclass_id`  int(11) NULL DEFAULT 1 ,
`edu_time`  timestamp NULL DEFAULT NULL COMMENT '发表时间' ,
PRIMARY KEY (`edu_id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=12
CHECKSUM=0
ROW_FORMAT=Dynamic
DELAY_KEY_WRITE=0

;

-- ----------------------------
-- Records of edu_essay
-- ----------------------------
BEGIN;
INSERT INTO `edu_essay` (`edu_id`, `edu_user_id`, `edu_title`, `edu_text`, `edu_count`, `edu_essayclass_id`, `edu_time`) VALUES ('1', '1', '标题', '内容1', null, '1', '2014-10-26 00:00:00'), ('2', '1', '标题', '内容2', null, '2', '2014-10-26 00:00:00'), ('3', '1', '标题', '内容3', null, '1', '2014-10-26 00:00:00'), ('4', '1', '标题', '内容4', null, '3', '2014-10-26 00:00:00'), ('5', '1', '标题', '内容5', null, '4', '2014-10-26 00:00:00'), ('6', '1', '标题', '内容6', null, '1', '2014-10-26 00:00:00'), ('7', '1', '标题', '内容7', null, '4', '2014-10-26 00:00:00'), ('8', '1', '标题', '内容8', null, '1', '2014-10-26 00:00:00'), ('9', '1', '标题', '内容9', null, '2', '2014-10-26 00:00:00');
COMMIT;

-- ----------------------------
-- Table structure for `edu_essayclass`
-- ----------------------------
DROP TABLE IF EXISTS `edu_essayclass`;
CREATE TABLE `edu_essayclass` (
`edu_id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文章分类ID' ,
`edu_order`  int(10) UNSIGNED NULL DEFAULT 1 ,
`edu_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类名称' ,
`edu_up_id`  int(10) UNSIGNED NULL DEFAULT 1 ,
`edu_show`  int(11) NULL DEFAULT 1 ,
PRIMARY KEY (`edu_id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=6
CHECKSUM=0
ROW_FORMAT=Dynamic
DELAY_KEY_WRITE=0

;

-- ----------------------------
-- Records of edu_essayclass
-- ----------------------------
BEGIN;
INSERT INTO `edu_essayclass` (`edu_id`, `edu_order`, `edu_name`, `edu_up_id`, `edu_show`) VALUES ('1', '1', '默认分类', '1', '1'), ('2', '3', '校园新闻', '1', '1'), ('3', '2', '政务公开', '1', '1'), ('4', '4', '网上办事', '1', '1'), ('5', '5', '家长留言', '1', '1');
COMMIT;

-- ----------------------------
-- Table structure for `edu_sign_log`
-- ----------------------------
DROP TABLE IF EXISTS `edu_sign_log`;
CREATE TABLE `edu_sign_log` (
`edu_id`  bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
`edu_text`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '用户签名内容' ,
`edu_user_id`  bigint(20) UNSIGNED NOT NULL COMMENT '用户ID' ,
`edu_time`  datetime NOT NULL COMMENT '更改时间' ,
PRIMARY KEY (`edu_id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1
CHECKSUM=0
ROW_FORMAT=Dynamic
DELAY_KEY_WRITE=0

;

-- ----------------------------
-- Records of edu_sign_log
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for `edu_user`
-- ----------------------------
DROP TABLE IF EXISTS `edu_user`;
CREATE TABLE `edu_user` (
`edu_id`  bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID' ,
`edu_user`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户账号' ,
`edu_passwd`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户密码' ,
`edu_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户昵称' ,
`edu_sign`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户签名' ,
`edu_class_id`  int(11) UNSIGNED NULL DEFAULT 1 COMMENT '用户等级' ,
PRIMARY KEY (`edu_id`),
INDEX `账号索引` (`edu_id`, `edu_user`) USING BTREE 
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=3
CHECKSUM=0
ROW_FORMAT=Dynamic
DELAY_KEY_WRITE=0

;

-- ----------------------------
-- Records of edu_user
-- ----------------------------
BEGIN;
INSERT INTO `edu_user` (`edu_id`, `edu_user`, `edu_passwd`, `edu_name`, `edu_sign`, `edu_class_id`) VALUES ('1', 'admin', '', '', '', '3'), ('2', 'root', '', '', '', '2');
COMMIT;

-- ----------------------------
-- Auto increment value for `edu_class`
-- ----------------------------
ALTER TABLE `edu_class` AUTO_INCREMENT=4;

-- ----------------------------
-- Auto increment value for `edu_essay`
-- ----------------------------
ALTER TABLE `edu_essay` AUTO_INCREMENT=12;

-- ----------------------------
-- Auto increment value for `edu_essayclass`
-- ----------------------------
ALTER TABLE `edu_essayclass` AUTO_INCREMENT=6;

-- ----------------------------
-- Auto increment value for `edu_sign_log`
-- ----------------------------
ALTER TABLE `edu_sign_log` AUTO_INCREMENT=1;

-- ----------------------------
-- Auto increment value for `edu_user`
-- ----------------------------
ALTER TABLE `edu_user` AUTO_INCREMENT=3;
