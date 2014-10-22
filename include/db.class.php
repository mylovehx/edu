<?php

class db
{

    // 保存类实例在此属性中
    private static $instance;
    private static $dbh;
    // 构造方法声明为private，防止直接创建对象
    private function __construct( & $DBname, & $host, & $user, & $password, & $DBtype)
    {
        if(!isset($DBtype)){
            $DBtype = 'mysql';
        }
        $user     = $user ;
        $password = $password ;

        try{
            $this->$dbh = mysql_connect($host,$user,$password);
        } catch( PDOException $e ){
            echo  'Connection failed: '  .  $e -> getMessage ();
        }

    }
    // singleton 方法
    public static function creat( & $DBname, & $host, & $user, & $password, & $DBtype)
    {
        if(!isset(self::$instance)){
            $c = __CLASS__;
            self::$instance = new $c($DBname,$host,$user,$password,$DBtype);
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

    public function query( & $sql)
    {

        echo($sql);
    }


}


?>