<?php
require_once "database.php";
requireLogin();

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["id"])) {
    $stmt = $database->prepare("DELETE FROM uploads WHERE id = :id AND user_id = :user_id");
    $stmt->bindParam(":id", $data["id"]);
    $stmt->bindParam(":user_id", $_SESSION["user_id"]);
    $stmt->execute();
}
?>
