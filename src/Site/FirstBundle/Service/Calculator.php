<?php

namespace Site\FirstBundle\Service;

class Calculator
{
    public function myCalc($ch1, $op, $ch2) 
    {
        if (isset($ch1) and isset($op) and isset($ch2)) {

            if (is_numeric($ch1)  and  is_numeric($ch2)) {
                $n1 = trim(strip_tags($ch1));
                $n2 = trim(strip_tags($ch2));

                if ($op != "+" and $op != "-" and $op != "*" and $op != "/") {
                    return $res = "Допустимые операторы: Сложение (+) Вычитание (-) 
                                   Умножение (*)Деление (/)";
                }

        if ($op == "+") {
                    $answ = $n1 + $n2;
                    return $res = "$n1 + $n2 = $answ";
        }
        elseif ($op == "-") {
                        $answ = $n1 - $n2;
                        return $res = "$n1 - $n2 = $answ";
        }
                elseif ($op == "*") {
                        $answ = $n1 * $n2;
                        return $res = "$n1 * $n2 = $answ";
        }
            
                if ($op == "/") {
                        if ($n2 == 0) {
                        return $zero = "На '0' делить нельзя!!!";
                        }
                    $answ = $n1 / $n2;
                    return $res = "$n1 / $n2 = $answ ";
        }
            }
            else {
                    return $res = "Только цифры, пожалуйста ;)";
            }
    }
  }
    
    
}
