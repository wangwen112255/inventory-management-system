-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2019-05-29 11:07:46
-- 服务器版本： 5.5.56-log
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo_ims`
--

-- --------------------------------------------------------

--
-- 表的结构 `tb_auth_group`
--

CREATE TABLE `tb_auth_group` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` text NOT NULL,
  `remark` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tb_auth_group`
--

INSERT INTO `tb_auth_group` (`id`, `title`, `status`, `rules`, `remark`) VALUES
(17, '北京', 1, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113', ''),
(21, '上海', 1, '1,46,47,48,49,50,51,52,53,54,55,56,57,68,69,70,71,72,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113', '');

-- --------------------------------------------------------

--
-- 表的结构 `tb_auth_group_access`
--

CREATE TABLE `tb_auth_group_access` (
  `uid` mediumint(8) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tb_auth_group_access`
--

INSERT INTO `tb_auth_group_access` (`uid`, `group_id`) VALUES
(11, 18),
(12, 17),
(16, 17),
(17, 17),
(18, 17),
(19, 21),
(27, 17),
(29, 17),
(30, 17);

-- --------------------------------------------------------

--
-- 表的结构 `tb_auth_rule`
--

CREATE TABLE `tb_auth_rule` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `pid` int(11) NOT NULL,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `group` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tb_auth_rule`
--

INSERT INTO `tb_auth_rule` (`id`, `pid`, `name`, `title`, `type`, `status`, `condition`, `group`) VALUES
(1, 0, 'admin/admin/listorders', '排序', 1, 1, '', '后台'),
(2, 0, 'admin/configure/product_look', '产品查看', 1, 1, '', '库存配置'),
(3, 0, 'admin/configure/product', '产品管理', 1, 1, '', '库存配置'),
(4, 0, 'admin/configure/product_add', '产品添加', 1, 1, '', '库存配置'),
(5, 0, 'admin/configure/product_edit', '产品修改', 1, 1, '', '库存配置'),
(6, 0, 'admin/configure/product_del', '产品删除', 1, 1, '', '库存配置'),
(7, 0, 'admin/configure/express', '快递管理', 1, 1, '', '库存配置'),
(8, 0, 'admin/configure/express_add', '快递添加', 1, 1, '', '库存配置'),
(9, 0, 'admin/configure/express_edit', '快递编辑', 1, 1, '', '库存配置'),
(10, 0, 'admin/configure/express_delete', '快递删除', 1, 1, '', '库存配置'),
(11, 0, 'admin/configure/unit', '单位管理', 1, 1, '', '库存配置'),
(12, 0, 'admin/configure/unit_add', '单位添加', 1, 1, '', '库存配置'),
(13, 0, 'admin/configure/unit_edit', '单位编辑', 1, 1, '', '库存配置'),
(14, 0, 'admin/configure/unit_delete', '单位删除', 1, 1, '', '库存配置'),
(15, 0, 'admin/configure/product_category', '产品分类', 1, 1, '', '库存配置'),
(16, 0, 'admin/configure/product_category_add', '产品分类新增', 1, 1, '', '库存配置'),
(17, 0, 'admin/configure/product_category_delete', '产品分类删除', 1, 1, '', '库存配置'),
(18, 0, 'admin/configure/product_category_edit', '产品分类修改', 1, 1, '', '库存配置'),
(19, 0, 'admin/configure/warehouse', '仓库管理', 1, 1, '', '库存配置'),
(20, 0, 'admin/configure/warehouse_add', '仓库新增', 1, 1, '', '库存配置'),
(21, 0, 'admin/configure/warehouse_edit', '仓库修改', 1, 1, '', '库存配置'),
(22, 0, 'admin/configure/warehouse_delete', '仓库删除', 1, 1, '', '库存配置'),
(23, 0, 'admin/configure/supplier', '供应商列表', 1, 1, '', '库存配置'),
(24, 0, 'admin/configure/supplier_add', '供应商新增', 1, 1, '', '库存配置'),
(25, 0, 'admin/configure/supplier_edit', '供应商修改', 1, 1, '', '库存配置'),
(26, 0, 'admin/configure/supplier_look', '供应商查看', 1, 1, '', '库存配置'),
(27, 0, 'admin/configure/supplier_delete', '供应商删除', 1, 1, '', '库存配置'),
(28, 0, 'admin/database/export', '备份数据库', 1, 1, '', '数据库'),
(29, 0, 'admin/database/import_list', '还原列表', 1, 1, '', '数据库'),
(30, 0, 'admin/database/export_list', '备份列表', 1, 1, '', '数据库'),
(31, 0, 'admin/database/optimize', '优化表', 1, 1, '', '数据库'),
(32, 0, 'admin/database/repair', '修复表', 1, 1, '', '数据库'),
(33, 0, 'admin/database/del', '删除备份文件', 1, 1, '', '数据库'),
(34, 0, 'admin/database/import', '还原数据库', 1, 1, '', '数据库'),
(35, 0, 'admin/finance/bank', '银行管理', 1, 1, '', '财务'),
(36, 0, 'admin/finance/bank_add', '新增银行', 1, 1, '', '财务'),
(37, 0, 'admin/finance/bank_delete', '删除银行', 1, 1, '', '财务'),
(38, 0, 'admin/finance/bank_edit', '修改银行', 1, 1, '', '财务'),
(39, 0, 'admin/finance/category', '财务分类', 1, 1, '', '财务'),
(40, 0, 'admin/finance/category_add', '新增财务分类', 1, 1, '', '财务'),
(41, 0, 'admin/finance/category_delete', '财务银行分类', 1, 1, '', '财务'),
(42, 0, 'admin/finance/category_edit', '修改财务分类', 1, 1, '', '财务'),
(43, 0, 'admin/finance/add', '新增财务', 1, 1, '', '财务'),
(44, 0, 'admin/finance/query', '账务查询', 1, 1, '', '财务'),
(45, 0, 'admin/finance/query_delete', '撤销账单', 1, 1, '', '财务'),
(46, 0, 'admin/production/product_build_undo', '生产撤销', 1, 1, '', '生产'),
(47, 0, 'admin/production/product_build_query', '加工记录', 1, 1, '', '生产'),
(48, 0, 'admin/production/product_build_submit', '产品加工提交', 1, 1, '', '生产'),
(49, 0, 'admin/production/product_build', '产品加工', 1, 1, '', '生产'),
(50, 0, 'admin/production/product_relation', '产品关系', 1, 1, '', '生产'),
(51, 0, 'admin/production/product_relation_edit', '产品关系编辑', 1, 1, '', '生产'),
(52, 0, 'admin/production/product_relation_edit_submit', '产品关联提交', 1, 1, '', '生产'),
(53, 0, 'admin/index/log_clear', '日志删除', 1, 1, '', '控制台'),
(54, 0, 'admin/index/password', '修改自己的密码', 1, 1, '', '控制台'),
(55, 0, 'admin/index/index', '框架页面', 1, 1, '', '控制台'),
(56, 0, 'admin/index/main', '首页', 1, 1, '', '控制台'),
(57, 0, 'admin/index/log', '我的日志', 1, 1, '', '控制台'),
(58, 0, 'admin/member/group_price', '会员组销价管理', 1, 1, '', '会员'),
(59, 0, 'admin/member/index', '会员管理', 1, 1, '', '会员'),
(60, 0, 'admin/member/delete', '删除管理', 1, 1, '', '会员'),
(61, 0, 'admin/member/look', '查看会员', 1, 1, '', '会员'),
(62, 0, 'admin/member/edit', '修改会员', 1, 1, '', '会员'),
(63, 0, 'admin/member/add', '新增会员', 1, 1, '', '会员'),
(64, 0, 'admin/member/group', '会员分组', 1, 1, '', '会员'),
(65, 0, 'admin/member/group_add', '会员分组新增', 1, 1, '', '会员'),
(66, 0, 'admin/member/group_edit', '会员分组修改', 1, 1, '', '会员'),
(67, 0, 'admin/member/group_delete', '会员分组删除', 1, 1, '', '会员'),
(68, 0, 'admin/json/finance_category', '财务分类', 1, 1, '', 'JSON'),
(69, 0, 'admin/json/menu', '菜单', 1, 1, '', 'JSON'),
(70, 0, 'admin/json/city', '城市', 1, 1, '', 'JSON'),
(71, 0, 'admin/json/product', '产品', 1, 1, '', 'JSON'),
(72, 0, 'admin/json/member', '会员', 1, 1, '', 'JSON'),
(73, 0, 'admin/system/auth_group', '信息列表', 1, 1, '', '系统'),
(74, 0, 'admin/system/auth_group_add', '添加角色', 1, 1, '', '系统'),
(75, 0, 'admin/system/auth_group_edit', '编辑角色', 1, 1, '', '系统'),
(76, 0, 'admin/system/auth_group_delete', '删除资源', 1, 1, '', '系统'),
(77, 0, 'admin/system/auth_rule', '显示资源列表', 1, 1, '', '系统'),
(78, 0, 'admin/system/node_parse', '节点解析', 1, 1, '', '系统'),
(79, 0, 'admin/system/node_refresh', '刷新节点', 1, 1, '', '系统'),
(80, 0, 'admin/system/user', '列表', 1, 1, '', '系统'),
(81, 0, 'admin/system/user_add', '添加用户', 1, 1, '', '系统'),
(82, 0, 'admin/system/user_edit', '编辑用户', 1, 1, '', '系统'),
(83, 0, 'admin/system/user_delete', '用户删除', 1, 1, '', '系统'),
(84, 0, 'admin/system/menu', '菜单列表', 1, 1, '', '系统'),
(85, 0, 'admin/system/menu_add', '添加', 1, 1, '', '系统'),
(86, 0, 'admin/system/menu_edit', '编辑菜单', 1, 1, '', '系统'),
(87, 0, 'admin/system/menu_delete', '删除菜单', 1, 1, '', '系统'),
(88, 0, 'admin/system/config', '配置列表', 1, 1, '', '系统'),
(89, 0, 'admin/inventory/storage', '入库', 1, 1, '', '库存管理'),
(90, 0, 'admin/inventory/storage_submit', '入库提交', 1, 1, '', '库存管理'),
(91, 0, 'admin/inventory/storage_undo', '入库撤消', 1, 1, '', '库存管理'),
(92, 0, 'admin/inventory/storage_query', '入库查询', 1, 1, '', '库存管理'),
(93, 0, 'admin/inventory/sales', '出库', 1, 1, '', '库存管理'),
(94, 0, 'admin/inventory/sales_submit', '出库提交', 1, 1, '', '库存管理'),
(95, 0, 'admin/inventory/sales_query', '出库查询', 1, 1, '', '库存管理'),
(96, 0, 'admin/inventory/sales_undo', '产品出库撤消', 1, 1, '', '库存管理'),
(97, 0, 'admin/inventory/sales_returns_query', '退货查询', 1, 1, '', '库存管理'),
(98, 0, 'admin/inventory/sales_returns_add', '出库退货提交', 1, 1, '', '库存管理'),
(99, 0, 'admin/inventory/sales_look', '产品出库查询', 1, 1, '', '库存管理'),
(100, 0, 'admin/inventory/sales_look_info_update', '补充快递信息', 1, 1, '', '库存管理'),
(101, 0, 'admin/inventory/stock_delete', '库存记录删除', 1, 1, '', '库存管理'),
(102, 0, 'admin/inventory/stock_query', '库存查询', 1, 1, '', '库存管理'),
(103, 0, 'admin/inventory/transfer_add', '库存调拨窗口', 1, 1, '', '库存管理'),
(104, 0, 'admin/inventory/transfer_query', '调拨查询', 1, 1, '', '库存管理'),
(105, 0, 'admin/inventory/scrapped_add', '报废窗口', 1, 1, '', '库存管理'),
(106, 0, 'admin/inventory/scrapped_query', '报废查询', 1, 1, '', '库存管理'),
(107, 0, 'admin/prints/orders_view', '出库订单详情', 1, 1, '', '打印'),
(108, 0, 'admin/prints/orders_list', '出库订单列表', 1, 1, '', '打印'),
(109, 0, 'admin/prints/storage_list', '入库查询', 1, 1, '', '打印'),
(110, 0, 'admin/prints/storage_view', '入库查询', 1, 1, '', '打印'),
(111, 0, 'admin/prints/finance_list', '打印账务', 1, 1, '', '打印'),
(112, 0, 'admin/everyone/login', '用户登录', 1, 1, '', '公共'),
(113, 0, 'admin/everyone/logout', '用户登出', 1, 1, '', '公共');

-- --------------------------------------------------------

--
-- 表的结构 `tb_express`
--

CREATE TABLE `tb_express` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tb_express`
--

