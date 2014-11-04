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
			$REQUEST['title'] = substr(ltrim($REQUEST['title']),0,255);
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
			$REQUEST['logotitle'] = substr(ltrim($REQUEST['logotitle']),0,255);
			$bool = db::creat()->uplabel('EDU-HOMETITLE',$REQUEST['logotitle']);
		}

		if (isset($REQUEST['logotext']) && strlen($REQUEST['logotext']) > 0) {
			$REQUEST['logotext'] = substr(ltrim($REQUEST['logotext']),0,500);
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
				echo('error:格式错误!');
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
			if (db::creat()->upnav((int)$REQUEST['edu_id'],substr($REQUEST['edu_name'],0,255),(int)$REQUEST['edu_order'],(int)$REQUEST['edu_show'],substr($REQUEST['edu_link'],0,255))) {
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
			//对输入文本做最高限制1000
			if (db::creat()->upcontentclass((int)$REQUEST['edu_id'],substr($REQUEST['edu_name'],0,255),(int)$REQUEST['edu_order'],(int)$REQUEST['edu_show'],substr($REQUEST['edu_summary'],0,255))) {
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

	public function getpage( & $REQUEST, & $returntext , & $FILES)
	{
		if (isset($REQUEST['page'])) {
			$pagecount = (int)C('PAGING');
			$page = (int)$REQUEST['page'] * $pagecount - $pagecount;
			Global $count;
			echo json_encode(db::creat()->loopessay(1,$page.','.$pagecount,'>=',$count));
			/*
			$text= '';
			foreach ($arr as $key=>$val) {
				$text .= '<a href="javascript:read('.$val['edu_id'].');" class="list-group-item textclick">'.$val['edu_title'].'</a>';
			}
			echo($text);
			*/
		}

	}
	public function readtext( & $REQUEST, & $returntext , & $FILES)
	{
		if (isset($REQUEST['eduid'])) {
			echo json_encode(db::creat()->readtext((int)$REQUEST['eduid']));
		}

	}

	public function writetext( & $REQUEST, & $returntext , & $FILES)
	{
		if (!isset($REQUEST['edu_user_id'])) {
			$REQUEST['edu_user_id'] = 1;
		}
		if (
			isset($REQUEST['edu_id']) &&
			isset($REQUEST['edu_essayclass_id']) &&
			isset($REQUEST['editorValue']) &&
			isset($REQUEST['edu_title']) &&
			isset($REQUEST['edu_user_id'])
		) {
			if (isset($REQUEST['new'])) {

			}
			else {
				$bool = db::creat()->uptext((int)$REQUEST['edu_id'],(int)$REQUEST['edu_user_id'],substr($REQUEST['edu_title'],0,255),$REQUEST['editorValue'],(int)$REQUEST['edu_essayclass_id'],1);
			}
		}
		if ($bool == TRUE) {
			echo('success:修改成功!');
		}
		else {
			echo('error:错误!');
		}

	}

}

?>