<?php
function money($amount) {
    return '$' . number_format((float)$amount, 2);
}

function status_class($nextDate, $status) {
    if ($status !== 'Active') return 'status-muted';
    $today = new DateTime('today');
    $next = new DateTime($nextDate);
    $diff = (int)$today->diff($next)->format('%r%a');
    if ($diff < 0) return 'status-overdue';
    if ($diff <= 7) return 'status-soon';
    return 'status-active';
}

function status_label($nextDate, $status) {
    if ($status !== 'Active') return $status;
    $today = new DateTime('today');
    $next = new DateTime($nextDate);
    $diff = (int)$today->diff($next)->format('%r%a');
    if ($diff < 0) return 'Overdue';
    if ($diff <= 7) return 'Due Soon';
    return 'Active';
}
?>
