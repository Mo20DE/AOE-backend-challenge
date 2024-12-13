<?php
/** 
 *    -- Task 2.3 --
 *    RESTful API with HTTP GET- and POST-Method support.
 */
include "../src/utility.php";

// start the session
session_start();

// load superheroes
$PATH_TO_DATABASE = "../database/superheroes.json";
// $_SESSION["superheroes_data"] = null;

// retrieve http verb
$http_verb = $_SERVER["REQUEST_METHOD"];
switch ($http_verb) {

    case "GET":

        // load database once
        if (!isset($_SESSION["superheroes_data"])) {
            $_SESSION["superheroes_data"] = loadSuperheroesDatabase($PATH_TO_DATABASE);
            echo "Database loaded successfully\n";
        }
        
        // no superheroes in database
        if (empty($_SESSION["superheroes_data"])) {
            http_response_code(404);
            exit("Database is empty");
        }

        global $superpowers;
        $get_all = checkParam($_GET, "all");
        $superpower_params = array(
            $get_all ? true : checkParam($_GET, "str"),
            $get_all ? true : checkParam($_GET, "spd"),
            $get_all ? true : checkParam($_GET, "fly"),
            $get_all ? true : checkParam($_GET, "invul"),
            $get_all ? true : checkParam($_GET, "heal")
        );
        if (!$get_all) {
            if (empty(array_filter($superpower_params))) {
                http_response_code(400);
                exit("At least one of the folowing parameters is required: " . implode(', ', ["str", "spd", "fly", "invul", "heal"]));
            }
        }

        $encrypt = checkParam($_GET, "enc");
        $key = checkIsSet($_GET, "key");
        if ($encrypt && $key != null) {
            if (!is_numeric($key)) {
                http_response_code(422);
                exit("The key $key is not a number");
            }
            else if ($key < 1 || $key > 28) {
                http_response_code(422);
                exit("The key $key must be between 1 - 28");
            }
            $key = (int)$key;
        }
        else $key = 5; // 5 is default value of encryption key

        $selected_superheroes = selectSuperheroes($_SESSION["superheroes_data"], $superpower_params, $encrypt, $key);
        if (empty($selected_superheroes)) {
            http_response_code(404);
            exit("No Superheroes for the requested Superpowers found");
        }
        // send data to client
        echo implode("\n", $selected_superheroes);
        break;

    case "POST":

        $hero_data = json_decode(file_get_contents("php://input"), true);
        if ($hero_data === null) {
            http_response_code(400);
            exit("Invalid JSON data provided");
        }
        if (count($hero_data) !== 4) {
            http_response_code(400);
            exit("Expected exactly 4 elements, received " . count($hero_data));
        }

        $nm = checkIsSet($hero_data, "name");
        $id = checkIsSet($hero_data, "identity");
        $dob = checkIsSet($hero_data, "birthday");
        $suppwrs = checkIsSet($hero_data, "superpowers");

        if ($nm === null || $id === null || $dob === null || $suppwrs === null) {
            http_response_code(400);
            exit("Please proovide correct key-names");
        }
        
        // $hero_data = array(
        //     "name" => isset($_POST["nm"]) ? $_POST["nm"] : null,
        //     "identity" => array(
        //         "firstName" => isset($_POST["fn"]) ? $_POST["fn"] : null,
        //         "lastName" => isset($_POST["ln"]) ? $_POST["ln"] : null
        //     ),
        //     "birthday" => isset($_POST["dob"]) ? $_POST["dob"] : null,
        //     "superpowers" => filterSuperpowers(array(
        //         checkParam($_POST, "str"),
        //         checkParam($_POST, "spd"),
        //         checkParam($_POST, "fly"),
        //         checkParam($_POST, "invul"),
        //         checkParam($_POST, "heal")
        //     ))
        // );

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
        else {
            // reload session variable
            $_SESSION["superheroes_data"] = loadSuperheroesDatabase($PATH_TO_DATABASE);
            echo "Data was successfully saved in database";
        } 
        // echo json_encode($data);
        // echo json_encode($superpowers);
        break;

    default:
        http_response_code(405);
        echo "$http_verb-Method is not supported";
        break;
};
?>
