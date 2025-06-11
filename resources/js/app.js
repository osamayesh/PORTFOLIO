import './bootstrap';

// Handle language switcher
document.addEventListener('DOMContentLoaded', function() {
    // Fix spacing for RTL language
    if (document.documentElement.classList.contains('rtl')) {
        // Adjust any specific RTL-specific dynamic JS here if needed
        const navItems = document.querySelectorAll('nav ul');
        navItems.forEach(ul => {
            ul.classList.remove('space-x-8', 'md:space-x-12');
            ul.classList.add('space-x-reverse', 'space-x-8', 'md:space-x-12');
        });
    }
});
