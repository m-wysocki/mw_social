<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */

if(isset($_SESSION['login']) && isset($_GET['id'])){
    
    $am = new ArticleManager();
    
    if($am->deleteArticle($_GET['id'], $_SESSION['login'])){
        
        header("Location: ".SERVER_ADDRESS."my-articles/");
        $_SESSION['delete_success'] = true;
        
    } else {
        
        header("Location: ".SERVER_ADDRESS."home/");
        $_SESSION['delete_success'] = false;
    }

} else {
    
    header("Location: ".SERVER_ADDRESS."home/");
}


