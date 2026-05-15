<?php require 'db.php'; require 'layout.php';
if ($_SERVER['REQUEST_METHOD']==='POST' && !empty($_POST['name'])) {$stmt=$pdo->prepare("INSERT IGNORE INTO payment_cards(name,last_four) VALUES(?,?)"); $stmt->execute([$_POST['name'], $_POST['last_four'] ?: null]);}
if (isset($_GET['delete'])) {$pdo->prepare("DELETE FROM payment_cards WHERE id=?")->execute([(int)$_GET['delete']]); header('Location: cards.php'); exit;}
$rows=$pdo->query("SELECT * FROM payment_cards ORDER BY name")->fetchAll(); page_header('Payment Cards'); ?>
<div class="cardx form-card"><form method="post" class="row g-2"><div class="col-md-8"><input name="name" class="form-control" placeholder="Card name / wallet"></div><div class="col-md-2"><input name="last_four" class="form-control" placeholder="Last 4"></div><div class="col-md-2"><button class="btn btn-primary w-100">Add</button></div></form></div>
<div class="cardx mt-4"><table class="table"><thead><tr><th>Name</th><th>Last Four</th><th></th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?= htmlspecialchars($r['name']) ?></td><td><?= htmlspecialchars($r['last_four'] ?? '-') ?></td><td class="text-end"><a class="btn btn-sm btn-outline-danger" href="?delete=<?= $r['id'] ?>">Delete</a></td></tr><?php endforeach; ?></tbody></table></div>
<?php page_footer(); ?>
