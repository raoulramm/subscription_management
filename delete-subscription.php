<?php require 'db.php';
$id = (int)($_GET['id'] ?? 0);
$pdo->prepare("DELETE FROM subscriptions WHERE id=?")->execute([$id]);
header('Location: subscriptions.php');
