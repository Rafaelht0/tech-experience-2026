# 🎓 Tech Experience 2026

Portal de inscrição em oficinas do evento Tech Experience 2026, feito com HTML, CSS, JavaScript e PHP, com validação no servidor e proteção contra XSS.

Projeto desenvolvido como atividade avaliativa de Desenvolvimento Web (Fundamentos de PHP e Integração Web).

## Funcionalidades

- **Formulário de inscrição** com nome, e-mail, nível de experiência, turno, oficinas de interesse e mensagem
- **Contador de caracteres** em tempo real na mensagem
- **Validação no cliente** com feedback visual e bloqueio do envio sem oficina selecionada
- **Validação no servidor** com whitelists para nível, turno e oficinas
- **Proteção contra XSS**: toda saída passa por `htmlspecialchars`
- **Bloqueio de acesso direto**: o `processar.php` responde **405** para requisições que não são POST
- **Layout responsivo** em tons claros

## Tecnologias

| Arquivo | Tecnologia | Responsabilidade |
|---|---|---|
| `index.html` | HTML5 | Estrutura semântica do formulário e acessibilidade (`label for`/`id`, `fieldset`/`legend`) |
| `style.css` | CSS3 | Design claro, Flexbox/Grid, foco visível, estilos `.is-invalid` e `.error-message` |
| `script.js` | JavaScript | Contador de caracteres e validação preventiva no `submit` |
| `processar.php` | PHP 8+ | Verificação do método, normalização (`trim`, `??`), validação e renderização segura |

## Como executar

Requisito: PHP 8 ou superior.

```bash
git clone https://github.com/Rafaelht0/tech-experience-2026.git
cd tech-experience-2026
php -S localhost:8000
```

Depois abra `http://localhost:8000/index.html` no navegador.

## Testes sugeridos

- **Envio válido:** preencha tudo corretamente e confira o cartão de confirmação.
- **XSS:** use `<script>alert("XSS")</script>` no nome; o texto aparece literal, sem executar.
- **Status 405:** acesse `http://localhost:8000/processar.php` direto pela barra de endereços.
- **DevTools Network:** confira o método POST, o status 200 e o payload enviado.

## Parte teórica

As respostas das questões teóricas da atividade estão em [`RESPOSTAS.md`](RESPOSTAS.md).

## Autor

**Helton Rafael Ferreira da Silva** · [@Rafaelht0](https://github.com/Rafaelht0)
