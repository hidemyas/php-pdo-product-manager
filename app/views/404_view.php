<style>
    #404 {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }
    .error-container {
        text-align: center;
        max-width: 500px;
        margin: 0 auto;
    }
    .error-code {
        font-size: 100px;
        font-weight: bold;
        color: darkturquoise;
    }
    .error-text {
        font-size: 24px;
        margin-bottom: 20px;
    }
</style>
<div id="404">
    <div class="error-container">
        <div class="error-code">404</div>
        <div class="error-text">Üzgünüz, aradığınız sayfa bulunamadı!</div>
        <a href="<?= SITE_URL ?>" class="btn btn-primary">Ana Sayfaya Dön</a>
    </div>
</div>