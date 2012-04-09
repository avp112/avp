<?php


for ($i = 1; $i <= 366; $i++) {
    echo 'ALTER TABLE `avp_anwesenheit` ADD `indtag'.$i.'` TINYINT( 1 ) NOT NULL;'."</br>"; 
}


?>
