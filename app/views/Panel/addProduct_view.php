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
<!--                    <pre>-->
<!--                        --><?php //print_r($data['product']) ?>
<!--                    </pre>-->
                </div>
                <div class="col-12 col-md-8">
                    <div class="app-card app-card-settings shadow-sm p-4">
                        <?php
                        if(isset($data['alert'])): ?>
                            <div class="alert alert-<?= $data['alert']['type'] ?>">
                                <p><?= $data['alert']['msg'] ?></p>
                            </div>

                        <?php  endif;

                            $data['alert']['type'] = isset($data['alert']['type']) ? $data['alert']['type'] : '';
                            if ($data['alert']['type'] == 'success'):
                                    ?>
                                    <table class="table app-table-hover mb-0 text-left">
                                        <thead>
                                        <tr>
                                            <th class="cell">Ürün İsmi</th>
                                            <th class="cell">Kısa Açıklama</th>
                                            <th class="cell">İndirimli Fiyat</th>
                                            <th class="cell">Normal Fiyat</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="cell"><span class="truncate"><?= $data['form']['product_name'] ?></span></td>
                                            <td class="cell"><?= $data['form']['product_description'] ?></td>
                                            <td class="cell"><?= $data['form']['discount_price'] ?? 0 ?></td>
                                            <td class="cell"><?= $data['form']['product_price'] ?></td>
                                        </tr>

                                        </tbody>
                                    </table>
                                <?php
                                else:
                                ?>

                                    <div class="app-card-body">
                            <form class="settings-form" action="<?= SITE_URL ?>/panel/setProduct" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="product-name" class="form-label">Ürün Adı</label>
                                    <input type="text" class="form-control <?= isset($data['errors']['product_name']) ? 'is-invalid': '' ?>" id="product-name" name="product_name" required
                                           value="<?= isset($data['form']['product_name']) ? $data['form']['product_name']:'' ?>">
                                    <?php if (isset($data['errors']['product_name'])): ?>
                                        <div class="invalid-feedback">
                                            <?php foreach ($data['errors']['product_name'] as $key => $err) echo $err."<br/>";?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="product-image" class="form-label">Ürün Resmi</label>
                                    <input type="file" class="form-control <?= isset($data['errors']['product_image']) ? 'is-invalid': '' ?>" id="product-image" name="product_image" accept="image/*">
                                    <?php if (isset($data['errors']['product_image'])): ?>
                                        <div class="invalid-feedback">
                                            <?php foreach ($data['errors']['product_image'] as $key => $err) echo $err."<br/>";?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="short-description" class="form-label">Kısa Açıklama</label>
                                    <textarea class="form-control <?= isset($data['errors']['product_description']) ? 'is-invalid': '' ?>" id="short-description" name="product_description" rows="2" required style="height: auto"><?= isset($data['form']['product_name']) ? $data['form']['product_description']:'' ?></textarea>
                                    <?php if (isset($data['errors']['product_description'])): ?>
                                        <div class="invalid-feedback">
                                            <?php foreach ($data['errors']['product_description'] as $key => $err) echo $err."<br/>";?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="full-description" class="form-label">Ürün Açıklaması</label>
                                    <?= $data['editor']['content']  ?>
                                    <?php if (isset($data['errors']['product_content'])): ?>
                                        <div class="invalid-feedback">
                                            <?php foreach ($data['errors']['product_description'] as $key => $err) echo $err."<br/>";?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="product-category" class="form-label">Kategori</label>
                                    <?php if (count($data['cats'])>0):?>
                                        <select class="form-select <?= isset($data['errors']['product_category']) ? 'is-invalid': '' ?>" id="product-category" name="product_category" required>
                                            <option disabled>Bir Kategori Seçiniz</option>
                                            <?php
                                            $active =  isset($data['form']['product_category']) ? $data['form']['product_category'] : '';

                                            foreach ($data['cats'] as $cat): ?>
                                                <option <?= $active==$cat['id']  ? 'selected':'' ?> value="<?= $cat['id'] ?>"><?= $cat['title'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php else: ?>
                                        <div class="alert alert-warning">
                                            Lütfen Kategori Oluşturun
                                        </div>
                                    <?php endif; ?>
                                    <?php if (isset($data['errors']['product_content'])): ?>
                                        <div class="invalid-feedback">
                                            <?php foreach ($data['errors']['product_category'] as $key => $err) echo $err."<br/>";?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="product-price" class="form-label">Ürün Fiyatı</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control <?= isset($data['errors']['product_price']) ? 'is-invalid': '' ?>" id="product-price" name="product_price" step="0.01" min="0" required
                                                   value="<?= isset($data['form']['product_name']) ? $data['form']['product_price']:'' ?>">
                                            <span class="input-group-text">₺</span>
                                            <?php if (isset($data['errors']['product_price'])): ?>
                                                <div class="invalid-feedback">
                                                    <?php foreach ($data['errors']['product_price'] as $key => $err) echo $err."<br/>";?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="discount-price" class="form-label">İndirimli Fiyat (Opsiyonel)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="discount-price" name="discount_price" step="0.01" min="0"
                                                   value="<?= isset($data['form']['product_name']) ? $data['form']['discount_price']:'' ?>">
                                            <span class="input-group-text">₺</span>
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn app-btn-primary" name="submit">Yeni Ürün Ekle</button>
                            </form>
                        </div><!--//app-card-body-->
                                <?php
                                endif;

                        ?>

                    </div><!--//app-card-->
                </div>
            </div><!--//row-->
        </div><!--//container-fluid-->
    </div><!--//app-content-->

</div>