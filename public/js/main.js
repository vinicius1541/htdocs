$(document).ready(function () {
  $("#inputCEP").blur(function () { //ativa o script quando o campo CEP perde o foco
    var cep = $(this).val().replace(/\D/g, ''); //A expressão \D valida apenas números. O que não for numeral é descartado.
    if (cep != "") {
      var validacep = /^[0-9]{8}$/; //expressão regular para certificar que o CEP tem exatamente 8 dígitos numéricos de 0 a 9.
      console.debug(cep);
      if (validacep.test(cep)) {
        $("#inputAddress").val("...");

        $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

          if (!("erro" in dados)) {
            //Atualiza os campos com os valores da consulta.
            if (!dados.logradouro) {
              var logradouro = dados.bairro + ", " + dados.localidade + "/" + dados.uf;
              $("#inputAddress").val(logradouro);
            }
            else {
              var logradouro = dados.logradouro + " - " + dados.bairro + ", " + dados.localidade + "/" + dados.uf;
              $("#inputAddress").val(logradouro);
            }

          } //end if.
          else {
            alert("CEP não encontrado.");
            $("#inputCEP").val("");
            $("#inputAddress").val("");
          }
        });
      } else {
        alert("CEP não encontrado.");
        $("#inputCEP").val("");
        $("#inputAddress").val("");
      }
    }
  })
});

$(document).ready(function () {
  $("#inputEmail").blur(function () {
    var mail = $(this).val();
    if (mail != ""){
      validacaoEmail(this);      
    }
    else{
    }
  });
});

function validacaoEmail(field) {
  usuario = field.value.substring(0, field.value.indexOf("@"));
  dominio = field.value.substring(field.value.indexOf("@") + 1, field.value.length);
  if ((usuario.length >= 1) &&
    (dominio.length >= 3) &&
    (usuario.search("@") == -1) &&
    (dominio.search("@") == -1) &&
    (usuario.search(" ") == -1) &&
    (dominio.search(" ") == -1) &&
    (dominio.search(".") != -1) &&
    (dominio.indexOf(".") >= 1) &&
    (dominio.lastIndexOf(".") < dominio.length - 1)) {
  }
  else {
    document.getElementById("inputEmail").innerHTML = "<font color='red'>Email inválido </font>";
    $("#inputEmail").val("");
    alert("E-mail invalido");
  }
}
