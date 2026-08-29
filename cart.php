<?php
session_start();

require_once "includes/db.php";

// Create an empty cart if one doesn't exist
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// Handle cart actions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";
    $productId = filter_input(INPUT_POST, "product_id", FILTER_VALIDATE_INT);

    // -----------------------------------------
    // Add product
    // -----------------------------------------

    if ($action === "add" && $productId) {
        if (isset($_SESSION["cart"][$productId])) {
            $_SESSION["cart"][$productId]++;
        } else {
            $_SESSION["cart"][$productId] = 1;
        }
    }

    // -----------------------------------------
    // Update quantity
    // -----------------------------------------

    if ($action === "update" && $productId) {
        $quantity = filter_input(INPUT_POST, "quantity", FILTER_VALIDATE_INT);

        if ($quantity && $quantity > 0) {
            $_SESSION["cart"][$productId] = $quantity;
        } else {
            unset($_SESSION["cart"][$productId]);
        }
    }

    // -----------------------------------------
    // Remove product
    // -----------------------------------------

    if ($action === "remove" && $productId) {
        unset($_SESSION["cart"][$productId]);
    }

    // Redirect to prevent form resubmission
    header("Location: cart.php");
    exit();
}

// -----------------------------------------
// Get products from database
// -----------------------------------------

$cartProducts = [];
$cartTotal = 0;

if (!empty($_SESSION["cart"])) {
    $productIds = array_keys($_SESSION["cart"]);

    $placeholders = implode(",", array_fill(0, count($productIds), "?"));

    $stmt = $pdo->prepare(
        "SELECT * FROM products
         WHERE id IN ($placeholders)",
    );

    $stmt->execute($productIds);

    $products = $stmt->fetchAll();

    foreach ($products as $product) {
        $quantity = $_SESSION["cart"][$product["id"]];

        $subtotal = $product["price"] * $quantity;

        $cartTotal += $subtotal;

        $cartProducts[] = [
            "product" => $product,
            "quantity" => $quantity,
            "subtotal" => $subtotal,
        ];
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
        Your Satchel | The Arcane Emporium
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
        href="assets/css/cart.css"
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
     SATCHEL
===================================================== -->

<main>

    <section class="cart-page">

        <div class="container">


            <div class="cart-heading">

                <p class="cart-eyebrow">
                    The Arcane Emporium
                </p>

                <h1>
                    Your Satchel
                </h1>

                <p>
                    The magical provisions you have selected
                    for your journey.
                </p>

            </div>


            <?php if (empty($cartProducts)): ?>

                <!-- EMPTY SATCHEL -->

                <div class="empty-cart">

                    <div class="empty-cart-icon">

                        <i class="fa-solid fa-bag-shopping"></i>

                    </div>

                    <h2>
                        Your Satchel Is Empty
                    </h2>

                    <p>
                        It appears you have yet to select
                        anything from our shelves.
                    </p>

                    <a
                        href="shop.php"
                        class="cart-button"
                    >
                        Browse the Emporium
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </div>


            <?php else: ?>


                <!-- CART CONTENT -->

                <div class="cart-layout">


                    <!-- PRODUCTS -->

                    <div class="cart-items">

                        <?php foreach ($cartProducts as $item): ?>

                            <?php
                            $product = $item["product"];
                            $quantity = $item["quantity"];
                            $subtotal = $item["subtotal"];
                            ?>


                            <article class="cart-item">


                                <a
                                    href="product.php?id=<?= $product["id"] ?>"
                                    class="cart-item-image"
                                >

                                    <img
                                        src="assets/images/products/<?= htmlspecialchars(
                                            $product["image"],
                                        ) ?>"
                                        alt="<?= htmlspecialchars(
                                            $product["name"],
                                        ) ?>"
                                    >

                                </a>


                                <div class="cart-item-info">


                                    <p class="cart-item-category">

                                        <?= htmlspecialchars(
                                            $product["category"],
                                        ) ?>

                                    </p>


                                    <h2>

                                        <a
                                            href="product.php?id=<?= $product[
                                                "id"
                                            ] ?>"
                                        >
                                            <?= htmlspecialchars(
                                                $product["name"],
                                            ) ?>
                                        </a>

                                    </h2>


                                    <p class="cart-item-price">

                                        <?= number_format(
                                            $product["price"],
                                            0,
                                        ) ?>

                                        Galleons each

                                    </p>


                                    <div class="cart-item-actions">


                                        <!-- Quantity -->

                                        <form
                                            method="POST"
                                            class="quantity-form"
                                        >

                                            <input
                                                type="hidden"
                                                name="action"
                                                value="update"
                                            >

                                            <input
                                                type="hidden"
                                                name="product_id"
                                                value="<?= $product["id"] ?>"
                                            >


                                            <label
                                                for="quantity-<?= $product[
                                                    "id"
                                                ] ?>"
                                            >
                                                Quantity
                                            </label>


                                            <div class="quantity-control">

                                                <input
                                                    type="number"
                                                    id="quantity-<?= $product[
                                                        "id"
                                                    ] ?>"
                                                    name="quantity"
                                                    value="<?= $quantity ?>"
                                                    min="1"
                                                    max="99"
                                                >

                                                <button
                                                    type="submit"
                                                    aria-label="Update quantity"
                                                >
                                                    <i class="fa-solid fa-rotate"></i>
                                                </button>

                                            </div>

                                        </form>


                                        <!-- Remove -->

                                        <form method="POST">

                                            <input
                                                type="hidden"
                                                name="action"
                                                value="remove"
                                            >

                                            <input
                                                type="hidden"
                                                name="product_id"
                                                value="<?= $product["id"] ?>"
                                            >

                                            <button
                                                type="submit"
                                                class="remove-item"
                                            >

                                                <i class="fa-solid fa-trash-can"></i>

                                                Remove

                                            </button>

                                        </form>


                                    </div>

                                </div>


                                <!-- Subtotal -->

                                <div class="cart-item-subtotal">

                                    <?= number_format($subtotal, 0) ?>

                                    <span>
                                        Galleons
                                    </span>

                                </div>


                            </article>

                        <?php endforeach; ?>

                    </div>



                    <!-- SUMMARY -->

                    <aside class="cart-summary">


                        <p class="cart-summary-eyebrow">
                            Purchase Ledger
                        </p>


                        <h2>
                            Your Order
                        </h2>


                        <div class="summary-row">

                            <span>
                                Items
                            </span>

                            <span>
                                <?= array_sum($_SESSION["cart"]) ?>
                            </span>

                        </div>


                        <div class="summary-row">

                            <span>
                                Subtotal
                            </span>

                            <span>
                                <?= number_format($cartTotal, 0) ?>
                                Galleons
                            </span>

                        </div>


                        <div class="summary-divider"></div>


                        <div class="summary-total">

                            <span>
                                Total
                            </span>

                            <strong>
                                <?= number_format($cartTotal, 0) ?>

                                Galleons
                            </strong>

                        </div>


                        <a
                            href="checkout.php"
                            class="checkout-button"
                        >

                            Proceed to Settlement

                            <i class="fa-solid fa-arrow-right"></i>

                        </a>


                        <a
                            href="shop.php"
                            class="continue-shopping"
                        >

                            <i class="fa-solid fa-arrow-left"></i>

                            Continue Browsing

                        </a>


                    </aside>

                </div>

            <?php endif; ?>

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
