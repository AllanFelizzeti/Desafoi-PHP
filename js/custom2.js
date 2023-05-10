const tbody = document.querySelector(".listar-usuarios");
const cadForm = document.getElementById("cad-usuario-form");
const editForm = document.getElementById("edit-usuario-form");
const msgAlertaErroCad = document.getElementById("msgAlertaErroCad");
const msgAlertaErroEdit = document.getElementById("msgAlertaErroEdit");
const msgAlerta = document.getElementById("msgAlerta");
const cadModal = new bootstrap.Modal(document.getElementById("cadUsuarioModal"));
const editModal = new bootstrap.Modal(document.getElementById("editUsuarioModal"));

const listarUsuarios = async (pagina) => {
    const dados = await fetch("./validalist.php?pagina=" + pagina);
    const resposta = await dados.text();
    tbody.innerHTML = resposta;
}

listarUsuarios(1);

async function editUsuarioDados(id) {
    msgAlertaErroEdit.innerHTML = "";

    const dados = await fetch('visualizar_edit.php?id=' + id);
    const resposta = await dados.json();
    //console.log(resposta);

    if (resposta['erro']) {
        //console.log("Aqui");
        msgAlerta.innerHTML = resposta['msg'];
    } else {
        editModal.show();
        document.getElementById("editid").value = resposta['dados'].id;
        document.getElementById("editnome").value = resposta['dados'].nome;
        document.getElementById("editcelular").value = resposta['dados'].celular;
        document.getElementById("editcpf").value = resposta['dados'].cpf;
        document.getElementById("editemail").value = resposta['dados'].email;
        document.getElementById("editbrapa").value = resposta['dados'].brapa;
        document.getElementById("editpretencao_salario").value = resposta['dados'].pretencao_salario;
        document.getElementById("editsexo").value = resposta['dados'].sexo;
        document.getElementById("editdata_nascimento").value = resposta['dados'].data_nascimento;
        document.getElementById("editestado_civil").value = resposta['dados'].estado_civil;
        document.getElementById("editescolaridade").value = resposta['dados'].escolaridade; 
        document.getElementById("editempresa").value = resposta['dados'].empresa;
        document.getElementById("editcargo").value = resposta['dados'].cargo;
        document.getElementById("editcurso").value = resposta['dados'].curso;
        document.getElementById("editperiodo_entrada").value = resposta['dados'].periodo_entrada;
        document.getElementById("editperiodo_saida").value = resposta['dados'].periodo_saida;
    }
}

editForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    document.getElementById("edit-usuario-btn").value = "Salvando...";

    const dadosForm = new FormData(editForm);
    //console.log(dadosForm);
    /*for (var dadosFormEdit of dadosForm.entries()){
        console.log(dadosFormEdit[0] + " - " + dadosFormEdit[1]);
    }*/

    const dados = await fetch("editar.php", {
        method: "POST",
        body: dadosForm
    });

    const resposta = await dados.json();
    //console.log(resposta);

    if (resposta['erro']) {
        msgAlertaErroEdit.innerHTML = resposta['msg'];
    } else {
        msgAlertaErroEdit.innerHTML = resposta['msg'];
        editForm.reset();
        editModal.hide();
        listarUsuarios(1);
    }

    document.getElementById("edit-usuario-btn").value = "Salvar";
});

async function apagarUsuarioDados(id) {
    console.log("acessou" + id);

    var confirmar = confirm("Tem certeza que deseja excluir o registro selecionado?");

    if(confirmar == true){
        const dados = await fetch('apagar.php?id=' + id);

        const resposta = await dados.json();
        if (resposta['erro']) {
            msgAlerta.innerHTML = resposta['msg'];
        } else {
            msgAlerta.innerHTML = resposta['msg'];
            listarUsuarios(1);
        }
    }    

} 