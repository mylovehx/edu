<?php
class templetfunction
{

    public function __call($name, $arguments)
    {
        //var_dump($arguments);
        return '';
    }

    /**
    * 自定义函数，载入HTML文件
    * 自定义参数
    * @param undefined $arguments
    * 返回处理好的替换文本
    * @return
    */
    public function load( & $htmltext, & $code , & $arguments, & $func_in, & $func_ot)
    {
        if(count($arguments) > 0){
            $filedir = C('templet');
            $file    = realpath(ROOT . 'templet./' . $filedir .'./'. $arguments[0]);
            if(!is_file($file)){
                $filedir = 'default';
                $file    = ROOT . 'templet./default./' . $arguments[0];
            }
            //取文件扩展名
            $ex = pathinfo($file, PATHINFO_EXTENSION);
            switch($ex){
                case 'js':
                return '<script src="./templet/'.$filedir.'/js/'.basename($file).'" ></script>';
                case 'css':
                return '<link rel="stylesheet" type="text/css" href="./templet/'.$filedir.'/css/'.basename($file).'">';
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'bmp':
                case 'gif':
                case 'svg':
                return './templet/'.$filedir.'/img/'.basename($file);
                default:
                //读取外部模板文件
                $returntext = file_get_contents($file);
                //压缩外部文件大小
                systems::compress_html($returntext);
                return $returntext;
            }
        }
        return '';
    }
    public function css( & $htmltext, & $code , & $arguments, & $func_in, & $func_ot)
    {
        if(count($arguments) > 0){
            $filedir = C('templet');
            $file    = realpath(ROOT . 'templet./' .$filedir.'./'. $arguments[0]);
            if(!is_file($file)){
                $file    = ROOT . 'templet./default./' . $arguments[0];
                $filedir = 'default';
            }
            //取文件扩展名
            $ex = pathinfo($file, PATHINFO_EXTENSION);
            switch($ex){
                case 'css':{
                    //清除原代码
                    $htmltext = str_replace('</head>',$code.'</head>',str_replace($code,'',$htmltext));
                    return '<link rel="stylesheet" type="text/css" href="./templet/'.$filedir.'/css/'.basename($file).'">';
                }
                case 'js':{
                    //清除原代码
                    $htmltext = str_replace('</head>',$code.'</head>',str_replace($code,'',$htmltext));
                    return '<script src="./templet/'.$filedir.'/js/'.basename($file).'" ></script>';
                }
                default:
                break;
            }

        }
        return '';
    }



    public function loop( & $htmltext, & $code , & $arguments, & $func_in, & $func_ot)
    {
        $strlen   = strlen($htmltext);
        $loop_in  = 0;
        $text     = '';
        $in_count = 0;
        for($in = $func_ot; $in < $strlen; ++$in){
            if($in < 3){
                break;
            }
            if($loop_in == 0 && $htmltext[$in] == '{' && $htmltext[$in - 1] != '\\'){
                $loop_in = $in + 1;
            }else
            if($htmltext[$in] == '{' && $htmltext[$in - 1] == '\\'){
                $htmltext[$in - 1] = '  ';
            }
            if($loop_in > 0 && $htmltext[$in] == '{' && $htmltext[$in - 1] != '\\'){
                ++$in_count;
            }

            if($loop_in > 0 && $htmltext[$in] == '}' && $htmltext[$in - 1] != '\\'){
                --$in_count;
            }
            if($loop_in > 0 && $htmltext[$in] == '}' && $htmltext[$in - 1] != '\\' && $in_count == 0){
                //取得函数体模板
                $modeltext = substr($htmltext,$loop_in ,$in - $loop_in);
                break;
            }else
            if($htmltext[$in] == '}' && $htmltext[$in - 1] == '\\'){
                $htmltext[$in - 1] = '  ';
            }
        }
        //重复函数体模板
        $text     = str_repeat($modeltext,$arguments[0]);
        //删除模板部分
        $htmltext = str_replace('{'.$modeltext.'}','',$htmltext);
        return $text;

    }
    public function traversal( & $htmltext, & $code , & $arguments, & $func_in, & $func_ot)
    {
        $strlen    = strlen($htmltext);
        $loop_in   = 0;
        $modeltext = '';
        $text      = '';
        $model     = '';
        $in_count  = 0;

        for($in = $func_ot; $in < $strlen; ++$in){
            if($in < 3){
                break;
            }
            //循环第一层判断函数体开头
            if($loop_in == 0 && $htmltext[$in] == '{' && $htmltext[$in - 1] != '\\'){
                $loop_in = $in + 1;
            }else
            if($htmltext[$in] == '{' && $htmltext[$in - 1] == '\\'){
                $htmltext[$in - 1] = '  ';
            }

            if($loop_in > 0 && $htmltext[$in] == '{' && $htmltext[$in - 1] != '\\'){
                ++$in_count;
            }

            if($loop_in > 0 && $htmltext[$in] == '}' && $htmltext[$in - 1] != '\\'){
                --$in_count;
            }

            //循环判断函数体结尾
            if($loop_in > 0 && $htmltext[$in] == '}' && $htmltext[$in - 1] != '\\' && $in_count == 0){
                $model     = substr($htmltext,$loop_in - 1 ,$in - $loop_in + 2);
                $modeltext = substr($htmltext,$loop_in  ,$in - $loop_in );
                break;
            }else
            if($htmltext[$in] == '}' && $htmltext[$in - 1] == '\\'){
                $htmltext[$in - 1] = '  ';
            }

        }
        //var_dump(strpos(strtolower($modeltext),'@traversal'));
        if(is_array($arguments)){
            $tabs = array();
            $len = count($arguments);
            if($len > 0){
                //动态调用取出数组并插入到新数组内
                for($is = 0; $is < $len; ++$is){
                    //$arrays = tab::creat()->get($arguments[$is]);
                    $tabs[$arguments[$is]] = G($arguments[$is]);
                }
                $alen = count($arguments);
                //第一层循环 循环动态变量名
                for($il = 0; $il < $alen; ++$il){
                    $klen = count($tabs[$arguments[$il]]);
                    //第三层循环 循环动态数组子类
                    for($ik = 0; $ik < $klen; ++$ik){
                        //取动态数组所有键名
                        if(is_array($tabs[$arguments[$il]][$ik])){
                            $keynames = array_keys($tabs[$arguments[$il]][$ik]);
                            $knlen    = count($keynames);
                            //初始化替换模板。
                            $temp     = $modeltext;
                            //循环动态数组子类名
                            for($io = 0; $io < $knlen; ++$io){
                                //替换数组循环变量
                                $temp = str_replace('$'.$arguments[$il].'.'.$keynames[$io],$tabs[$arguments[$il]][$ik][$keynames[$io]],$temp);
                            }
                            //替换遍历值
                            $text .= str_replace('$$',$ik + 1,$temp);
                        }else{
                            if(($ik + 1) == $klen){
                                //替换文本变量
                                $text = str_replace('$'.$arguments[$il],$tabs[$arguments[$il]][$ik],$text);
                            }else{
                                //替换文本变量不足总数部分统一替换
                                $text = substr_replace($text,$tabs[$arguments[$il]][$ik],strpos($text,'$'.$arguments[$il]),strlen('$'.$arguments[$il]));
                            }
                        }
                    }
                }
            }
        }
        //删除模板部分
        $htmltext = str_replace($model,'',$htmltext);
        return $text;
    }

}
?>