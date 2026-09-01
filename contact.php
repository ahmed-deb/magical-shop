<?php

session_start();

require_once __DIR__ . "/includes/db.php";
if (!empty($_SESSION["cart"])) {
    $cartCount = array_sum($_SESSION["cart"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Owl Post | The Arcane Emporium
    </title>

    <link
        rel="icon"
        type="image/png"
        href="assets/images/logo.png"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/contact.css"
    >

</head>


<body>


<!-- =====================================================
     HEADER
===================================================== -->

<header class="site-header">

    <div class="container">

        <!-- Logo -->

        <a
            href="index.php"
            class="site-logo"
        >

            <img
                src="assets/images/logo.png"
                alt="The Arcane Emporium"
                width="150"
                height="48"
            >

        </a>


        <!-- Navigation -->

        <nav
            class="main-nav"
            aria-label="Main Navigation"
        >

            <a href="index.php">
                Home
            </a>

            <a href="shop.php">
                The Emporium
            </a>

            <a href="about.php">
                Our Establishment
            </a>

            <a
                href="contact.php"
                class="active"
            >
                Owl Post
            </a>

        </nav>


        <!-- Header Actions -->

        <div class="header-actions">

            <!-- Search -->

            <a
                href="search.php"
                class="header-action"
                aria-label="Search"
                title="Search"
            >

                <i
                    class="fa-solid fa-magnifying-glass"
                    aria-hidden="true"
                ></i>

            </a>


            <!-- Account -->

            <?php if (isset($_SESSION["user_id"])): ?>

                <a
                    href="account.php"
                    class="header-action"
                    aria-label="My account"
                    title="My account"
                >

                    <i
                        class="fa-solid fa-user"
                        aria-hidden="true"
                    ></i>

                </a>

            <?php else: ?>

                <div class="account-links">

                    <a href="login.php">
                        Sign In
                    </a>

                    <span>·</span>

                    <a href="register.php">
                        Register
                    </a>

                </div>

            <?php endif; ?>


            <!-- Shopping Bag -->

            <a
                href="cart.php"
                class="header-action cart-action"
                aria-label="Your satchel"
                title="Your satchel"
            >

                <i
                    class="fa-solid fa-bag-shopping"
                    aria-hidden="true"
                ></i>

<span class="cart-count">
    <?= $cartCount ?>
</span>

            </a>

        </div>

    </div>

</header>



<!-- =====================================================
     CONTACT HERO
===================================================== -->

<main class="contact-page">


    <section class="contact-hero">

        <div class="container">

            <p class="contact-eyebrow">
                Correspondence & Enquiries
            </p>

            <h1>
                Send Us an Owl
            </h1>

            <p>
                Whether you seek a particular potion ingredient,
                require assistance with an order, or merely wish
                to enquire about one of our more curious wares,
                our clerks shall be pleased to hear from you.
            </p>

        </div>

    </section>



    <!-- =================================================
         CONTACT CONTENT
    ================================================= -->

    <section class="contact-content">

        <div class="container">

            <div class="contact-grid">


                <!-- =====================================
                     CONTACT INFORMATION
                ====================================== -->

                <aside class="contact-details">


                    <div class="contact-detail">

                        <div class="contact-detail-icon">

                            <i class="fa-solid fa-location-dot"></i>

                        </div>

                        <div>

                            <h2>
                                Our Establishment
                            </h2>

                            <p>
                                7 Copperwick Lane
                                <br>
                                Old Hogsmeade
                                <br>
                                Scottish Highlands
                            </p>

                            <span class="contact-note">
                                Look for the crooked brass lantern.
                            </span>

                        </div>

                    </div>



                    <div class="contact-detail">

                        <div class="contact-detail-icon">

                            <i class="fa-solid fa-envelope"></i>

                        </div>

                        <div>

                            <h2>
                                Owl Post
                            </h2>

                            <p>
                                post@arcane-emporium.magic
                            </p>

                            <span class="contact-note">
                                Replies are generally dispatched
                                within two working days.
                            </span>

                        </div>

                    </div>



                    <div class="contact-detail">

                        <div class="contact-detail-icon">

                            <i class="fa-solid fa-clock"></i>

                        </div>

                        <div>

                            <h2>
                                Opening Hours
                            </h2>

                            <p>
                                Monday — Saturday
                                <br>
                                9:00 in the morning — 6:00 in the evening
                                <br><br>
                                Sunday
                                <br>
                                Closed for inventory & restorative tea.
                            </p>

                        </div>

                    </div>



                    <div class="contact-detail">

                        <div class="contact-detail-icon">

                            <i class="fa-solid fa-feather-pointed"></i>

                        </div>

                        <div>

                            <h2>
                                Postal Matters
                            </h2>

                            <p>
                                For urgent correspondence, please mark
                                your owl's parchment with the words
                                <em>URGENT</em> in clear ink.
                            </p>

                        </div>

                    </div>


                </aside>



                <!-- =====================================
                     OWL POST FORM
                ====================================== -->

                <section class="contact-form-wrapper">


                    <div class="form-heading">

                        <p>
                            Correspondence Ledger
                        </p>

                        <h2>
                            Write to the Emporium
                        </h2>

                        <span>
                            Your message shall be delivered to
                            our correspondence clerk.
                        </span>

                    </div>


                    <form
                        action="#"
                        method="POST"
                        class="contact-form"
                    >


                        <!-- Name -->

                        <div class="form-group">

                            <label for="name">
                                Your Name
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                placeholder="The name by which you are known"
                                autocomplete="name"
                                required
                            >

                        </div>


                        <!-- Email -->

                        <div class="form-group">

                            <label for="email">
                                Owl Post Address
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="you@example.com"
                                autocomplete="email"
                                required
                            >

                        </div>


                        <!-- Subject -->

                        <div class="form-group">

                            <label for="subject">
                                Nature of Correspondence
                            </label>

                            <select
                                id="subject"
                                name="subject"
                                required
                            >

                                <option
                                    value=""
                                    selected
                                    disabled
                                >
                                    Select a subject
                                </option>

                                <option value="order">
                                    An existing order
                                </option>

                                <option value="product">
                                    A product enquiry
                                </option>

                                <option value="delivery">
                                    Dispatch & delivery
                                </option>

                                <option value="account">
                                    Account matters
                                </option>

                                <option value="general">
                                    General correspondence
                                </option>

                            </select>

                        </div>


                        <!-- Message -->

                        <div class="form-group">

                            <label for="message">
                                Your Message
                            </label>

                            <textarea
                                id="message"
                                name="message"
                                rows="7"
                                placeholder="Compose your correspondence here..."
                                required
                            ></textarea>

                        </div>


                        <!-- Submit -->

                        <button
                            type="submit"
                            class="contact-submit"
                        >

                            <i class="fa-solid fa-feather-pointed"></i>

                            Dispatch Owl Post

                        </button>


                        <p class="form-footnote">

                            By submitting this correspondence,
                            you acknowledge that delivery by owl
                            may occasionally be delayed by adverse
                            weather, hungry cats, or strong winds.

                        </p>

                    </form>


                </section>

            </div>

        </div>

    </section>



    <!-- =================================================
         LOCATION STRIP
    ================================================= -->

    <section class="contact-location">

        <div class="container">

            <div class="location-inner">

                <div class="location-icon">

                    <i class="fa-solid fa-map-location-dot"></i>

                </div>

                <div>

                    <p class="location-eyebrow">
                        Find the Emporium
                    </p>

                    <h2>
                        Somewhere Along Copperwick Lane
                    </h2>

                    <p>
                        Tucked between the old apothecary and the
                        bookseller, beneath a weathered wooden sign
                        bearing our crest.
                    </p>

                </div>

            </div>

        </div>

    </section>


</main>



<!-- =====================================================
     FOOTER
===================================================== -->

<footer class="site-footer">

    <div class="container">

        <div class="footer-main">


            <div class="footer-brand">

                <a
                    href="index.php"
                    class="footer-logo"
                >

                    <img
                        src="assets/images/logo.png"
                        alt="The Arcane Emporium"
                    >

                </a>

                <p>
                    A respectable establishment supplying witches,
                    wizards, scholars, and other curious folk since 1687.
                </p>

                <p class="footer-motto">
                    <em>
                        Quality wares. Honest enchantments.
                    </em>
                </p>

            </div>



            <div class="footer-column">

                <h3>
                    The Emporium
                </h3>

                <ul>

                    <li>
                        <a href="shop.php">
                            All Wares
                        </a>
                    </li>

                    <li>
                        <a href="shop.php?category=Potions">
                            Potions
                        </a>
                    </li>

                    <li>
                        <a href="shop.php?category=Potion%20Ingredients">
                            Potion Ingredients
                        </a>
                    </li>

                    <li>
                        <a href="shop.php?category=Wands">
                            Wands & Implements
                        </a>
                    </li>

                </ul>

            </div>



            <div class="footer-column">

                <h3>
                    The Establishment
                </h3>

                <ul>

                    <li>
                        <a href="about.php">
                            Our Story
                        </a>
                    </li>

                    <li>
                        <a href="contact.php">
                            Owl Post
                        </a>
                    </li>

                    <li>
                        <a href="shipping.php">
                            Dispatch & Delivery
                        </a>
                    </li>

                </ul>

            </div>



            <div class="footer-column">

                <h3>
                    For the Customer
                </h3>

                <ul>

                    <li>
                        <a href="account.php">
                            My Account
                        </a>
                    </li>

                    <li>
                        <a href="orders.php">
                            Purchase Ledger
                        </a>
                    </li>

                    <li>
                        <a href="cart.php">
                            My Satchel
                        </a>
                    </li>

                </ul>

            </div>

        </div>



        <div class="footer-divider"></div>



        <div class="footer-bottom">

            <p>
                &copy; <?= date("Y") ?>
                The Arcane Emporium.
                All rights reserved.
            </p>


            <div class="footer-legal">

                <a href="privacy.php">
                    Privacy
                </a>

                <a href="terms.php">
                    Terms of Trade
                </a>

            </div>


            <div class="footer-socials">

                <a
                    href="#"
                    aria-label="Instagram"
                >
                    <i class="fa-brands fa-instagram"></i>
                </a>

                <a
                    href="#"
                    aria-label="Facebook"
                >
                    <i class="fa-brands fa-facebook-f"></i>
                </a>

            </div>

        </div>

    </div>

</footer>


<script src="assets/js/app.js"></script>

</body>
</html>
