<?php

/**
 * @author Mateusz Manaj
 * @company Eduweb.pl™ 2011 ©
 * @email mateusz@eduweb.pl
 * --------------------------------------------------
 * All rights reserved! | Wszystkie Prawa Zastrzeżone!
 *
 */

/**
 * KLASA LogFile
 * 
 * @package CLASS.Log
 * @access public
 * @author Mateusz Manaj <mateusz@eduweb.pl>
 * @license http://www.eduweb.pl/
 * @version 2.1.0
 * @copyright Eduweb™ 2011
 * @param OPIS KLASY:
 * @param Klasa stosowana do obsługi zdarzeń w serwisie. 
 * @param Za jej pomocą zapiszesz nie przewidziane wyjątki systemu do pliku *.log
 */
class LogFile {
    
    /**
     * LogFile::AddLog()
     * 
     * @param mixed $logText    Konieczny parametr treści dziennika, czyli tego co chcesz w nim zapisać
     * @param bool  $filename   Opcjonalna nazwa pliku z logiem
     * @return void
     */
    static public function AddLog($logText, $line = 0, $script_name = false, $filename = false) {
            
        $ip = $_SERVER['REMOTE_ADDR'];  
        $time = date('H:i:s');
        $line = ($line == 0) ? "" : "[linia #{$line}]";
        $script_name = ($script_name === false) ? "" : "[plik $script_name]";
        
        if($filename === false) { $filename = LogFolder.date("d_m_Y")."-log.log"; }
        
        if(file_exists($filename)) {
            $fh = fopen($filename, "a") or die("nie moge zapisać!");
        } else {
            $fh = fopen($filename, "w") or die("nie moge zapisać!");
            fwrite($fh, "Plik dziennika [ ".date("d/m/Y")." ]\n---------------------------------------\n\n");  
        }
        
        fwrite($fh, "+ [$time][$ip]$script_name$line: $logText\n");
        fclose($fh); 
        
    }
    
}

?>