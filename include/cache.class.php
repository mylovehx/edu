<?php
class cache
{
    public $sum = 200;
    public $count = 1024;
    public $root = 0744;
    public $rootmodel = 'c';
    public $pos = 0;

    public
    function read($keyname)
    {
        $text = '';
        for ($n = 1; $n < $this->sum; $n++) {
            $json      = $this->readshmop($n);
            $arrayjson = json_decode($json,TRUE);
            if(!is_array($arrayjson)){
				break;
			}else{
				if($arrayjson['key'] == $keyname){
					for($i = $arrayjson['start']; $i < $arrayjson['finish']; $i++){
						$text .= $this->readshmop($i);
					}
				}
			}
        }
        return $text;
    }

    public
    function write($keyname,& $texts)
    {

        for ($n = 1; $n < $this->sum; $n++) {
            $json      = $this->readshmop($n);
            $arrayjson = json_decode($json,TRUE);
            if (!is_array($arrayjson) && $n == 1) {
                $this->pos = $this->sum + 1;
                $finish = $this->writeshmop($this->pos,$texts);
                $this->writeshmopname($keyname,$n,$this->pos,$finish);
                break;
            }

            if (is_array($arrayjson)) {
                if ($arrayjson['key'] == $keyname) {
                    break;
                }else {
                    $this->pos = $arrayjson['finish'];
                    continue;
                }
            }else {
                $finish = $this->writeshmop($this->pos,$texts);
                $this->writeshmopname($keyname,$n,$this->pos,$finish);
                break;
            }

        }
    }

    public
    function writeshmop($start,&$texts)
    {
    	
        $finish = $start;
        $textlen= strlen($texts);
        for ($i = 0; $i < $textlen; $i += $this->count) {
            $text   = substr($texts,$i,$this->count);
            $tempid = shmop_open($finish,$this->rootmodel,$this->root,$this->count);
            shmop_write($tempid,$text,0);
            shmop_close($tempid);
            $finish++;
        }
        return $finish;
    }
    public
    function readshmop($finish)
    {
        $tempid = shmop_open($finish,$this->rootmodel,$this->root,$this->count);
        $val    = rtrim(shmop_read($tempid,0,$this->count));
        shmop_close($tempid);
        return $val;
    }

    public
    function writeshmopval($finish,&$text)
    {
        $tempid = shmop_open($finish,$this->rootmodel,$this->root,$this->count);
        shmop_write($tempid,$text,0);
        shmop_close($tempid);
    }

    public
    function writeshmopname($keyname,$starts,$start,$finish)
    {
        $arrayjson = array("key"=>$keyname,"start"=>$start,"finish"=>$finish);
        $tempid = shmop_open($starts,$this->rootmodel,$this->root,$this->count);
        $text   = json_encode($arrayjson);
        shmop_write($tempid,$text,0);
        shmop_close($tempid);
    }


}



?>