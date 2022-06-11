<?php
if(!isset($_POST)){
    $response = array('status'=>'failed', 'date' => null);
    sendJsonResponse($response);
    die();
}
include_once("connect.php");
$results_per_page = 5;
$pageno = (int)$_POST['pageno'];
$page_first_result = ($pageno - 1)* $results_per_page;

$sqlloadsub= "SELECT * FROM tbl_subjects";
$result = $conn->query($sqlloadsub);

$number_of_result = $result->num_rows;
$number_of_page = ceil($number_of_result / $results_per_page);
$sqlloadsub= $sqlloadsub . "LIMIT $page_first_result , $results_per_page";
$result = $conn->query($sqlloadsub);

if($result->num_rows >0){

    $tutors ["tutors"] = array();
while($row= $result->fetch_assoc()){
    $tutorlist = array();
    $tutorlist ['subject_id']= $row['subject_id'];
    $tutorlist ['subject_name']= $row['subject_name'];
    $tutorlist ['subject_description']= $row['subject_description'];
    $tutorlist ['subject_price']= $row['subject_price'];
    $tutorlist ['tutor_id']= $row['tutor_id'];
    $tutorlist ['subject_sessions']= $row['subject_sessions'];
    $tutorlist ['subject_rating']= $row['subject_rating'];

    array_push($tutors["tutors"],$tutorlist);

}
    $response = array('status'=>'success', 'date' => $tutors);
    sendJsonResponse($response);
}else{
    $response = array('status'=>'failed', 'date' => null);
    sendJsonResponse($response);
}
function sendJsonResponse($sendArray){
    header('Content-Type: application/json');
    echo json_encode($sendArray);
}



?>