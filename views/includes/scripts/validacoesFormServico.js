//datas mínima é o dia de amanhã os elementos possuem a class data_input e a mensagem de erro tem o id erroDataMinima
//e os input inválidos devem ser marcaos com a classe isInvalid
function validarData(){
    const datas = document.querySelectorAll(".data_input");
    const dataAtual = new Date();
    dataAtual.setHours(0, 0, 0, 0);

    datas.forEach(data => {
        const dataServico = new Date(data.value);
        dataServico.setHours(0, 0, 0, 0);
        possuiErro = false;
        let msgError = "";

        if(dataServico < dataAtual){
            possuiErro = true;
        }

        if(possuiErro){
            msgError = "A data miníma deve ser o dia de amanhã.";
        }

        possuiErro = false;
        for(data2 of datas){
            const dataServico2 = new Date(data2.value);
            dataServico2.setHours(0, 0, 0, 0);

            if(dataServico.getTime() === dataServico2.getTime() && data !== data2){
                possuiErro = true;
                break;   
            }
        }

        if(possuiErro){
            if(msgError){
                msgError += "e o mesmo serviço não pode ser agendado para duas datas iguais.";
            }else{
                msgError = "Não é permitido agendar dois serviços para a mesma data.";
            }
        }

        data.setCustomValidity(msgError);
    });
}