/**
 * Reusable Delete Confirmation Component
 * Uses SweetAlert2 to confirm generic delete actions.
 * 
 * Usage:
 * <button id="delete-btn" data-confirm-message="Are you sure...?">Delete</button>
 * <div style="display:none">
 *     <?= $this->Form->postLink('', ['action' => 'delete', $id], ['id' => 'delete-form']) ?>
 * </div>
 *
 * @file webroot/js/components/delete-confirm.js
 */
/**
 * Global Delete Confirmation Component
 * Uses SweetAlert2 to intercept delete actions and show a confirmation dialog.
 * 
 * Logic:
 * Uses event capturing (true as 3rd arg) to intercept clicks BEFORE inline handlers run.
 * 
 * Usage:
 * Add class "delete-confirm" to any link/button.
 * Add data-confirm-message="Your message" (optional).
 * 
 * Example (CakePHP):
 * $this->Form->postLink('Delete', [...], [
 *     'class' => 'btn btn-danger delete-confirm',
 *     'data-confirm-message' => 'Delete this item?',
 *     'escape' => false
 * ])
 *
 * @file webroot/js/components/delete-confirm.js
 */
document.addEventListener('click', function(e) {
    // Check if clicked element or parent has .delete-confirm class
    const target = e.target.closest('.delete-confirm');
    
    // Only proceed if target exists
    if (!target) return;

    // If already confirmed, allow the event to proceed normally (executing inline onclick)
    if (target.dataset.confirmed === 'true') {
        // Clean up
        delete target.dataset.confirmed;
        return;
    }

    // Stop immediate propagation to prevent inline onclick from firing
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();

    const message = target.dataset.confirmMessage || "This action cannot be undone!";
    const title = target.dataset.confirmTitle || "Are you sure?";

    const confirmBtnText = target.dataset.confirmBtnText || '<i class="fas fa-trash me-1"></i> Yes, delete it!';
    const cancelBtnText = target.dataset.cancelBtnText || '<i class="fas fa-times me-1"></i> Cancel';
    const confirmBtnColor = target.dataset.confirmBtnColor || '#dc3545';
    const icon = target.dataset.icon || 'warning';

    Swal.fire({
        title: title,
        html: message,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: confirmBtnColor,
        cancelButtonColor: '#6c757d',
        confirmButtonText: confirmBtnText,
        cancelButtonText: cancelBtnText,
        customClass: {
            popup: 'glass-swal-popup'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Mark as confirmed and re-trigger click
            target.dataset.confirmed = 'true';
            target.click();
        }
    });

}, true); // Use Capture Phase to intercept before inline handlers
