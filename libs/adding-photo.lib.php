<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */
if(isset($_SESSION['login']) && isset($_FILES['plik']['name'])){
    
    $um = new UserManager;
    
    $photoArr = DBManager::selectData('users', array('photo'), array("username='{$_SESSION['login']}'"));
    
    if(count($photoArr) > 0 && $photoArr[0]['photo'] != 'user_icon.png'){
        $res2 = $um->deletePhoto("./img/profiles/", $photoArr[0]['photo']);
    }
    
    
    $res = $um->addPhoto("./img/profiles/", $_FILES['plik']['name'], $_FILES['plik']['error'], $_FILES['plik']['tmp_name'], $_FILES['plik']['type']);
    
    if ($res){
        $_SESSION['adding_success'] = true; 
        header("Location: ".$_SERVER['HTTP_REFERER']);

    } else {
        $_SESSION['adding_success'] = false;
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
    
} else {
    header("Location: ".SERVER_ADDRESS."home/");
}