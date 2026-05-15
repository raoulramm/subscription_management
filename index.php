<?php
require 'db.php'; require 'functions.php'; require 'layout.php';

$totalMonthly = $pdo->query("
SELECT SUM(amount) total 
FROM subscriptions 
WHERE status='Active' AND billing_cycle='Monthly'
")->fetch()['total'] ?? 0;


$totalYearly = $pdo->query("
SELECT SUM(amount) total 
FROM subscriptions 
WHERE status='Active' AND billing_cycle='Yearly'
")->fetch()['total'] ?? 0;

$totalYearCost = $pdo->query("
SELECT SUM(
    CASE 
        WHEN billing_cycle='Monthly' THEN amount*12 
        WHEN billing_cycle='Yearly' THEN amount 
    END
) total 
FROM subscriptions 
WHERE status='Active'
")->fetch()['total'] ?? 0;


$active = $pdo->query("SELECT COUNT(*) c FROM subscriptions WHERE status='Active'")->fetch()['c'];
$dueSoon = $pdo->query("SELECT COUNT(*) c FROM subscriptions WHERE status='Active' AND next_billing_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)")->fetch()['c'];
$overdue = $pdo->query("SELECT COUNT(*) c FROM subscriptions WHERE status='Active' AND next_billing_date < CURDATE()")->fetch()['c'];

$categoryRows = $pdo->query("SELECT COALESCE(c.name,'Uncategorized') label, SUM(CASE WHEN s.billing_cycle='Monthly' THEN s.amount ELSE s.amount/12 END) total FROM subscriptions s LEFT JOIN categories c ON s.category_id=c.id WHERE s.status='Active' GROUP BY label ORDER BY total DESC")->fetchAll();
$cardRows = $pdo->query("SELECT COALESCE(p.name,'No Card') label, SUM(CASE WHEN s.billing_cycle='Monthly' THEN s.amount ELSE s.amount/12 END) total FROM subscriptions s LEFT JOIN payment_cards p ON s.payment_card_id=p.id WHERE s.status='Active' GROUP BY label ORDER BY total DESC")->fetchAll();
$recent = $pdo->query("SELECT s.*, c.name category, p.name card FROM subscriptions s LEFT JOIN categories c ON s.category_id=c.id LEFT JOIN payment_cards p ON s.payment_card_id=p.id ORDER BY s.next_billing_date ASC LIMIT 8")->fetchAll();

$monthlyRenewals = $pdo->query("
SELECT s.*, c.name category, p.name card
FROM subscriptions s
LEFT JOIN categories c ON s.category_id=c.id
LEFT JOIN payment_cards p ON s.payment_card_id=p.id
WHERE s.billing_cycle='Monthly'
ORDER BY s.next_billing_date ASC
LIMIT 8
")->fetchAll();

$yearlyRenewals = $pdo->query("
SELECT s.*, c.name category, p.name card
FROM subscriptions s
LEFT JOIN categories c ON s.category_id=c.id
LEFT JOIN payment_cards p ON s.payment_card_id=p.id
WHERE s.billing_cycle='Yearly'
ORDER BY s.next_billing_date ASC
LIMIT 8
")->fetchAll();

page_header('Subscription Management Dashboard');
?>
<div class="grid-cards">
  <div class="stat"><span>Monthly Total</span><strong><?= money($totalMonthly) ?></strong></div>
  <div class="stat"><span>Yearly Total</span><strong><?= money($totalYearly) ?></strong></div>
  <div class="stat"><span>Total / Year</span><strong><?= money($totalYearCost) ?></strong></div>
  <div class="stat"><span>Active Subs</span><strong><?= $active ?></strong></div>
  <div class="stat warning"><span>Due Next 7 Days</span><strong><?= $dueSoon ?></strong></div>
  <div class="stat danger"><span>Overdue</span><strong><?= $overdue ?></strong></div>
</div>

<div class="row g-4 mt-1">

  <!-- LEFT: TABLES -->
  <div class="col-lg-7">

    <?php
    $tables = [
      'Upcoming Renewals' => $recent,
      'Monthly Renewals' => $monthlyRenewals,
      'Yearly Renewals' => $yearlyRenewals
    ];
    ?>

    <?php foreach($tables as $title => $rows): ?>
      <div class="cardx mb-4">
        <h4><?= $title ?></h4>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>Service</th>
                <th>Category</th>
                <th>Next Billing</th>
                <th>Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($rows as $r): ?>
                <tr>
                  <td><?= htmlspecialchars($r['service_name']) ?></td>
                  <td><?= htmlspecialchars($r['category'] ?? '-') ?></td>
                  <td><?= htmlspecialchars($r['next_billing_date']) ?></td>
                  <td><?= money($r['amount']) ?></td>
                  <td>
                    <span class="badge-status <?= status_class($r['next_billing_date'],$r['status']) ?>">
                      <?= status_label($r['next_billing_date'],$r['status']) ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endforeach; ?>

  </div>

  <!-- RIGHT: CHARTS -->
  <div class="col-lg-5">
    <div class="cardx mb-4">
      <h4>Monthly Cost by Category</h4>
      <div style="height:260px;">
        <canvas id="categoryChart"></canvas>
      </div>
    </div>

    <div class="cardx">
      <h4>Monthly Cost by Card</h4>
      <div style="height:260px;">
        <canvas id="cardChart"></canvas>
      </div>
    </div>
  </div>

</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const catLabels = <?= json_encode(array_column($categoryRows,'label')) ?>;
  const catData = <?= json_encode(array_map('floatval', array_column($categoryRows,'total'))) ?>;

  const cardLabels = <?= json_encode(array_column($cardRows,'label')) ?>;
  const cardData = <?= json_encode(array_map('floatval', array_column($cardRows,'total'))) ?>;

  new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: { labels: catLabels, datasets: [{ data: catData }] },
    options: { responsive: true, maintainAspectRatio: false }
  });

  new Chart(document.getElementById('cardChart'), {
    type: 'bar',
    data: { labels: cardLabels, datasets: [{ label: 'Monthly Cost', data: cardData }] },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } }
    }
  });
});
</script>
<?php page_footer(); ?>
