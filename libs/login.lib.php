<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */
if (isset($_POST['login']) && isset($_POST['password'])){
    
    $um = new UserManager();
    
    if($um->logIn($_POST['login'], $_POST['password'])){
        
        header("Location: ".$_SERVER['HTTP_REFERER']);
        
    } else {
        $_SESSION['login_error'] = true;
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }  
} else {
    
    header("Location: ".SERVER_ADDRESS."home/");
}


