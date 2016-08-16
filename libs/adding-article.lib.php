<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */

if(isset($_POST['title']) && isset($_POST['intro']) && isset($_POST['txt']) && isset($_POST['author'])){
    
    $am = new ArticleManager();
    $res = $am->addArticle($_POST['title'], $_POST['intro'], $_POST['txt'], $_POST['author']);
    
    if($res){
        
        $_SESSION['adding_success'] = true;
        header("Location: ".$_SERVER['HTTP_REFERER']);
        
    } else {
        
        $_SESSION['adding_success'] = false;
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
} else {
    
    header("Location: ".SERVER_ADDRESS."home/");
}