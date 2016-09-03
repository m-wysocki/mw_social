<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */

class DBManager{
    
    /**
     * Inicjalizuje połączenie z bazą danych.
     * @return \mysqli
     */
    static public function getConnection() {
        
        $db_handle = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
        if(mysqli_connect_errno()){
            
            $conn_errno = mysqli_connect_errno();   // numer błędu
            $conn_error = mysqli_connect_error();   // treść
            
            // W przypadku błędu, info do loga i koniec skryptu.
            LogFile::AddLog("Nastąpił błąd połączenia [$conn_errno] z bazą danych, o treści: [ $conn_error ]" , __LINE__, __FILE__);
            exit();
            
        } else {
            
            $db_handle->query("SET NAMES 'utf8'"); // ustawiam system kodowań w bazie
            return $db_handle;
        }
    }
    
    /**
     * Wysyła polecenie SQL do bazy danych.  
     * sendSQLQuery('SELECT * FROM users');
     * 
     * @param type $SQL_QUERY - zapytanie SQL - string
     * @return boolean
     */
    static public function sendSQLQuery($SQL_QUERY){
        
        $db_handle = self::getConnection();
        $res = $db_handle->query("$SQL_QUERY");
        
        if(!$res){            
            LogFile::AddLog("Nastąpił błąd połączenia z bazą danych" , __LINE__, __FILE__);
            return false;           
        } else {           
            $resArr = array();
            while($row = $res->fetch_array(MYSQLI_ASSOC)!== NULL){  // dzieli tablice mysql na wiersze
                $resArr[] = $row;                              // wpisuje wiersze do nowej tablicy dopóki nie trafi na pusty wiersz
            }
        }
        
        if(count($resArr)>0){     
            return $resArr;    // sprawdza czy tablica z wynikami nie jest pusta        
        } else {    
            LogFile::AddLog("Zapytanie bazodanowe zwróciło pusty wynik" , __LINE__, __FILE__);
            return false;
        }
        
        mysqli_close($db_handle);
    }
    
    /**
     * Zaznacza dane z danej tabeli.  
     * selectData('users', array('username', 'mail'), array("id>2", "username='Jan'"), "AND");
     * 
     * @param type $TABLE - tabela - string
     * @param type $COLS - kolumny, które mają być zaznaczone - array /opcjonalnie - domyślnie('*')
     * @param type $WHERE - warunki dla jakich wiersze mają być zaznaczone - array()
     * @param type $OPER - operator łączący warunki - string /opcjonalnie - domyślnie "AND"
     * @return boolean or array
     */
    static public function selectData($TABLE, $COLS = array('*'), $WHERE=array(), $OPER="AND"){
        
        $db_handle = self::getConnection();
        
        $query = "SELECT ";

        if((count($COLS)) == 1){
            $query.= $COLS[0];
        } else {
            foreach ($COLS as $value) {
                $query.=$value.",";
            }
            $query = rtrim($query, ',');
        }
      
        $query.=" FROM $TABLE";
        
        if(isset($WHERE) && (count($WHERE))>0){
            $query.=" WHERE ";
            foreach ($WHERE as $value) {
                $query.=$value." ".$OPER." ";
            }
            $query = substr($query, 0, strlen($query)-(strlen($OPER)+2)); // usuwa ostatni operator
        }
        
        
//        echo "<br>".$query."<br>";
        $res = $db_handle->query($query);
        
        if(!$res){    
            LogFile::AddLog("Nastąpił błąd połączenia z bazą danych" , __LINE__, __FILE__);
            return false;      
        } else {
            $resArr = array();
            while (($row = $res->fetch_array(MYSQLI_ASSOC)) !== NULL) {
                $resArr[] = $row;
            }
        }

        if(count($resArr)>0){
            return $resArr;
        } else {
            LogFile::AddLog("Zapytanie bazodanowe zwróciło pusty wynik" , __LINE__, __FILE__);
            return false;
        }
        
        mysqli_close($db_handle);   
    }
    
