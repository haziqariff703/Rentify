/**
 * Car Form Scripts
 * Handles image preview and color picker interactions for Add/Edit Car pages.
 *
 * @file webroot/js/views/Cars/form.js
 */
document.addEventListener('DOMContentLoaded', function() {
    // Image preview on file select
    const imageInput = document.getElementById('imageInput');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    // Check if preview container has an img tag or is a placeholder div
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        // Replace placeholder div content or the div itself
                        // Better to keep structure consistent: replace content or src
                         preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" style="width:100%; height:200px; object-fit:cover; border-radius:12px;">';
                        // If it was a div with class 'no-image', we might want to swap it to a clean state, 
                        // but setting innerHTML of the div to an img works for visual preview.
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Color picker preview update
    const colorInput = document.querySelector('input[type="color"]');
    if (colorInput) {
        colorInput.addEventListener('input', function(e) {
            const preview = document.querySelector('.color-preview');
            if (preview) {
                preview.style.background = e.target.value;
            }
        });
    }
});
