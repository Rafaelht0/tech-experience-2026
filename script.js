const form = document.querySelector('#form-inscricao');
const mensagem = document.querySelector('#mensagem');
const contador = document.querySelector('#contador');
const LIMITE = Number(mensagem.getAttribute('maxlength'));

// Contador de caracteres em tempo real
function atualizarContador() {
  const restantes = LIMITE - mensagem.value.length;
  contador.textContent = `Restam ${restantes} caracteres`;
}
mensagem.addEventListener('input', atualizarContador);
atualizarContador();

// Helpers de feedback visual
function mostrarErro(elemento, idErro, texto) {
  elemento.classList.add('is-invalid');
  const erro = document.querySelector(idErro);
  erro.textContent = texto;
  erro.hidden = false;
}

function limparErro(elemento, idErro) {
  elemento.classList.remove('is-invalid');
  const erro = document.querySelector(idErro);
  erro.textContent = '';
  erro.hidden = true;
}

// Validação preventiva no envio
form.addEventListener('submit', (event) => {
  let valido = true;

  const nome = document.querySelector('#nome');
  if (nome.value.trim().length < 3) {
    mostrarErro(nome, '#erro-nome', 'Informe seu nome completo (mínimo 3 caracteres).');
    valido = false;
  } else {
    limparErro(nome, '#erro-nome');
  }

  const email = document.querySelector('#email');
  if (!email.value.trim() || !email.checkValidity()) {
    mostrarErro(email, '#erro-email', 'Informe um e-mail válido.');
    valido = false;
  } else {
    limparErro(email, '#erro-email');
  }

  const experiencia = document.querySelector('#experiencia');
  if (!experiencia.value) {
    mostrarErro(experiencia, '#erro-experiencia', 'Selecione seu nível de experiência.');
    valido = false;
  } else {
    limparErro(experiencia, '#erro-experiencia');
  }

  const grupoTurno = document.querySelector('#grupo-turno');
  if (!form.querySelector('input[name="turno"]:checked')) {
    mostrarErro(grupoTurno, '#erro-turno', 'Escolha um turno de preferência.');
    valido = false;
  } else {
    limparErro(grupoTurno, '#erro-turno');
  }

  // Pelo menos uma oficina selecionada
  const grupoOficinas = document.querySelector('#grupo-oficinas');
  const oficinasMarcadas = form.querySelectorAll('input[name="oficinas[]"]:checked');
  if (oficinasMarcadas.length === 0) {
    mostrarErro(grupoOficinas, '#erro-oficinas', 'Selecione ao menos uma oficina de interesse.');
    valido = false;
  } else {
    limparErro(grupoOficinas, '#erro-oficinas');
  }

  if (!valido) {
    event.preventDefault();
    const primeiroErro = form.querySelector('.is-invalid');
    primeiroErro?.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }
});
