<?php



/**
* 参数引用未定义的类名
* @param undefined $VarName 
* 返回
* @return
*/
function __autoload($VarName){
    $file = ROOT."include./". $VarName . ".class.php"; 
    if(is_file($file)){
        include($file);
    }else{
        echo($VarName . ".class.php" . '文件不存在!');
    }
}







?>