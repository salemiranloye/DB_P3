<!-- Jordan Smith-Acquah 1002098372 -->
<!-- Salem Iranloye 1002156031 -->
 
<?php
require_once "Viewer.php";
require_once "ViewerService.php";

$service = new ViewerService();

// Step 1: Check for ID
if (!isset($_GET["id"])) {
    die("Viewer ID not provided.");
}

$id = $_GET["id"];
$viewer = $service->getViewerById($id);

// Step 2: Handle POST (update form)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $viewer->setName($_POST["name"]);
    $viewer->setSex($_POST["sex"]);
    $viewer->setMailId($_POST["mailId"]);
    $viewer->setAge($_POST["age"]);
    $viewer->setCity($_POST["city"]);
    $viewer->setStateAb($_POST["stateAb"]);

    $service->updateViewer($viewer);
    header("Location: index.php");
    exit();
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Edit Viewer</title>
</head>
<body>
    <h2>Edit Viewer Info</h2>
    <form method="POST" action="updateViewer.php?id=<?= $viewer->getViewerId(); ?>">
        Name: <input type="text" name="name" value="<?= $viewer->getName(); ?>" required><br><br>
        Sex: 
        <select name="sex">
            <option value="M" <?= $viewer->getSex() === "M" ? "selected" : ""; ?>>Male</option>
            <option value="F" <?= $viewer->getSex() === "F" ? "selected" : ""; ?>>Female</option>
        </select><br><br>
        Email: <input type="email" name="mailId" value="<?= $viewer->getMailId(); ?>" required><br><br>
        Age: <input type="number" name="age" value="<?= $viewer->getAge(); ?>" required><br><br>
        City: <input type="text" name="city" value="<?= $viewer->getCity(); ?>" required><br><br>
        State Abbreviation: <input type="text" name="stateAb" value="<?= $viewer->getStateAb(); ?>" maxlength="2" required><br><br>
        
        <input type="submit" value="Update Viewer">
        <a href="index.php">Cancel</a>
    </form>
</body>
</html>
