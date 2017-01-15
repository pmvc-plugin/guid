<?php
namespace IdOfThings;

class BigIntGuid
{
    public function messOdd($number, $rand)
    {
        return $number.$rand;
    }

    public function messEven($number, $rand)
    {
        return $rand.$number;
    }

    /**
     * @param int      $guidLen        Guid length
     * @param callable $existsCallback Check if id already exists in db
     */
    public function gen($guidLen=null, callable $existsCallback=null)
    {
        if (empty($guidLen)) {
            $guidLen = 19;
        }
        $newid = $this->_gen($guidLen);
        if (is_callable($existsCallback)) {
           while ( call_user_func_array($existsCallback, [&$newid]) )
           { 
                $newid = $this->_gen($guidLen);
           }
        }
        return $newid;
    }

    private function _gen($guidLen)
    {
        $date = explode(' ', date('Y m d H i s'));
        $d_y=$date[0];
        $d_mon = $date[1];
        $d_day = $date[2];
        $d_h = $date[3];
        $d_min = $date[4];
        $d_s = $date[5];

        $totalSec = $d_mon*30*86400 + $d_day*86400 + $d_h*3600 + $d_min*60 + $d_s;
        $totalSec =sprintf('%08d', $totalSec);
        $totalSecLen=strlen($totalSec);

        $randlen = $guidLen -1 -8 -4;
        $rand = '';
        for ($i=0;$i<$randlen;$i++) {
            $rand.=mt_rand(0, 9);
        }
        $d_string = $d_y.$d_mon.$d_day.$d_h.$d_min.$d_s;
        $md5 =$this->getVerifyNo($d_string, $rand);
        $startInsert = $md5;
        $isOdd=$md5%2;
        if ($startInsert>=$totalSecLen) {
            $startInsert-=$totalSecLen;
        }
        $newNumber=$d_y;
        $totalSec=(string)$totalSec;
        $rand=(string)$rand;
        for ($i=0;$i<$totalSecLen;$i++) {
            $rand0 = $this->popString($rand);
            if ($isOdd) {
                $newNumber.=$this->messOdd($totalSec[$startInsert], $rand0);
            } else {
                $newNumber.=$this->messEven($totalSec[$startInsert], $rand0);
            }
            $startInsert++;
            if ($startInsert>=$totalSecLen) {
                $startInsert=0;
            }
        }
        $newNumber.=$rand.$md5;
        return $newNumber;
    }

    public function getVerifyNo($date, $rand)
    {
        $md5=md5($date.$rand);
        $i = $rand%32;
        $md5=substr(ord($md5[$i]), -1);
        return $md5;
    }

    public function secToDate($sec)
    {
        $mon = floor($sec / 86400 / 30);
        if ($mon>12) {
            return false;
        }
        $d_sec = $sec - $mon*86400*30;
        $d = floor($d_sec / 86400);
        if ($d>31) {
            return false;
        }
        $h_sec = $d_sec - 86400*$d;
        $h = floor($h_sec / 3600);
        if ($h>23) {
            return false;
        }
        $m_sec = $h_sec - 3600*$h;
        $min = floor($m_sec / 60);
        if ($min>59) {
            return false;
        }
        $s = $m_sec - 60*$min;
        return array(
            'mon'=>sprintf('%02d', $mon)
            ,'day'=>sprintf('%02d', $d)
            ,'hour'=>sprintf('%02d', $h)
            ,'min'=>sprintf('%02d', $min)
            ,'sec'=>sprintf('%02d', $s)
       );
    }


    public function popString(&$str)
    {
        $first ='';
        if (strlen($str)) {
            $first = $str[0];
        }
        $str = substr($str, 1, strlen($str));
        return $first;
    }

    public function verify($s)
    {
        $year = substr($s, 0, 4);
        $lastMd5 = substr($s, -1);
        $encode = substr($s, 4, strlen($s)-4-1);
        $isOdd = $lastMd5%2;
        $totalSecLen = 8;
        $startInsert = $lastMd5;
        if ($startInsert>=$totalSecLen) {
            $startInsert-=$totalSecLen;
        }
        $randLen = strlen($encode) - $totalSecLen;
        $keepRandLen = $randLen;
        $rand='';
        $totalSec='';
        $totalSecHead='';
        $tmpTotalSecLastLen=0;
        for ($i=0;$i<$totalSecLen;$i++) {
            if ($randLen) {
                if ($isOdd) {
                    if ($startInsert<$totalSecLen) {
                        $totalSec.=$this->popString($encode);
                    } else {
                        $totalSecHead.=$this->popString($encode);
                    }
                    $rand.=$this->popString($encode);
                } else {
                    $rand.=$this->popString($encode);
                    if ($startInsert<$totalSecLen) {
                        $totalSec.=$this->popString($encode);
                    } else {
                        $totalSecHead.=$this->popString($encode);
                    }
                }
                $randLen--;
            } else {
                if ($startInsert<$totalSecLen) {
                    $totalSec.=$this->popString($encode);
                } else {
                    $totalSecHead.=$this->popString($encode);
                }
            }
            $startInsert++;
        }
        $totalSec=$totalSecHead.$totalSec;
        if ($randLen) {
            $rand.=$encode;
        }
        $date = $this->secToDate($totalSec);
        $d_string = $year.$date['mon'].$date['day'].$date['hour'].$date['min'].$date['sec'];
        $verifyMd5 = $this->getVerifyNo($d_string, $rand);
        if ($verifyMd5==$lastMd5) {
            return $d_string;
        } else {
            return false;
        }
    }
}
