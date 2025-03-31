<?php $form_err =   isset($data['formErrors']) ? $data['formErrors'] : array(); ?>
<div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <h1 class="app-page-title"><?= $data['pageInfo']['title'] ?></h1>
            <hr class="mb-4">

            <div class="row g-4 settings-section">
                <div class="col-12 col-md-4">
                    <h3 class="section-title">Site Ayarları</h3>
                    <div class="section-intro">
                        Yan taraftaki alandan sitenizin işleyişi ile ilgili ayarları düzenleyebilirsiniz
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="app-card app-card-settings shadow-sm p-4">

                        <div class="app-card-body">
                            <?php if(isset($data['alert'])): ?>
                            <div class="alert alert-<?= $data['alert']['type'] ?>">
                                <p><?= $data['alert']['msg'] ?></p>
                            </div>
                            <?php endif; ?>
                            <form class="settings-form" action="<?= SITE_URL ?>/panel/saveSiteSettings" method="post">
                                <div class="mb-3">
                                    <label for="setting-input-1" class="form-label">Listelenecek Ürün Sayısı<span class="ms-2" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="hover focus"  data-bs-placement="top" data-bs-content="Sayfalama için sayfa başına düşen ürün sayısı 5 idealdir."><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                      <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                                      <circle cx="8" cy="4.5" r="1"/>
                                    </svg></span>
                                    </label>
                                    <input type="number" class="form-control <?= isset($form_err['urunSayisi']) ? 'is-invalid':'' ?>" id="setting-input-1" name="urunSayisi" value="<?= isset($data['siteSettings']['urunSayisi']) ? $data['siteSettings']['urunSayisi']:''  ?>" min="1">
                                    <?php if (isset($form_err['urunSayisi'])): ?>
                                        <div id="setting-input-2" class="invalid-feedback">
                                            <?= isset($form_err['urunSayisi']['empty']) ? $form_err['urunSayisi']['empty']:$form_err['urunSayisi']['equal'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                </div>
                                <div class="mb-3">
                                    <label for="setting-input-1" class="form-label">Listelenecek Kategori Sayısı<span class="ms-2" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="hover focus"  data-bs-placement="top" data-bs-content="Filtreleme Kısmında Gözükecek Maksimum Sayfa Sayısı"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                      <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                                      <circle cx="8" cy="4.5" r="1"/>
                                    </svg></span>
                                    </label>
                                    <input type="number" class="form-control <?= isset($form_err['kategoriSayisi']) ? 'is-invalid':'' ?>" id="setting-input-1" name="kategoriSayisi" value="<?= isset($data['siteSettings']['kategoriSayisi']) ? $data['siteSettings']['kategoriSayisi'] :''  ?>" min="1">
                                    <?php if (isset($form_err['kategoriSayisi'])): ?>
                                        <div id="setting-input-2" class="invalid-feedback">
                                            <?= isset($form_err['kategoriSayisi']['empty']) ? $form_err['kategoriSayisi']['empty']:$form_err['kategoriSayisi']['equal'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <button type="submit" class="btn app-btn-primary" >Değişiklikleri Kayıt Et</button>
                            </form>
                        </div><!--//app-card-body-->

                    </div><!--//app-card-->
                </div>
            </div>
        </div><!--//container-fluid-->
    </div><!--//app-content-->


</div><!--//app-wrapper-->