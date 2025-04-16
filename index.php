<!-- Jordan Smith-Acquah 1002098372 -->
<!-- Salem Iranloye 1002156031 -->
 
<?php
require_once "Viewer.php";
require_once "ViewerService.php";

$service = new ViewerService();
$viewers = $service->getAllViewers();
$resultMessage = "";
$matchedViewers = [];

// Handle messages from redirects
$message = "";
if (isset($_GET["message"])) {
    if ($_GET["message"] === "deleted") {
        $message = "✅ Viewer deleted successfully.";
    } else if ($_GET["message"] === "notfound") {
        $message = "❌ Viewer not found.";
    }
}

// Handle form actions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"];

    if ($action === "search") {
        $keyword = $_POST["search_value"];
        
        if (is_numeric($keyword)) {
            $viewer = $service->getViewerById($keyword);
            if ($viewer) $matchedViewers[] = $viewer;
        } else {
            foreach ($viewers as $v) {
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
        $viewer = new Viewer(
            null, 
            $_POST["name"], 
            $_POST["sex"], 
            $_POST["mailId"], 
            $_POST["age"], 
            $_POST["city"], 
            $_POST["stateAb"]
        );
        $service->addViewer($viewer);
        $resultMessage = "✅ Viewer inserted.";
        // Refresh viewers list
        $viewers = $service->getAllViewers();
    }

    if ($action === "update") {
        $viewer = $service->getViewerById($_POST["viewerId"]);
        if ($viewer) {
            $viewer->setName($_POST["newName"]);
            $service->updateViewer($viewer);
            $resultMessage = "✅ Viewer name updated.";
            // Refresh viewers list
            $viewers = $service->getAllViewers();
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
            foreach ($viewers as $v) {
                if (strcasecmp($v->getName(), $val) == 0) {
                    $service->deleteViewer($v->getViewerId());
                    $deleted = true;
                    break;
                }
            }
        }
    
        $resultMessage = $deleted ? "✅ Viewer deleted." : "❌ Viewer not found.";
        // Refresh viewers list
        $viewers = $service->getAllViewers();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Viewer Management System</title>
    <style>
        :root {
            --primary-color: #3a86ff;
            --secondary-color: #8338ec;
            --accent-color: #ff006e;
            --light-bg: #f8f9fa;
            --dark-bg: #212529;
            --border-radius: 12px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            padding: 20px;
            margin: 0;
            color: #333;
        }
        
        .page-title {
            text-align: center;
            margin-bottom: 30px;
            color: var(--dark-bg);
            font-size: 28px;
            font-weight: 600;
        }
        
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .bento-box {
            background: white;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }
        
        .bento-box:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }
        
        .box-search {
            border-top: 5px solid var(--primary-color);
        }
        
        .box-add {
            border-top: 5px solid var(--secondary-color);
        }
        
        .box-update {
            border-top: 5px solid #ff9f1c;
        }
        
        .box-delete {
            border-top: 5px solid var(--accent-color);
        }
        
        .box-results {
            border-top: 5px solid #2dc653;
            min-height: 200px;
            grid-column: span 2;
        }
        
        .box-table {
            grid-column: 1 / -1;
            overflow: auto;
            max-height: 600px;
            padding-bottom: 10px;
        }
        
        .box-icon {
            font-size: 24px;
            margin-right: 10px;
            vertical-align: middle;
        }
        
        h3 {
            margin-top: 0;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            font-size: 18px;
            color: #333;
            display: flex;
            align-items: center;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #555;
        }
        
        input[type=text], input[type=email], input[type=number], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: var(--transition);
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(58, 134, 255, 0.1);
        }
        
        input[type=submit] {
            width: 100%;
            background: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: var(--transition);
        }
        
        input[type=submit]:hover {
            background: #2a75e6;
        }
        
        .box-search input[type=submit] {
            background: var(--primary-color);
        }
        
        .box-add input[type=submit] {
            background: var(--secondary-color);
        }
        
        .box-update input[type=submit] {
            background: #ff9f1c;
        }
        
        .box-delete input[type=submit] {
            background: var(--accent-color);
        }
        
        .result-item {
            padding: 12px;
            margin-bottom: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: var(--transition);
        }
        
        .result-item:hover {
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .message {
            padding: 15px;
            margin: 0 0 20px 0;
            background-color: #e8f4fd;
            border-radius: var(--border-radius);
            border-left: 5px solid var(--primary-color);
            font-weight: 500;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        tr {
            border-bottom: 1px solid #f2f2f2;
            transition: var(--transition);
        }
        
        tr:last-child {
            border-bottom: none;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .actions a {
            display: inline-block;
            margin-right: 8px;
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 500;
            transition: var(--transition);
        }
        
        .actions a:hover {
            color: var(--secondary-color);
        }
        
        .edit-btn {
            color: #ff9f1c;
        }
        
        .delete-btn {
            color: var(--accent-color);
        }
        
        @media (max-width: 768px) {
            .bento-grid {
                grid-template-columns: 1fr;
            }
            
            .box-results {
                grid-column: 1;
            }
        }
    </style>
</head>
<body>

<h1 class="page-title">🎛️ Viewer Management System</h1>

<?php if ($message): ?>
    <div class="message">
        <?= $message ?>
    </div>
<?php endif; ?>

<div class="bento-grid">
    <div class="bento-box box-search">
        <h3><span class="box-icon">🔍</span>Search Viewer</h3>
        <form method="POST">
            <div class="form-group">
                <label>Name or ID:</label>
                <input type="text" name="search_value" required placeholder="Enter name or ID">
            </div>
            <input type="hidden" name="action" value="search">
            <input type="submit" value="Search">
        </form>
    </div>

    <div class="bento-box box-add">
        <h3><span class="box-icon">➕</span>Add New Viewer</h3>
        <form method="POST">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" maxlength="15" required placeholder="Full name">
            </div>
            <div class="form-group">
                <label>Sex:</label>
                <select name="sex" required>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="mailId" required placeholder="email@example.com">
            </div>
            <div class="form-group">
                <label>Age:</label>
                <input type="number" name="age" required placeholder="Age">
            </div>
            <div class="form-group">
                <label>City:</label>
                <input type="text" name="city" required placeholder="City">
            </div>
            <div class="form-group">
                <label>State:</label>
                <input type="text" name="stateAb" maxlength="2" required placeholder="TX">
            </div>
            <input type="hidden" name="action" value="insert">
            <input type="submit" value="Add Viewer">
        </form>
    </div>

    <div class="bento-box box-update">
        <h3><span class="box-icon">✏️</span>Update Viewer Name</h3>
        <form method="POST">
            <div class="form-group">
                <label>Viewer ID:</label>
                <input type="number" name="viewerId" required placeholder="Enter ID">
            </div>
            <div class="form-group">
                <label>New Name:</label>
                <input type="text" name="newName" required placeholder="New name">
            </div>
            <input type="hidden" name="action" value="update">
            <input type="submit" value="Update Name">
        </form>
    </div>

    <div class="bento-box box-delete">
        <h3><span class="box-icon">❌</span>Delete Viewer</h3>
        <form method="POST">
            <div class="form-group">
                <label>ID or Name:</label>
                <input type="text" name="delete_value" required placeholder="Enter ID or name">
            </div>
            <input type="hidden" name="action" value="delete">
            <input type="submit" value="Delete Viewer">
        </form>
    </div>

    <div class="bento-box box-results">
        <h3><span class="box-icon">📊</span>Results</h3>
        
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
    
    <div class="bento-box box-table">
        <h3><span class="box-icon">👥</span>Viewer List</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Sex</th>
                <th>Email</th>
                <th>Age</th>
                <th>City</th>
                <th>State</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($viewers as $viewer): ?>
                <tr>
                    <td><?= $viewer->getViewerId(); ?></td>
                    <td><?= $viewer->getName(); ?></td>
                    <td><?= $viewer->getSex(); ?></td>
                    <td><?= $viewer->getMailId(); ?></td>
                    <td><?= $viewer->getAge(); ?></td>
                    <td><?= $viewer->getCity(); ?></td>
                    <td><?= $viewer->getStateAb(); ?></td>
                    <td class="actions">
                        <a href="updateViewer.php?id=<?= $viewer->getViewerId(); ?>" class="edit-btn">✏️ Edit</a>
                        <a href="deleteViewer.php?id=<?= $viewer->getViewerId(); ?>" onclick="return confirm('Are you sure you want to delete this viewer?');" class="delete-btn">❌ Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

</body>
</html>