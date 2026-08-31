<?php

session_start();

require_once "includes/db.php";

// ---------------------------------------------------------
// Make sure the satchel exists and isn't empty
// ---------------------------------------------------------

if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
    header("Location: cart.php");
    exit();
}

// ---------------------------------------------------------
// Get products from database
// ---------------------------------------------------------

$productIds = array_keys($_SESSION["cart"]);

$placeholders = implode(",", array_fill(0, count($productIds), "?"));

$stmt = $pdo->prepare(
    "SELECT *
     FROM products
     WHERE id IN ($placeholders)",
);

$stmt->execute($productIds);

$products = $stmt->fetchAll();

// ---------------------------------------------------------
// Build order summary
// ---------------------------------------------------------

$checkoutItems = [];
$cartTotal = 0;

foreach ($products as $product) {
    $quantity = $_SESSION["cart"][$product["id"]];

    if ($quantity < 1) {
        continue;
    }

    $subtotal = $product["price"] * $quantity;

    $cartTotal += $subtotal;

    $checkoutItems[] = [
        "product" => $product,
        "quantity" => $quantity,
        "subtotal" => $subtotal,
    ];
}

// ---------------------------------------------------------
// Form variables
// ---------------------------------------------------------

$errors = [];

$name = "";
$email = "";
$phone = "";
$address = "";
$city = "";

