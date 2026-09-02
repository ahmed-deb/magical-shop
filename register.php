<?php
session_start();

require_once "includes/db.php";

// ---------------------------------------------------------
// Variables
// ---------------------------------------------------------

$errors = [];

$name = "";
$email = "";

// ---------------------------------------------------------
// Handle registration
// ---------------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    // -----------------------------------------------------
    // Validate name
    // -----------------------------------------------------

    if ($name === "") {
        $errors[] = "Please provide your name.";
    } elseif (strlen($name) < 2) {
        $errors[] = "Your name must contain at least two characters.";
    }

    // -----------------------------------------------------
    // Validate email
    // -----------------------------------------------------

    if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please provide a valid owl post address.";
    }

    // -----------------------------------------------------
    // Validate password
    // -----------------------------------------------------

    if (strlen($password) < 8) {
        $errors[] = "Your password must contain at least eight characters.";
    }

    // -----------------------------------------------------
    // Confirm password
    // -----------------------------------------------------

    if ($password !== $confirmPassword) {
        $errors[] = "The two passwords do not match.";
    }

    // -----------------------------------------------------
    // Check whether email already exists
    // -----------------------------------------------------

    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "SELECT id
             FROM users
             WHERE email = ?",
        );

        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $errors[] = "An account already exists for this owl post address.";
        }
    }

    // -----------------------------------------------------
    // Create account
    // -----------------------------------------------------

    if (empty($errors)) {
        try {
            /*
             * Never store passwords as plain text.
             */

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                "INSERT INTO users
                (
                    name,
                    email,
                    password
                )
                VALUES
                (
                    ?,
                    ?,
                    ?
                )",
            );

            $stmt->execute([$name, $email, $hashedPassword]);

            /*
             * Automatically log the new customer in.
             */

            $_SESSION["user_id"] = $pdo->lastInsertId();

            $_SESSION["user_name"] = $name;

            header("Location: account.php");

            exit();
        } catch (PDOException $e) {
            /*
             * The email may have been registered between
             * our SELECT and INSERT.
             */

            if ($e->getCode() === "23000") {
                $errors[] =
                    "An account already exists for this owl post address.";
            } else {
                $errors[] =
                    "Something went wrong while opening your account. Please try again.";
            }
        }
    }
}
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
        Join the Emporium | The Arcane Emporium
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
        href="assets/css/register.css"
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
    <?= $cartCount ?>
</span>

            </a>

        </div>

    </div>

</header>




<!-- =====================================================
     REGISTER
===================================================== -->

<main class="register-page">

    <div class="container">

        <section class="register-card">


            <!-- Decorative emblem -->

            <div class="register-emblem">

                <i class="fa-solid fa-feather-pointed"></i>

            </div>


            <!-- Heading -->

            <div class="register-heading">

                <p class="register-eyebrow">
                    The Arcane Emporium
                </p>

                <h1>
                    Enter Your Name
                </h1>

                <p>
                    Establish an account with our humble
                    emporium and keep a record of your purchases,
                    should you wish to return for further wares.
                </p>

            </div>


            <!-- Errors -->

            <?php if (!empty($errors)): ?>

                <div class="register-errors">

                    <div class="register-errors-title">

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


            <!-- Form -->

            <form
                method="POST"
                class="register-form"
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
                        value="<?= htmlspecialchars($name) ?>"
                        placeholder="Your full name"
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
                        value="<?= htmlspecialchars($email) ?>"
                        placeholder="you@example.com"
                        autocomplete="email"
                        required
                    >

                </div>


                <!-- Password -->

                <div class="form-group">

                    <label for="password">
                        Secret Passphrase
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="At least eight characters"
                        autocomplete="new-password"
                        required
                    >

                    <small>
                        Keep this somewhere safe. We shall not
                        be able to retrieve it for you.
                    </small>

                </div>


                <!-- Confirm password -->

                <div class="form-group">

                    <label for="confirm_password">
                        Repeat Passphrase
                    </label>

                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        placeholder="Repeat your passphrase"
                        autocomplete="new-password"
                        required
                    >

                </div>


                <!-- Submit -->

                <button
                    type="submit"
                    class="register-button"
                >

                    <i class="fa-solid fa-quill"></i>

                    Establish My Account

                </button>


            </form>


            <!-- Login -->

            <div class="register-login">

                <span>
                    Already known to the Emporium?
                </span>

                <a href="login.php">
                    Sign in to your account
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
