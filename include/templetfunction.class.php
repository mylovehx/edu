<?php

class templetfunction
{
	// 保存类实例在此属性中
	private static $instance;
	// 构造方法声明为private，防止直接创建对象
	private function __construct()
	{
	}
	// singleton 方法
	public static function creat()
	{
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c();
		}
		return self::$instance;
	}

	// 阻止用户复制对象实例
	public function __clone()
	{
		trigger_error('Clone is not allowed.', E_USER_ERROR);
	}


	public function __call($name, $arguments)
	{
		//var_dump($arguments);
		return '';
	}
	/**
	* 自定义函数，载入HTML文件
	* 自定义参数
	* @param undefined $arguments
	* 返回处理好的替换文本
	* @return
	*/
	public function load( & $htmltext, & $code , & $arguments, & $func_in, & $func_ot)
	{

		if (count($arguments) > 0) {
			$filedir = C('templet');
			$file    = realpath(ROOT . 'templet./' . $filedir .'./'. $arguments[0]);
			if (!is_file($file)) {
				$filedir = 'default';
				$file    = realpath(ROOT . 'templet./default./' . $arguments[0]);
			}

			//取文件扩展名
			$ex      = pathinfo($file, PATHINFO_EXTENSION);
			$dirname = systems::dirpath($file);
			switch ($ex) {
				case 'js':
				return '<script src="./templet/'.$filedir.'/'.$dirname.'/'.basename($file).'" ></script>';
				case 'css':
				return '<link rel="stylesheet" type="text/css" href="./templet/'.$filedir.'/'.$dirname.'/'.basename($file).'">';
				case 'jpg':
				case 'jpeg':
				case 'png':
				case 'bmp':
				case 'gif':
				case 'svg':
				return './templet/'.$filedir.'/'.$dirname.'/'.basename($file);
				default:
				//读取外部模板文件压缩外部文件大小
				return systems::compress_html($file);
			}
		}
		return '';
	}
	public function css( & $htmltext, & $code , & $arguments, & $func_in, & $func_ot)
	{
		if (count($arguments) > 0) {
			$filedir = C('templet');
			$file    = realpath(ROOT . 'templet./' .$filedir.'./'. $arguments[0]);
			if (!is_file($file)) {
				$file    = ROOT . 'templet./default./' . $arguments[0];
				$filedir = 'default';
			}
			//取文件扩展名
			$ex      = pathinfo($file, PATHINFO_EXTENSION);
			$dirname = systems::dirpath($file);
			switch ($ex) {
				case 'css':{
					//清除原代码
					$htmltext = str_replace('</head>',$code.'</head>',str_replace($code,'',$htmltext));
					return '<link  rel="stylesheet" type="text/css" href="./templet/'.$filedir.'/'.$dirname.'/'.basename($file).'">';
				}
				case 'js':{
					//清除原代码
					$htmltext = str_replace('</head>',$code.'</head>',str_replace($code,'',$htmltext));
					return '<script  src="./templet/'.$filedir.'/'.$dirname.'/'.basename($file).'" ></script>';
				}
				default:
				break;
			}

		}
		return '';
	}



	public function loop( & $htmltext, & $code , & $arguments, & $func_in, & $func_ot)
	{
		self::select($htmltext,  $code ,  $arguments,  $func_in,  $func_ot,$modeltext);
		//重复函数体模板
		if (!isset($arguments[0])) {
			$arguments[0] = 0;
		}
		return str_repeat($modeltext,$arguments[0]);

	}
	public function traversal( & $htmltext, & $ucode , & $arguments, & $func_in, & $func_ot)
	{
		self::select($htmltext, $ucode , $arguments,  $func_in,  $func_ot,$modeltext);
		$temp   = '';
		//替换循环变量$$
		$arglen = count($arguments);
		for ($ii = 0; $ii < $arglen; $ii++) {
			$code = G($arguments[$ii]);
			if (is_numeric($code)) {
				$paging = C('PAGING');
				$pagingS= $code / $paging;
				if ($code > $pagingS * $paging) {
					++$pagingS;
				}
				for ($ss = 0; $ss < $pagingS; $ss++) {
					$temp .= str_replace('$#',$ss + 1,$modeltext);
				}
				return $temp;
			}
			$lent = count($code);
			if (isset($code['count'])) {
				--$lent;
			}
			if ($ii == 0) {
				//初始化替换模板。
				for ($ss = 0; $ss < $lent; $ss++) {
					$temp .= str_replace('$#',$ss + 1,$modeltext);
				}
			}
			for ($ll = 0; $ll < $lent; $ll++) {
				if (is_array($code[$ll])) {
					$keynames    = array_keys($code[$ll]);
					$keynameslen = count($keynames);
					if ($ll == 0) {
						$onelen = $lent;
					}
					for ($ol = 0; $ol < $keynameslen; $ol++) {
						$item    = '$'.$arguments[$ii] . '.' .$keynames[$ol];
						$keyname = $keynames[$ol];
						$keyname = $code[$ll][$keyname];
						$pos     = strpos($temp,$item);
						if ($pos !== FALSE) {
							$temp = substr_replace($temp,$keyname,$pos,strlen($item));
							if ($ol == $keynameslen - 1 && $keynameslen == $onelen && isset($code[$ll + 1])) {
								$keyname = $keynames[$ol];
								$keyname = $code[$ll + 1][$keyname];
								$temp    = str_replace($item,$keyname,$temp);
							}
						}
					}
				}

			}
		}
		return $temp;
	}
	public function loops( & $htmltext, & $code , & $arguments, & $func_in, & $func_ot)
	{
		$text   = '';
		self::select($htmltext,  $code ,  $arguments,  $func_in,  $func_ot,$modeltext);
		//初始化替换模板。
		$arg    = G($arguments[0]);
		$arglen = count($arg);
		$temp   = '';
		//替换循环变量$#
		for ($ss = 0; $ss < $arglen; $ss++) {
			$temp      = str_replace('$#',$ss + 1,$modeltext);
			$ages      = $arg[$ss];
			$agesnames = array_keys($arg[$ss]);
			$ageslen   = count($ages);
			for ($ll = 0; $ll < $ageslen; $ll++) {
				$temp = str_replace( '$'.$arguments[0].'.'.$agesnames[$ll],$ages[$agesnames[$ll]],$temp);
			}
			$text .= $temp;
		}
		return $text;
	}

	function select( & $htmltext, & $code , & $arguments, & $func_in, & $func_ot, & $modeltext)
	{
		$strlen    = strlen($htmltext);
		$loop_in   = 0;
		$modeltext = '';
		$model     = '';
		$in_count  = 0;

		for ($in = $func_ot; $in < $strlen; ++$in) {
			if ($in < 3) {
				break;
			}
			//循环第一层判断函数体开头
			if ($loop_in == 0 && $htmltext[$in] == '{' && $htmltext[$in - 1] != '\\') {
				$loop_in = $in + 1;
			}
			else
			if ($htmltext[$in] == '{' && $htmltext[$in - 1] == '\\') {
				$htmltext[$in - 1] = '  ';
			}
			if ($loop_in > 0 && $htmltext[$in] == '{' && $htmltext[$in - 1] != '\\') {
				++$in_count;
			}
			if ($loop_in > 0 && $htmltext[$in] == '}' && $htmltext[$in - 1] != '\\') {
				--$in_count;
			}
			//循环判断函数体结尾
			if ($loop_in > 0 && $htmltext[$in] == '}' && $htmltext[$in - 1] != '\\' && $in_count == 0) {
				$modeltext = substr($htmltext,$loop_in  ,$in - $loop_in );
				$model     = '{'.$modeltext.'}' ;
				break;
			}
			else
			if ($htmltext[$in] == '}' && $htmltext[$in - 1] == '\\') {
				$htmltext[$in - 1] = '  ';
			}

		}
		
		//删除模板部分
		$htmltext = str_replace($model,'',$htmltext);
	}

	public function label( & $htmltext, & $code , & $arguments, & $func_in, & $func_ot)
	{
		if (isset($arguments[0])) {
			$arr = db::creat()->label($arguments[0]);
			return $arr[0]['edu_values'];
		}
		return '';
	}

}
?>