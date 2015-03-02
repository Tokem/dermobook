
$(function(){
     $('a').on('mouseover', function() {
            $(this).tooltip('show');
        });

     $('button').on('mouseover', function() {
            $(this).tooltip('show');
        });

})

//Perfil Images
$(function(){   
    $('.perfil-img').click(function() {
      $('input[type=file]').trigger('click');
  });

  $('input[type=file]').change(function() {
      $('#form-perfil-image').submit();
  });
})

//Click nos graficos
$(function(){
    $("#chart-afazer").on('click',function(){

        var pathname = window.location.pathname;
        var tab = "#tab1";

        if(pathname!="/ducajobs/public/tarefa"){

            $.ajax({
                url: "/ducajobs/public/tarefa/aba",
                type: 'post',
                data: {
                    aba: tab,
                }, beforeSend: function() {
                }, success: function(e) {
                    window.location="/ducajobs/public/tarefa";
                }, error: function(e) {
                    console.log(e);
                    return false
                }
            })

        }else{$( "#tab01" ).trigger( "click" );}
        
    })
    $("#chart-andamento").on('click',function(){
        var pathname = window.location.pathname;
        var tab = "#tab2";

        if(pathname!="/ducajobs/public/tarefa"){

            $.ajax({
                url: "/ducajobs/public/tarefa/aba",
                type: 'post',
                data: {
                    aba: tab,
                }, beforeSend: function() {
                }, success: function(e) {
                    window.location="/ducajobs/public/tarefa";
                }, error: function(e) {
                    console.log(e);
                    return false
                }
            })

        }else{$( "#tab02" ).trigger( "click" );}
    })
    $("#chart-atrasados").on('click',function(){
        var pathname = window.location.pathname;
        var tab = "#tab3";

        if(pathname!="/ducajobs/public/tarefa"){

            $.ajax({
                url: "/ducajobs/public/tarefa/aba",
                type: 'post',
                data: {
                    aba: tab,
                }, beforeSend: function() {
                }, success: function(e) {
                    window.location="/ducajobs/public/tarefa";
                }, error: function(e) {
                    console.log(e);
                    return false
                }
            })

        }else{$( "#tab03" ).trigger( "click" );}
    })
    $("#chart-concluidos").on('click',function(){
        var pathname = window.location.pathname;
        var tab = "#tab4";

        if(pathname!="/ducajobs/public/tarefa"){

            $.ajax({
                url: "/ducajobs/public/tarefa/aba",
                type: 'post',
                data: {
                    aba: tab,
                }, beforeSend: function() {
                }, success: function(e) {
                    window.location="/ducajobs/public/tarefa";
                }, error: function(e) {
                    console.log(e);
                    return false
                }
            })

        }else{$( "#tab04" ).trigger( "click" );}
    })
    $("#chart-finalizados").on('click',function(){
        var pathname = window.location.pathname;
        var tab = "#tab5";

        if(pathname!="/ducajobs/public/tarefa"){

            $.ajax({
                url: "/ducajobs/public/tarefa/aba",
                type: 'post',
                data: {
                    aba: tab,
                }, beforeSend: function() {
                }, success: function(e) {
                    window.location="/ducajobs/public/tarefa";
                }, error: function(e) {
                    console.log(e);
                    return false
                }
            })

        }else{$( "#tab05" ).trigger( "click" );}
    })
})

$(function() {
    $("#cli_senha").pstrength();
    $("#cli_telefone").mask('(99) 9999-9999');
    $("#per_contato_urgencia").mask('(99) 9999-9999');
    $("#data_inicio").datepicker();
    $("#data_fim").datepicker();
    //$("#data_social").datepicker();

    $('#tar_prazo-datepicker').datetimepicker({
      pickTime: false
    });


    
    $('#soc_data-datepicker').datetimepicker({
      pickTime: false
    });


    $('#soc_hora-datepicker').datetimepicker({
      pickDate: false
    });
    
    $('#tar_hora-datepicker').datetimepicker({
      pickDate: false
    });
    
})

