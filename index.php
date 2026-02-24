<?php

session_start();
header("X-Frame-Options: sameorigin");
include('global.php');

$page = $_GET['page'] ?? "home";


// include("session.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>quickpassdigital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght,CRSV@100..900,0&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css" />

    <link rel="shortcut icon" href="favicon.png" />
</head>

<body>
    <?php
    include('pages/header.php');
    include "pages/$page.php";
    include 'pages/footer.php';
    ?>

    <script src="assets/js/app.js"></script>
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>

    <script>
        let captchaCompleted = false;

        function onCaptchaSuccess() {
            captchaCompleted = true;
        }

        document.getElementById('contactForm').addEventListener('submit', function(e) {
            if (!captchaCompleted) {
                e.preventDefault();
                alert('Please complete the captcha verification before submitting the form.');
                return false;
            }
        });

        // Reset captcha completion status when captcha expires or is reset
        function onCaptchaExpired() {
            captchaCompleted = false;
        }

        // Add data-expired-callback to hCaptcha div
        document.querySelector('.h-captcha').setAttribute('data-expired-callback', 'onCaptchaExpired');
    </script>
</body>

</html>