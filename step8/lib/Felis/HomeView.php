<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/12/2017
 * Time: 7:23 PM
 */

namespace Felis;

class HomeView extends View{
    //arrays of testimonials
    private $leftTestimonials;
    private $rightTestimonials;

    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct() {
        $this->setTitle("Felis Investigations");
        $this->addLink("login.php", "Log in");
    }

    /**
     * Add content to the header
     * @return string Any additional comment to put in the header
     */
    protected function headerAdditional() {
        return <<<HTML
<p>Welcome to Felis Investigations!</p>
<p>Domestic, divorce, and carousing investigations conducted without publicity. People and cats shadowed
    and investigated by expert inspectors. Katnapped kittons located. Missing cats and witnesses located.
    Accidents, furniture damage, losses by theft, blackmail, and murder investigations.</p>
<p><a href="">Learn more</a></p>
HTML;
    }

    public function testimonials(){
        $html = '';
        if( sizeof($this->leftTestimonials) != 0 ){
            $html = <<<HTML
<section class="testimonials">
    <h2>TESTIMONIALS</h2>
    <div class="left">
HTML;
            foreach($this->leftTestimonials as $left){
                $html.= $left;
            }
            $html .= "</div>";
            if( sizeof($this->rightTestimonials) != 0 ){
                $html .= "<div class=\"right\">";
                foreach($this->rightTestimonials as $right){
                    $html.=$right;
                }
                $html .= "</div>";
            }
            $html .= <<<HTML
</section>
HTML;
        }
    return $html;
    }

    public function addTestimonial($message, $author){
        //left empty, add to left
        if( sizeof($this->leftTestimonials) == 0 ){
            $target =& $this->leftTestimonials;
        }
        //right empty, add to right
        else if( sizeof($this->rightTestimonials) == 0 ){
            $target =& $this->rightTestimonials;
        }
        //left odd, add to left
        else if(sizeof($this->leftTestimonials)%2 != 0){
            $target =& $this->leftTestimonials;
        }
        //right odd, add to right
        else if(sizeof($this->rightTestimonials)%2 != 0){
            $target =& $this->rightTestimonials;
        }
        //both odd, add to left
        else{
            $target =& $this->leftTestimonials;
        }
        $target[] = "
            <blockquote>
                <p> ". $message ."</p>
                <cite> ". $author ."</cite>
            </blockquote>
        ";
    }
}