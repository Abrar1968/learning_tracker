/**
 * Keyboard Shortcuts Handler
 * Global keyboard navigation for the application
 */
export function initKeyboardShortcuts() {
    if (!window.keyboardShortcutsEnabled) {
        window.keyboardShortcutsEnabled = true;
    }
    
    document.addEventListener('keydown', handleKeydown);
    
    // Expose functions globally
    window.keyboardShortcuts = {
        enable() {
            window.keyboardShortcutsEnabled = true;
        },
        disable() {
            window.keyboardShortcutsEnabled = false;
        },
        showHelp() {
            window.dispatchEvent(new CustomEvent('show-keyboard-help'));
        }
    };
}

function handleKeydown(e) {
    // Don't trigger shortcuts when typing in inputs
    if (isTyping(e.target)) {
        // Allow Escape to blur inputs
        if (e.key === 'Escape') {
            e.target.blur();
        }
        return;
    }
    
    if (!window.keyboardShortcutsEnabled) return;
    
    const key = e.key.toLowerCase();
    const isCtrl = e.ctrlKey || e.metaKey;
    const isShift = e.shiftKey;
    
    // Global shortcuts
    switch (true) {
        // ? - Show keyboard shortcuts help
        case key === '?' || (isShift && key === '/'):
            e.preventDefault();
            window.dispatchEvent(new CustomEvent('show-keyboard-help'));
            break;
            
        // Escape - Close modals/overlays
        case key === 'escape':
            window.dispatchEvent(new CustomEvent('close-modal'));
            break;
            
        // Ctrl/Cmd + K - Global search
        case isCtrl && key === 'k':
            e.preventDefault();
            window.dispatchEvent(new CustomEvent('open-global-search'));
            break;
            
        // g then h - Go Home/Dashboard
        case key === 'g':
            waitForSecondKey('h', () => navigateTo('/dashboard'));
            waitForSecondKey('r', () => navigateTo('/roadmaps'));
            waitForSecondKey('a', () => navigateTo('/activities'));
            waitForSecondKey('c', () => navigateTo('/certificates'));
            waitForSecondKey('p', () => navigateTo('/profile'));
            break;
            
        // n - New (context-aware)
        case key === 'n' && !isCtrl:
            handleNewAction();
            break;
            
        // j/k - Navigate up/down in lists
        case key === 'j':
            navigateList('down');
            break;
        case key === 'k':
            navigateList('up');
            break;
            
        // Enter - Select/Open focused item
        case key === 'enter' && !isCtrl:
            selectFocusedItem();
            break;
            
        // d - Toggle dark mode
        case key === 'd' && !isCtrl:
            if (window.darkMode) {
                window.darkMode.toggle();
            }
            break;
            
        // f - Focus/Search within page
        case key === 'f' && !isCtrl:
            e.preventDefault();
            focusPageSearch();
            break;
    }
}

function isTyping(element) {
    const tagName = element.tagName.toLowerCase();
    return tagName === 'input' || 
           tagName === 'textarea' || 
           tagName === 'select' ||
           element.isContentEditable;
}

let pendingSecondKey = null;
let secondKeyTimeout = null;

function waitForSecondKey(expectedKey, callback) {
    clearTimeout(secondKeyTimeout);
    
    const handler = (e) => {
        if (e.key.toLowerCase() === expectedKey) {
            e.preventDefault();
            callback();
        }
        document.removeEventListener('keydown', handler);
        clearTimeout(secondKeyTimeout);
    };
    
    document.addEventListener('keydown', handler, { once: true });
    
    secondKeyTimeout = setTimeout(() => {
        document.removeEventListener('keydown', handler);
    }, 1000);
}

function navigateTo(path) {
    window.location.href = path;
}

function handleNewAction() {
    const path = window.location.pathname;
    
    if (path.includes('/roadmaps')) {
        if (path.match(/\/roadmaps\/\d+/)) {
            // On roadmap show page - create new topic
            const createTopicBtn = document.querySelector('[data-action="create-topic"]');
            if (createTopicBtn) createTopicBtn.click();
        } else {
            // On roadmaps index - create new roadmap
            navigateTo('/roadmaps/create');
        }
    } else if (path.includes('/topics')) {
        // Create new resource
        const createResourceBtn = document.querySelector('[data-action="create-resource"]');
        if (createResourceBtn) createResourceBtn.click();
    }
}

function navigateList(direction) {
    const items = document.querySelectorAll('[data-navigable]');
    if (items.length === 0) return;
    
    const focused = document.querySelector('[data-navigable].focused, [data-navigable]:focus');
    let index = Array.from(items).indexOf(focused);
    
    if (direction === 'down') {
        index = index < items.length - 1 ? index + 1 : 0;
    } else {
        index = index > 0 ? index - 1 : items.length - 1;
    }
    
    items.forEach(item => item.classList.remove('focused'));
    items[index].classList.add('focused');
    items[index].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function selectFocusedItem() {
    const focused = document.querySelector('[data-navigable].focused');
    if (focused) {
        const link = focused.querySelector('a') || focused;
        if (link.href) {
            window.location.href = link.href;
        } else {
            focused.click();
        }
    }
}

function focusPageSearch() {
    const searchInput = document.querySelector('[data-page-search]');
    if (searchInput) {
        searchInput.focus();
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    initKeyboardShortcuts();
});
