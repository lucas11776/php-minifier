<?php
/**
 * Simple Algo to minifier js and css code
 * 
 * Developer : Themba Lucas Ngubeni
 * 
 * @docs
 * 
 * require_once 'minifier.class.php';
 * 
 * $code = 'Some javascript or css code to minifier';
 * 
 * $minifier = new Minifier();
 * 
 * // minifier code
 * $minifiered = $minifier->min($code);
 * 
 * // remove single line comment
 * $not_comments = $minifier->remove_comments($code);
 * 
 * @version 1.0
 * @copyright themba.website
*/

class Minifier
{
    private const NEW_LINE = [
        "\0", "\t", "\n", "\x0b", "\r"
    ];
    private const CHARACTORS = [
        'q','w','e','r','t','y','u',
        'i','o','p','a','s','d','f',
        'g','h','j','k','l','z','x',
        'c','v','b','n','m','_','$'
    ];

    /**
     * Minifier text
     * 
     * @param string text
     * @return boolean
    */
    public function min($text)
    {
        if(!is_string($text)){
            return false;
        }

        // store cleaned text string
        $clean_text = '';
        
        // removes comments from text
        $text = $this->remove_comments($text);

        for($i = 0; $i < strlen($text); $i++){
            $prev = $text[$i-1] ?? '';  // shift one unit backward
            $current = $text[$i] ?? '';
            $next = $text[$i+1] ?? '';  // shift one unit forward

            // check if char is not new line
            if(!in_array($current, $this::NEW_LINE)){
                // check if char is not empty space
                if($current != ' '){
                    $clean_text .= $current;
                }
                else{
                    // check if next char is not empty space
                    if($next != ' '){
                        // check if prev and next are charactors
                        if(in_array(strtolower($prev), $this::CHARACTORS) && in_array(strtolower($next), $this::CHARACTORS)){
                            $clean_text .= $current;
                        }
                    }
                }
            }

        }

        return $clean_text;
    }

    /**
     * Remove single line comments
     * 
     * @param string text
     * @return string
    */
    public function remove_comments($text)
    {
        if(!is_string($text)){
            return false;
        }
        
        // string with no comments
        $clean_text = '';
        
        // keep track comment start and end
        $is_comment = false;

        for($i = 0; $i < strlen($text); $i++){
            // next element
            $next = $text[$i+1] ?? '';
            $comment = ($text[$i] ?? '') . $next;

            // check if current item and next are single line comment
            if($comment == '//' && $is_comment == false){
                $is_comment = true;
            }else{
                // check if not comment
                if(!$is_comment){
                    $clean_text .= $text[$i];
                }else{
                    // check if new line
                    if(in_array($text[$i], $this::NEW_LINE)){
                        $is_comment = false;
                    }
                }
            }
        }

        return $clean_text;
    }

}

?>