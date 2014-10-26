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



    /**
    * 以下为自定义函数，用于模板调用
    */

    public function login( & $REQUEST, & $returntext)
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

    public function upwebname( & $REQUEST, & $returntext)
    {
        $REQUEST['title'] = ltrim($REQUEST['title']);
        if(isset($REQUEST['title']) && strlen($REQUEST['title']) > 0){
            $a = db::creat()->uplabel('EDU-WEBNAME',$REQUEST['title']);
            echo('success:修改成功!');
        }else{
            echo('error:错误!');
        }
    }
    public function uplogo( & $REQUEST, & $returntext , & $FILES)
    {
        var_dump($FILES);
        $bool = FALSE;

        if(isset($REQUEST['logotitle']) && strlen($REQUEST['logotitle']) > 0){
            $REQUEST['logotitle'] = ltrim($REQUEST['logotitle']);
            $bool = db::creat()->uplabel('EDU-HOMETITLE',$REQUEST['logotitle']);
        }

        if(isset($REQUEST['logotext']) && strlen($REQUEST['logotext']) > 0){
            $REQUEST['logotext'] = ltrim($REQUEST['logotext']);
            $bool = db::creat()->uplabel('EDU-HOMETEXT',$REQUEST['logotext']);
        }

        if(isset($REQUEST['logofile']) && strlen($REQUEST['logofile']) > 0){
            $REQUEST['logofile'] = ltrim($REQUEST['logofile']);
            $bool = db::creat()->uplabel('EDU-HOMELOGO',$REQUEST['logofile']);
        }

        if($bool == TRUE){
            echo('success:修改成功!');
        }else{
            echo('error:错误!');
        }

    }
    public function uplogofile( & $REQUEST, & $returntext , & $FILES)
    {
        var_dump($FILES);
    }

}

?>