function displayWindow(theURL,winName,width,height,features) { //v3.1
// Made by Eddie Traversa modified from Macromedia Code
// http://nirvana.media3.net/
    var window_width = width;
    var window_height = height;
    var newfeatures= features;
    var window_top = (screen.height-window_height)/2;
    var window_left = (screen.width-window_width)/2;
	var opcoes_janela =newfeatures+",width="+ window_width +",height=" + window_height+",top="+window_top+",left="+window_left;
    newWindow=window.open(theURL,winName,''+opcoes_janela+'');
    newWindow.focus();
}
//-->

function FormataCampo(Campo,teclapres,mascara){ 
//pegando o tamanho do texto da caixa de texto com delay de -1 no event 
//ou seja o caractere que foi digitado não será contado. 
strtext = Campo.value 
tamtext = strtext.length 
//pegando o tamanho da mascara 
tammask = mascara.length 
//criando um array para guardar cada caractere da máscara 
arrmask = new Array(tammask) 
//jogando os caracteres para o vetor 
for (var i = 0 ; i < tammask; i++){ 
arrmask[i] = mascara.slice(i,i+1) 
} 
//alert (teclapres.keyCode) 
//começando o trabalho sujo 
if (((((arrmask[tamtext] == "#") || (arrmask[tamtext] == "9"))) || (((arrmask[tamtext+1] != "#") || (arrmask[tamtext+1] != "9"))))){ 
if ((teclapres.keyCode >= 37 && teclapres.keyCode <= 40)||(teclapres.keyCode >= 48 && teclapres.keyCode <= 57)||(teclapres.keyCode >= 96 && teclapres.keyCode <= 105)||(teclapres.keyCode == 8)||(teclapres.keyCode == 9) ||(teclapres.keyCode == 46) ||(teclapres.keyCode == 13)){ 
Organiza_Casa(Campo,arrmask[tamtext],teclapres.keyCode,strtext) 
} 
else{ 
Detona_Event(Campo,strtext) 
} 
} 
else{//Aqui funcionaria a mascara para números mas eu ainda não implementei 
if ((arrmask[tamtext] == "A")) { 
charupper = event.valueOf() 
//charupper = charupper.toUpperCase() 
Detona_Event(Campo,strtext) 
masktext = strtext + charupper 
Campo.value = masktext 
} 
} 
} 
function Organiza_Casa(Campo,arrpos,teclapres_key,strtext){ 
if (((arrpos == "/") || (arrpos == ".") || (arrpos == ",") || (arrpos == ":") || (arrpos == " ") || (arrpos == "-")) && !(teclapres_key == 8)){ 
separador = arrpos 
masktext = strtext + separador 
Campo.value = masktext 
} 
} 
function Detona_Event(Campo,strtext){ 
event.returnValue = false 
if (strtext != "") { 
Campo.value = strtext 
} 
} 


function validaData() {
        d = document.formCad;
        erro=0;
        hoje = new Date();
        anoAtual = hoje.getFullYear();
        barras = d.data_nascimento.value.split("/");
         if (barras.length == 3){
                   dia = barras[0];
                   mes = barras[1];
                   ano = barras[2];
                   resultado = (!isNaN(dia) && (dia > 0) && (dia < 32)) && (!isNaN(mes) && (mes > 0) && (mes < 13)) && (!isNaN(ano) && (ano.length == 4) && (ano <= anoAtual && ano >= 1900));
                   if (!resultado) {
                             alert("Formato de data invalido!");
                             d.data_nascimento.focus();
                             return false;
                   }
         } else {
                   alert("Formato de data invalido!");
                   d.data_nascimento.focus();
                   return false;
         }
}


<!-- Função para formatar as datas -->
function FormatDate(Campo,teclapres) {
        var tecla = teclapres.keyCode;
        vr = Campo.value;
        vr = vr.replace( ".", "" );
        vr = vr.replace( "/", "" );
        vr = vr.replace( "/", "" );
        tam = vr.length + 1;

        if ( tecla != 9 && tecla != 8 ){
                if ( tam > 2 && tam < 5 ) {
                 Campo.value = vr.substr( 0, tam - 2  ) + '/' + vr.substr( tam - 2, tam );}
                if ( tam >= 5 && tam <= 10 ){
                 Campo.value = vr.substr( 0, 2 ) + '/' + vr.substr( 2, 2 ) + '/' + vr.substr( 4, 4 ); }
        }
}
<!-- Função para checar a validade da data -->
  function checkdate(t,msg) {
    var barras=0;
    a=t.value
    if(a == "dd/mm/aaaa") {
      t.value="01/01/1999";
      return true
    }
    if (a == "") {
      return true
    }
    var b = ""
    var isValid = true
    for (var i = 0; i < a.length; i++) {
      if ( (a.substring(i, i+1) == "-") || (a.substring(i, i+1) == ".") || (a.substring(i, i+1) == "/")) {
        b = b + "/"
        barras++
        if((a.length-1)==i) {
          alert(msg+" Data inválida, utilizar barras como separadores (ex.: 01/01/1999).")
          return select(t); }
      } else {
        b = b + a.substring(i, i+1)
      }
    }
    var d = new Date(b)
    if (barras!=2) {
      alert(msg+" Data inválida, utilizar barras como separadores (ex.: 01/01/1999).")
      return select(t); }
    if (d == "Invalid Date") {
      alert(msg+" Data inválida")
    } else {
       dia = b.substring(0, b.indexOf("/") )
       mes = b.substring(b.indexOf("/") + 1, b.lastIndexOf("/")  )
       ano = b.substring(b.lastIndexOf("/") + 1, b.length)

       for (var j = 0; j < ano.length - 1; j++) {
         if (ano.substring(0,1) == "0") {
           ano = ano.substring(1, ano.length)
         }
       }
       if ( (mes > 12) || (mes < 1) ) {
         alert(msg+"Mês <"+mes+"> inválido")
         isValid = false
         return select(t)
       }
       if (dia.length == 1) { dia = "0" + dia }
       if (mes.length == 1) { mes = "0" + mes }
       if (ano < 10) {
         if (ano.length == 1) {
           ano = "200" + ano
         } else if (ano.length == 2) {
           ano = "20" + ano
         } else if (ano.length == 3) {
           ano = "2" + ano
         }
       } else if (ano < 50) {
         ano = "20" + ano
       } else if (ano < 100) {
         ano = "19" + ano
       } else if (ano < 1000) {
         ano = "1" + ano
       }
       if ( (mes == 1) || (mes == 3) || (mes == 5) || (mes == 7) ||
            (mes == 8) || (mes == 10) || (mes == 12) ) {
         if ( (dia > 31) || (dia < 1) ) {
           alert(msg+"Dia <"+dia+"> inválido")
           isValid = false
           return select(t)
         }
       } else if ( (mes == 4) || (mes == 6) || (mes == 9) || (mes == 11) ) {
         if ( (dia > 30) || (dia < 1) ) {
           alert(msg+"Dia <"+dia+">inválido")
           isValid = false
           return select(t)
         }
       } else {
         if (dia == 30) {
           isValid = false
         } else if (dia == 29) {
           if ( (new String(ano / 4)).indexOf(".") != -1) {
             isValid = false
           }
         }
       }
       if (isValid) {
         t.value = dia + "/" + mes + "/" + ano
         return true
       } else {
         alert("Data <"+t.value+"> inválida")
         return select(t)
       }
    }
  }
  <!-- fim da função -->

