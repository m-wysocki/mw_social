<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */
$mt = new MetaTags($_GET['page'], null, null, null, null, null, 'bootstrap,styles', 'MW_icona', "jquery.min,bootstrap.min");

echo '<body>';

ModuleLoader::load('header');

echo<<<PL
    <div id="main">
        <div class="container-fluid">
            <div class="row">       
PL;
if((isset($_SESSION['logged'])) && $_SESSION['logged']===true && isset($_GET['id'])){ 
    ModuleLoader::load('sidebar');
    ModuleLoader::load('read-article');
} else {
    header("Location: ".SERVER_ADDRESS."home/");
}
                
echo<<<PL
            </div>
        </div>
    </div>
PL;

ModuleLoader::load('footer');

echo<<<PL
    </body>
    </html>
PL;

?>