require(['jquery'],function($){
   'use strict';

    $(document).on('change', '#taxvat', function(){
        let cpf = $(this).val();

        $.ajax({
            type: 'GET',
            url: 'http://atividade2.localhost/validatetaxvat/index/validate',
            dataType:'json',
            data:{ cpf:cpf },
            success:function(data){
                $('.message-error').remove();
                if (data['error'] == true) {
                    $('#taxvat').after('<p class="message-error">*CPF inválido</p>');
                }
            }
        });
    });
});
