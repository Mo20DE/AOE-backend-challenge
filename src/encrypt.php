<?php
/** 
 *    /-- Task 2.1 --/
 *    Encrypts a string by shifting the letters by the value of key.
 */
function deeSeeChiffre(string $name, int $key) {

    $name_chars = str_split($name);
    $all_letters = range("a", "z");
    $encrypted_name = "";

    foreach ($name_chars as $char) {
        if ($char === " ") {
            $encrypted_name .= $char;
        } 
        else {
            $char_idx = ord($char) - 97;
            $shifted_char = $all_letters[($char_idx + $key) % 26];
            $encrypted_name .= $shifted_char;
        }
    }
    return $encrypted_name;
}
?>
