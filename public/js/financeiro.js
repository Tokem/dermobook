$(document).ready(function() {

    $('#form_entradas').bootstrapValidator({
        message: 'Valor não válido!',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            fin_descricao: {
                validators: {
                    notEmpty: {
                        message: 'Descrião é obrigatório!'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'Digite entre 6 e 30 letras'
                    },
                }
            },
            fin_tipo: {
                validators: {
                    notEmpty: {
                        message: 'Tipo é obrigatório!'
                    },
                }
            }
            ,fin_data: {
                validators: {
                    notEmpty: {
                        message: 'Data é obrigatório!'
                    },
                }
            },fin_valor: {
                validators: {
                    notEmpty: {
                        message: 'Valor é obrigatório!'
                    }
                }
            },
            
        }
    });
});







// //Deletar cliente
// $("#deleteCliente").on('click',function(){
    
//     $("#save_financeiro_receita").on('click',function(){
        
//         var codigo = $("#form-cliente").attr('ref');
//         var caminho ="/ducajobs/public/cliente/delete-ajax/";
//         var url = location.href;  // entire url including querystring - also: window.location.href;
//         var baseURL = url.substring(0, url.indexOf('/', 14))+"/guia/public/cliente/";
    
//             if ( $("#form-cliente").length ){
//                 $.ajax({
//                     url: caminho,
//                     type: 'post',
//                     data: {
//                         cli_codigo: codigo,
//                     }, beforeSend: function() {
//                     }, success: function(e) {
//                         window.location.replace("/ducajobs/public/cliente/");
//                     }, error: function(e) {
//                         console.log(e);
//                         return false
//                     }
//                 })
//             }    
        
//          return false;   
        
//     })
    
//     return false;   
// })