<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="faqs-page">

    <!-- FAQ Content -->
    <div class="faq-header">
        <div class="faq-icon-container">
            <img src="assets/images/FAQsIcon.png" alt=" FAQ Icon">
        </div>
        <div class="faq-search-container">
            <input type="text" class="faq-search" placeholder="Type your question...">
            <button class="search-button">Search</button>
        </div>
    </div>

    <div class="faq-container">
        <h2>Frequently Asked Questions</h2>
        <?php
        $faqs = [
            "Can I apply for multiple jobs at the same time?" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
            "How do I delete my account?" => "To delete your account, locate the User dropdown menu in the navigation bar, then go to 'My Account' and click 'Account Management' in the sidebar. Follow the steps for account deletion.",
            "How does the website ensure the credibility of job postings?" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
            "What are the requirements to create an account?" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
            "Who do I contact for support?" => "Reach out to us via the Contact Us page or check out the FAQs page to see if your inquiry has been answered."
        ];
        foreach ($faqs as $question => $answer) {
            echo "<div class='faq-item'>
                    <div class='faq-question'>$question <span>+</span></div>
                    <div class='faq-content'>$answer</div>
                  </div>";
        }
        ?>
    </div>

    <!-- Script for FAQ Expansion -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const faqItems = document.querySelectorAll(".faq-item");
            faqItems.forEach(item => {
                item.addEventListener("click", () => {
                    item.classList.toggle("active");
                    const content = item.querySelector(".faq-content");
                    content.style.maxHeight = item.classList.contains("active") ? content.scrollHeight + "px" : "0";
                });
            });
        });
    </script>
</body>

</html>