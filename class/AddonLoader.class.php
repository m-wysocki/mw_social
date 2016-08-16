<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */

class AddonLoader{
    
    public static $javaScriptBegin = "<script type=\"text/javascript\">\n\n";
    public static $javaScriptEnd = "\n\n</script>\n\n";
    public static $jQueryBegin = "\$(function() {\n\n";
    public static $jQueryEnd = "\n});\n\n";
    
    public static function register(){
        $register = '
            var cliked;
            clicked = true;
            $( "#registration" ).on( "click", function() {
                
                switch(clicked){
                    case true:
                        $( "#pass2" ).append("<label for=\'pwd\'>Powtórz hasło: </label><input type=\'password\' class=\'form-control\' id=\'pwd\' required>");
                        $( "#email" ).append("<label for=\'email\'>Adres e-mail:</label><input type=\'email\' class=\'form-control\' id=\'email\' name=\'mail\' required>");
                        $( "#btn-reg" ).html("Zarejestruj");
                        $( "#form" ).attr("action", "register/");
                        $("#registration a").text("Masz konto? Zaloguj się!");
                        
                        var password = document.getElementById("pass1");
                        var confirm_password = document.getElementById("pwd");

                        function validatePassword(){
                          if(password.value != confirm_password.value) {
                            confirm_password.setCustomValidity("Hasła muszą być takie same");
                          } else {
                            confirm_password.setCustomValidity(\'\');
                          }
                        }

                        password.onchange = validatePassword;
                        confirm_password.onkeyup = validatePassword;
            
                        clicked = false;
                        break;
                        
                    case false:
                        $("#pass2").empty();
                        $("#email").empty();
                        $( "#btn-reg" ).html("Zaloguj");
                        $( "#form" ).attr("action", "login/");
                        $("#registration a").text("Nie masz konta? Zarejestruj się!");
                        clicked = true;
                        break;
                }
            });
        ';
        return $register;   
    }
    
    
    public static function load($variable){
        switch($variable) {
            
            case "register":
                echo self::$javaScriptBegin;
                echo self::$jQueryBegin;
                
                echo self::register();
                
                echo self::$jQueryEnd;
                echo self::$javaScriptEnd;
            break; 
        }
    }

}