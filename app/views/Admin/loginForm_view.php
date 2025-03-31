<!DOCTYPE html>
<html lang="tr-TR">
<head>
    <title>Gririş - Yönetim Paneli</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Admin Panel">
    <meta name="author" content="HidemYas">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- FontAwesome JS-->
    <script defer src="/public/assets/plugins/fontawesome/js/all.min.js"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="/public/assets/css/portal.css">

</head>

<body class="app app-login p-0">
<div class="row g-0 app-auth-wrapper">
    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
        <div class="d-flex flex-column align-content-end">
            <div class="app-auth-body mx-auto">
                <div class="app-auth-branding mb-4"><a class="app-logo" href="i<?= SITE_URL ?>"><img class="logo-icon me-2" src="/public/assets/images/app-logo.svg" alt="logo"></a></div>
                <h2 class="auth-heading text-center mb-5">Admin Panel Giriş</h2>
                <?php if (isset($data['status'])){
                    ?>
                <div class="alert alert-danger">
                    <?= $data['status'] ?>
                </div>
                <?php
                } ?>
                <div class="auth-form-container text-start">
                    <form class="auth-form login-form" method="post" action="<?= SITE_URL ?>/admin/runLogin">
                        <div class="email mb-3">
                            <label class="sr-only" for="signin-email">Email</label>
                            <input id="signin-email" name="signin-email" type="email" class="form-control signin-email" placeholder="Email adresi" required="required">
                        </div><!--//form-group-->
                        <div class="password mb-3">
                            <label class="sr-only" for="signin-password">Password</label>
                            <input id="signin-password" name="signin-password" type="password" class="form-control signin-password" placeholder="Şifre" required="required">
                            <div class="extra mt-3 row justify-content-between">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="RememberPassword">
                                        <label class="form-check-label" for="RememberPassword">
                                            Beni Hatırla
                                        </label>
                                    </div>
                                </div><!--//col-6-->

                            </div><!--//extra-->
                        </div><!--//form-group-->
                        <div class="text-center">
                            <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Giriş Yap</button>
                        </div>
                    </form>

                </div><!--//auth-form-container-->

            </div><!--//auth-body-->

            <footer class="app-auth-footer">
                <div class="container text-center py-3">
                    <small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart" style="color: #fb866a;"></i> by <a class="app-link" href="http://www.hidemyas.org" target="_blank">HidemYas</a> for developers</small>

                </div>
            </footer><!--//app-auth-footer-->
        </div><!--//flex-column-->
    </div><!--//auth-main-col-->
    <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
        <div class="auth-background-holder">
        </div>
        <div class="auth-background-mask"></div>
        <div class="auth-background-overlay p-3 p-lg-5">
            <div class="d-flex flex-column align-content-end h-100">
                <div class="h-100"></div>
                <div class="overlay-content p-3 p-lg-4 rounded">
                    <h5 class="mb-3 overlay-title">Gelişmiş Admin Panel Yönetimi</h5>
                    <div>Ürün Yönetimine hızlıca başla ! </div>
                </div>
            </div>
        </div><!--//auth-background-overlay-->
    </div><!--//auth-background-col-->

</div><!--//row-->


</body>
</html>

