
function validarSenha() {
  const senha = document.getElementById("floatingPassword");
  const confirmarSenha = document.getElementById("floatingCPassword");
  const erroSenha = document.getElementById("erroSenha");
  const erroSenhaForca = document.getElementById("erroSenhaForca");


  const senhaPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
  
  if (senha.value && !senhaPattern.test(senha.value)) {
    if (erroSenhaForca) {
      erroSenhaForca.style.display = "block";
      senha.setCustomValidity("A senha deve conter no mínimo 8 caracteres, uma letra maiúscula, uma minúscula, um número e um caractere especial");
    }
  } else {
    if (erroSenhaForca) {
      erroSenhaForca.style.display = "none";
      senha.setCustomValidity("");
    }
  }


  if (senha.value == confirmarSenha.value) {
    erroSenha.style.display = "none";
    confirmarSenha.setCustomValidity("");
  } else {
    erroSenha.style.display = "block";
    confirmarSenha.setCustomValidity(
      "A senha e confirmação de senha são diferentes."
    );
  }
}

function validarTelefone(input) {
  const telefone = input.value.replace(/\D/g, '');
  
  if (telefone.length === 10 || telefone.length === 11) {
    input.setCustomValidity("");
  } else {
    input.setCustomValidity("Telefone deve ter 10 ou 11 dígitos");
  }
}

function validarDataNascimento() {
  const formDtNasc = document.querySelector("#floatingInputDtNasc");
  const dataNasc = new Date(formDtNasc.value);
  const dataAtual = new Date();
  const msgErro = document.querySelector("#erroDtNasc");

  let idade = dataAtual.getFullYear() - dataNasc.getFullYear();
  const mes = dataAtual.getMonth() - dataNasc.getMonth();
  const dia = dataAtual.getDate() - dataNasc.getDate();

  if (mes < 0 || (mes === 0 && dia < 0)) {
    idade--;
  }

  if (idade < 18) {
    formDtNasc.setCustomValidity("O usuário precisa ter 18 ou mais anos.");
    msgErro.style.display = "block";
  } else {
    formDtNasc.setCustomValidity("");
    msgErro.style.display = "none";
  }
}

function validarCPF_CNPJ(input) {
  const valor = input.value.replace(/\D/g, '');
  
  if (valor.length === 11) {
    if (validarCPF(valor)) {
      input.setCustomValidity("");
    } else {
      input.setCustomValidity("CPF inválido");
    }
  } else if (valor.length === 14) {
    if (validarCNPJ(valor)) {
      input.setCustomValidity("");
    } else {
      input.setCustomValidity("CNPJ inválido");
    }
  } else {
    input.setCustomValidity("CPF deve ter 11 dígitos ou CNPJ deve ter 14 dígitos");
  }
}

function validarCPF(cpf) {
  if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;
  
  let soma = 0;
  let resto;
  
  for (let i = 1; i <= 9; i++) {
    soma += parseInt(cpf.substring(i-1, i)) * (11 - i);
  }
  
  resto = (soma * 10) % 11;
  if (resto === 10 || resto === 11) resto = 0;
  if (resto !== parseInt(cpf.substring(9, 10))) return false;
  
  soma = 0;
  for (let i = 1; i <= 10; i++) {
    soma += parseInt(cpf.substring(i-1, i)) * (12 - i);
  }
  
  resto = (soma * 10) % 11;
  if (resto === 10 || resto === 11) resto = 0;
  if (resto !== parseInt(cpf.substring(10, 11))) return false;
  
  return true;
}

function validarCNPJ(cnpj) {
  if (cnpj.length !== 14) return false;
  
  const pesos1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
  const pesos2 = [6, 7, 8, 9, 2, 3, 4, 5, 6, 7, 8, 9];
  
  let soma = 0;
  for (let i = 0; i < 12; i++) {
    soma += parseInt(cnpj.charAt(i)) * pesos1[i];
  }
  
  let resto = soma % 11;
  let dv1 = resto < 2 ? 0 : 11 - resto;
  
  if (dv1 !== parseInt(cnpj.charAt(12))) return false;
  
  soma = 0;
  for (let i = 0; i < 13; i++) {
    soma += parseInt(cnpj.charAt(i)) * pesos2[i];
  }
  
  resto = soma % 11;
  let dv2 = resto < 2 ? 0 : 11 - resto;
  
  return dv2 === parseInt(cnpj.charAt(13));
}

function validarEmail(input) {
  const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (!emailPattern.test(input.value)) {
    input.setCustomValidity("Por favor, insira um email válido");
  } else {
    input.setCustomValidity("");
  }
}

function validarCampoObrigatorio(input, nomeCampo) {
  if (!input.value.trim()) {
    input.setCustomValidity(`O campo ${nomeCampo} é obrigatório`);
  } else {
    input.setCustomValidity("");
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const emailInput = document.getElementById("floatingInputEmail");
  if (emailInput) {
    emailInput.addEventListener('blur', function() {
      validarEmail(this);
    });
    emailInput.addEventListener('input', function() {
      validarCampoObrigatorio(this, 'Email');
    });
  }

  const camposObrigatorios = [
    { id: "floatingInputNome", nome: "Nome Completo" },
    { id: "floatingInputEndereco", nome: "Endereço" },
    { id: "floatingInputCidade", nome: "Cidade" },
    { id: "floatingInputTel", nome: "Telefone" },
    { id: "floatingInputCPF", nome: "CPF/CNPJ" }
  ];

  camposObrigatorios.forEach(campo => {
    const input = document.getElementById(campo.id);
    if (input) {
      input.addEventListener('blur', function() {
        validarCampoObrigatorio(this, campo.nome);
      });
    }
  });

  const telefoneInput = document.getElementById("floatingInputTel");
  if (telefoneInput) {
    telefoneInput.addEventListener('blur', function() {
      validarTelefone(this);
    });
  }

  const cpfInput = document.getElementById("floatingInputCPF");
  if (cpfInput) {
    cpfInput.addEventListener('blur', function() {
      validarCPF_CNPJ(this);
    });
  }
});
