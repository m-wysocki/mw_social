<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */

class MainPage{
    private $active_page;
    
    public function __construct($ACTIVE_PAGE) {
        $this->active_page = $ACTIVE_PAGE;
        
        switch ($this->active_page){
            case 'home':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'login':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'logout':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'register':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'articles':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'articles-from':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'read-article':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'add-article':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'adding-article':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'delete-article':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'users-list':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'profile':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'adding-photo':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'deleting-photo':
                require_once $this->active_page.".lib.php";
                break;

            case 'follow':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'follow-list':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'follow-articles':
                require_once $this->active_page.".lib.php";
                break;
            
            case 'delete-follow':
                require_once $this->active_page.".lib.php";
                break;
        }
    }
}