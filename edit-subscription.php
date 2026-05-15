<?php require 'db.php'; require 'layout.php';
$id = (int)($_GET['id'] ?? 0);
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$cards = $pdo->query("SELECT * FROM payment_cards ORDER BY name")->fetchAll();
$stmt = $pdo->prepare("SELECT * FROM subscriptions WHERE id=?"); $stmt->execute([$id]); $sub = $stmt->fetch();
if (!$sub) die('Subscription not found.');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("UPDATE subscriptions SET service_name=?, category_id=?, start_date=?, billing_cycle=?, next_billing_date=?, amount=?, payment_card_id=?, status=?, reminder_days=?, notes=? WHERE id=?");
  $stmt->execute([$_POST['service_name'], $_POST['category_id'] ?: null, $_POST['start_date'] ?: null, $_POST['billing_cycle'], $_POST['next_billing_date'], $_POST['amount'], $_POST['payment_card_id'] ?: null, $_POST['status'], $_POST['reminder_days'], $_POST['notes'], $id]);
  header('Location: subscriptions.php'); exit;
}
page_header('Edit Subscription'); include 'form-subscription.php'; page_footer();
