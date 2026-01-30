// Home Page Slider JavaScript

function currentSlide(n) {
    const slides = document.getElementsByClassName('slide');
    const dots = document.getElementsByClassName('dot');
    
    if (slides.length === 0) return;
    
    let slideIndex = n;
    if (n > slides.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length;
    }
    
    // Hide all slides
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
    }
    
    // Remove active class from all dots
    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove('active');
    }
    
    // Show selected slide and activate dot
    if (slides[slideIndex - 1]) {
        slides[slideIndex - 1].style.display = 'block';
    }
    if (dots[slideIndex - 1]) {
        dots[slideIndex - 1].classList.add('active');
    }
}

// Initialize slider on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize slider
    if (document.getElementsByClassName('slide').length > 0) {
        currentSlide(1);
    }
    
    // Add event listeners to dots
    document.querySelectorAll('.dot[data-slide]').forEach(dot => {
        dot.addEventListener('click', function() {
            const slideNumber = parseInt(this.getAttribute('data-slide'));
            currentSlide(slideNumber);
        });
    });
    
    // Support legacy onclick handlers
    window.currentSlide = currentSlide;
});
