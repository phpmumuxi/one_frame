/*
Navicat MySQL Data Transfer
Source Host     : localhost:3306
Source Database : newbio
Target Host     : localhost:3306
Target Database : newbio
Date: 2017-06-09 09:39:00
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for ko_ads_cat
-- ----------------------------
DROP TABLE IF EXISTS `ko_ads_cat`;
CREATE TABLE `ko_ads_cat` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '广告位名称',
  `width` smallint(5) NOT NULL DEFAULT '0' COMMENT '广告位宽',
  `height` smallint(5) NOT NULL DEFAULT '0' COMMENT '广告位高',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='广告位表';

-- ----------------------------
-- Records of ko_ads_cat
-- ----------------------------
INSERT INTO `ko_ads_cat` VALUES ('1', '首页第一个横幅广告', '1200', '110');
INSERT INTO `ko_ads_cat` VALUES ('2', '首页第二个横幅广告', '1200', '110');
INSERT INTO `ko_ads_cat` VALUES ('3', '期刊列表页-右侧【转让及优惠信息】广告', '305', '85');
INSERT INTO `ko_ads_cat` VALUES ('4', '首页第三个横幅广告', '1200', '110');
INSERT INTO `ko_ads_cat` VALUES ('5', '文章列表广告', '1200', '110');
INSERT INTO `ko_ads_cat` VALUES ('6', '首页头部中间banner', '700', '353');

-- ----------------------------
-- Table structure for ko_ads_con
-- ----------------------------
DROP TABLE IF EXISTS `ko_ads_con`;
CREATE TABLE `ko_ads_con` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `cat_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '广告位ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '广告名称',
  `img` varchar(500) NOT NULL DEFAULT '' COMMENT '广告图片地址',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `target` varchar(10) NOT NULL DEFAULT '' COMMENT '打开方式：_blank新窗口，_self原窗口',
  `sort` smallint(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_huan` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是幻灯片：1是，0否',
  `add_at` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`),
  KEY `sort` (`sort`),
  KEY `add_at` (`add_at`),
  KEY `is_huan` (`is_huan`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='广告表';

-- ----------------------------
-- Records of ko_ads_con
-- ----------------------------
INSERT INTO `ko_ads_con` VALUES ('1', '1', '广告1', '/data/upload/ad_pic/20151130/144885107310593478.jpg', 'openZoosUrl(\'chatwin\',\'&e=\'+window.location.hostname+\'，首页，横幅，banner\');return false;', '_blank', '100', '0', '0');
INSERT INTO `ko_ads_con` VALUES ('2', '2', '广告2', '/data/upload/ad_pic/20151130/144885094242639772.jpg', 'openZoosUrl(\'chatwin\',\'&e=\'+window.location.hostname+\'，首页，横幅，banner\');return false;', '_blank', '100', '0', '0');
INSERT INTO `ko_ads_con` VALUES ('3', '3', '广告3', '/data/upload/ad_pic/20150421/142960213447724428.gif', 'openZoosUrl(\'chatwin\',\'&e=\'+window.location.hostname+\'，列表，右侧，banner\');return false;', '_blank', '100', '0', '0');
INSERT INTO `ko_ads_con` VALUES ('4', '4', '广告4', '/data/upload/ad_pic/20150416/142917653995329735.jpg', 'openZoosUrl(\'chatwin\',\'&e=\'+window.location.hostname+\'，首页，横幅，banner\');return false;', '_blank', '100', '0', '0');
INSERT INTO `ko_ads_con` VALUES ('5', '5', '文章列表', '/data/upload/ad_pic/20151130/144885032895360078.jpg', 'openZoosUrl(\'chatwin\',\'&e=\'+window.location.hostname+\'，列表，banner\');return false;', '_blank', '100', '0', '0');
INSERT INTO `ko_ads_con` VALUES ('22', '6', 'weixin', '/data/upload/ad_pic/20160222/145613379517850049.png', '/static/qkzt/index.html', '_blank', '100', '0', '0');
INSERT INTO `ko_ads_con` VALUES ('24', '6', '公司视频', '/data/upload/ad_pic/20160307/145733519181482.jpg', 'http://www.qkw360.com/default/index/video/', '_blank', '100', '0', '0');
INSERT INTO `ko_ads_con` VALUES ('25', '6', 'sci_zt', '/data/upload/ad_pic/20160412/146044807564550073.jpg', 'http://www.qkw360.com/static/sci_zt/index.html', '_blank', '100', '0', '0');

-- ----------------------------
-- Table structure for ko_art_type
-- ----------------------------
DROP TABLE IF EXISTS `ko_art_type`;
CREATE TABLE `ko_art_type` (
  `id` int(11) NOT NULL COMMENT '主键ID',
  `lx_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型：1文章，2期刊',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '分类名称',
  `img` varchar(300) NOT NULL DEFAULT '' COMMENT '栏目图片（保存地址）',
  `seo_title` varchar(80) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(60) NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  `seo_descripion` varchar(150) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `site_url` decimal(10,1) NOT NULL DEFAULT '0.0' COMMENT '绑定域名',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `sort` smallint(4) NOT NULL DEFAULT '0' COMMENT '排序，从小到大',
  `child_ids` varchar(5000) NOT NULL DEFAULT '' COMMENT '子ID：1,2,3,4,5'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of ko_art_type
-- ----------------------------
INSERT INTO `ko_art_type` VALUES ('1', '1', '微信营销组', '', '', '', '', '0.0', '0', '0', '');
INSERT INTO `ko_art_type` VALUES ('2', '1', '市场部', '', '', '', '', '0.0', '0', '0', '');
INSERT INTO `ko_art_type` VALUES ('3', '1', '微信推送首图', '', '', '', '', '3.0', '1', '0', '');
INSERT INTO `ko_art_type` VALUES ('4', '1', '微信图文页内图片', '', '', '', '', '12.0', '1', '0', '');
INSERT INTO `ko_art_type` VALUES ('5', '1', '名片', '', '', '', '', '12.0', '2', '0', '');
INSERT INTO `ko_art_type` VALUES ('6', '1', '微信活动页面设计', '', '', '', '', '8.0', '1', '0', '');
INSERT INTO `ko_art_type` VALUES ('7', '1', 'H5页面当中设计元素', '', '', '', '', '2.0', '1', '0', '');
INSERT INTO `ko_art_type` VALUES ('8', '1', '宣传册', '', '', '', '', '40.0', '2', '0', '');
INSERT INTO `ko_art_type` VALUES ('9', '1', '宣传单页', '', '', '', '', '16.0', '2', '0', '');
INSERT INTO `ko_art_type` VALUES ('10', '1', '宣传折页', '', '', '', '', '24.0', '2', '0', '');
INSERT INTO `ko_art_type` VALUES ('11', '1', '品牌礼品小（笔、手提袋）', '', '', '', '', '12.0', '2', '0', '');
INSERT INTO `ko_art_type` VALUES ('12', '1', '品牌礼品大（日历、会展用品）', '', '', '', '', '40.0', '2', '0', '');
INSERT INTO `ko_art_type` VALUES ('13', '1', '竞价组', '', '', '', '', '0.0', '0', '0', '');
INSERT INTO `ko_art_type` VALUES ('14', '1', '网站首页', '', '', '', '', '32.0', '13', '0', '');
INSERT INTO `ko_art_type` VALUES ('15', '1', '公司内部修图', '', '', '', '', '2.0', '2', '0', '');
INSERT INTO `ko_art_type` VALUES ('16', '1', '网站列表页', '', '', '', '', '4.0', '13', '0', '');
INSERT INTO `ko_art_type` VALUES ('17', '1', '网站详情页', '', '', '', '', '16.0', '13', '0', '');
INSERT INTO `ko_art_type` VALUES ('18', '1', '商务通', '', '', '', '', '4.0', '13', '0', '');
INSERT INTO `ko_art_type` VALUES ('19', '1', '专题页', '', '', '', '', '24.0', '13', '0', '');
INSERT INTO `ko_art_type` VALUES ('20', '1', 'banner', '', '', '', '', '3.0', '13', '0', '');
INSERT INTO `ko_art_type` VALUES ('21', '1', '手机版网站首页', '', '', '', '', '24.0', '13', '0', '');
INSERT INTO `ko_art_type` VALUES ('22', '1', '手机版网站列表页', '', '', '', '', '16.0', '13', '0', '');
INSERT INTO `ko_art_type` VALUES ('23', '1', '手机版网站详情页', '', '', '', '', '16.0', '13', '0', '');
INSERT INTO `ko_art_type` VALUES ('24', '1', '手机版专题页', '', '', '', '', '16.0', '13', '0', '');

-- ----------------------------
-- Table structure for ko_backmenu
-- ----------------------------
DROP TABLE IF EXISTS `ko_backmenu`;
CREATE TABLE `ko_backmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `url` varchar(300) NOT NULL DEFAULT '' COMMENT '连接地址',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `is_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示：1显示0不显示',
  `sort` smallint(3) NOT NULL DEFAULT '300' COMMENT '排序，从小到大',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ko_backmenu
-- ----------------------------
INSERT INTO `ko_backmenu` VALUES ('1', '控制台', '', '0', '1', '1');
INSERT INTO `ko_backmenu` VALUES ('2', '欢迎页面', '/kocp/index/welcome', '1', '1', '1');
INSERT INTO `ko_backmenu` VALUES ('3', '系统介绍', '/kocp/index/about', '1', '1', '5');
INSERT INTO `ko_backmenu` VALUES ('4', '后台菜单列表', '/kocp/menu/lists', '1', '1', '10');
INSERT INTO `ko_backmenu` VALUES ('5', '单页面管理', '/kocp/pagehtml/index', '7', '1', '1');
INSERT INTO `ko_backmenu` VALUES ('6', '网站参数设置', '/kocp/setlist/pub/kot/1', '1', '1', '15');
INSERT INTO `ko_backmenu` VALUES ('7', '设置', '', '0', '1', '10');
INSERT INTO `ko_backmenu` VALUES ('8', '管理员', '/kocp/admin/index', '7', '1', '50');
INSERT INTO `ko_backmenu` VALUES ('9', '参数分类设置', '/kocp/setcat/lists', '1', '1', '20');
INSERT INTO `ko_backmenu` VALUES ('10', '广告列表', '/kocp/ads/index', '7', '1', '10');
INSERT INTO `ko_backmenu` VALUES ('11', '友情链接', '/kocp/link/index', '7', '1', '20');
INSERT INTO `ko_backmenu` VALUES ('23', '网站规则配置', '/kocp/route/index', '7', '1', '50');
INSERT INTO `ko_backmenu` VALUES ('38', '实验室管理', '', '0', '1', '15');
INSERT INTO `ko_backmenu` VALUES ('39', '文章/新闻管理', '/kocp/news/content', '38', '1', '300');
INSERT INTO `ko_backmenu` VALUES ('40', '实验产品列表', '/kocp/product/index', '38', '1', '300');
INSERT INTO `ko_backmenu` VALUES ('41', '在线报价', '/kocp/user/info', '38', '1', '300');
INSERT INTO `ko_backmenu` VALUES ('42', '常见问题', '/kocp/user/content', '38', '1', '300');
INSERT INTO `ko_backmenu` VALUES ('43', '分类管理', '/kocp/category/index', '38', '1', '200');

-- ----------------------------
-- Table structure for ko_category
-- ----------------------------
DROP TABLE IF EXISTS `ko_category`;
CREATE TABLE `ko_category` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `parent_id` int(3) NOT NULL,
  `type` int(3) DEFAULT '1' COMMENT ' 1实验平台2文章列表3常见问题4其他',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ko_category
-- ----------------------------
INSERT INTO `ko_category` VALUES ('1', '细胞生物学平台', '0', '1');
INSERT INTO `ko_category` VALUES ('2', '蛋白质学技术平台', '0', '1');
INSERT INTO `ko_category` VALUES ('3', '分子生物学技术平台', '0', '1');
INSERT INTO `ko_category` VALUES ('4', '动物实验技术平台', '0', '1');
INSERT INTO `ko_category` VALUES ('5', '科研平台', '0', '1');
INSERT INTO `ko_category` VALUES ('9', '细胞实验', '0', '2');
INSERT INTO `ko_category` VALUES ('10', '蛋白质实验', '0', '2');
INSERT INTO `ko_category` VALUES ('11', '分子生物实验', '0', '2');
INSERT INTO `ko_category` VALUES ('12', '动物实验', '0', '2');
INSERT INTO `ko_category` VALUES ('13', '细胞培养技术', '9', '2');
INSERT INTO `ko_category` VALUES ('14', '细胞转染', '9', '2');
INSERT INTO `ko_category` VALUES ('15', '细胞增值与毒性实验', '9', '2');
INSERT INTO `ko_category` VALUES ('16', '细胞迁移与侵染实验', '9', '2');
INSERT INTO `ko_category` VALUES ('17', '细胞凋亡', '9', '2');
INSERT INTO `ko_category` VALUES ('18', '新闻资讯', '0', '3');
INSERT INTO `ko_category` VALUES ('19', '病理学分析', '2', '1');
INSERT INTO `ko_category` VALUES ('21', '细胞培养', '1', '1');
INSERT INTO `ko_category` VALUES ('22', '细胞凋亡检测', '1', '1');
INSERT INTO `ko_category` VALUES ('23', '细胞增殖与毒性', '1', '1');
INSERT INTO `ko_category` VALUES ('24', '基因过表达/沉默', '1', '1');
INSERT INTO `ko_category` VALUES ('25', '细胞转移', '1', '1');
INSERT INTO `ko_category` VALUES ('26', '流式细胞仪检测', '1', '1');
INSERT INTO `ko_category` VALUES ('27', '细胞鉴定', '1', '1');
INSERT INTO `ko_category` VALUES ('28', '基因表达差异性PCR检测', '3', '1');
INSERT INTO `ko_category` VALUES ('29', '核酸提取', '3', '1');
INSERT INTO `ko_category` VALUES ('30', 'DNA解析', '3', '1');
INSERT INTO `ko_category` VALUES ('31', '克隆服务', '3', '1');
INSERT INTO `ko_category` VALUES ('32', 'RNAi服务', '3', '1');
INSERT INTO `ko_category` VALUES ('33', '病毒包装', '3', '1');
INSERT INTO `ko_category` VALUES ('34', '表观遗传检测', '3', '1');
INSERT INTO `ko_category` VALUES ('35', '蛋白表达检测', '2', '1');
INSERT INTO `ko_category` VALUES ('36', '氧化应激检测', '2', '1');
INSERT INTO `ko_category` VALUES ('37', '生化检测', '2', '1');
INSERT INTO `ko_category` VALUES ('38', '同源性皮下移植肿瘤模型', '4', '1');
INSERT INTO `ko_category` VALUES ('39', '人肿瘤异种移植裸鼠模型', '4', '1');
INSERT INTO `ko_category` VALUES ('40', '蛋白表达检测', '10', '2');
INSERT INTO `ko_category` VALUES ('41', '病理学分析', '10', '2');
INSERT INTO `ko_category` VALUES ('42', '氧化应激检测', '10', '2');
INSERT INTO `ko_category` VALUES ('43', '生化分析', '10', '2');
INSERT INTO `ko_category` VALUES ('44', '基因表达差异性PCR检测', '11', '2');
INSERT INTO `ko_category` VALUES ('45', '核酸提取', '11', '2');
INSERT INTO `ko_category` VALUES ('46', 'DNA解析', '11', '2');
INSERT INTO `ko_category` VALUES ('47', '克隆服务', '11', '2');
INSERT INTO `ko_category` VALUES ('48', 'RNAi服务', '11', '2');
INSERT INTO `ko_category` VALUES ('49', '病毒包装', '11', '2');
INSERT INTO `ko_category` VALUES ('50', '动物实验', '12', '2');
INSERT INTO `ko_category` VALUES ('51', '肿瘤转移模型', '4', '1');
INSERT INTO `ko_category` VALUES ('52', '肿瘤原位种植模型', '4', '1');
INSERT INTO `ko_category` VALUES ('53', '代谢疾病模型', '4', '1');
INSERT INTO `ko_category` VALUES ('54', '胃肠道疾病模型', '4', '1');
INSERT INTO `ko_category` VALUES ('55', '肝胆系统疾病模型', '4', '1');
INSERT INTO `ko_category` VALUES ('56', '心脑血管疾病模型', '4', '1');
INSERT INTO `ko_category` VALUES ('57', '呼吸系统疾病模型', '4', '1');
INSERT INTO `ko_category` VALUES ('58', '泌尿生殖系统疾病模型', '4', '1');
INSERT INTO `ko_category` VALUES ('59', '免疫炎症、抗感染模型', '4', '1');

-- ----------------------------
-- Table structure for ko_configs
-- ----------------------------
DROP TABLE IF EXISTS `ko_configs`;
CREATE TABLE `ko_configs` (
  `cid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型：1基本设置，2第三方统计，3其它设置',
  `code` varchar(30) NOT NULL DEFAULT '' COMMENT '配置标识',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '参数说明',
  `value` text NOT NULL COMMENT '配置内容',
  `lx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '变量类型：1文本，2多行文本，3 布尔(Y/N)，4上传图片',
  `sort` smallint(3) NOT NULL DEFAULT '0' COMMENT '排序：越小越靠前'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统配置表';

-- ----------------------------
-- Records of ko_configs
-- ----------------------------
INSERT INTO `ko_configs` VALUES ('1', 'site_name', '网站名称', '', '1', '1');
INSERT INTO `ko_configs` VALUES ('1', 'site_logo', '网站Logo', '/data/upload/system/20150410/142865798039946525.jpg', '4', '2');
INSERT INTO `ko_configs` VALUES ('1', 'site_title', '网站标题', '', '1', '3');
INSERT INTO `ko_configs` VALUES ('1', 'site_keywords', '网站关键词', '', '1', '4');
INSERT INTO `ko_configs` VALUES ('1', 'site_description', '网站描述', '', '2', '5');
INSERT INTO `ko_configs` VALUES ('1', 'site_status', '网站是否关闭', '0', '3', '6');
INSERT INTO `ko_configs` VALUES ('1', 'site_closed_reason', '关闭原因', '系统升级中.....', '2', '7');
INSERT INTO `ko_configs` VALUES ('1', 'ko_copyright2', '网站版权2', '', '2', '10');
INSERT INTO `ko_configs` VALUES ('1', 'ko_copyright', '网站版权', '', '2', '9');
INSERT INTO `ko_configs` VALUES ('2', 'ko_arc_autopic', '提取第一张图片作为缩略图', '1', '3', '4');
INSERT INTO `ko_configs` VALUES ('2', 'ko_rm_remote', '远程图片本地化', '1', '3', '1');
INSERT INTO `ko_configs` VALUES ('2', 'ko_arc_dellink', '删除非站内链接', '0', '3', '2');
INSERT INTO `ko_configs` VALUES ('2', 'ko_search_words', '搜索关键词（英文“|”分割）', '', '2', '11');
INSERT INTO `ko_configs` VALUES ('3', 'site_tj_head', '在Head区(结尾之前)添加统计代码', '', '2', '1');
INSERT INTO `ko_configs` VALUES ('3', 'site_tj_body', '在Body区(结尾之前)域添加统计代码', '<script type=\"text/javascript\" src=\"/static/js/swt.js\"></script><script type=\"text/javascript\">var cnzz_protocol = ((\"https:\" == document.location.protocol) ? \" https://\" : \" http://\");document.write(unescape(\"%3Cspan id=\'cnzz_stat_icon_5554755\'%3E%3C/span%3E%3Cscript src=\'\" + cnzz_protocol + \"s11.cnzz.com/stat.php%3Fid%3D5554755\' type=\'text/javascript\'%3E%3C/script%3E\"));</script>\r\n<script>\r\nvar _hmt = _hmt || [];\r\n(function() {\r\n  var hm = document.createElement(\"script\");\r\n  hm.src = \"//hm.baidu.com/hm.js?18ed67e3a3ff72d2e58fff337282ea6b\";\r\n  var s = document.getElementsByTagName(\"script\")[0]; \r\n  s.parentNode.insertBefore(hm, s);\r\n})();\r\n</script>', '2', '2');
INSERT INTO `ko_configs` VALUES ('2', 'ko_stie_totle_clinch', '网站总成交', '', '1', '10');
INSERT INTO `ko_configs` VALUES ('4', 'ko_alipay_partner', '支付宝合作身份者ID，以2088开头的16位纯数字', '2088202642500979', '1', '1');
INSERT INTO `ko_configs` VALUES ('4', 'ko_alipay_key', '支付宝安全检验码，以数字和字母组成的32位字符', 'r5ekg4s8rni69duqvbsxk908p1vnm5jm', '1', '2');
INSERT INTO `ko_configs` VALUES ('4', 'ko_alipay_seller_email', '签约支付宝账号或卖家支付宝帐户', '479018526@qq.com', '1', '3');
INSERT INTO `ko_configs` VALUES ('2', 'ko_arc_allowlink', '允许的超链接(每行保存一个超链接)', '', '2', '3');
INSERT INTO `ko_configs` VALUES ('2', 'ko_detail_problem', '', '', '2', '12');
INSERT INTO `ko_configs` VALUES ('1', 'ko_top_menu', '网站头部导航', '', '2', '8');
INSERT INTO `ko_configs` VALUES ('2', 'ko_index_zhuannew', '', '', '2', '13');

-- ----------------------------
-- Table structure for ko_examples
-- ----------------------------
DROP TABLE IF EXISTS `ko_examples`;
CREATE TABLE `ko_examples` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `examples_title` varchar(255) DEFAULT NULL,
  `examples_writer` varchar(255) DEFAULT NULL,
  `examples_profession` varchar(255) DEFAULT NULL,
  `examples_factor` varchar(255) DEFAULT NULL,
  `examples_img` varchar(255) DEFAULT NULL,
  `examples_name` varchar(255) DEFAULT NULL,
  `update` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ko_examples
-- ----------------------------
INSERT INTO `ko_examples` VALUES ('3', '健康前沿', '1', '1', '1', '/data/upload/d/20161229/148297800982625839.png', '多年来，方维英文论文润色服务协助无数研究学者成功在国际期刊上展示他们的研究成果，', '2016-12-14');
INSERT INTO `ko_examples` VALUES ('4', '实用预防医学', '1', '1', '0.686', '/data/upload/d/20161229/148297812146729368.png', '多年来，方维英文论文润色服务协助无数研究学者成功在国际期刊上展示他们的研究成果', '2016-12-14');
INSERT INTO `ko_examples` VALUES ('5', '中外健康文摘', '1', '1', '0', '/data/upload/d/20161229/148297825918062134.png', '我们针对不同客户的需求，将英文论文编辑服务分为三种。方维期刊网英文论文编辑服务将使您的英语论文在语言方面无懈可击，足以刊登在任何SCI/SSCI/EI高影响因子知名期刊或在国际学术论坛刊登', '2016-12-14');
INSERT INTO `ko_examples` VALUES ('6', '电子制作', '0', '0', '0.113', '/data/upload/d/20161229/148298168738453898.png', '多年来，方维英文论文润色服务协助无数研究学者成功在国际期刊上展示他们的研究成果', '2016-12-07');
INSERT INTO `ko_examples` VALUES ('7', '文艺生活', '0', '0', '0', '/data/upload/d/20161229/148299222350162688.png', '多年来，方维英文论文润色服务协助无数研究学者成功在国际期刊上展示他们的研究成果', '2016-12-14');

-- ----------------------------
-- Table structure for ko_line_price
-- ----------------------------
DROP TABLE IF EXISTS `ko_line_price`;
CREATE TABLE `ko_line_price` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `lab_name` varchar(60) NOT NULL,
  `name` varchar(10) NOT NULL,
  `email` varchar(32) NOT NULL,
  `tel` bigint(11) NOT NULL,
  `qq` bigint(20) DEFAULT NULL,
  `des` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ko_line_price
-- ----------------------------
INSERT INTO `ko_line_price` VALUES ('1', '医学类实验', '张三', 'zhangsan@qq.com', '15236425618', '20170419150', '医学类实验', null);

-- ----------------------------
-- Table structure for ko_link
-- ----------------------------
DROP TABLE IF EXISTS `ko_link`;
CREATE TABLE `ko_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `url` varchar(300) NOT NULL DEFAULT '' COMMENT '链接地址',
  `pic` varchar(500) NOT NULL DEFAULT '' COMMENT '图片',
  `isshow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示：1显示，0默认不显示',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `pic` (`pic`(333)),
  KEY `isshow` (`isshow`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='友情链接表';

-- ----------------------------
-- Records of ko_link
-- ----------------------------
INSERT INTO `ko_link` VALUES ('1', 'ssss', 'http://www.baidu.com', '', '0', '255');

-- ----------------------------
-- Table structure for ko_manager
-- ----------------------------
DROP TABLE IF EXISTS `ko_manager`;
CREATE TABLE `ko_manager` (
  `id` int(10) unsigned NOT NULL COMMENT '主键ID',
  `users` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员名称',
  `passwd` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `nick` varchar(50) NOT NULL DEFAULT '' COMMENT '笔名',
  `roles_ids` varchar(1000) NOT NULL DEFAULT '' COMMENT '角色ID字符串',
  `last_at` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `login_num` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `err_num` tinyint(1) NOT NULL DEFAULT '0' COMMENT '登录错误次数',
  `err_at` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录错误时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1正常，2冻结',
  `bms` tinyint(1) NOT NULL COMMENT '部门id',
  `uids` varchar(50) NOT NULL COMMENT '用户权限id',
  `mids` varchar(255) NOT NULL COMMENT '菜单id',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱地址'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ko_manager
-- ----------------------------
INSERT INTO `ko_manager` VALUES ('1', 'admin', 'b5fc8c8d1ec387c40c8a9c6ea9b5c523', '', 'all', '1496731390', '192.168.1.7', '112', '0', '0', '1', '0', '1', '1,27', '');

-- ----------------------------
-- Table structure for ko_news
-- ----------------------------
DROP TABLE IF EXISTS `ko_news`;
CREATE TABLE `ko_news` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `parent_id` int(3) NOT NULL,
  `title` varchar(60) NOT NULL,
  `is_tui` int(3) NOT NULL DEFAULT '0',
  `img` varchar(100) DEFAULT NULL,
  `content` text NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ko_news
-- ----------------------------
INSERT INTO `ko_news` VALUES ('1', '13', '大鼠神经元细胞原代培养及鉴定', '1', '/data/upload/news/20170602/149638586960153130.jpg', '<p>\r\n	<span>&nbsp; 一、原理</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>将动物机体的各种组织从机体中取出，经各种酶(常用胰蛋白酶)、螯合剂(常用EDTA)或机械方法处理，分散成单细胞，置合适的培养基中培养，使细胞得以生存、生长和繁殖，这一过程称原代培养。</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>&nbsp; 二、仪器、材料及试剂</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>仪器：培养箱(调整至37℃)，培养瓶、青霉素瓶、小玻璃漏斗、平皿、吸管、移液管、纱布、手术器械、血球计数板、离心机、水浴箱(37℃)</span> \r\n</p>\r\n<p>\r\n	<span style=\"line-height:1.5;\"><br />\r\n</span>\r\n</p>\r\n<p>\r\n	<span style=\"line-height:1.5;\">材料：胎鼠或新生鼠</span>\r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>试剂：1640培养基(含20%小牛血清)，0.25%胰酶，Hank’s液，碘酒</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>&nbsp; 三、操作步骤</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>(一)胰酶消化法</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>1.器材：将孕鼠或新生小鼠拉颈椎致死，置75%酒精泡2-3秒钟(时间不能过长、以免酒精从口和肛门浸入体内)再用碘酒消毒腹部，取胎鼠带入超净台内(或将新生小鼠在超净台内)解剖取组织，置平皿中。</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>2.用Hank’s液洗涤三次，并剔除脂肪，结缔组织，血液等杂物。</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>3.用手术剪将组织剪成小块(1mm3)，再用Hank’s液洗三次，转移至小青霉素瓶中。</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>4.视组织块量加入5-6倍体积的0.25%胰酶液，37℃中消化20-40分钟，每隔5分钟振荡一次，或用吸管吹打一次，使细胞分离。</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>5.加入3-5ml培养液以终止胰酶消化作用(或加入胰酶抑制剂)。</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>6.静置5-10分钟，使未分散的组织块下沉，取悬液加入到离心管中。</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>7.1000rpm，离心10分钟，弃上清液。</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>8.加入Hank’s液5ml，冲散细胞，再离心一次，弃上清液。</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>9.加入培养液1-2ml(视细胞量)，血球计数板计数。</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>10.将细胞调整到5×105/ml左右，转移至25ml细胞培养瓶中，37℃下培养。</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>细胞分离的方法各实验室不同，所采用的消化酶也不相同(如胶原酶，透明质酶等)。</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>(二)组织块直接培养法</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>自上方法第3步后，将组织块转移到培养瓶，贴附与瓶底面。翻转瓶底朝上，将培养液加至瓶中，培养液勿接触组织块。于37℃静置3—5小时，轻轻翻转培养瓶，使组织浸入培养液中(勿使组织漂起)，37℃继续培养。</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>&nbsp; 四、注意事项</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>1、自取材开始，保持所有组织细胞处于无菌条件。细胞计数可在有菌环境中进行。</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>2、在超净台中，组织细胞、培养液等不能暴露过久，以免溶液蒸发。</span> \r\n</p>\r\n<p>\r\n	<span><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span>3、凡在超净台外操作的步骤，各器皿需用盖子或橡皮塞，以防止细菌落入。</span> \r\n</p>', '1492568795');
INSERT INTO `ko_news` VALUES ('2', '18', '临床实验室质量管理中存在的问题与对策', '1', null, '<span>临床实验室质量管理中存在的问题与对策</span><span>临床实验室质量管理中存在的问题与对策</span>', '1492569440');
INSERT INTO `ko_news` VALUES ('3', '18', '疾病预防控制中心实验室建设之PCR 实验室基本要求', '1', null, '<span>疾病预防控制中心实验室建设之PCR 实验室基本要求</span><span>疾病预防控制中心实验室建设之PCR 实验室基本要求</span>', '1492569466');
INSERT INTO `ko_news` VALUES ('4', '20', '蛋白质 实验文章', '1', '/data/upload/news/20170503/14937963315298376.jpg', '蛋白质 实验文章', '1492591351');
INSERT INTO `ko_news` VALUES ('5', '14', '细胞转染', '1', '/data/upload/news/20170503/149379630097790726.jpg', '<span>细胞转染</span>', '1492591508');
INSERT INTO `ko_news` VALUES ('6', '13', '从混杂的细胞群中分离出单一种类的细胞进行实验', '0', '/data/upload/news/20170511/149447097533253231.jpg', '<p>\r\n	<span style=\"line-height:1.5;\">实验目的：从混杂的细胞群中分离出单一种类的细胞进行实验</span> \r\n</p>\r\n<p>\r\n	<span style=\"line-height:1.5;\"><br />\r\n</span> \r\n</p>\r\n<p>\r\n	实验原理：将动物机体的各种组织从机体中取出，经各种酶、螯合剂或机械法处理，分散成单细胞，置于合适的培养基中培养，使细胞得以生存、生长和繁殖，并通过形态活免疫法鉴定细胞。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验材料仪器：超净工作台、CO2培养箱、生物倒置显微镜\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验内容与方法：\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	1. 去组织块，洗涤，用手术剪将组织剪成小块然后清洗\r\n</p>\r\n<p>\r\n	2. 胰酶消化，静置5-10分钟，取悬液\r\n</p>\r\n<p>\r\n	3. 离心，洗涤，加入适合培养基培养\r\n</p>\r\n<p>\r\n	4. 免疫组化法鉴定\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	客户提供实验信息：\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	1、实验信息(客户提供)：\r\n</p>\r\n<p>\r\n	样品信息 (包括来源、全称等)\r\n</p>\r\n<p>\r\n	2、实验材料提供\r\n</p>\r\n<p>\r\n	(1)样本材料\r\n</p>\r\n<p>\r\n	新鲜组织块\r\n</p>\r\n<p>\r\n	(2)试剂：\r\n</p>\r\n<p>\r\n	培养基、血清、如有特殊成分，需客户提供、药物及加药浓度\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	服务周期：1周(根据实验需求适当调整周期)\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	结果提交：提交实验报告书(实验试剂与设备、实验过程、细胞图片等)\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<img src=\"/data/upload/keditor/86983461494470439.jpg\" alt=\"\" /> <img src=\"/data/upload/keditor/55368201494470449.jpg\" alt=\"\" /> \r\n</p>', '1494470477');
INSERT INTO `ko_news` VALUES ('7', '13', '构建对特定药物产生耐药性的肿瘤细胞株', '1', '/data/upload/news/20170602/149638582674720585.jpg', '<p>\r\n	<span style=\"line-height:1.5;\">&nbsp; 实验原理：采用体外低浓度梯度递增联合大剂量间断冲击方法诱导肿瘤细胞对特定药物产生耐药性</span> \r\n</p>\r\n<p>\r\n	<span style=\"line-height:1.5;\"><br />\r\n</span> \r\n</p>\r\n<p>\r\n	&nbsp; 实验仪器：超净工作台、CO2培养箱、生物倒置显微镜\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	&nbsp; 实验内容与方法：\r\n</p>\r\n<p>\r\n	1. 体外低浓度梯度递增联合大剂量间断冲击方法诱导细胞的耐药性\r\n</p>\r\n<p>\r\n	2. MTT法测定药物对亲本细胞和耐药细胞的IC50，计算耐药指数\r\n</p>\r\n<p>\r\n	客户提供实验信息：\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	&nbsp; 1、实验信息(客户提供)：\r\n</p>\r\n<p>\r\n	样品信息 (包括来源、全称等)\r\n</p>\r\n<p>\r\n	&nbsp; 2、实验材料提供\r\n</p>\r\n<p>\r\n	(1)样本材料\r\n</p>\r\n<p>\r\n	生长状况良好的宿主细胞株，并提供细胞特性，培养条件及相关注意事项。\r\n</p>\r\n<p>\r\n	(2)试剂：\r\n</p>\r\n<p>\r\n	培养基，血清等常规试剂公司可以提供，诱导药物需要客户自己购买，或委托我公司代购\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	&nbsp; 服务周期：收到样品6个月内提交结果(视样本数量适当调整周期)\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	&nbsp; 结果提交：提交实验报告书(耐药指数、实验试剂与设备、实验过程、结果分析、原始数据、细胞图片等);耐药细胞株、亲本细胞株\r\n</p>', '1494470572');
INSERT INTO `ko_news` VALUES ('8', '15', ' 检测细胞群体依赖性和增殖活力', '1', '/data/upload/news/20170511/149447115341364550.jpg', '<p>\r\n	实验目的<span style=\"white-space:normal;\">&nbsp;检测细胞群体依赖性和增殖活力</span>\r\n</p>\r\n<p>\r\n	<span style=\"white-space:normal;\"><br />\r\n</span>\r\n</p>\r\n<p>\r\n	实验原理：由于细胞生物学性状不同，细胞克隆形成率差别也很大，一般初代培养细胞克隆形成率弱，传代细胞系强;二倍体细胞克隆形成率弱，转化细胞系强;正常细胞克隆形成率弱，肿瘤细胞强。并且克隆形成率与接种密度有一定关系，做克隆形成率测定时，接种细胞一定要分散成单细胞悬液，直接接种在碟皿中，持续一周，随时检查，到细胞形成克隆时终止培养。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验仪器：超净工作台、CO2培养箱、生物倒置显微镜\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验内容与方法：\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	1. 细胞培养，消化制备单细胞悬液\r\n</p>\r\n<p>\r\n	2. 以适当数量接种细胞于培养板中，培养2-3周\r\n</p>\r\n<p>\r\n	3. 肉眼观察到克隆形成，终止培养，染色观察\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	客户提供实验信息：\r\n</p>\r\n<p>\r\n	1、实验信息(客户提供)：\r\n</p>\r\n<p>\r\n	样品信息 (包括来源、全称等)\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	2、实验材料提供\r\n</p>\r\n<p>\r\n	(1)样本材料\r\n</p>\r\n<p>\r\n	生长状况良好的宿主细胞株，并提供细胞特性，培养条件及相关注意事项。\r\n</p>\r\n<p>\r\n	(2)试剂：\r\n</p>\r\n<p>\r\n	培养基，血清等常规试剂公司可以提供，诱导药物需要客户自己购买，或委托我公司代购\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	服务周期：收到样品4周内提交结果\r\n</p>\r\n<p>\r\n	结果提交：提交实验报告书(耐药指数、实验试剂与设备、实验过程、结果分析、原始数据、细胞图片等)\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<center>\r\n	<img alt=\"\" src=\"http://www.keygentec.com.cn/image/kitali/userfiles/image/1(31).jpg\" width=\"127\" height=\"111\" />\r\n</center>', '1494471153');
INSERT INTO `ko_news` VALUES ('9', '40', '检测组织或细胞中特定目的蛋白的含量。', '1', '/data/upload/news/20170526/149578235579487394.jpg', '<p>\r\n	实验目的：检测组织或细胞中特定目的蛋白的含量。\r\n</p>\r\n<p>\r\n	实验原理：将蛋白样本通过聚丙烯酰胺电泳按分子量大小分离，再转移到杂交膜上，然后通过一抗/二抗复合物对靶蛋白进行特异性检测的方法。其中的步骤包括蛋白样本提取制备，蛋白定量，电泳，转膜与显色。\r\n</p>\r\n<p>\r\n	实验材料：\r\n</p>\r\n<p>\r\n	试剂：蛋白(全/核/膜/胞浆)提取试剂盒、蛋白定量试剂盒、SDS凝胶电泳上样缓冲液、电泳缓冲液、封闭液、一抗、二抗、ECL发光液、显影液、定影液。\r\n</p>\r\n<p>\r\n	仪器：匀浆器、紫外分光光度计、bio-rad电泳仪、恒温箱。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验内容与方法：\r\n</p>\r\n<p>\r\n	1、 蛋白提取：根据需要测定的目的蛋白主要来源(胞浆、胞核或者全蛋白)，区分组织提取或者细胞提取，选取相应的试剂盒。\r\n</p>\r\n<p>\r\n	2、 蛋白定量：bradford法、BCA法或lowery法测定出所提取的蛋白含量。\r\n</p>\r\n<p>\r\n	3、 蛋白变性：5×电泳上样缓冲液，煮沸5~10分钟。\r\n</p>\r\n<p>\r\n	4、 凝胶电泳：垂直电泳分离出目的蛋白条带。\r\n</p>\r\n<p>\r\n	5、 转膜：将SDS丙烯酰胺中的蛋白通过水平电泳的方式转移到PVDF或者NC膜上。\r\n</p>\r\n<p>\r\n	6、 免疫反应：目的蛋白分别与相应的一抗、二抗结合。\r\n</p>\r\n<p>\r\n	7、 显色反应：通过化学发光法将蛋白条带显影至胶片上。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	客户提供实验信息：\r\n</p>\r\n<p>\r\n	1、 实验信息(客户提供)：\r\n</p>\r\n<p>\r\n	样本来源： 细胞 种属来源__________ 或 组织 组织来源_________\r\n</p>\r\n<p>\r\n	样本数量：__________ 检测蛋白信息：目的蛋白名称_______________ 蛋白分子量_________\r\n</p>\r\n<p>\r\n	主要表达部位(选填)_______________________ 一抗信息：抗体名称________________________ \r\n种属来源__________\r\n</p>\r\n<p>\r\n	购买公司______________ 推荐工作浓度(选填)_________\r\n</p>\r\n<p>\r\n	2、实验材料提供：\r\n</p>\r\n<p>\r\n	(1)样本材料：\r\n</p>\r\n<p>\r\n	新鲜或冷冻细胞不少于106个，新鲜或冷冻组织样本不少于50 mg。\r\n</p>\r\n<p>\r\n	已提取的蛋白样品蛋白含量不低于0.1ug/ul。\r\n</p>\r\n<p>\r\n	(2)试剂：蛋白提取与定量可根据客户要求选用特定试剂盒，如客户不提供\r\n</p>\r\n<p>\r\n	试剂盒且无特别要求，则选用凯基公司相应试剂盒产品。一抗二抗反应所用抗体客户自备，凯基也可以提供抗体代订服务。\r\n</p>\r\n<p>\r\n	服务周期：(2到8周，根据样本数量而定)\r\n</p>\r\n<p>\r\n	结果提交：提交实验报告书(包括实验材料、试剂、仪器、实验过程方法、结果及分析)、原始数据、图片，文本或电子版。\r\n</p>', '1495781354');
INSERT INTO `ko_news` VALUES ('10', '40', 'ELISA检测血清、细胞上清液等待测样品中目的蛋白的含量', '1', '/data/upload/news/20170526/149578225815533831.jpg', '<p>\r\n	实验目的：检测血清、细胞上清液等待测样品中目的蛋白的含量\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验原理：①使抗原或抗体结合到某种固相载体表面，并保持其免疫活性。②使抗原或抗体与某种酶连接成酶标抗原或抗体，这种酶标抗原或抗体既保留其免疫活性又保留酶的活性。受检标本和酶标抗原或抗体按不同的步骤与固相载体表面的抗原或抗体起反应。通过洗涤使固相载体上的抗原抗体复合物与其他物质分开，加入酶反应底物后，底物被酶催化变为有色产物，产物的量与标本中受检物质的量直接相关，故可根据颜色反应的深浅定性或定量分析。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验材料：\r\n</p>\r\n<p>\r\n	试剂：ELISA检测试剂盒\r\n</p>\r\n<p>\r\n	仪器：摇床、恒温箱、酶标仪\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验内容与方法：\r\n</p>\r\n<p>\r\n	1、制作标准曲线样品孔。\r\n</p>\r\n<p>\r\n	2、加样反应。\r\n</p>\r\n<p>\r\n	3、洗板后加生物素化抗体工作液反应。\r\n</p>\r\n<p>\r\n	4、洗板后加酶标抗体工作液反应。\r\n</p>\r\n<p>\r\n	5、洗板后加显色液避光反应。\r\n</p>\r\n<p>\r\n	6、加终止液于酶标仪上读数。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	客户提供实验信息：\r\n</p>\r\n<p>\r\n	1、实验信息(客户提供)：\r\n</p>\r\n<p>\r\n	样本名称与来源： __________ 样本数量：__________\r\n</p>\r\n<p>\r\n	检测蛋白信息：目的蛋白名称______________________\r\n</p>\r\n<p>\r\n	ELISA试剂盒：名称______________ 工作次数______T\r\n</p>\r\n<p>\r\n	购买公司______________________________\r\n</p>\r\n<p>\r\n	2、实验材料提供：\r\n</p>\r\n<p>\r\n	(1)样本材料(客户提供，运送方法见P )：\r\n</p>\r\n<p>\r\n	(2)试剂：ELISA试剂盒可根据客户要求选用特定试剂盒，如客户不提供\r\n</p>\r\n<p>\r\n	试剂盒且无特别要求，可选购凯基公司相应试剂盒产品，凯基也可以提供抗体代订服务。\r\n</p>\r\n<p>\r\n	服务周期：(2到3周，根据样本数量而定)\r\n</p>\r\n<p>\r\n	结果提交：提交实验报告书(包括实验材料、试剂、仪器、实验过程方法、结果及分析)、原始数据、图片，文本或电子版\r\n</p>', '1495781440');
INSERT INTO `ko_news` VALUES ('11', '41', '针对淀粉样物质的染色法', '1', '/data/upload/news/20170526/149578271840886676.jpg', '<p>\r\n	实验目的：针对淀粉样物质的染色法\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验原理：刚果红能把淀粉样物质染成红色复合物。\r\n</p>\r\n<p>\r\n	实验材料：\r\n</p>\r\n<p>\r\n	试剂：刚果红染液、乙醇、二甲苯等\r\n</p>\r\n<p>\r\n	仪器：切片机、烤箱微波炉或高压锅、湿盒、显微镜、孵育箱等\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验内容与方法：\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	1、哄片、脱蜡\r\n</p>\r\n<p>\r\n	2、番红染色\r\n</p>\r\n<p>\r\n	3、分化\r\n</p>\r\n<p>\r\n	4、复染\r\n</p>\r\n<p>\r\n	5、分化\r\n</p>\r\n<p>\r\n	6、脱水透明\r\n</p>\r\n<p>\r\n	7、封片。\r\n</p>\r\n<p>\r\n	客户提供实验信息：\r\n</p>\r\n<p>\r\n	1、实验信息(客户提供)：\r\n</p>\r\n<p>\r\n	样本名称与来源： 样本数量：_________\r\n</p>\r\n<p>\r\n	2、 实验材料提供：\r\n</p>\r\n<p>\r\n	冰冻组织样品需超低温保存\r\n</p>\r\n<p>\r\n	贴壁细胞必须爬片，本市可以上门取样后我们来固定，外地必须固定后再送样。悬浮细胞可充液或涂片固定好以后寄送\r\n</p>\r\n<p>\r\n	石蜡包埋组织可包埋后或固定好以后寄送\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	服务周期：(2到4周，根据样本数量而定)\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	结果提交：提交实验报告书(包括实验材料、试剂、仪器、实验过程方法、结果及分析)、原始数据、图片，文本或电子版。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验范例：\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<center>\r\n	<img alt=\"\" src=\"http://www.keygentec.com.cn/image/kitali/userfiles/image/1(51).jpg\" width=\"163\" height=\"137\" />\r\n</center>', '1495782718');
INSERT INTO `ko_news` VALUES ('12', '41', '判定各种组织、器官的病变程度与修复', '0', '/data/upload/news/20170526/149578282934013238.jpg', '<p>\r\n	实验目的：用于判定各种组织、器官的病变程度与修复情况，以不同色调显示与区分某些非结缔组织及物质成分\r\n</p>\r\n<p>\r\n	实验原理：胶原纤维呈蓝色(被苯胺蓝所染),肌纤维呈红色(被酸性品红和丽春红所染)\r\n</p>\r\n<p>\r\n	实验材料：\r\n</p>\r\n<p>\r\n	试剂：masson三色染色试剂盒\r\n</p>\r\n<p>\r\n	仪器：切片机、烤箱微波炉或高压锅、湿盒、显微镜、孵育箱等\r\n</p>\r\n<p>\r\n	实验内容与方法：\r\n</p>\r\n<p>\r\n	1、切片脱蜡至水\r\n</p>\r\n<p>\r\n	2、Weigert铁苏木素液染\r\n</p>\r\n<p>\r\n	3、分化、流水冲洗，\r\n</p>\r\n<p>\r\n	4、丽春红酸性品红液染n\r\n</p>\r\n<p>\r\n	5、分化固绿色l%冰醋酸液处理\r\n</p>\r\n<p>\r\n	6、脱水，透明，中性树胶封片。\r\n</p>\r\n<p>\r\n	客户提供实验信息：\r\n</p>\r\n<p>\r\n	1、实验信息(客户提供)：\r\n</p>\r\n<p>\r\n	样本名称与来源： 样本数量：_________\r\n</p>\r\n<p>\r\n	2、 实验材料提供：\r\n</p>\r\n<p>\r\n	冰冻组织样品需超低温保存\r\n</p>\r\n<p>\r\n	贴壁细胞必须爬片，本市可以上门取样后我们来固定，外地必须固定后再送样。悬浮细胞可充液或涂片固定好以后寄送\r\n</p>\r\n<p>\r\n	石蜡包埋组织可包埋后或固定好以后寄送\r\n</p>\r\n<p>\r\n	服务周期：(2到4周，根据样本数量而定)\r\n</p>\r\n<p>\r\n	结果提交：提交实验报告书(包括实验材料、试剂、仪器、实验过程方法、结果及分析)、原始数据、图片，文本或电子版。\r\n</p>\r\n<p>\r\n	实验范例：\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<center>\r\n	<img alt=\"\" src=\"http://www.keygentec.com.cn/image/kitali/userfiles/image/1(39).jpg\" width=\"179\" height=\"159\" />\r\n</center>', '1495782829');
INSERT INTO `ko_news` VALUES ('13', '44', '基因表达的相对定量', '1', '/data/upload/news/20170526/149578305167697190.jpg', '<p>\r\n	实验目的：目的基因表达的相对定量。\r\n</p>\r\n<p>\r\n	实验原理：利用反转录酶，把mRNA反转录生成 \r\ncDNA，再以cDNA为模板进行PCR扩增，即RT-PCR，RT-PCR对RNA的质量要求较低，操作简便，它是在转录水平上检测基因时空表达的常用方法。\r\n</p>\r\n<p>\r\n	实验仪器：Eppendorf Centrifuge5804R、UV-visible Spectrophotometer、BIO-RAD Gel \r\nDocTM XR、Multitene TC9600-G-230V LabNet。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验内容与方法：\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	1. 查找基因序列或相关参考文献，设计或查找特异性的引物，并化学合成引物;\r\n</p>\r\n<p>\r\n	2. 提取样品总RNA，分光光度法测定总RNA含量，电泳鉴定总RNA完整性;\r\n</p>\r\n<p>\r\n	3. 根据基因属性进行反转录，得到cDNA模板;\r\n</p>\r\n<p>\r\n	4. 使用1中合成的引物进行PCR预实验与正式实验;\r\n</p>\r\n<p>\r\n	5. 结果分析，提交实验报告。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验信息(客户提供)：\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	1. 基因信息：\r\n</p>\r\n<p>\r\n	待测样品种属：\r\n</p>\r\n<p>\r\n	基因全称与ID：\r\n</p>\r\n<p>\r\n	备注说明：\r\n</p>\r\n<p>\r\n	2. 实验材料：\r\n</p>\r\n<p>\r\n	(1)样本材料;\r\n</p>\r\n<p>\r\n	(2)试剂材料。\r\n</p>\r\n<p>\r\n	服务周期：2周至8周(具体视样品数而定)。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	结果提交：提交实验报告书(包括实验材料、试剂、仪器、实验过程方法、结果及分析)、原始数据、图片，文本或电子版。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验范例：RT-PCR法检测基因1/基因2基因的表达\r\n</p>\r\n<p>\r\n	1. 引物设计与合成\r\n</p>\r\n<p>\r\n	内参 primer (527bp):\r\n</p>\r\n<p>\r\n	F: 5’-CTACAATGAGCTGCGTGTGG-3’\r\n</p>\r\n<p>\r\n	R: 5’ -CGTGAGAAGGTCGGAAGGAA -3’\r\n</p>\r\n<p>\r\n	基因1 primer (320bp):\r\n</p>\r\n<p>\r\n	F:5’ -CTGAAGAGCGTGAAGGTTGGA-3’\r\n</p>\r\n<p>\r\n	R:5’ -AAGGATGTGGAGGGAGATGAGT-3’\r\n</p>\r\n<p>\r\n	基因2 primer(600bp):\r\n</p>\r\n<p>\r\n	F:5’- AAATTAATCATATGTGCAGCTGCTCCCCGGTGCAC-3’\r\n</p>\r\n<p>\r\n	R:5’ -GCTTAYGGGTCCTCGATGTC-3’\r\n</p>\r\n<p>\r\n	2. RNA提取与质量检测\r\n</p>\r\n<p>\r\n	RNA的浓度=OD260×稀释倍数×0.04μg/μL，OD260/280 \r\n在1.8～2.1视为抽提的RNA的纯度很高;总RNA琼脂糖凝胶电泳28S、18S、5S三条带较为完整。\r\n</p>\r\n<p>\r\n	3. 基因1/基因2电泳图\r\n</p>\r\n<p>\r\n	4.基因1/基因2灰度分析\r\n</p>', '1495783051');
INSERT INTO `ko_news` VALUES ('14', '45', '提取纯化RNA', '1', '/data/upload/news/20170526/149578322165496838.jpg', '<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验目的：提取纯化RNA\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验原理：利用成熟试验方法从组织中提取提取纯化大量适合后续操作的RNA\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验材料：\r\n</p>\r\n<p>\r\n	(1)样本材料;\r\n</p>\r\n<p>\r\n	(2)试剂材料。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验内容与方法：\r\n</p>\r\n<p>\r\n	1. 裂解细胞或组织，\r\n</p>\r\n<p>\r\n	2. 氯仿抽提，\r\n</p>\r\n<p>\r\n	3. 异丙醇沉淀，\r\n</p>\r\n<p>\r\n	4. 乙醇洗涤，纯化产物验证合格。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	客户提供实验信息：\r\n</p>\r\n<p>\r\n	1、实验信息(客户提供)：\r\n</p>\r\n<p>\r\n	样本名称 或其它信息。\r\n</p>\r\n<p>\r\n	2、实验材料提供\r\n</p>\r\n<p>\r\n	(1)样本材料;\r\n</p>\r\n<p>\r\n	(2)试剂材料。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	服务周期：1周至2周(具体视样本数及提取量而定)\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	结果提交：提交客户经合适质检验证合格的纯化产物，同时提交质检报告。(包括实验材料、试剂、仪器、实验过程方法、结果及分析)、原始数据、图片，文本或电子版。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验范例：\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<center>\r\n	<img alt=\"\" src=\"http://www.keygentec.com.cn/image/kitali/userfiles/image/1(47).jpg\" width=\"220\" height=\"145\" /> \r\n</center>\r\n<p>\r\n	<br />\r\n</p>', '1495783221');
INSERT INTO `ko_news` VALUES ('15', '47', 'cDNA克隆/文库 构建客户需要的基因克隆', '1', '/data/upload/news/20170526/14957845899762864.jpg', '<p>\r\n	<span style=\"line-height:1.5;\">实验目的：构建客户需要的基因克隆</span> \r\n</p>\r\n<p>\r\n	<span style=\"line-height:1.5;\"><br />\r\n</span> \r\n</p>\r\n<p>\r\n	实验原理：根据客户提供的起始克隆及cDNA起始材料，通过PCR、酶切、连接、测序等DNA操作，得到客户需要的基因克隆。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验材料：\r\n</p>\r\n<p>\r\n	(1)样本材料;\r\n</p>\r\n<p>\r\n	(2)试剂材料。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验内容与方法：\r\n</p>\r\n<p>\r\n	<span style=\"line-height:1.5;\">1. 根据客户提供的起始克隆及cDNA等起始材料设计方案及引物，</span> \r\n</p>\r\n<p>\r\n	2. 合成引物、目的基因扩增，\r\n</p>\r\n<p>\r\n	3. 扩增产物连接转化、得到亚克隆或测序验证，\r\n</p>\r\n<p>\r\n	4. 利用亚克隆扩增全长或酶切操作得到全长基因克隆，\r\n</p>\r\n<p>\r\n	5. 测序验证，或酶切转到目的表达载体。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	客户提供实验信息：\r\n</p>\r\n<p>\r\n	1、实验信息(客户提供)：\r\n</p>\r\n<p>\r\n	基因序列 目的载体及序列 或其它信息。\r\n</p>\r\n<p>\r\n	2、 实验材料提供\r\n</p>\r\n<p>\r\n	(1)样本材料;\r\n</p>\r\n<p>\r\n	(2)试剂材料。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	服务周期：3周至8周(具体视基因长度及难度而定)\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	结果提交：提交客户经测序验证正确的克隆载体，同时提交质检报告。(包括实验材料、试剂、仪器、实验过程方法、结果及分析)、原始数据、图片，文本或电子版。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	实验范例：\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	1.酶切图\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<center>\r\n	<img alt=\"\" src=\"http://www.keygentec.com.cn/image/kitali/userfiles/image/1(52).jpg\" width=\"161\" height=\"161\" /> \r\n</center>\r\n<center>\r\n	<img alt=\"\" src=\"http://www.keygentec.com.cn/image/kitali/userfiles/image/2(24).jpg\" width=\"177\" height=\"160\" /> \r\n</center>\r\n<p>\r\n	2.测序图\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<center>\r\n	<img alt=\"\" src=\"http://www.keygentec.com.cn/image/kitali/userfiles/image/3(9).jpg\" width=\"231\" height=\"241\" /> \r\n</center>', '1495783348');
INSERT INTO `ko_news` VALUES ('16', '48', ' microRNA inhibitors 干扰载体构建，使目的基因特异性沉默', '1', null, '<p>\r\n	实验原理：利用双链RNA(double-strandedRNA,dsRNA)诱发的、同源mRNA特异性降解，从而抑制特异基因表达。<br />\r\n<br />\r\n实验材料：<br />\r\n<br />\r\n试剂：DNA纯化试剂盒、DNA连接试剂盒、DNA聚合酶、DNA限制性内切酶、DNA连接酶等<br />\r\n<br />\r\n仪器：SORVALLSHO3014、UV-visibleSpectrophotometer、BIO-RADGelDocTMXR、MultiteneTC9600-G-230VLabNet、ABI3730<br />\r\n<br />\r\n实验内容与方法：<br />\r\n<br />\r\n1.序列设计、合成<br />\r\n<br />\r\n2.连接转化<br />\r\n<br />\r\n3.菌检<br />\r\n<br />\r\n4.测序<br />\r\n<br />\r\n5.提交载体及质检报告<br />\r\n<br />\r\n客户提供实验信息：<br />\r\n<br />\r\n1、实验信息(客户提供)：<br />\r\n<br />\r\n基因种属及名称载体名称及相关信息或其它信息。<br />\r\n<br />\r\n2、实验材料提供<br />\r\n<br />\r\n(1)样本材料;<br />\r\n<br />\r\n(2)试剂材料。<br />\r\n<br />\r\n服务周期：4周至6周(视载体个数、难易程度而定)<br />\r\n<br />\r\n结果提交：提交载体及质检报告(包括实验材料、试剂、仪器、实验过程方法、结果及分析)、原始数据、图片，文本或电子版。<br />\r\n<br />\r\n实验范例：<br />\r\n<br />\r\n1.SchematicoverviewofthemechanismofRNAsilencinginthehostcell<br />\r\n<br />\r\n2.TestofdifferenthairpindesignsrevealsmostefficientprocessingofsmallRNAfromshorthairpinsbasedonthemiR-122<br />\r\n<br />\r\n<br />\r\n</p>', '1495783447');
INSERT INTO `ko_news` VALUES ('17', '50', '人肝癌裸鼠皮下-肝原位移植瘤模型的建立实验', '1', '/data/upload/news/20170526/14957852743057451.jpg', '<p>\r\n	<span style=\"line-height:1.5;\">&nbsp; 实验方法原理：先用组织学完整的新鲜人肝癌组织接种于裸鼠皮下，形成皮下移植瘤，然后用此移植瘤组织再接种于裸鼠肝内，建立肝原位移植瘤模型(间接肝原位移植瘤模型)，并将其与直接肝原位移植瘤模型、皮下移植瘤模型和腹腔内移植瘤模型作比较。　　实验方法原理先用组织学完整的新鲜人肝癌组织接种于裸鼠皮下，形成皮下移植瘤，然后用此移植瘤组织再接种于裸鼠肝内，建立肝原位移植瘤模型(间接肝原位移植瘤模型)，并将其与直接肝原位移植瘤模型、皮下移植瘤模型和腹腔内移植瘤模型作比较。<br />\r\n<br />\r\n&nbsp; 实验材料NC裸鼠Balbc裸鼠<br />\r\n<br />\r\n&nbsp; 试剂、试剂盒肝癌外科手术切除标本Hanks液戊巴比妥钠甲醛石蜡<br />\r\n&nbsp;<br />\r\n&nbsp; 仪器、耗材针头光学显微镜手术刀剪刀纱布消毒液口罩<br />\r\n<br />\r\n&nbsp; 实验步骤</span>\r\n</p>\r\n<p>\r\n	<span style=\"line-height:1.5;\">&nbsp; 一、间接肝原位移植瘤模型的制备<br />\r\n<br />\r\n&nbsp; 1.用新鲜的肝癌外科手术切除标本(来自长海医院，患者为1名47岁男性，病理诊断：肝左叶肝细胞癌，粗梁型，Ⅱ级)，在Hanks液中，去除坏死组织和非癌组织后切成1～2mm3小块。<br />\r\n<br />\r\n&nbsp; 2.取2块瘤组织，在离体40min内用粗针头植入裸鼠腰背部皮下，待皮下移植瘤长到直径约1cm时切取肿瘤，在Hanks液中，去除坏死组织后切成1～2mm3小块，裸鼠用戊巴比妥钠腹腔麻醉后，行左上腹横切口，暴露肝 脏。<br />\r\n<br />\r\n&nbsp; 3.取上述2块瘤组织，在离体40min内用粗针头植入裸鼠肝右叶深部实质内，全层关腹。<br />\r\n<br />\r\n&nbsp; 二、直接肝原位移植瘤模型的制备<br />\r\n<br />\r\n&nbsp; 1.同一例新鲜肝癌手术切除标本，处理方法同皮下移植，裸鼠处理同间接肝原位移植，取2块瘤组织，在离体40min内用粗针头直接植入裸鼠肝右叶深部实质内。<br />\r\n<br />\r\n&nbsp; 2.皮下移植瘤模型和腹腔内移植瘤模型的制备。<br />\r\n<br />\r\n&nbsp; 三、病理检查和相关指标检测<br />\r\n<br />\r\n&nbsp; 1.解剖和组织学检查<br />\r\n<br />\r\n&nbsp; (1)所有裸鼠接种后，分组分笼饲养，自由进食，每天观察1～2次。<br />\r\n<br />\r\n&nbsp; (2)当裸鼠处于全身衰竭状态时处死并作大体解剖，对接种瘤和转移瘤分别进行观察、测量，记录肿瘤侵袭和转移情况，重要器官(主要为肝和肺)经10%中性甲醛固定后，常规石蜡制片，光学显微镜检查。<br />\r\n<br />\r\n&nbsp; 2.周围血甲胎蛋白(AFP)检测<br />\r\n<br />\r\n&nbsp; 处死前，均采用摘眼球采血的方法获得血液，用生化法检测AFP的分泌量。<br />\r\n<br />\r\n&nbsp; 3.瘤细胞DNA含量分析<br />\r\n<br />\r\n&nbsp; 留取部分移植瘤标本采用流式细胞术进行DNA含量分析。<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n</span> \r\n</p>\r\n<p>\r\n	<br />\r\n</p>', '1495785274');
INSERT INTO `ko_news` VALUES ('18', '50', '大鼠脑微血管内皮细胞原代培养实验', '1', '/data/upload/news/20170526/149578556951297838.jpg', '<p>\r\n	&nbsp; 实验材料：SD大鼠<br />\r\n<br />\r\n&nbsp; 试剂、试剂盒纤连蛋白Ⅳ型胶原明胶肝素钠碱性成纤维细胞生长因子青霉素链霉素NaHCO3牛血清白蛋白鼠尾胶葡聚糖DNA酶ID-Hanks\'液II型胶原酶<br />\r\n<br />\r\n&nbsp; 仪器、耗材低温离心机离心管移液枪<br />\r\n<br />\r\n&nbsp; 实验步骤\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<span style=\"line-height:1.5;\">&nbsp; 一、实验材料准备</span>\r\n</p>\r\n<p>\r\n	<br />\r\n&nbsp; 1.实验动物<br />\r\n<br />\r\n&nbsp; 每次实验采用10只2-3周龄SD大鼠，雌雄均可，体重40~60g。<br />\r\n<br />\r\n&nbsp; 2.试剂<br />\r\n<br />\r\n&nbsp; 纤连蛋白(fibronectin)、Ⅳ型胶原、鼠尾胶、葡聚糖(dextran，分子量100~200kDa)和DNA酶I(DNaseI);D-Hanks\'液、10×PBS按配方自制;II型胶原酶;明胶、牛血清白蛋白(BSA)、HEPES;Percoll;DMEM(高糖);肝素钠、NaHCO3、链霉素;胎牛血清(FBS);碱性成纤维细胞生长因子(bFGF)，胶原酶/分散酶(collagenase/dispase)购。<br />\r\n<br />\r\n&nbsp; 3.仪器<br />\r\n<br />\r\n&nbsp;&nbsp;低温离心机(Centrifuge5810R，购自Eppendorf;HimacCR22F，购自Hitachi)。<br />\r\n<br />\r\n&nbsp; 4.试剂配制<br />\r\n<br />\r\n&nbsp; (1)1mg/ml鼠尾胶(用0.2%乙酸配制)，1%明胶(用D-Hanks\'液配制)，1%II型胶原酶(用DMEM配制，用时稀释成0.1%的浓度)，1%胶原酶/分散酶(用DMEM配制，用时稀释成0.1%)，15%葡聚糖(用PBS配制)，20%BSA(用DMEM配制，调pH值至7.4后用0.45μm滤膜过滤除菌，较难过滤)，DNaseI(用冷PBS配制成2U/μl)，以上试剂经0.22μm滤膜过滤除菌后分装保存于-20℃。<br />\r\n<br />\r\n&nbsp; (2)50%Percoll(配12ml，需6mlPercoll原液，0.67ml10×PBS，0.4mlFBS，4.93mlPBS);DMEM培养液(含4000mg/LD-葡萄糖，4mmol/LL-谷氨酰胺，添加3.7g/LNaHCO3，20mmol/LHEPES，肝素钠100mg/L，青霉素100U/ml，链霉素100μg/ml)，pH值调至7.4，过滤除菌后分装保存于4℃，用时加入20%FBS及1ng/mlbFGF。<br />\r\n<br />\r\n&nbsp; 二、培养皿预处理<br />\r\n<br />\r\n&nbsp; 1.涂布3种不同的基质，培养前一天加入1ml1%明胶于35mm塑料培养皿，置于37℃培养箱过夜，接种前用D-Hanks\'液漂洗2次。<br />\r\n<br />\r\n&nbsp; 2.接种前4h，加入鼠尾胶6~10μg/cm2，在密闭的器皿里用氨气熏5~10min后，置于室温1~2h晾干后，用D-Hanks\'液漂洗2次。<br />\r\n<br />\r\n&nbsp; 3.50μl0.1%纤连蛋白、50μl1mg/mlⅣ型胶原和400μl双蒸水混合后，加入到每个培养皿中涂布均匀后吸出，可涂布10个培养皿，置于37℃培养箱1~2h晾干后，用D-Hanks\'液漂洗2次。<br />\r\n<br />\r\n&nbsp;&nbsp;三、脑微血管段的分离与脑微血管内皮细胞原代培养<br />\r\n<br />\r\n&nbsp; 1.大鼠颈椎脱臼处死后浸泡于75%乙醇中消毒3~5min后断头置于玻璃培养皿中，打开颅腔后取出全脑置于盛有冷D-Hanks\'液的玻璃培养皿中解剖去除小脑、间脑(包括海马)。<br />\r\n<br />\r\n&nbsp; 2.随后将大脑半球在干滤纸上缓慢滚动以吸除软脑膜及脑膜大血管后置于新的含冷D-Hanks\'液玻璃培养皿中，用细解剖镊去除大脑白质、残余大血管和软脑膜，保留大脑皮质。<br />\r\n<br />\r\n&nbsp; 3.用D-Hanks\'液漂洗3次后，加入1mlDMEM培养液，用虹膜剪将其剪碎成1mm3大小，加入0.1%Ⅱ型胶原酶(含30U/mlDNaseI，1ml/大脑)混匀后37℃水浴消化1.5h。<br />\r\n<br />\r\n&nbsp; 4.离心(1000rpm，8min，室温)，去上清液，加入20%BSA悬浮混匀后离心(1000g，20min，4℃)或加入15%葡聚糖悬浮混匀后离心(4000rpm，20min，4℃)，去除中上层神经组织及大血管，保留底部沉淀。<br />\r\n<br />\r\n&nbsp; 5.加入2ml0.1%胶原酶/分散酶(含20U/mlDNaseI)悬浮混匀后37℃水浴消化1h，离心(1000rpm，8min，室温)，去上清液，加入2mlDMEM培养液悬浮后铺于经离心形成连续梯度的12ml50%Percoll(25000g，60min，4℃)。<br />\r\n<br />\r\n&nbsp; 6.离心(1000g，10min，4℃)，靠近底部的红细胞层之上的白黄色的层面即为纯化的微血管段，吸出后用DMEM漂洗两次(离心1000rpm，5min，室温)，去上清液。<br />\r\n<br />\r\n&nbsp; 7.加入DMEM完全培养液(含20%FBS，100μg/ml肝素钠)悬浮后接种于涂布基质的35mm一次性塑料培养皿(1.5ml/培养皿，可接种1个培养皿/大脑)，置于37℃、5%CO2培养箱内静置培养，12~24h后换液，并加入1ng/mlbFGF，随后隔天换液。<br />\r\n<br />\r\n&nbsp;&nbsp;四、鉴定方法<br />\r\n<br />\r\n&nbsp; 形态学、Ⅷ因子相关抗原免疫组织化学检测。<br />\r\n<br />\r\n&nbsp; 五、结果<br />\r\n<br />\r\n&nbsp; 1.细胞形态观察<br />\r\n<br />\r\n&nbsp; 接种当时可见由圆形的内皮细胞构成的呈单枝状或分枝状的脑微血管段，并可见散在的单细胞及组织碎片(见图1-1);培养12~24h后可见培养的细胞从贴壁的微血管段周围长出，细胞呈短梭形，区域性单层生长，经换液后微血管段的残余部分不断减少，成纤维细胞、周细胞等杂细胞含量较少;随着培养时间的延长，内皮细胞不断增殖，可见\"漩涡\"分布，大约5~7天细胞达到融合，短梭形的内皮细胞占90%以上，但可见少量周细胞等杂细胞生长于内皮细胞单层表面或细胞克隆间隙(结果未显示)。细胞生长过程见图1，细胞接种于纤连蛋白/Ⅳ型胶原涂布的培养皿。<br />\r\n<br />\r\n&nbsp; 2.涂布不同基质的细胞生长情况<br />\r\n<br />\r\n&nbsp; 明胶及鼠尾胶涂布的培养皿微血管段贴壁时间较长，6h时可见少量微血管段贴壁但无内皮细胞长出，12~24h可见一些内皮细胞长出，24h后脑微血管段完全贴壁并有较多的内皮细胞长出，两者无明显差异(见图2-1~4);纤连蛋白/Ⅳ型胶原涂布的培养皿培养后6h即可见微血管段贴壁并有一些内皮细胞长出，12~24h内基本完全贴壁并有较多的内皮细胞长出(见图2-5,6)。<br />\r\n<br />\r\n&nbsp; 3.免疫组化鉴定<br />\r\n<br />\r\n&nbsp;&nbsp;Ⅷ因子相关抗原免疫组化检测可见培养的脑微血管内皮细胞的胞浆及核周有棕黄色着色，胞核呈空泡状结构;对照染色为阴性。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>', '1495785569');
INSERT INTO `ko_news` VALUES ('19', '50', '大鼠胰腺移植模型制作', '1', '/data/upload/news/20170526/149578601565700655.jpg', '<p>\r\n	<span style=\"line-height:1.5;\">&nbsp; 胰腺移植是目前临床上有效治疗I型糖尿病，挽救II型糖尿病晚期伴肾功能不全的外科手段，因此，胰腺移植一直受到广泛的关注，至今围绕着胰腺移植，仍有许多问题需要解决，这些问题的基础研究都需要在合适的动物模型上进行，其中大鼠因为其成本低，来源易，免疫系统与人类相似等优点，是目前器官移植领域流行的实验动物之一。但是大鼠胰腺移植模型的建立是一个难度很大的实验外科技术，操作复杂，成功率低。因此，需要建立一种比较规范，操作简便，模型稳定且成功率高的胰腺移植模型的方法，以利于进行胰腺移植的基础研究。<br />\r\n<br />\r\n&nbsp; 一、手术器械<br />\r\n<br />\r\n&nbsp; 显微外科手术器械包，手术显微镜1台，自制S拉钩(用橡皮筋一端带上弯成S形的大头针)4个，眼科剪1把，其它外科器械若干及纱布、棉球、棉片和橡皮条等。<br />\r\n<br />\r\n&nbsp; 二、供、受者大鼠的选择<br />\r\n<br />\r\n&nbsp; 根据不同的研究目的选择不同的动物品系，在同种移植模型中，一般采用两种纯系健康大鼠，如Lewis大鼠，BrownNorway大鼠(BN)，DA大鼠等，国内应用Wistar，SD大鼠也比较多。其中受者大鼠于移植手术前制备成糖尿病模型<br />\r\n<br />\r\n&nbsp; 三、大鼠糖尿病模型的建立<br />\r\n<br />\r\n&nbsp; 方法一：10%的四氧嘧啶按100mg/kg的剂量连续两天于大鼠腹股沟区皮下注射，隔日测定血糖，一周后血糖持续&gt;16.7mmol/L者，作为合格的糖尿病受者大鼠。<br />\r\n<br />\r\n&nbsp; 方法二：采用70mg/kg肌肉注射链脲霉素，以尿糖定性强阳性，非禁食血糖&gt;20mmol/L持续10天者为稳定的糖尿病模型。<br />\r\n<br />\r\n&nbsp;&nbsp;方法三：受者鼠一次性静脉注射链脲霉素55mg/kg，第7d开始测定非禁食血糖，若血糖浓度连续3d超过22mmol/L，判定为大鼠糖尿病诱导成功。<br />\r\n<br />\r\n&nbsp; 四、术前准备及麻醉方式<br />\r\n<br />\r\n&nbsp; 术前供者禁食24h，饮用50g/L葡萄糖生理盐水，受者禁食24h，饮用25g/L葡萄糖生理盐水，供、受者麻醉均采用1%的戊巴比妥钠40mg/kg腹腔注射，麻醉过浅时加乙醚吸入辅助。<br />\r\n<br />\r\n五、供胰切取术<br />\r\n<br />\r\n&nbsp; 麻醉成功后，经腹正中切口进腹，(1)将胃向上翻起，结扎切断胰腺和大网膜之间的血管联系及胃网膜左右动静脉，结扎十二指肠近端，切断幽门，在食管与胃交界出结扎切断胃左血管、食管，结扎切断胃短动脉并切除全胃;(2)胰腺下缘自脾脏向胰头方向游离胰腺，保留胰管入十二指肠管约1.5cm，结扎切断肠系膜上血管;(3)结扎切断胆总管及肝固有动脉，游离门静脉至入肝门分叉处;(4)打开腹主动脉前被覆的后腹膜，结扎切断左右肾及肾上腺动脉，完全游离腹腔动脉和肠系膜上动脉所在的腹主动脉段，经阴茎背静脉注入肝素(25U/L)生理盐水;(5)分别结扎肠系膜上动脉开口以下和腹腔动脉开口以上的腹主动脉，肠系膜上动脉开口以下腹主动脉插管，予以4℃EuroCollins液(或者4℃平衡液25U/L肝素溶液)灌洗移植物，同时横断门静脉，灌洗至门静脉断端流出液转清，移植物颜色由淡红变为苍白;(6)灌洗完成后，完整地切取移植物及脾脏，移植物置4℃EuroCollins液中保存。<br />\r\n<br />\r\n&nbsp; 六、供胰植入术<br />\r\n<br />\r\n&nbsp; (一)腔静脉-膀胱引流式胰腺移植<br />\r\n<br />\r\n&nbsp; 下腹正中切口进腹，用生理盐水纱布将肠管推向上方，膀胱、精囊腺推向下方并以拉钩固定，游离髂血管分叉上方1.5cm左右的腹主动脉及下腔静脉，经阴茎背静脉注射肝素(25IU/L)至全身肝素化，血管夹阻断游离血管上下端，9-0无创显微缝线作供者门静脉与受者下腔静脉连续端-侧吻合，8-0无创显微缝线作供者腹主动脉与受者腹主动脉连续端-侧吻合。吻合过程中移动胰腺时，牵动与移植胰腺相连脾脏，避免直接钳夹移植胰。吻合口及供者腹主动脉表面可以涂少量的ZT胶，以封闭吻合口缝隙和腹主动脉营养血管，切除移植物附带的脾脏，先远心端再近心端松开血管夹，恢复移植胰血供。<br />\r\n<br />\r\n&nbsp; &nbsp;将供者十二指肠段与受者膀胱顶部行侧-侧吻合(3-0丝线单层连续缝合)，吻合口大约0.5cm，大网膜覆盖移植物，关腹结束手术。<br />\r\n<br />\r\n&nbsp; (二)门静脉-肠道引流式胰腺移植<br />\r\n<br />\r\n&nbsp; 腹正中切口入腹，打开腹腔，在左肾静脉以下，分离出腹主动脉，用改良过的李氏钳纵行夹住该段动脉，纵行切开动脉闭，用含肝素的平衡盐溶液冲洗管腔，在低位分离肠系膜上静脉，近端用微血管夹夹住，远端用3-0丝线结扎，在同一水平高度同时结扎肠系膜上动脉。紧靠丝线结扎处切断肠系膜上静脉，管腔同样用含肝素的平衡盐溶液冲洗，切断缺血的小肠及回盲部(30~40%)，用7-0尼龙线将两断端行端-端全层肠吻合，将移植物从冰水中移出，用带冰屑的湿纱布覆盖移植物。先行静脉缝合，应确保静脉吻合后无扭转，供者门静脉与受者肠系膜上静脉以10-0无损伤显微缝线端-端间断缝合，在缝合过程中，用生理盐水灌洗静脉腔，并轻轻地用显微钳分离血管边缘，避免吻合口狭窄。供胰腺的腹主动脉与受者的腹主动脉以9-0无损伤显微缝合线行端-侧连续缝合。吻合完毕后先松开静脉夹，再松开动脉夹，用干明胶海绵轻压动脉吻合口1~2min。最后，供胰的十二指肠开口一端与受者近端空肠行端-侧吻合，另一端结扎。切除供胰上附着的脾脏，关腹结束手术。<br />\r\n<br />\r\n&nbsp; 七、术后监测和处理<br />\r\n<br />\r\n&nbsp; 根据实验研究设计的需要监测移植胰功能，如果移植胰功能正常，在发生排斥反应以前空腹血糖值正常，C-肽值正常。术后注意受者动物保温，可以置于电热毯上，以电灯热辐射24h。一般情况下，动物于术后1h内从麻醉中苏醒。术后每天皮下注射含25g/L葡萄糖和4.5g/L氯化钠的糖盐水30~40ml(内含150mg氧哌嗪青霉素)，36~48h视动物情况开始正常饮食。<br />\r\n</span> \r\n</p>\r\n<p>\r\n	<br />\r\n</p>', '1495786015');
INSERT INTO `ko_news` VALUES ('20', '50', '人胰腺癌裸小鼠模型的建立实验', '1', '/data/upload/news/20170526/149578616083709509.jpg', '<p>\r\n	<span style=\"line-height:1.5;\">&nbsp; 实验方法原理：将人胰腺癌细胞株8988接种于裸鼠腋窝处皮下，每周测量肿瘤大小，第42d处死小鼠。肿瘤组织及相关脏器送病理及电镜检查，放射免疫法检测相关抗原。皮下肿瘤组织细胞及细胞株培养，HE染色。<br />\r\n<br />\r\n&nbsp; 实验材料裸小鼠BALBcnu-nu胰腺癌细胞株8988<br />\r\n<br />\r\n&nbsp; 试剂、试剂盒RPMI-1640完全培养基胰酶戊二醛<br />\r\n<br />\r\n&nbsp; 仪器、耗材CO2培养箱试管<br />\r\n<br />\r\n&nbsp; 实验步骤</span>\r\n</p>\r\n<p>\r\n	<span style=\"line-height:1.5;\"><br />\r\n</span>\r\n</p>\r\n<p>\r\n	<span style=\"line-height:1.5;\">&nbsp;&nbsp;一、实验材料准备<br />\r\n<br />\r\n&nbsp; 裸小鼠BALB/cnu-nu，4～6周龄，体重16～20g，雌雄兼备，SPF级环境中饲养，恒温25～27℃，恒湿45%～50%，饮用水及食物均经灭菌。<br />\r\n&nbsp;<br />\r\n&nbsp; 二、人胰腺癌细胞株8988体外传代培养<br />\r\n<br />\r\n&nbsp; 1.将人胰腺癌细胞株放入含10%的RPMI-1640完全培养基中，置于37℃、5%CO2培养箱中，每2d换液1次，2～3d，0.25%的胰酶消化，一传3传代培养。<br />\r\n<br />\r\n&nbsp; 2.待细胞布满瓶底时,收集单细胞悬液，每只5×106肿瘤细胞，0.2ml，注射于裸小鼠腋窝处皮下，建立肿瘤模型。<br />\r\n<br />\r\n&nbsp; 3.每周用游标卡尺测量肿瘤大小，按公式V=π/6×长×宽×高，计算肿瘤大小，并绘制生长曲线。<br />\r\n<br />\r\n&nbsp; 三、血清学检测<br />\r\n<br />\r\n&nbsp;&nbsp;第6周时拔眼球法处死小鼠，收集血液于试管中，静置取血清，检测肿瘤相关抗原及淀粉酶。<br />\r\n<br />\r\n&nbsp; 四、巨检<br />\r\n<br />\r\n&nbsp; 1.处死裸鼠后，皮下剥离肿瘤，记录质地、浸润、血供情况，观察有无腹腔粘连，各脏器转移状况。<br />\r\n<br />\r\n&nbsp; 2.将肿瘤组织、肺、肝、脾、肠系膜、十二指肠、胃、脑等取标本置于10%的福尔马林固定液中待用。<br />\r\n<br />\r\n&nbsp; 五、病理学检测<br />\r\n<br />\r\n&nbsp; 上述标本常规石蜡包埋切片，HE染色，光镜观察。<br />\r\n<br />\r\n&nbsp; 六、超微结构观察<br />\r\n<br />\r\n&nbsp; 肿瘤组织2.5%戊二醛，1%锇酸双固定，包埋，超薄切片，铀铅双重染色，透射电镜观察。<br />\r\n<br />\r\n&nbsp;&nbsp;七、镜检<br />\r\n<br />\r\n&nbsp; 1.肿瘤组织细胞培养及活细胞观察：取新鲜裸鼠皮下肿瘤组织，PBS漂洗3次，剪成1m3大小，0.25%的胰酶消化，去除粗大组织后，制成单细胞悬液，置37℃、5%CO2培养箱中培养，倒置显微镜下观察其形态、生长情况等，并与细胞株8988进行比较。<br />\r\n<br />\r\n&nbsp; 2.细胞HE染色及形态学观察：肿瘤细胞及细胞株相同量培养于含有盖玻片的六孔板中，生长至次融合后，弃培养基，PBS洗3次，2.5%戊二醛固定，PBS洗3次，HE染色，光镜下观察比较。<br />\r\n</span> \r\n</p>\r\n<p>\r\n	<br />\r\n</p>', '1495786160');
INSERT INTO `ko_news` VALUES ('21', '17', '缺口末端标记法(TUNEL)检测细胞凋亡', '1', '/data/upload/news/20170602/149638522351748033.jpg', '<p>\r\n	&nbsp;&nbsp;实验目的：缺口末端标记法(TUNEL)检测细胞凋亡<br />\r\n<br />\r\n&nbsp; 实验原理：本实验可检测细胞在凋亡过程中细胞核DNA的断裂情况，其原理是不同标记(荧光或者生物素)的dUTP在脱氧核糖核苷酸末端转移酶(TdTEnzyme)的作用下,可以连接到凋亡细胞中断裂的DNA的3‘-OH末端，再通过荧光激发或者化学显色的方法，特异准确地定位正在凋亡的细胞，因而在显微镜下即可观察和计数凋亡细胞;由于正常的或正在增殖的细胞几乎没有DNA的断裂，因而没有3\'-OH形成，很少能够被染色。本实验适用于组织和细胞样本的凋亡原位检测。<br />\r\n<br />\r\n&nbsp; 实验仪器：低温高速离心机、光学或荧光显微镜、恒温孵育箱等<br />\r\n<br />\r\n&nbsp; 实验内容与方法：<br />\r\n<br />\r\n&nbsp; 一、样品处理<br />\r\n<br />\r\n&nbsp; 1、细胞样品：自然晾干的细胞样品固定;封闭;通透液促渗<br />\r\n<br />\r\n&nbsp; 2、冰冻样本：PBS浸润;封闭;通透液促渗<br />\r\n<br />\r\n&nbsp; 3、石蜡样品：脱蜡及水化;微波或蛋白酶K修复;封闭<br />\r\n<br />\r\n&nbsp; 二、标记反应<br />\r\n<br />\r\n&nbsp;&nbsp;1、荧光标记：滴加TdT酶反应液，反应;荧光显微镜检测<br />\r\n<br />\r\n&nbsp; 2、生物素标记：滴加TdT酶工作液反应;滴加Streptavidin-HRP工作液反应;DAB显色;苏木素复染;显微镜观察拍照<br />\r\n<br />\r\n&nbsp; 客户提供实验信息：<br />\r\n<br />\r\n&nbsp; 1、实验信息(客户提供)：<br />\r\n<br />\r\n&nbsp; 样品信息(全称、来源、种属等)<br />\r\n<br />\r\n&nbsp; 2、实验材料提供<br />\r\n<br />\r\n&nbsp; (1)样本材料：<br />\r\n<br />\r\n冰冻组织样品需超低温保存<br />\r\n<br />\r\n贴壁细胞必须爬片，本市可以上门取样后我们来固定，外地必须固定后再送样。悬浮细胞可充液或涂片固定好以后寄送<br />\r\n<br />\r\n石蜡包埋组织可包埋后或固定好以后寄送<br />\r\n<br />\r\n&nbsp; (2)试剂：<br />\r\n<br />\r\n采用TUNEL系列凋亡检测试剂盒等。或可按客户要求代订和使用其它品牌公司试剂。<br />\r\n<br />\r\n服务周期：2周至5周(具体视样品数而定)<br />\r\n<br />\r\n结果提交：提交实验报告书(包括实验材料、试剂、仪器、实验过程方法、结果及分析)、原始数据、图片，文本或电子版。<br />\r\n<br />\r\n&nbsp; 实验范例:<br />\r\n<br />\r\n经饥饿处理小鼠空肠小鼠肝损伤模型的肝组织\r\n</p>\r\n<p>\r\n	<br />\r\n</p>', '1495786846');
INSERT INTO `ko_news` VALUES ('22', '16', 'MTT（四唑盐）比色法', '0', '/data/upload/news/20170602/149638565827083851.jpg', '<p>\r\n	&nbsp;&nbsp;实验方法原理:\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	MTT法是Mosmann \r\n1983年报道的，以后此方法得到了迅速发展并广泛应用于临床与科研研究。其原理是活细胞中脱氢酶能将四唑盐还原成不溶于水的蓝紫色产物(formazan)，并沉淀在细胞中，而死细胞没有这种功能。二甲亚砜(DMSO)能溶解沉积在细胞中蓝紫色结晶物，溶液颜色深浅与所含的formazan量成正比。再用酶标仪测定OD值。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	&nbsp; 实验材料细胞样品\r\n</p>\r\n<p>\r\n	试剂、试剂盒PBSDMSO胰蛋白酶甘氨酸缓冲液二甲亚枫\r\n</p>\r\n<p>\r\n	仪器、耗材加样器96孔培养板酶标仪培养板\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	&nbsp; 实验步骤\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	&nbsp; 一、实验前应明确的问题\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	1. \r\n选择适当的细胞接种浓度。一般情况下，96孔培养板的一内贴壁细胞长满时约有105个细胞。但由于不同细胞贴壁后面积差异很大，因此，在进行MTT试验前，要进行预实验检测其贴壁率、倍增时间以及不同接种细胞数条件下的生长曲线，确定试验中每孔的接种细胞数和培养时间，以保证培养终止致细胞过满。这样，才能保证MTT结晶形成酌量与细胞数呈的线性关系。否则细胞数太多敏感性降低，太少观察不到差异。\r\n</p>\r\n<p>\r\n	2. \r\n药物浓度的设定。一定要多看文献，参考别人的结果再定个比较大的范围先初筛。根据自己初筛的结果缩小浓度和时间范围再细筛。切记!否则，可能你用的时间和浓度根本不是药物的有效浓度和时间。\r\n</p>\r\n<p>\r\n	3. \r\n时间点的设定。在不同时间点的测定OD值，输入excel表，最后得到不同时间点的抑制率变化情况，画出变化的曲线，曲线什么时候变得平坦了(到了平台期)那个时间点应该就是最好的时间点(因为这个时候的细胞增殖抑制表现的最明显)。\r\n</p>\r\n<p>\r\n	4. 培养时间。200 ul的培养液对于10的4~5次方的增殖期细胞来说，很难维持68 \r\nh，如果营养不够的话，细胞会由增殖期渐渐趋向G0期而趋于静止，影响结果，我们是在48 h换液的。\r\n</p>\r\n<p>\r\n	5. MTT法只能测定细胞相对数和相对活力，不能测定细胞绝对数。做MTT时，尽量无菌操作，因为细菌也可以导致MTT比色OD值的升高。\r\n</p>\r\n<p>\r\n	6. 理论未必都是对的。要根据自己的实际情况调整。\r\n</p>\r\n<p>\r\n	7. \r\n实验时应设置调零孔，对照孔，加药孔。调零孔加培养基、MTT、二甲基亚砜。对照孔和加药孔都要加细胞、培养液、MTT、二甲基亚砜，不同的是对照孔加溶解药物的介质，而加药组加入不同浓度的药物。\r\n</p>\r\n<p>\r\n	8. \r\n避免血清干扰。用含15%胎牛血清培养液培养细胞时，高的血清物质会影响试验孔的光吸收值。由于试验本底增加，会试验敏感性。因此，一般选小于10%胎牛血清的培养液进行。在呈色后，尽量吸净培养孔内残余培养液。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	&nbsp; 经验总结\r\n</p>\r\n<p>\r\n	1. \r\n首先细胞的接种密度一定不能过大，一般每孔1000个左右就够了，我认为宁少勿多。尤其是对于肿瘤细胞。10000/孔是太高了，这样即使药物有作用，MTT方法也是表现不出的，最佳点板浓度在4000-5000/孔，太少的话SD值会很大。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	2. \r\nMTT本身就是比较粗的实验，增殖率10%左右的波动都不算奇怪。特别是新手，20%的波动也是常见的，所以很可能是技术原因引起的，特别是种板技术一定要过关。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	3. \r\n我做的是肿瘤细胞的MTT实验，这种细胞长的很快一开始我是用100000/ML的浓度来接种的，结果细胞长的太满结果是没有梯度也没有线性关系.后来调整浓度，用过40000~80000/ML的浓度都做过MTT实验，结果发现做的结果比较好点的是60000~70000/ML的浓度组的.用40000/M的浓度的组，由于细胞少，药物作用的梯度还是有，只是没有很好的线性关系.还有根据细胞生长速度以及药物的特性(有时间依赖性和浓度依赖性的药物)来确定培养时间是48小时还是72小时.\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	4. \r\n注意细胞悬液一定要混匀，已避免细胞沉淀下来，导致每孔中的细胞数量不等，可以每接几个就要再混匀一下。加样器操作要熟练，尽量避免人为误差。虽然移液器比移液管精确得多，但是如果操作不熟，CV会在8%左右。另外，吹散次数过多也会影响细胞活力。所以要熟练鞋、快些上板。\r\n</p>', '1496385658');

-- ----------------------------
-- Table structure for ko_pagehtml
-- ----------------------------
DROP TABLE IF EXISTS `ko_pagehtml`;
CREATE TABLE `ko_pagehtml` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
  `keywords` varchar(200) NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(300) NOT NULL DEFAULT '' COMMENT '描述',
  `body` text NOT NULL COMMENT '内容',
  `is_title` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示标题：1是，0否',
  `is_time` tinyint(1) DEFAULT '0' COMMENT '是否显示时间：1是，0否',
  `mod_at` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ko_pagehtml
-- ----------------------------

-- ----------------------------
-- Table structure for ko_product
-- ----------------------------
DROP TABLE IF EXISTS `ko_product`;
CREATE TABLE `ko_product` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(3) NOT NULL,
  `name` varchar(20) NOT NULL,
  `lab_about` text,
  `content` text,
  `is_tui` int(2) NOT NULL DEFAULT '0',
  `lab_demo` text,
  `img` varchar(100) DEFAULT NULL,
  `lab_member` text,
  `lab_name` text,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ko_product
-- ----------------------------
INSERT INTO `ko_product` VALUES ('1', '1', '细胞培养', '平台拥有多种载体系统，可根据客户需要进行基因克隆、载体构建、并可提供高纯度质粒制备服务。', '<p>\r\n	<img src=\"/data/upload/keditor/48545321494468751.png\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/21813201496386241.jpg\" alt=\"\" style=\"line-height:1.5;\" />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	原代细胞分离与鉴定\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/52323671496386275.jpg\" alt=\"\" style=\"line-height:1.5;\" /> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	细胞3D培养\r\n</p>', '/data/upload/p_img/20170419/149256508529330198.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '细胞培养');
INSERT INTO `ko_product` VALUES ('2', '1', '细胞凋亡检测', '细胞凋亡是一种不同于坏死的由基因调控的细胞主动性死亡过程，是细胞在一定的生理或病理状态下，遵循自身的程序，自己结束自己生命的过程，最后细胞脱落离体或裂解为......', '<p>\r\n	<img src=\"/data/upload/keditor/30024841494472067.jpg\" alt=\"\" width=\"788\" height=\"876\" title=\"\" align=\"\" /> \r\n</p>', '0', '<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/84683051495606430.jpg\" alt=\"\" width=\"300\" height=\"154\" title=\"\" align=\"\" style=\"line-height:1.5;\" /> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<span style=\"white-space:normal;\">线粒体膜电位实验j结果图</span> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/25969781496387379.jpg\" alt=\"\" width=\"363\" height=\"216\" title=\"\" align=\"\" /> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	AO染色结果图\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<br />\r\n</p>', '/data/upload/p_img/20170602/149638746397718368.jpg', '实验操作人员经验丰富、技术熟练，从事生物行业多年', '细胞凋亡检测');
INSERT INTO `ko_product` VALUES ('3', '2', '蛋白表达检测', '提供RNA提取、逆转录、RT-PCR与Real Time PCR等实验外包服务。', '<p>\r\n	<img src=\"/data/upload/keditor/62420421494474053.jpg\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/74724211495616473.jpg\" alt=\"\" style=\"line-height:1.5;\" /> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<span style=\"white-space:normal;\">原核蛋白表达实验结果</span> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<span style=\"white-space:normal;\"><br />\r\n</span> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<span style=\"white-space:normal;\"><img src=\"/data/upload/keditor/91356101496387604.jpg\" alt=\"\" /><br />\r\n</span> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<span style=\"white-space:normal;\">小鼠骨骼肌组织中myoglobin蛋白电泳条带<br />\r\n</span> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<br />\r\n</p>', '/data/upload/p_img/20170419/149258975176548822.jpg', '实验操作人员经验丰富、技术熟练，从事生物行业多年', '蛋白表达检测');
INSERT INTO `ko_product` VALUES ('5', '1', '细胞鉴定', '该平台具有丰富的细胞培养经验，为细胞生物学研究提供最基础的保障。', '<p>\r\n	<img src=\"/data/upload/keditor/42712461494471225.png\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/98041391495616614.jpg\" alt=\"\" /> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<span style=\"text-align:center;white-space:normal;\">支原体检测试验结果</span>\r\n</p>', '/data/upload/p_img/20170510/149440821282082605.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年', '细胞鉴定');
INSERT INTO `ko_product` VALUES ('6', '1', '细胞转移', '细胞转移指的是细胞在接收到迁移信号或感受到某些物质的浓度梯度后而产生的移动。', '<p>\r\n	<img src=\"/data/upload/keditor/71824441494470672.png\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/96813201495616869.jpg\" alt=\"\" /> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<span style=\"white-space:normal;\">细胞侵袭实验结果图</span>\r\n</p>', '/data/upload/p_img/20170510/149440832619098135.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年', '细胞转移');
INSERT INTO `ko_product` VALUES ('7', '1', '流式细胞仪检测', '流式细胞术（Flow Cytometry, FCM）是一种在功能水平上对单细胞或其他生物粒子进行定量分析和分选的检测手段，它可以高速分析上万个细胞，并能同时从一个细胞中......', '<p>\r\n	<img src=\"/data/upload/keditor/76180941494471016.png\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/77313811495617366.jpg\" alt=\"\" width=\"500\" height=\"331\" title=\"\" align=\"\" /> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<span style=\"white-space:normal;\">细胞凋亡检测实验结果</span>\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n</p>', '/data/upload/p_img/20170602/149638905898027987.jpg', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '流式细胞仪检测');
INSERT INTO `ko_product` VALUES ('8', '1', '基因过表达/沉默', '基因表达沉默是一个非常复杂和普遍的现象，转录后水平的基因沉默是指转基因在细胞核里能稳定转录到细胞质里却无相应的稳定态mRNA存在的现象，它往往被称为共抑制、静息作用或RNA干预等。', '<p>\r\n	<img src=\"/data/upload/keditor/43800721494468612.png\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/77001721495617471.jpg\" alt=\"\" style=\"line-height:1.5;\" />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<span style=\"text-align:center;white-space:normal;\">瞬时转染实验结果图</span>\r\n</p>', '/data/upload/p_img/20170510/149440850374227372.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年', '基因过表达/沉默');
INSERT INTO `ko_product` VALUES ('9', '1', '细胞增殖与毒性', '细胞增殖是生物体的重要生命特征，细胞以分裂的方式进行增殖，是生活细胞的重要生理功能之一。细胞的增殖是生物体生长、发育、繁殖以及遗传的基础。而细胞毒性是......', '<p>\r\n	<img src=\"/data/upload/keditor/31251531494469356.png\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/93712911495618690.png\" alt=\"\" style=\"line-height:1.5;\" /> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<span style=\"white-space:normal;\">克隆形成实验结果</span> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/1909351496388643.jpg\" alt=\"\" /><img src=\"/data/upload/keditor/26910951496388673.jpg\" alt=\"\" /> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	Brdu标记法与存活曲线测定\r\n</p>', '/data/upload/p_img/20170510/149440861728699193.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年', '细胞增殖与毒性');
INSERT INTO `ko_product` VALUES ('10', '2', '病理学分析', '将病变组织制作成切片，经不同方法染色后用显微镜观察其病理变化，提高了肉眼观察的分辨能力，加深了对疾病和病变的认识，是最常用的观察、研究疾病的手段。', '<p>\r\n	<img src=\"/data/upload/keditor/76840441494483113.jpg\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/60251431495675148.jpg\" alt=\"\" style=\"line-height:1.5;\" /> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<span style=\"text-align:center;white-space:normal;\">番红o染色实验结果</span> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/88501301495675154.jpg\" alt=\"\" /> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<span style=\"text-align:center;white-space:normal;\">masson染色实验结果</span> \r\n</p>', '/data/upload/p_img/20170511/149446757720049605.jpg', '实验团队经验丰富', '病理学分析');
INSERT INTO `ko_product` VALUES ('11', '3', '基因表达差异性PCR检测', '提供RNA提取，逆转录，引物设计合成，普通RT-PCR与Real time PCR等实验外包服务。', '<p>\r\n	<img src=\"/data/upload/keditor/62407571494468229.jpg\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/25094641495678174.jpg\" alt=\"\" style=\"line-height:1.5;\" /><img src=\"/data/upload/keditor/74273521495678182.jpg\" alt=\"\" style=\"line-height:1.5;\" /> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<span style=\"text-align:center;white-space:normal;\">相对定量基因Real time-PCR检测(SYBRGreen掺法)实验结果图</span> \r\n</p>', '/data/upload/p_img/20170605/149664191671999629.jpg', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '基因表达差异性PCR检测');
INSERT INTO `ko_product` VALUES ('12', '3', '核酸提取', '核酸包括：DNA和RNA，是分子生物学实验的基础，但DNA和RNA的提取和纯化在常规实验室仍然是一件繁琐的事情，大大影响了科研人员的......', '<p>\r\n	<img src=\"/data/upload/keditor/81531561494468349.png\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/61630161495678386.jpg\" alt=\"\" style=\"line-height:1.5;\" />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	RNA琼脂糖凝胶电泳图\r\n</p>', '/data/upload/p_img/20170602/149639022828173740.jpg', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '核酸提取');
INSERT INTO `ko_product` VALUES ('13', '3', 'DNA解析', '该平台提供快速、准确的基因解析服务，包括普通测序、SNP分型、STR、MLPA、MLST等基因解析服务', '<p>\r\n	<img src=\"/data/upload/keditor/43418721494468446.png\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/64450211495690830.jpg\" alt=\"\" /> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<span style=\"white-space:normal;\">SNP(直接测序法)实验结果图</span>\r\n</p>', '/data/upload/p_img/20170511/149446792868365560.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', 'DNA解析');
INSERT INTO `ko_product` VALUES ('14', '2', '氧化应激检测', '检测由于体内氧化与抗氧化作用失衡所导致中性粒细胞炎性浸润，蛋白酶分泌增加所产生的大量氧化中间产物。', '<p>\r\n	<img src=\"/data/upload/keditor/38308361494483499.png\" alt=\"\" /> \r\n</p>', '0', '<p style=\"text-align:center;\">\r\n	&nbsp;<img src=\"/data/upload/keditor/15135791496393824.jpg\" alt=\"\" width=\"680\" height=\"383\" title=\"\" align=\"\" />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	活性氧（ROS）检测结果图\r\n</p>', '/data/upload/p_img/20170602/149639387453744243.jpg', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '氧化应激检测');
INSERT INTO `ko_product` VALUES ('15', '3', '克隆服务', '平台拥有多种载体系统，可根据客户需要进行基因克隆、载体构建。并根据客户的要求，准确无误的操作，提供适合的高纯度质粒后。', '<p>\r\n	<img src=\"/data/upload/keditor/62382901494472608.png\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	cDNA克隆/文库实验结果：\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	1、酶切图\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/58818191495690996.jpg\" alt=\"\" /> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	2、测序图\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/81000361495691005.jpg\" alt=\"\" /> \r\n</p>', '/data/upload/p_img/20170511/149448059215275600.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '克隆服务');
INSERT INTO `ko_product` VALUES ('17', '3', 'RNAi服务', '该平台拥有成熟的siRNA、miRNA载体构建、转染、检测技术，可根据客户需要进行siRNA、miRNA载体构建，细胞转染及相关指标检测。', '<p>\r\n	<img src=\"/data/upload/keditor/265311494472831.png\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:right;\">\r\n	MicroRNA inhibitors化学合成实验结果：\r\n</p>\r\n<p style=\"text-align:right;\">\r\n	提交载体及质检报告(包括实验材料、试剂、仪器、实验过程方法、结果及分析)、原始数据、图片，文本或电子版。\r\n</p>\r\n<p style=\"text-align:right;\">\r\n	1、 Schematic overview of the mechanism of RNA silencing in the host \r\ncell\r\n</p>\r\n<p style=\"text-align:right;\">\r\n	<img src=\"/data/upload/keditor/11519441495691575.jpg\" alt=\"\" /> \r\n</p>\r\n<p style=\"text-align:right;\">\r\n	2、Test of different hairpin designs reveals most efficient processing of \r\nsmall RNA from short hairpins based on the miR-122\r\n</p>\r\n<p style=\"text-align:right;\">\r\n	<img src=\"/data/upload/keditor/61167661495691583.jpg\" alt=\"\" /> \r\n</p>', '/data/upload/p_img/20170511/14944729186473135.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', 'RNAi服务');
INSERT INTO `ko_product` VALUES ('18', '3', '病毒包装', '该平台拥有成熟的siRNA、miRNA、过表达载体等载体构建、病毒包装系统，为客户提供安全有效的相关载体构建病毒包装服务。', '<p>\r\n	<img src=\"/data/upload/keditor/20457021494473047.png\" alt=\"\" /> \r\n</p>', '1', '<p>\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/data/upload/keditor/3441651495691685.jpg\" alt=\"\" width=\"300\" height=\"311\" title=\"\" align=\"\" /> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<span style=\"white-space:normal;\">RNAi干扰腺/慢病毒包装实验结果图</span>\r\n</p>', '/data/upload/p_img/20170605/1496626091340704.jpg', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '病毒包装');
INSERT INTO `ko_product` VALUES ('19', '3', '表观遗传检测', '该平台具备过硬的表观遗传学相关检测技术，为客户提供优质的组蛋白乙酰化、MSP、BSP检测服务。', '<p>\r\n	<img src=\"/data/upload/keditor/94153121494473777.png\" alt=\"\" /> \r\n</p>', '1', '<p>\r\n	组蛋白乙酰化实验结果：\r\n</p>\r\n<p>\r\n	<img src=\"/data/upload/keditor/22004821495693404.jpg\" alt=\"\" width=\"300\" height=\"172\" title=\"\" align=\"\" />\r\n</p>', '/data/upload/p_img/20170511/149447378817302333.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '表观遗传检测');
INSERT INTO `ko_product` VALUES ('20', '2', '生化检测', '通过全自动生化检测仪对肝功能、肾功能、心肌酶普、糖类、血脂、电解质进行检测', '<p>\r\n	<img src=\"/data/upload/keditor/67417071494483863.jpg\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	提交结果：为相关数据分析\r\n</p>', '/data/upload/p_img/20170511/149448387312936059.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '生化检测');
INSERT INTO `ko_product` VALUES ('21', '4', '同源性皮下移植肿瘤模型', '该平台具有种类齐全的各类动物模型，为各类疾病及药物筛选研究提供基础的保障。', '<p>\r\n	<img src=\"/data/upload/keditor/54495671494484055.png\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	同源性皮下移植肿瘤模型提交结果：\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	实验方法、荷瘤小鼠\r\n</p>', '/data/upload/p_img/20170511/149448421950467729.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '同源性皮下移植肿瘤模型');
INSERT INTO `ko_product` VALUES ('22', '4', '人肿瘤异种移植裸鼠模型', '该平台具有种类齐全的各类动物模型，为各类疾病及药物筛选研究提供基础的保障。', '<p>\r\n	<img src=\"/data/upload/keditor/39786001494484562.jpg\" alt=\"\" /> \r\n</p>', '1', '<p>\r\n	人肿瘤异种移植裸鼠模型提交结果：\r\n</p>\r\n<p>\r\n	实验方法、荷瘤小鼠\r\n</p>', '/data/upload/p_img/20170511/14944845732268235.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '人肿瘤异种移植裸鼠模型');
INSERT INTO `ko_product` VALUES ('23', '4', '肿瘤模型', '该平台具有种类齐全的各类动物模型，为各类疾病及药物筛选研究提供基础的保障。', '<p>\r\n	<img src=\"/data/upload/keditor/85741711494484748.jpg\" alt=\"\" /> \r\n</p>', '1', '<p>\r\n	肿瘤模型提交结果：\r\n</p>\r\n<p>\r\n	实验方法、裸鼠模型\r\n</p>', '/data/upload/p_img/20170511/149448475993981320.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '肿瘤模型');
INSERT INTO `ko_product` VALUES ('24', '4', '代谢疾病模型', '该平台具有种类齐全的各类动物模型，为各类疾病及药物筛选研究提供基础的保障。', '<p>\r\n	<img src=\"/data/upload/keditor/40367031494484925.jpg\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	代谢疾病模型提交结果：\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	实验报告\r\n</p>', '/data/upload/p_img/20170511/149448493758203181.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '代谢疾病模型');
INSERT INTO `ko_product` VALUES ('25', '4', '胃肠道疾病模型', '该平台具有种类齐全的各类动物模型，为各类疾病及药物筛选研究提供基础的保障。', '<p>\r\n	<img src=\"/data/upload/keditor/99354621494485069.jpg\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	胃肠道疾病模型提交结果：\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	实验报告\r\n</p>', '/data/upload/p_img/20170511/149448508040683545.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '胃肠道疾病模型');
INSERT INTO `ko_product` VALUES ('26', '4', '肝胆系统疾病模型', '该平台具有种类齐全的各类动物模型，为各类疾病及药物筛选研究提供基础的保障。', '<p>\r\n	<img src=\"/data/upload/keditor/3126191494485551.jpg\" alt=\"\" /> \r\n</p>', '1', '<p>\r\n	肝胆系统疾病模型提交结果：\r\n</p>\r\n<p>\r\n	实验报告\r\n</p>', '/data/upload/p_img/20170511/149448556311882896.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '肝胆系统疾病模型');
INSERT INTO `ko_product` VALUES ('27', '4', '心脑血管疾病模型', '该平台具有种类齐全的各类动物模型，为各类疾病及药物筛选研究提供基础的保障。', '<p>\r\n	<img src=\"/data/upload/keditor/78856131494485814.jpg\" alt=\"\" /> \r\n</p>', '1', '<p>\r\n	心脑血管疾病模型提交结果：\r\n</p>\r\n<p>\r\n	实验报告\r\n</p>', '/data/upload/p_img/20170511/149448582436639972.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '心脑血管疾病模型');
INSERT INTO `ko_product` VALUES ('28', '4', '呼吸系统疾病模型', '该平台具有种类齐全的各类动物模型，为各类疾病及药物筛选研究提供基础的保障。', '<p>\r\n	<img src=\"/data/upload/keditor/96150771494486160.jpg\" alt=\"\" /> \r\n</p>', '1', '<p>\r\n	呼吸系统疾病模型提交结果：\r\n</p>\r\n<p>\r\n	实验报告\r\n</p>', '/data/upload/p_img/20170511/149448617147373333.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '呼吸系统疾病模型');
INSERT INTO `ko_product` VALUES ('29', '4', '泌尿生殖系统疾病模型', '该平台具有种类齐全的各类动物模型，为各类疾病及药物筛选研究提供基础的保障。', '<p>\r\n	<img src=\"/data/upload/keditor/63655171494488088.png\" alt=\"\" /> \r\n</p>', '1', '<p>\r\n	泌尿生殖系统疾病模型提交结果：\r\n</p>\r\n<p>\r\n	实验报告\r\n</p>', '/data/upload/p_img/20170511/149448809950842496.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '泌尿生殖系统疾病模型');
INSERT INTO `ko_product` VALUES ('30', '4', '免疫炎症、抗感染模型', '该平台具有种类齐全的各类动物模型，为各类疾病及药物筛选研究提供基础的保障。', '<p>\r\n	<img src=\"/data/upload/keditor/38730041494488231.png\" alt=\"\" /> \r\n</p>', '1', '<p style=\"text-align:center;\">\r\n	免疫炎症、抗感染模型提交结果：\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	实验报告\r\n</p>', '/data/upload/p_img/20170511/149448824272246386.png', '实验操作人员经验丰富、技术熟练，从事生物行业多年。', '免疫炎症、抗感染模型');
INSERT INTO `ko_product` VALUES ('31', '5', '课题基金申请', '', '<p>\r\n<img src=\"/data/upload/keditor/77414851496309218.png\" alt=\"\" />\r\n</p>', '1', '', '/data/upload/p_img/20170601/149630932615300135.jpg', '', '');

-- ----------------------------
-- Table structure for ko_question
-- ----------------------------
DROP TABLE IF EXISTS `ko_question`;
CREATE TABLE `ko_question` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `question` text,
  `answer` text,
  `type_id` int(3) NOT NULL,
  `status` int(2) NOT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ko_question
-- ----------------------------
INSERT INTO `ko_question` VALUES ('1', '<span>贵公司采用什么方法进行菌种鉴定？</span>', '<span>传统的菌种鉴定主要依据形态特征和生理性状，需要进行分离培养及一系列生化反应或免疫学检测。方法复杂费时，对有些菌种也往往不能给出理想的鉴定结果。应用分子生物学方法从遗传进化角度阐明微生物种群之间的分类学关系是目前微生物分类学研究普遍采用的鉴定方法。我们的菌种鉴定服务采用Sanger测序的方法，比传统的生化鉴定更加的快速、准确。</span>', '11', '1', '1492567368');
INSERT INTO `ko_question` VALUES ('2', '<span>采用Sanger测序进行菌种鉴定的原理是什么？能鉴定到种吗？</span>', '<span>生物细胞DNA分子的一级结构中既具有保守的片段,又具有变化的碱基序列。保守的片段反映了生物物种间的亲缘关系，而高变片段则能表明物种间的差异。利用保守区设计引物扩增高变区进而进行比对分析，就能区分不同的物种信息。通过扩增测序的方法进行菌种鉴定，大多只能鉴定到属。如需鉴定至种，还要如DNA杂交，生理生化指标等的综合判断。</span>', '11', '0', '1495786592');
INSERT INTO `ko_question` VALUES ('3', '<span>为什么鉴定出来的菌种跟我想象的相差太大？</span>', '<div id=\"u2176\" class=\"text\" style=\"visibility:visible;\">\r\n	<p>\r\n		<span>菌种鉴定服务采用PCR扩增、测序的方法，即以客户提供的菌株为模板直接进行PCR扩增，中间不经过传代培养，因此不会引入新的污染，如果出现结果不一致的情况，一般有以下原因导致：</span>\r\n	</p>\r\n	<p>\r\n		<span>1）您提供的样品含有其他杂菌； </span>\r\n	</p>\r\n	<p>\r\n		<span>2）您提供样品的真实情况确认如此。</span>\r\n	</p>\r\n	<p>\r\n		<span>3）建议您提供三次纯化的菌株重新进行鉴定。</span>\r\n	</p>\r\n</div>', '9', '1', '1492567439');
INSERT INTO `ko_question` VALUES ('4', '<span>为什么会出现PCR扩增失败的现象？</span>', '<div id=\"u2182\" class=\"text\" style=\"visibility:visible;\">\r\n	<p>\r\n		<span>客户样品PCR扩增失败的可能原因有：</span>\r\n	</p>\r\n	<p>\r\n		<span>1）客户提供的菌种从严格意义上讲不是细菌或者真菌，或者客户提供信息有误；</span>\r\n	</p>\r\n	<p>\r\n		<span>2）客户提供的是革兰氏阳性菌，由于细胞壁较厚，采用常规方法不能有效地破壁；</span>\r\n	</p>\r\n	<p>\r\n		<span>3）培养基或菌体中含有抑制PCR的组分。</span>\r\n	</p>\r\n	<p>\r\n		<span>对于第二种和第三种，需要用基因组DNA。</span>\r\n	</p>\r\n</div>', '9', '1', '1492567471');
INSERT INTO `ko_question` VALUES ('5', '<p class=\"MsoNormal\">\r\n	<span style=\"font-family:华文中宋;\">用</span>Trypsin酶解蛋白质时，碳酸氢氨的浓度应该是多少？\r\n</p>', '<p class=\"MsoNormal\">\r\n	<span style=\"font-family:华文中宋;\">酶解时碳酸氢氨的浓度一般在</span> 10-50mM之间。碳酸氢氨的作用主要是提供一个碱性的水解环境，因为 Typsin 的活力在 pH8-9 之间最高。最常用的碳酸氢氨浓度有20 mM， 40 mM。盐浓度过大时，后续的冻干过程中会有较多的盐析出；盐浓度过小时，则不能有效的提供碱性pH的水解环境（尤其是在样品的 pH 值低，而且体积大时）。<o:p></o:p>\r\n</p>', '10', '1', '1495786290');
INSERT INTO `ko_question` VALUES ('6', '<p class=\"MsoNormal\">\r\n	怎样邮寄我的样品？\r\n</p>', '<p class=\"MsoNormal\">\r\n	<span style=\"font-family:华文中宋;\">冻干的胶或干粉可以直接邮寄。切胶后的湿胶（不用做任何处理），放在</span>EP管中 (不加任何缓冲液) ；用干冰速冻；邮寄时，置样品于足够的干冰中。液体样品的邮寄方式同湿胶一样。<o:p></o:p>\r\n</p>', '10', '1', '1495786314');
INSERT INTO `ko_question` VALUES ('7', '<p class=\"MsoNormal\">\r\n	为什么要使用内标？\r\n</p>', '<p class=\"MsoNormal\">\r\n	<span style=\"font-family:华文中宋;\">用内标做校准可以大大减少</span> MALDI-MS 的误差（&lt;70ppm），从而提高查库结果和可靠性。好的内标肽段需要有以下的要求：最好有两个肽（两点一线）；质量不要在大多数的肽段范围内（1200-2500 Da）；内标的量要与样品的量成比例；内标对其他肽段离子化的抑止要小。<o:p></o:p>\r\n</p>', '10', '1', '1495786334');
INSERT INTO `ko_question` VALUES ('8', '<p class=\"MsoNormal\">\r\n	<span style=\"font-family:华文中宋;\">我为什么还要提供正负空白胶正对照提供</span> (exact) 对照两块胶？\r\n</p>', '<p class=\"MsoNormal\">\r\n	<span style=\"font-family:华文中宋;\">正负对照的两块胶是用来对整个鉴定过程做质量控制的。负对照（空白胶）主要是看样品是否有污染（比如角蛋白的污染）；正对照（已知胶，比如同一块胶上的标准蛋白）主要是检测酶解和质谱的效果是否正常。如果客户不能提供正负对照，我们可以使用自己预先准备的胶条。如果顾客的样品量大（</span>&gt;10 个 2D 胶上的点），则顾客必须提供正负对照。<o:p></o:p>\r\n</p>', '10', '1', '1495786360');
INSERT INTO `ko_question` VALUES ('9', '<p class=\"MsoNormal\">\r\n	&nbsp;PCR扩增切胶纯化测序出现套峰，是什么原因？\r\n</p>', '<p class=\"MsoNormal\">\r\n	测序结果出现套峰的可能原因：\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	&nbsp;\r\n</p>\r\n<p class=\"15\" style=\"margin-left:18.0000pt;text-indent:-18.0000pt;\">\r\n	1）&nbsp;<span>测序结果个别碱基出现</span>N，或者部分连续出现套峰，是由菌种rDNA多态性造成，对菌种鉴定无影响。\r\n</p>\r\n<p class=\"15\" style=\"margin-left:18.0000pt;text-indent:-18.0000pt;\">\r\n	2）&nbsp;<span>所有测序反应均出现大面积套峰，由于客户提供样品模板不纯造成，这种情况需要客户重新纯化菌种或进行</span>TA克隆。\r\n</p>', '11', '1', '1495786435');
INSERT INTO `ko_question` VALUES ('10', '<p class=\"MsoNormal\">\r\n	什么是微卫星？\r\n</p>', '<p class=\"MsoNormal\">\r\n	<span style=\"font-family:华文中宋;\">微卫星也叫做短串联重复序列（</span>STRs）或简单重复序列（SSR），是指少数几个核苷酸（一般为1~6个）为重复单位组成的简单多次串联重复序列，其长度大多在100bp以内。微卫星标记由核心序列和两侧保守的侧翼序列构成。保守的侧翼序列使微卫星特异地定位于染色体某一区域。核心序列重复数的差异则形成微卫星的高度多态性。微卫星上不同长度的等位基因按简单的孟德尔方式遗传，在基因组中含量丰富且分布均等，因此是一种十分理想的分子标记。<o:p></o:p>\r\n</p>', '11', '1', '1495786472');
INSERT INTO `ko_question` VALUES ('11', '<p class=\"MsoNormal\">\r\n	微卫星标记的应用有哪些？<o:p></o:p>\r\n</p>', '<p class=\"MsoNormal\">\r\n	<span style=\"font-family:华文中宋;\">微卫星序列，也叫做短串联重复序列（</span>STRs），广泛存在于各类真核基因组中，它具有多态性丰富、重复性好、呈孟德尔共显性遗传，检测快速方便及结果稳定可靠等特点广泛应用于遗传图谱构建、数量性状位点（QTL）定位、标记辅助选择、遗传多样性评估、遗传检测等研究领域。<o:p></o:p>\r\n</p>', '11', '1', '1495786552');

-- ----------------------------
-- Table structure for ko_route
-- ----------------------------
DROP TABLE IF EXISTS `ko_route`;
CREATE TABLE `ko_route` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL COMMENT '名称注释',
  `route` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ko_route
-- ----------------------------
INSERT INTO `ko_route` VALUES ('1', '支付宝付款', 'a:3:{i:0;s:6:\"alipay\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:7:\"payment\";s:6:\"action\";s:6:\"alipay\";}i:2;a:1:{i:0;s:0:\"\";}}');
INSERT INTO `ko_route` VALUES ('2', '单页面地址', 'a:3:{i:0;s:17:\"single-(\\d+).html\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:5:\"index\";s:6:\"action\";s:6:\"single\";}i:2;a:1:{i:0;s:2:\"id\";}}');
INSERT INTO `ko_route` VALUES ('3', '实验平台详情', 'a:3:{i:0;s:17:\"detail-(\\d+).html\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:5:\"index\";s:6:\"action\";s:6:\"detail\";}i:2;a:1:{i:0;s:2:\"id\";}}');
INSERT INTO `ko_route` VALUES ('4', '行业资讯列表页（带分页）', 'a:3:{i:0;s:27:\"infomation-(\\d+)-(\\d+).html\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:5:\"index\";s:6:\"action\";s:10:\"infomation\";}i:2;a:2:{i:0;s:2:\"id\";i:1;s:1:\"p\";}}');
INSERT INTO `ko_route` VALUES ('5', '列表页', 'a:3:{i:0;s:20:\"list-(\\d+).html(.*?)\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:7:\"article\";s:6:\"action\";s:5:\"lists\";}i:2;a:1:{i:0;s:2:\"id\";}}');
INSERT INTO `ko_route` VALUES ('6', '搜索页（带分页）', 'a:3:{i:0;s:28:\"search-(\\d)-(\\d+)-(.*?).html\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:5:\"index\";s:6:\"action\";s:6:\"search\";}i:2;a:3:{i:0;s:11:\"search_type\";i:1;s:1:\"p\";i:2;s:9:\"key_words\";}}');
INSERT INTO `ko_route` VALUES ('7', '搜索页', 'a:3:{i:0;s:18:\"searchs-(.*?).html\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:7:\"article\";s:6:\"action\";s:6:\"search\";}i:2;a:1:{i:0;s:7:\"keyword\";}}');
INSERT INTO `ko_route` VALUES ('12', '实验平台列表页', 'a:3:{i:0;s:22:\"lists-(\\d+)-(\\d+).html\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:5:\"index\";s:6:\"action\";s:5:\"lists\";}i:2;a:2:{i:0;s:2:\"id\";i:1;s:1:\"p\";}}');
INSERT INTO `ko_route` VALUES ('13', '热 门 资 讯', 'a:3:{i:0;s:14:\"art-(\\d+).html\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:5:\"index\";s:6:\"action\";s:8:\"art_info\";}i:2;a:1:{i:0;s:2:\"id\";}}');
INSERT INTO `ko_route` VALUES ('14', '其他检测项目', 'a:3:{i:0;s:16:\"other-(\\d+).html\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:5:\"index\";s:6:\"action\";s:5:\"other\";}i:2;a:1:{i:0;s:3:\"kot\";}}');
INSERT INTO `ko_route` VALUES ('15', '辅助生殖生育', 'a:3:{i:0;s:17:\"others-(\\d+).html\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:5:\"other\";s:6:\"action\";s:5:\"index\";}i:2;a:1:{i:0;s:2:\"id\";}}');
INSERT INTO `ko_route` VALUES ('16', '公司简介', 'a:3:{i:0;s:16:\"about-(\\d+).html\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:5:\"index\";s:6:\"action\";s:5:\"about\";}i:2;a:1:{i:0;s:3:\"kot\";}}');
INSERT INTO `ko_route` VALUES ('17', '常见问题分类页', 'a:3:{i:0;s:25:\"question-(\\d+)-(\\d+).html\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:5:\"index\";s:6:\"action\";s:8:\"question\";}i:2;a:2:{i:0;s:2:\"id\";i:1;s:1:\"p\";}}');
INSERT INTO `ko_route` VALUES ('18', '肿瘤基因检测单页面', 'a:3:{i:0;s:18:\"product-(\\d+).html\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:7:\"product\";s:6:\"action\";s:5:\"index\";}i:2;a:1:{i:0;s:2:\"id\";}}');
INSERT INTO `ko_route` VALUES ('19', '肿瘤个体化用药', 'a:3:{i:0;s:16:\"pinfo-(\\d+).html\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:7:\"product\";s:6:\"action\";s:5:\"pinfo\";}i:2;a:1:{i:0;s:2:\"id\";}}');
INSERT INTO `ko_route` VALUES ('20', '常见问题', 'a:3:{i:0;s:19:\"question-(\\d+).html\";i:1;a:3:{s:6:\"module\";s:7:\"default\";s:10:\"controller\";s:5:\"index\";s:6:\"action\";s:8:\"question\";}i:2;a:1:{i:0;s:1:\"p\";}}');

-- ----------------------------
-- Table structure for ko_set_cat
-- ----------------------------
DROP TABLE IF EXISTS `ko_set_cat`;
CREATE TABLE `ko_set_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '设置分类名称',
  `sort` tinyint(3) NOT NULL DEFAULT '0' COMMENT '排序，从小到大',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ko_set_cat
-- ----------------------------
INSERT INTO `ko_set_cat` VALUES ('1', '基本设置', '1');
INSERT INTO `ko_set_cat` VALUES ('2', '其它设置', '10');
INSERT INTO `ko_set_cat` VALUES ('3', '第三方统计', '2');
INSERT INTO `ko_set_cat` VALUES ('4', '支付宝配置', '5');
