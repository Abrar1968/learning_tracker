/**
 * Dark Mode Handler
 * Manages theme switching with localStorage persistence and system preference detection
 */
export function initDarkMode() {
    const html = document.documentElement;
    
    // Get saved theme or default to system
    const savedTheme = localStorage.getItem('theme') || 'system';
    
    // Apply theme
    applyTheme(savedTheme);
    
    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (localStorage.getItem('theme') === 'system') {
            applyTheme('system');
        }
    });
    
    // Expose theme functions globally for Alpine.js
    window.darkMode = {
        toggle() {
            const current = localStorage.getItem('theme') || 'system';
            const next = current === 'dark' ? 'light' : (current === 'light' ? 'system' : 'dark');
            this.setTheme(next);
            return next;
        },
        
        setTheme(theme) {
            localStorage.setItem('theme', theme);
            applyTheme(theme);
            
            // Sync with server if authenticated
            if (window.axios && document.querySelector('meta[name="user-id"]')) {
                window.axios.patch('/api/preferences', { theme })
                    .catch(() => {}); // Silently fail
            }
            
            // Dispatch event for Alpine.js components
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme } }));
        },
        
        getTheme() {
            return localStorage.getItem('theme') || 'system';
        },
        
        isDark() {
            const theme = this.getTheme();
            if (theme === 'system') {
                return window.matchMedia('(prefers-color-scheme: dark)').matches;
            }
            return theme === 'dark';
        }
    };
}

function applyTheme(theme) {
    const html = document.documentElement;
    
    if (theme === 'system') {
        // Check system preference
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }
    } else if (theme === 'dark') {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
    }
}

// Initialize on load
document.addEventListener('DOMContentLoaded', () => {
    initDarkMode();
});

// Also init immediately for faster theme application
initDarkMode();
