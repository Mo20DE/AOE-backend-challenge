<?php

require_once "encrypt.php";
require_once "Superhero.php";

$superpowers = array("strength", "speed", "flight", "invulnerability", "healing"); // Accepted superpowers by DeeSee
$json_keys = array("name", "identity", "birthday", "superpowers");

// utility function to load a file
function loadSuperheroesDatabase(string $filename) {
    $heroes = array();
    if (file_exists($filename)) {
        $json = json_decode(file_get_contents($filename));
        if ($json !== null) {
            foreach ($json as $hero) {
                $hero_object = new SuperHero(
                    $hero->name,
                    $hero->identity->firstName,
                    $hero->identity->lastName,
                    $hero->birthday,
                    $hero->superpowers
                );
                $heroes[] = $hero_object;
            }
        }
    }
    return $heroes;
}

function checkIsSet($array, $param) {
    return isset($array[$param]) ? $array[$param] : null;
}

function checkParam($method, $param) {
    $param = checkIsSet($method, $param);
    return filter_var($param, FILTER_VALIDATE_BOOL);
}

// based on GET parameters selects from available superpowers
function getRequiredSuperpowers(array $params) {
    global $superpowers;
    return array_values(array_filter(
        $superpowers, function($item, $idx) use ($params) {
            return $params[$idx];
        }, ARRAY_FILTER_USE_BOTH)
    );
}

/** 
 *    /-- Task 2.2 --/
 *    Filters Superheroes by specified superpowers.
 */
function selectSuperheroes(array $superhero_data, array $superpower_params, bool $encrypt, int $key) {
    $filtered_superheroes = array();
    $filtered_superpowers = getRequiredSuperpowers($superpower_params);
    foreach ($superhero_data as $hero) {
        if ($hero->hasGivenSuperpowers($filtered_superpowers)) {
            $filtered_superheroes[] = $encrypt ? deeSeeChiffre($hero->getFullName(), $key) : $hero->getFullName();
        }
    }
    return $filtered_superheroes;
}

function isValidString(string $str) {
    return is_string($str) && trim($str) !== "" && preg_match('/^[a-z ]+$/', $str) === 1;
}
?>