    /**
     * Dodaje dane do tabeli.  
     * insertInto("users", array('username'=>'new_user', 'password'=>'pass');
     * 
     * @param type $TABLE - tabela, do której dodaje - string
     * @param type $DATA - tablica asocjacyjna (nazwa_kolumny=>value) - array
     * @return boolean
     */
    static public function insertInto($TABLE, $DATA=array()){
        
        $db_handle = self::getConnection();
        $query = "INSERT INTO {$TABLE} ";
        
        if(@array_key_exists('password',$DATA)){
            $DATA['password'] = md5($DATA['password']);
        }
        
        if(isset($DATA) && (count($DATA))>0){
            $query.="(";
            foreach ($DATA as $key => $value) {
                $query.=$key.",";
            }
            $query = rtrim($query,",");
            
            $query.=") VALUES (";
            
            foreach ($DATA as $key => $value) {
                $query.="'".$value."',";
            }
            $query = rtrim($query,",");
            $query.=")";
        }
        
        echo "<br>".$query."<br>";
        $res = $db_handle->query($query);
        
        if(!$res){
            LogFile::AddLog("Nastąpił błąd połączenia z bazą danych" , __LINE__, __FILE__);
            return false;
        } else {
            echo 'Użytkownik dodany';
            return true;
        }
         
        mysqli_close($db_handle);
    }
    
    /**
     * Uaktualnia tabele według wytycznych.  
     * updateTable("users", array('username'=>'updateUser'), array("id>3", "username='user'");
     * 
     * @param type $TABLE - tabela, którą uaktualnia - string
     * @param type $SET - tablica z updatami - array($key=>$value)
     * @param type $WHERE - tablica z warunkami do updatu - array()
     * @param type $OPER - operator łączący warunki - string /opcjonalnie - domyślnie "AND"
     * @return boolean
     */
    static public function updateTable($TABLE, $SET=array(), $WHERE=array(), $OPER="AND"){
    // UPDATE Customers SET ContactName='Alfred Schmidt', City='Hamburg' WHERE CustomerName='Alfreds Futterkiste';
        $db_handle = self::getConnection();
        $query = "UPDATE {$TABLE} ";
        
        if(isset($SET) && (count($SET))>0){
            $query.="SET ";
            foreach ($SET as $key => $value) {
                $query.= $key."='".$value."',";
            }
            $query = rtrim($query, ",");
        }
        
        if(isset($WHERE) && (count($WHERE))>0){
            $query.=" WHERE ";
            foreach ($WHERE as $value) {
                $query.=$value." ".$OPER." ";
            }
            $query = substr($query, 0, strlen($query)-(strlen($OPER)+2)); // usuwa ostatni operator
        }
        echo $query."<br><br>";
        $res = $db_handle->query($query);
        
        if(!$res){
            LogFile::AddLog("Nastąpił błąd połączenia z bazą danych" , __LINE__, __FILE__);
            return false;
        } else {
            return true;
        }
        mysqli_close($db_handle);
    }
    
    /**
     * Usuwa dane wiersze w tabeli.  
     * deleteFrom('users', array("id>3", "username='new_user'"), "AND")
     * 
     * @param type $TABLE - tabela, z której usuwa - string
     * @param type $WHERE - tablica z warunkami do usunięcia - array()
     * @param type $OPER - operator łączący warunki - string /domyślnie "AND"
     * @return boolean
     */
    static public function deleteFrom($TABLE, $WHERE=array(), $OPER="AND"){
    // DELETE FROM Customers WHERE CustomerName='Alfreds Futterkiste' AND ContactName='Maria Anders';
        $db_handle = self::getConnection();
        $query = "DELETE FROM {$TABLE}";
        
        if(isset($WHERE) && (count($WHERE))>0){
            $query.=" WHERE ";
            foreach ($WHERE as $value) {
                $query.=$value." ".$OPER." ";
            }
            $query = substr($query, 0, strlen($query)-(strlen($OPER)+2)); // usuwa ostatni operator
        }
        
        echo $query."<br><br>";
        $res = $db_handle->query($query);
        
        if(!$res){
            LogFile::AddLog("Nastąpił błąd połączenia z bazą danych" , __LINE__, __FILE__);
            return false;
        } else {
            return true;
        }
        mysqli_close($db_handle);
    }
} 