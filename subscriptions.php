<?php require 'db.php'; require 'functions.php'; require 'layout.php';
$rows = $pdo->query("SELECT s.*, c.name category, p.name card FROM subscriptions s LEFT JOIN categories c ON s.category_id=c.id LEFT JOIN payment_cards p ON s.payment_card_id=p.id ORDER BY s.next_billing_date ASC")->fetchAll();
page_header('Subscriptions'); ?>
<div class="cardx">
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>Service</th><th>Category</th><th>Cycle</th><th>Next Billing</th><th>Amount</th><th>Card</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
      <?php foreach($rows as $r): ?>
        <tr>
          <td><strong><?= htmlspecialchars($r['service_name']) ?></strong><br><small><?= htmlspecialchars($r['notes'] ?? '') ?></small></td>
          <td><?= htmlspecialchars($r['category'] ?? '-') ?></td>
          <td><?= htmlspecialchars($r['billing_cycle']) ?></td>
          <td><?= htmlspecialchars($r['next_billing_date']) ?></td>
          <td><?= money($r['amount']) ?></td>
          <td><?= htmlspecialchars($r['card'] ?? '-') ?></td>
          <td><span class="badge-status <?= status_class($r['next_billing_date'],$r['status']) ?>"><?= status_label($r['next_billing_date'],$r['status']) ?></span></td>
          <td><a class="btn btn-sm btn-outline-primary" href="edit-subscription.php?id=<?= $r['id'] ?>">Edit</a> <a onclick="return confirm('Delete this subscription?')" class="btn btn-sm btn-outline-danger" href="delete-subscription.php?id=<?= $r['id'] ?>">Delete</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php page_footer(); ?>
