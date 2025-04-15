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
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .form-row {
            margin-bottom: 15px;
        }
        label {
            display: inline-block;
            width: 150px;
            vertical-align: middle;
        }
        input[type="text"], 
        input[type="email"], 
        input[type="number"],
        select {
            width: 200px;
            padding: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            margin-right: 10px;
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        a {
            text-decoration: none;
            color: #666;
            padding: 8px 15px;
        }
    </style>
</head>
<body>
    <h2>Edit Viewer Info</h2>
    <form method="POST" action="updateViewer.php?id=<?= $viewer->getViewerId(); ?>">
        <div class="form-row">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= $viewer->getName(); ?>" required>
        </div>
        
        <div class="form-row">
            <label for="sex">Sex:</label>
            <select id="sex" name="sex">
                <option value="M" <?= $viewer->getSex() === "M" ? "selected" : ""; ?>>Male</option>
                <option value="F" <?= $viewer->getSex() === "F" ? "selected" : ""; ?>>Female</option>
            </select>
        </div>
        
        <div class="form-row">
            <label for="mailId">Email:</label>
            <input type="email" id="mailId" name="mailId" value="<?= $viewer->getMailId(); ?>" required>
        </div>
        
        <div class="form-row">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?= $viewer->getAge(); ?>" required>
        </div>
        
        <div class="form-row">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?= $viewer->getCity(); ?>" required>
        </div>
        
        <div class="form-row">
            <label for="stateAb">State Abbreviation:</label>
            <input type="text" id="stateAb" name="stateAb" value="<?= $viewer->getStateAb(); ?>" maxlength="2" required>
        </div>
        
        <div class="form-row">
            <input type="submit" value="Update Viewer">
            <a href="index.php">Cancel</a>
        </div>
    </form>
</body>
</html>