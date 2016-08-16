<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */

if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['mail'])){
    
    $um = new UserManager();
    if($um->register($_POST['login'], $_POST['password'], $_POST['mail'])){
        $_SESSION['register_success'] = true;
        header("Location: ".$_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['register_success'] = false;
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
    
} else {
    header("Location: ".SERVER_ADDRESS."home/");
}