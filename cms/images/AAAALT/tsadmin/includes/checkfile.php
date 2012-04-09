<?php
    if($_GET['filename'] != ""){
        if(file_exists('../data/user_avatars/'.$_GET['filename'])){
            echo 'true';
        } else {
            echo 'false';
        }
    } else {
        echo 'false';
    }
?>