/**
 * Table of Contents Generator and Reading Progress Bar
 */

// Generate Table of Contents
document.addEventListener('DOMContentLoaded', function() {
    generateTableOfContents();
    initReadingProgress();
});

/**
 * Generate Table of Contents from article headings
 */
function generateTableOfContents() {
    const content = document.querySelector('.article-content');
    const tocContainer = document.getElementById('table-of-contents');
    const tocWrapper = document.getElementById('toc-container');
    
    if (!content || !tocContainer || !tocWrapper) return;
    
    // Check if admin disabled TOC for this article
    const showToc = tocWrapper.getAttribute('data-show-toc') === 'true';
    if (!showToc) {
        tocWrapper.style.display = 'none';
        return;
    }
    
    // Check TOC mode (auto or custom)
    const tocMode = tocWrapper.getAttribute('data-toc-mode') || 'auto';
    const tocCustomContent = tocWrapper.getAttribute('data-toc-content');
    
    // Detect language direction
    const isRTL = document.documentElement.lang === 'ar' || 
                  document.documentElement.dir === 'rtl' ||
                  document.querySelector('html').getAttribute('lang') === 'ar';
    
    // Add RTL class if needed
    if (isRTL) {
        tocContainer.classList.add('rtl');
    }
    
    // Use custom TOC if mode is custom and content exists
    if (tocMode === 'custom' && tocCustomContent) {
        try {
            const customItems = JSON.parse(tocCustomContent);
            if (customItems && customItems.length > 0) {
                generateCustomTOC(customItems, tocContainer);
                tocWrapper.style.display = 'block';
                return;
            }
        } catch (e) {
            console.warn('Invalid custom TOC content, falling back to auto mode', e);
        }
    }
    
    // Auto mode - generate from headings
    const headings = content.querySelectorAll('h1, h2, h3, h4');
    
    // Hide TOC if less than minimum headings
    const MIN_HEADINGS_FOR_TOC = 4;
    
    if (headings.length < MIN_HEADINGS_FOR_TOC) {
        tocWrapper.style.display = 'none';
        return;
    }
    
    // Show TOC with fade-in effect
    tocWrapper.style.display = 'block';
    
    // Generate TOC links from headings
    headings.forEach((heading, index) => {
        // Add ID to heading if not exists
        if (!heading.id) {
            const headingText = heading.textContent.trim()
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .substring(0, 50);
            heading.id = 'heading-' + index + '-' + headingText;
        }
        
        // Create TOC link
        const link = document.createElement('a');
        link.href = '#' + heading.id;
        link.textContent = heading.textContent.trim();
        link.className = 'toc-' + heading.tagName.toLowerCase();
        link.setAttribute('data-heading-id', heading.id);
        
        // Smooth scroll on click
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active from all links
            tocContainer.querySelectorAll('a').forEach(a => a.classList.remove('active'));
            
            // Add active to clicked link
            link.classList.add('active');
            
            // Scroll to heading
            heading.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start',
                inline: 'nearest'
            });
            
            // Update URL without jumping
            if (history.pushState) {
                history.pushState(null, null, '#' + heading.id);
            }
        });
        
        tocContainer.appendChild(link);
    });
    
    // Highlight active section on scroll
    initScrollSpy(headings, tocContainer);
}

/**
 * Generate custom TOC from JSON data
 */
function generateCustomTOC(items, tocContainer) {
    items.forEach((item) => {
        const link = document.createElement('a');
        link.href = item.link || '#';
        link.textContent = item.text || 'Untitled';
        
        // Add class based on level
        const level = item.level || 1;
        link.className = 'toc-h' + level;
        
        // External link handling
        if (item.external || item.link.startsWith('http')) {
            link.target = '_blank';
            link.rel = 'noopener noreferrer';
            const externalIcon = document.createElement('span');
            externalIcon.textContent = ' ↗';
            externalIcon.style.fontSize = '0.8em';
            link.appendChild(externalIcon);
        } else {
            // Internal link - smooth scroll
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = item.link.substring(1); // Remove #
                const target = document.getElementById(targetId);
                
                if (target) {
                    tocContainer.querySelectorAll('a').forEach(a => a.classList.remove('active'));
                    link.classList.add('active');
                    
                    target.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start',
                        inline: 'nearest'
                    });
                    
                    if (history.pushState) {
                        history.pushState(null, null, item.link);
                    }
                }
            });
        }
        
        tocContainer.appendChild(link);
    });
}

/**
 * Initialize scroll spy to highlight current section
 */
function initScrollSpy(headings, tocContainer) {
    const observerOptions = {
        rootMargin: '-100px 0px -66%',
        threshold: 0
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.id;
                const links = tocContainer.querySelectorAll('a');
                
                // Remove active from all links
                links.forEach(link => link.classList.remove('active'));
                
                // Add active to current link
                const activeLink = tocContainer.querySelector(`a[data-heading-id="${id}"]`);
                if (activeLink) {
                    activeLink.classList.add('active');
                }
            }
        });
    }, observerOptions);
    
    // Observe all headings
    headings.forEach(heading => observer.observe(heading));
}

/**
 * Initialize Reading Progress Bar
 */
function initReadingProgress() {
    const progressBar = document.getElementById('reading-progress');
    if (!progressBar) return;
    
    window.addEventListener('scroll', function() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        progressBar.style.width = scrolled + '%';
    });
}

