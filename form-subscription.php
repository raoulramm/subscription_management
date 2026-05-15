<?php $isEdit = isset($sub); ?>
<div class="cardx form-card">
<form method="post">
  <div class="row g-3">
    <div class="col-md-6"><label>Service Name</label><input required name="service_name" class="form-control" value="<?= htmlspecialchars($sub['service_name'] ?? '') ?>"></div>
    <div class="col-md-6"><label>Category</label><select name="category_id" class="form-select"><option value="">Select category</option><?php foreach($categories as $c): ?><option value="<?= $c['id'] ?>" <?= (($sub['category_id'] ?? '')==$c['id'])?'selected':'' ?>><?= htmlspecialchars($c['name']) ?></option><?php endforeach; ?></select></div>
    <div class="col-md-4"><label>Start Date</label><input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($sub['start_date'] ?? '') ?>"></div>
    <div class="col-md-4"><label>Billing Cycle</label><select name="billing_cycle" class="form-select"><option <?= (($sub['billing_cycle'] ?? '')=='Monthly')?'selected':'' ?>>Monthly</option><option <?= (($sub['billing_cycle'] ?? '')=='Yearly')?'selected':'' ?>>Yearly</option></select></div>
    <div class="col-md-4"><label>Next Billing Date</label><input required type="date" name="next_billing_date" class="form-control" value="<?= htmlspecialchars($sub['next_billing_date'] ?? '') ?>"></div>
    <div class="col-md-4"><label>Amount</label><input required type="number" step="0.01" name="amount" class="form-control" value="<?= htmlspecialchars($sub['amount'] ?? '') ?>"></div>
    <div class="col-md-4"><label>Payment/Card</label><select name="payment_card_id" class="form-select"><option value="">Select card</option><?php foreach($cards as $p): ?><option value="<?= $p['id'] ?>" <?= (($sub['payment_card_id'] ?? '')==$p['id'])?'selected':'' ?>><?= htmlspecialchars($p['name']) ?></option><?php endforeach; ?></select></div>
    <div class="col-md-2"><label>Status</label><select name="status" class="form-select"><option <?= (($sub['status'] ?? '')=='Active')?'selected':'' ?>>Active</option><option <?= (($sub['status'] ?? '')=='Paused')?'selected':'' ?>>Paused</option><option <?= (($sub['status'] ?? '')=='Cancelled')?'selected':'' ?>>Cancelled</option></select></div>
    <div class="col-md-2"><label>Reminder Days</label><input type="number" name="reminder_days" class="form-control" value="<?= htmlspecialchars($sub['reminder_days'] ?? '7') ?>"></div>
    <div class="col-12"><label>Notes</label><textarea name="notes" class="form-control" rows="3"><?= htmlspecialchars($sub['notes'] ?? '') ?></textarea></div>
  </div>
  <button class="btn btn-primary mt-4">Save Subscription</button>
  <a href="subscriptions.php" class="btn btn-light mt-4">Cancel</a>
</form>
</div>
