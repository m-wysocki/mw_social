<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */

class UserManager {
    protected $login, $password, $mail;
    
    /**
     * Odpowiada za logowanie użytkownika.
     * 
     * @param type $LOGIN - login - string
     * @param type $PASSWORD - hasło - string
     * @return false or login(string)
     */
    public function logIn($LOGIN, $PASSWORD){
        $this->login = $LOGIN;
        $this->password = md5($PASSWORD);
        
        $res = $this->isExistToLogin();
        if(!$res || (count($res))<0){
            return false;
        } else {
            $_SESSION['login'] = $this->login;
            $_SESSION['logged'] = true;
            return $this->login;
        }    
    }
    
    /**
     * Odpowiada za wylogowanie użytkownika.
     */
    public function logOut(){
        $_SESSION['login'] = false;
        $_SESSION['logged'] = false;
        session_destroy();
    }
    
    /**
     * Odpowiada za rejestracje użytkownika. Dodaje nowego do bazy danych.
     * 
     * @param type $LOGIN - login - string
     * @param type $PASSWORD - hasło - string
     * @param type $MAIL - mail - string
     * @return boolean
     */
    public function register($LOGIN, $PASSWORD, $MAIL){
        $this->login = $LOGIN;
        $this->password = $PASSWORD;
        $this->mail = $MAIL;
        
        $res = $this->isExist();
        if(!$res || (count($res))<1){
            
            $res_of_reg = DBManager::insertInto("users", array('username'=>$this->login, 'password'=>$this->password, 'mail'=>$this->mail));
            
            if($res_of_reg === true){
                return true;
            } else {
                return false;
            }
            
        } else {
            return false;
        }   
    }
    
    /**
     * Sprawdza czy użytkownik o danym loginie istnieje w bazie. 
     */
    protected function isExist(){
        $res = DBManager::selectData('users', array('username'), array("username='{$this->login}'"));
        return $res;
    }

    /**
     * Sprawdza czy użytkownik o danym loginie i haśle istnieje w bazie. 
     */
    protected function isExistToLogin(){
        $res = DBManager::selectData('users', array('username'), array("username='{$this->login}'", "password='{$this->password}'"));
        return $res;
    }
}
