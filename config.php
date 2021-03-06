<?php

/**
* 声明一个常量，用于保存本程序主要目录
*/

define('ROOT',strtr(dirname(__FILE__),'\\','/'). './');
define('TEMPDIR',sys_get_temp_dir());
//设置时间区域 上海
date_default_timezone_set("Asia/Shanghai");


if (isset($_COOKIE['session'])) {
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
}


/**
* 加载自动加载程序
*/
include(ROOT . "include./atuoload.php");

/**
* 声明一个配置程序
*/

//全局过滤
//$_POST = sql_injection($_POST);
//$_GET = sql_injection($_GET);
$_REQUEST = sql_injection($_REQUEST);

function sql_injection($content)
{
	if (!get_magic_quotes_gpc()) {
		if (is_array($content)) {
			foreach ($content as $key=>$value) {
				$content[$key] = addslashes($value);
			}
		}
		else {
			addslashes($content);
		}
	}
	return $content;
}
Global $config;
$config['templet'] = 'default';
$config['server'] = '127.0.0.1';
$config['user'] = 'root';
$config['passwd'] = '';
$config['DBNAME'] = 'edu-default';
$config['PAGING'] = 10;
$config['DEFAULT-PASSWD'] = '123456';
$config['STATICCACHE'] = TRUE;

function C($name)
{
	Global $config;
	return $config[$name];
}

function G($name)
{
	//新闻列表
	if (ctype_digit($name)) {
		return db::creat()->loopessay($name,5,'=');
	}

	switch ($name) {
		case 'newlist':
		if (!isset($newlist)) {
			$newlist = db::creat()->loopessay(1,8,'>=');
		}
		return $newlist;
		case 'adminlist':
		//全局文章总行数
		Global $count;
		Global $adminlist;
		if (!isset($adminlist)) {
			$adminlist = db::creat()->loopessay(1,C('PAGING'),'>=',$count);
		}
		return $adminlist;
		case 'adminlistcount':
		Global $count;
		return $count;
		case 'pagelist':
		Global $pagelist;
		if (!isset($pagelist)) {
			$pagelist = db::creat()->loopessay();
		}
		return $pagelist;
		case 'newstype':
		Global $newstype;
		if (!isset($newstype)) {
			$newstype = db::creat()->loopclass();
		}
		return $newstype;
		case 'nav':
		Global $nav;
		if (!isset($nav)) {
			$nav = db::creat()->contentclass(1,'=');
		}
		return $nav;
		case 'getvip':
		Global $getvip;
		if (!isset($getvip)) {
			$getvip = db::creat()->getvipclass();
		}
		return $getvip;
		case 'navlist':
		Global $navlist;
		if (!isset($navlist)) {
			$navlist = db::creat()->loopnav(1,'=');
		}
		return $navlist;
		case 'adminnav':
		Global $adminnav;
		if (!isset($adminnav)) {
			$adminnav = db::creat()->loopnav();
		}
		return $adminnav;
		case 'admincontentclass':
		Global $admincontentclass;
		if (!isset($admincontentclass)) {
			$admincontentclass = db::creat()->contentclass();
		}
		return $admincontentclass;
		case 'adminvip':
		Global $vipcount;
		if (isset($_REQUEST['vippage'])) {
			$pagecount = (int)C('PAGING');
			$page = (int)$_REQUEST['vippage'] * $pagecount - $pagecount;
			$page = $page.','.$pagecount;
		}
		else {
			$page = (int)C('PAGING');
		}
		$adminvip = db::creat()->getvips(1,$vipcount,$page);
		return $adminvip;
		case 'vipcount':
		Global $vipcount;
		return $vipcount;
		default:
		break;
	}
	return array();
}

/**
* 以下为模板函数，用于处理模板内置函数
*/


function M( & $html_text)
{
	$off      = 0;
	$funcname = '';
	$code     = '';
	$func_in  = 0;
	$agm_in   = 0;
	while (TRUE) {
		$in = strpos($html_text,'@',$off);//寻找关键字并返回位置
		if ($in === FALSE) {
			break;
		}
		$funcname = $in;
		while (TRUE) {
			$off = ++$in;
			if (ctype_space($html_text[$in])) {
				break;
			}
			//判断函数括号位置
			if ($html_text[$in] == '(' ) {
				$agm_in   = $in + 1;
				$func_in  = $funcname;
				$funcname = substr($html_text,$funcname + 1,$in - $funcname - 1);
				continue;
			}
			else
			if ($html_text[$in] == ')') {
				//判断函数尾部括号
				$code    = substr($html_text,$func_in ,$in - $func_in + 1);
				$funcarg = substr($html_text,$agm_in,$in - $agm_in);
				//分割自定义参数
				$funcarg = explode(',',$funcarg);
				//载入模板函数对象
				//调用自定义函数变量,返回并替换函数
				$code    = (string)$code;
				//$funcname 自定义函数名
				$resou = templetfunction::creat()->$funcname($html_text,$code,$funcarg,$func_in,$in);
				if (is_string($resou) && is_string($code)) {
					$html_text = str_replace($code,$resou,$html_text);
				}
				break;
			}
		}
	}



}

?>