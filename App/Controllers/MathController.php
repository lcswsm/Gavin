<?php

/**
 * MathController ，数学计算控制器
 *
 * @author Gavin
 * @version 2018-01-08 14：21：30
 */
class MathController extends App\Common\BaseController {

    public function initialize() 
    {
        parent::initialize();
    }
    /**
     * 等差数列求和
     * 算法：等差数列求和公式 
     * 条件1：已知最大值，最小值
     * Sn = n*(a1+an)/2
     */
    public function sum_arithmeticAction( ){
        $a1 = $this->__GET__(0);
        $an = $this->__GET__(1);
        if($a1 > $an ){      
            $c = $a1;
            $a1 = $an;
            $an = $c;
        }
        $n  = $an - $a1 + 1;
        $sn = $n*($a1+$an)/2;  
        echo $sn;
    }
}
