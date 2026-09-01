<?php
session_start();
require_once "includes/db.php";

/*
|--------------------------------------------------------------------------
| Search & Category Filters
|--------------------------------------------------------------------------
*/

$search = trim($_GET["search"] ?? "");
$category = trim($_GET["category"] ?? "");

/*
|--------------------------------------------------------------------------
| Get Categories
|--------------------------------------------------------------------------
*/

$categoryQuery = $pdo->query("
    SELECT DISTINCT category
    FROM products
    WHERE category IS NOT NULL
    AND category != ''
    ORDER BY category
");

$categories = $categoryQuery->fetchAll(PDO::FETCH_COLUMN);

/*
|--------------------------------------------------------------------------
| Get Products
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT *
    FROM products
    WHERE 1
";

$params = [];

/*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/

if ($search !== "") {
    $sql .= "
        AND (
            name LIKE :search
            OR description LIKE :search
            OR category LIKE :search
        )
    ";

    $params["search"] = "%$search%";
}

/*
|--------------------------------------------------------------------------
| Category Filter
|--------------------------------------------------------------------------
*/

if ($category !== "") {
    $sql .= "
        AND category = :category
    ";

    $params["category"] = $category;
}

/*
|--------------------------------------------------------------------------
| Order
|--------------------------------------------------------------------------
*/

$sql .= "
    ORDER BY id DESC
";

/*
|--------------------------------------------------------------------------
| Execute Query
|--------------------------------------------------------------------------
*/

$productQuery = $pdo->prepare($sql);
$productQuery->execute($params);

$products = $productQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>The Emporium | The Arcane Emporium</title>

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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/shop.css">

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
     SHOP PAGE
===================================================== -->

<main>

    <!-- Shop Hero -->

    <section class="shop-header">

        <div class="container">

            <p class="section-eyebrow">
                The Arcane Catalogue
            </p>

            <h1>
                The Emporium
            </h1>

            <p>
                Browse our respectable collection of magical wares,
                ingredients, implements, garments, creatures and curiosities.
            </p>

        </div>

    </section>



    <!-- =================================================
         SHOP
    ================================================== -->

    <section class="shop-section">

        <div class="container">


            <!-- Search -->

            <form
                action="shop.php"
                method="GET"
                class="shop-search"
            >

                <div class="search-input-wrapper">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="search"
                        name="search"
                        placeholder="Seek an item within the catalogue..."
                        value="<?= htmlspecialchars($search) ?>"
                    >

                </div>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Search the Catalogue
                </button>

            </form>



            <!-- Categories -->

            <div class="shop-categories">

                <a
                    href="shop.php"
                    class="<?= $category === "" ? "active" : "" ?>"
                >
                    All Wares
                </a>


                <?php foreach ($categories as $cat): ?>

                    <a
                        href="shop.php?category=<?= urlencode($cat) ?>"
                        class="<?= $category === $cat ? "active" : "" ?>"
                    >

                        <?= htmlspecialchars($cat) ?>

                    </a>

                <?php endforeach; ?>

            </div>



            <!-- Results Information -->

            <div class="shop-results">

                <p>

                    <?php if ($search !== ""): ?>

                        Showing results for
                        <strong>
                            "<?= htmlspecialchars($search) ?>"
                        </strong>

                    <?php elseif ($category !== ""): ?>

                        Showing wares from
                        <strong>
                            <?= htmlspecialchars($category) ?>
                        </strong>

                    <?php else: ?>

                        All available wares

                    <?php endif; ?>

                </p>


                <span>

                    <?= count($products) ?>

                    <?= count($products) === 1 ? "article" : "articles" ?>

                </span>

            </div>



            <!-- =================================================
                 PRODUCTS
            ================================================== -->

            <?php if (!empty($products)): ?>

                <div class="products-grid">

                    <?php foreach ($products as $product): ?>

                        <article class="product-card">


                            <!-- Product Image -->

                            <a
                                href="product.php?id=<?= $product["id"] ?>"
                                class="product-image"
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


                            <!-- Product Information -->

                            <div class="product-info">


                                <p class="product-category">

                                    <?= htmlspecialchars(
                                        $product["category"],
                                    ) ?>

                                </p>


                                <h3>

                                    <a
                                        href="product.php?id=<?= $product[
                                            "id"
                                        ] ?>"
                                    >

                                        <?= htmlspecialchars(
                                            $product["name"],
                                        ) ?>

                                    </a>

                                </h3>


                                <p class="product-description">

                                    <?= htmlspecialchars(
                                        $product["description"],
                                    ) ?>

                                </p>


                                <!-- Product Footer -->

                                <div class="product-footer">


                                    <span class="product-price">

                                        <?= number_format(
                                            $product["price"],
                                            0,
                                        ) ?>

                                        Galleons

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

                </div>


            <?php else: ?>

                <!-- Empty Results -->

                <div class="empty-shop">

                    <i class="fa-solid fa-flask"></i>

                    <h2>
                        The Shelves Be Bare
                    </h2>

                    <p>
                        Alas, no wares matching thy request could be found.
                    </p>

                    <a
                        href="shop.php"
                        class="btn btn-primary"
                    >
                        View All Wares
                    </a>

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


            <!-- Brand -->

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


            <!-- Shop -->

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


            <!-- Establishment -->

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


            <!-- Customer -->

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