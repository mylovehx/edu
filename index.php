<?php
//error_reporting(0);
include("config.php");

/**
*
* URL路由器
*
*/

/**
*
* @var 如果没有设置类型则直接默认
*
*/

if(count($_REQUEST) >= 1){
    if($_REQUEST[key($_REQUEST)] == ''){
        $parameter = explode('/',ltrim(key($_REQUEST),'/'));
        if(count($parameter) >= 2){
            if(count($parameter) >= 1){
                if($parameter[0] != ''){
                    $_REQUEST['model'] = $parameter[0];
                }
            }
            if(count($parameter) >= 2){
                if($parameter[1] != ''){
                    $_REQUEST['page'] = $parameter[1];
                }
            }
        }
    }


}


//gzip压缩程序
function ob_gzip($content) // $content 就是要压缩的页面内容，或者说饼干原料
{
    if( !headers_sent() && // 如果页面头部信息还没有输出
        extension_loaded("zlib") && // 而且zlib扩展已经加载到PHP中
        strpos($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip") !== FALSE)//而且浏览器说它可以接受GZIP的页面
    {
        $content = gzencode($content,9);//此页已压缩”的注释标签，然后用zlib提供的gzencode()函数执行级别为9的压缩，这个参数值范围是0 - 9，0表示 无压缩，9表示最大压缩，当然压缩程度越高越费CPU。

        //然后用header()函数给浏览器发送一些头部信息，告诉浏览器这个页面已经用GZIP压缩过了！
        header("Content-Encoding: gzip");
        header("Vary: Accept-Encoding");
        header("Content-Length: ".strlen($content));
        header("content-Type: text/html; charset=utf-8");
    }else
    if( !headers_sent() && // 如果页面头部信息还没有输出
        extension_loaded("zlib") && // 而且zlib扩展已经加载到PHP中
        strpos($_SERVER["HTTP_ACCEPT_ENCODING"],"deflate") !== FALSE)//而且浏览器说它可以接受GZIP的页面
    {
        $content = gzcompress($content,9);//此页已压缩”的注释标签，然后用zlib提供的gzencode()函数执行级别为9的压缩，这个参数值范围是0 - 9，0表示 无压缩，9表示最大压缩，当然压缩程度越高越费CPU。

        //然后用header()函数给浏览器发送一些头部信息，告诉浏览器这个页面已经用GZIP压缩过了！
        header("Content-Encoding: deflate");
        header("Vary: Accept-Encoding");
        header("Content-Length: ".strlen($content));
        header("content-Type: text/html; charset=utf-8");
    }
    return $content; //返回压缩的内容，或者说把压缩好的饼干送回工作台。
}


if(!isset($_REQUEST['type'])){
    $_REQUEST['type'] = 0;
}

/**
*
* 判断访问类型是否定义 否则默认
* 0 访问 1 提交POST
*/


if(($_REQUEST['type'] == '0' || $_REQUEST['type'] == '')){
    if(!isset($_REQUEST['model'])){
        $_REQUEST['model'] = 'index';
    }
    /**
    *
    * 判断页面参数是否定义，否则默认
    *
    */
    if(!isset($_REQUEST['page'])){
        $_REQUEST['page'] = 'index';
    }
    /**
    *
    * 加载模板文件
    *
    */

    //判断页面参数是否有扩展名
    if(strpos($_REQUEST['page'],'.') === FALSE && strpos($_REQUEST['page'],'_') === FALSE){
        $_REQUEST['page'] = $_REQUEST['page'].'.html';
    }else{
        //将系统默认的_替换成.
        $_REQUEST['page'] = str_replace('_','.',$_REQUEST['page']);
    }

    $file = ROOT . 'templet./'.C('templet').'./'.$_REQUEST['model'].'/'.$_REQUEST['page'];

    while(true){
        //判断访问的文件是否存在
        if(!is_file($file)){
            $file = ROOT . 'templet./default/'.$_REQUEST['model'].'/'.$_REQUEST['page'];
        }else{
            break;
        }
        if(!is_file($file)){
            $file = ROOT . 'templet./'.C('templet').'./404.html';
        }else{
            break;
        }
        if(!is_file($file)){
            $file = ROOT . 'templet./default./404.html';
        }else{
            break;
        }
        if(!is_file($file)){
            //判断是否有404页面
            $file = ROOT . 'templet./default./index./index.html';
            break;
        }else{
            break;
        }
    }
    //读入主要模块模块
    $html_text = file_get_contents($file);
    //压缩HTML
    systems::compress_html($html_text);
    M($html_text);//处理代码
    if(extension_loaded('zlib')){
        ob_start('ob_gzip');
    }
    echo($html_text);
    if(extension_loaded('zlib')){
        ob_end_flush();
    }

}else{
    /**
    *
    * @var 判断是否要调用函数
    *
    */
    if(isset($_REQUEST['method'])){
        //动态调用 func ，将参数传递引用过去
        if(method_exists(func::creat(),$_REQUEST['method'])){
            if(extension_loaded('zlib')){
                ob_start('ob_gzip');
            }
            $returntext = '';
            func::creat()->$_REQUEST['method']($_REQUEST,$returntext);
            if(extension_loaded('zlib')){
                ob_end_flush();
            }
        }else{
            echo('Can\'t find the method!');
        }
    }else{
        echo('Can\'t find the methods!');
    }
}



//echo ROOT . 'default / '.$_REQUEST['model'].'.html';





?>