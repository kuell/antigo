$(function(){
    $(".valor").maskMoney({
        symbol:"R$ ",
        decimal:",", 
        thousands: ".",
        allowZero:true
    });
    $(".qtd").maskMoney({
        symbol:"",
        decimal:",", 
        thousands: ".",
        allowZero:true
    });
    $(".fone").mask("(99) 9999-9999");
    $(".hora").mask("99:99");
    $("#voltar").click(function(){
        location = "?"
    })
    $(".data").mask("99/99/9999");
    $(".data").datepicker({
            dateFormat: 'dd/mm/yy',
            dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
            dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
            monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            nextText: 'Próximo',
            prevText: 'Anterior',
            changeYear: true,
            yearRange : '2010:2015',
            changeMonth: true
        });
    
    $("input[type=text], textarea").blur(function(){
        muda = $(this).val().toUpperCase()
        $(this).val(muda)
    })
    $(".email").blur(function(){
        muda = $(this).val().toLowerCase()
        $(this).val(muda)
    })
    $(".int").bind("keyup blur focus", function(e) {            
        e.preventDefault();         
        var expre = /[A-Za-z\.\Â§\Â£\@\`\Z\^\~\'\"\!\?\#\$\%\s\Â¬\_\+\=\.\,\:\;\<\>\|\Â°\Âª\Âº\]\[\{\}\\ \)\(\*\&\-\/\\]/g;             // REMOVE OS CARACTERES DA EXPRESSAO ACIMA            
        if ($(this).val().match(expre))               
            $(this).val($(this).val().replace(expre,'')); 
    })
    $("input[name=Adicionar]").click(function(){
        $("#lista").hide();
        $("#form").show();
    });
    $("#form").hide();
    $(".cnpj_cpf").blur(function(){
        qtd = $(this).val().length; 
    });

});