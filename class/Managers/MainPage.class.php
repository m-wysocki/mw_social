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
        }
        
        switch ($this->active_page){
            case 'login':
                require_once $this->active_page.".lib.php";
                break;
        }
        
        switch ($this->active_page){
            case 'logout':
                require_once $this->active_page.".lib.php";
                break;
        }
        
        switch ($this->active_page){
            case 'register':
                require_once $this->active_page.".lib.php";
                break;
        }
        
        switch ($this->active_page){
            case 'articles':
                require_once $this->active_page.".lib.php";
                break;
        }
        
        switch ($this->active_page){
            case 'my-articles':
                require_once $this->active_page.".lib.php";
                break;
        }
        
        switch ($this->active_page){
            case 'read-article':
                require_once $this->active_page.".lib.php";
                break;
        }
        
        switch ($this->active_page){
            case 'add-article':
                require_once $this->active_page.".lib.php";
                break;
        }
        
        switch ($this->active_page){
            case 'adding-article':
                require_once $this->active_page.".lib.php";
                break;
        }
        
        switch ($this->active_page){
            case 'delete-article':
                require_once $this->active_page.".lib.php";
                break;
        }
    }
}