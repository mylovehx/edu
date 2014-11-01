<?php

class systems
{
	/**
	* 压缩html : 清除换行符,清除制表符,去掉注释标记
	* @param undefined $string
	*
	* @return
	*/
	public static function compress_html( & $file)
	{
		$temp = TEMPDIR.'./'.hash('md5',$file);
		if (is_file($temp)) {
			return file_get_contents($temp);
		}
		$string = file_get_contents($file);
		$string = strtr($string,array("\r\n"=>'',"\n"  =>'',"\r"  =>'',"\t"  =>''));
		$string = strtr($string,array('  '=>''));
		$string = strtr($string,array('  '=>''));
		$string = strtr($string,array('  '=>''));
		file_put_contents($temp,$string);
		return $string;
	}
}




?>