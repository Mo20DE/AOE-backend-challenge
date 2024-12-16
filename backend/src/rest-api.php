<?php

require_once "utility.php";

/** 
 *    -- Task 2.3 --
 *    RESTful API with HTTP GET and POST support.
 */

// start user session
session_start();
$PATH_TO_DATABASE = "../data/superheroes.json";

// retrieve http verb
$http_verb = $_SERVER["REQUEST_METHOD"] ?? "GET";
switch ($http_verb) {

    case "GET":

        // load database once
        $_SESSION["superheroes_data"] = null;
        if (!isset($_SESSION["superheroes_data"])) {
            $_SESSION["superheroes_data"] = loadSuperheroesDatabase($PATH_TO_DATABASE);
        }
        
        // no superheroes in database
        if (empty($_SESSION["superheroes_data"])) {
            http_response_code(404);
            exit("Database is empty");
        }

        $get_all = checkParam($_GET, "all") ;
        $superpower_params = array(
            $get_all ? false : checkParam($_GET, "str"),
            $get_all ? false : checkParam($_GET, "spd"),
            $get_all ? false : checkParam($_GET, "fly"),
            $get_all ? false : checkParam($_GET, "invul"),
            $get_all ? false : checkParam($_GET, "heal")
        );
        if (!$get_all) {
            if (empty(array_filter($superpower_params))) {
                http_response_code(400);
                exit("Either set the 'all'-parameter or at least one of the folowing parameters: " . implode(', ', ["str", "spd", "fly", "invul", "heal"]));
            }
        }

        $encrypt = checkParam($_GET, "enc");
        $key = checkIsSet($_GET, "key");
        if ($encrypt && $key != null) {
            if (!is_numeric($key)) {
                http_response_code(422);
                exit("The encryption key $key is not a number");
            }
            else if ($key < 1 || $key > 28) {
                http_response_code(422);
                exit("The encryption key $key must be between 1 - 28");
            }
            $key = (int)$key;
        }
        else $key = 5; // 5 is default value of encryption key

        $selected_superheroes = selectSuperheroes($_SESSION["superheroes_data"], $superpower_params, $encrypt, $key);
        if (empty($selected_superheroes)) {
            http_response_code(404);
            exit("No Superheroes found for the requested superpowers");
        }
        // send data to client
        http_response_code(200);
        echo implode("\n", $selected_superheroes);
        break;

    case "POST":

        $hero_data = json_decode(file_get_contents("php://input"), true);
        if ($hero_data === null) {
            http_response_code(400);
            exit("Invalid JSON format");
        }

        if (count($hero_data) !== 4) {
            http_response_code(400);
            exit("Expected exactly 4 key-value pairs, received " . count($hero_data));
        }

        $nm = checkIsSet($hero_data, "name");
        $id = checkIsSet($hero_data, "identity");
        $dob = checkIsSet($hero_data, "birthday");
        $suppwrs = checkIsSet($hero_data, "superpowers");

        if ($nm === null || $id === null || $dob === null || $suppwrs === null) {
            http_response_code(400);
            exit("Please provide exactly the following keys: " . implode(", ", ["name", "identity", "birthday", "superpowers"]));
        }
        // validate name
        if (!isValidString($nm)) {
            http_response_code(400);
            exit("Superhero name has to be an lowercase non-empty string");
        }
        // validate identity
        if (!is_array($id) || count($id) !== 2 || !key_exists("firstName", $id) || !key_exists("lastName", $id)) {
            http_response_code(400);
            exit("Identity must be an JSON object and should contain 'firstName' and 'lastName' as keys");
        }
        if (!isValidString($id["firstName"]) || !isValidString($id["lastName"])) {
            http_response_code(400);
            exit("The values of first- and lastname must be lowercase non-empty strings");
        }
        // validate date
        if (!is_string($dob) || !(preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob))) {
            http_response_code(400);
            exit("Birthday should be a string with the format YYYY-MM-DD");
        }
        // validate superpowers
        if (!is_array($suppwrs) || empty($suppwrs)) {
            http_response_code(400);
            exit("Superpowers must be an non-empty array");
        }
        foreach($suppwrs as $elem) {
            if (!in_array($elem, $superpowers, true)) {
                http_response_code(400);
                exit("Superpowers must be one or more of the following strings: " . implode(", ", $superpowers));
            }
        }

        if (file_exists($PATH_TO_DATABASE)) {
            $json_data = file_get_contents($PATH_TO_DATABASE);
            $data_array = json_decode($json_data, true);
        }
        else $data_array = array();

        // add new data to old data
        $data_array[] = $hero_data;
        $json_data = json_encode($data_array, JSON_PRETTY_PRINT);

        if (file_put_contents($PATH_TO_DATABASE, $json_data) === false) {
            http_response_code(500);
            exit("An error occurred during storing the data");
        }
        // reload session variable
        $_SESSION["superheroes_data"] = loadSuperheroesDatabase($PATH_TO_DATABASE);
        http_response_code(200);
        echo "Data was successfully saved in database";
        break;

    default:
        http_response_code(405);
        echo "$http_verb-Method is not supported";
        break;
};
?>
