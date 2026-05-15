<?php require 'db.php'; require 'layout.php';
if ($_SERVER['REQUEST_METHOD']==='POST' && !empty($_POST['name'])) {$stmt=$pdo->prepare("INSERT IGNORE INTO categories(name) VALUES(?)"); $stmt->execute([$_POST['name']]);}
if (isset($_GET['delete'])) {$pdo->prepare("DELETE FROM categories WHERE id=?")->execute([(int)$_GET['delete']]); header('Location: categories.php'); exit;}
$rows=$pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll(); page_header('Categories'); ?>
<div class="cardx form-card"><form method="post" class="d-flex gap-2"><input name="name" class="form-control" placeholder="New category"><button class="btn btn-primary">Add</button></form></div>
<div class="cardx mt-4"><table class="table"><thead><tr><th>Name</th><th></th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?= htmlspecialchars($r['name']) ?></td><td class="text-end"><a class="btn btn-sm btn-outline-danger" href="?delete=<?= $r['id'] ?>">Delete</a></td></tr><?php endforeach; ?></tbody></table></div>
<?php page_footer(); ?>
