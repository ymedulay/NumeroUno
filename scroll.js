// Scroll animation for elements
document.addEventListener('DOMContentLoaded', function() {
  // Create an intersection observer
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
  
  // Enhanced sidebar animation
  document.querySelector('.menu-icon').addEventListener('click', function() {
    const sidebar = document.getElementById('sideMenu');
    sidebar.classList.toggle('active');
  });
  
  // Close sidebar when clicking outside
  document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sideMenu');
    const menuIcon = document.querySelector('.menu-icon');
    
    if (!sidebar.contains(event.target) && !menuIcon.contains(event.target) && sidebar.classList.contains('active')) {
      sidebar.classList.remove('active');
    }
  });
  
  // Add smooth scroll behavior for "Find Jobs" button
  document.querySelector('.find-jobs-btn').addEventListener('click', function(e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    
    if (target) {
      window.scrollTo({
        top: target.offsetTop - 80,
        behavior: 'smooth'
      });
    }
  });
});

// Add this to the existing sidebar.js or replace it
function toggleSidebar() {
  const sidebar = document.getElementById('sideMenu');
  sidebar.classList.toggle('active');
}

// Automatically attach the toggle function to the menu icon
document.addEventListener('DOMContentLoaded', function() {
  const menuIcon = document.querySelector('.menu-icon');
  if (menuIcon) {
    menuIcon.addEventListener('click', toggleSidebar);
  }
});