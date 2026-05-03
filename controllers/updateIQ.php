<?php
session_start();
require_once __DIR__ . '/../models/UserModel.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['iq'])) {
    $_SESSION['iq'] = $data['iq'];
    
    // Also update the database
    $userModel = new UserModel();
    $user = $userModel->getUserByLogin($_SESSION['username']);
    if ($user) {
        $userModel->updateGameOneScore($user['id'], $data['iq']);
    }
}

echo json_encode(["status" => "success"]);