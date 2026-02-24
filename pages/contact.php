<div class="page-hero">
    <div class="container">
        <div class="d-flex mobile-column">
            <div class="hero-text">
                <h1>Contact</h1>
                <hr>
                <p class="intro-text">We’d love to hear from you! Whether you’re ready to get started, want a
                    quote, or have questions about our services, the <strong>Quickpass Digital</strong>
                    team is here to help. </p>
            </div>

            <img src="assets/images/contact-hero.png" alt="contact Hero Image"></img>
        </div>
    </div>
</div>

<main>
    <section class="section no-padding-bottom">
        <div class="container d-flex flex-column align-items-center">
            <h2 class="mb-4">Get to know us better</h2>
            <form action="mail.php" method="post" id="contactForm">
                <input type="text" placeholder="Name" name="name" /><input id="email" type="email" name="email" placeholder="Email" />

                <input type="text" placeholder="Subject" name="subject" />

                <textarea id="message" name="message" rows="3" placeholder="Message"></textarea>

                <div class="h-captcha m-auto" data-sitekey="ad837be1-2815-41d2-afd5-bff95e563963" data-callback="onCaptchaSuccess"></div>

                <button class="btn-send" type="submit">Submit</button>
            </form>

            <?php
            if (isset($_GET['mail']) && $_GET['mail'] == "true") {
            ?>

                <div class="alert alert-success">
                    <strong>Success!</strong> Message sent succesfully.
                </div>

            <?php
            } elseif (isset($_GET['mail']) && $_GET['mail'] == "false") {
            ?>

                <div class="alert alert-danger">
                    <strong>Error!</strong> Unexpected error has occurred, try it later.
                </div>

            <?php
            }
            ?>
        </div>
    </section>
</main>