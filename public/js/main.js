document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href').substring(1);
            if (!targetId) return;
            
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 70,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Mobile navigation toggle (if needed in the future)
    const setupMobileNav = () => {
        const navToggle = document.querySelector('.mobile-nav-toggle');
        if (navToggle) {
            navToggle.addEventListener('click', () => {
                const navLinks = document.querySelector('.nav-links');
                navLinks.classList.toggle('active');
            });
        }
    };

    // Animation for banner elements
    const animateBanner = () => {
        const bannerContent = document.querySelector('.banner-content');
        if (bannerContent) {
            bannerContent.classList.add('animated');
        }
    };

    // Initialize functions
    setupMobileNav();
    animateBanner();

    // Form validation for complaint submission (to be implemented)
    const complaintForm = document.getElementById('complaint-form');
    if (complaintForm) {
        complaintForm.addEventListener('submit', function(e) {
            // Form validation logic will go here
            console.log('Form submitted');
        });
    }
});
