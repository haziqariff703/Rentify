<?php

/**
 * Warning Flash Toast
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
$id = 'toast-' . uniqid();
?>
<div id="<?= $id ?>" class="toast show shadow-lg overflow-hidden" role="alert" aria-live="assertive" aria-atomic="true" style="min-width: 350px; background-color: #ffc107; color: #000; border: none; border-radius: 8px;">
    <div class="toast-header" style="background-color: rgba(255,255,255,0.4); color: #000; border-bottom: 1px solid rgba(0,0,0,0.05);">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong class="me-auto">Warning</strong>
        <small>Just now</small>
        <button type="button" class="btn-close" aria-label="Close" onclick="document.getElementById('<?= $id ?>').remove();"></button>
    </div>
    <div class="toast-body font-weight-normal" style="font-size: 0.95rem;">
        <?= $message ?>
    </div>
</div>
<script>
    setTimeout(function() {
        var toast = document.getElementById('<?= $id ?>');
        if (toast) {
            toast.classList.add('fade');
            setTimeout(function() {
                toast.remove();
            }, 300);
        }
    }, 3000);
</script>