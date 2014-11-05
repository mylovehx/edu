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
		$temp        = TEMPDIR.'./edu_'.hash('md5',$file).'.tmp';
		$STATICCACHE = C('STATICCACHE');
		if ($STATICCACHE && is_file($temp) && $_SERVER['REQUEST_TIME'] - filectime($temp) < 180) {
			return file_get_contents($temp);
		}
		$string = file_get_contents($file);
		$string = strtr($string,array("\r\n"=>'',"\n"  =>'',"\r"  =>'',"\t"  =>''));
		$string = strtr($string,array('  '=>''));
		$string = strtr($string,array('  '=>''));
		$string = strtr($string,array('  '=>''));
		if ($STATICCACHE) {
			file_put_contents($temp,$string);
		}
		return $string;
	}


	public static function path($path)
	{
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			return str_replace('/','\\',$path);
		}
		else {
			return str_replace('\\','/',$path);
		}
	}
	public static function dirpath($path)
	{
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			return substr(strrchr(dirname($path), "\\"), 1);
		}
		else {
			return substr(strrchr(dirname($path), "/"), 1);
		}
	}
}




?>