<?php
require_once __DIR__ . '/../includes/bootstrap.php';

if (!empty($_SESSION['is_admin'])) { header('Location: index.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atraso simples contra tentativas em massa
    $_SESSION['tries'] = ($_SESSION['tries'] ?? 0) + 1;
    if ($_SESSION['tries'] > 5) {
        $error = 'Muitas tentativas. Feche o navegador e tente de novo.';
    } elseif (!csrf_check($_POST['csrf'] ?? null)) {
        $error = 'Sessão expirada. Recarregue a página.';
    } elseif (($_POST['user'] ?? '') === ADMIN_USER && password_verify($_POST['pass'] ?? '', ADMIN_HASH)) {
        session_regenerate_id(true);
        $_SESSION['is_admin'] = true;
        $_SESSION['tries'] = 0;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Usuário ou senha incorretos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <title>Entrar | Admin BeeBeauty</title>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="login">
  <form method="post" class="login-box">
    <h1>BeeBeauty</h1>
    <p>Área do administrador</p>
    <?php if ($error): ?><p class="alert"><?= e($error) ?></p><?php endif; ?>
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <label>Usuário<input type="text" name="user" required autofocus></label>
    <label>Senha<input type="password" name="pass" required></label>
    <button class="btn" type="submit">Entrar</button>
    <?php if (DEMO_MODE): ?><small>Demo: admin / admin123</small><?php endif; ?>
  </form>
</body>
</html>
