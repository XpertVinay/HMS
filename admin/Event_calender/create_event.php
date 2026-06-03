<?php
require_once("../../Includes/config.php");
require_once("../../Includes/session.php");
if ($logged == false) {
    header("Location:../../login.php");
    exit();
}
if(isset($_POST['submit'])){
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $event_date = mysqli_real_escape_string($con, $_POST['event_date']);
    $event_time = !empty($_POST['event_time']) ? mysqli_real_escape_string($con, $_POST['event_time']) : NULL;
    $description = mysqli_real_escape_string($con, $_POST['description']);

    if($event_time){
        $query = "INSERT INTO events (title, event_date, event_time, description) VALUES ('$title', '$event_date', '$event_time', '$description')";
    } else {
        $query = "INSERT INTO events (title, event_date, description) VALUES ('$title', '$event_date', '$description')";
    }
    mysqli_query($con, $query);
    header("Location: admin_event.php");
}
?>
