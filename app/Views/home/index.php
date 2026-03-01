<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<section class="hero-section text-center text-md-start">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <h1 class="display-4 fw-bold">Welcome to <br> The world of Tasty & Fresh Pizza</h1>
                <p class="lead">Fresh, cheesy, and guaranteed to make you happy! Every bite is a perfect blend of rich flavors and premium ingredients.</p>
                <a href="#menu" class="btn btn-custom btn-lg px-4">Choose a Pizza</a>
            </div>
            <div class="col-md-6 text-center">
                <img src="<?= base_url('img/home.png'); ?>" alt="home" class="img-fluid w-75">
            </div>
        </div>
    </div>
</section>

<section id="menu" class="container mt-5 pt-5 mb-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Most Popular Pizza</h2>
        <p class="text-muted">We have selected for You the most exquisite tastes around the world</p>
    </div>

    <div class="row g-4">
        <?php foreach ($products as $product): ?>
        <div class="col-md-6 col-lg-3">
            <div class="card pizza-card h-100 text-center p-3">
                <img src="<?= base_url(str_replace('public/', '', $product['img'])); ?>" class="card-img-top w-75 mx-auto" alt="<?= $product['name']; ?>">
                
                <div class="card-body">
                    <h5 class="card-title fw-bold"><?= $product['name']; ?></h5>
                    <h6 class="text-danger fw-bold">$<?= number_format($product['price'], 2); ?></h6>
                    <p class="card-text small text-muted"><?= $product['desc']; ?></p>
                </div>
                
                <div class="card-footer bg-transparent border-0">
                    <form action="/cart/add" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                        <button type="submit" class="btn btn-warning w-100 text-white fw-bold">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<?= $this->endSection(); ?>