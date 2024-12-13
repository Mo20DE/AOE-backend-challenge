<?php
include 'encrypt.php';
/** 
 *    /-- Task 2.2 --/
 *    Model for Supehero.
 */
class SuperHero {

    public string $name;
    private string $firstname;
    private string $lastename;
    public string $birthday;
    public array $superpowers;

    function __construct(string $nm, string $fn, string $ln, string $bday, array $sprpwrs) {
        $this->name = $nm;
        $this->firstname = $fn;
        $this->lastename = $ln;
        $this->birthday = $bday;
        $this->superpowers = $sprpwrs;
    }

    function hasSomeGivenSuperpowers(array $superpowers) {
        return count(array_intersect($this->superpowers, $superpowers)) > 0;
    }

    function getHeroName() {
        return $this->name;
    }
    
    function getFullName(bool $encrypt, int $key) {
        $full_name = $this->firstname . " " . $this->lastename;
        if ($encrypt) return deeSeeChiffre($full_name, $key);
        return $full_name;
    }

    function getBirthday() {
        return $this->birthday;
    }

    function getSuperpowers() {
        return implode(", ", $this->superpowers);
    }
}
?>
