$(function(){
    
    $("#basic_validate").on('submit',function(){
       
       var caminho =$("#basic_validate").attr('action');
       
       var loginCheck = $("#login").val();
       var passwordCheck = $("#senha").val();
       var redirectAdminOperador = "/ducajobs/public/tarefa";
       var redirectSocial = "/ducajobs/public/social";

       if ($('#lembrar').is(":checked")){
            var check = $("#lembrar").val();
       }else{
            var check = "0";
       }
       
       
       if($("#basic_validate").valid()){
           
            $.ajax({
            
            url: caminho,
            type: 'post',
            data: {
                login: loginCheck,
                senha: passwordCheck,
                lembrar:check
            },beforeSend: function() {
                 $("#btn-login").button('loading');   
                 $("#mensagem").hide();   
            },success: function(e) {
                
                setTimeout( function() {
                    $("#btn-login").button('complete');
                    
                    var obj = jQuery.parseJSON(e);

                    if(obj.resultado!=1){
                       $("#mensagem").html(""); 
                       $("#mensagem").html("*Login ou senhas invalidos!");
                       $("#mensagem").show();
                    }else{

                      if(obj.permissao!="social"){
                        $(location).attr('href',redirectAdminOperador); 
                      }else{
                        $(location).attr('href',redirectSocial); 
                      }
                      
                    }
                    
                }, 2000 );
                
            },error: function(e){
                $("#btn-login").button('complete');
                $("#mensagem").html("*erro ao tentar logar! avise ao suporte!");
            }

        })
       
       return false;
       }else{
          $("#btn-login").button('complete'); 
       }
       
    });
    
})