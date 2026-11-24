<?php
declare(strict_types=1);

// 1. Verificação do método HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><title>405 - Método não permitido</title></head>';
    echo '<body><h1>405 - Method Not Allowed</h1><p>Este endereço aceita apenas envios via POST pelo formulário.</p>';
    echo '<p><a href="index.html">Ir para o formulário</a></p></body></html>';
    exit;
}

/** Escape de saída para HTML (proteção contra XSS). */
function e(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

// Whitelists
$niveisPermitidos   = ['iniciante' => 'Iniciante', 'intermediario' => 'Intermediário', 'avancado' => 'Avançado'];
$turnosPermitidos   = ['manha' => 'Manhã', 'noite' => 'Noite'];
$oficinasPermitidas = ['html_css' => 'HTML & CSS', 'js_dom' => 'JavaScript & DOM', 'php_backend' => 'PHP Backend'];

// 2. Leitura e normalização
$nome        = is_string($_POST['nome'] ?? null) ? trim($_POST['nome']) : '';
$email       = is_string($_POST['email'] ?? null) ? trim($_POST['email']) : '';
$experiencia = is_string($_POST['experiencia'] ?? null) ? trim($_POST['experiencia']) : '';
$turno       = is_string($_POST['turno'] ?? null) ? trim($_POST['turno']) : '';
$mensagem    = is_string($_POST['mensagem'] ?? null) ? trim($_POST['mensagem']) : '';
$oficinas    = $_POST['oficinas'] ?? [];

// 3. Validação
$erros = [];

if (mb_strlen($nome) < 3) {
    $erros[] = 'O nome deve ter pelo menos 3 caracteres.';
}

if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $erros[] = 'Informe um e-mail com formato válido.';
}

if ($experiencia === '') {
    $erros[] = 'O nível de experiência é obrigatório.';
} elseif (!in_array($experiencia, array_keys($niveisPermitidos), true)) {
    $erros[] = 'Nível de experiência inválido.';
}

if ($turno === '') {
    $erros[] = 'O turno de preferência é obrigatório.';
} elseif (!in_array($turno, array_keys($turnosPermitidos), true)) {
    $erros[] = 'Turno de preferência inválido.';
}

if (!is_array($oficinas)) {
    $erros[] = 'Formato inválido para as oficinas.';
    $oficinas = [];
} elseif (count($oficinas) === 0) {
    $erros[] = 'Selecione ao menos uma oficina de interesse.';
} else {
    foreach ($oficinas as $oficina) {
        if (!is_string($oficina) || !in_array($oficina, array_keys($oficinasPermitidas), true)) {
            $erros[] = 'Uma ou mais oficinas selecionadas são inválidas.';
            break;
        }
    }
    $oficinas = array_values(array_unique($oficinas));
}

if (mb_strlen($mensagem) > 200) {
    $erros[] = 'A mensagem deve ter no máximo 200 caracteres.';
}

// 4. Renderização segura
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tech Experience 2026 | <?= $erros ? 'Corrija sua inscrição' : 'Inscrição confirmada' ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="site-header">
    <h1>Tech Experience 2026</h1>
    <p>Inscrição nas oficinas técnicas do evento</p>
  </header>

  <main class="container">
    <section class="card">
<?php if ($erros): ?>
      <h2>Não foi possível concluir a inscrição</h2>
      <div class="alerta-erro" role="alert">
        <strong>Corrija os itens abaixo:</strong>
        <ul>
<?php foreach ($erros as $erro): ?>
          <li><?= e($erro) ?></li>
<?php endforeach; ?>
        </ul>
      </div>
      <p><a class="btn" href="index.html" style="margin-top:1.5rem">Voltar ao formulário</a></p>
<?php else: ?>
      <h2 class="titulo-sucesso">Inscrição confirmada!</h2>
      <p>Obrigado, <strong><?= e($nome) ?></strong>. Confira os dados cadastrados:</p>
      <dl class="dados">
        <dt>Nome</dt>
        <dd><?= e($nome) ?></dd>
        <dt>E-mail</dt>
        <dd><?= e($email) ?></dd>
        <dt>Experiência</dt>
        <dd><?= e($niveisPermitidos[$experiencia]) ?></dd>
        <dt>Turno</dt>
        <dd><?= e($turnosPermitidos[$turno]) ?></dd>
        <dt>Oficinas</dt>
        <dd><?= e(implode(', ', array_map(fn(string $o): string => $oficinasPermitidas[$o], $oficinas))) ?></dd>
        <dt>Mensagem</dt>
        <dd><?= $mensagem !== '' ? nl2br(e($mensagem)) : '<em>Não informada</em>' ?></dd>
      </dl>
      <a class="btn" href="index.html">Fazer nova inscrição</a>
<?php endif; ?>
    </section>
  </main>

  <footer class="site-footer">
    <p>Tech Experience 2026 · Desenvolvimento Web</p>
  </footer>
</body>
</html>
