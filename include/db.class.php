<?php

class db
{

	// 保存类实例在此属性中
	private static $instance;
	private static $dbh;
	// 构造方法声明为private，防止直接创建对象
	private function __construct()
	{

		if (!isset($DBtype)) {
			$DBtype = 'mysql';
		}
		try {
			self::$dbh = mysqli_connect(C('server'),C('user'),C('passwd'));

			if (!mysqli_select_db(self::$dbh,C('DBNAME'))) {
				echo 'select DB connect error';
			}
			mysqli_query(self::$dbh,'SET CHARACTER SET utf8');
		} catch ( PDOException $e ) {
			echo  'Connection failed: '  .  $e -> getMessage ();
			die;
		}

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

	public function query( & $sql)
	{
		mysqli_query(self::$dbh,'SET CHARACTER SET utf8');
		return mysqli_query(self::$dbh,$sql);
	}
	//通用数据库查询函数
	public function Q( & $teble, & $field = array(), & $values = array() , & $top = 5, $orde = '', & $tab = ' AND ')
	{
		$arr = array();
		$field    = implode(',',$field);
		$values   = implode($tab,$values);
		$sql      = "Select  $field FROM $teble WHERE $values  $orde  LIMIT $top ";
		$resource = self::query($sql);
		if ($resource === FALSE) {
			return array();
		}
		while ($row = mysqli_fetch_array($resource,MYSQL_ASSOC)) {
			$arr[] = $row;
		}

		return $arr;
	}

	//通用修改数据库函数
	public function U( & $teble, & $field = array(), & $values = array()  , & $tab = ' AND ')
	{
		$arr = array();
		$field    = implode(',',$field);
		$values   = implode($tab,$values);
		$sql      = "UPDATE $teble SET $field  WHERE $values ";
		$resource = self::query($sql);
		return $resource;
	}

	//以下数据库函数为自定义函数库

	//取文章最新前N条
	public function loopessay($edu_essayclass_id = 1,$top = 5,$symbol = '=')
	{
		$sql   = 'edu_essay';
		$field = array('edu_id','edu_title','DATE(edu_time) as edu_time');
		$values = array("edu_essayclass_id $symbol '$edu_essayclass_id'");
		return self::Q($sql,$field,$values,$top,' ORDER BY edu_id DESC ');
	}
	//取分类列表
	public function loopclass($edu_show = 1,$symbol = '=')
	{
		$sql   = 'edu_essayclass';
		$field = array('edu_id','edu_name');
		$values = array("edu_show $symbol '$edu_show'");
		$top = 999;
		return self::Q($sql,$field,$values,$top,' ORDER BY edu_order ASC ');
	}
	//取导航列表
	public function loopnav($edu_show = 0,$symbol = '>=')
	{
		$sql   = 'edu_nav';
		$field = array('edu_id','edu_name','edu_link','edu_order','IF(edu_show>0,"checked=\"checked\"","") as edu_show_html ','edu_show');
		$values = array("edu_show $symbol '$edu_show'");
		$top = 999;
		return self::Q($sql,$field,$values,$top,' ORDER BY edu_order ASC ');
	}
	//取分类列表
	public function contentclass($edu_show = 0,$symbol = '>=')
	{
		$sql   = 'edu_essayclass';
		$field = array('edu_id','edu_name','edu_summary','edu_order','IF(edu_show>0,"checked=\"checked\"","") as edu_show_html ','edu_show');
		$values = array("edu_show $symbol '$edu_show'");
		$top = 999;
		return self::Q($sql,$field,$values,$top,' ORDER BY edu_order ASC ');
	}
	public function label($edu_name)
	{
		$sql   = 'edu_label';
		$field = array('edu_id','edu_values');
		$values = array("edu_name = '$edu_name'");
		$top = 1;
		return self::Q($sql,$field,$values,$top);
	}

	public function uplabel($edu_name,$edu_values)
	{
		$sql   = 'edu_label';
		$field = array("edu_values='$edu_values'");
		$values = array("edu_name = '$edu_name'");
		return self::U($sql,$field,$values);
	}


	public function upnav($edu_id,$edu_name,$edu_order,$edu_show,$edu_link)
	{
		$sql   = 'edu_nav';
		$field = array("edu_name='$edu_name'","edu_order='$edu_order'","edu_show='$edu_show'","edu_link='$edu_link'",);
		$values = array("edu_id = '$edu_id'");
		return self::U($sql,$field,$values);
	}
	public function upcontentclass($edu_id,$edu_name,$edu_order,$edu_show,$edu_summary)
	{
		$sql   = 'edu_essayclass';
		$field = array("edu_name='$edu_name'","edu_order='$edu_order'","edu_show='$edu_show'","edu_summary='$edu_summary'",);
		$values = array("edu_id = '$edu_id'");
		return self::U($sql,$field,$values);
	}
}


?>