
<div class="col-md-8">
<?php $products =   $data['products'];
    if (count($products)>0):
?>
    <div class="alert alert-light">
        <span>Toplam <?= count($products) ?> ürün listelenmektedir</span>
    </div>
    <div class="products row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 my-2">
            <div class="card product-card">
                <!-- @TODO : Ürün Resimler Dinmaikleştireleck  -->
                <img src="<?= $product['thumbnail'] ?>" class="card-img-top" alt="<?= $product['title'] ?>" title="<?= $product['title'] ?>">
                <div class="card-body">
                    <a href="<?= $product['url'] ?>" class="product-title"><h5 class="card-title"><?= $product['title'] ?></h5></a>

                        <span class="badge rounded-pill text-bg-primary"><?= $product['cat']['title'] ?></span>

                    <p class="card-text"><?= $product['description'] ?></p>
                    <div class="d-flex price-info justify-content-between">
                        <?php if ($product['salePrice']): ?>
                            <span class="sale-price text-success"><?= $product['salePrice'] ?></span>
                            <del><span class="sale-price text-secondary del"><?= $product['price'] ?></span></del>
                        <?php else: ?>
                            <span class="sale-price text-secondary"><?= $product['price'] ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?= $data['pagination'] ?>
    <?php else: ?>
    <div class="alert alert-info">
        <p>Herhangi bir ürün bulunamadı</p>
    </div>
    <?php endif; ?>
</div>