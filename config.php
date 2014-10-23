<?php

/**
* 声明一个常量，用于保存本程序主要目录
*/

define('ROOT',strtr(dirname(__FILE__),'\\','/'). './');

/**
* 加载自动加载程序
*/
include(ROOT . "include./atuoload.php");

/**
* 声明一个配置程序 
*/


function C($name)
{
    $config['templet'] = 'default';
    $config['server'] = '127.0.0.1';
    $config['user'] = 'root';
    $config['passwd'] = 'root';
    $config['DBNAME'] = 'edu_Default';
    
    return $config[$name];
}

function G($name)
{
    if ($name == 'newslist') {
        $arr = array();
        $arr[] = array('tag' =>'5','name'=>'我校已经成为世界第一名校。1 ');
        $arr[] = array('tag' =>'4','name'=>'我校已经成为世界第一名校。2 ');
        $arr[] = array('tag' =>'3','name'=>'我校已经成为世界第一名校。3 ');
        $arr[] = array('tag' =>'2','name'=>'我校已经成为世界第一名校。4 ');
        $arr[] = array('tag' =>'1','name'=>'我校已经成为世界第一名校。5 ');

        return $arr;
    }
    if ($name == 'pagelist') {
    	$sql = 'sql';
        $arr = array(db::creat()->query($sql),'a2','a3','a5');
        return $arr;
    }
    if ($name == 'newstype') {
        $arr = array();
        $arr[] = array('name'=>'校园新闻');
        $arr[] = array('name'=>'网上办事');
        $arr[] = array('name'=>'政务公开');
        return $arr;
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
    $tmp      = new templetfunction;
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
            }else
            if ($html_text[$in] == ')') { //判断函数尾部括号
                $code      = substr($html_text,$func_in ,$in - $func_in + 1);
                $funcarg   = substr($html_text,$agm_in,$in - $agm_in);
                //分割自定义参数
                $funcarg   = explode(',',$funcarg);
                //载入模板函数对象
                //调用自定义函数变量,返回并替换函数
                $html_text = str_replace($code,$tmp->$funcname($html_text,$code,$funcarg,$func_in,$in),$html_text);
                break;
            }
        }
    }



}

?>