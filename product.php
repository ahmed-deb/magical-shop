<?php

require_once "includes/db.php";

// Get product ID from URL
$productId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

// If no valid ID was provided
if (!$productId) {
    http_response_code(404);
    die("Product not found.");
}

// Get the product from the database
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");

$stmt->execute([$productId]);

$product = $stmt->fetch();

// Product doesn't exist
if (!$product) {
    http_response_code(404);
    die("Product not found.");
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
        <?= htmlspecialchars($product["name"]) ?>
        | The Arcane Emporium
    </title>

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

    <!-- Main CSS -->
    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

    <!-- Product CSS -->
    <link
        rel="stylesheet"
        href="assets/css/product.css"
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
                    0
                </span>

            </a>

        </div>

    </div>

</header>



<!-- =====================================================
     PRODUCT
===================================================== -->

<main>

    <section class="product-page">

        <div class="container">

            <!-- Breadcrumb -->

            <nav
                class="product-breadcrumb"
                aria-label="Breadcrumb"
            >

                <a href="index.php">
                    Home
                </a>

                <i class="fa-solid fa-chevron-right"></i>

                <a href="shop.php">
                    The Emporium
                </a>

                <i class="fa-solid fa-chevron-right"></i>

                <span>
                    <?= htmlspecialchars($product["name"]) ?>
                </span>

            </nav>


            <!-- Product -->

            <div class="product-detail">

                <!-- Image -->

                <div class="product-detail-image">

                    <div class="product-image-frame">

                        <img
                            src="assets/images/products/<?= htmlspecialchars(
                                $product["image"],
                            ) ?>"
                            alt="<?= htmlspecialchars($product["name"]) ?>"
                        >

                    </div>

                </div>


                <!-- Information -->

                <div class="product-detail-info">

                    <p class="product-detail-category">

                        <?= htmlspecialchars($product["category"]) ?>

                    </p>


                    <h1>

                        <?= htmlspecialchars($product["name"]) ?>

                    </h1>


                    <div class="product-divider"></div>


                    <p class="product-detail-description">

                        <?= htmlspecialchars($product["description"]) ?>

                    </p>


                    <!-- Price -->

                    <div class="product-detail-price">

                        <?= number_format($product["price"], 0) ?>

                        <span>
                            Galleons
                        </span>

                    </div>


                    <!-- Stock -->

                    <div class="product-stock">

                        <i class="fa-solid fa-circle-check"></i>

                        Available from the Emporium

                    </div>


                    <!-- Quantity -->

                    <div class="quantity-section">

                        <label for="quantity">
                            Quantity
                        </label>

                    <div class="quantity-control">

                        <button
                            type="button"
                            class="quantity-button quantity-decrease"
                            aria-label="Decrease quantity"
                        >
                            <i class="fa-solid fa-minus"></i>
                        </button>

                        <input
                            type="number"
                            name="quantity"
                            value="1"
                            min="1"
                            max="99"
                            aria-label="Quantity"
                        >

                        <button
                            type="button"
                            class="quantity-button quantity-increase"
                            aria-label="Increase quantity"
                        >
                            <i class="fa-solid fa-plus"></i>
                        </button>

                    </div>

                    </div>


                    <!-- Add to Satchel -->

<form method="POST" action="cart.php">

    <input
        type="hidden"
        name="action"
        value="add"
    >

    <input
        type="hidden"
        name="product_id"
        value="<?= $product["id"] ?>"
    >

    <input
        type="hidden"
        name="quantity"
        value="1"
    >

    <button
        type="submit"
        class="add-to-satchel-large"
    >

        <i class="fa-solid fa-bag-shopping"></i>

        Add to Satchel

    </button>

</form>


                    <!-- Product note -->

                    <p class="product-note">

                        <i class="fa-solid fa-feather-pointed"></i>

                        Carefully packed and dispatched by Owl Post.

                    </p>

                </div>

            </div>

        </div>

    </section>



    <!-- =================================================
         PRODUCT DETAILS
    ================================================== -->

    <section class="product-description-section">

        <div class="container">

            <div class="description-inner">

                <p class="product-detail-category">
                    A Note from the Emporium
                </p>

                <h2>
                    A Proper Addition to Your Magical Collection
                </h2>

                <p>
                    Every item found upon our shelves has been selected
                    with considerable care. Whether intended for study,
                    potion-making, household enchantment or adventures
                    of questionable wisdom, we expect our wares to serve
                    their new owners admirably.
                </p>

            </div>

        </div>

    </section>



    <!-- =================================================
         RETURN TO SHOP
    ================================================== -->

    <section class="product-back">

        <div class="container">

            <a href="shop.php">

                <i class="fa-solid fa-arrow-left"></i>

                Return to the Emporium

            </a>

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


<!-- =====================================================
     QUANTITY JAVASCRIPT
===================================================== -->

<script>

const quantityInput = document.getElementById("quantity");

const decreaseButton =
    document.getElementById("decrease-quantity");

const increaseButton =
    document.getElementById("increase-quantity");


decreaseButton.addEventListener("click", () => {

    const currentValue =
        parseInt(quantityInput.value);

    if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
    }

});


increaseButton.addEventListener("click", () => {

    const currentValue =
        parseInt(quantityInput.value);

    if (currentValue < 99) {
        quantityInput.value = currentValue + 1;
    }

});

</script>

<script src="assets/js/app.js"></script>
</body>
</html>