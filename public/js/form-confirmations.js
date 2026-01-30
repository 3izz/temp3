// Form Confirmation JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Handle delete confirmations
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', function(e) {
            const message = this.getAttribute('data-confirm');
            if (!confirm(message || 'Are you sure?')) {
                e.preventDefault();
                return false;
            }
        });
    });
});
