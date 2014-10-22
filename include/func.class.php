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



    /**
    * 以下为自定义函数，用于模板调用
    */

    public function login( & $REQUEST,&$returntext)
    {
        //$REQUEST['method'] = '0000';
       // var_dump($REQUEST['searchtxt']);
       if(function_exists('curl_init')){      
	   	$curl = curl_init($REQUEST['searchtxt']);
	   	//curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	   	//var_dump(curl_exec($curl));
	   	curl_exec($curl);
	   	curl_close($curl);
	   }
       
       
    }

}

?>