document.addEventListener("DOMContentLoaded", function () {
    const observerOptions = {
        root: null,
        rootMargin: "0px",
        threshold: 0.2, // Trigger when 20% of the element is visible
    };

    function handleIntersection(entries, observer) {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
                observer.unobserve(entry.target); // Remove observer once it's visible
            }
        });
    }

    const observer = new IntersectionObserver(handleIntersection, observerOptions);

    // Apply animation to sections
    document.querySelectorAll(".fade-in").forEach((section) => {
        observer.observe(section);
    });

    // Step-by-step animation for "Who Can Benefit"
    const steps = document.querySelectorAll(".step-box");
    steps.forEach((step, index) => {
        observer.observe(step);
        step.style.transitionDelay = `${index * 0.3}s`; // Delayed appearance
    });
});
