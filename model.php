<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Model {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

//insert a main catagory
public function insert_main_catagoryDB($cat_name,$username){

    $query = sprintf("SELECT * FROM `defaultdb`.`MAIN_CATEGORY` WHERE DELETED_FLG !='D' AND LOWER(MAIN_CAT_NAME)=LOWER('%s')",$cat_name);
    $stmt = $this->db->prepare($query);
    $stmt->execute();

    $response = array();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result==0) {

        $query = sprintf("INSERT INTO `defaultdb`.`MAIN_CATEGORY` (`MAIN_CAT_NAME`, `DELETED_FLG`, `CREATED_USER`, `LAST_UPD_USER`) VALUES ( '%s', '%s', '%s', '%s');",$cat_name,'N',$username,$username);
        $stmt = $this->db->prepare($query);
        $result=$stmt->execute();

        if ($result) {
            $response['status'] = "success";
            $response['message'] = $cat_name . " added in main catagory";
        } else {
            $response['status'] = "failure";
            $response['message'] = $cat_name . " added failed in main category";
        }

    } else {
        $response['status'] = "failure";
        $response['message'] = $cat_name." already exist in main catagory";
    }


   

    return $response;
}


//update main catagory

public function update_main_catagoryDB($cat_name, $deleted_flg, $main_cat_id, $username) {
    $response = array();
    $query = sprintf("UPDATE `defaultdb`.`MAIN_CATEGORY` SET `MAIN_CAT_NAME` = '%s', `DELETED_FLG` ='%s', `LAST_UPD_USER` = '%s' WHERE `MAIN_CAT_ID` = '%s';", $cat_name, $deleted_flg, $username, $main_cat_id);
    $stmt = $this->db->prepare($query);
    $result = $stmt->execute();
    
    if ($result) {
        $response['status'] = "success";
        $response['message'] = $cat_name . " updated in main category";
    } else {
        $response['status'] = "failure";
        $response['message'] = $cat_name . " update failed in main category";
    }

    return $response;
}
//get main catagory list
    public function get_all_main_catDB() {
        $query = "SELECT * FROM `defaultdb`.`MAIN_CATEGORY` WHERE DELETED_FLG !='D'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $response = array();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            $response['status'] = "success";
            $response['message'] = $result;
        } else {
            $response['status'] = "failure";
            $response['message'] = "No Records available";
        }

        return $response;
    }

    //SUB CATEGORY QUERY CHANGES

//insert a sub catagory

public function insert_sub_catagoryDB($cat_name,$username,$main_cat_id) {
    $response = array();

    // Prepare and execute the select query
    $query = sprintf("SELECT * FROM `defaultdb`.`SUB_CATAGORY` WHERE DELETED_FLG != 'D' AND MAIN_CAT_ID = '%s' AND LOWER(SUB_CAT_NAME) = LOWER('%s')",$main_cat_id,$cat_name);
    $stmt = $this->db->prepare($query);
    $stmt->execute();

    // Fetch the results
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($result)) {
        // If no existing record, prepare and execute the insert query
        $query = sprintf("INSERT INTO `defaultdb`.`SUB_CATAGORY` (`SUB_CAT_NAME`, `DELETED_FLG`, `CREATED_USER`, `LAST_UPD_USER`, `MAIN_CAT_ID`) VALUES ('%s', '%s', '%s', '%s', '%s')",$cat_name,'N',$username,$username,$main_cat_id);
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute();

        if ($result) {
            $response['status'] = "success";
            $response['message'] = $cat_name . " added to sub category";
        } else {
            $response['status'] = "failure";
            $response['message'] = $cat_name . " addition failed in sub category";
        }
    } else {
        $response['status'] = "failure";
        $response['message'] = $cat_name . " already exists in sub category";
    }

    return $response;
}
//update sub catagory

public function update_sub_catagoryDB($cat_name, $deleted_flg, $main_cat_id, $username,$sub_cat_id) {
    $response = array();
    $query = sprintf("UPDATE `defaultdb`.`SUB_CATAGORY` SET `SUB_CAT_NAME` = '%s', `DELETED_FLG` ='%s', `LAST_UPD_USER` = '%s' WHERE `MAIN_CAT_ID` = '%s' AND `SUB_CAT_ID` = '%s' ;", $cat_name, $deleted_flg, $username, $main_cat_id,$sub_cat_id);
    $stmt = $this->db->prepare($query);
    $result = $stmt->execute();
    
    if ($result) {
        $response['status'] = "success";
        $response['message'] = $cat_name . " updated in sub category";
    } else {
        $response['status'] = "failure";
        $response['message'] = $cat_name . " update failed in sub category";
    }

    return $response;
}

//get sub catagory list
public function get_all_sub_catDB($main_cat_id) {
    $query = sprintf("SELECT * FROM `defaultdb`.`SUB_CATAGORY` WHERE DELETED_FLG !='D' AND `MAIN_CAT_ID` = '%s'",$main_cat_id);
    $stmt = $this->db->prepare($query);
    $stmt->execute();

    $response = array();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        $response['status'] = "success";
        $response['message'] = $result;
    } else {
        $response['status'] = "failure";
        $response['message'] = "No Records available";
    }

    return $response;
}



//MAIN VARIANT QUERY CHANGES

