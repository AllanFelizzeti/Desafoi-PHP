//valoda a força da senha
function senhaForca(){
    var senha = document.getElementById('exampleInputPassword1').value;
     var forca = 0;

    if ((senha.length >= 4) && (senha.length <= 7)){
        forca += 10;
    } else if (senha.length > 7){
        forca += 25;
    }

    if ((senha.length >= 5) && (senha.match(/[a-z]+/))){
        forca += 10;
    }

    if ((senha.length >= 6) && (senha.match(/[A-Z]+/))){
        forca += 20;
    }

    if ((senha.length >= 7) && (senha.match(/[!@#$:;/%&*?]+/))){
        forca += 25;
    }

    mostrarForca(forca);
}

function mostrarForca(forca){
    if (forca < 30){
        document.getElementById("impForcaSenha").innerHTML = "<span style='color:#ff0000'>Fraca</span>";
    }else if ((forca >= 30) && (forca < 50)){
        document.getElementById("impForcaSenha").innerHTML = "<span style='color:#FFD700'>Média</span>";
    }else if ((forca >= 50) && (forca < 70)){
        document.getElementById("impForcaSenha").innerHTML = "<span style='color:#7FFF00'>Forte</span>";
    }else if ((forca >= 70) && (forca < 100)){
        document.getElementById("impForcaSenha").innerHTML = "<span style='color:#008000'>Excelente</span>";
    }
}





