/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1@localhost
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : applcon_mall

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-03-05 22:19:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `am_access`
-- ----------------------------
DROP TABLE IF EXISTS `am_access`;
CREATE TABLE `am_access` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `object` varchar(64) NOT NULL,
  `action` varchar(255) NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of am_access
-- ----------------------------
INSERT INTO `am_access` VALUES ('1', 'AdminArea', 'access', '1', 'allow');
INSERT INTO `am_access` VALUES ('2', 'AdminArea', 'access', '2', 'deny');
INSERT INTO `am_access` VALUES ('3', 'AdminArea', 'access', '3', 'deny');

-- ----------------------------
-- Table structure for `am_employee`
-- ----------------------------
DROP TABLE IF EXISTS `am_employee`;
CREATE TABLE `am_employee` (
  `employee_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '员工ID',
  `lang_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '语言ID',
  `lastname` varchar(255) NOT NULL COMMENT '姓',
  `firstname` varchar(255) NOT NULL COMMENT '名',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `last_login_time` int(10) NOT NULL DEFAULT '0' COMMENT '最后一次登录时间',
  PRIMARY KEY (`employee_id`),
  KEY `employee_login` (`email`,`password`),
  KEY `id_employee_password` (`employee_id`,`password`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='员工表';

-- ----------------------------
-- Records of am_employee
-- ----------------------------
INSERT INTO `am_employee` VALUES ('1', '1', 'ShuiRong', 'Yang', '643141017@qq.com', '$2y$12$b0NoTEZvSHdEOHB6a3lBO.TAho9MZ.nN5NYgC9vIVQc4BPbWUBHcW', '1', '164577445');

-- ----------------------------
-- Table structure for `am_failed_login`
-- ----------------------------
DROP TABLE IF EXISTS `am_failed_login`;
CREATE TABLE `am_failed_login` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(10) unsigned DEFAULT NULL,
  `ip_address` int(10) unsigned NOT NULL,
  `attempted` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `failedLoginsAttempts` (`ip_address`,`attempted`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of am_failed_login
-- ----------------------------
INSERT INTO `am_failed_login` VALUES ('28', '1', '2130706433', '1548927046');
INSERT INTO `am_failed_login` VALUES ('29', '1', '2130706433', '1548927241');
INSERT INTO `am_failed_login` VALUES ('30', '1', '2130706433', '1548927434');
INSERT INTO `am_failed_login` VALUES ('31', '1', '2130706433', '1548927553');
INSERT INTO `am_failed_login` VALUES ('32', '1', '2130706433', '1548927564');
INSERT INTO `am_failed_login` VALUES ('33', '1', '2130706433', '1550636884');
INSERT INTO `am_failed_login` VALUES ('34', '1', '2130706433', '1550637279');
INSERT INTO `am_failed_login` VALUES ('35', '1', '2130706433', '1550637283');

-- ----------------------------
-- Table structure for `am_roles`
-- ----------------------------
DROP TABLE IF EXISTS `am_roles`;
CREATE TABLE `am_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text,
  `type` varchar(32) NOT NULL,
  `is_special` tinyint(1) DEFAULT '0',
  `is_default` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of am_roles
-- ----------------------------
INSERT INTO `am_roles` VALUES ('1', 'Admins', 'Administrative user, has access to everything.', 'admin', '1', '0');
INSERT INTO `am_roles` VALUES ('2', 'Moderators', 'The regular members with moderation privileges.', 'moderator', '1', '0');
INSERT INTO `am_roles` VALUES ('3', 'Users', 'Member privileges, granted after account confirmation.', 'user', '1', '1');
INSERT INTO `am_roles` VALUES ('4', 'Anonymous', 'Guests can only view content. Anyone browsing the site who is not signed in is considered to be a \"Guest\".', 'guest', '1', '0');

-- ----------------------------
-- Table structure for `am_roles_users`
-- ----------------------------
DROP TABLE IF EXISTS `am_roles_users`;
CREATE TABLE `am_roles_users` (
  `users_id` bigint(20) unsigned NOT NULL,
  `roles_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`users_id`,`roles_id`),
  KEY `roles_users_users_id` (`users_id`),
  KEY `roles_users_roles_id` (`roles_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of am_roles_users
-- ----------------------------
INSERT INTO `am_roles_users` VALUES ('1', '1');
INSERT INTO `am_roles_users` VALUES ('1', '2');
INSERT INTO `am_roles_users` VALUES ('1', '3');

-- ----------------------------
-- Table structure for `am_success_login`
-- ----------------------------
DROP TABLE IF EXISTS `am_success_login`;
CREATE TABLE `am_success_login` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(10) unsigned NOT NULL,
  `ip_address` int(10) unsigned NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `failedLoginsAttempts` (`ip_address`,`user_agent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of am_success_login
-- ----------------------------
