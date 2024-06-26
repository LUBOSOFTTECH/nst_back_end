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

if (isset($_REQUEST['run']) && method_exists('Products', $_REQUEST['run'])) {
    $view = new Products($model);
    $request = $_REQUEST['run'];
    $view->$request();
} else {
    echo json_encode(array('status' => 'failure', 'message' => 'Invalid request'));
    exit; // Exit if run parameter is missing or invalid
}

class Products {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    // Insert a main variant category
    public function insert_product() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $request = json_decode(file_get_contents('php://input'), true);

            $deviceType = $request['deviceType'];
            $username = $request['username'];

            $prd_name=$prd_desription=$stock_unit=$price=$dis_digit=$dis_type=$main_cat_id=$sub_cat_id=$main_var_id=$sub_var_id=  '';
            if (isset($request['prd_name'])) {
                $prd_name = $request['prd_name'];
            }
            if (isset($request['prd_desription'])) {
                $prd_desription = $request['prd_desription'];
            }
            if (isset($request['stock_unit'])) {
                $stock_unit = $request['stock_unit'];
            }
            if (isset($request['price'])) {
                $price = $request['price'];
            }
            if (isset($request['dis_digit'])) {
                $var_name = $request['dis_digit'];
            }
            if (isset($request['dis_type'])) {
                $dis_type = $request['dis_type'];
            }
            if (isset($request['main_cat_id'])) {
                $main_cat_id = $request['main_cat_id'];
            }
            if (isset($request['sub_cat_id'])) {
                $sub_cat_id = $request['sub_cat_id'];
            }
            if (isset($request['main_var_id'])) {
                $main_var_id = $request['main_var_id'];
            }
            if (isset($request['sub_var_id'])) {
                $sub_var_id = $request['sub_var_id'];
            }

            $response = $this->model->insert_productDB( $prd_name,$prd_desription,$stock_unit,$price,$dis_digit,$dis_type,$main_cat_id,$sub_cat_id,$main_var_id,$sub_var_id,$username);
            echo json_encode($response);
        } else {
            echo json_encode(array('status' => 'failure', 'message' => 'Invalid request method'));
        }
    }
   //update a product variant category
   public function update_product() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $request = json_decode(file_get_contents('php://input'), true);

        $deviceType = $request['deviceType'];
        $username = $request['username'];

        $prd_id=$prd_name=$prd_desription=$stock_unit=$price=$dis_digit=$dis_type=$main_cat_id=$sub_cat_id=$main_var_id=$sub_var_id= $deleted_flg= '';

        if (isset($request['prd_id'])) {
            $prd_id = $request['prd_id'];
        }
        if (isset($request['prd_name'])) {
            $prd_name = $request['prd_name'];
        }
        if (isset($request['prd_desription'])) {
            $prd_desription = $request['prd_desription'];
        }
        if (isset($request['stock_unit'])) {
            $stock_unit = $request['stock_unit'];
        }
        if (isset($request['price'])) {
            $price = $request['price'];
        }
        if (isset($request['dis_digit'])) {
            $var_name = $request['dis_digit'];
        }
        if (isset($request['dis_type'])) {
            $dis_type = $request['dis_type'];
        }
        if (isset($request['main_cat_id'])) {
            $main_cat_id = $request['main_cat_id'];
        }
        if (isset($request['sub_cat_id'])) {
            $sub_cat_id = $request['sub_cat_id'];
        }
        if (isset($request['main_var_id'])) {
            $main_var_id = $request['main_var_id'];
        }
        if (isset($request['sub_var_id'])) {
            $sub_var_id = $request['sub_var_id'];
        }
        if (isset($request['deleted_flg'])) {
            $deleted_flg = $request['deleted_flg'];
        }

        $response = $this->model->update_productDB( $prd_name,$prd_desription,$stock_unit,$price,$dis_digit,$dis_type,$main_cat_id,$sub_cat_id,$main_var_id,$sub_var_id,$username,$prd_id,$deleted_flg);
        echo json_encode($response);
    } else {
        echo json_encode(array('status' => 'failure', 'message' => 'Invalid request method'));
    }
}

//get main catagory list
public function get_all_products() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $request = json_decode(file_get_contents('php://input'), true);

            $deviceType = $request['deviceType'];
            $username = $request['username'];
            $start = $request['start'];
            $end = $request['end'];

            $search =$filterbycat = $filterbyvar='';
            if (isset($request['search'])) {
            $search = $request['search'];
            }
            if (isset($request['filterbycat'])) {
            $filterbycat = $request['filterbycat'];
            }
            if (isset($request['filterbyvar'])) {
            $filterbyvar = $request['filterbyvar'];
            }

            $response = $this->model->get_all_productsDB($search ,$filterbycat , $filterbyvar, $start, $end);
            echo json_encode($response);
        
    } else {
        echo json_encode(array('status' => 'failure', 'message' => 'Invalid request method'));
    }
}

}
?>
