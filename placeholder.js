document.addEventListener("DOMContentLoaded", function () {
    let inputs = document.querySelectorAll("#login-signin-page .input-group input");

    inputs.forEach(input => {
        let placeholderText = input.placeholder; // Store the placeholder text

        input.addEventListener("focus", function () {
            input.placeholder = ""; // Remove placeholder on focus
        });

        input.addEventListener("blur", function () {
            if (input.value === "") {
                input.placeholder = placeholderText; // Restore if input is empty
            }
        });
    });
});
