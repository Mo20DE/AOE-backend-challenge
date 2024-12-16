<?php

/** 
 *    /-- Task 2.2 --/
 *    Model for Supehero.
 */

class Superhero {

    public string $name;
    private string $firstname;
    private string $lastename;
    public string $birthday;
    public array $superpowers;

    public function __construct(string $nm, string $fn, string $ln, string $bday, array $suppwrs) {
        $this->name = $nm;
        $this->firstname = $fn;
        $this->lastename = $ln;
        $this->birthday = $bday;
        $this->superpowers = $suppwrs;
    }

    public function hasGivenSuperpowers(array $superpowers) {
        return empty(array_diff($superpowers, $this->superpowers));
    }

    public function getHeroName() {
        return $this->name;
    }
    
    public function getFullName() {
        return $this->firstname . " " . $this->lastename;
    }

    public function getBirthday() {
        return $this->birthday;
    }

    public function getSuperpowers() {
        return implode(", ", $this->superpowers);
    }
}
?>
