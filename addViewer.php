<!-- Jordan Smith-Acquah 1002098372 -->
<!-- Salem Iranloye 1002156031 -->

<?php
require_once "Viewer.php";
require_once "ViewerService.php";

$service = new ViewerService();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get POST data
    $name = $_POST["name"];
    $sex = $_POST["sex"];
    $mailId = $_POST["mailId"];
    $age = $_POST["age"];
    $city = $_POST["city"];
    $stateAb = $_POST["stateAb"];

    // Create Viewer object
    $viewer = new Viewer(null, $name, $sex, $mailId, $age, $city, $stateAb);

    // Add to DB
    $service->addViewer($viewer);

    // Redirect to index or confirmation page
    header("Location: index.php");
    exit();
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Viewer</title>
</head>
<body>
    <h2>Add New Viewer</h2>
    <form method="POST" action="addViewer.php">
        Name: <input type="text" name="name" required><br><br>
        Sex: 
        <select name="sex">
            <option value="M">Male</option>
            <option value="F">Female</option>
        </select><br><br>
        Email: <input type="email" name="mailId" required><br><br>
        Age: <input type="number" name="age" min="0" required><br><br>
        City: <input type="text" name="city" required><br><br>
        State Abbreviation: <input type="text" name="stateAb" maxlength="2" required><br><br>
        <input type="submit" value="Add Viewer">
    </form>
</body>
</html>
