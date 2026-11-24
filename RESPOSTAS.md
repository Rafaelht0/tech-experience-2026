# Parte 1 - Respostas

Estudante: Helton Rafael Ferreira da Silva
Disciplina: Desenvolvimento Web

## Questão 1

a) Quando acesso pelo localhost, o navegador manda uma requisição HTTP para o servidor. O servidor vê que é um arquivo .php e passa ele para o interpretador PHP, que executa o código. No final, só o resultado dessa execução (o HTML gerado) volta como resposta. O código PHP fica no servidor, por isso não aparece no código-fonte. Já abrindo pelo file://, o navegador só lê o arquivo do disco, sem servidor nenhum no meio, e como o navegador não tem interpretador PHP ele mostra o texto puro ou baixa o arquivo.

b) O interpretador é quem executa o script no servidor, usando os dados da requisição ($_GET, $_POST etc.). O que ele entrega é texto, normalmente HTML, que o servidor envia de volta para o navegador exibir.

## Questão 2

a) No GET os dados vão na URL como query string (ex: ?nome=Ana&turno=noite), ficando visíveis na barra de endereço e no histórico. Serve para buscas, filtros e paginação, coisas que só consultam e podem ser salvas nos favoritos. No POST os dados vão no corpo da requisição, então não aparecem na URL. É o certo para cadastrar, alterar dados, fazer login ou mandar dados sensíveis.

b) O POST não criptografa nada, ele só coloca os dados em outro lugar da requisição. Usando http://, quem interceptar a rede consegue ler o corpo do POST normalmente. O que protege de verdade é o HTTPS, que usa TLS para criptografar toda a comunicação.

## Questão 3

a) Normalização é deixar o dado num formato padrão antes de validar, tipo tirar espaços sobrando. Validação é conferir se o dado segue as regras (obrigatório, tamanho, formato, se está na lista permitida) e rejeitar se não seguir. Escape de saída é converter caracteres especiais na hora de mostrar o dado na página, para ele aparecer como texto e não ser lido como código.

b) Normalização: trim() e o operador ??. Validação: filter_var() com FILTER_VALIDATE_EMAIL, mb_strlen() para tamanho e in_array(..., true) para lista permitida. Escape: htmlspecialchars($dado, ENT_QUOTES, 'UTF-8').

O escape evita XSS. Se alguém digitar `<script>alert("XSS")</script>` no nome e o PHP imprimir isso direto, o navegador executa o script, o que poderia roubar cookies ou mudar a página. Com htmlspecialchars, o < vira &lt;, o > vira &gt; e assim por diante, então o texto aparece na tela sem ser executado.

## Questão 4

a) Porque tudo que está no navegador pode ser controlado pelo usuário. O servidor não tem como saber se os dados vieram mesmo do formulário. Sem validar no processar.php, qualquer coisa pode ser gravada, até dados vazios ou códigos maliciosos.

b) Alguns jeitos de passar por cima da validação do cliente:
- desativar o JavaScript do navegador;
- usar o Inspecionar elemento para apagar o required ou mudar o valor de uma opção;
- mandar o POST direto pelo Postman ou cURL, sem nem abrir o formulário.

A validação no cliente serve para a experiência do usuário, avisando o erro na hora. Quem garante a segurança e a integridade dos dados é a validação no servidor, que sempre tem que existir.

## Questão 5

a) O ?? devolve o valor da esquerda se ele existir e não for null, senão usa o da direita. Com `$_POST['nome'] ?? ''`, se o campo não for enviado a variável fica como string vazia, em vez de dar o aviso "Undefined array key".

b) No HTML todos os checkboxes usam o mesmo name com colchetes, `name="oficinas[]"`. Assim o PHP junta os itens marcados num array, por exemplo `['html_css', 'php_backend']`. No backend eu verifico se é array com is_array(), se não está vazio, e depois percorro cada item conferindo com in_array($item, $permitidos, true) se ele está na lista de valores permitidos. O true faz a comparação ser estrita, olhando também o tipo.
