<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Unplagged_Helper
{
    /**
     * Generates a random hash.
     * 
     * @return The hashed string.
     */
    public static function generateRandomHash() {        
        return substr(sha1(uniqid (rand())), 0, 32); ;
    }
    
    /**
     * Hash a string.
     * 
     * @String $string The unhashed string.
     * 
     * @return The hashed string.
     */
    public static function hashString($string) {
        return sha1($string);
    }
    
    /**
     * Checks if a string matches a hash using the same function the hash was created.
     * 
     * @String $string The unhashed string.
     * @String $hash The hash.
     * 
     * @return Whether the string matches the hash or not.
     */
    public static function checkStringAndHash($string, $hash) {
        return $hash == $this->hashString($string);
    }
    
}
?>
