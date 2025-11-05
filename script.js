/**
 * Portfolio Website JavaScript Functions
 * Handles interactive elements and dynamic content
 * Author: Krupa Bhalsod
 */

/**
 * Creates a circular progress ring for skills display
 * @param {number} percentage - The skill percentage (0-100)
 * @returns {HTMLElement} Complete progress ring element
 */
function createCircle(percentage) {
    const radius = 75;
    const circumference = 2 * Math.PI * radius;
    const offset = circumference - (percentage / 100) * circumference;

    // Create SVG element
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('width', '150');
    svg.setAttribute('height', '150');
    svg.classList.add('progress-ring-svg');

    // Create background circle
    const circleBackground = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    circleBackground.setAttribute('cx', '75');
    circleBackground.setAttribute('cy', '75');
    circleBackground.setAttribute('r', '75');
    circleBackground.classList.add('progress-ring__circle-background');
    svg.appendChild(circleBackground);

    // Create progress circle
    const circleProgress = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    circleProgress.setAttribute('cx', '75');
    circleProgress.setAttribute('cy', '75');
    circleProgress.setAttribute('r', '75');
    circleProgress.classList.add('progress-ring__circle-progress');
    circleProgress.style.strokeDashoffset = offset;
    svg.appendChild(circleProgress);

    // Create percentage text
    const text = document.createElement('div');
    text.classList.add('percentage-text');
    text.textContent = `${percentage}%`;
    text.setAttribute('aria-label', `${percentage} percent proficiency`);

    // Create container element
    const container = document.createElement('div');
    container.classList.add('progress-ring');
    container.appendChild(svg);
    container.appendChild(text);

    return container;
}

/**
 * Initialize all progress rings when DOM is loaded
 */
document.addEventListener('DOMContentLoaded', function() {
    const progressContainer = document.querySelectorAll('.progress-ring');

    progressContainer.forEach(function(progressRing) {
        const percentage = parseInt(progressRing.getAttribute('data-percentage'));
        
        // Validate percentage value
        if (isNaN(percentage) || percentage < 0 || percentage > 100) {
            console.warn('Invalid percentage value:', percentage);
            return;
        }

        const circle = createCircle(percentage);
        progressRing.innerHTML = '';
        progressRing.appendChild(circle);
    });

    // Add smooth scrolling for navigation links
    initializeSmoothScrolling();
    
    // Initialize intersection observer for animations
    initializeScrollAnimations();
});

/**
 * Mobile Navigation Menu Functionality
 */
const menuBtn = document.querySelector('.menu-btn');
const sidebarContent = document.querySelector('.sidebar-content');

if (menuBtn && sidebarContent) {
    // Toggle mobile menu
    menuBtn.addEventListener('click', function(event) {
        sidebarContent.classList.toggle('active');
        event.stopPropagation();
        
        // Update ARIA attributes for accessibility
        const isExpanded = sidebarContent.classList.contains('active');
        menuBtn.setAttribute('aria-expanded', isExpanded);
        sidebarContent.setAttribute('aria-hidden', !isExpanded);
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        if (sidebarContent.classList.contains('active') &&
            !sidebarContent.contains(event.target) &&
            !menuBtn.contains(event.target)) {
            sidebarContent.classList.remove('active');
            menuBtn.setAttribute('aria-expanded', 'false');
            sidebarContent.setAttribute('aria-hidden', 'true');
        }
    });

    // Close menu when pressing Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && sidebarContent.classList.contains('active')) {
            sidebarContent.classList.remove('active');
            menuBtn.setAttribute('aria-expanded', 'false');
            sidebarContent.setAttribute('aria-hidden', 'true');
            menuBtn.focus(); // Return focus to menu button
        }
    });
}

/**
 * Initialize smooth scrolling for internal links
 */
function initializeSmoothScrolling() {
    const internalLinks = document.querySelectorAll('a[href^="#"]');
    
    internalLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                event.preventDefault();
                
                // Close mobile menu if open
                if (sidebarContent && sidebarContent.classList.contains('active')) {
                    sidebarContent.classList.remove('active');
                    menuBtn.setAttribute('aria-expanded', 'false');
                }
                
                // Smooth scroll to target
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Update URL without jumping
                history.pushState(null, '', targetId);
            }
        });
    });
}

