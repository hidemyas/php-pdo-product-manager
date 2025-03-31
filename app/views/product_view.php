<?php $product=$data['product'];
?>
<div class="col-md-8">
    <div class="product">
        <div class="card product-card" >
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?= $product['thumbnail'] ?>" class="img-fluid rounded-start" alt="<?= $product['title'] ?>" title="<?= $product['title'] ?>">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['title'] ?></h5>
                        <a href="#">
                            <span class="badge rounded-pill text-bg-primary"><?= $product['cat']['title'] ?></span>
                        </a>
                        <p class="card-text">
                            <?= $product['content'] ?>
                        </p>

                        <div class="price-info">
                            <?php if ($product['salePrice']): ?>
                                <span class="sale-price text-success"><?= $product['salePrice'] ?></span>
                                <del><span class="sale-price text-secondary del"><?= $product['price'] ?></span></del>
                            <?php else: ?>
                                <span class="sale-price text-dark"><b><?= $product['price'] ?></b></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>