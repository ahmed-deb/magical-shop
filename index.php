<?php
session_start();
require_once __DIR__ . "/includes/db.php";

// Example: Fetch products to use in your template
$stmt = $pdo->query("SELECT * FROM products WHERE is_active = 1");
$products = $stmt->fetchAll();
$cartCount = 0;

if (!empty($_SESSION["cart"])) {
    $cartCount = array_sum($_SESSION["cart"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>The Arcane Emporium</title>

    <link rel="icon" type="image/png" href="assets/images/logo.png">

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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>


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


    <main>

        <!-- Hero -->
 <section class="hero">
        <div class="container hero-container">

            <!-- Hero Content -->
            <div class="hero-content">

                <p class="hero-eyebrow">
                    Established in the Year of Our Lord 1687
                </p>

                <h1>
                    Wares for the
                    <span>Witch & Wizard</span>
                </h1>

                <p class="hero-description">
                    A most respectable establishment supplying potions,
                    ingredients, enchanted implements, scholarly necessities,
                    and other curious articles to magical folk of discerning taste.
                </p>

                <div class="hero-actions">
                    <a href="shop.php" class="btn btn-primary">
                        Enter the Emporium
                    </a>

                    <a href="shop.php?category=potions" class="btn btn-secondary">
                        Browse Potions
                    </a>
                </div>

                <p class="hero-note">
                    Wares dispatched by owl post throughout the known magical world.
                </p>

            </div>

            <!-- Hero Artwork -->
            <div class="hero-artwork">

                <div class="hero-artwork-frame">
                    <img
                        src="assets/images/hero-image.jpg"
                        alt="An enchanted potion and magical implements"
                    >
                </div>

                <div class="hero-stamp">
                    <span>Trusted</span>
                    <strong>Since</strong>
                    <span>1687</span>
                </div>

            </div>

        </div>
    </section>

    <!-- Featured Products -->
<section class="featured-products">

<div class="container products-grid">

    <?php if (!empty($products)): ?>

        <?php $featuredProducts = array_slice($products, 0, 4); ?>

        <?php foreach ($featuredProducts as $product): ?>

            <article class="product-card">

                <a
                    href="product.php?id=<?= $product["id"] ?>"
                    class="product-image"
                >
                    <img
                        src="assets/images/products/<?= htmlspecialchars(
                            $product["image"],
                        ) ?>"
                        alt="<?= htmlspecialchars($product["name"]) ?>"
                    >
                </a>

                <div class="product-info">

                    <p class="product-category">
                        <?= htmlspecialchars($product["category"]) ?>
                    </p>

                    <h3>
                        <a href="product.php?id=<?= $product["id"] ?>">
                            <?= htmlspecialchars($product["name"]) ?>
                        </a>
                    </h3>

                    <p class="product-description">
                        <?= htmlspecialchars($product["description"]) ?>
                    </p>

                    <div class="product-footer">

                        <span class="product-price">
                            <?= number_format($product["price"], 0) ?> Galleons
                        </span>

                        <button
                            type="button"
                            class="add-to-satchel"
                            aria-label="Add <?= htmlspecialchars(
                                $product["name"],
                            ) ?> to satchel"
                        >
                            <i class="fa-solid fa-bag-shopping"></i>
                        </button>

                    </div>

                </div>

            </article>

        <?php endforeach; ?>

    <?php else: ?>

        <p>No magical items available at the moment.</p>

    <?php endif; ?>

</div>

</section>

    </main>

    <footer>
    <div class="container">

        <!-- Footer Main -->
        <div class="footer-main">

            <!-- Brand -->
            <div class="footer-brand">

                <a href="index.php" class="footer-logo">
                    <img
                        src="assets/images/logo.png"
                        alt="The Arcane Emporium"
                    >
                </a>

                <p>
                    A respectable establishment supplying witches,
                    wizards, druids, and other curious folk since 1687.
                </p>

                <p class="footer-motto">
                    <em>Quality wares. Honest enchantments.</em>
                </p>

            </div>


            <!-- Shop -->
            <div class="footer-column">

                <h3>The Emporium</h3>

                <ul>
                    <li>
                        <a href="shop.php">All Wares</a>
                    </li>
                    <li>
                        <a href="shop.php?category=potions">Potions</a>
                    </li>
                    <li>
                        <a href="shop.php?category=ingredients">
                            Potion Ingredients
                        </a>
                    </li>
                    <li>
                        <a href="shop.php?category=wands">
                            Wands & Implements
                        </a>
                    </li>
                    <li>
                        <a href="shop.php?category=robes">
                            Robes & Raiment
                        </a>
                    </li>
                    <li>
                        <a href="shop.php?category=beasts">
                            Beasts & Familiars
                        </a>
                    </li>
                </ul>

            </div>


            <!-- Information -->
            <div class="footer-column">

                <h3>The Establishment</h3>

                <ul>
                    <li>
                        <a href="about.php">Our Story</a>
                    </li>
                    <li>
                        <a href="contact.php">Owl Post</a>
                    </li>
                    <li>
                        <a href="shipping.php">Dispatch & Delivery</a>
                    </li>
                    <li>
                        <a href="returns.php">Returns & Exchanges</a>
                    </li>
                    <li>
                        <a href="faq.php">Frequently Asked Questions</a>
                    </li>
                </ul>

            </div>


            <!-- Customer -->
            <div class="footer-column">

                <h3>For the Customer</h3>

                <ul>
                    <li>
                        <a href="account.php">My Account</a>
                    </li>
                    <li>
                        <a href="orders.php">Order Ledger</a>
                    </li>
                    <li>
                        <a href="wishlist.php">Saved Wares</a>
                    </li>
                    <li>
                        <a href="cart.php">My Satchel</a>
                    </li>
                </ul>

            </div>

        </div>


        <!-- Footer Divider -->
        <div class="footer-divider"></div>


        <!-- Footer Bottom -->
        <div class="footer-bottom">

            <p>
                &copy; <?php echo date("Y"); ?> The Arcane Emporium.
                All rights reserved.
            </p>

            <div class="footer-legal">
                <a href="privacy.php">Privacy</a>
                <a href="terms.php">Terms of Trade</a>
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

    </div>    </footer>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="assets/js/app.js"></script>


</body>
</html>