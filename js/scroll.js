// scroll.js - Animation functionality only
document.addEventListener('DOMContentLoaded', function() {
  // Create an intersection observer for scroll animations
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, {
    threshold: 0.1
  });
  
  // Target elements to animate on scroll
  const animatedElements = document.querySelectorAll('.how-it-works, .step, .homepage-job-postings, .job-card');
  animatedElements.forEach(item => {
    item.classList.add('hidden');
    observer.observe(item);
  });
  
  // Smooth scroll for "Find Jobs" button
  const findJobsBtn = document.querySelector('.find-jobs-btn');
  if (findJobsBtn) {
    findJobsBtn.addEventListener('click', function(e) {
      const href = this.getAttribute('href');
      // Only prevent default if it's a hash link
      if (href && href.startsWith('#')) {
        e.preventDefault();
        const target = document.querySelector(href);
        
        if (target) {
          window.scrollTo({
            top: target.offsetTop - 80,
            behavior: 'smooth'
          });
        }
      }
    });
  }
});