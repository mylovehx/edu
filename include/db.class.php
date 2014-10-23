<?php

class db
{

    // 保存类实例在此属性中
    private static $instance;
    public $dbh;
    // 构造方法声明为private，防止直接创建对象
    private function __construct()
    {
    	 /*
    	 if(!isset($DBtype)){
            $DBtype = 'mysql';
        }
       
        try{
            self::$dbh = mysql_connect(C('server'),C('user'),C('passwd'));
            if(!mysql_select_db(C('DBNAME'),self::$dbh)){
		echo '选择数据库错误!';
            }
        } catch( PDOException $e ){
            echo  'Connection failed: '  .  $e -> getMessage ();
        }*/

    }
    // singleton 方法
    public static function creat()
    {
        if(!isset(self::$instance)){
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
    	return $sql;
    }


}


?>