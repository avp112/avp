<?php

    function tellSeconds($NumberOfSeconds){
        $time_map = array(
    
         'Jahre'     => 31536000,    # 365 Tage
         'Monate'    => 2592000,    # 30 Tage
         'Wochen'    => 604800,    # 7 Tage
         'Tage'     => 86400,
         'Stunden'     => 3600,
         'Minuten'     => 60,
         'Sekunden'     => 1,
        );
    
        $SecondsTotal     = $NumberOfSeconds;
    
        $SecondsLeft     = $SecondsTotal;
    
        $stack = array();
    
        foreach ($time_map as $k => $v) {
    
            if ($SecondsLeft < $v || $SecondsLeft == 0) {
                    continue;
            } else {
                    $amount = floor($SecondsLeft/ $v);
                        $SecondsLeft = $SecondsLeft % $v;
    
                $label = ($amount>1)
                    ? $k
                    : substr($k, 0, -1);
    
                        $stack[] = sprintf('<strong>%s</strong> %s', $amount, $label);
            }
        }
        $cnt = count($stack);
    
        if ($cnt > 1){
            $tmp1 = array_pop($stack);
            $tmp2 = array_pop($stack);
            array_push ($stack, $tmp2 . ' und '.$tmp1);
        };
        $result = join (', ', $stack);
        return $result;
    
    }

?>