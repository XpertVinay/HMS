<?php
require_once("../../Includes/config.php");
require_once("../../Includes/session.php");
if ($logged == false) {
    header("Location:../../login.php");
    exit();
}
if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $event_date = $_POST['event_date'];
    $event_time = !empty($_POST['event_time']) ? $_POST['event_time'] : NULL;
    $description = $_POST['description'];

    $pdo = $db->getPDO();
    if($event_time){
        $stmt = $pdo->prepare("INSERT INTO events (title, event_date, event_time, description) VALUES (:title, :date, :time, :desc)");
        $stmt->execute([':title' => $title, ':date' => $event_date, ':time' => $event_time, ':desc' => $description]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO events (title, event_date, description) VALUES (:title, :date, :desc)");
        $stmt->execute([':title' => $title, ':date' => $event_date, ':desc' => $description]);
    }
    header("Location: admin_event.php");
}
?>
