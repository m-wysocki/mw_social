<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */

class UserManager {
    protected $login, $password, $mail;
    protected $logged_id, $followed_id;


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
     * Odpowiada za obserwowanie danego użytkownika.
     * 
     * @param type $LOGGED_ID - id zalogowanego użytkownika
     * @param type $FOLLOWED_ID - id użytkownika, którego chce obserwować zalogowany użytkownik
     * @return boolean
     */
    public function follow($LOGGED_ID, $FOLLOWED_ID){
        
        $this->logged_id = $LOGGED_ID;
        $this->followed_id = $FOLLOWED_ID;
        
        $res = DBManager::insertInto("follow", array('logged_id'=>$this->logged_id, 'followed_id'=>$this->followed_id));
        
        if($res){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Odpowiada za  zaprzestanie obserwowani danego użytkownika.
     * 
     * @param type $LOGGED_ID - id zalogowanego użytkownika
     * @param type $FOLLOWED_ID - id użytkownika, którego chce przestać obserwować zalogowany użytkownik
     * @return boolean
     */
    public function deleteFollow($LOGGED_ID, $FOLLOWED_ID){
        
        $this->logged_id = $LOGGED_ID;
        $this->followed_id = $FOLLOWED_ID;
        
        $res = DBManager::deleteFrom("follow", array("logged_id={$this->logged_id}", "followed_id={$this->followed_id}"), "AND");
        
        if($res){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sprawdza czy istnieje już takie obserwowanie
     * 
     * @param type $LOGGED_ID - id zalogowanego użytkownika
     * @param type $FOLLOWED_ID - id użytkownika do sprawdzenia obserwowania
     * @return boolean
     */
    public function isFollowed($LOGGED_ID, $FOLLOWED_ID){
        
        $this->logged_id = $LOGGED_ID;
        $this->followed_id = $FOLLOWED_ID;
        
        $resArr = DBManager::selectData("follow", array("id"), array("logged_id={$this->logged_id}", "followed_id={$this->followed_id}"), "AND");

        if($resArr[0]['id']>0){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Dodaje zdjęcie na serwer i dopisuje nazwe do bazy danych.
     * 
     * @param type $F_UPLOAD_FOLDER - folder do którego ma nastąpić upload zdjęcia
     * @param type $F_NAME - nazwa zdjęcia
     * Z superglobalnej tablicy $_FILE:
     * @param type $F_ERROR - zmienna informująca o błędzie
     * @param type $F_TMP - nazwa tymczasowa zdjęcia
     * @param type $F_TYPE - typ uploadowanych danych (do sprawdzenia czy photo)
     * @return boolean
     */
    public function addPhoto($F_UPLOAD_FOLDER, $F_NAME, $F_ERROR, $F_TMP, $F_TYPE){
        
        $folder_upload = $F_UPLOAD_FOLDER;
    
        $file_name = $F_NAME;

        if($F_ERROR == UPLOAD_ERR_OK){

            $new_name = $folder_upload.$file_name;
            $temp_name = $F_TMP;

            $mime = $F_TYPE;
            $file_type = explode("/", $mime);
            if ($file_type[0] != "image") {
                return false;
            } else {

                if(move_uploaded_file($temp_name, $new_name)){
                    $res = DBManager::updateTable("users", array('photo'=>$file_name), array("username='{$_SESSION['login']}'"));
                    if($res){
                        return true;
                    } else {
                        return false;
                    }  
                } else {
                    return false;
                }
            }

        } else {
            return false;
        }
    }
    
    /**
     * Usuwa plik zdjęcia z serwera.
     * 
     * @param type $F_UPLOAD_FOLDER - folder do którego ma nastąpić upload zdjęcia
     * @param type $F_NAME - nazwa zdjęcia
     * @return boolean
     */
    public function deletePhoto($F_UPLOAD_FOLDER, $F_NAME){
        $file_name = $F_NAME;
        $file_dir = $F_UPLOAD_FOLDER;
        
        if(unlink($file_dir.$file_name)){
            return true;
        } else {
            return false;
        }      
    }
    
    /**
     * Ustawia z powrotem zdjęcie na domyślne.
     * 
     * @return boolean
     */
    public function setDefaultPhoto(){
        $res = DBManager::updateTable('users', array("photo"=>"user_icon.png"), array("username='{$_SESSION['login']}'"));
        
        if($res){
            return true;
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
