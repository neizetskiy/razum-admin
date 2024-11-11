<?php 
require('../connect/connect.php');
require('functions.php');
if(isRole()){
    $sql = "DELETE FROM `Purchased` WHERE `userId` = " . $_GET['userid'] . " AND `courseId` = " . $_GET['courseid'];
    $state = $database->prepare($sql);
    $state->execute();
    header('Location: /?page=updateCourse&id=' . $_GET['courseid']);
    die();
}
?>