<?php
function page_header($title = 'Subscription Manager') { ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="app">
  <aside class="sidebar">
    <div class="brand"><i class="fa-solid fa-layer-group"></i><span>SubManager</span></div>
    <a href="index.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
    <a href="subscriptions.php"><i class="fa-solid fa-list-check"></i> Subscriptions</a>
    <a href="add-subscription.php"><i class="fa-solid fa-plus"></i> Add Subscription</a>
    <a href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a>
    <a href="cards.php"><i class="fa-solid fa-credit-card"></i> Payment Cards</a>
  </aside>
  <main class="content">
    <div class="topbar">
      <div>
        <h1><?= htmlspecialchars($title) ?></h1>
        <p>Track renewals, cards, categories, and monthly costs.</p>
      </div>
      <a class="btn btn-primary" href="add-subscription.php"><i class="fa-solid fa-plus"></i> Add New</a>
    </div>
<?php }

function page_footer() { ?>
  </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } ?>
