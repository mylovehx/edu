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
		}

	}
	public function getvippage( & $REQUEST, & $returntext , & $FILES)
	{
		if (isset($REQUEST['page'])) {
			$pagecount = (int)C('PAGING');
			$page = (int)$REQUEST['page'] * $pagecount - $pagecount;
			Global $vipcount;
			echo json_encode(db::creat()->getvips(1,$vipcount,$page.','.$pagecount,'>='));
		}
	}
	public function readtext( & $REQUEST, & $returntext , & $FILES)
	{
		if (isset($REQUEST['eduid'])) {
			$REQUEST['eduid'] = (int)$REQUEST['eduid'];
			echo json_encode(db::creat()->readtext($REQUEST['eduid']));
		}

	}
	public function deletetext( & $REQUEST, & $returntext , & $FILES)
	{
		if(isset($REQUEST['edu_id'])){
			$REQUEST['edu_id'] = (int)$REQUEST['edu_id'];
			if(db::creat()->delete_text($REQUEST['edu_id'])){
				echo('success:删除成功!');
			}else{
				echo('success:删除失败!');
			}
		}
	}
	public function upvip( & $REQUEST, & $returntext , & $FILES)
	{
		if (isset($REQUEST['edu_id']) && isset($REQUEST['edu_name']) && isset($REQUEST['edu_class_id']) && isset($REQUEST['edu_sign']) && isset($REQUEST['edu_login']) ) {
			//对输入文本做最高限制1000
			if ((int)$REQUEST['edu_id'] == 0) {
				if (ltrim($REQUEST['edu_user']) != '' && ltrim($REQUEST['edu_name']) != '') {
					$bool = count(db::creat()->getvip($REQUEST['edu_user']));
					if ($bool > 0) {
						echo('error:用户账号已注册!');
					}
					else {
						//默认密码
						if (db::creat()->newvip($REQUEST['edu_user'],hash('md5',C('DEFAULT-PASSWD')),$REQUEST['edu_name'],substr($REQUEST['edu_sign'],0,255),(int)$REQUEST['edu_login'],(int)$REQUEST['edu_class_id'])) {
							echo('success:新增成功!');
						}
						else {
							echo('error:新增失败!');
						}
					}

				}
				else {
					echo('error:用户账号和用户昵称不可为空!');
				}

				return;
			}
			else {
				if (db::creat()->upvipmessage((int)$REQUEST['edu_id'],substr($REQUEST['edu_name'],0,255),(int)$REQUEST['edu_class_id'],(int)$REQUEST['edu_login'],substr($REQUEST['edu_sign'],0,255))) {
					echo('success:修改成功!');
				}
				else {
					echo('error:修改失败!');
				}
				return;
			}

		}
		else {
			echo('error:参数不能为空!');
		}

	}
	public function writetext( & $REQUEST, & $returntext , & $FILES)
	{
		$bool = FALSE;
		if (!isset($REQUEST['edu_user_id'])) {
			$REQUEST['edu_user_id'] = 1;
		}
		$REQUEST['edu_type'] = 1;
		if (
			isset($REQUEST['edu_id']) &&
			isset($REQUEST['edu_essayclass_id']) &&
			isset($REQUEST['editorValue']) &&
			isset($REQUEST['edu_title']) &&
			isset($REQUEST['edu_user_id'])
		) {
			$REQUEST['edu_title'] = substr($REQUEST['edu_title'],0,255);
			$REQUEST['edu_essayclass_id'] = (int)$REQUEST['edu_essayclass_id'];
			$REQUEST['edu_user_id'] = (int)$REQUEST['edu_user_id'];
			if (isset($REQUEST['new'])) {
				$bool = db::creat()->newtext($REQUEST['edu_title'],$REQUEST['editorValue'],$REQUEST['edu_essayclass_id'],$REQUEST['edu_user_id'],$REQUEST['edu_type'] );
			}
			else {
				$bool = db::creat()->uptext($REQUEST['edu_id'],$REQUEST['edu_user_id'],$REQUEST['edu_title'],$REQUEST['editorValue'],$REQUEST['edu_essayclass_id'],$REQUEST['edu_type'] );
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