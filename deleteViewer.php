<?php
// Jordan Smith-Acquah 1002098372
// Salem Iranloye 1002156031
 
require_once "ViewerService.php";

$service = new ViewerService();

$id = $_GET["id"];

// Check if viewer exists before deleting
$viewer = $service->getViewerById($id);
if ($viewer) {
    $rowsDeleted = $service->deleteViewer($id);
    header("Location: index.php?message=" . ($rowsDeleted > 0 ? "deleted" : "notfound"));
} else {
    // Redirect with error message
    header("Location: index.php?message=notfound");
}
exit();
?>