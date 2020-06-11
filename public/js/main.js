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
            var erroCep = document.getElementById('erroCEP');
            erroCep.hidden=true;
          } //end if.
          else {
            var erro = "<div id='erroCEP' style='padding-top: 15px;'><div class='alert alert-danger'><p>CEP não encontrado.</p></div></div>";
            $("#card_body").before(erro);
            //alert("CEP não encontrado.");
            $("#inputCEP").val("");
            $("#inputAddress").val("");
            $(document).ready(function(){
              $("#inputCEP").focus();
            });
          }
        });
      } else {
        var erro = "<div id='erroCEP' style='padding-top: 15px;'><div class='alert alert-danger'><p>Há mais/menos de 8 digitos...</p></div></div>";
        $("#card_body").before(erro);
        //alert("Há mais de 8 digitos...");
        $("#inputCEP").val("");
        $("#inputAddress").val("");
        $(document).ready(function(){
          $("#inputCEP").focus();
        });
        
      }
    }
  })
});

$(document).ready(function () {
  $("#inputEmail").blur(function () {
    var mail = $(this).val();
    if (mail != "") {
      validacaoEmail(this);
    }
    else {

    }
  });
});
/*function cleanError(){
  document.getElementById("erroCEP").style.display = "none";
}*/
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
    $(document).ready(function () {
      $("#inputEmail").focus();
    })

  }
}

$(document).ready(function(){
  $("#inputCpf").mask("000.000.000-00")
  //$("#cnpj").mask("00.000.000/0000-00")
  //$("#telefone").mask("(00) 0000-0000")
  //$("#salario").mask("999.999.990,00", {reverse: true})
  $("#inputCEP").mask("00000-000")
  //$("#dataNascimento").mask("00/00/0000")

  $("#inputRg").mask("999.999.999-W", {
    translation: {
      'W': {
        pattern: /[X0-9]/
      }
    },
    reverse: true
  })

  var options = {
    translation: {
      'A': {pattern: /[A-Z]/},
      'a': {pattern: /[a-zA-Z]/},
      'S': {pattern: /[a-zA-Z0-9]/},
      'L': {pattern: /[a-z]/},
    }
  }

  //$("#placa").mask("AAA-0000", options)
  //$("#codigo").mask("AA.LLL.0000", options)
  //$("#celular").mask("(00) 0000-00009")

  $("#inputPhone").blur(function(event){
    if ($(this).val().length === 15){
      $("#inputPhone").mask("(00) 00000-0009")
    }else{
      $("#inputPhone").mask("(00) 0000-00009")
    }
  })
})