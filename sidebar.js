document.addEventListener("DOMContentLoaded", function () {
    const menuIcon = document.querySelector(".menu-icon");
    const sidebar = document.getElementById("sideMenu");

    menuIcon.addEventListener("click", function () {
        sidebar.classList.toggle("active"); // Toggle sidebar visibility
    });

    // Close sidebar when clicking outside
    document.addEventListener("click", function (event) {
        if (!menuIcon.contains(event.target) && !sidebar.contains(event.target)) {
            sidebar.classList.remove("active");
        }
    });
});
