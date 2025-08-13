function validarSenha() {
    const senha = document.getElementById("floatingPassword");
    const confirmarSenha = document.getElementById("floatingCPassword");
    const erroSenha = document.getElementById("erroSenha");

    if (senha.value == confirmarSenha.value){
        erroSenha.style.display = "none";
        confirmarSenha.setCustomValidity("");
    }else{
        erroSenha.style.display = "block";
        confirmarSenha.setCustomValidity("A senha e confirmação de senha são diferentes.");
    }
}

function validarDataNascimento(){
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

    if(idade < 18){
        formDtNasc.setCustomValidity("O usuário precisa ter 18 ou mais anos.");
        msgErro.style.display = "block";
    }else{
        formDtNasc.setCustomValidity("");
        msgErro.style.display = "none";
    }
}

function validarTelefone(input) {
    const telefonePattern = /^\d{2} \d{5}-\d{4}$/;
    if (!telefonePattern.test(input.value)) {
        input.setCustomValidity("Formato de telefone inválido, formato correto: 00 00000-0000");
    } else {
        input.setCustomValidity("");
    }
}

function validarCPF_CNPJ(input) {
    const cpfPattern = /(^\d{3}\.\d{3}\.\d{3}\-\d{2}$)|(^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$)/;
    const cnpjPattern =  /^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/;

    if(cpfPattern.test(input.value) || cnpjPattern.test(input.value)){
        input.setCustomValidity("");
        return;
    }

    input.setCustomValidity("Formato inválido, formato correto: 000.000.000-00 ou CNPJ 00.000.000/0000-00");
}
