<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */

class ArticleManager{
    
    protected $idUser;
    
    /**
     * Dodaje cały artykuł do bazy danych.
     * 
     * @param type $TITLE - tytuł - string
     * @param type $INTRO - wstęp - string
     * @param type $TXT - treść - string
     * @param type $AUTHOR - autor - string ($_SESSION['login'])
     * @return boolean
     */
    public function addArticle($TITLE, $INTRO, $TXT, $AUTHOR){
        $userArr = DBManager::selectData("users", array('id'), array("username='{$AUTHOR}'"));
        if(count($userArr)===1){
            $idUser = $userArr[0]['id'];
        } else {
            return false;
        }
        $res = DBManager::insertInto("articles", array('title'=>"{$TITLE}", 'intro'=>"{$INTRO}", 'text'=>"{$TXT}", 'id_user'=>$idUser));
        
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Usuwa artykuł z bazy danych.
     * 
     * @param type $ARTICLE_ID - id artykułu do usunięcia - int
     * @param type $LOGGED_USER - nazwa zalogowanego użytkownika - string ($_SESSION['login'])
     * @return boolean
     */
    public function deleteArticle($ARTICLE_ID, $LOGGED_USER){
        
        if($this->checkAuthor($ARTICLE_ID, $LOGGED_USER)){
            
            $res = DBManager::deleteFrom("articles", array("id={$ARTICLE_ID}"));
            
            if($res){
                return true;
            } else {
                return false;
            }
            
        } else {
            
            return false;
        }
        
    }
    
    /**
     * Sprawdza czy dany artukuł jest dziełem zalogowanego użytkownika.
     * 
     * @param type $ARTICLE_ID - id artykułu do usunięcia - int
     * @param type $LOGGED_USER - nazwa zalogowanego użytkownika - string ($_SESSION['login'])
     * @return boolean
     */
    protected function checkAuthor($ARTICLE_ID, $LOGGED_USER){
        
        $articleArr = DBManager::selectData("articles", array('id_user'), array("id={$ARTICLE_ID}"));
        $articleAuthorId = $articleArr[0]['id_user'];

        $userArr = DBManager::selectData("users", array('username'), array("id={$articleAuthorId}"));
        $articleAuthorName = $userArr[0]['username'];

        if($LOGGED_USER == $articleAuthorName){
            return true;
        } else {
            return false;
        }
    }
}