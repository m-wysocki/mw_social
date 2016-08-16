<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */
if ($_SESSION['logged'] === true){
    $um = new UserManager();
    $um->logOut();
    if($_SERVER['HTTP_REFERER']){ 
        header("Location: ".$_SERVER['HTTP_REFERER']);
    } else {
       header("Location: ".SERVER_ADDRESS."home/"); 
    }
} else {
    header("Location: ".SERVER_ADDRESS."home/");
}