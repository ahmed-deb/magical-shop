
<?php
session_start();

require_once "includes/db.php";

// ---------------------------------------------------------
// If already logged in, send them to their account
// ---------------------------------------------------------

if (isset($_SESSION["user_id"])) {
    header("Location: account.php");
    exit();
}

// ---------------------------------------------------------
// Variables
// ---------------------------------------------------------

$errors = [];

$email = "";

// ---------------------------------------------------------
// Handle login
// ---------------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // -----------------------------------------------------
    // Basic validation
    // -----------------------------------------------------

    if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please provide a valid owl post address.";
    }

    if ($password === "") {
        $errors[] = "Please provide your secret passphrase.";
    }

    // -----------------------------------------------------
    // Find user
    // -----------------------------------------------------

    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "SELECT id, name, email, password
             FROM users
             WHERE email = ?
             LIMIT 1",
        );

        $stmt->execute([$email]);

        $user = $stmt->fetch();

        // -------------------------------------------------
        // Verify password
        // -------------------------------------------------

        if ($user && password_verify($password, $user["password"])) {
            /*
             * Regenerate the session ID after authentication.
             * This helps protect against session fixation.
             */

            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];

            $_SESSION["user_name"] = $user["name"];

            $_SESSION["user_email"] = $user["email"];

            // ---------------------------------------------
            // Send user to account
            // ---------------------------------------------

            header("Location: account.php");

            exit();
        } else {
            /*
             * Don't reveal whether the email exists.
             *
             * A generic message prevents someone from using
             * the login form to discover registered accounts.
             */

            $errors[] = "The owl post address or passphrase is incorrect.";
        }
    }
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
        Enter the Emporium | The Arcane Emporium
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
        href="assets/css/login.css"
    >

</head>


<body>


<!-- =====================================================
     HEADER
===================================================== -->

<header class="site-header">

    <div class="container">

        <a
            href="index.php"
            class="site-logo"
        >

            <img
                src="assets/images/logo.png"
                alt="The Arcane Emporium"
            >

        </a>


        <nav
            class="main-nav"
            aria-label="Main navigation"
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


        <div class="header-actions">

            <a
                href="search.php"
                class="header-action"
                aria-label="Search"
                title="Search"
            >
                <i class="fa-solid fa-magnifying-glass"></i>
            </a>


            <a
                href="login.php"
                class="header-action"
                aria-label="Sign in"
                title="Sign in"
            >
                <i class="fa-solid fa-user"></i>
            </a>


            <a
                href="cart.php"
                class="header-action"
                aria-label="Your satchel"
                title="Your satchel"
            >

                <i class="fa-solid fa-bag-shopping"></i>

                <?php if (!empty($_SESSION["cart"])): ?>

                    <span class="cart-count">
                        <?= array_sum($_SESSION["cart"]) ?>
                    </span>

                <?php endif; ?>

            </a>

        </div>

    </div>

</header>



<!-- =====================================================
     LOGIN
===================================================== -->

<main class="login-page">

    <div class="container">

        <section class="login-card">


            <!-- Emblem -->

            <div class="login-emblem">

                <i class="fa-solid fa-key"></i>

            </div>


            <!-- Heading -->

            <div class="login-heading">

                <p class="login-eyebrow">
                    The Arcane Emporium
                </p>

                <h1>
                    Welcome Back
                </h1>

                <p>
                    Present your credentials and the doors
                    of the Emporium shall once more be opened.
                </p>

            </div>


            <!-- Errors -->

            <?php if (!empty($errors)): ?>

                <div class="login-errors">

                    <div class="login-errors-title">

                        <i class="fa-solid fa-circle-exclamation"></i>

                        The registrar has found a difficulty.

                    </div>

                    <ul>

                        <?php foreach ($errors as $error): ?>

                            <li>
                                <?= htmlspecialchars($error) ?>
                            </li>

                        <?php endforeach; ?>

                    </ul>

                </div>

            <?php endif; ?>


            <!-- Login form -->

            <form
                method="POST"
                class="login-form"
            >


                <!-- Email -->

                <div class="form-group">

                    <label for="email">
                        Owl Post Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= htmlspecialchars($email) ?>"
                        placeholder="you@example.com"
                        autocomplete="email"
                        required
                    >

                </div>


                <!-- Password -->

                <div class="form-group">

                    <div class="password-label-row">

                        <label for="password">
                            Secret Passphrase
                        </label>

                        <a href="forgot-password.php">
                            Forgotten?
                        </a>

                    </div>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Your secret passphrase"
                        autocomplete="current-password"
                        required
                    >

                </div>


                <!-- Submit -->

                <button
                    type="submit"
                    class="login-button"
                >

                    <i class="fa-solid fa-door-open"></i>

                    Enter the Emporium

                </button>

            </form>


            <!-- Register -->

            <div class="login-register">

                <span>
                    Not yet known to our establishment?
                </span>

                <a href="register.php">
                    Establish an account
                </a>

            </div>


        </section>

    </div>

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
