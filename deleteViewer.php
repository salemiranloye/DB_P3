<?php
require_once "ViewerService.php";

$service = new ViewerService();

if (!isset($_GET["id"])) {
    die("No viewer ID provided.");
}

$id = $_GET["id"];
$service->deleteViewer($id);

header("Location: index.php");
exit();
?>
