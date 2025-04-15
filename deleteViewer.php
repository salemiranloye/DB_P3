<!-- Jordan Smith-Acquah 1002098372 -->
<!-- Salem Iranloye 1002156031 -->
 
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
