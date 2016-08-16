<?php
        
session_start();
require_once("config.php");

if(!(isset($_GET['page']))){
    header("Location: ".SERVER_ADDRESS."home");
}else{
    $mp = new MainPage($_GET['page']);
}