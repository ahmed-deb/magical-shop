<?php

session_start();

require_once __DIR__ . "/includes/db.php";
$cartCount = 0;

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
        Terms of Trade | The Arcane Emporium
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
        href="assets/css/terms.css"
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
     TERMS HERO
===================================================== -->

<main class="terms-page">

    <section class="terms-hero">

        <div class="container">

            <p class="terms-eyebrow">
                Charter of Trade
            </p>

            <h1>
                Terms of Trade
            </h1>

            <p>
                The following articles govern the purchase,
                possession, and delivery of goods obtained
                from the Arcane Emporium.
            </p>

            <span class="terms-date">
                Last revised: September 2026
            </span>

        </div>

    </section>



    <!-- =================================================
         TERMS CONTENT
    ================================================= -->

    <section class="terms-content">

        <div class="container">

            <div class="terms-layout">


                <!-- Table of Contents -->

                <aside class="terms-navigation">

                    <p>
                        Articles
                    </p>

                    <a href="#general">
                        I. General Provisions
                    </a>

                    <a href="#orders">
                        II. Orders & Purchases
                    </a>

                    <a href="#payment">
                        III. Payment
                    </a>

                    <a href="#delivery">
                        IV. Dispatch & Delivery
                    </a>

                    <a href="#returns">
                        V. Returns & Exchanges
                    </a>

                    <a href="#magical-goods">
                        VI. Magical Goods
                    </a>

                    <a href="#accounts">
                        VII. Accounts
                    </a>

                    <a href="#correspondence">
                        VIII. Correspondence
                    </a>

                    <a href="#changes">
                        IX. Amendments
                    </a>

                </aside>



                <!-- Terms -->

                <article class="terms-document">


                    <section id="general">

                        <span class="article-number">
                            Article I
                        </span>

                        <h2>
                            General Provisions
                        </h2>

                        <p>
                            By entering the Arcane Emporium and
                            purchasing any of its wares, you agree
                            to abide by these Terms of Trade.
                        </p>

                        <p>
                            These terms apply to all customers,
                            whether witch, wizard, scholar,
                            travelling alchemist, or otherwise
                            suitably qualified person.
                        </p>

                    </section>



                    <section id="orders">

                        <span class="article-number">
                            Article II
                        </span>

                        <h2>
                            Orders & Purchases
                        </h2>

                        <p>
                            An order placed through the Emporium
                            constitutes an offer to purchase the
                            selected goods at the price displayed
                            at the time of ordering.
                        </p>

                        <p>
                            We reserve the right to decline or
                            cancel an order where an item has been
                            incorrectly listed, is unavailable,
                            or has been purchased in quantities
                            that suggest suspicious magical
                            experimentation.
                        </p>

                        <p>
                            Customers are responsible for ensuring
                            that all information supplied during
                            an order is accurate.
                        </p>

                    </section>



                    <section id="payment">

                        <span class="article-number">
                            Article III
                        </span>

                        <h2>
                            Payment
                        </h2>

                        <p>
                            All prices displayed by the Emporium
                            are stated in Galleons unless otherwise
                            indicated.
                        </p>

                        <p>
                            Payment must be completed before an
                            order is prepared for dispatch.
                        </p>

                        <p>
                            The Emporium reserves the right to
                            amend prices at any time. An order
                            already accepted shall ordinarily
                            retain the price displayed at the
                            time of purchase.
                        </p>

                    </section>



                    <section id="delivery">

                        <span class="article-number">
                            Article IV
                        </span>

                        <h2>
                            Dispatch & Delivery
                        </h2>

                        <p>
                            Orders are prepared and dispatched
                            according to the availability of
                            the purchased goods.
                        </p>

                        <p>
                            Delivery times are estimates rather
                            than guarantees. Delays may occur
                            owing to adverse weather, difficult
                            terrain, unusually aggressive owls,
                            or other circumstances beyond the
                            Emporium's reasonable control.
                        </p>

                        <p>
                            Customers are responsible for providing
                            a complete and accurate delivery address.
                        </p>

                    </section>



                    <section id="returns">

                        <span class="article-number">
                            Article V
                        </span>

                        <h2>
                            Returns & Exchanges
                        </h2>

                        <p>
                            Unused and unopened ordinary goods may
                            be eligible for return within fourteen
                            days of delivery.
                        </p>

                        <p>
                            Items that have been consumed, opened,
                            altered, enchanted, hexed, cursed,
                            brewed with, or otherwise experimented
                            upon cannot ordinarily be accepted for
                            return.
                        </p>

                        <p>
                            Customers wishing to arrange a return
                            should contact the Emporium through
                            Owl Post before sending anything back.
                        </p>

                    </section>



                    <section id="magical-goods">

                        <span class="article-number">
                            Article VI
                        </span>

                        <h2>
                            Magical Goods
                        </h2>

                        <p>
                            Certain goods sold by the Emporium may
                            possess unusual properties, scents,
                            appearances, temperatures, or other
                            characteristics.
                        </p>

                        <p>
                            Customers are responsible for using
                            all goods in accordance with their
                            intended purpose and any instructions
                            supplied with the item.
                        </p>

                        <p>
                            The Emporium accepts no responsibility
                            for consequences arising from reckless
                            experimentation, improper brewing,
                            unsupervised spellcraft, or attempts to
                            place a cauldron in a domestic fireplace
                            without proper ventilation.
                        </p>

                    </section>



                    <section id="accounts">

                        <span class="article-number">
                            Article VII
                        </span>

                        <h2>
                            Customer Accounts
                        </h2>

                        <p>
                            Customers creating an account are
                            responsible for keeping their account
                            credentials confidential.
                        </p>

                        <p>
                            You must notify the Emporium promptly
                            if you believe that your account has
                            been accessed by another person.
                        </p>

                        <p>
                            Accounts may not be created using
                            deliberately misleading information
                            or for the purpose of interfering with
                            the operation of the Emporium.
                        </p>

                    </section>



                    <section id="correspondence">

                        <span class="article-number">
                            Article VIII
                        </span>

                        <h2>
                            Correspondence
                        </h2>

                        <p>
                            Questions, complaints, and other
                            matters concerning an order may be
                            submitted through our Owl Post service.
                        </p>

                        <p>
                            Please include your order number where
                            applicable so that our clerks may locate
                            the relevant entry in the Purchase Ledger.
                        </p>

                    </section>



                    <section id="changes">

                        <span class="article-number">
                            Article IX
                        </span>

                        <h2>
                            Amendments
                        </h2>

                        <p>
                            These Terms of Trade may occasionally
                            be revised to reflect changes to the
                            Emporium, its services, or applicable
                            requirements.
                        </p>

                        <p>
                            The latest version published upon this
                            page shall be considered the current
                            version.
                        </p>

                    </section>



                    <!-- Closing -->

                    <div class="terms-closing">

                        <i class="fa-solid fa-feather-pointed"></i>

                        <p>
                            By order of the proprietor and witnessed
                            by the senior clerk of the Emporium.
                        </p>

                        <span>
                            The Arcane Emporium
                        </span>

                    </div>


                </article>

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
                        <a href="terms.php">
                            Terms of Trade
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

                <a
                    href="terms.php"
                    class="active"
                >
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
