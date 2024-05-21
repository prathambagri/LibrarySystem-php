<?php
defined('server') ? null : define("server", "localhost");
defined('user') ? null : define("user", "root");
defined('pass') ? null : define("pass", "");
defined('db') ? null : define("db", "db_onlinelibrary");

$c = mysqli_connect(server, user, pass);
if (!$c) {
    die(json_encode(["message" => "Database connection failed: " . mysqli_connect_error()]));
}
if (!mysqli_select_db($c, db)) {
    die(json_encode(["message" => "Database selection failed: " . mysqli_error($c)]));
}
$data = json_decode(file_get_contents('php://input'), true);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['update_review'])) {
    $id = isset($data['id']) ? (int)$data['id'] : null;
    $review = isset($data['review']) ? $data['review'] : null;
    if ($id !== null && $review !== null) {
        $stmt = mysqli_prepare($c, "UPDATE tbltransaction SET review = ? WHERE TransactionID = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $review, $id);
            $result = mysqli_stmt_execute($stmt);
            if ($result) {
                echo json_encode(["message" => "Thanks for your input"]);
            } else {
                echo json_encode(["message" => "Error updating review: " . mysqli_stmt_error($stmt)]);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(["message" => "Error preparing statement: " . mysqli_error($c)]);
        }
    } else {
        echo json_encode(["message" => "Invalid input data"]);
    }
} else {
    echo json_encode(["message" => "Invalid request method or missing update_review flag"]);
}

mysqli_close($c);
