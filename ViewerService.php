<?php
require_once "Database.php";
require_once "Viewer.php";

class ViewerService {
    private $pdo;

    public function __construct() {
        $this->pdo = (new Database())->getConnection();
    }

    // CREATE
    public function addViewer($viewer) {
        $sql = "INSERT INTO VIEWER (Name, Sex, MailId, Age, City, StateAb) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $viewer->getName(),
            $viewer->getSex(),
            $viewer->getMailId(),
            $viewer->getAge(),
            $viewer->getCity(),
            $viewer->getStateAb()
        ]);
    }

    // READ ALL
    public function getAllViewers() {
        $sql = "SELECT * FROM VIEWER";
        $stmt = $this->pdo->query($sql);
        $viewers = [];
        while ($row = $stmt->fetch()) {
            $viewers[] = new Viewer(
                $row["ViewerId"], $row["Name"], $row["Sex"], $row["MailId"],
                $row["Age"], $row["City"], $row["StateAb"]
            );
        }
        return $viewers;
    }

    // READ ONE
    public function getViewerById($id) {
        $sql = "SELECT * FROM VIEWER WHERE ViewerId = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return new Viewer(
            $row["ViewerId"], $row["Name"], $row["Sex"], $row["MailId"],
            $row["Age"], $row["City"], $row["StateAb"]
        );
    }

    // UPDATE
    public function updateViewer($viewer) {
        $sql = "UPDATE VIEWER SET Name=?, Sex=?, MailId=?, Age=?, City=?, StateAb=? WHERE ViewerId=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $viewer->getName(),
            $viewer->getSex(),
            $viewer->getMailId(),
            $viewer->getAge(),
            $viewer->getCity(),
            $viewer->getStateAb(),
            $viewer->getViewerId()
        ]);
    }

    // DELETE
    public function deleteViewer($id) {
        $sql = "DELETE FROM VIEWER WHERE ViewerId=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}
?>
