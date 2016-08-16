<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */
$mt = new MetaTags($_GET['page'], null, null, null, null, null, 'bootstrap,styles', 'MW_icona', "jquery.min,bootstrap.min");

echo '<body>';

AddonLoader::load('register');

ModuleLoader::load('header');

echo<<<PL

    <div id="main">
        <div class="container-fluid">
        
PL;

if(!(isset($_SESSION['logged'])) || $_SESSION['logged']===false){ 
    ModuleLoader::load('form');
} else {
    header("Location: ".SERVER_ADDRESS."articles/");
}

echo<<<PL
        </div>
    </div>
PL;

ModuleLoader::load('footer');
$_SESSION['login_error'] = false;
$_SESSION['register_success'] = NULL;

echo<<<PL
    </body>
    </html>
PL;

?>