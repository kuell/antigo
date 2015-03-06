$(function(){
	$(".negativo").maskMoney({symbol:"",decimal:",", thousands: ".", allowNegative: true });
	
	$("select").css("background","#FFF");
	$("select").css("height","25px");
	$("select").css("font-size","14px");
	$("input[type=text]").blur(function(){
				muda = $(this).val().toUpperCase()
				$(this).val(muda)
									   })
$(".data").mask("99-99-9999");
$("#kt_login_password").keyup(function(){
				muda = $(this).val().toUpperCase()
						$(this).val(muda)
									   })
$("#kt_login_user").keyup(function(){
				muda = $(this).val().toUpperCase()
						$(this).val(muda)
									   })

$("textarea").blur(function(){
				muda = $(this).val().toUpperCase()
						$(this).val(muda)
									   })
$(".numero").bind("keyup blur focus", function(e) {            
						e.preventDefault();            
						var expre = /[A-Za-z\.\§\£\@\`\Z\^\~\'\"\!\?\#\$\%\s\¬\_\+\=\.\,\:\;\<\>\|\°\ª\º\]\[\{\}\\ \)\(\*\&\-\/\\]/g;             // REMOVE OS CARACTERES DA EXPRESSAO ACIMA            
						if ($(this).val().match(expre))               
						$(this).val($(this).val().replace(expre,''));     
						}); 
$("input[type=submit]").css("background","url(../includes/skins/aqua/images/button_smallest.gif");

})

function maiusculo(qual)
	{
		uCase = qual.value.toUpperCase();
		qual.value = uCase;
	}

function minusculo(qual)
	{
		uCase = qual.value.toLowerCase();
		qual.value = uCase;
	}
