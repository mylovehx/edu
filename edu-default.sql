/*
Navicat MySQL Data Transfer

Source Server         : 本机
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : edu-default

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2014-11-05 13:12:11
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
  `edu_uptime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`edu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of edu_essay
-- ----------------------------
INSERT INTO `edu_essay` VALUES ('43', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '2', '2014-11-05 12:37:15', null);
INSERT INTO `edu_essay` VALUES ('44', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '2', '2014-11-05 12:37:17', null);
INSERT INTO `edu_essay` VALUES ('45', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '3', '2014-11-05 12:37:21', null);
INSERT INTO `edu_essay` VALUES ('46', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '3', '2014-11-05 12:37:22', null);
INSERT INTO `edu_essay` VALUES ('47', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '3', '2014-11-05 12:37:23', null);
INSERT INTO `edu_essay` VALUES ('48', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '3', '2014-11-05 12:37:24', null);
INSERT INTO `edu_essay` VALUES ('49', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '3', '2014-11-05 12:37:25', null);
INSERT INTO `edu_essay` VALUES ('50', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '3', '2014-11-05 12:37:25', null);
INSERT INTO `edu_essay` VALUES ('51', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '3', '2014-11-05 12:37:26', null);
INSERT INTO `edu_essay` VALUES ('52', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '3', '2014-11-05 12:37:27', null);
INSERT INTO `edu_essay` VALUES ('53', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '3', '2014-11-05 12:37:27', null);
INSERT INTO `edu_essay` VALUES ('54', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '3', '2014-11-05 12:37:28', null);
INSERT INTO `edu_essay` VALUES ('55', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '3', '2014-11-05 12:37:28', null);
INSERT INTO `edu_essay` VALUES ('56', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '3', '2014-11-05 12:37:29', null);
INSERT INTO `edu_essay` VALUES ('59', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '3', '2014-11-05 12:37:30', null);
INSERT INTO `edu_essay` VALUES ('60', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '3', '2014-11-05 12:37:31', null);
INSERT INTO `edu_essay` VALUES ('61', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '3', '2014-11-05 12:37:31', null);
INSERT INTO `edu_essay` VALUES ('67', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '4', '2014-11-05 12:37:39', null);
INSERT INTO `edu_essay` VALUES ('69', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '4', '2014-11-05 12:37:40', '2014-11-05 12:44:41');
INSERT INTO `edu_essay` VALUES ('70', '1', '标题', '<p>测试</p><pre class=\"brush:diff;toolbar:false\">&lt;?php\r\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;hello&quot;;\r\n\r\n?&gt;</pre><p><br/></p>', '1', '0', '4', '2014-11-05 12:37:41', null);

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
INSERT INTO `edu_essayclass` VALUES ('1', '5', '默认分类', '默认', '1', '0');
INSERT INTO `edu_essayclass` VALUES ('2', '2', '校园新闻', '默认', '1', '1');
INSERT INTO `edu_essayclass` VALUES ('3', '1', '政务公开', '公务公开', '1', '1');
INSERT INTO `edu_essayclass` VALUES ('4', '3', '网上办事', '默认', '1', '1');
INSERT INTO `edu_essayclass` VALUES ('5', '4', '家长留言', '默认', '1', '1');
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
INSERT INTO `edu_label` VALUES ('2', 'EDU-HOMETITLE', '我们的友谊!   ', '首页LOGO标题');
INSERT INTO `edu_label` VALUES ('3', 'EDU-HOMETEXT', '曾经许多人说过大学里的同学之间不会有真正的友谊。因为太熟悉，也因为有太多的利益之争，名利之累，更因为四年之后，大家天各一方，会逐渐把彼此遗忘。  然而，我却不以为然。大学生之间是有友谊的。我想只要你真诚待你的同学，那么你的同学必然回报你以真诚。唯独此，无论是同学之间的友谊还是同事、亲人之间的友谊都会固若金汤。      ', '首页LOGO内容');
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
  `edu_sign` varchar(255) NOT NULL DEFAULT '个性签名' COMMENT '用户签名',
  `edu_login` int(10) unsigned DEFAULT '1' COMMENT '是否允许登录',
  `edu_class_id` int(11) unsigned DEFAULT '1' COMMENT '用户等级',
  `edu_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '注册时间',
  PRIMARY KEY (`edu_id`,`edu_user`),
  KEY `账号索引` (`edu_id`,`edu_user`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of edu_user
-- ----------------------------
INSERT INTO `edu_user` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '超级管理员', '个性签名', '1', '3', '2014-11-04 23:19:59');
INSERT INTO `edu_user` VALUES ('2', 'vip', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '个性签名', '1', '2', '2014-11-04 23:12:34');
INSERT INTO `edu_user` VALUES ('3', 'vip1', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '个性签名', '1', '2', '2014-11-04 23:12:34');
INSERT INTO `edu_user` VALUES ('4', 'vip2', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '个性签名', '1', '2', '2014-11-04 23:12:32');
INSERT INTO `edu_user` VALUES ('5', 'vip5', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '', '1', '2', '2014-11-05 06:15:26');
INSERT INTO `edu_user` VALUES ('6', 'vip6', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '个性签名', '1', '2', '2014-11-05 12:42:41');
INSERT INTO `edu_user` VALUES ('7', 'vip7', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '', '1', '2', '2014-11-05 06:15:32');
INSERT INTO `edu_user` VALUES ('8', 'vip8', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '', '1', '2', '2014-11-05 06:15:36');
INSERT INTO `edu_user` VALUES ('9', 'vip9', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '', '1', '2', '2014-11-05 06:15:39');
INSERT INTO `edu_user` VALUES ('10', 'vip10', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '', '1', '2', '2014-11-05 06:15:44');
INSERT INTO `edu_user` VALUES ('11', 'vip11', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '', '1', '2', '2014-11-05 06:15:47');
INSERT INTO `edu_user` VALUES ('12', 'vip12', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '', '1', '2', '2014-11-05 06:15:52');
INSERT INTO `edu_user` VALUES ('13', 'vip13', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '', '1', '2', '2014-11-05 06:15:54');
INSERT INTO `edu_user` VALUES ('14', 'vip14', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '', '1', '2', '2014-11-05 06:15:57');
INSERT INTO `edu_user` VALUES ('15', 'vip15', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '', '1', '2', '2014-11-05 06:16:00');
INSERT INTO `edu_user` VALUES ('16', 'vip16', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '', '1', '2', '2014-11-05 06:16:04');
