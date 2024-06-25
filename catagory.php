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

if (isset($_REQUEST['run']) && method_exists('Category', $_REQUEST['run'])) {
    $view = new Category($model);
    $request = $_REQUEST['run'];
    $view->$request();
} else {
    echo json_encode(array('status' => 'failure', 'message' => 'Invalid request'));
    exit; // Exit if run parameter is missing or invalid
}

class Category {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }
//insert a main catagory
public function insert_main_catagory() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $request = json_decode(file_get_contents('php://input'), true);

            $deviceType = $request['deviceType'];
            $username = $request['username'];

            $cat_name=$created_user='';
            if (isset($request['cat_name']))
            $cat_name=$request['cat_name'];

            $response = $this->model->insert_main_catagoryDB($cat_name,$username);
            echo json_encode($response);
        
    } else {
        echo json_encode(array('status' => 'failure', 'message' => 'Invalid request method'));
    }
}

//update main catagory
public function update_main_catagory() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $request = json_decode(file_get_contents('php://input'), true);

            $deviceType = $request['deviceType'];
            $username = $request['username'];

            $cat_name=$deleted_flg=$main_cat_id='';

            if (isset($request['cat_name']))
            $cat_name=$request['cat_name'];

            if (isset($request['deleted_flg']))
            $deleted_flg=$request['deleted_flg'];

            if (isset($request['main_cat_id']))
            $main_cat_id=$request['main_cat_id'];


            $response = $this->model->update_main_catagoryDB($cat_name,$deleted_flg,$main_cat_id,$username);
            echo json_encode($response);
        
    } else {
        echo json_encode(array('status' => 'failure', 'message' => 'Invalid request method'));
    }
}

//get main catagory list
    public function get_all_main_cat() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $request = json_decode(file_get_contents('php://input'), true);

                $deviceType = $request['deviceType'];
                $username = $request['username'];

                $response = $this->model->get_all_main_catDB();
                echo json_encode($response);
            
        } else {
            echo json_encode(array('status' => 'failure', 'message' => 'Invalid request method'));
        }
    }


//SUB CATEGORY QUERY CHANGES

//insert a sub catagory
public function insert_sub_catagory() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $request = json_decode(file_get_contents('php://input'), true);

            $deviceType = $request['deviceType'];
            $username = $request['username'];

            $cat_name=$main_cat_id='';

            if (isset($request['cat_name']))
            $cat_name=$request['cat_name'];

            if (isset($request['main_cat_id']))
            $main_cat_id=$request['main_cat_id'];

            $response = $this->model->insert_sub_catagoryDB($cat_name,$username,$main_cat_id);
            echo json_encode($response);
        
    } else {
        echo json_encode(array('status' => 'failure', 'message' => 'Invalid request method'));
    }
}

//update main catagory
public function update_sub_catagory() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $request = json_decode(file_get_contents('php://input'), true);

            $deviceType = $request['deviceType'];
            $username = $request['username'];

            $cat_name=$deleted_flg=$main_cat_id=$sub_cat_id='';

            if (isset($request['cat_name']))
            $cat_name=$request['cat_name'];

            if (isset($request['deleted_flg']))
            $deleted_flg=$request['deleted_flg'];

            if (isset($request['main_cat_id']))
            $main_cat_id=$request['main_cat_id'];

            if (isset($request['sub_cat_id']))
            $sub_cat_id=$request['sub_cat_id'];


            $response = $this->model->update_sub_catagoryDB($cat_name,$deleted_flg,$main_cat_id,$username,$sub_cat_id);
            echo json_encode($response);
        
    } else {
        echo json_encode(array('status' => 'failure', 'message' => 'Invalid request method'));
    }
}
//get main catagory list
public function get_all_sub_cat() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $request = json_decode(file_get_contents('php://input'), true);

            $deviceType = $request['deviceType'];
            $username = $request['username'];

            $sub_cat_id='';
            
            if (isset($request['sub_cat_id']))
            $sub_cat_id=$request['sub_cat_id'];

            $response = $this->model->get_all_sub_catDB($sub_cat_id);
            echo json_encode($response);
        
    } else {
        echo json_encode(array('status' => 'failure', 'message' => 'Invalid request method'));
    }
}







}
?>
