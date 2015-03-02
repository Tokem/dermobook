$(document).ready(function() {

    $('#registrationForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nome: {
                validators: {
                    notEmpty: {
                        message: 'Nome obrigatório'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'Digite entre 6 e 30 letras'
                    },
                }
            }
            ,email: {
                validators: {
                    notEmpty: {
                        message: 'Email Obrigatório!'
                    },
                    emailAddress: {
                        message: 'Digite um email válido!'
                    }
                }
            },sexo: {
                validators: {
                    notEmpty: {
                        message: 'Sexo Obrigatório!'
                    }
                }
            },telefone: {
                validators: {
                    notEmpty: {
                        message: 'Telefone Obrigatório!'
                    },
                }
            },
            
        }
    });
});

function onFormSuccess(e) {

    var caminho = "/dermobook/public/promocoes/adicionar";
    var nome = $("#nome").val();
    var email = $("#email").val();
    var telefone = $("#telefone").val();
    var sexo = $('input[name=sexo]:checked', '#registrationForm').val()

    $.ajax({
        url: caminho,
        type: 'post',
        data: {
            dermo_nome: nome,
            dermo_email: email,
            dermo_telefone: telefone,
            dermo_sexo: sexo,
        }, beforeSend: function() {
        }, success: function(e) {
            if(e==1){
                $("#nome").val("");
                $("#email").val("");
                $("#telefone").val("");
                $('input[name=sexo]:checked', '#registrationForm').prop( "checked", false );
                $("#myModal").modal("hide");
                alert("Participante cadastrado com sucesso!");
            }else{
                alert(e);
            }
            return false;
        }, error: function(e) {
        }
    })
  
};



$(document).ready(function(){

    $("#sortear").on("click",function(){
        var caminho = "/dermobook/public/promocoes/sortear";

            $.ajax({
                url: caminho,
                type: 'post',
                 beforeSend: function() {
                }, success: function(e) {
                    alert(e);
                    console.log(e);
                    return false;
                }, error: function(e) {
                }
            })
    })
})





