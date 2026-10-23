<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_admin();

/** Seções do painel: título, tabela e colunas exibidas. */
$sections = [
    'bookings' => ['Agendamentos', 'bookings', ['name' => 'Cliente', 'service' => 'Serviço', 'date' => 'Data e hora', 'phone' => 'Telefone', 'status' => 'Status']],
    'services' => ['Serviços e preços', 'services', ['name' => 'Serviço', 'category' => 'Categoria', 'price' => 'Preço', 'featured' => 'Destaque']],
    'team'     => ['Equipe', 'team', ['name' => 'Nome', 'role' => 'Especialidade']],
    'gallery'  => ['Galeria (antes/depois)', 'gallery', ['title' => 'Título']],
    'reviews'  => ['Depoimentos', 'reviews', ['author' => 'Cliente', 'text' => 'Texto', 'stars' => 'Estrelas']],
    'settings' => ['Dados do salão', null, []],
];
$page = $_GET['p'] ?? 'bookings';
if (!isset($sections[$page])) $page = 'bookings';
[$title, $table, $cols] = $sections[$page];
$rows = $table ? get_list($table) : [];

$statusLabel = ['pending' => 'Pendente', 'confirmed' => 'Confirmado', 'cancelled' => 'Cancelado'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <meta name="csrf" content="<?= e(csrf_token()) ?>">
  <title><?= e($title) ?> | Admin BeeBeauty</title>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
<aside class="side">
  <h1>BeeBeauty</h1>
  <nav>
    <?php foreach ($sections as $key => $s): ?>
      <a href="?p=<?= e($key) ?>" class="<?= $key === $page ? 'on' : '' ?>"><?= e($s[0]) ?></a>
    <?php endforeach; ?>
  </nav>
  <a href="../index.php" target="_blank" class="side-link">Ver site</a>
  <a href="logout.php" class="side-link">Sair</a>
</aside>

<main class="content">
  <header class="top">
    <h2><?= e($title) ?></h2>
    <?php if ($table && $page !== 'bookings'): ?><button class="btn" data-demo>Adicionar</button><?php endif; ?>
  </header>

  <?php if (DEMO_MODE): ?>
    <p class="notice">Modo demonstração: os dados abaixo são de exemplo e os botões ainda não gravam no banco.</p>
  <?php endif; ?>

  <?php if ($page === 'settings'): ?>
    <form class="panel form-admin">
      <label>Nome do salão<input value="<?= e(SITE_NAME) ?>"></label>
      <label>Endereço<input value="<?= e(SITE_ADDRESS) ?>"></label>
      <label>Horário de funcionamento<input value="<?= e(SITE_HOURS) ?>"></label>
      <label>Telefone<input value="<?= e(SITE_PHONE) ?>"></label>
      <label>E-mail<input value="<?= e(SITE_EMAIL) ?>"></label>
      <button type="button" class="btn" data-demo>Salvar alterações</button>
    </form>
  <?php elseif (!$rows): ?>
    <p class="panel">Nada cadastrado ainda.</p>
  <?php else: ?>
    <div class="panel table-wrap">
      <table>
        <thead><tr><?php foreach ($cols as $label): ?><th><?= e($label) ?></th><?php endforeach; ?><th>Ações</th></tr></thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <?php foreach ($cols as $key => $label): $v = $r[$key] ?? ''; ?>
              <td>
                <?php if ($key === 'status'): ?><span class="tag tag-<?= e($v) ?>"><?= e($statusLabel[$v] ?? $v) ?></span>
                <?php elseif ($key === 'featured'): ?><?= $v ? 'Sim' : 'Não' ?>
                <?php elseif ($key === 'stars'): ?><?= str_repeat('★', (int)$v) ?>
                <?php else: ?><?= e($v) ?><?php endif; ?>
              </td>
            <?php endforeach; ?>
            <td class="actions">
              <?php if ($page === 'bookings'): ?>
                <button data-demo>Confirmar</button><button data-demo>Cancelar</button>
              <?php else: ?>
                <button data-demo>Editar</button><button data-demo>Excluir</button>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</main>
<div class="toast" role="status" aria-live="polite"></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="../assets/js/admin.js"></script>
</body>
</html>
