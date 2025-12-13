export function showToast(message, type = 'info') {
    window.dispatchEvent(new CustomEvent('toast', {
        detail: { message, type }
    }));
}

// Make globally available
window.showToast = showToast;
