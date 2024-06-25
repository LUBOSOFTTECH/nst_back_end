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

    // Insert a main variant category
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

    //update main variant 
public function update_main_variant() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $request = json_decode(file_get_contents('php://input'), true);

            $deviceType = $request['deviceType'];
            $username = $request['username'];

            $var_name=$deleted_flg=$main_var_id='';

            if (isset($request['var_name']))
            $var_name=$request['var_name'];

            if (isset($request['deleted_flg']))
            $deleted_flg=$request['deleted_flg'];

            if (isset($request['main_var_id']))
            $main_var_id=$request['main_var_id'];


            $response = $this->model->update_main_variantDB($var_name,$deleted_flg,$main_var_id,$username);
            echo json_encode($response);
        
    } else {
        echo json_encode(array('status' => 'failure', 'message' => 'Invalid request method'));
    }
}
//get main variant list
public function get_all_main_var() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $request = json_decode(file_get_contents('php://input'), true);

            $deviceType = $request['deviceType'];
            $username = $request['username'];

            $response = $this->model->get_all_main_varDB();
            echo json_encode($response);
        
    } else {
        echo json_encode(array('status' => 'failure', 'message' => 'Invalid request method'));
    }
}


//SUB VARIANT QUERY CHANGES

//insert a sub catagory
public function insert_sub_variant() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $request = json_decode(file_get_contents('php://input'), true);

            $deviceType = $request['deviceType'];
            $username = $request['username'];

            $var_name=$main_var_id='';

            if (isset($request['var_name']))
            $var_name=$request['var_name'];

            if (isset($request['main_var_id']))
            $main_var_id=$request['main_var_id'];

            $response = $this->model->insert_sub_variantDB($var_name,$username,$main_var_id);
            echo json_encode($response);
        
    } else {
        echo json_encode(array('status' => 'failure', 'message' => 'Invalid request method'));
    }
}

//update sub catagory
public function update_sub_variant() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $request = json_decode(file_get_contents('php://input'), true);

            $deviceType = $request['deviceType'];
            $username = $request['username'];

            $var_name=$deleted_flg=$main_var_id=$sub_var_id='';

            if (isset($request['var_name']))
            $var_name=$request['var_name'];

            if (isset($request['deleted_flg']))
            $deleted_flg=$request['deleted_flg'];

            if (isset($request['main_var_id']))
            $main_var_id=$request['main_var_id'];

            if (isset($request['sub_var_id']))
            $sub_var_id=$request['sub_var_id'];


            $response = $this->model->update_sub_variantDB($var_name,$deleted_flg,$main_var_id,$username,$sub_var_id);
            echo json_encode($response);
        
    } else {
        echo json_encode(array('status' => 'failure', 'message' => 'Invalid request method'));
    }
}
//get sub catagory list
public function get_all_sub_variant() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $request = json_decode(file_get_contents('php://input'), true);

            $deviceType = $request['deviceType'];
            $username = $request['username'];

            $main_var_id='';
            
            if (isset($request['main_var_id']))
            $main_var_id=$request['main_var_id'];

            $response = $this->model->get_all_sub_variantDB($main_var_id);
            echo json_encode($response);
        
    } else {
        echo json_encode(array('status' => 'failure', 'message' => 'Invalid request method'));
    }
}




}
?>
