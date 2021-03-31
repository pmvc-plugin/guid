<?php
namespace IdOfThings;

class BigIntGuid
{
    private $_start = 2021;

    public function setStart($i)
    {
        $this->_start = $i;
    }

    public function getStart($timestamp)
    {
        return 1000 + date('Y', $timestamp) - $this->_start;
    }

    public function messOdd($number, $rand)
    {
        return $number . $rand;
    }

    public function messEven($number, $rand)
    {
        return $rand . $number;
    }

    /**
     * @param int      $guidLen        Guid length
     * @param callable $existsCallback Check if id already exists in db
     */
    public function gen(
        $guidLen = null,
        callable $existsCallback = null,
        $timestamp = null
    ) {
        if (empty($guidLen)) {
            $guidLen = 19;
        }
        if (empty($timestamp)) {
            $timestamp = time();
        }
        $newid = $this->_gen($guidLen, $timestamp);
        if (is_callable($existsCallback)) {
            while (call_user_func_array($existsCallback, [&$newid])) {
                $newid = $this->_gen($guidLen, $timestamp);
            }
        }
        return $newid;
    }

    private function _gen($guidLen, $timestamp)
    {
        $date = explode(' ', date('Y m d H i s', $timestamp));
        $d_y = $this->getStart($timestamp);
        $d_mon = $date[1];
        $d_day = $date[2];
        $d_h = $date[3];
        $d_min = $date[4];
        $d_s = $date[5];

        $totalSec = sprintf('%08d', mktime($d_h, $d_min, $d_s, $d_mon, $d_day, 1970));
        $totalSecLen = strlen($totalSec);

        $randlen = $guidLen - 1 - 8 - strlen($d_y);
        $rand = '';
        for ($i = 0; $i < $randlen; $i++) {
            $rand .= mt_rand(0, 9);
        }
        $d_string = $d_y . $d_mon . $d_day . $d_h . $d_min . $d_s;
        $md5 = $this->getVerifyNo($d_string, $rand);
        $startInsert = $md5;
        $isOdd = $md5 % 2;
        if ($startInsert >= $totalSecLen) {
            $startInsert -= $totalSecLen;
        }
        $newNumber = $d_y;
        $totalSec = (string) $totalSec;
        $rand = (string) $rand;
        for ($i = 0; $i < $totalSecLen; $i++) {
            $rand0 = $this->popString($rand);
            if ($isOdd) {
                $newNumber .= $this->messOdd($totalSec[$startInsert], $rand0);
            } else {
                $newNumber .= $this->messEven($totalSec[$startInsert], $rand0);
            }
            $startInsert++;
            if ($startInsert >= $totalSecLen) {
                $startInsert = 0;
            }
        }
        $newNumber .= $rand . $md5;
        return $newNumber;
    }

    public function getVerifyNo($date, $rand)
    {
        $md5 = md5($date . $rand);
        $i = $rand % 32;
        $md5 = substr(ord($md5[$i]), -1);
        return $md5;
    }

    public function secToDate($sec)
    {
        $date = explode(' ', date('Y m d H i s', $sec));
        return [
            'mon' => $date[1],
            'day' => $date[2],
            'hour' => $date[3],
            'min' => $date[4],
            'sec' => $date[5],
        ];
    }

    public function popString(&$str)
    {
        $first = '';
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
        $encode = substr($s, 4, strlen($s) - 4 - 1);
        $isOdd = $lastMd5 % 2;
        $totalSecLen = 8;
        $startInsert = $lastMd5;
        if ($startInsert >= $totalSecLen) {
            $startInsert -= $totalSecLen;
        }
        $randLen = strlen($encode) - $totalSecLen;
        $keepRandLen = $randLen;
        $rand = '';
        $totalSec = '';
        $totalSecHead = '';
        $tmpTotalSecLastLen = 0;
        for ($i = 0; $i < $totalSecLen; $i++) {
            if ($randLen) {
                if ($isOdd) {
                    if ($startInsert < $totalSecLen) {
                        $totalSec .= $this->popString($encode);
                    } else {
                        $totalSecHead .= $this->popString($encode);
                    }
                    $rand .= $this->popString($encode);
                } else {
                    $rand .= $this->popString($encode);
                    if ($startInsert < $totalSecLen) {
                        $totalSec .= $this->popString($encode);
                    } else {
                        $totalSecHead .= $this->popString($encode);
                    }
                }
                $randLen--;
            } else {
                if ($startInsert < $totalSecLen) {
                    $totalSec .= $this->popString($encode);
                } else {
                    $totalSecHead .= $this->popString($encode);
                }
            }
            $startInsert++;
        }
        $totalSec = $totalSecHead . $totalSec;
        if ($randLen) {
            $rand .= $encode;
        }
        $date = $this->secToDate($totalSec);
        $d_string =
            $year .
            $date['mon'] .
            $date['day'] .
            $date['hour'] .
            $date['min'] .
            $date['sec'];
        $verifyMd5 = $this->getVerifyNo($d_string, $rand);
        if ($verifyMd5 == $lastMd5) {
            return $year - 1000 + $this->_start . substr($d_string, 4);
        } else {
            return false;
        }
    }
}
