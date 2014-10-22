<?php

class systems
{
    /**
    * 压缩html : 清除换行符,清除制表符,去掉注释标记
    * @param undefined $string
    *
    * @return
    */
    public static function compress_html( & $string)
    {
    	$string = strtr($string,array("  "=>'',"\r\n"=>'',"\n"=>'',"\r"=>'',"\t"=>''));
    }
}




?>