INSERT INTO `tb_express` (`id`, `name`, `sort`) VALUES
(1, '顺丰', NULL),
(2, '中通', NULL),
(3, '圆通', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tb_finance_accounts`
--

CREATE TABLE `tb_finance_accounts` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL COMMENT '用户',
  `bank_id` int(11) DEFAULT NULL COMMENT '银行',
  `c_id` int(11) DEFAULT NULL COMMENT '分类',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  `type` int(11) DEFAULT NULL COMMENT '收入支出类型',
  `money` double(11,2) DEFAULT NULL COMMENT '金额',
  `datetime` int(11) DEFAULT NULL COMMENT '日期时间',
  `attn_id` int(11) DEFAULT NULL COMMENT '经办人',
  `remark` text COMMENT '备注',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='账务';

--
-- 转存表中的数据 `tb_finance_accounts`
--

INSERT INTO `tb_finance_accounts` (`id`, `u_id`, `bank_id`, `c_id`, `status`, `type`, `money`, `datetime`, `attn_id`, `remark`, `create_time`) VALUES
(1, 1, 1, 0, 1, 0, 111.00, 1557237780, 30, '1111', 1559052188);

-- --------------------------------------------------------

--
-- 表的结构 `tb_finance_bank`
--

CREATE TABLE `tb_finance_bank` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `money` double(11,2) DEFAULT NULL COMMENT '金额',
  `default` int(1) DEFAULT '0' COMMENT '是否默认',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `sort` int(11) DEFAULT NULL COMMENT '排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='财务银行';

--
-- 转存表中的数据 `tb_finance_bank`
--

INSERT INTO `tb_finance_bank` (`id`, `name`, `money`, `default`, `remark`, `sort`) VALUES
(1, '1111', 1000.00, 0, '11111', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tb_finance_category`
--

CREATE TABLE `tb_finance_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `pid` int(11) DEFAULT '0',
  `type` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产器分类';

-- --------------------------------------------------------

--
-- 表的结构 `tb_member`
--

CREATE TABLE `tb_member` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `g_id` int(11) DEFAULT NULL COMMENT '会员分组',
  `card` varchar(255) DEFAULT NULL COMMENT '会员卡号',
  `nickname` varchar(255) DEFAULT NULL COMMENT '会员姓名',
  `sex` int(11) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL COMMENT '电话',
  `qq` varchar(255) DEFAULT NULL COMMENT 'qq',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `id_card` varchar(255) DEFAULT NULL COMMENT '身份证号码',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `remark` text COMMENT '备注',
  `create_time` int(11) DEFAULT NULL,
  `points` bigint(20) DEFAULT '0' COMMENT '积分',
  `update` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员';

--
-- 转存表中的数据 `tb_member`
--

INSERT INTO `tb_member` (`id`, `u_id`, `g_id`, `card`, `nickname`, `sex`, `tel`, `qq`, `email`, `address`, `id_card`, `birthday`, `remark`, `create_time`, `points`, `update`, `update_time`) VALUES
(1, 1, 1, '', '广州XX', 1, '', '', '', '', '', '0000-00-00', '', 1559019097, 0, NULL, NULL),
(2, 1, 1, '', '上海某代理', 1, '', '', '', '地址地址地址地址地址地址地址', '', '0000-00-00', '', 1559019108, 0, 1, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tb_member_card`
--

CREATE TABLE `tb_member_card` (
  `id` int(11) NOT NULL,
  `card_number` varchar(255) DEFAULT NULL COMMENT '会员卡号',
  `status` int(1) DEFAULT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员卡';

-- --------------------------------------------------------

--
-- 表的结构 `tb_member_group`
--

CREATE TABLE `tb_member_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `pid` int(11) DEFAULT '0',
  `sort` int(11) DEFAULT NULL,
  `discounts` double(3,2) DEFAULT '0.00' COMMENT '折扣'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产器分类';

--
-- 转存表中的数据 `tb_member_group`
--

INSERT INTO `tb_member_group` (`id`, `name`, `pid`, `sort`, `discounts`) VALUES
(1, '一级代理', 0, NULL, 0.00),
(2, '二级代理', 0, NULL, 0.00);

-- --------------------------------------------------------

--
-- 表的结构 `tb_member_points`
--

CREATE TABLE `tb_member_points` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `member` int(11) DEFAULT NULL,
  `m_id` int(11) DEFAULT NULL,
  `type` int(1) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分日志';

-- --------------------------------------------------------

--
-- 表的结构 `tb_member_price`
--

CREATE TABLE `tb_member_price` (
  `id` int(11) NOT NULL,
  `p_id` int(11) DEFAULT NULL,
  `g_id` int(11) DEFAULT NULL,
  `price` double(20,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tb_member_price`
--

INSERT INTO `tb_member_price` (`id`, `p_id`, `g_id`, `price`) VALUES
(1, 1, 1, 1.00),
(2, 1, 2, 22.00),
(3, 2, 1, 1.00),
(4, 2, 2, 22.00),
(5, 3, 1, 2.00),
(6, 3, 2, 2.00);

-- --------------------------------------------------------

--
-- 表的结构 `tb_operate`
--

CREATE TABLE `tb_operate` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `client` varchar(15) DEFAULT 'pc' COMMENT '客户端',
  `country` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `data` text,
  `log` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- --------------------------------------------------------

--
-- 表的结构 `tb_operate_1`
--

CREATE TABLE `tb_operate_1` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `client` varchar(15) DEFAULT 'pc' COMMENT '客户端',
  `country` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `data` text,
  `log` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- --------------------------------------------------------

--
-- 表的结构 `tb_operate_2`
--

CREATE TABLE `tb_operate_2` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `client` varchar(15) DEFAULT 'pc' COMMENT '客户端',
  `country` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `data` text,
  `log` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志';

--
-- 转存表中的数据 `tb_operate_2`
--

INSERT INTO `tb_operate_2` (`id`, `u_id`, `title`, `status`, `create_time`, `ip`, `client`, `country`, `area`, `url`, `data`, `log`) VALUES
(50, 1, '成功登录系统', 1, 1559030183, '171.88.1.34', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(49, 1, '成功登录系统', 1, 1559029021, '1.204.205.59', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(47, 1, '成功登录系统', 1, 1559026552, '182.117.176.27', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(48, 1, '成功登录系统', 1, 1559028761, '125.62.5.96', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(46, 1, '成功登录系统', 1, 1559026292, '27.187.170.93', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(45, 1, '入库成功', 1, 1559026289, '115.56.39.127', 'pc', '', '', '/admin/inventory/storage_submit', 'a:9:{s:4:\"code\";s:0:\"\";s:10:\"product_id\";s:0:\"\";s:11:\"product_ids\";a:1:{i:1;s:1:\"1\";}s:9:\"warehouse\";a:1:{i:1;s:1:\"2\";}s:16:\"product_quantity\";a:1:{i:1;s:2:\"20\";}s:11:\"group_price\";a:1:{i:1;s:3:\"100\";}s:8:\"supplier\";s:1:\"1\";s:4:\"type\";s:1:\"1\";s:6:\"remark\";s:0:\"\";}', ''),
(44, 1, '产品关联提交', 1, 1559026223, '115.56.39.127', 'pc', '', '', '/admin/production/product_relation_edit_submit?id=2', 'a:2:{s:4:\"code\";s:0:\"\";s:11:\"product_ids\";a:1:{i:0;s:0:\"\";}}', ''),
(42, 1, '成功登录系统', 1, 1559025791, '171.8.254.201', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(43, 1, '成功登录系统', 1, 1559026123, '115.56.39.127', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(41, 1, '打印出货单=>20190528311257263831', 1, 1559025691, '223.72.67.182', 'pc', '', '', '/admin/prints/orders_view?id=1&session_id=t58fd8lbt540l3gjue17im21ff&r=0.19589730460150578', 'a:0:{}', ''),
(39, 1, '成功登录系统', 1, 1559024773, '112.86.69.48', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(40, 1, '成功登录系统', 1, 1559025516, '223.72.67.182', 'mobile', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(38, 1, '打印账务单', 1, 1559024352, '113.200.156.117', 'pc', '', '', '/admin/prints/finance_list?session_id=2651m7ti8f2c93007vqon8tlkg&r=0.2695308762426796&timea=2019-04-28&timeb=2019-05-28&b_id=&attn_id=&remark=', 'a:0:{}', ''),
(36, 1, '成功登录系统', 1, 1559023582, '183.3.155.73', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(37, 1, '成功登录系统', 1, 1559024267, '113.200.156.117', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(33, 1, '成功登录系统', 1, 1559023511, '175.169.111.129', 'mobile', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(34, 1, '成功登录系统', 1, 1559023562, '113.104.244.35', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(35, 1, '成功登录系统', 1, 1559023575, '175.169.111.129', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(32, 1, '成功登录系统', 1, 1559021939, '61.148.245.73', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(51, 1, '成功登录系统', 1, 1559031293, '58.246.20.210', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(52, 1, '成功登录系统', 1, 1559031529, '14.114.37.90', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(53, 1, '成功登录系统', 1, 1559031736, '119.90.88.106', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(54, 1, '成功登录系统', 1, 1559032055, '211.97.10.43', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(55, 1, '成功登录系统', 1, 1559033016, '220.173.124.78', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(56, 1, '成功登录系统', 1, 1559034469, '113.109.110.67', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(57, 1, '成功登录系统', 1, 1559034575, '222.211.206.46', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(58, 1, '入库撤消', 1, 1559034807, '222.211.206.46', 'pc', '', '', '/admin/inventory/storage_undo?id=4', 'a:0:{}', ''),
(59, 1, '成功登录系统', 1, 1559035309, '110.184.163.99', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(60, 1, '成功登录系统', 1, 1559040723, '175.188.64.228', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(61, 1, '成功登录系统', 1, 1559048766, '180.106.15.242', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(62, 1, '成功登录系统', 1, 1559048960, '183.17.67.146', 'mobile', '', '', '/admin/everyone/login', 'a:2:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";}', ''),
(63, 1, '成功登录系统', 1, 1559049000, '180.106.15.242', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(64, 1, '用户密码错误', 0, 1559049113, '113.65.210.18', 'mobile', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:5:\"admin\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(65, 1, '成功登录系统', 1, 1559049133, '113.65.210.18', 'mobile', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(66, 1, '成功登录系统', 1, 1559049424, '124.114.249.125', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(67, 1, '成功登录系统', 1, 1559050091, '180.126.42.76', 'mobile', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(68, 1, '成功登录系统', 1, 1559050094, '112.86.69.48', 'mobile', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(69, 1, '成功登录系统', 1, 1559050260, '112.86.69.48', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(70, 1, '成功登录系统', 1, 1559051010, '61.140.206.221', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(71, 1, '产品关联提交', 1, 1559051027, '61.140.206.221', 'pc', '', '', '/admin/production/product_relation_edit_submit?id=3', 'a:2:{s:4:\"code\";s:0:\"\";s:11:\"product_ids\";a:1:{i:0;s:0:\"\";}}', ''),
(72, 1, '成功登录系统', 1, 1559051354, '59.109.152.230', 'mobile', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(73, 1, '成功登录系统', 1, 1559052042, '223.72.57.23', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(74, 1, '新增银行', 1, 1559052175, '223.72.57.23', 'pc', '', '', '/admin/finance/bank_add', 'a:3:{s:4:\"name\";s:4:\"1111\";s:5:\"money\";s:4:\"1111\";s:6:\"remark\";s:5:\"11111\";}', ''),
(75, 1, '新增账务', 1, 1559052188, '223.72.57.23', 'pc', '', '', '/admin/finance/add', 'a:7:{s:4:\"type\";s:12:\"选择类型\";s:4:\"c_id\";s:12:\"选择分类\";s:7:\"bank_id\";s:1:\"1\";s:5:\"money\";s:3:\"111\";s:8:\"datetime\";s:16:\"2019-05-07 22:03\";s:7:\"attn_id\";s:2:\"30\";s:6:\"remark\";s:4:\"1111\";}', ''),
(76, 1, '成功登录系统', 1, 1559053687, '110.52.105.173', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(77, 1, '成功登录系统', 1, 1559054144, '119.60.64.116', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(78, 1, '库存调拨', 1, 1559054313, '119.60.64.116', 'pc', '', '', '/admin/inventory/transfer_add?id=1', 'a:3:{s:9:\"warehouse\";s:1:\"1\";s:6:\"number\";s:1:\"2\";s:6:\"remark\";s:0:\"\";}', ''),
(79, 1, '新增供应商', 1, 1559054423, '119.60.64.116', 'pc', '', '', '/admin/configure/supplier_add', 'a:9:{s:7:\"company\";s:2:\"ce\";s:4:\"name\";s:0:\"\";s:3:\"tel\";s:0:\"\";s:3:\"fax\";s:0:\"\";s:6:\"mobile\";s:0:\"\";s:4:\"site\";s:0:\"\";s:5:\"email\";s:0:\"\";s:7:\"address\";s:0:\"\";s:6:\"remark\";s:0:\"\";}', ''),
(80, 1, '修改供应商', 1, 1559054461, '119.60.64.116', 'pc', '', '', '/admin/configure/supplier_edit', 'a:10:{s:2:\"id\";s:1:\"4\";s:7:\"company\";s:6:\"测试\";s:4:\"name\";s:12:\"企业返现\";s:3:\"tel\";s:7:\"1111111\";s:3:\"fax\";s:0:\"\";s:6:\"mobile\";s:0:\"\";s:4:\"site\";s:0:\"\";s:5:\"email\";s:0:\"\";s:7:\"address\";s:0:\"\";s:6:\"remark\";s:0:\"\";}', ''),
(81, 1, '成功登录系统', 1, 1559056288, '180.106.15.242', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(82, 1, '成功登录系统', 1, 1559056391, '122.192.12.103', 'mobile', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(83, 1, '成功登录系统', 1, 1559056423, '223.104.27.232', 'mobile', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(84, 1, '成功登录系统', 1, 1559060555, '119.86.37.174', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(85, 1, '成功登录系统', 1, 1559062272, '218.87.25.149', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(86, 1, '成功登录系统', 1, 1559084994, '183.52.198.196', 'mobile', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(87, 1, '成功登录系统', 1, 1559091418, '121.231.46.186', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(88, 1, '成功登录系统', 1, 1559092386, '59.61.92.150', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(89, 1, '成功登录系统', 1, 1559092401, '180.106.15.242', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(90, 1, '成功登录系统', 1, 1559093783, '1.202.124.123', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(91, 1, '成功登录系统', 1, 1559093800, '1.202.124.123', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(92, 1, '成功登录系统', 1, 1559095757, '111.160.91.250', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(93, 1, '成功登录系统', 1, 1559095777, '111.160.91.250', 'pc', '', '', '/admin/everyone/login', 'a:2:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";}', ''),
(94, 1, '成功登录系统', 1, 1559096761, '118.250.172.63', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(95, 1, '成功登录系统', 1, 1559096903, '125.118.132.23', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(96, 1, '入库成功', 1, 1559097009, '125.118.132.23', 'pc', '', '', '/admin/inventory/storage_submit', 'a:9:{s:4:\"code\";s:0:\"\";s:10:\"product_id\";s:0:\"\";s:11:\"product_ids\";a:1:{i:1;s:1:\"1\";}s:9:\"warehouse\";a:1:{i:1;s:1:\"2\";}s:16:\"product_quantity\";a:1:{i:1;s:1:\"2\";}s:11:\"group_price\";a:1:{i:1;s:1:\"1\";}s:8:\"supplier\";s:1:\"3\";s:4:\"type\";s:1:\"1\";s:6:\"remark\";s:3:\"123\";}', ''),
(97, 1, '销售产品', 1, 1559097054, '125.118.132.23', 'pc', '', '', '/admin/inventory/sales_submit', 'a:12:{s:9:\"member_id\";s:0:\"\";s:10:\"product_id\";s:0:\"\";s:11:\"product_ids\";a:1:{i:1;s:1:\"1\";}s:17:\"product_warehouse\";a:1:{i:1;s:1:\"2\";}s:16:\"product_quantity\";a:1:{i:1;s:1:\"1\";}s:11:\"group_price\";a:1:{i:1;s:1:\"1\";}s:9:\"ship_time\";s:16:\"2019-05-29 10:30\";s:10:\"express_id\";s:1:\"1\";s:11:\"express_num\";s:0:\"\";s:12:\"express_addr\";s:5:\"21132\";s:10:\"sales_type\";s:1:\"1\";s:6:\"remark\";s:3:\"123\";}', ''),
(98, 1, '入库成功', 1, 1559097091, '125.118.132.23', 'pc', '', '', '/admin/inventory/storage_submit', 'a:9:{s:4:\"code\";s:0:\"\";s:10:\"product_id\";s:0:\"\";s:11:\"product_ids\";a:1:{i:1;s:1:\"1\";}s:9:\"warehouse\";a:1:{i:1;s:1:\"2\";}s:16:\"product_quantity\";a:1:{i:1;s:1:\"1\";}s:11:\"group_price\";a:1:{i:1;s:1:\"1\";}s:8:\"supplier\";s:0:\"\";s:4:\"type\";s:1:\"1\";s:6:\"remark\";s:0:\"\";}', ''),
(99, 1, '销售产品', 1, 1559097112, '125.118.132.23', 'pc', '', '', '/admin/inventory/sales_submit', 'a:12:{s:9:\"member_id\";s:0:\"\";s:10:\"product_id\";s:0:\"\";s:11:\"product_ids\";a:1:{i:1;s:1:\"1\";}s:17:\"product_warehouse\";a:1:{i:1;s:1:\"2\";}s:16:\"product_quantity\";a:1:{i:1;s:1:\"4\";}s:11:\"group_price\";a:1:{i:1;s:1:\"1\";}s:9:\"ship_time\";s:16:\"2019-05-29 10:31\";s:10:\"express_id\";s:0:\"\";s:11:\"express_num\";s:0:\"\";s:12:\"express_addr\";s:0:\"\";s:10:\"sales_type\";s:1:\"1\";s:6:\"remark\";s:0:\"\";}', ''),
(100, 1, '成功登录系统', 1, 1559097354, '183.239.207.144', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(101, 1, '成功登录系统', 1, 1559097687, '118.187.58.216', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(102, 1, '成功登录系统', 1, 1559098166, '223.72.67.182', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(103, 1, '成功登录系统', 1, 1559099051, '113.70.58.77', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(104, 1, '成功登录系统', 1, 1559099149, '222.214.45.197', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:10:\"superadmin\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', '');

-- --------------------------------------------------------

--
-- 表的结构 `tb_operate_3`
--

CREATE TABLE `tb_operate_3` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `client` varchar(15) DEFAULT 'pc' COMMENT '客户端',
  `country` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `data` text,
  `log` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- --------------------------------------------------------

--
-- 表的结构 `tb_operate_4`
--

CREATE TABLE `tb_operate_4` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `client` varchar(15) DEFAULT 'pc' COMMENT '客户端',
  `country` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `data` text,
  `log` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- --------------------------------------------------------

--
-- 表的结构 `tb_operate_5`
--

CREATE TABLE `tb_operate_5` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `client` varchar(15) DEFAULT 'pc' COMMENT '客户端',
  `country` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `data` text,
  `log` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- --------------------------------------------------------

--
-- 表的结构 `tb_operate_6`
--

CREATE TABLE `tb_operate_6` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `client` varchar(15) DEFAULT 'pc' COMMENT '客户端',
  `country` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `data` text,
  `log` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- --------------------------------------------------------

--
-- 表的结构 `tb_operate_7`
--

CREATE TABLE `tb_operate_7` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `client` varchar(15) DEFAULT 'pc' COMMENT '客户端',
  `country` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `data` text,
  `log` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志';

--
-- 转存表中的数据 `tb_operate_7`
--

INSERT INTO `tb_operate_7` (`id`, `u_id`, `title`, `status`, `create_time`, `ip`, `client`, `country`, `area`, `url`, `data`, `log`) VALUES
(1, 26, '成功登录系统', 1, 1558939985, '127.0.0.1', 'pc', '', '', '/_mmno_/pss.mmno.com/public/admin/everyone/login', 'a:3:{s:8:\"username\";s:2:\"xx\";s:8:\"password\";s:6:\"123456\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(2, 16, '成功登录系统', 1, 1558946030, '223.72.67.182', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:7:\"zhaodan\";s:8:\"password\";s:6:\"111111\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(3, 16, '用户密码错误', 0, 1558946559, '114.253.225.248', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:7:\"zhaodan\";s:8:\"password\";s:7:\"narrims\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(4, 16, '成功登录系统', 1, 1558946562, '114.253.225.248', 'pc', '', '', '/admin/everyone/login', 'a:3:{s:8:\"username\";s:7:\"zhaodan\";s:8:\"password\";s:6:\"111111\";s:15:\"rember_password\";s:2:\"on\";}', ''),
(5, 16, '新增仓库', 0, 1558947225, '114.253.225.248', 'pc', '', '', '/admin/configure/warehouse_add', 'a:4:{s:4:\"name\";s:9:\"北京仓\";s:7:\"address\";s:0:\"\";s:6:\"remark\";s:0:\"\";s:4:\"uids\";a:5:{i:0;s:1:\"1\";i:1;s:2:\"16\";i:2;s:2:\"17\";i:3;s:2:\"18\";i:4;s:2:\"27\";}}', ''),
(6, 16, '新增仓库', 1, 1558947430, '114.253.225.248', 'pc', '', '', '/admin/configure/warehouse_add', 'a:4:{s:4:\"name\";s:9:\"北京仓\";s:7:\"address\";s:0:\"\";s:6:\"remark\";s:0:\"\";s:4:\"uids\";a:5:{i:0;s:1:\"1\";i:1;s:2:\"16\";i:2;s:2:\"17\";i:3;s:2:\"18\";i:4;s:2:\"27\";}}', ''),
(7, 16, '新增仓库', 1, 1558947443, '114.253.225.248', 'pc', '', '', '/admin/configure/warehouse_add', 'a:4:{s:4:\"name\";s:9:\"宁波仓\";s:7:\"address\";s:0:\"\";s:6:\"remark\";s:0:\"\";s:4:\"uids\";a:5:{i:0;s:1:\"1\";i:1;s:2:\"16\";i:2;s:2:\"17\";i:3;s:2:\"18\";i:4;s:2:\"27\";}}', ''),
(8, 16, '新增仓库', 1, 1558947454, '114.253.225.248', 'pc', '', '', '/admin/configure/warehouse_add', 'a:4:{s:4:\"name\";s:9:\"广州仓\";s:7:\"address\";s:0:\"\";s:6:\"remark\";s:0:\"\";s:4:\"uids\";a:5:{i:0;s:1:\"1\";i:1;s:2:\"16\";i:2;s:2:\"17\";i:3;s:2:\"18\";i:4;s:2:\"27\";}}', ''),
(9, 16, '新增仓库', 1, 1558947465, '114.253.225.248', 'pc', '', '', '/admin/configure/warehouse_add', 'a:4:{s:4:\"name\";s:9:\"郑州仓\";s:7:\"address\";s:0:\"\";s:6:\"remark\";s:0:\"\";s:4:\"uids\";a:6:{i:0;s:1:\"1\";i:1;s:2:\"16\";i:2;s:2:\"17\";i:3;s:2:\"18\";i:4;s:2:\"19\";i:5;s:2:\"27\";}}', '');

-- --------------------------------------------------------

--
-- 表的结构 `tb_operate_8`
--

CREATE TABLE `tb_operate_8` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `client` varchar(15) DEFAULT 'pc' COMMENT '客户端',
  `country` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `data` text,
  `log` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- --------------------------------------------------------

--
-- 表的结构 `tb_operate_9`
--

CREATE TABLE `tb_operate_9` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `client` varchar(15) DEFAULT 'pc' COMMENT '客户端',
  `country` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `data` text,
  `log` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- --------------------------------------------------------

--
-- 表的结构 `tb_operate_10`
--

CREATE TABLE `tb_operate_10` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `client` varchar(15) DEFAULT 'pc' COMMENT '客户端',
  `country` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `data` text,
  `log` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- --------------------------------------------------------

--
-- 表的结构 `tb_pinyin`
--

CREATE TABLE `tb_pinyin` (
  `py` char(1) NOT NULL,
  `begin` smallint(5) UNSIGNED NOT NULL,
  `end` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tb_pinyin`
--

INSERT INTO `tb_pinyin` (`py`, `begin`, `end`) VALUES
('A', 45217, 45252),
('B', 45253, 45760),
('C', 45761, 46317),
('D', 46318, 46825),
('E', 46826, 47009),
('F', 47010, 47296),
('G', 47297, 47613),
('H', 47614, 48118),
('J', 48119, 49061),
('K', 49062, 49323),
('L', 49324, 49895),
('M', 49896, 50370),
('N', 50371, 50613),
('O', 50614, 50621),
('P', 50622, 50905),
('Q', 50906, 51386),
('R', 51387, 51445),
('S', 51446, 52217),
('T', 52218, 52697),
('W', 52698, 52979),
('X', 52980, 53640),
('Y', 53689, 54480),
('Z', 54481, 55289);

-- --------------------------------------------------------

--
-- 表的结构 `tb_product`
--

CREATE TABLE `tb_product` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL COMMENT '创建员工',
  `c_id` int(11) DEFAULT NULL COMMENT '产品分类',
  `code` varchar(255) DEFAULT NULL COMMENT '产品货号',
  `name` varchar(255) DEFAULT NULL COMMENT '产品名称',
  `sales` double(11,2) DEFAULT NULL COMMENT '销售价',
  `purchase` double(11,2) DEFAULT NULL COMMENT '进货价',
  `points` bigint(20) DEFAULT '0' COMMENT '积分',
  `format` varchar(255) DEFAULT NULL COMMENT '产品规格',
  `lowest` int(11) DEFAULT '0' COMMENT '最低库存',
  `type` int(1) DEFAULT '0' COMMENT '产品类型',
  `unit` varchar(255) DEFAULT NULL COMMENT '单位',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `update_uid` int(11) DEFAULT NULL,
  `remark` text COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品';

--
-- 转存表中的数据 `tb_product`
--

INSERT INTO `tb_product` (`id`, `u_id`, `c_id`, `code`, `name`, `sales`, `purchase`, `points`, `format`, `lowest`, `type`, `unit`, `create_time`, `update_time`, `update_uid`, `remark`) VALUES
(1, 1, 1, '00001', '苹果', 1.00, 1.00, 0, '', 0, 1, '1', 1559019025, 1559019025, 1, ''),
(2, 1, 1, '0003', '香蕉', 1.00, 1.00, 0, '', 0, 1, '1', 1559019070, 1559019070, 1, ''),
(3, 1, 3, '0008', 'MG面膜', 5.00, 1.00, 0, '', 0, 1, '4', 1559019309, 1559019309, 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_build_order`
--

CREATE TABLE `tb_product_build_order` (
  `id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL COMMENT '生产订单号',
  `u_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL COMMENT '生产的产品',
  `quantity` int(11) NOT NULL COMMENT '生产数量 ',
  `build_time` int(11) NOT NULL COMMENT '生产日期',
  `remark` varchar(50) NOT NULL COMMENT '备注',
  `create_time` int(11) NOT NULL COMMENT '创建日期',
  `storage_order_id` int(11) NOT NULL COMMENT '关联的入库订单'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_build_order_data`
--

CREATE TABLE `tb_product_build_order_data` (
  `id` int(11) NOT NULL,
  `o_id` int(11) NOT NULL COMMENT '订单',
  `p_id_bc` int(11) NOT NULL COMMENT '包材名称',
  `w_id` int(11) NOT NULL COMMENT '来自哪个仓库',
  `product_data` text NOT NULL COMMENT '产品快照',
  `quantity` int(11) NOT NULL COMMENT '消耗数量 '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_category`
--

CREATE TABLE `tb_product_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `pid` int(11) DEFAULT '0',
  `sort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产器分类';

--
-- 转存表中的数据 `tb_product_category`
--

INSERT INTO `tb_product_category` (`id`, `name`, `pid`, `sort`) VALUES
(1, '水果', 2, NULL),
(2, '干货', 0, NULL),
(3, '美妆', 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_inventory`
--

CREATE TABLE `tb_product_inventory` (
  `id` int(11) NOT NULL,
  `p_id` varchar(255) DEFAULT NULL COMMENT '产品',
  `w_id` varchar(255) DEFAULT NULL COMMENT '仓库',
  `quantity` bigint(255) DEFAULT NULL COMMENT '数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库存表';

--
-- 转存表中的数据 `tb_product_inventory`
--

INSERT INTO `tb_product_inventory` (`id`, `p_id`, `w_id`, `quantity`) VALUES
(1, '1', '2', 2996),
(2, '3', '2', 0),
(3, '1', '1', 2);

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_relation`
--

CREATE TABLE `tb_product_relation` (
  `id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `p_id_bc` int(11) NOT NULL,
  `multiple` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_sales_order`
--

CREATE TABLE `tb_product_sales_order` (
  `id` int(11) NOT NULL,
  `order_number` varchar(100) DEFAULT NULL COMMENT '订单号',
  `status` int(2) DEFAULT '1' COMMENT '状态',
  `u_id` int(11) DEFAULT NULL COMMENT '创建员工',
  `m_id` int(11) DEFAULT NULL COMMENT '购买会员',
  `create_time` int(11) DEFAULT NULL,
  `remark` text,
  `ship_time` int(11) DEFAULT NULL COMMENT '发货日期',
  `print` int(11) DEFAULT '0' COMMENT '是否打印',
  `amount` double(22,2) DEFAULT NULL COMMENT '金额',
  `points` double(22,2) DEFAULT NULL COMMENT '积分',
  `cost` double(20,2) DEFAULT NULL COMMENT '销售成本',
  `express_id` int(11) DEFAULT NULL COMMENT '快递',
  `express_num` varchar(50) DEFAULT NULL,
  `express_addr` varchar(500) DEFAULT NULL,
  `type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单管理';

--
-- 转存表中的数据 `tb_product_sales_order`
--

INSERT INTO `tb_product_sales_order` (`id`, `order_number`, `status`, `u_id`, `m_id`, `create_time`, `remark`, `ship_time`, `print`, `amount`, `points`, `cost`, `express_id`, `express_num`, `express_addr`, `type`) VALUES
(1, '20190528311257263831', 1, 1, 2, 1559019446, '', 1559019420, 1, 400.00, NULL, 200.00, 0, '', '地址地址地址地址地址地址地址', 1),
(2, '20190529311030545051', 1, 1, 0, 1559097054, '123', 1559097000, 0, 1.00, NULL, 1.00, 1, '', '21132', 1),
(3, '20190529311031521201', 1, 1, 0, 1559097112, '', 1559097060, 0, 4.00, NULL, 4.00, 0, '', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_sales_order_data`
--

CREATE TABLE `tb_product_sales_order_data` (
  `id` int(11) NOT NULL,
  `o_id` int(11) DEFAULT NULL COMMENT '订单ID',
  `status` int(255) DEFAULT '1' COMMENT '状态',
  `p_id` int(11) DEFAULT NULL COMMENT '产品',
  `quantity` bigint(20) DEFAULT NULL COMMENT '数量',
  `discounts` decimal(4,2) DEFAULT NULL COMMENT '折扣',
  `amount` double(20,2) DEFAULT '0.00' COMMENT '金额',
  `cost` double(20,2) DEFAULT NULL,
  `points` bigint(20) DEFAULT '0' COMMENT '购买积分',
  `w_id` int(11) DEFAULT NULL COMMENT '仓库',
  `product_data` text COMMENT '产品数据',
  `returns` bigint(20) DEFAULT '0' COMMENT '退货数量',
  `group_price` double(20,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单数据';

--
-- 转存表中的数据 `tb_product_sales_order_data`
--

INSERT INTO `tb_product_sales_order_data` (`id`, `o_id`, `status`, `p_id`, `quantity`, `discounts`, `amount`, `cost`, `points`, `w_id`, `product_data`, `returns`, `group_price`) VALUES
(1, 1, 1, 3, 200, NULL, 400.00, 200.00, 0, 2, 'a:18:{s:2:\"id\";i:3;s:4:\"u_id\";i:1;s:4:\"c_id\";i:3;s:4:\"code\";s:4:\"0008\";s:4:\"name\";s:8:\"MG面膜\";s:5:\"sales\";d:5;s:8:\"purchase\";d:1;s:6:\"points\";i:0;s:6:\"format\";s:0:\"\";s:6:\"lowest\";i:0;s:4:\"type\";i:1;s:4:\"unit\";s:1:\"4\";s:11:\"create_time\";i:1559019309;s:11:\"update_time\";i:1559019309;s:10:\"update_uid\";i:1;s:6:\"remark\";s:0:\"\";s:8:\"category\";s:6:\"美妆\";s:12:\"product_type\";s:6:\"正常\";}', 0, 2.00),
(2, 2, 1, 1, 1, NULL, 1.00, 1.00, 0, 2, 'a:18:{s:2:\"id\";i:1;s:4:\"u_id\";i:1;s:4:\"c_id\";i:1;s:4:\"code\";s:5:\"00001\";s:4:\"name\";s:6:\"苹果\";s:5:\"sales\";d:1;s:8:\"purchase\";d:1;s:6:\"points\";i:0;s:6:\"format\";s:0:\"\";s:6:\"lowest\";i:0;s:4:\"type\";i:1;s:4:\"unit\";s:1:\"1\";s:11:\"create_time\";i:1559019025;s:11:\"update_time\";i:1559019025;s:10:\"update_uid\";i:1;s:6:\"remark\";s:0:\"\";s:8:\"category\";s:6:\"水果\";s:12:\"product_type\";s:6:\"正常\";}', 0, 1.00),
(3, 3, 1, 1, 4, NULL, 4.00, 4.00, 0, 2, 'a:18:{s:2:\"id\";i:1;s:4:\"u_id\";i:1;s:4:\"c_id\";i:1;s:4:\"code\";s:5:\"00001\";s:4:\"name\";s:6:\"苹果\";s:5:\"sales\";d:1;s:8:\"purchase\";d:1;s:6:\"points\";i:0;s:6:\"format\";s:0:\"\";s:6:\"lowest\";i:0;s:4:\"type\";i:1;s:4:\"unit\";s:1:\"1\";s:11:\"create_time\";i:1559019025;s:11:\"update_time\";i:1559019025;s:10:\"update_uid\";i:1;s:6:\"remark\";s:0:\"\";s:8:\"category\";s:6:\"水果\";s:12:\"product_type\";s:6:\"正常\";}', 0, 1.00);

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_sales_return`
--

CREATE TABLE `tb_product_sales_return` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL COMMENT '员工',
  `o_id` int(11) DEFAULT NULL COMMENT '订单',
  `create_time` int(11) DEFAULT NULL COMMENT '时间',
  `quantity` bigint(20) DEFAULT NULL COMMENT '退货数量',
  `w_id` int(11) DEFAULT NULL COMMENT '退货仓库',
  `remark` text COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品退货';

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_scrapped`
--

CREATE TABLE `tb_product_scrapped` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL COMMENT '用户',
  `create_time` int(11) DEFAULT NULL,
  `remark` text COMMENT '备注',
  `p_id` bigint(20) DEFAULT NULL,
  `w_id` bigint(20) DEFAULT NULL,
  `quantity` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='报销产品';

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_storage_order`
--

CREATE TABLE `tb_product_storage_order` (
  `id` int(11) NOT NULL,
  `order_number` varchar(255) DEFAULT NULL COMMENT '订单号',
  `u_id` int(11) DEFAULT NULL,
  `create_time` int(10) DEFAULT NULL,
  `s_id` int(11) DEFAULT NULL COMMENT '供应商',
  `quantity` bigint(20) DEFAULT NULL COMMENT '数量',
  `amount` double(20,2) DEFAULT NULL COMMENT '金额',
  `remark` text,
  `type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tb_product_storage_order`
--

INSERT INTO `tb_product_storage_order` (`id`, `order_number`, `u_id`, `create_time`, `s_id`, `quantity`, `amount`, `remark`, `type`) VALUES
(1, '20190528311252414901', 1, 1559019161, 0, 1000, 1000.00, '', 1),
(2, '20190528311253599831', 1, 1559019239, 3, 2000, 4000.00, '', 1),
(3, '20190528311255464171', 1, 1559019346, 1, 200, 200.00, '', 1),
(5, '20190529311030099241', 1, 1559097009, 3, 2, 2.00, '123', 1),
(6, '20190529311031316481', 1, 1559097091, 0, 1, 1.00, '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_storage_order_data`
--

CREATE TABLE `tb_product_storage_order_data` (
  `id` int(11) NOT NULL,
  `o_id` int(11) DEFAULT NULL,
  `w_id` int(11) DEFAULT '0' COMMENT '仓库',
  `s_id` int(11) DEFAULT NULL COMMENT '供应商',
  `p_id` int(11) DEFAULT '0' COMMENT '产品',
  `quantity` bigint(20) DEFAULT NULL COMMENT '数量',
  `create_time` int(10) DEFAULT NULL,
  `u_id` int(11) DEFAULT NULL,
  `remark` text COMMENT '备注',
  `returns` bigint(20) DEFAULT '0' COMMENT '退货',
  `product_data` text NOT NULL,
  `amount` double(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品仓库';

--
-- 转存表中的数据 `tb_product_storage_order_data`
--

INSERT INTO `tb_product_storage_order_data` (`id`, `o_id`, `w_id`, `s_id`, `p_id`, `quantity`, `create_time`, `u_id`, `remark`, `returns`, `product_data`, `amount`) VALUES
(1, 1, 2, 0, 1, 1000, 1559019161, 1, NULL, 0, 'a:18:{s:2:\"id\";i:1;s:4:\"u_id\";i:1;s:4:\"c_id\";i:1;s:4:\"code\";s:5:\"00001\";s:4:\"name\";s:6:\"苹果\";s:5:\"sales\";d:1;s:8:\"purchase\";d:1;s:6:\"points\";i:0;s:6:\"format\";s:0:\"\";s:6:\"lowest\";i:0;s:4:\"type\";i:1;s:4:\"unit\";s:1:\"1\";s:11:\"create_time\";i:1559019025;s:11:\"update_time\";i:1559019025;s:10:\"update_uid\";i:1;s:6:\"remark\";s:0:\"\";s:8:\"category\";s:6:\"水果\";s:12:\"product_type\";s:6:\"正常\";}', 1000.00),
(2, 2, 2, 3, 1, 2000, 1559019239, 1, NULL, 0, 'a:18:{s:2:\"id\";i:1;s:4:\"u_id\";i:1;s:4:\"c_id\";i:1;s:4:\"code\";s:5:\"00001\";s:4:\"name\";s:6:\"苹果\";s:5:\"sales\";d:1;s:8:\"purchase\";d:1;s:6:\"points\";i:0;s:6:\"format\";s:0:\"\";s:6:\"lowest\";i:0;s:4:\"type\";i:1;s:4:\"unit\";s:1:\"1\";s:11:\"create_time\";i:1559019025;s:11:\"update_time\";i:1559019025;s:10:\"update_uid\";i:1;s:6:\"remark\";s:0:\"\";s:8:\"category\";s:6:\"水果\";s:12:\"product_type\";s:6:\"正常\";}', 4000.00),
(3, 3, 2, 1, 3, 200, 1559019346, 1, NULL, 0, 'a:18:{s:2:\"id\";i:3;s:4:\"u_id\";i:1;s:4:\"c_id\";i:3;s:4:\"code\";s:4:\"0008\";s:4:\"name\";s:8:\"MG面膜\";s:5:\"sales\";d:5;s:8:\"purchase\";d:1;s:6:\"points\";i:0;s:6:\"format\";s:0:\"\";s:6:\"lowest\";i:0;s:4:\"type\";i:1;s:4:\"unit\";s:1:\"4\";s:11:\"create_time\";i:1559019309;s:11:\"update_time\";i:1559019309;s:10:\"update_uid\";i:1;s:6:\"remark\";s:0:\"\";s:8:\"category\";s:6:\"美妆\";s:12:\"product_type\";s:6:\"正常\";}', 200.00),
(5, 5, 2, 3, 1, 2, 1559097009, 1, NULL, 0, 'a:18:{s:2:\"id\";i:1;s:4:\"u_id\";i:1;s:4:\"c_id\";i:1;s:4:\"code\";s:5:\"00001\";s:4:\"name\";s:6:\"苹果\";s:5:\"sales\";d:1;s:8:\"purchase\";d:1;s:6:\"points\";i:0;s:6:\"format\";s:0:\"\";s:6:\"lowest\";i:0;s:4:\"type\";i:1;s:4:\"unit\";s:1:\"1\";s:11:\"create_time\";i:1559019025;s:11:\"update_time\";i:1559019025;s:10:\"update_uid\";i:1;s:6:\"remark\";s:0:\"\";s:8:\"category\";s:6:\"水果\";s:12:\"product_type\";s:6:\"正常\";}', 2.00),
(6, 6, 2, 0, 1, 1, 1559097091, 1, NULL, 0, 'a:18:{s:2:\"id\";i:1;s:4:\"u_id\";i:1;s:4:\"c_id\";i:1;s:4:\"code\";s:5:\"00001\";s:4:\"name\";s:6:\"苹果\";s:5:\"sales\";d:1;s:8:\"purchase\";d:1;s:6:\"points\";i:0;s:6:\"format\";s:0:\"\";s:6:\"lowest\";i:0;s:4:\"type\";i:1;s:4:\"unit\";s:1:\"1\";s:11:\"create_time\";i:1559019025;s:11:\"update_time\";i:1559019025;s:10:\"update_uid\";i:1;s:6:\"remark\";s:0:\"\";s:8:\"category\";s:6:\"水果\";s:12:\"product_type\";s:6:\"正常\";}', 1.00);

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_supplier`
--

CREATE TABLE `tb_product_supplier` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL COMMENT '供应商',
  `name` varchar(255) DEFAULT NULL COMMENT '联系人',
  `tel` varchar(255) DEFAULT NULL COMMENT '电话',
  `fax` varchar(255) DEFAULT NULL COMMENT '传真',
  `mobile` varchar(255) DEFAULT NULL COMMENT '手机',
  `site` varchar(255) DEFAULT NULL COMMENT '网址',
  `email` varchar(255) DEFAULT NULL COMMENT 'EMAIL',
  `pc` varchar(255) DEFAULT NULL COMMENT '邮编',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `remark` text COMMENT '备注',
  `create_time` int(11) DEFAULT NULL COMMENT '创建日期',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `replace_uid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='供应商';

--
-- 转存表中的数据 `tb_product_supplier`
--

INSERT INTO `tb_product_supplier` (`id`, `u_id`, `company`, `name`, `tel`, `fax`, `mobile`, `site`, `email`, `pc`, `address`, `remark`, `create_time`, `update_time`, `replace_uid`) VALUES
(1, 1, '包装盒厂家', '', '', '', '', '', '', NULL, '', '', 1559019189, 1559019189, 1),
(2, 1, '防伪标厂家', '', '', '', '', '', '', NULL, '', '', 1559019196, 1559019196, 1),
(3, 1, '苹果园', '', '', '', '', '', '', NULL, '', '', 1559019205, 1559019205, 1),
(4, 1, '测试', '企业返现', '1111111', '', '', '', '', NULL, '', '', 1559054423, 1559054461, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_unit`
--

CREATE TABLE `tb_product_unit` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '单位名称',
  `sort` int(11) DEFAULT '0' COMMENT '排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tb_product_unit`
--

INSERT INTO `tb_product_unit` (`id`, `name`, `sort`) VALUES
(1, '个', 0),
(2, '瓶', 0),
(3, '箱', 0),
(4, '片', 0),
(5, '盒', 0);

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_warehouse`
--

CREATE TABLE `tb_product_warehouse` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '仓库名称',
  `default` int(1) DEFAULT '0' COMMENT '是否默认仓库',
  `address` varchar(255) DEFAULT NULL COMMENT '仓库地址',
  `remark` text,
  `sort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='仓库';

--
-- 转存表中的数据 `tb_product_warehouse`
--

INSERT INTO `tb_product_warehouse` (`id`, `name`, `default`, `address`, `remark`, `sort`) VALUES
(1, '默认仓库', 1, '', '', NULL),
(2, '上海仓库', 1, '', '', NULL),
(3, '退货仓库', 0, '', '', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_warehouse_transfer`
--

CREATE TABLE `tb_product_warehouse_transfer` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `jin_id` int(11) DEFAULT NULL COMMENT '拔入仓库',
  `out_id` int(11) DEFAULT NULL COMMENT '排出仓库',
  `p_id` int(11) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `remark` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='调拨';

--
-- 转存表中的数据 `tb_product_warehouse_transfer`
--

INSERT INTO `tb_product_warehouse_transfer` (`id`, `u_id`, `jin_id`, `out_id`, `p_id`, `number`, `create_time`, `remark`) VALUES
(1, 1, 1, 2, 1, 2, 1559054313, '');

-- --------------------------------------------------------

--
-- 表的结构 `tb_product_warehouse_user`
--

CREATE TABLE `tb_product_warehouse_user` (
  `id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `w_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='仓库负责人';

--
-- 转存表中的数据 `tb_product_warehouse_user`
--

INSERT INTO `tb_product_warehouse_user` (`id`, `u_id`, `w_id`) VALUES
(3, 1, 1),
(4, 29, 1),
(5, 1, 2),
(6, 29, 2),
(7, 1, 3),
(8, 29, 3);

-- --------------------------------------------------------

--
-- 表的结构 `tb_session`
--

CREATE TABLE `tb_session` (
  `session_id` varchar(150) NOT NULL,
  `session_expire` int(11) NOT NULL,
  `session_data` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `tb_session`
--

INSERT INTO `tb_session` (`session_id`, `session_expire`, `session_data`) VALUES
('think_3ptlteqhud1r8l43pkbdpijaho', 1559102809, 'think|a:1:{s:9:\"user_auth\";a:3:{s:2:\"id\";i:1;s:8:\"username\";s:10:\"superadmin\";s:8:\"nickname\";s:9:\"管理员\";}}'),
('think_4o59e6eccblho3gvg523g4c0l7', 1559100734, 'think|a:1:{s:9:\"user_auth\";a:3:{s:2:\"id\";i:1;s:8:\"username\";s:10:\"superadmin\";s:8:\"nickname\";s:9:\"管理员\";}}'),
('think_83jjiuqs2emkdlo5dd69c255ov', 1559100779, 'think|a:1:{s:9:\"user_auth\";a:3:{s:2:\"id\";i:1;s:8:\"username\";s:10:\"superadmin\";s:8:\"nickname\";s:9:\"管理员\";}}'),
('think_c4lf1lvtjklkdsahpe0dc4fmo9', 1559101383, 'think|a:1:{s:9:\"user_auth\";a:3:{s:2:\"id\";i:1;s:8:\"username\";s:10:\"superadmin\";s:8:\"nickname\";s:9:\"管理员\";}}'),
('think_h4hsbglc97g9sfs66k3f966b0q', 1559101796, 'think|a:1:{s:9:\"user_auth\";a:3:{s:2:\"id\";i:1;s:8:\"username\";s:10:\"superadmin\";s:8:\"nickname\";s:9:\"管理员\";}}'),
('think_o1vo46go9hmf31kmjsok736o6b', 1559102677, 'think|a:1:{s:9:\"user_auth\";a:3:{s:2:\"id\";i:1;s:8:\"username\";s:10:\"superadmin\";s:8:\"nickname\";s:9:\"管理员\";}}'),
('think_qa418g2aogspj1osflobq4b15k', 1559101034, 'think|a:1:{s:9:\"user_auth\";a:3:{s:2:\"id\";i:1;s:8:\"username\";s:10:\"superadmin\";s:8:\"nickname\";s:9:\"管理员\";}}'),
('think_thn06ghcqp7eoad9ao7b97jblq', 1559099439, 'think|a:1:{s:9:\"user_auth\";a:3:{s:2:\"id\";i:1;s:8:\"username\";s:10:\"superadmin\";s:8:\"nickname\";s:9:\"管理员\";}}');

-- --------------------------------------------------------

--
-- 表的结构 `tb_system_menu`
--

CREATE TABLE `tb_system_menu` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `path` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `url` varchar(100) NOT NULL,
  `home` varchar(50) NOT NULL,
  `is_dev` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单表';

--
-- 转存表中的数据 `tb_system_menu`
--

INSERT INTO `tb_system_menu` (`id`, `pid`, `name`, `sort`, `status`, `path`, `icon`, `url`, `home`, `is_dev`) VALUES
(1, 0, '系统首页', 1, 1, '0-1', 'fa-home', 'admin/index/main', '', 0),
(2, 1, '控制台', 0, 1, '0-1-2', '', '', '', 0),
(3, 2, '首页', 1, 1, '0-1-2-3', '', 'admin/index/main', '', 0),
(4, 0, '系统管理', 99, 1, '0-4', 'fa-gear', 'admin/system/config', '', 0),
(5, 4, '系统设置', 1, 1, '0-4-5', '', '', '', 0),
(6, 5, '菜单管理', 1, 1, '0-4-5-6', '', 'admin/system/menu', '', 0),
(7, 4, '员工管理', 2, 1, '0-4-7', '', '', '', 0),
(8, 7, '员工管理', 2, 1, '0-4-7-8', '', 'admin/system/user', '', 0),
(9, 5, '规则节点', 2, 1, '0-4-5-9', '', 'admin/system/auth_rule', '', 0),
(10, 7, '员工分组', 1, 1, '0-4-7-10', '', 'admin/system/auth_group', '', 0),
(12, 0, '库存管理', 30, 1, '0-12', 'fa-cubes', 'admin/inventory/storage', '', 0),
(14, 12, '库存管理', 3, 1, '0-12-14', '', '', '', 0),
(15, 14, '库存查询', 1, 1, '0-12-14-15', '', 'admin/inventory/stock_query', '', 0),
(17, 12, '入库管理', 1, 1, '0-12-17', '', '', '', 0),
(18, 17, '入库查询', 2, 1, '0-12-17-18', '', 'admin/inventory/storage_query', '', 0),
(20, 17, '入库', 1, 1, '0-12-17-20', '', 'admin/inventory/storage', '', 0),
(28, 57, '产品管理', 6, 1, '0-42-57-28', '', 'admin/configure/product', '', 0),
(29, 14, '调拨查询', 4, 1, '0-12-14-29', '', 'admin/inventory/transfer_query', '', 0),
(31, 12, '出库管理', 2, 1, '0-12-31', '', '', '', 0),
(32, 31, '出库', 1, 1, '0-12-31-32', '', 'admin/inventory/sales', '', 0),
(33, 31, '出库查询', 2, 1, '0-12-31-33', '', 'admin/inventory/sales_query', '', 0),
(35, 31, '退货查询', 4, 1, '0-12-31-35', '', 'admin/inventory/sales_returns_query', '', 0),
(37, 14, '报废查询', 6, 1, '0-12-14-37', '', 'admin/inventory/scrapped_query', '', 0),
(38, 42, '库存设置', 1, 1, '0-42-38', '', '', '', 0),
(39, 57, '产品分类', 1, 1, '0-42-57-39', '', 'admin/configure/product_category', '', 0),
(40, 38, '仓库管理', 2, 1, '0-4-38-40', '', 'admin/configure/warehouse', '', 0),
(41, 38, '计量单位', 3, 1, '0-4-38-41', '', 'admin/configure/unit', '', 0),
(42, 0, '库存配置', 40, 1, '0-42', 'fa-cogs', 'admin/configure/supplier', '', 0),
(43, 42, '会员管理', 3, 1, '', '', '', '', 0),
(44, 43, '会员组', 2, 1, '', '', 'admin/member/group', '', 0),
(45, 43, '会员列表', 3, 1, '', '', 'admin/member/index', '', 0),
(48, 38, '供应商', 0, 1, '0-42-47-48', '', 'admin/configure/supplier', '', 0),
(52, 2, '我的日志', 2, 1, '0-1-2-52', '', 'admin/index/log', '', 0),
(53, 38, '快递管理', 4, 1, '0-42-38-53', '', 'admin/configure/express', '', 0),
(57, 42, '产品管理', 2, 1, '0-42-57', '', '', '', 0),
(59, 5, '系统参数', 0, 1, '0-4-5-59', '', 'admin/system/config', '', 0),
(60, 4, '数据库', 3, 1, '0-4-60', '', '', '', 0),
(61, 60, '数据备份', 1, 1, '0-4-60-61', '', 'admin/database/export_list', '', 0),
(62, 60, '数据还原', 2, 1, '0-4-60-62', '', 'admin/database/import_list', '', 0),
(63, 0, '财务管理', 60, 1, '0-63', 'fa-bank', 'admin/finance/add', '', 0),
(65, 67, '银行列表', 4, 1, '0-63-64-65', '', 'admin/finance/bank', '', 0),
(67, 63, '财务', 1, 1, '0-63-67', '', '', '', 0),
(68, 67, '财务分类', 3, 1, '0-63-67-68', '', 'admin/finance/category', '', 0),
(70, 67, '账务查询', 2, 1, '0-63-67-70', '', 'admin/finance/query', '', 0),
(71, 67, '新增财务', 1, 1, '0-63-67-71', '', 'admin/finance/add', '', 0),
(76, 80, '包材关联', 3, 1, '', '', 'admin/production/product_relation', '', 0),
(77, 80, '加工', 1, 1, '', '', 'admin/production/product_build', '', 0),
(78, 80, '加工记录', 2, 1, '', '', 'admin/production/product_build_query', '', 0),
(79, 0, '生产管理', 2, 1, '', 'fa-flask', 'admin/production/product_build', '', 0),
(80, 79, ' 生产', 20, 1, '', '', '', '', 0),
(81, 38, '数据字典', 10, 0, '', '', 'admin/configure/dicts', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `tb_system_user`
--

CREATE TABLE `tb_system_user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `birthday` varchar(11) DEFAULT NULL,
  `mobile` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tb_system_user`
--

INSERT INTO `tb_system_user` (`id`, `username`, `nickname`, `password`, `email`, `sex`, `status`, `create_time`, `update_time`, `birthday`, `mobile`) VALUES
(1, 'superadmin', '管理员', 'e10adc3949ba59abbe56e057f20f883e', '1@1.com', 2, 1, 1489718475, 1492835129, '', ''),
(29, 'fas', 'fdsa', 'e10adc3949ba59abbe56e057f20f883e', '', 0, 1, 1559014989, 0, NULL, ''),
(30, '544555', '是否收费电视', 'e10adc3949ba59abbe56e057f20f883e', '', 0, 1, 1559026684, 0, NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_auth_group`
--
ALTER TABLE `tb_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_auth_rule`
--
ALTER TABLE `tb_auth_rule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_express`
--
ALTER TABLE `tb_express`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_finance_accounts`
--
ALTER TABLE `tb_finance_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_finance_bank`
--
ALTER TABLE `tb_finance_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_finance_category`
--
ALTER TABLE `tb_finance_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_member`
--
ALTER TABLE `tb_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_member_card`
--
ALTER TABLE `tb_member_card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_member_group`
--
ALTER TABLE `tb_member_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_member_points`
--
ALTER TABLE `tb_member_points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_member_price`
--
ALTER TABLE `tb_member_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_operate`
--
ALTER TABLE `tb_operate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_operate_1`
--
ALTER TABLE `tb_operate_1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_operate_2`
--
ALTER TABLE `tb_operate_2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_operate_3`
--
ALTER TABLE `tb_operate_3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_operate_4`
--
ALTER TABLE `tb_operate_4`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_operate_5`
--
ALTER TABLE `tb_operate_5`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_operate_6`
--
ALTER TABLE `tb_operate_6`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_operate_7`
--
ALTER TABLE `tb_operate_7`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_operate_8`
--
ALTER TABLE `tb_operate_8`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_operate_9`
--
ALTER TABLE `tb_operate_9`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_operate_10`
--
ALTER TABLE `tb_operate_10`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pinyin`
--
ALTER TABLE `tb_pinyin`
  ADD PRIMARY KEY (`py`);

--
-- Indexes for table `tb_product`
--
ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`u_id`),
  ADD KEY `c_id` (`c_id`) USING BTREE;

--
-- Indexes for table `tb_product_build_order`
--
ALTER TABLE `tb_product_build_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_product_build_order_data`
--
ALTER TABLE `tb_product_build_order_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_product_category`
--
ALTER TABLE `tb_product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_product_inventory`
--
ALTER TABLE `tb_product_inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product` (`p_id`),
  ADD KEY `warehouse` (`w_id`);

--
-- Indexes for table `tb_product_relation`
--
ALTER TABLE `tb_product_relation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_product_sales_order`
--
ALTER TABLE `tb_product_sales_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_product_sales_order_data`
--
ALTER TABLE `tb_product_sales_order_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `o_id` (`o_id`),
  ADD KEY `warehouse` (`w_id`);

--
-- Indexes for table `tb_product_sales_return`
--
ALTER TABLE `tb_product_sales_return`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`u_id`);

--
-- Indexes for table `tb_product_scrapped`
--
ALTER TABLE `tb_product_scrapped`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`u_id`);

--
-- Indexes for table `tb_product_storage_order`
--
ALTER TABLE `tb_product_storage_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`u_id`);

--
-- Indexes for table `tb_product_storage_order_data`
--
ALTER TABLE `tb_product_storage_order_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `o_id` (`o_id`),
  ADD KEY `w_id` (`w_id`),
  ADD KEY `s_id` (`s_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `tb_product_supplier`
--
ALTER TABLE `tb_product_supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`u_id`),
  ADD KEY `replace_uid` (`replace_uid`);

--
-- Indexes for table `tb_product_unit`
--
ALTER TABLE `tb_product_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_product_warehouse`
--
ALTER TABLE `tb_product_warehouse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_product_warehouse_transfer`
--
ALTER TABLE `tb_product_warehouse_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_product_warehouse_user`
--
ALTER TABLE `tb_product_warehouse_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_session`
--
ALTER TABLE `tb_session`
  ADD UNIQUE KEY `session_id` (`session_id`);

--
-- Indexes for table `tb_system_menu`
--
ALTER TABLE `tb_system_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_system_user`
--
ALTER TABLE `tb_system_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tb_auth_group`
--
ALTER TABLE `tb_auth_group`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用表AUTO_INCREMENT `tb_auth_rule`
--
ALTER TABLE `tb_auth_rule`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- 使用表AUTO_INCREMENT `tb_express`
--
ALTER TABLE `tb_express`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `tb_finance_accounts`
--
ALTER TABLE `tb_finance_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `tb_finance_bank`
--
ALTER TABLE `tb_finance_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `tb_finance_category`
--
ALTER TABLE `tb_finance_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_member`
--
ALTER TABLE `tb_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `tb_member_card`
--
ALTER TABLE `tb_member_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_member_group`
--
ALTER TABLE `tb_member_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `tb_member_points`
--
ALTER TABLE `tb_member_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_member_price`
--
ALTER TABLE `tb_member_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `tb_operate`
--
ALTER TABLE `tb_operate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_operate_1`
--
ALTER TABLE `tb_operate_1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_operate_2`
--
ALTER TABLE `tb_operate_2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- 使用表AUTO_INCREMENT `tb_operate_3`
--
ALTER TABLE `tb_operate_3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_operate_4`
--
ALTER TABLE `tb_operate_4`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_operate_5`
--
ALTER TABLE `tb_operate_5`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_operate_6`
--
ALTER TABLE `tb_operate_6`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_operate_7`
--
ALTER TABLE `tb_operate_7`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `tb_operate_8`
--
ALTER TABLE `tb_operate_8`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_operate_9`
--
ALTER TABLE `tb_operate_9`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_operate_10`
--
ALTER TABLE `tb_operate_10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `tb_product_build_order`
--
ALTER TABLE `tb_product_build_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_product_build_order_data`
--
ALTER TABLE `tb_product_build_order_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_product_category`
--
ALTER TABLE `tb_product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `tb_product_inventory`
--
ALTER TABLE `tb_product_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `tb_product_relation`
--
ALTER TABLE `tb_product_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_product_sales_order`
--
ALTER TABLE `tb_product_sales_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `tb_product_sales_order_data`
--
ALTER TABLE `tb_product_sales_order_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `tb_product_sales_return`
--
ALTER TABLE `tb_product_sales_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_product_scrapped`
--
ALTER TABLE `tb_product_scrapped`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_product_storage_order`
--
ALTER TABLE `tb_product_storage_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `tb_product_storage_order_data`
--
ALTER TABLE `tb_product_storage_order_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `tb_product_supplier`
--
ALTER TABLE `tb_product_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `tb_product_unit`
--
ALTER TABLE `tb_product_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `tb_product_warehouse`
--
ALTER TABLE `tb_product_warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `tb_product_warehouse_transfer`
--
ALTER TABLE `tb_product_warehouse_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `tb_product_warehouse_user`
--
ALTER TABLE `tb_product_warehouse_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `tb_system_menu`
--
ALTER TABLE `tb_system_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- 使用表AUTO_INCREMENT `tb_system_user`
--
ALTER TABLE `tb_system_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
