<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NumeroUno - Job Application</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>

<body id="find-job-appli">

    <!-- Horizontal Container with Text -->
    <div class="horizontal-container">
        <p>You are applying for <strong>*Job Position*</strong> at <strong>*Company Name*</strong>.</p>
    </div>

    <!-- Application Form Container -->
    <div class="application-form">
        <h2 class="form-title">Job Application Form</h2>

        <form action="submit_form.php" method="POST" enctype="multipart/form-data">
            <div class="name-container">
                <div class="input-group-name">
                    <label for="first-name">First Name:</label>
                    <input type="text" id="first-name" name="first_name" placeholder="ex. John" required>
                </div>
                <div class="input-group-name">
                    <label for="last-name">Last Name:</label>
                    <input type="text" id="last-name" name="last_name" placeholder="ex. Dela Cruz" required>
                </div>
            </div>

            <div class="birth-gender-container">
                <div class="input-group-birthgender">
                    <label for="birthdate">Birthdate:</label>
                    <input type="date" id="birthdate" name="birthdate" required>
                </div>
                <div class="input-group-birthgender">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="" disabled selected>Select your gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="prefer-not">Prefer not to state</option>
                    </select>
                </div>
            </div>

            <div class="contact-email-container">
                <div class="input-group-contactemail">
                    <label for="contact-number">Contact Number:</label>
                    <input type="tel" id="contact-number" name="contact_number" pattern="[0-9]{11}" placeholder="e.g., 09123456789" required>
                </div>
                <div class="input-group-contactemail">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" placeholder="e.g., example@email.com" required>
                </div>
            </div>

            <div class="home-address-container">
                <div class="input-group-homeaddress">
                    <label for="home-address">Home Address:</label>
                    <input type="text" id="home-address" name="home_address" placeholder="Enter your full address" required>
                </div>
            </div>

            <div class="jobtype-startdate-container">
                <div class="input-group-jobtype">
                    <label for="job-type">Job Type:</label>
                    <select id="job-type" name="job_type" required>
                        <option value="" disabled selected>Select job type</option>
                        <option value="part-time">Part-time</option>
                        <option value="full-time">Full-time</option>
                    </select>
                </div>
                <div class="input-group-jobtype">
                    <label for="start-date">Available Start Date:</label>
                    <input type="date" id="start-date" name="start_date" required>
                </div>
            </div>

            <div class="cv-upload-container">
                <label for="cv-upload">Upload CV:</label>
                <input type="file" id="cv-upload" name="cv_upload" accept=".pdf,.doc,.docx" required>
            </div>

            <div class="submit-container">
                <button class="submit-btn" type="submit">Submit</button>
            </div>
        </form>
    </div>

</body>

</html>