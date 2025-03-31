<!--<pre>-->
    <?php
//    print_r($data['filter']);
    $price_filter   =   $data['filter']['price'];
    /*
     * Varsayılan Default Değerler
     * */
    $min    =   $price_filter['min'];
    $min_msg    =   "";

    $max    =   $price_filter['max'];
    $max_msg    =   "";

    /*
     * Kullanıcı fiiltre için gönderdiği değerler
     * */
    if (isset($data['filtered'])){
        $min    =   $data['filtered']['price']['min'];
        $min_msg    =   $data['filtered']['price']['min_msg'];

        $max    =   $data['filtered']['price']['max'];
        $max_msg    =   $data['filtered']['price']['max_msg'];
    }
    ?>
<!--</pre>-->
<div class="col-md-4">
    <h2 class="display-6"><i class="bi bi-funnel"></i> Filtrele</h2>
    <form action="<?= SITE_URL ?>/urun/filtrele" method="post" class="filter-form">

        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        Fiyata Göre Filtrele
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="number" class="form-control <?=  strlen($min_msg)>0 ? 'is-invalid':'' ?>"  aria-describedby="min-feedback" id="minPrice" name="filter[price][minPrice]" placeholder="En Az" value="<?= $min ?>" min="<?= $price_filter['min'] ?>" max="<?= $price_filter['max'] ?>">
                                    <label for="minPrice">En Az</label>
                                    <?php if (strlen($min_msg)>0){
                                        echo '<div class="invalid-feedback d-block" id="min-feedback">'.$min_msg.'</div>';
                                    } ?>

                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="number" class="form-control <?=  strlen($max_msg)>0 ? 'is-invalid':'' ?>" id="maxPrice" name="filter[price][maxPrice]" placeholder="En Az" value="<?= $max ?>"  min="<?= $price_filter['min'] ?>" max="<?= $price_filter['max'] ?>">
                                    <label for="maxPrice">En Fazla</label>
                                    <?php if (strlen($max_msg)>0){
                                        echo '<div class="invalid-feedback d-block">'.$max_msg.'</div>';
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                        <i class="bi bi-bookmarks-fill"></i> Kategoriye Göre
                    </button>
                </h2>
                <?php
                if (isset($data['filter']['cats'])):
                    $cats   =   $data['filter']['cats'];
                    if (count($cats)>0):
                        $filtered_cats  =   isset($data['filtered']['cats']) ? $data['filtered']['cats'] : array();
                ?>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse <?= count($filtered_cats)>0 ? 'show':'collapse' ?>">
                    <div class="accordion-body">
                        <ul class="list-group">
                            <?php foreach ($cats as $cat):?>
                            <li class="list-group-item">
                                <input <?= isset($filtered_cats[$cat['id']]) ? 'checked':'' ?> class="form-check-input me-1" type="checkbox" name="filter[cats][]" value="<?= $cat['id'] ?>" id="<?= $cat['id'] ?>Checkbox">
                                <label class="form-check-label" for="<?= $cat['id'] ?>Checkbox"><?= $cat['title'] ?></label>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; endif; ?>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                        <i class="bi bi-search"></i> Ürün Arama
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseThree" class="accordion-collapse <?= isset($data['filtered']['search']) ? 'show':'collapse' ?>">
                    <div class="accordion-body">
                        <div class="form-floating mb-3">
                            <input type="search" class="form-control" id="search" placeholder="bir şeyler yazın" name="filter[search]" value="<?= isset($data['filtered']['search']) ? $data['filtered']['search']:'' ?>">
                            <label for="search">Lütfen ürün adı giriniz</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="page" id="pageInput" value="<?= isset($_REQUEST['page']) ?  $_REQUEST['page'] : 1  ?>">
        <button type="submit" class="btn btn-outline-primary btn-block my-2 btn-sm w-100">Ürünleri Getir</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".pagination-link").forEach(link => {
            link.addEventListener("click", function(event) {
                event.preventDefault(); // Sayfanın yeniden yüklenmesini engelle
                const url = new URL(this.href);
                const page = url.searchParams.get("page"); // URL'den ?page= değerini al
                document.getElementById("pageInput").value = page; // Input değerini güncelle
                document.querySelector(".filter-form").submit(); // Formu gönder
            });
        });
    });
</script>