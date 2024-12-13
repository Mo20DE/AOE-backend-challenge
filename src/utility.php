<?php
include "model.php";
// Accepted Superpowers by DeeSee
$superpowers = array("strength", "speed", "flight", "invulnerability", "healing");

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

function filterSuperpowers(array $params) {
    global $superpowers;
    return array_values(array_filter(
        $superpowers, function($item, $idx) use ($params) {
            return $params[$idx];
        }, ARRAY_FILTER_USE_BOTH)
    );
}

/** 
 *    /-- Task 2.2 --/
 *    Filters Superheroes by their Superpowers.
 */
function selectSuperheroes(array $superhero_data, array $superpower_params, bool $encrypt, int $key) {
    $filtered_superheroes = array();
    $filtered_superpowers = filterSuperpowers($superpower_params);
    foreach ($superhero_data as $hero) {
        if ($hero->hasSomeGivenSuperpowers($filtered_superpowers)) {
            $filtered_superheroes[] = $hero->getFullName($encrypt, $key);
        }
    }
    return $filtered_superheroes;
}

function isLowerCaseWithSpaces($word) {
    return preg_match('/^[a-z ]+$/', $word) === 1;
}

function storeSuperheroInDatabase(string $database_path) {
    
}
?>