/**
 * Initialize scroll-triggered animations using Intersection Observer
 */
function initializeScrollAnimations() {
    // Check if Intersection Observer is supported
    if (!('IntersectionObserver' in window)) {
        return; // Graceful degradation for older browsers
    }

    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                
                // Animate progress rings when they come into view
                if (entry.target.classList.contains('skill')) {
                    animateProgressRing(entry.target);
                }
            }
        });
    }, observerOptions);

    // Observe elements for animation
    const animateElements = document.querySelectorAll('.qualification, .internship, .projects, .skill');
    animateElements.forEach(function(element) {
        observer.observe(element);
    });
}

/**
 * Animate progress ring when it comes into view
 * @param {HTMLElement} skillElement - The skill container element
 */
function animateProgressRing(skillElement) {
    const progressRing = skillElement.querySelector('.progress-ring__circle-progress');
    
    if (progressRing) {
        // Get the final stroke-dashoffset value
        const finalOffset = progressRing.style.strokeDashoffset;
        
        // Start from full circle (no progress)
        progressRing.style.strokeDashoffset = '471';
        
        // Animate to final value
        setTimeout(function() {
            progressRing.style.transition = 'stroke-dashoffset 1.5s ease-in-out';
            progressRing.style.strokeDashoffset = finalOffset;
        }, 200);
    }
}

/**
 * Form validation and submission handler
 */
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('.contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            const formData = new FormData(this);
            let isValid = true;
            
            // Basic client-side validation
            const requiredFields = ['name', 'contact', 'email', 'title', 'message'];
            
            requiredFields.forEach(function(fieldName) {
                const field = formData.get(fieldName);
                const fieldElement = document.getElementById(fieldName);
                
                if (!field || field.trim() === '') {
                    isValid = false;
                    if (fieldElement) {
                        fieldElement.classList.add('error');
                        fieldElement.setAttribute('aria-invalid', 'true');
                    }
                } else if (fieldElement) {
                    fieldElement.classList.remove('error');
                    fieldElement.setAttribute('aria-invalid', 'false');
                }
            });
            
            // Email validation
            const email = formData.get('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                isValid = false;
                const emailField = document.getElementById('email');
                if (emailField) {
                    emailField.classList.add('error');
                    emailField.setAttribute('aria-invalid', 'true');
                }
            }
            
            if (!isValid) {
                event.preventDefault();
                
                // Focus on first error field
                const firstError = document.querySelector('.error');
                if (firstError) {
                    firstError.focus();
                }
            }
        });
    }
});

/**
 * Utility function to debounce function calls
 * @param {Function} func - Function to debounce
 * @param {number} wait - Wait time in milliseconds
 * @returns {Function} Debounced function
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = function() {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Handle window resize events
 */
window.addEventListener('resize', debounce(function() {
    // Close mobile menu on resize to larger screen
    if (window.innerWidth > 768 && sidebarContent && sidebarContent.classList.contains('active')) {
        sidebarContent.classList.remove('active');
        if (menuBtn) {
            menuBtn.setAttribute('aria-expanded', 'false');
        }
    }
}, 250));

/**
 * Accessibility improvements
 */
document.addEventListener('DOMContentLoaded', function() {
    // Add skip to main content link
    const skipLink = document.createElement('a');
    skipLink.href = '#main-page';
    skipLink.textContent = 'Skip to main content';
    skipLink.classList.add('skip-link');
    skipLink.style.cssText = `
        position: absolute;
        top: -40px;
        left: 6px;
        background: #000;
        color: #fff;
        padding: 8px;
        text-decoration: none;
        border-radius: 4px;
        z-index: 1000;
        transition: top 0.3s;
    `;
    
    skipLink.addEventListener('focus', function() {
        this.style.top = '6px';
    });
    
    skipLink.addEventListener('blur', function() {
        this.style.top = '-40px';
    });
    
    document.body.insertBefore(skipLink, document.body.firstChild);
    
    // Improve keyboard navigation for custom elements
    const clickableElements = document.querySelectorAll('.btn, .nav-link');
    clickableElements.forEach(function(element) {
        if (!element.hasAttribute('tabindex')) {
            element.setAttribute('tabindex', '0');
        }
        
        element.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                this.click();
            }
        });
    });
});
