<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */

class ModuleLoader{
    
    public static function load($variable){
    
        switch ($variable) {
            
        case 'header':
            
            if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
                $users = DBManager::selectData("users", array("*"), array("username='{$_SESSION['login']}'"));
                $avatar = '<div id="avatar"><img src="img/profiles/'.$users[0]['photo'].'" class="img-rounded" alt="Cinque Terre" width="100" height="100"></div>';
                $logged = '<div id="logged-info">'
                        .$avatar.
                        '<div id="logged-info-text"><p>Zalogowano jako: </br></br>'.$_SESSION['login'].'</p>
                        <a href="logout/" class="btn btn-default" id="btn-logout" role="button">Wyloguj</a></div>
                    </div>';
            } else {
                $logged = "";
            }
            
            echo 
            '<div id="header">
                <div class="container">
                    <h1><a href="#">MW_Social</a></h1>
                    '.$logged.'
                </div>
            </div>';

            break;

        case 'form':
            if(isset($_SESSION['login_error']) && $_SESSION['login_error']===true){
                
                $info = "Błędny login lub hasło. Spróbuj ponownie";
                
            } else {
                
                if(isset($_SESSION['register_success'])){
                    if($_SESSION['register_success']===true){
                        $info = "Rejestracja przebiegła pomyślnie. Proszę się zalogować";
                    } else {
                        $info = "Użytkownik o takiej nazwie już istnieje. Proszę spróbować ponownie";
                    }              
                } else {
                    $info = "";
                }
            }
            
            echo '  <div class="row">
                        <div class="col-md-6">
                            <div class="container-fluid">
                                <div id="info">'.$info.'</div>
                                <p></p>
                                <form data-toggle="validator" role="form" method="POST" id="form" action="login/">                  
                                    <div class="form-group">
                                        <label for="name">Nazwa użytkownika</label>
                                        <input type="text" class="form-control" id="name" name="login" minlength="3" maxlength="20" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="pwd">Hasło</label>
                                        <input type="password" class="form-control" id="pass1" name="password" minlength="3" required>
                                    </div>

                                    <div class="form-group" id="pass2"></div>

                                    <div class="form-group" id="email"></div>

                                    <button type="submit" class="btn btn-default" id="btn-reg">Zaloguj</button>
                                    <div id="registration"><a>Nie masz konta? Zarejestruj się!</a></div>

                                </form>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="container-fluid">
                                <div class="slogan">
                                    <h2>Zaloguj się!</h2>
                                    <p>Jeżeli jeszcze nie posiadasz konta w naszym serwisie - zarejestruj się.<p>
                                </div>
                            </div>
                        </div> 
                    </div>';

            break; 
        
        case 'footer':
            echo '<footer class="footer">
                    <div class="container">
                          <div class="navbar-header">
                            <a class="navbar-brand" href="#">Copyright © 2016 Mateusz Wysocki</a>
                          </div>
                         <ul class="nav navbar-nav">
                            <li><a href="#">Page 1</a></li>
                            <li><a href="#">Page 2</a></li> 
                            <li><a href="#">Page 3</a></li>
                            <li><a href="#">Page 4</a></li>
                            <li><a href="#">Page 5</a></li>
                          </ul>          
                    </div>
                </footer>';
        break;
    
        case 'sidebar':
            $userId = DBManager::selectData("users", array('id'), array("username='{$_SESSION['login']}'"));
            echo'<div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                      <!--<li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>-->
                      <li><a href="articles/">Artykuły</a></li>
                      <li><a href="articles-from/'.$userId[0]['id'].'/">Moje artukuły</a></li>
                      <li><a href="follow-articles/">Artykuły obserwowanych</a></li> 
                    </ul>
                      
                    <ul class="nav nav-sidebar">
                      <li><a href="users-list/">Lista użytkowników</a></li>  
                      <li><a href="follow-list/">Lista obserwowanych</a></li>  
                    </ul>
                      
                    <ul class="nav nav-sidebar">
                      <li><a href="add-article/">Dodaj artykuł</a></li>
                      <li><a href="profile/'.$userId[0]['id'].'/">Moje konto</a></li>                    
                    </ul>
                    
                  </div>';
            
            break;
        
        case 'articles':
            if(isset($_SESSION['delete_success'])){
                    if($_SESSION['delete_success']===true){
                        $infoDel = '<div class="well"><div id="info">Artykuł został usunięty.</div></div>';
                    } else {
                        $infoDel = '<div class="well"><div id="info">Błąd. Artykuł nie może zostać usunięty.</div></div>';
                    }              
                } else {
                    $infoDel = "";
            }
            
            echo '<div class="articles">'.$infoDel;
            $resArr = DBManager::selectData("articles");

            foreach ($resArr as $article) {
                $author = DBManager::selectData("users", array('username'), array("id={$article['id_user']}"));
                if($author[0]['username'] == $_SESSION['login']){
                    $delete = '<br><a href="delete-article/'.$article['id'].'/" id="deleteArticle">Usuń artykuł</a>';
                } else {
                    $delete = '';
                }

                echo '<div class="well">
                        <h3>'.$article['title'].'</h3>
                        <blockquote>
                            <p>'.$article['intro'].'</p>
                            <footer>Autor: <a href="profile/'.$article['id_user'].'/">'.$author[0]['username'].'</a><br><br>
                            <a href="read-article/'.$article['id'].'/">Czytaj dalej...</a>'.$delete.'</footer>
                        </blockquote>
                      </div>';
            }
            echo '</div>';
            break;
            
        case 'articles-from':
            if(isset($_SESSION['delete_success'])){
                    if($_SESSION['delete_success']===true){
                        $infoDel = '<div class="well"><div id="info">Artykuł został usunięty.</div></div>';
                    } else {
                        $infoDel = '<div class="well"><div id="info">Błąd. Artykuł nie może zostać usunięty.</div></div>';
                    }              
                } else {
                    $infoDel = "";
            }
            
            echo '<div class="articles">'.$infoDel;
            
//            $userId = DBManager::selectData("users", array('id'), array("username='{$_SESSION['login']}'"));
            $resArr = DBManager::selectData("articles", array("*"), array("id_user={$_GET['id']}"));
            
            if($resArr != null && count($resArr)>0){
                
                foreach ($resArr as $article) {
                    
                    $author = DBManager::selectData("users", array('username'), array("id={$article['id_user']}"));
                    
                    if($_SESSION['login']==$author[0]['username']){
                        $delete = '<br><a href="delete-article/'.$article['id'].'/" id="deleteArticle">Usuń artykuł</a>';
                    } else {
                        $delete = "";
                    }
                    
                    echo '<div class="well">
                                <h3>'.$article['title'].'</h3>
                                <blockquote>
                                    <p>'.$article['intro'].'</p>
                                    <footer>Autor: <a href="profile/'.$article['id_user'].'">'.$author[0]['username'].'</a><br><br>
                                        <a href="read-article/'.$article['id'].'/">Czytaj dalej...</a>
                                        '.$delete.'
                                    </footer>
                                </blockquote>
                            </div>';
                    } 
            } else {
                
                echo '<div id="info">Ten użytkownik nie utworzył jeszcze artykułu.<br></div>';
            }
            echo '</div>';
        break;
        
        case 'read-article':
            echo '<div class="articles">';
            $resArr = DBManager::selectData("articles", array("*"), array("id={$_GET['id']}"));

            foreach ($resArr as $article) {
                $author = DBManager::selectData("users", array('username'), array("id={$article['id_user']}"));
                if($author[0]['username'] == $_SESSION['login']){
                    $delete = '<br><a href="delete-article/'.$article['id'].'/" id="deleteArticle">Usuń artykuł</a>';
                } else {
                    $delete = '';
                }
                echo '<div class="container-fluid">
                            <h3>'.$article['title'].'</h3>
                            <p>'.$article['intro'].'</p><br/>
                            <p>'.$article['text'].'</p><br/>
                            <blockquote>
                                <footer>Autor: <a href="profile/'.$article['id_user'].'">'.$author[0]['username'].'</a>'.$delete.'</footer>
                            </blockquote>
                        </div>';
            }
            echo '</div>';
        break;

        case 'add-article':
            if(isset($_SESSION['adding_success'])){
                    if($_SESSION['adding_success']===true){
                        $infoArt = "Artykuł został dodany.";
                    } else {
                        $infoArt = "Błąd. Artykuł nie został dodany. Proszę spróbować ponownie";
                    }              
                } else {
                    $infoArt = "";
            }
            
            echo '<div class="articles">
                    <div class="container-fluid">
                        <div id="info">'.$infoArt.'</div>
                        <p></p>
                        <form data-toggle="validator" role="form" method="POST" id="add-article-form" action="adding-article/">                  
                            <div class="form-group">
                                <label for="title">Tytuł artykułu</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>

                            <div class="form-group">
                                <label for="intro">Wstęp do artukułu (wyświetlany na liście artykułów)</label>
                                <textarea type="text" rows="2" class="form-control" name="intro" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="comment">Treść artykułu</label>
                                <textarea type="text" rows="5" class="form-control" name="txt" id="comment" required></textarea>
                            </div>

                            <input type="text" name="author" value="'.$_SESSION['login'].'" hidden>
                            <button type="submit" class="btn btn-default" id="btn-reg">Dodaj artykuł</button>

                        </form>
                    </div></div>';
            break;
            
        case 'users-list':
                                 
            $resArr = DBManager::selectData("users");
            $userId = DBManager::selectData("users", array('id'), array("username='{$_SESSION['login']}'"));
            
            echo '<div class="articles">';
            
            foreach ($resArr as $user) {
                
                $um = new UserManager();
                $resFollow = $um->isFollowed($userId[0]['id'], $user['id']);
                if(!$resFollow){
                    if($user['username'] === $_SESSION['login']){
                        $followButton = "";
                    } else {
                        $followButton = '<form action="follow/" method="POST">
                                                <input type="hidden" name="followed_id" value="'.$user['id'].'"></input>
                                                <input type="submit" class="btn btn-warning" value="Obserwuj użytkownika"></input>
                                            </form> 
                                            </br>';
                    }
                } else {
                    $followButton = '<form action="delete-follow/" method="POST">
                                            <input type="hidden" name="followed_id" value="'.$user['id'].'"></input>
                                            <input type="submit" class="btn btn-warning" value="Przestań obserwować użytkownika"></input>
                                        </form> 
                                        </br>';
                }
                
                echo '<div class="well">
                            <blockquote>    
                                <div class="row">                        
                                        <div class="col-sm-2" id="list-avatar"><img src="img/profiles/'.$user['photo'].'" class="img-rounded" alt="Cinque Terre" width="75" height="75"></div>
                                        <div class="col-sm-4" id="list-name"><a href="profile/'.$user['id'].'">'.$user['username'].'</a></div>
                                        <div class="col-sm-2" id="list-name">'.$followButton.'</div>

                                </div>
                            </blockquote>
                        </div>';
            }
            echo '</div>';
            
            break;
            
        case 'profile':
            
            if(isset($_SESSION['adding_success'])){
                    if($_SESSION['adding_success']===true){
                        $infoUpload = "Zdjęcie zostało dodane.";
                    } else {
                        $infoUpload = "Błąd. Zdjęcie nie zostało dodane. Proszę spróbować ponownie";
                    }              
                } else {
                    $infoUpload = "";
            }
            
            if(isset($_SESSION['deleting_success'])){
                    if($_SESSION['deleting_success']===true){
                        $infoDel = "Zdjęcie zostało usunięte.";
                    } else {
                        $infoDel = "Błąd. Zdjęcie nie zostało usunięte. Proszę spróbować ponownie";
                    }              
                } else {
                    $infoDel = "";
            }
                       
            echo '<div class="articles">';
            $userId = DBManager::selectData("users", array('id'), array("username='{$_SESSION['login']}'"));
            $resArr = DBManager::selectData("users", array("*"), array("id={$_GET['id']}"));
            
            foreach ($resArr as $user) {
                          
                $um = new UserManager();
                
                $resFollow = $um->isFollowed($userId[0]['id'], $user['id']);
                if(!$resFollow){
                    $followButton = '<form action="follow/" method="POST">
                                            <input type="hidden" name="followed_id" value="'.$user['id'].'"></input>
                                            <input type="submit" class="btn btn-warning" id="follow-button" value="Obserwuj użytkownika"></input>
                                        </form> 
                                        </br>';
                } else {
                    $followButton = '<form action="delete-follow/" method="POST">
                                            <input type="hidden" name="followed_id" value="'.$user['id'].'"></input>
                                            <input type="submit" class="btn btn-warning" id="follow-button" value="Przestań obserwować użytkownika"></input>
                                        </form> 
                                        </br>';
                }
                
                if($user['username'] === $_SESSION['login']){
                    $photo_form = '<form role="form" enctype="multipart/form-data" action="adding-photo/" method="post" id="add-photo-form">
                            <div class="form-group">
                                <label class="btn btn-primary" for="my-file-selector">Wybierz plik
                                    <input id="my-file-selector" type="file" name="plik" style="display:none;" onchange="$(\'#upload-file-info\').html($(this).val());">
                                </label>
                            </div>
                            <div class="form-group">
                                 <span class="label label-info" id="upload-file-info"></span>
                            </div>
                            <div class="form-group" id="add-photo-button">
                                <input type="submit" class="btn btn-default" value="Dodaj zdjęcie"></input>
                                <a href="deleting-photo/" class="btn btn-default" role="button">Usuń zdjęcie</a>
                            </div>

                        </form> ';
                    $followButton = "<br>";
                } else {
                    $photo_form = "";
                    
                }
            
                echo '<div class="row">
                            <div class="col-sm-4">
                                <div id="profile-photo">
                                    <div id="info-upload">'.$infoUpload.$infoDel.'</div>
                                    <img src="img/profiles/'.$user['photo'].'" class="img-rounded" alt="Cinque Terre" width="150" height="150">
                                </div>
                                '.$photo_form.'
                            </div>
                            <div class="col-sm-8">
                                <div id="profile-info">
                                    <p id="user-name">'.$user['username'].'</p>
                                    '.$followButton.'
                                    <a href="articles-from/'.$user['id'].'">Wyświetl artykuły użytkownika.</a></br></br>
                                    <a href="">Wyślij e-mail do użytkownika.</a></br>    
                                </div>
                            </div> 
                        </div>';
            }
            echo '</div>';
        break;
        
        case 'follow-list':

            $userId = DBManager::selectData("users", array('id'), array("username='{$_SESSION['login']}'"));
            $resArrFollow = DBManager::selectData("follow", array("followed_id"), array("logged_id={$userId[0]['id']}"));
            
            echo '<div class="articles">';
            
            if(is_array($resArrFollow) && (count($resArrFollow)) > 0) {
                foreach ($resArrFollow as $follow) {
                    $user = DBManager::selectData("users", array("*"), array("id={$follow['followed_id']}"));

                    $um = new UserManager();
                    $resFollow = $um->isFollowed($userId[0]['id'], $user[0]['id']);
                    if($resFollow){
                        $followButton = '<form action="delete-follow/" method="POST">
                                                <input type="hidden" name="followed_id" value="'.$user[0]['id'].'"></input>
                                                <input type="submit" class="btn btn-warning" value="Przestań obserwować użytkownika"></input>
                                            </form> 
                                            </br>';
                    } else {
                        $followButton = "";
                    }

                    echo '<div class="well">
                                <blockquote>    
                                    <div class="row">                        
                                            <div class="col-sm-2" id="list-avatar"><img src="img/profiles/'.$user[0]['photo'].'" class="img-rounded" alt="Cinque Terre" width="75" height="75"></div>
                                            <div class="col-sm-4" id="list-name"><a href="profile/'.$user[0]['id'].'">'.$user[0]['username'].'</a></div>
                                            <div class="col-sm-2" id="list-name">'.$followButton.'</div>

                                    </div>
                                </blockquote>
                            </div>';
                }
            } else {
                echo '<div id="info-upload">Nie obserwujesz żednego użytkownika.</div>';
            }
            echo '</div>';
                
            break;
            
        case 'follow-articles':
            
            $userId = DBManager::selectData("users", array('id'), array("username='{$_SESSION['login']}'"));
            $resArrFollow = DBManager::selectData("follow", array("followed_id"), array("logged_id={$userId[0]['id']}"));
            
            echo '<div class="articles">';
//            echo '<pre>'.print_r($resArrFollow).'</pre>';
            if(is_array($resArrFollow) && (count($resArrFollow)) > 0) {
                foreach ($resArrFollow as $follow) {
                    $article = DBManager::selectData("articles", array("*"), array("id_user={$follow['followed_id']}"));

                    if((count($article[0])) > 0) {
                        $author = DBManager::selectData("users", array('username'), array("id={$article[0]['id_user']}"));
                        echo '<div class="well">
                                <h3>'.$article[0]['title'].'</h3>
                                <blockquote>
                                    <p>'.$article[0]['intro'].'</p>
                                    <footer>Autor: <a href="profile/'.$article[0]['id_user'].'/">'.$author[0]['username'].'</a><br><br>
                                    <a href="read-article/'.$article[0]['id'].'/">Czytaj dalej...</a></footer>
                                </blockquote>
                              </div>';
                    } else {
                        echo '<div id="info-upload">Obserwowani przez Ciebie użytkownicy nie dodali jeszcze artukułów.</div>';
                    }
                }
            } else {
                echo '<div id="info-upload">Nie obserwujesz żednego użytkownika.</div>';
            }
            echo '</div>';
            break;
    }
}
}