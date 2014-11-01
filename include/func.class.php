<?php

class func
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
		return '';
	}

	/**
	* 以下为自定义函数，用于模板调用
	*/

	public function login( & $REQUEST, & $returntext)
	{
		//$REQUEST['method'] = '0000';
		// var_dump($REQUEST['searchtxt']);
		if (function_exists('curl_init')) {
			$curl = curl_init($REQUEST['searchtxt']);
			//curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
			//var_dump(curl_exec($curl));
			curl_exec($curl);
			curl_close($curl);
		}
	}

	public function upwebname( & $REQUEST, & $returntext)
	{
		$REQUEST['title'] = ltrim($REQUEST['title']);
		if (isset($REQUEST['title']) && strlen($REQUEST['title']) > 0) {
			$a = db::creat()->uplabel('EDU-WEBNAME',$REQUEST['title']);
			echo('success:修改成功!');
		}
		else {
			echo('error:错误!');
		}
	}
	public function uplogo( & $REQUEST, & $returntext , & $FILES)
	{
		$bool = FALSE;
		if (isset($REQUEST['logotitle']) && strlen($REQUEST['logotitle']) > 0) {
			$REQUEST['logotitle'] = ltrim($REQUEST['logotitle']);
			$bool = db::creat()->uplabel('EDU-HOMETITLE',$REQUEST['logotitle']);
		}

		if (isset($REQUEST['logotext']) && strlen($REQUEST['logotext']) > 0) {
			$REQUEST['logotext'] = ltrim($REQUEST['logotext']);
			$bool = db::creat()->uplabel('EDU-HOMETEXT',$REQUEST['logotext']);
		}

		if ($bool == TRUE) {
			echo('success:修改成功!');
		}
		else {
			echo('error:错误!');
		}

	}
	public function uplogofile( & $REQUEST, & $returntext , & $FILES)
	{
		//var_dump($FILES['myfile']['type']);
		if (isset($FILES['myfile']['tmp_name'])) {
			if (strpos($FILES['myfile']['type'],'image') === FALSE) {
				return FALSE;
			}
			$filename = '';
			if (!isset($REQUEST['filename'])) {
				$filename = 'first_bg.jpg';
			}
			else {
				$filename = $REQUEST['filename'];
			}
			if (move_uploaded_file($FILES['myfile']['tmp_name'],ROOT .'templet./'. C('templet').'./img./'.$filename)) {
				echo('success:修改成功!');
				return;
			}
		}
		echo('error:错误!');
	}

	public function upnavigate( & $REQUEST, & $returntext , & $FILES)
	{
		if (isset($REQUEST['edu_id']) && isset($REQUEST['edu_name']) && isset($REQUEST['edu_order']) && isset($REQUEST['edu_link']) && isset($REQUEST['edu_show']) ) {
			if (db::creat()->upnav($REQUEST['edu_id'],$REQUEST['edu_name'],$REQUEST['edu_order'],$REQUEST['edu_show'],$REQUEST['edu_link'])) {
				echo('success:修改成功!');
			}
			else {
				echo('error:修改失败!');
			}
		}
		else {
			echo('error:参数不能为空!');
		}
	}
	public function upcontentclass( & $REQUEST, & $returntext , & $FILES)
	{
		if (isset($REQUEST['edu_id']) && isset($REQUEST['edu_name']) && isset($REQUEST['edu_order']) && isset($REQUEST['edu_summary']) && isset($REQUEST['edu_show']) ) {
			if (db::creat()->upcontentclass($REQUEST['edu_id'],$REQUEST['edu_name'],$REQUEST['edu_order'],$REQUEST['edu_show'],$REQUEST['edu_summary'])) {
				echo('success:修改成功!');
			}
			else {
				echo('error:修改失败!');
			}
		}
		else {
			echo('error:参数不能为空!');
		}
	}


}

?>