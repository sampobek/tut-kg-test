<?php

class Application_Model_Additional
{
    public function date($input){
        $month_names = array(
            "01" => "Январь",
            "02" => "Февраль",
            "03" => "Март",
            "04" => "Апрель",
            "05" => "Май",
            "06" => "Июнь",
            "07" => "Июль",
            "08" => "Август",
            "09" => "Сентябрь",
            "10" => "Октябрь",
            "11" => "Ноябрь",
            "12" => "Декабрь",
        );
        
        $year = substr($input,0,4);
        $month = $month_names[substr($input,4,2)];
        $day = substr($input,6,2);
        $hour = substr($input,8,2);
        $minute = substr($input,10,2);
        if($day == date('d')){
            $date = "Сегодня";
        }
        else if(($day+1) == date('d')){
            $date = "Вчера";
        }
        else if($year != date('Y')){
            $date = $day." ".$month." ".$year;
        }
        else{
            $date = $day." ".$month;
        }
        $date .= " ".$hour.":".$minute;
        return $date;
    }
    
    public function id(){
        if(Zend_Auth::getInstance()->hasIdentity()){
            return Zend_Auth::getInstance()->getIdentity()->id;
        }
        else{
            return false;
        }
    }
}

