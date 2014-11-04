<?php

class db
{

	// 保存类实例在此属性中
	private static $instance;
	//数据库对象
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
			//mysqli_query(self::$dbh,'SET CHARACTER SET utf8');
			mysqli_query(self::$dbh,"SET NAMES 'utf8'");
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
		//mysqli_query(self::$dbh,'SET CHARACTER SET utf8');
		return mysqli_query(self::$dbh,$sql);
	}
	//通用数据库查询函数
	public function Q( & $teble, & $field = array(), & $values = array() , & $top = 5, $orde = '',&$count = 0, & $tab = ' AND ' )
	{
		$arr = array();
		$field    = implode(',',$field);
		$values   = implode($tab,$values);
		//SQL_CALC_FOUND_ROWS 不受 limit 影响 可以取得所有行的数量
		$sql      = "Select SQL_CALC_FOUND_ROWS $field FROM $teble WHERE $values  $orde  LIMIT $top ";
		$resource = self::query($sql);
		//取回SQL_CALC_FOUND_ROWS 上一条语句不受limit影响的总行数
		$sql ='SELECT FOUND_ROWS() AS count';
		$row = mysqli_fetch_array(self::query($sql),MYSQL_ASSOC);
		$count = (int)$row['count'];
		//判断查询是否成功
		if ($resource === FALSE) {
			return array();
		}
		//遍历所有行
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

	public function readtext($edu_id)
	{
		$teble   = 'edu_essay AS ey LEFT JOIN edu_essayclass AS es ON es.edu_id = ey.edu_essayclass_id ';
		$field = array('ey.edu_id as edu_id','ey.edu_title as edu_title','DATE(ey.edu_time) as edu_time','ey.edu_user_id as edu_user_id','ey.edu_text as edu_text','ey.edu_count as edu_count','ey.edu_essayclass_id as edu_essayclass_id','es.edu_name as edu_name ');
		$values = array("ey.edu_id='$edu_id'");
		$top = 1;
		return self::Q($teble,$field,$values,$top,' ORDER BY ey.edu_id DESC ',$count);	
	}

	public function uptext($edu_id,$edu_user_id,$edu_title,$edu_text,$edu_essayclass_id,$edu_type)
	{
		$time = date("Y-m-d H:i:s");
		$teble   = 'edu_essay';
		$field = array("edu_user_id='$edu_user_id'","edu_title='$edu_title'","edu_text='$edu_text'","edu_essayclass_id='$edu_essayclass_id'","edu_type='$edu_type'","edu_uptime='$time'");
		$values = array("edu_id = '$edu_id'");
		return self::U($teble,$field,$values);
	}
	//取文章最新前N条
	public function loopessay($edu_essayclass_id = 1,$top = 5,$symbol = '=',&$count = 0)
	{
		$teble   = 'edu_essay AS ey LEFT JOIN edu_essayclass AS es ON es.edu_id = ey.edu_essayclass_id ';
		$field = array('ey.edu_id as edu_id','ey.edu_title as edu_title','DATE(ey.edu_time) as edu_time','es.edu_name as edu_name');
		$values = array("ey.edu_essayclass_id $symbol '$edu_essayclass_id'");
		return self::Q($teble,$field,$values,$top,' ORDER BY ey.edu_id DESC ',$count);
	}
	//取分类列表
	public function loopclass($edu_show = 1,$symbol = '=')
	{
		$sql   = 'edu_essayclass';
		$field = array('edu_id','edu_name');
		$values = array("edu_show $symbol '$edu_show'");
		$top = 999;
		return self::Q($sql,$field,$values,$top,' ORDER BY edu_order ASC ',$count);
	}
	//取导航列表
	public function loopnav($edu_show = 0,$symbol = '>=')
	{
		$teble   = 'edu_nav';
		$field = array('edu_id','edu_name','edu_link','edu_order','IF(edu_show>0,"checked=\"checked\"","") as edu_show_html ','edu_show');
		$values = array("edu_show $symbol '$edu_show'");
		$top = 999;
		return self::Q($teble,$field,$values,$top,' ORDER BY edu_order ASC ');
	}
	//取分类列表
	public function contentclass($edu_show = 0,$symbol = '>=')
	{
		$teble   = 'edu_essayclass';
		$field = array('edu_id','edu_name','edu_summary','edu_order','IF(edu_show>0,"checked=\"checked\"","") as edu_show_html ','edu_show');
		$values = array("edu_show $symbol '$edu_show'");
		$top = 999;
		return self::Q($teble,$field,$values,$top,' ORDER BY edu_order ASC ');
	}
	public function label($edu_name)
	{
		$teble   = 'edu_label';
		$field = array('edu_id','edu_values');
		$values = array("edu_name = '$edu_name'");
		$top = 1;
		return self::Q($teble,$field,$values,$top);
	}

	public function uplabel($edu_name,$edu_values)
	{
		$teble   = 'edu_label';
		$field = array("edu_values='$edu_values'");
		$values = array("edu_name = '$edu_name'");
		return self::U($teble,$field,$values);
	}


	public function upnav($edu_id,$edu_name,$edu_order,$edu_show,$edu_link)
	{
		$teble   = 'edu_nav';
		$field = array("edu_name='$edu_name'","edu_order='$edu_order'","edu_show='$edu_show'","edu_link='$edu_link'",);
		$values = array("edu_id = '$edu_id'");
		return self::U($teble,$field,$values);
	}
	public function upcontentclass($edu_id,$edu_name,$edu_order,$edu_show,$edu_summary)
	{
		$teble   = 'edu_essayclass';
		$field = array("edu_name='$edu_name'","edu_order='$edu_order'","edu_show='$edu_show'","edu_summary='$edu_summary'",);
		$values = array("edu_id = '$edu_id'");
		return self::U($teble,$field,$values);
	}
	
	public function get()
	{
		
	}
}


?>