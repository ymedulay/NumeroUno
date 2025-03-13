// sidebar.js - Consolidated sidebar functionality
document.addEventListener("DOMContentLoaded", function() {
    const menuIcon = document.querySelector(".menu-icon");
    const sidebar = document.getElementById("sideMenu");

    // Toggle sidebar when menu icon is clicked
    menuIcon.addEventListener("click", function() {
        sidebar.classList.toggle("active");
    });

    // Close sidebar when clicking outside
    document.addEventListener("click", function(event) {
        if (!sidebar.contains(event.target) && 
            !menuIcon.contains(event.target) && 
            sidebar.classList.contains("active")) {
            sidebar.classList.remove("active");
        }
    });
});