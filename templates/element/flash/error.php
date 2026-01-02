<?php

/**
 * Error Flash Toast
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
$id = 'toast-' . uniqid();
?>
<div id="<?= $id ?>" class="toast show shadow-lg overflow-hidden" role="alert" aria-live="assertive" aria-atomic="true" style="min-width: 350px; background-color: #dc3545; color: white; border: none; border-radius: 8px;">
    <div class="toast-header" style="background-color: rgba(255,255,255,0.1); color: white; border-bottom: 1px solid rgba(255,255,255,0.1);">
        <i class="fas fa-times-circle me-2"></i>
        <strong class="me-auto">Error</strong>
        <small>Just now</small>
        <button type="button" class="btn-close btn-close-white" aria-label="Close" onclick="document.getElementById('<?= $id ?>').remove();"></button>
    </div>
    <div class="toast-body font-weight-normal" style="font-size: 0.95rem;">
        <?= $message ?>
    </div>
</div>