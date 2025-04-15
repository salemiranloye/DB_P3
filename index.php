<?php
require_once "Viewer.php";
require_once "ViewerService.php";

$service = new ViewerService();
$viewers = $service->getAllViewers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Viewers</title>
    <style>
        table {
            border-collapse: collapse;
            width: 90%;
        }
        th, td {
            border: 1px solid gray;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        a {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <h2>Viewer List</h2>
    <a href="addViewer.php">➕ Add New Viewer</a><br><br>

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
                <td>
                    <a href="updateViewer.php?id=<?= $viewer->getViewerId(); ?>">✏️ Edit</a>
                    <a href="deleteViewer.php?id=<?= $viewer->getViewerId(); ?>" onclick="return confirm('Are you sure you want to delete this viewer?');">❌ Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