// ---------------------------------------------------------
// Handle checkout
// ---------------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $address = trim($_POST["address"] ?? "");
    $city = trim($_POST["city"] ?? "");

    // -----------------------------------------------------
    // Validation
    // -----------------------------------------------------

    if ($name === "") {
        $errors[] = "Please provide your name.";
    }

    if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please provide a valid owl post address.";
    }

    if ($phone === "") {
        $errors[] = "Please provide your telephone number.";
    }

    if ($address === "") {
        $errors[] = "Please provide your delivery address.";
    }

    if ($city === "") {
        $errors[] = "Please provide your city.";
    }

    // -----------------------------------------------------
    // Create order
    // -----------------------------------------------------

    if (empty($errors)) {
        try {
            $pdo->beginTransaction();

            // ---------------------------------------------
            // Insert order
            // ---------------------------------------------

            $orderStmt = $pdo->prepare(
                "INSERT INTO orders
                (
                    customer_name,
                    email,
                    phone,
                    address,
                    city,
                    total,
                    status
                )
                VALUES
                (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                )",
            );

            $orderStmt->execute([
                $name,
                $email,
                $phone,
                $address,
                $city,
                $cartTotal,
                "Pending",
            ]);

            $orderId = $pdo->lastInsertId();

            // ---------------------------------------------
            // Insert order items
            // ---------------------------------------------

            $itemStmt = $pdo->prepare(
                "INSERT INTO order_items
                (
                    order_id,
                    product_id,
                    product_name,
                    price,
                    quantity,
                    subtotal
                )
                VALUES
                (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                )",
            );

            foreach ($checkoutItems as $item) {
                $product = $item["product"];

                $itemStmt->execute([
                    $orderId,
                    $product["id"],
                    $product["name"],
                    $product["price"],
                    $item["quantity"],
                    $item["subtotal"],
                ]);
            }

            // ---------------------------------------------
            // Everything worked
            // ---------------------------------------------

            $pdo->commit();

            // Empty the satchel
            $_SESSION["cart"] = [];

            // Store order information for confirmation
            $_SESSION["last_order_id"] = $orderId;

            header("Location: order-success.php");

            exit();
        } catch (PDOException $e) {
            $pdo->rollBack();

            $errors[] =
                "We were unable to record your order. Please try again.";
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
        Settlement | The Arcane Emporium
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
        href="assets/css/checkout.css"
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
            >
                <i class="fa-solid fa-magnifying-glass"></i>
            </a>


            <a
                href="account.php"
                class="header-action"
                aria-label="My account"
            >
                <i class="fa-solid fa-user"></i>
            </a>


            <a
                href="cart.php"
                class="header-action"
                aria-label="Your satchel"
            >

                <i class="fa-solid fa-bag-shopping"></i>

                <span class="cart-count">
                    <?= array_sum($_SESSION["cart"]) ?>
                </span>

            </a>

        </div>

    </div>

</header>



<!-- =====================================================
     CHECKOUT
===================================================== -->

<main>

    <section class="checkout-page">

        <div class="container">


            <!-- Heading -->

            <div class="checkout-heading">

                <p class="checkout-eyebrow">
                    The Arcane Emporium
                </p>

                <h1>
                    Settlement of Account
                </h1>

                <p>
                    Pray provide the necessary particulars
                    and we shall prepare your order for dispatch.
                </p>

            </div>


            <!-- Errors -->

            <?php if (!empty($errors)): ?>

                <div class="checkout-errors">

                    <div class="checkout-errors-title">

                        <i class="fa-solid fa-circle-exclamation"></i>

                        A few matters require your attention.

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


            <!-- Layout -->

            <div class="checkout-layout">


                <!-- =========================================
                     CUSTOMER DETAILS
                ========================================== -->

                <div class="checkout-form-wrapper">

                    <div class="checkout-section-heading">

                        <span class="section-number">
                            I
                        </span>

                        <div>

                            <p>
                                Delivery Particulars
                            </p>

                            <h2>
                                Where shall we send your wares?
                            </h2>

                        </div>

                    </div>


                    <form
                        method="POST"
                        class="checkout-form"
                    >


                        <!-- Name -->

                        <div class="form-group">

                            <label for="name">
                                Full Name
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

                            <small>
                                We shall use this address to send
                                your purchase confirmation.
                            </small>

                        </div>


                        <!-- Phone -->

                        <div class="form-group">

                            <label for="phone">
                                Telephone
                            </label>

                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                value="<?= htmlspecialchars($phone) ?>"
                                placeholder="Your telephone number"
                                autocomplete="tel"
                                required
                            >

                        </div>


                        <!-- Address -->

                        <div class="form-group">

                            <label for="address">
                                Delivery Address
                            </label>

                            <textarea
                                id="address"
                                name="address"
                                rows="4"
                                placeholder="Where should our owl deliver your parcel?"
                                autocomplete="street-address"
                                required
                            ><?= htmlspecialchars($address) ?></textarea>

                        </div>


                        <!-- City -->

                        <div class="form-group">

                            <label for="city">
                                City
                            </label>

                            <input
                                type="text"
                                id="city"
                                name="city"
                                value="<?= htmlspecialchars($city) ?>"
                                placeholder="Your city"
                                autocomplete="address-level2"
                                required
                            >

                        </div>


                        <!-- Payment -->

                        <div class="checkout-section-heading payment-heading">

                            <span class="section-number">
                                II
                            </span>

                            <div>

                                <p>
                                    Settlement
                                </p>

                                <h2>
                                    Method of Payment
                                </h2>

                            </div>

                        </div>


                        <div class="payment-notice">

                            <i class="fa-solid fa-coins"></i>

                            <div>

                                <strong>
                                    Galleons upon delivery
                                </strong>

                                <p>
                                    For the purposes of this student
                                    establishment, payment shall be
                                    collected upon delivery.
                                </p>

                            </div>

                        </div>


                        <!-- Submit -->

                        <button
                            type="submit"
                            class="place-order-button"
                        >

                            <i class="fa-solid fa-feather-pointed"></i>

                            Place My Order

                        </button>


                        <p class="checkout-security">

                            <i class="fa-solid fa-shield-halved"></i>

                            Your particulars shall be treated
                            with the utmost discretion.

                        </p>


                    </form>

                </div>



                <!-- =========================================
                     ORDER SUMMARY
                ========================================== -->

                <aside class="checkout-summary">

                    <p class="summary-eyebrow">
                        Your Satchel
                    </p>

                    <h2>
                        Purchase Ledger
                    </h2>


                    <div class="summary-products">

                        <?php foreach ($checkoutItems as $item): ?>

                            <?php $product = $item["product"]; ?>

                            <div class="summary-product">

                                <div class="summary-product-image">

                                    <img
                                        src="assets/images/products/<?= htmlspecialchars(
                                            $product["image"],
                                        ) ?>"
                                        alt="<?= htmlspecialchars(
                                            $product["name"],
                                        ) ?>"
                                    >

                                </div>


                                <div class="summary-product-info">

                                    <h3>
                                        <?= htmlspecialchars(
                                            $product["name"],
                                        ) ?>
                                    </h3>

                                    <p>
                                        <?= $item["quantity"] ?>
                                        ×
                                        <?= number_format(
                                            $product["price"],
                                            0,
                                        ) ?>
                                        Galleons
                                    </p>

                                </div>


                                <strong>

                                    <?= number_format($item["subtotal"], 0) ?>

                                </strong>

                            </div>

                        <?php endforeach; ?>

                    </div>


                    <div class="summary-divider"></div>


                    <div class="summary-total">

                        <span>
                            Total Due
                        </span>

                        <strong>

                            <?= number_format($cartTotal, 0) ?>

                            <small>
                                Galleons
                            </small>

                        </strong>

                    </div>


                    <a
                        href="cart.php"
                        class="edit-satchel"
                    >

                        <i class="fa-solid fa-arrow-left"></i>

                        Return to Satchel

                    </a>

                </aside>

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
```
