<?php
require_once "ViewerService.php";
$service = new ViewerService();
$resultMessage = "";
$matchedViewers = [];

// Handle form actions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"];

    if ($action === "search") {
        $keyword = $_POST["search_value"];
        if (is_numeric($keyword)) {
            $viewer = $service->getViewerById($keyword);
            if ($viewer) $matchedViewers[] = $viewer;
        } else {
            foreach ($service->getAllViewers() as $v) {
                if (stripos($v->getName(), $keyword) !== false) {
                    $matchedViewers[] = $v;
                }
            }
        }
    }

    if ($action === "insert") {
        $viewer = new Viewer(null, $_POST["name"], $_POST["sex"], $_POST["mailId"], $_POST["age"], $_POST["city"], $_POST["stateAb"]);
        $service->addViewer($viewer);
        $resultMessage = "✅ Viewer inserted.";
    }

    if ($action === "update") {
        $viewer = $service->getViewerById($_POST["viewerId"]);
        if ($viewer) {
            $viewer->setName($_POST["newName"]);
            $service->updateViewer($viewer);
            $resultMessage = "✅ Viewer name updated.";
        } else {
            $resultMessage = "❌ Viewer not found.";
        }
    }

    if ($action === "delete") {
        $val = $_POST["delete_value"];
        $deleted = false;

        if (is_numeric($val)) {
            $service->deleteViewer($val);
            $deleted = true;
        } else {
            foreach ($service->getAllViewers() as $v) {
                if (strcasecmp($v->getName(), $val) == 0) {
                    $service->deleteViewer($v->getViewerId());
                    $deleted = true;
                }
            }
        }

        $resultMessage = $deleted ? "✅ Viewer deleted." : "❌ Viewer not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Viewer Manager</title>
    <style>
        body { font-family: Arial; background: #f7f7f7; padding: 20px; }
        .box { background: #e0e0e0; padding: 20px; margin-bottom: 20px; width: 400px; }
        label { display: inline-block; width: 120px; }
        input[type=text], input[type=email], input[type=number] {
            width: 200px;
            padding: 5px;
            margin-bottom: 10px;
        }
        input[type=submit] {
            background: black; color: white; font-weight: bold; padding: 5px 10px; border: none; cursor: pointer;
        }
    </style>
</head>
<body>

<h2>🎛️ Viewer Management Panel</h2>

<div class="box">
    <form method="POST">
        <label>Search Name/ID:</label>
        <input type="text" name="search_value" required>
        <input type="hidden" name="action" value="search">
        <input type="submit" value="SUBMIT NAME">
    </form>
</div>

<div class="box">
    <form method="POST">
        <label>Name:</label> <input type="text" name="name" required><br>
        <label>Sex:</label> <input type="text" name="sex" maxlength="1"><br>
        <label>Email:</label> <input type="email" name="mailId" required><br>
        <label>Age:</label> <input type="number" name="age" required><br>
        <label>City:</label> <input type="text" name="city"><br>
        <label>StateAb:</label> <input type="text" name="stateAb" maxlength="2"><br>
        <input type="hidden" name="action" value="insert">
        <input type="submit" value="INSERT VIEWER">
    </form>
</div>

<div class="box">
    <form method="POST">
        <label>Viewer ID:</label> <input type="number" name="viewerId" required><br>
        <label>New Name:</label> <input type="text" name="newName" required><br>
        <input type="hidden" name="action" value="update">
        <input type="submit" value="UPDATE NAME">
    </form>
</div>

<div class="box">
    <form method="POST">
        <label>Delete by ID/Name:</label>
        <input type="text" name="delete_value" required>
        <input type="hidden" name="action" value="delete">
        <input type="submit" value="DELETE VIEWER">
    </form>
</div>

<?php if ($resultMessage): ?>
    <p><strong><?= $resultMessage ?></strong></p>
<?php endif; ?>

<?php if (!empty($matchedViewers)): ?>
    <h3>🔍 Search Results:</h3>
    <ul>
        <?php foreach ($matchedViewers as $v): ?>
            <li>
                <?= "ID: {$v->getViewerId()}, Name: {$v->getName()}, Email: {$v->getMailId()}" ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>
</html>
