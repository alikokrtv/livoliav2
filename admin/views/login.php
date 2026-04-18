<?php
// Login POST işlemi
$loginError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (Auth::login($email, $password)) {
        redirect(ADMIN_URL . '/dashboard');
    } else {
        $loginError = 'E-posta veya şifre hatalı.';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giriş Yap — <?= ADMIN_TITLE ?></title>
    <!-- Metronic Assets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link rel="stylesheet" href="<?= ADMIN_URL ?>/assets/plugins/global/plugins.bundle.css">
    <link rel="stylesheet" href="<?= ADMIN_URL ?>/assets/css/style.bundle.css">
    <style>
        body {
            background-image: url('<?= ADMIN_URL ?>/assets/media/auth/bg4.jpg');
            background-size: cover;
        }

        [data-bs-theme="dark"] body {
            background-image: url('<?= ADMIN_URL ?>/assets/media/auth/bg4-dark.jpg');
        }
    </style>
</head>

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-column-fluid flex-lg-row">
            <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                <div class="d-flex flex-center flex-lg-start flex-column">
                    <a href="<?= BASE_URL ?>" class="mb-7">
                        <h1 class="text-white display-3 fw-bolder" style="letter-spacing: 5px;">LIVOLIA</h1>
                    </a>
                    <h2 class="text-white fw-normal m-0">Premium B2B Home Textiles</h2>
                </div>
            </div>
            <div
                class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                        <form class="form w-100" action="<?= ADMIN_URL ?>/login" method="POST" novalidate="novalidate">
                            <?= csrf_field() ?>
                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-3">Admin Paneli</h1>
                                <div class="text-gray-500 fw-semibold fs-6">Sisteme giriş yapın</div>
                            </div>

                            <?php if (!empty($loginError)): ?>
                                <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                                    <i class="ki-duotone ki-information-5 fs-2hx text-danger me-4"><span
                                            class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-danger">Hata</h4>
                                        <span><?= htmlspecialchars($loginError) ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="fv-row mb-8">
                                <input type="email" placeholder="E-posta" name="email" autocomplete="off"
                                    class="form-control bg-transparent" required
                                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
                            </div>
                            <div class="fv-row mb-3">
                                <input type="password" placeholder="Şifre" name="password" autocomplete="off"
                                    class="form-control bg-transparent" required />
                            </div>
                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <div></div>
                                <a href="#" class="link-primary">Şifremi Unuttum?</a>
                            </div>
                            <div class="d-grid mb-10">
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Giriş Yap</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= ADMIN_URL ?>/assets/plugins/global/plugins.bundle.js"></script>
    <script src="<?= ADMIN_URL ?>/assets/js/scripts.bundle.js"></script>
</body>

</html>