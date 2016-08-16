<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */

/**
 * Opis klasy MetaTags.
 *
 * @package CLASS.Managers.MetaManager
 * @access public
 * @param string $PAGE Zmienna przechowuje dane o nazwie aktualnie przegladanej stronie
 * @param string $doctype xHTML->doctype
 * @param string $title xHTML->title
 * @param string $content_type xHTML->content_type
 * @param string $keywords xHTML->keywords
 * @param string $description xHTML->description
 * @param string $style xHTML->style
 * @param string $icon xHTML->icon
 * @param string $JS xHTML->JavaScript
 * @return void
 * @var string
 */

class MetaTags {
	
    public $PAGE;
    public $doctype;
    public $title;
    public $content_type;
    public $keywords;
    public $description;
    public $style;
    public $icon;
    public $JS;
	
    /**
     * KONSTRUKTOR KLASY | THE CLASS CONSTRUCTOR
     */
	
    public function __construct($PAGE, $doctype, $title, $content_type, $keywords, $description, $style, $icon, $JS) {

        $this->PAGE = $PAGE;
        $this->doctype = $doctype;
        $this->title = $title;
        $this->content_type = $content_type;
        $this->keywords = $keywords;
        $this->description = $description;
        $this->style = $style;
        $this->icon = $icon;
        $this->JS = $JS;

        /**
         * DEFINICJA METOD PUBLICZNYCH | DEFINITION OF PUBLIC METHODS
         * 
         * @param SetDoctype Ustawia [ xHTML->doctype ] DocType
         * @param SetTitle Ustawia [ xHTML->doctype ] Tytul
         * @param SetContent_type Ustawia [ xHTML->doctype ] Typ tresci
         * @param SetKeywords Ustawia [ xHTML->doctype ] Slowa kluczowe
         * @param SetDescription Ustawia [ xHTML->doctype ] Opis strony
         * @param SetStyle Ustawia [ xHTML->doctype ] Styl [ $nazwa_pliku, $nazwa_pliku2... ]
         * @param SetIcon Ustawia [ xHTML->doctype ] Ikone [ $nazwa_ikony, $nazwa_ikony2... ]
         * @param SetJS Ustawia [ xHTML->doctype ] Plik skryptowy [ $nazwa_pliku, $nazwa_pliku2... ]
         * 
         */

        $this->SetDoctype();
        $this->SetTitle();
        $this->SetContent_type();
        $this->SetKeywords();
        $this->SetDescription();
        $this->SetStyle();
        $this->SetIcon();
        $this->SetJS();

    }

    /**
     * METODA SetDoctype() | SetDoctype() METHOD
     * @access public
     * @param 
     * @return string
     * @var string
     */
	
    public function SetDoctype() {

        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">';
    }
	
    /**
     * METODA SetTitle() | SetTitle() METHOD
     * @access public
     * @param $this->PAGE [ Nazwa strony ]
     * @return string
     * @var string
     */

    public function SetTitle() {

        if(!$this->title) {

            $this->title = 'MW Social - serwis społecznościowy';
        }
        echo '<head>'
        . '<title>'.$this->title.'</title>';
    }
	
    /**
     * METODA SetContent_type() | SetContent_type() METHOD
     * @access public
     * @param $this->content_type [ Typ tresci ]
     * @return string
     * @var string
     */

    public function SetContent_type() {

        if (!($this->content_type)) {
            echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8" />';   
        }else{ 
            echo '<meta http-equiv="content-type" content="text/html; charset='.$this->content_type.'" />';
         }
    }

    /**
     * METODA SetKeywords() | SetKeywords() METHOD
     * @access public
     * @param $this->keywords [ Slowa kluczowe witryny ]
     * @return string
     * @var string
     */

    public function SetKeywords() {

        if (!($this->keywords)) {
            echo '<meta name="keywords" content="MW Social" />';    
        }else{  
            echo '<meta name="keywords" content="'.$this->keywords.'" />';           
        }
    }
	
    /**
     * METODA SetDescription() | SetDescription() METHOD
     * @access public
     * @param $this->description [ Generuje opis witryny ]
     * @return string
     * @var string
     */

    public function SetDescription() {

        if (!($this->description)) {
            echo '<meta name="description" content="MW Social - serwis społecznościowy" />';
        }else{
            echo '<meta name="description" content="'.$this->description.'" />';
        }
    }
   
    /**
     * METODA SetStyle() | SetStyle() METHOD
     *
     * @access public
     * @param $this->style [ Korzystajc ze natywnego adrsu witryny, ustawiane zostaja poszczegolne sciezki dostepu do dolaczanych plików ]
     * @return string
     * @var string
     */

    public function SetStyle() {
        if($this->style){
            echo '<base href="'.SERVER_ADDRESS.'">';

            $tab = $this->style;

            $ex = explode(",", $tab);

            $ile = count($ex);

            for($i=0; $i<$ile; $i++) {
                echo '<link rel="stylesheet" href="css/'.$ex[$i].'.css" type="text/css" />';           
            }
        }
    }

    /**
     * METODA SetIcon() | SetIcon() METHOD
     *
     * @access public
     * @param $this->icon [ Nazwa pliku ikony (bez rozszerzenia pliku) ]
     * @return string
     * @var string
     */

    public function SetIcon() {

        if ($this->icon) {
            echo '<link rel="shortcut icon" href="'.$this->icon.'.ico" />';
        }
    }

    /**
     * METODA SetJS() | SetJS() METHOD
     *
     * @access public
     * @param $this->JS [ Nazwa pliku ze skryptami ]
     * @return string
     * @var string
     */

    public function SetJS() {
        if($this->JS){
            $tab = $this->JS;

            $ex = explode(",", $tab);

            $ile = count($ex);

            for($i=0; $i<$ile; $i++) {
                echo '<script type="text/javascript" src="JS/'.$ex[$i].'.js"></script>';
            }
        }
        echo '</head>';
    }	
}

?>