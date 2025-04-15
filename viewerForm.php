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
        $searchPerformed = true; // Add this flag
        
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
        
        if (empty($matchedViewers)) {
            $resultMessage = "❌ No viewers found matching '$keyword'";
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
            $viewer = $service->getViewerById($val);
            if ($viewer) {
                $service->deleteViewer($val);
                $deleted = true;
            }
        } else {
            // Search for viewer by name
            $found = false;
            foreach ($service->getAllViewers() as $v) {
                if (strcasecmp($v->getName(), $val) == 0) {
                    $service->deleteViewer($v->getViewerId());
                    $deleted = true;
                    break;
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
        body { 
            font-family: Arial; 
            background: #f7f7f7; 
            padding: 20px; 
        }
        .container {
            display: flex;
            gap: 20px;
        }
        .form-container {
            flex: 1;
        }
        .results-container {
            flex: 1;
            position: sticky;
            top: 20px;
            align-self: flex-start;
        }
        .box { 
            background: #e0e0e0; 
            padding: 20px; 
            margin-bottom: 20px; 
            width: 400px; 
            border-radius: 5px;
        }
        .results-box {
            background: #f0f0f0;
            border-left: 4px solid #4CAF50;
            padding: 20px;
            margin-bottom: 20px;
            width: 400px;
            border-radius: 5px;
            min-height: 200px;
        }
        label { 
            display: inline-block; 
            width: 120px; 
        }
        input[type=text], input[type=email], input[type=number] {
            width: 200px;
            padding: 5px;
            margin-bottom: 10px;
        }
        input[type=submit] {
            background: black; 
            color: white; 
            font-weight: bold; 
            padding: 5px 10px; 
            border: none; 
            cursor: pointer;
        }
        .result-item {
            padding: 10px;
            margin-bottom: 5px;
            background: white;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        h3 {
            margin-top: 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>

<h2>🎛️ Viewer Management Panel</h2>

<div class="container">
    <div class="form-container">
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
                <label>Sex:</label><select name="sex" required>
                    <option value="M">Male</option><option value="F">Female</option>
                </select><br>
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
    </div>

    <div class="results-container">
        <div class="results-box">
            <h3>Results</h3>
            
            <?php if ($resultMessage): ?>
                <div class="result-item">
                    <strong><?= $resultMessage ?></strong>
                </div>
            <?php endif; ?>

            <?php if (!empty($matchedViewers)): ?>
                <h4>🔍 Search Results:</h4>
                <?php foreach ($matchedViewers as $v): ?>
                    <div class="result-item">
                        <?= "ID: {$v->getViewerId()}, Name: {$v->getName()}, Email: {$v->getMailId()}" ?>
                    </div>
                <?php endforeach; ?>
            <?php elseif (empty($resultMessage)): ?>
                <div class="result-item" style="color: #666;">
                    Results will appear here after form submission.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>