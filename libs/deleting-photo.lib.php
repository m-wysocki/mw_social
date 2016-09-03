<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */

if(isset($_SESSION['login'])){
    
    $photoArr = DBManager::selectData('users', array('photo'), array("username='{$_SESSION['login']}'"));
    
    if (count($photoArr) > 0 && $photoArr[0]['photo'] != 'user_icon.png'){
        $um = new UserManager;
        $res = $um->deletePhoto("./img/profiles/", $photoArr[0]['photo']);
        $res2 = $um->setDefaultPhoto();

        if ($res && $res2){
            $_SESSION['deleting_success'] = true; 
            header("Location: ".$_SERVER['HTTP_REFERER']);
        } else {
            $_SESSION['deleting_success'] = false;
            header("Location: ".$_SERVER['HTTP_REFERER']);
        }
    } else {
        $_SESSION['deleting_success'] = false;
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
    
    
} else {
    
    header("Location: ".SERVER_ADDRESS."home/");
}