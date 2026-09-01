<?php
session_start();
require_once __DIR__ . "/includes/db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Our Establishment | The Arcane Emporium</title>

    <link
        rel="icon"
        type="image/png"
        href="assets/images/logo.png"
    >

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >

    <!-- Main Website CSS -->
    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

    <!-- About Page CSS -->
    <link
        rel="stylesheet"
        href="assets/css/about.css"
    >

</head>


<body>


<!-- =====================================================
     HEADER
===================================================== -->


<header class="site-header">

    <div class="container">

        <!-- Logo -->
        <a href="index.php" class="site-logo">
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

            <a href="contact.php">
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

                <!-- Logged in -->
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

                <!-- Not logged in -->
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
                    0
                </span>

            </a>

        </div>

    </div>

</header>





<!-- =====================================================
     ABOUT HERO
===================================================== -->

<main>

    <section class="about-hero">

        <div class="container">

            <p class="about-eyebrow">
                An Establishment of Some Repute
            </p>

            <h1>
                Our Story
            </h1>

            <p class="about-hero-text">
                For generations, we have supplied witches, wizards,
                scholars and curious folk with the finest magical wares
                the wizarding world has to offer.
            </p>

        </div>

    </section>



    <!-- =================================================
         THE BEGINNING
    ================================================== -->

    <section class="about-story">

        <div class="container">

            <div class="about-story-grid">

                <div class="about-story-image">

                    <img
                        src="assets/images/alley.jpg"
                        alt="The Arcane Emporium"
                    >

                </div>


                <div class="about-story-content">

                    <p class="about-eyebrow">
                        Since 1687
                    </p>

                    <h2>
                        A Shop Born of Curiosity
                    </h2>

                    <p>
                        The Arcane Emporium was established in the winter
                        of 1687 by Aldric Wetherby, a travelling alchemist
                        with little money, three suspiciously intelligent
                        ravens and an unreasonable enthusiasm for
                        collecting magical curiosities.
                    </p>

                    <p>
                        What began as a modest stall became a respectable
                        establishment serving students, professors,
                        apothecaries, adventurers and witches of
                        considerably varying reputations.
                    </p>

                    <p>
                        Our shelves have changed considerably since those
                        early days. Our principles, however, remain much
                        the same.
                    </p>

                </div>

            </div>

        </div>

    </section>



    <!-- =================================================
         PHILOSOPHY
    ================================================== -->

    <section class="about-philosophy">

        <div class="container">

            <div class="about-section-heading">

                <p class="about-eyebrow">
                    Our Principles
                </p>

                <h2>
                    Matters We Take Seriously
                </h2>

                <p>
                    A magical establishment is only as respectable
                    as the standards by which it conducts its trade.
                </p>

            </div>


            <div class="principles-grid">

                <article class="principle-card">

                    <div class="principle-icon">
                        <i class="fa-solid fa-flask"></i>
                    </div>

                    <h3>
                        Proper Craftsmanship
                    </h3>

                    <p>
                        Every potion, implement and enchanted article
                        offered through our shelves is selected with
                        considerable care.
                    </p>

                </article>


                <article class="principle-card">

                    <div class="principle-icon">
                        <i class="fa-solid fa-feather-pointed"></i>
                    </div>

                    <h3>
                        Honest Trade
                    </h3>

                    <p>
                        We believe a wizard ought to know precisely what
                        he is purchasing before handing over his Galleons.
                    </p>

                </article>


                <article class="principle-card">

                    <div class="principle-icon">
                        <i class="fa-solid fa-book-open"></i>
                    </div>

                    <h3>
                        Knowledge First
                    </h3>

                    <p>
                        A magical object is best understood before it is
                        used. We therefore encourage curiosity, caution
                        and a healthy respect for instructions.
                    </p>

                </article>


                <article class="principle-card">

                    <div class="principle-icon">
                        <i class="fa-solid fa-wand-sparkles"></i>
                    </div>

                    <h3>
                        A Little Wonder
                    </h3>

                    <p>
                        Commerce need not be dull. We have always believed
                        that purchasing one's supplies should retain some
                        measure of enchantment.
                    </p>

                </article>

            </div>

        </div>

    </section>



    <!-- =================================================
         THE PROPRIETOR
    ================================================== -->

    <section class="proprietor-section">

        <div class="container">

            <div class="proprietor-grid">

                <div class="proprietor-content">

                    <p class="about-eyebrow">
                        A Word from the Proprietor
                    </p>

                    <h2>
                        "One Must Know What One Is Selling."
                    </h2>

                    <p>
                        "There are establishments which will sell you
                        anything provided you possess sufficient coin.
                        We have never wished to be one of them."
                    </p>

                    <p>
                        "A wand should suit its wizard. A potion should
                        serve its purpose. And a cauldron should, at the
                        very least, remain intact until supper."
                    </p>

                    <p class="proprietor-signature">
                        — Aldric Wetherby
                    </p>

                    <span class="proprietor-title">
                        Proprietor & Master of the Establishment
                    </span>

                </div>


                <div class="proprietor-image">

                    <img
                        src="assets/images/proprietor.jpg"
                        alt="Portrait of Aldric Wetherby"
                    >

                </div>

            </div>

        </div>

    </section>



    <!-- =================================================
         CLOSING
    ================================================== -->

    <section class="about-closing">

        <div class="container">

            <div class="about-closing-inner">

                <i class="fa-solid fa-wand-magic-sparkles"></i>

                <h2>
                    Come In, Have a Look About
                </h2>

                <p>
                    The shelves are full, the kettle is warm,
                    and there is almost certainly something here
                    you did not know you needed.
                </p>

                <a
                    href="shop.php"
                    class="about-button"
                >
                    Browse the Emporium
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

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
                        <a href="shop.php?category=Wands%20%26%20Implements">
                            Wands & Implements
                        </a>
                    </li>

                    <li>
                        <a href="shop.php?category=Robes%20%26%20Raiment">
                            Robes & Raiment
                        </a>
                    </li>

                    <li>
                        <a href="shop.php?category=Beasts%20%26%20Familiars">
                            Beasts & Familiars
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

                    <li>
                        <a href="returns.php">
                            Returns & Exchanges
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
                            Order Ledger
                        </a>
                    </li>

                    <li>
                        <a href="wishlist.php">
                            Saved Wares
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