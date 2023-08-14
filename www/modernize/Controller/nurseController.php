<?php 

    class Nurse{

        //constructor function
        function __construct(){
            //call database.php
            include_once('database.php');
            session_start();
            //enable log
            // error_reporting(E_ALL);
            // ini_set('display_errors', 1);
            // ini_set('error_log', 'error.log');
            // ini_set('display_errors', 1);
            // ini_set('display_startup_errors', 1);
            // error_reporting(E_ALL);
        }

        function getAllNurse(){
            $conn = new Connection();
            $query = "SELECT * FROM nurse";
            $connection = new Connection();
            $conn = $connection->connect();
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $conn->close();
            return $result;
        }

        function addNurse(){
            //get post parameteres

            isset($_POST['nurse_firstname']) ? $nurse_firstname = $_POST['nurse_firstname'] : $nurse_firstname = '';
            isset($_POST['nurse_lastname']) ? $nurse_lastname = $_POST['nurse_lastname'] : $nurse_lastname = '';
            isset($_POST['nurse_email']) ? $nurse_email = $_POST['nurse_email'] : $nurse_email = '';
            isset($_POST['nurse_sex']) ? $nurse_sex = $_POST['nurse_sex'] : $nurse_sex ='';
            isset($_POST['nurse_contact']) ? $nurse_contact = $_POST['nurse_contact'] : $nurse_contact = '';
            isset($_POST['nurse_middlename']) ? $nurse_middlename = $_POST['nurse_middlename'] : $nurse_middlename = '';
            isset($_POST['nurse_street']) ? $nurse_street = $_POST['nurse_street'] : $nurse_street = '';
            isset($_POST['nurse_barangay']) ? $nurse_barangay = $_POST['nurse_barangay'] : $nurse_barangay = '';
            isset($_POST['nurse_city']) ? $nurse_city = $_POST['nurse_city'] : $nurse_city = '';
            isset($_POST['nurse_province']) ? $nurse_province = $_POST['nurse_province'] : $nurse_province = '';
            isset($_POST['nurse_postal']) ? $nurse_postal = $_POST['nurse_postal'] : $nurse_postal = '';
            isset($_POST['nurse_type']) ? $nurse_type = $_POST['nurse_type'] : $nurse_type = '';

            //insert querry and prepare statement

            $query = "INSERT INTO nurse (firstname, lastname, email, sex, contact, middlename, street, barangay, city, province, postal,nurse_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            // $conn = new Connection();
            $connection = new Connection();
            $conn = $connection->connect();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssssssssss", $nurse_firstname, $nurse_lastname, $nurse_email, $nurse_sex, $nurse_contact, $nurse_middlename, $nurse_street, $nurse_barangay, $nurse_city, $nurse_province, $nurse_postal, $nurse_type);
            // $stmt->execute();
            $result = $stmt->execute();
            $stmt->close();
            $conn->close();
            return $result ? 'success' : $conn->error;
        }

        function editNurse(){
            $id = $_POST['id'];

            $query = "SELECT * FROM nurse WHERE id = ?";
            $connection = new Connection();
            $conn = $connection->connect();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $conn->close();
            return $result;
        }

        
       
        function updateNurse(){
            isset($_POST['id']) ? $nurse_id = $_POST['id'] : '';
            isset($_POST['nurse_firstname']) ? $nurse_firstname = $_POST['nurse_firstname'] : $nurse_firstname = '';
            isset($_POST['nurse_lastname']) ? $nurse_lastname = $_POST['nurse_lastname'] : $nurse_lastname = '';
            isset($_POST['nurse_email']) ? $nurse_email = $_POST['nurse_email'] : $nurse_email = '';
            isset($_POST['nurse_sex']) ? $nurse_sex = $_POST['nurse_sex'] : $nurse_sex ='';
            isset($_POST['nurse_contact']) ? $nurse_contact = $_POST['nurse_contact'] : $nurse_contact = '';
            isset($_POST['nurse_middlename']) ? $nurse_middlename = $_POST['nurse_middlename'] : $nurse_middlename = '';
            isset($_POST['nurse_street']) ? $nurse_street = $_POST['nurse_street'] : $nurse_street = '';
            isset($_POST['nurse_barangay']) ? $nurse_barangay = $_POST['nurse_barangay'] : $nurse_barangay = '';
            isset($_POST['nurse_city']) ? $nurse_city = $_POST['nurse_city'] : $nurse_city = '';
            isset($_POST['nurse_province']) ? $nurse_province = $_POST['nurse_province'] : $nurse_province = '';
            isset($_POST['nurse_postal']) ? $nurse_postal = $_POST['nurse_postal'] : $nurse_postal = '';
            isset($_POST['nurse_type']) ? $nurse_type = $_POST['nurse_type'] : $nurse_type = '';
        
            //update Query
            $query = "UPDATE nurse SET firstname=?, lastname=?, email=?, sex=?, contact=?, middlename=?, street=?, barangay=?, city=?, province=?, postal=?, nurse_type=? WHERE id=?";
            $connection = new Connection();
            $conn = $connection->connect();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssssssssssi", $nurse_firstname, $nurse_lastname, $nurse_email, $nurse_sex, $nurse_contact, $nurse_middlename, $nurse_street, $nurse_barangay, $nurse_city, $nurse_province, $nurse_postal, $nurse_type, $nurse_id);
            $result = $stmt->execute();
            // $stmt->close();
            
            return $result ? 'success' : $conn->error;
            
        }

        function deleteNurse(){
            $id = $_POST['id'];
            $query = "DELETE FROM nurse WHERE id = ?";
            $connection = new Connection();
            $conn = $connection->connect();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            $stmt->close();
            $conn->close();
            return $result ? 'success' : $conn->error;
        }

    }

    if(isset($_POST['function'])){

        $function = $_POST['function'];
 
        $nurse = new Nurse();
        switch($function){
            case 'addNurse':
                echo $nurse->addNurse();

                break;
            case 'getAllNurse':
                $result = $nurse->getAllNurse();
                $nurseArray = array();
                while($row = $result->fetch_assoc()){
                    array_push($nurseArray, $row);
                }
                $dataTable = array('data'=>$nurseArray,'draw'=>1,'recordsTotal'=>count($nurseArray),'recordsFiltered'=>count($nurseArray));
                echo json_encode($dataTable);
                break;
            case 'editNurse':
                $result = $nurse->editNurse();
                $editNurse = array();
                $row = $result->fetch_assoc();
                echo json_encode($row);
                break;
            case 'updateNurse':
                echo $nurse->updateNurse();
                break;
            case 'deleteNurse':
                echo $nurse->deleteNurse();
                break;
        }
    }

    if(isset($_GET['function'])){
        $function = $_GET['function'];
        $nurse = new Nurse();
        switch($function){
            case 'editNurse':
                $result = $nurse->editNurse();
                $editNurse = array();
                $row = $result->fetch_assoc();
                echo json_encode($row);
                break;
            
        }
    }
?>