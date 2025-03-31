<div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="app-page-title"><?= $data['pageInfo']['title'];  ?></h1>
                <a href="<?= SITE_URL ?>/panel/products" class="btn btn-warning">Ürünlere Dön</a>
            </div>
            <hr class="mb-4">
            <div class="row g-4 settings-section">
                <div class="col-12 col-md-4">
                    <h3 class="section-title">Ürün Bilgileri</h3>
                    <div class="section-intro">Yeni ürün eklemek için aşağıdaki formu doldurun. Tüm alanların doldurulması zorunludur.</div>
                    <a href="<?= $data['product']['url'] ?>" target="_blank" class="btn btn-primary app-btn-primary d-block w-100">Bu Ürünü İncele</a>
<!--                    <pre>-->
<!--                        --><?php //print_r($data['product']) ?>
<!--                    </pre>-->
                </div>
                <div class="col-12 col-md-8">
                    <div class="app-card app-card-settings shadow-sm p-4">
                        <?php if(isset($data['alert'])): ?>
                            <div class="alert alert-<?= $data['alert']['type'] ?>">
                                <p><?= $data['alert']['msg'] ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="app-card-body">
                            <form class="settings-form" action="<?= SITE_URL ?>/panel/updateProduct" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="product-name" class="form-label">Ürün Adı</label>
                                    <input type="text" class="form-control" id="product-name" name="product_name" required value="<?= $data['product']['title'] ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="product-image" class="form-label">Ürün Resmi</label>
                                    <img src="<?= $data['product']['thumbnail'] ?>" alt="" style="width: auto; height: auto; max-height: 200px; border-radius: 6px; display: block; margin: 20px 0px;">
                                    <input type="file" class="form-control" id="product-image" name="product_image" accept="image/*">
                                </div>

                                <div class="mb-3">
                                    <label for="short-description" class="form-label">Kısa Açıklama</label>
                                    <textarea class="form-control" id="short-description" name="product_description" rows="2" required style="height: auto">
                                        <?= $data['product']['description'] ?>
                                    </textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="full-description" class="form-label">Ürün Açıklaması</label>
                                    <?= $data['editor']['content']  ?>
                                </div>

                                <div class="mb-3">
                                    <label for="product-category" class="form-label">Kategori</label>
                                    <?php if (count($data['cats'])>0):?>
                                    <select class="form-select" id="product-category" name="product_category" required>
                                        <?php foreach ($data['cats'] as $cat): ?>
                                            <option <?= $cat['id']==$data['product']['catID'] ? 'selected':'' ?> value="<?= $cat['id'] ?>"><?= $cat['title'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php else: ?>
                                    <div class="alert alert-warning">
                                        Lütfen Kategori Oluşturun
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="product-price" class="form-label">Ürün Fiyatı</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="product-price" name="product_price" step="0.01" min="0" required value="<?= $data['product']['price'] ?>">
                                            <span class="input-group-text">₺</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="discount-price" class="form-label">İndirimli Fiyat (Opsiyonel)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="discount-price" name="discount_price" step="0.01" min="0" value="<?= $data['product']['salePrice'] ?>">
                                            <span class="input-group-text">₺</span>
                                        </div>
                                    </div>
                                </div>


                                <input type="text" hidden="" name="id" value="<?= $data['product']['id'] ?>">
                                <input type="text" hidden="" name="param" value="<?= $data['product']['slug'] ?>">
                                <button type="submit" class="btn app-btn-primary" name="submit">Ürünü Güncelle</button>
                            </form>
                        </div><!--//app-card-body-->
                    </div><!--//app-card-->
                </div>
            </div><!--//row-->
        </div><!--//container-fluid-->
    </div><!--//app-content-->

</div>