-- phpMyAdmin SQL Dump
-- http://www.phpmyadmin.net
--
-- 生成日期: 2014 年 06 月 07 日 19:16

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `IHNBPvFTTrzhfwGpnvyF`
--

-- --------------------------------------------------------

--
-- 表的结构 `cfm_admin_log`
--

CREATE TABLE IF NOT EXISTS `cfm_admin_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `log_info` varchar(255) NOT NULL DEFAULT '',
  `ip_address` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`log_id`),
  KEY `log_time` (`log_time`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `cfm_admin_privilage`
--

CREATE TABLE IF NOT EXISTS `cfm_admin_privilage` (
  `action_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT '0',
  `action_code` int(11) NOT NULL,
  `relevance` int(11) NOT NULL,
  PRIMARY KEY (`action_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `cfm_admin_users`
--

CREATE TABLE IF NOT EXISTS `cfm_admin_users` (
  `admin_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(32) NOT NULL,
  `admin_pass` varchar(32) NOT NULL,
  `salt` int(4) DEFAULT NULL,
  `email` varchar(64) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `add_time` int(11) NOT NULL DEFAULT '0',
  `privilage` varchar(20) DEFAULT NULL,
  `last_login` int(11) DEFAULT NULL,
  `last_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='storage administrators' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `cfm_admin_users`
--

INSERT INTO `cfm_admin_users` (`admin_id`, `admin_name`, `admin_pass`, `salt`, `email`, `phone`, `add_time`, `privilage`, `last_login`, `last_ip`) VALUES
(1, 'rexskz', 'e7f89a9faf5c32b91fc853bfb3bb538e', 4712, 'rex.fgtsky@qq.com', '15895919198', 0, NULL, NULL, '10.50.140.33'),
(2, 'xm1994', '6d5347d0b29fbf13594900463655bc00', 1808, '', '', 0, NULL, NULL, '10.50.141.13');

-- --------------------------------------------------------

--
-- 表的结构 `cfm_ants`
--

CREATE TABLE IF NOT EXISTS `cfm_ants` (
  `ant_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL DEFAULT '',
  `ant_name` varchar(60) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `ant_real_name` varchar(60) NOT NULL DEFAULT '',
  `question` varchar(255) NOT NULL DEFAULT '',
  `answer` varchar(255) NOT NULL DEFAULT '',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(11) unsigned NOT NULL DEFAULT '0',
  `last_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_ip` varchar(15) NOT NULL DEFAULT '',
  `pic_url` text,
  `salt` varchar(10) DEFAULT NULL,
  `mobile_phone` varchar(20) NOT NULL,
  `is_validated` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `passwd_question` varchar(50) DEFAULT NULL,
  `passwd_answer` varchar(255) DEFAULT NULL,
  `last_lon` varchar(20) NOT NULL,
  `last_lat` varchar(20) NOT NULL,
  `ant_online` tinyint(1) DEFAULT NULL,
  `channel_id` varchar(32) NOT NULL,
  `channel_user_id` varchar(32) NOT NULL,
  PRIMARY KEY (`ant_id`),
  UNIQUE KEY `ant_name` (`ant_name`),
  UNIQUE KEY `ant_id` (`ant_id`),
  UNIQUE KEY `email_2` (`email`),
  UNIQUE KEY `mobile_phone` (`mobile_phone`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `cfm_ants`
--

INSERT INTO `cfm_ants` (`ant_id`, `email`, `ant_name`, `password`, `ant_real_name`, `question`, `answer`, `sex`, `birthday`, `reg_time`, `last_login`, `last_time`, `last_ip`, `pic_url`, `salt`, `mobile_phone`, `is_validated`, `passwd_question`, `passwd_answer`, `last_lon`, `last_lat`, `ant_online`, `channel_id`, `channel_user_id`) VALUES
(1, 'example@examples.com', '百万基佬同时', 'a219bcd383d53e820ee8db0e517581e8', '王尼玛', '1+1=?', '2', 0, '0000-00-00', 0, 0, '0000-00-00 00:00:00', '', NULL, '1', '12345678901', 0, NULL, NULL, '', '', NULL, '', ''),
(2, 'xm1994@gmail.com', 'xm1994', '8fcf5573ff13188e5ff385532bf61f2c', 'Yibai Zhang', '', '', 0, '0000-00-00', 0, 0, '0000-00-00 00:00:00', '', NULL, '1644645688', '18115167739', 0, NULL, NULL, '', '', NULL, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `cfm_ants_log`
--

CREATE TABLE IF NOT EXISTS `cfm_ants_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `log_info` varchar(255) NOT NULL DEFAULT '',
  `ip_address` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`log_id`),
  KEY `log_time` (`log_time`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `cfm_customers`
--

CREATE TABLE IF NOT EXISTS `cfm_customers` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL DEFAULT '',
  `user_name` varchar(60) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `question` varchar(255) NOT NULL DEFAULT '',
  `answer` varchar(255) NOT NULL DEFAULT '',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `pay_points` int(10) unsigned NOT NULL DEFAULT '0',
  `rank_points` int(10) unsigned NOT NULL DEFAULT '0',
  `address_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(11) unsigned NOT NULL DEFAULT '0',
  `last_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_ip` varchar(15) NOT NULL DEFAULT '',
  `visit_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `salt` varchar(10) DEFAULT NULL,
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(60) NOT NULL,
  `qq` varchar(20) NOT NULL,
  `mobile_phone` varchar(20) DEFAULT NULL,
  `is_validated` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `passwd_question` varchar(50) DEFAULT NULL,
  `passwd_answer` varchar(255) DEFAULT NULL,
  `last_lon` varchar(20) NOT NULL,
  `last_lat` varchar(20) NOT NULL,
  `openid` varchar(32) NOT NULL,
  `verify_code` int(6) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `openid` (`openid`),
  FULLTEXT KEY `openid_2` (`openid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `cfm_customers`
--

INSERT INTO `cfm_customers` (`user_id`, `email`, `user_name`, `password`, `question`, `answer`, `sex`, `birthday`, `pay_points`, `rank_points`, `address_id`, `reg_time`, `last_login`, `last_time`, `last_ip`, `visit_count`, `salt`, `flag`, `alias`, `qq`, `mobile_phone`, `is_validated`, `passwd_question`, `passwd_answer`, `last_lon`, `last_lat`, `openid`, `verify_code`) VALUES
(1, '', '123456', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '58.213.51.36, 1', 0, NULL, 0, '', '', '', 0, NULL, NULL, '', '', '', 1234),
(2, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '58.213.51.39, 1', 0, NULL, 0, '', '', '1234567890', 1, NULL, NULL, '', '', 'a7b7f89797ab79a79b', 424536),
(3, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '127.0.0.1', 0, NULL, 0, '', '', '', 0, NULL, NULL, '', '', 'b14f412bab1234bd12b', NULL),
(4, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '127.0.0.1', 0, NULL, 0, '', '', '', 0, NULL, NULL, '', '', 'e8e977e7e9789e', NULL),
(5, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '127.0.0.1', 0, NULL, 0, '', '', '', 0, NULL, NULL, '', '', 'fasoidfhasiodfhasoi', NULL),
(6, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '58.213.51.35, 1', 0, NULL, 0, '', '', '', 0, NULL, NULL, '', '', '7d8as7d58asd6a8', NULL),
(7, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '58.213.51.41, 1', 0, NULL, 0, '', '', '', 0, NULL, NULL, '', '', 'a7b7f89797ab79a79c', NULL),
(8, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '114.222.52.86, ', 0, NULL, 0, '', '', '18013874721', 1, NULL, NULL, '', '', '12345', 958106),
(9, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '58.213.51.39, 1', 0, NULL, 0, '', '', '', 0, NULL, NULL, '', '', 'gh_7733e1fad98b', NULL),
(10, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '180.98.83.150, ', 0, NULL, 0, '', '', '18013874721', 1, NULL, NULL, '', '', 'o7pUBj_yrsg03yzYpNNn4LfEe254', 582370),
(11, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '58.213.47.122, ', 0, NULL, 0, '', '', '', 0, NULL, NULL, '', '', 'yrsg03yzYpNNn4LfEe254', NULL),
(12, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '58.213.47.122, ', 0, NULL, 0, '', '', '', 0, NULL, NULL, '', '', '321312', NULL),
(13, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '58.213.51.36, 1', 0, NULL, 0, '', '', '15051839636', 1, NULL, NULL, '', '', 'o7pUBjxoz7_XpUDxsPsVnvfDIqBw', 550088),
(14, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '180.109.229.18,', 0, NULL, 0, '', '', '18651625156', 1, NULL, NULL, '', '', 'o7pUBjxh8YK01PuXnKPgR5wGOHrM', 633801),
(15, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '122.96.45.179, ', 0, NULL, 0, '', '', '18651625156', 1, NULL, NULL, '', '', 'o7pUBj460r5ysx0jsoVO_M1OKq20', 184404),
(16, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '180.99.52.184, ', 0, NULL, 0, '', '', '15651757873', 1, NULL, NULL, '', '', 'o7pUBjyuWQ0_kY9B6IoEKFROHsJk', 577553),
(17, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '122.96.45.189, ', 0, NULL, 0, '', '', '', 0, NULL, NULL, '', '', 'o7pUBj06oetVWotvMYkgL9-vugu8', NULL),
(18, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '58.213.51.35, 1', 0, NULL, 0, '', '', '', 0, NULL, NULL, '', '', 'fasdf0asdf90asdf', NULL),
(19, '', '', '', '', '', 0, '0000-00-00', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '58.213.51.39, 1', 0, NULL, 0, '', '', NULL, 0, NULL, NULL, '', '', 'o7pUBjwhKMuKX4OBBLiQ90kkmRI8', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `cfm_feedback`
--

CREATE TABLE IF NOT EXISTS `cfm_feedback` (
  `fback_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`fback_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `cfm_options`
--

CREATE TABLE IF NOT EXISTS `cfm_options` (
  `key` varchar(32) NOT NULL,
  `type` varchar(20) NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cfm_order_details`
--

CREATE TABLE IF NOT EXISTS `cfm_order_details` (
  `rec_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `good_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `good_name` varchar(120) NOT NULL DEFAULT '',
  `good_number` smallint(5) unsigned NOT NULL DEFAULT '1',
  `good_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`rec_id`),
  KEY `order_id` (`order_id`),
  KEY `goods_id` (`good_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- 转存表中的数据 `cfm_order_details`
--

INSERT INTO `cfm_order_details` (`rec_id`, `order_id`, `good_id`, `good_name`, `good_number`, `good_price`) VALUES
(5, 1, 1, 'what do you think', 2, '10.00'),
(6, 1, 2, '', 2, '22.00'),
(7, 2, 1, 'what do you think', 2, '10.00'),
(8, 2, 2, '好吃的', 2, '22.00'),
(9, 8, 1, 'what do you think', 2, '10.00'),
(10, 8, 2, '好吃的', 4, '22.00'),
(11, 9, 1, 'what do you think', 2, '10.00'),
(12, 9, 2, '好吃的', 2, '22.00'),
(13, 10, 1, 'what do you think', 2, '10.00'),
(14, 10, 2, '好吃的', 2, '22.00'),
(53, 31, 1, '南瓜粥', 1, '5.00'),
(54, 31, 2, '紫薯紫米红豆粥', 1, '5.00'),
(55, 31, 3, '大白粥', 1, '3.00');

-- --------------------------------------------------------

--
-- 表的结构 `cfm_order_info`
--

CREATE TABLE IF NOT EXISTS `cfm_order_info` (
  `order_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(20) NOT NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  `user_realname` varchar(10) NOT NULL,
  `order_status` tinyint(4) NOT NULL DEFAULT '0',
  `ant_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `confirm_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `taking_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `shipping_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pay_status` tinyint(1) NOT NULL DEFAULT '0',
  `ant_id` varchar(60) DEFAULT NULL,
  `ant_time` int(11) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `user_phone` varchar(60) NOT NULL,
  `pay_id` tinyint(20) NOT NULL DEFAULT '0',
  `goods_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tips_amount` decimal(10,2) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `disp_id` int(11) DEFAULT NULL,
  `order_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_time_ms` varchar(30) DEFAULT NULL,
  `confirm_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `taking_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shipping_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pay_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `add_date` date DEFAULT NULL,
  `nonce` varchar(64) NOT NULL,
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_sn` (`order_sn`),
  KEY `user_id` (`user_id`),
  KEY `order_status` (`order_status`),
  KEY `shipping_status` (`confirm_status`),
  KEY `pay_status` (`taking_status`),
  KEY `pay_id` (`pay_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- 转存表中的数据 `cfm_order_info`
--

INSERT INTO `cfm_order_info` (`order_id`, `order_sn`, `user_id`, `user_realname`, `order_status`, `ant_status`, `confirm_status`, `taking_status`, `shipping_status`, `pay_status`, `ant_id`, `ant_time`, `address`, `user_phone`, `pay_id`, `goods_amount`, `tips_amount`, `shop_id`, `disp_id`, `order_time`, `order_time_ms`, `confirm_time`, `taking_time`, `shipping_time`, `pay_time`, `add_date`, `nonce`) VALUES
(31, '20140605753715989100', 5, '张一白', 0, 0, 0, 0, 0, 0, NULL, NULL, '怡园18', '15615386668', 0, '13.00', '10.00', 1, NULL, '2014-06-05 13:36:11', '1401975371', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2014-06-05', '1902390213');

-- --------------------------------------------------------

--
-- 表的结构 `cfm_payment`
--

CREATE TABLE IF NOT EXISTS `cfm_payment` (
  `pay_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `ant_id` int(11) NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `creat_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pay_time` timestamp NULL DEFAULT NULL,
  `finished` tinyint(1) NOT NULL DEFAULT '0',
  `check_id` varchar(32) NOT NULL,
  PRIMARY KEY (`pay_id`),
  KEY `user_id` (`user_id`),
  KEY `order_id` (`order_id`),
  KEY `ant_id` (`ant_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `cfm_providers`
--

CREATE TABLE IF NOT EXISTS `cfm_providers` (
  `provider_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL DEFAULT '',
  `provider_name` varchar(60) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `shop_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL DEFAULT '',
  `answer` varchar(255) NOT NULL DEFAULT '',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(11) unsigned NOT NULL DEFAULT '0',
  `last_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_ip` varchar(15) NOT NULL DEFAULT '',
  `visit_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_rank` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `salt` varchar(10) DEFAULT NULL,
  `parent_id` mediumint(9) NOT NULL DEFAULT '0',
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(60) NOT NULL,
  `qq` varchar(20) NOT NULL,
  `mobile_phone` varchar(20) NOT NULL,
  `is_validated` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `credit_line` decimal(10,2) unsigned NOT NULL,
  `passwd_question` varchar(50) DEFAULT NULL,
  `passwd_answer` varchar(255) DEFAULT NULL,
  `last_log` text NOT NULL,
  `last_lat` text NOT NULL,
  `openid` text NOT NULL,
  `channel_id` varchar(32) NOT NULL,
  `channel_user_id` varchar(32) NOT NULL,
  PRIMARY KEY (`provider_id`),
  UNIQUE KEY `user_name` (`provider_name`),
  UNIQUE KEY `user_id` (`provider_id`),
  UNIQUE KEY `email_2` (`email`),
  UNIQUE KEY `mobile_phone` (`mobile_phone`),
  KEY `email` (`email`),
  KEY `parent_id` (`parent_id`),
  KEY `flag` (`flag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- 表的结构 `cfm_shop`
--

CREATE TABLE IF NOT EXISTS `cfm_shop` (
  `shop_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) DEFAULT NULL,
  `shop_name` varchar(255) NOT NULL,
  `shop_desc` varchar(512) DEFAULT NULL,
  `shop_pos` text,
  `shop_phone` varchar(13) DEFAULT NULL,
  `pic_url` text,
  `shop_lon` text,
  `shop_lat` text,
  `isopen` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`shop_id`),
  UNIQUE KEY `shop_id` (`shop_id`),
  UNIQUE KEY `owner_id` (`owner_id`),
  KEY `shop_id_2` (`shop_id`),
  KEY `owner_id_2` (`owner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `cfm_shop`
--

INSERT INTO `cfm_shop` (`shop_id`, `owner_id`, `shop_name`, `shop_desc`, `shop_pos`, `shop_phone`, `pic_url`, `shop_lon`, `shop_lat`, `isopen`) VALUES
(1, 1, '南航粥店', '自开业以来，绝大部分粥类价格没变。喝粥免费送小菜。', '后街里面，西南角', '12345678901', NULL, NULL, NULL, 1),
(2, 2, '香酥鸡柳', '提供5元、10元两种类型的包装。', '反正在后街，只是位置不确定而已，找找就好了', '12345678901', NULL, NULL, NULL, 0),
(5, 3, '小四川', '聚餐、请客的好地方。', '后街外面，西边', '12345678901', NULL, NULL, NULL, 1),
(6, 4, '咖喱小憩', '可以免费加饭，环境舒适。', '后街外面，南边', '12345678901', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `cfm_shop_goods`
--

CREATE TABLE IF NOT EXISTS `cfm_shop_goods` (
  `good_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `onsale` tinyint(1) NOT NULL DEFAULT '0',
  `pic_url` text NOT NULL,
  `good_name` varchar(64) NOT NULL,
  `good_desc` text NOT NULL,
  `unavail` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`good_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `cfm_shop_goods`
--

INSERT INTO `cfm_shop_goods` (`good_id`, `shop_id`, `price`, `onsale`, `pic_url`, `good_name`, `good_desc`, `unavail`) VALUES
(1, 1, '5.00', 1, '0', '南瓜粥', '…………', 0),
(2, 1, '5.00', 0, '', '紫薯紫米红豆粥', '~~~~', 0),
(3, 1, '3.00', 1, '', '大白粥', '没什么可说的。', 0),
(4, 6, '12.00', 1, '', '烤肠玉米咖喱饭', '好吃！', 0);

-- --------------------------------------------------------

--
-- 表的结构 `cfm_tokens`
--

CREATE TABLE IF NOT EXISTS `cfm_tokens` (
  `token` varchar(32) NOT NULL,
  `id` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `gen_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`token`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cfm_tokens`
--

INSERT INTO `cfm_tokens` (`token`, `id`, `role`, `gen_time`) VALUES
('1171e594da99e7176c54baa49447ce85', 11, 102, 1401874117),
('26500e8e514e79bf44900cea38eb0bfc', 8, 102, 1401893315),
('4748494df69b0430dc0d6b46f40b2a7b', 3, 102, 2147483647),
('47ea2adcbac5ba706e0f1e3783195a6e', 9, 102, 1401873240),
('5779ef79bed5c04ad78c703008eb7431', 4, 102, 1397469629),
('6e4e8bb4fdc2264987c9901298b9a471', 17, 102, 1401972611),
('83dd07daefd9f93f8b2283376456879e', 0, 103, 2147483647),
('900899bad2275a38c10c91397ccf0132', 18, 102, 1401972939),
('96a9ebfc90c5515bfc47631e9a57a315', 7, 102, 1400908009),
('a856cb2d63d8c2fdcbcdd6bec7a77800', 15, 102, 1401967300),
('aa577b671b83e57ddd6e743f5682bf41', 5, 102, 2147483647),
('b33dea98a68a61a38b6767e6cbf479dd', 2, 102, 1400938288),
('c236dca217174b6d5dcba678b8af48d5', 10, 102, 1401972252),
('cabe54baca8f7c7de0746f3f54633a96', 16, 102, 1401967746),
('d5a739cd9fe0c5f2c8a612904acb5e6d', 12, 102, 1401874162),
('edf74b2bf08d209f0c43a4d8a871aaba', 19, 102, 1402055871),
('f5f80fc8cc5a2c06cdab3175ee412609', 6, 102, 1397813492),
('f6a7e6c9b591bd168697255988edf142', 1, 102, 1401972887),
('fd45348c019ba77676afe902916d2d3b', 13, 102, 1401894192),
('fd5c82ab4cbe0b73c4261eef2ad5cf6d', 14, 102, 1402138343);

-- --------------------------------------------------------

--
-- 表的结构 `cfm_user_address`
--

CREATE TABLE IF NOT EXISTS `cfm_user_address` (
  `addr_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_realname` text NOT NULL,
  `user_phone` varchar(13) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `user_lon` text NOT NULL,
  `user_lat` text NOT NULL,
  PRIMARY KEY (`addr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `cfm_user_address`
--

INSERT INTO `cfm_user_address` (`addr_id`, `user_realname`, `user_phone`, `user_id`, `address`, `user_lon`, `user_lat`) VALUES
(1, '张三', '15615615615', 1, '我就不告诉你我在哪儿日', '', ''),
(2, '张一白', '15615386668', 5, '怡园18', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `cfm_verify_code`
--

CREATE TABLE IF NOT EXISTS `cfm_verify_code` (
  `mobile_phone` int(11) NOT NULL,
  `verify_code` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
