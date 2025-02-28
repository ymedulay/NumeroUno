<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="About-us-page">

    <section class="about-content">
        <div class="what-is">
            <img src="assets/images/About us page-amico.png" alt="Illustration of people discussing" class="about-img">
            <div class="text-1">
                <h2>What is NumeroUno?</h2>
                <p>Description</p>
            </div>
        </div>
    </section>

    <section class="creator-info">
        <div class="who-created">
            <div class="text-2">
                <h2>Who created NumeroUno?</h2>
                <p>NumeroUno was created by students from Mapua University blahblah</p>
            </div>
            <div class="creator-img">
                <img src="assets/images/image-here.png" alt="Who created NumeroUno">
            </div>
        </div>
    </section>

    <script>
        function toggleDropdown(id) {
            document.querySelectorAll(".dropdown-menu").forEach(menu => {
                if (menu.id !== id) menu.classList.remove("show");
            });
            document.getElementById(id).classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.ph')) {
                let dropdowns = document.getElementsByClassName("dropdown-menu");
                for (let i = 0; i < dropdowns.length; i++) {
                    let openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        };
    </script>
</body>

</html>