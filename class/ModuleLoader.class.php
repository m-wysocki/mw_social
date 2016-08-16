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
                $logged = '<div id="logged-info">
                        <p>Zalogowano jako: '.$_SESSION['login'].'</p>
                        <a href="logout/" class="btn btn-default" id="btn-logout" role="button">Wyloguj</a>
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
            echo'<div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                      <!--<li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>-->
                      <li><a href="articles/">Artykuły</a></li>
                      <li><a href="my-articles/">Moje artukuły</a></li>
                    </ul>
                      
                    <ul class="nav nav-sidebar">
                      <li><a href="add-article/">Dodaj artykuł</a></li>                    
                    </ul>
                      
                    <ul class="nav nav-sidebar">
                      <li><a href="">Moje konto</a></li>                    
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
                            <footer>Autor: <a href="">'.$author[0]['username'].'</a><br><br>
                            <a href="read-article/'.$article['id'].'/">Czytaj dalej...</a>'.$delete.'</footer>
                        </blockquote>
                      </div>';
            }
            echo '</div>';
            break;
            
        case 'my-articles':
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
            
            $userId = DBManager::selectData("users", array('id'), array("username='{$_SESSION['login']}'"));
            $resArr = DBManager::selectData("articles", array("*"), array("id_user={$userId[0]['id']}"));

            foreach ($resArr as $article) {
                $author = DBManager::selectData("users", array('username'), array("id={$article['id_user']}"));
                echo '<div class="well">
                            <h3>'.$article['title'].'</h3>
                            <blockquote>
                                <p>'.$article['intro'].'</p>
                                <footer>Autor: <a href="">'.$author[0]['username'].'</a><br><br>
                                    <a href="read-article/'.$article['id'].'/">Czytaj dalej...</a>
                                    <br><a href="delete-article/'.$article['id'].'/" id="deleteArticle">Usuń artykuł</a>
                                </footer>
                            </blockquote>
                        </div>';
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
                                <footer>Autor: <a href="">'.$author[0]['username'].'</a>'.$delete.'</footer>
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
    }
}
}