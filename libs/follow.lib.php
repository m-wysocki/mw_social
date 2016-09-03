<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */

if (isset($_SESSION['login']) && isset($_POST['followed_id'])){
    
    $um = new UserManager();
    $res = DBManager::selectData("users", array("id"), array("username='{$_SESSION['login']}'"));
    $logged_id = $res[0]['id'];
    
    $resF = $um->follow($logged_id, $_POST['followed_id']);
    
    header("Location: ".$_SERVER['HTTP_REFERER']);
        
} else {
    header("Location: ".SERVER_ADDRESS."home/");
}