//insert a main variant

public function insert_main_variantDB($var_name, $username) {
    $response = array();

    // Prepare the select query
    $query = sprintf("SELECT * FROM `defaultdb`.`MAIN_VARIANT` WHERE DELETED_FLG != 'D' AND LOWER(MAIN_VAR_NAME) = LOWER('%s')",$var_name);
    $stmt = $this->db->prepare($query);
    $stmt->execute();

    // Fetch the results
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($result)) {
        // If no existing record, prepare and execute the insert query
        $insertQuery = sprintf("INSERT INTO `defaultdb`.`MAIN_VARIANT` (`MAIN_VAR_NAME`, `DELETED_FLG`, `CREATED_USER`, `LAST_UPD_USER`) VALUES ('%s', '%s', '%s', '%s')",$var_name,'N',$username,$username);
        $stmt = $this->db->prepare($insertQuery);
        $insertResult = $stmt->execute();

        if ($insertResult) {
            $response['status'] = "success";
            $response['message'] = $var_name . " added to main variant";
        } else {
            $response['status'] = "failure";
            $response['message'] = $var_name . " addition failed in main variant";
        }
    } else {
        $response['status'] = "failure";
        $response['message'] = $var_name . " already exists in main variant";
    }

    return $response;
}
//update main catagory

public function update_main_variantDB($var_name,$deleted_flg,$main_var_id,$username) {
    $response = array();
    $query = sprintf("UPDATE `defaultdb`.`MAIN_VARIANT` SET `MAIN_VAR_NAME` = '%s', `DELETED_FLG` ='%s', `LAST_UPD_USER` = '%s' WHERE `MAIN_VAR_ID` = '%s';", $var_name, $deleted_flg, $username, $main_var_id);
    $stmt = $this->db->prepare($query);
    $result = $stmt->execute();
    
    if ($result) {
        $response['status'] = "success";
        $response['message'] = $var_name . " updated in main variant";
    } else {
        $response['status'] = "failure";
        $response['message'] = $var_name . " update failed in main variant";
    }

    return $response;
}

//get main variant list
public function get_all_main_varDB() {
    $query = "SELECT * FROM `defaultdb`.`MAIN_VARIANT` WHERE DELETED_FLG !='D'";
    $stmt = $this->db->prepare($query);
    $stmt->execute();

    $response = array();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        $response['status'] = "success";
        $response['message'] = $result;
    } else {
        $response['status'] = "failure";
        $response['message'] = "No Records available";
    }

    return $response;
}


    //SUB VARIANT QUERY CHANGES

//insert a sub catagory

public function insert_sub_variantDB($var_name,$username,$main_var_id) {
    $response = array();

    // Prepare and execute the select query
    $query = sprintf("SELECT * FROM `defaultdb`.`SUB_VARIANT` WHERE DELETED_FLG != 'D' AND MAIN_VAR_ID = '%s' AND LOWER(SUB_VAR_NAME) = LOWER('%s')",$main_var_id,$var_name);
    $stmt = $this->db->prepare($query);
    $stmt->execute();

    // Fetch the results
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($result)) {
        // If no existing record, prepare and execute the insert query
        $query = sprintf("INSERT INTO `defaultdb`.`SUB_VARIANT` (`SUB_VAR_NAME`, `DELETED_FLG`, `CREATED_USER`, `LAST_UPD_USER`, `MAIN_VAR_ID`) VALUES ('%s', '%s', '%s', '%s', '%s')",$var_name,'N',$username,$username,$main_var_id);
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute();

        if ($result) {
            $response['status'] = "success";
            $response['message'] = $var_name . " added to sub category";
        } else {
            $response['status'] = "failure";
            $response['message'] = $var_name . " addition failed in sub category";
        }
    } else {
        $response['status'] = "failure";
        $response['message'] = $var_name . " already exists in sub category";
    }

    return $response;
}
//update sub catagory

public function update_sub_variantDB($var_name,$deleted_flg,$main_var_id,$username,$sub_var_id) {
    $response = array();
    $query = sprintf("UPDATE `defaultdb`.`SUB_VARIANT` SET `SUB_VAR_NAME` = '%s', `DELETED_FLG` ='%s', `LAST_UPD_USER` = '%s' WHERE `MAIN_VAR_ID` = '%s' AND `SUB_VAR_ID` = '%s' ;", $var_name, $deleted_flg, $username, $main_var_id,$sub_var_id);
    $stmt = $this->db->prepare($query);
    $result = $stmt->execute();
    
    if ($result) {
        $response['status'] = "success";
        $response['message'] = $var_name . " updated in sub category";
    } else {
        $response['status'] = "failure";
        $response['message'] = $var_name . " update failed in sub category";
    }

    return $response;
}

//get sub catagory list
public function get_all_sub_variantDB($main_var_id) {
    $query = sprintf("SELECT * FROM `defaultdb`.`SUB_VARIANT` WHERE DELETED_FLG !='D' AND `MAIN_VAR_ID` = '%s'",$main_var_id);
    $stmt = $this->db->prepare($query);
    $stmt->execute();

    $response = array();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        $response['status'] = "success";
        $response['message'] = $result;
    } else {
        $response['status'] = "failure";
        $response['message'] = "No Records available";
    }

    return $response;
}

}
?>