$("#cli_email").on('blur', function() {

    var caminho = "/ducajobs/public/usuario/email";
    var check = $("#cli_email").val();
    
    if(check){
        $.ajax({
        url: caminho,
        type: 'post',
        data: {
            cli_email: check,
        }, beforeSend: function() {
            $("#load").fadeOut();
            $("#load").show();
            $("#mensagem_email").hide();
            $('#btnusuario').prop('disabled', true);
        }, success: function(e) {
            $("#load").fadeOut();
            setTimeout(function() {
                $("#mensagem_email").hide();
                if (e) {
                  $("#mensagem_email").html("");
                  $('#btnusuario').prop('disabled', false);
                  $("#btnusuario").button('complete');
                } else {
                    $("#btnusuario").button('loading');
                    $("#mensagem_email").html("");
                    $("#mensagem_email").html("*Email já cadastrado no sistema");
                    $("#mensagem_email").show();
                }

            }, 2000);

        }, error: function(e) {

            setTimeout(function() {
                $("#mensagem_email").html("*Erro ao pesquisar email na base de dados");
                $("#mensagem_email").show();
                $("#load").fadeOut();
            }, 2000);

        }
    })
    }
    
    
})

//Deletar Usuario
$("#deleteUser").on('click',function(){

    $('#myModal').modal('show');
    $("#modal-t").html('Deletar usuario');
    $(".modal-body").html("<p>Deseja realmente deletar este usuario?!</p><p>Esta ação não podera ser disfeita!</p>")
    
    $("#continuar").on('click',function(){
        var codigo = $("#form-usuario").attr('ref');
        var caminho ="/ducajobs/public/usuario/delete-ajax/";
        var url = location.href;  // entire url including querystring - also: window.location.href;
         var baseURL = url.substring(0, url.indexOf('/', 14))+"/guia/public/usuario/";
        
      if ( $("#form-usuario").length ){  
        $.ajax({
            url: caminho,
            type: 'post',
            data: {
                cli_codigo: codigo,
            }, beforeSend: function() {
            }, success: function(e) {
                window.location.replace("/ducajobs/public/usuario/");
            }, error: function(e) {
                console.log(e);
                return false
            }
        })
           return false; 
       } 
      
    })
    
    return false;

})

//Deletar cliente
$("#deleteCliente").on('click',function(){
    
    $('#myModal').modal('show');
    $("#modal-t").html('Deletar cliente');
    $(".modal-body").html("<p>Deseja realmente deletar este cliente?!</p><p>Esta ação não podera ser disfeita!</p>")
    
    $("#continuar").on('click',function(){
        var codigo = $("#form-cliente").attr('ref');
        var caminho ="/ducajobs/public/cliente/delete-ajax/";
        var url = location.href;  // entire url including querystring - also: window.location.href;
         var baseURL = url.substring(0, url.indexOf('/', 14))+"/guia/public/cliente/";
    
            if ( $("#form-cliente").length ){
                $.ajax({
                    url: caminho,
                    type: 'post',
                    data: {
                        cli_codigo: codigo,
                    }, beforeSend: function() {
                    }, success: function(e) {
                        window.location.replace("/ducajobs/public/cliente/");
                    }, error: function(e) {
                        console.log(e);
                        return false
                    }
                })
            }    
        
         return false;   
        
    })
    
    return false;   
})

/*Inativar tarefa*/


$(function(){
//    $('.make-switch').on('click', function(e, data) {
//        $('.make-switch').bootstrapSwitch('toggleState');
//    });
    $('.desligar-tarefa').on('switch-change', function (e, data) {
        
        var status = data.value;
        var codigo = $(this).attr('data-id');
        var caminho ="/ducajobs/public/tarefa/status/";
        var cod = null;
        

        if(status){
            cod = 1; 
        }else{
            cod = 0;
        }
        
            $.ajax({
                    url: caminho,
                    type: 'post',
                    data: {
                        tar_ativo: cod,
                        id:codigo,
                        acao:'desligar'
                    }, beforeSend: function() {
                    }, success: function(e) {
                       console.log(e);
                       return false;
                    }, error: function(e) {
                        console.log(e);
                        return false
                    }
                })
        
        return false;
    });
})

$(function(){

   if($('#charts-box').length){
    $('#charts-box').fadeIn('fast');
   }

})

