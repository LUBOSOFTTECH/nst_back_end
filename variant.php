<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connection.php';
include_once 'model.php';

$database = new Database();
$db = $database->getConnection();
$model = new Model($db);

if (isset($_REQUEST['run']) && method_exists('Variant', $_REQUEST['run'])) {
    $view = new Variant($model);
    $request = $_REQUEST['run'];
    $view->$request();
} else {
    echo json_encode(array('status' => 'failure', 'message' => 'Invalid request'));
    exit; // Exit if run parameter is missing or invalid
}

class Variant {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    // Insert a variant category
    public function insert_main_variant() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $request = json_decode(file_get_contents('php://input'), true);

            $deviceType = $request['deviceType'];
            $username = $request['username'];

            $var_name = '';
            if (isset($request['var_name'])) {
                $var_name = $request['var_name'];
            }

            $response = $this->model->insert_main_variantDB($var_name, $username);
            echo json_encode($response);
        } else {
            echo json_encode(array('status' => 'failure', 'message' => 'Invalid request method'));
        }
    }
}
?>
