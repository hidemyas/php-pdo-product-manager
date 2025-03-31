<div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">

            <div class="d-flex justify-content-between align-items-center">
                <h1 class="app-page-title"><?= $data['pageInfo']['title'];  ?></h1>
                <a href="<?= SITE_URL ?>/panel/products" class="btn btn-warning">Ürünlere Dön</a>
            </div>


            <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
                <?php if(isset($data['alert'])): ?>
                    <div class="alert alert-<?= $data['alert']['type'] ?> d-block w-100 m-0">
                        <p><?= $data['alert']['msg'] ?></p>
                    </div>
                <?php else: ?>
                    <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true"> Silinecek Ürünleri Onaylayın </a>
                <?php endif; ?>
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
                                        <th class="cell">Kısa Açıklama</th>
                                        <th class="cell">İndirimli Fiyat</th>
                                        <th class="cell">Normal Fiyat</th>
                                        <th class="cell"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ( count($data['products']) > 0):
                                            foreach ($data['products'] as $product):
                                    ?>
                                    <tr>
                                        <td class="cell">#<?= $product['id'] ?></td>
                                        <td class="cell"><span class="truncate"><?= $product['title'] ?></span></td>
                                        <td class="cell"><?= $product['description'] ?></td>
                                        <td class="cell"><?= $product['salePrice'] ?></td>
                                        <td class="cell"><?= $product['price'] ?></td>
                                        <?php if(!isset($data['alert'])): ?>
                                            <td class="cell d-inline-flex"><a class="btn btn-danger  text-white" href="<?= SITE_URL ?>/panel/deleteProduct/<?= $product['id'] ?>?run=true">Silme İşlemini Onayla</a></td>
                                        <?php endif; ?>
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