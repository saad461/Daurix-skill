/*!
 * DaurixSkills Main JS
 * Handles sidebar toggling and global animations
 */

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.querySelector('#wrapper').classList.toggle('toggled');
        });
    }

    // GSAP Page Load Animation
    const mainContent = document.body.querySelector('#main-content');
    if (mainContent) {
        gsap.to(mainContent, {
            duration: 0.5,
            opacity: 1,
            y: 0,
            ease: 'power2.out',
            delay: 0.2
        });
    }

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

});
