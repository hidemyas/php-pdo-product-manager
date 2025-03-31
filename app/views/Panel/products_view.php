<div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">

            <div class="row g-3 mb-4 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="app-page-title mb-0"><?= $data['pageInfo']['title'] ?></h1>
                </div>
                <div class="col-auto">
                    <div class="page-utilities">
                        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                            <div class="col-auto">
                                <form class="table-search-form row gx-1 align-items-center" method="get" action="<?= SITE_URL ?>/panel/products">
                                    <div class="col-auto">
                                        <input type="text" id="search-orders" name="search" class="form-control search-orders" value="<?= isset($_GET['search']) ? $_GET['search']:'' ?>" placeholder="Ürünlerde aramak için bir şeyler yazın...">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn app-btn-secondary">Ara</button>
                                        <a href="<?= SITE_URL ?>/panel/addProduct" type="submit" class="btn app-btn-primary">+ Yeni Ürün Ekle</a>
                                    </div>
                                </form>

                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//table-utilities-->
                </div><!--//col-auto-->
            </div><!--//row-->


            <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
                <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true"><?= isset($_GET['search']) ? 'Arağınız Ürünler':'Bütün Ürünler' ?></a>
              </nav>


            <div class="tab-content" id="orders-table-tab-content">
                <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                    <div class="app-card app-card-orders-table shadow-sm mb-5">
                        <div class="app-card-body">
                            <div class="table-responsive">
                                <table class="table app-table-hover mb-0 text-left">
                                    <thead>
                                    <tr>
                                        <th class="cell">id</th>
                                        <th class="cell">Ürün İsmi</th>
                                        <th class="cell">Kategori</th>
                                        <th class="cell">Kısa Açıklama</th>
                                        <th class="cell">İndirimli Fiyat</th>
                                        <th class="cell">Normal Fiyat</th>
                                        <th class="cell">İşlem</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ( count($data['products']) > 0):

                                            foreach ($data['products'] as $product):
                                    ?>
                                    <tr>
                                        <td class="cell">#<?= $product['id'] ?></td>
                                        <td class="cell"><span class="truncate"><?= $product['title'] ?></span></td>
                                        <td class="cell"><?= $product['cat']['title'] ?></td>
                                        <td class="cell"><?= $product['description'] ?></td>
                                        <td class="cell"><?= $product['salePrice'] ?></td>
                                        <td class="cell"><?= $product['price'] ?></td>
                                        <td class="cell">
                                            <div class="d-inline-flex">
                                                <a class="btn-sm app-btn-info" target="_blank" href="<?= $product['url'] ?>">İncele</a>
                                                <a class="btn-sm app-btn-secondary" href="/panel/editProduct/<?= $product['slug'] ?>">Düzenle</a>
                                                <a class="btn btn-danger btn-sm text-white" href="/panel/deleteProduct/<?= $product['id'] ?>">Sil</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php   endforeach;
                                        else:
                                    ?>
                                    <tr class="cell">
                                        <td class="alert alert-warning" colspan="7">
                                            Listelenecek Ürün Bulunamadı
                                        </td>
                                    </tr>
                                    <?php endif; ?>

                                    </tbody>
                                </table>
                            </div><!--//table-responsive-->

                        </div><!--//app-card-body-->
                    </div><!--//app-card-->
                    <style>
                        .app-pagination .pagination .page-link.active{
                            color: #fff!important;
                        }
                        .pagination{
                            justify-content: center;
                        }
                    </style>
                    <nav class="app-pagination">
                        <?= isset($data['pagination']) ? $data['pagination'] : '' ?>
                    </nav><!--//app-pagination-->

                </div><!--//tab-pane-->


            </div><!--//tab-content-->



        </div><!--//container-fluid-->
    </div><!--//app-content-->



</div><!--//app-wrapper-->