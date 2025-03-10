document.addEventListener("DOMContentLoaded", () => {
    const observerOptions = {
        root: null,        // Use the viewport as the root
        rootMargin: "0px",
        threshold: 0.2     // Trigger when 20% of the element is visible
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
                observer.unobserve(entry.target);  // Stop observing once animated
            }
        });
    }, observerOptions);

    const howItWorksSection = document.querySelector(".how-it-works");
    if (howItWorksSection) {
        howItWorksSection.classList.add("hidden");  // Start hidden
        observer.observe(howItWorksSection);
    }
});
