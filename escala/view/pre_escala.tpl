<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../js/modal/jquery.superbox.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
<link href="../css/calendario.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.11.4/jquery-ui.js"></script>    
<script type="text/javascript" src="../js/bootstrap.min.js"></script>

<script type="text/javascript" src="../js/jquery.maskMoney.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="../js/modal/jquery.superbox-min.js"></script> 


<script type="text/javascript" src="../js/scripts.js"></script> 

<script type="text/javascript">
    $(function(){
		var availableTags = $.get('?buscaPecuarista' ,function(data) {
									console.log(data)
								});
		$( "#pecuarista" ).autocomplete({
				source: availableTags
			});
		$('#pecuarista').click(function(event) {
			alert("Ola");
		});

        $.superbox();
    })

</script>
</head>

{if $op|default:"" eq ""}

<h1>Pré-Escala de abate</h1>
<div>
<table class="table table-striped">
    <thead>
        <tr>
          <th colspan="7" >
              {assign var=m value=($mes|date_format:"%m")}
            <a class="btn btn-info" href="?ref=-1&mes={$m}&ano={$ano}"><< <i class="icon-chevron-left"></i></a>
            <input type="text" value="{$mesNome} -  {$ano}" class="disabled">
            <a class="btn btn-info" href="?ref=1&mes={$m}&ano={$ano}"> >><i class="icon-chevron-right"></i></a>
          </th>
        </tr>
        <tr>
            <th>Domingo</th>
            <th>Segunda</th>
            <th>Terça</th>
            <th>Quarta</th>
            <th>Quinta</th>
            <th>Sexta</th>
            <th>Sabado</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$dia item=d}
            <tr>
                <td><div class="well">
                   {if ($d.0|default:"" ne "")}
                    {($d.0|default:"")}    
                    <div>
                        Domingo
                    </div>
                    {/if}
                   </div>
                </td>
                <td><div class="well">
                    {if $d.1|default:"" ne ""}
                    <a class="btn btn-primary btn-lg" href="?add=1&data={$ano}-{$m}-{$d.1}" rel="superbox[iframe][1100x500]">
                        {$d.1|default:""}
                    </a>
                        <div>
                            Total: {$qtd.{$d.1}|default:""}</div>
                    </div>
                    {/if}
                </td>
                <td><div class="well">
                        {if $d.2|default:"" ne ""}
                    <a class="btn btn-primary btn-large" href="?add=1&data={$ano}-{$m}-{$d.2}" rel="superbox[iframe][1100x500]">
                        {$d.2|default:""}
                    </a>
                        <div>
                            Total: {$qtd.{$d.2}|default:""}</div>
                    </div>
                    {/if}
                </td>
                <td><div class="well">
                        {if $d.3|default:"" ne ""}
                    <a class="btn btn-primary btn-large" href="?add=1&data={$ano}-{$m}-{$d.3}" rel="superbox[iframe][1100x500]">
                        {$d.3|default:""}
                    </a>
                        <div>
                            Total: {$qtd.{$d.3}|default:""}</div>
                   </div>
                   {/if}
                </td>
                <td><div class="well">
                        {if $d.4|default:"" ne ""}
                    <a class="btn btn-primary btn-large" href="?add=1&data={$ano}-{$m}-{$d.4}" rel="superbox[iframe][1100x500]">
                        {$d.4|default:""}
                    </a>
                        <div>
                            Total: {$qtd.{$d.4}|default:""}</div>
                </div>
                {/if}
                </td>
                <td><div class="well">
                        {if $d.5|default:"" ne ""}
                    <a class="btn btn-primary btn-large" href="?add=1&data={$ano}-{$m}-{$d.5}" rel="superbox[iframe][1100x500]">
                        {$d.5|default:""}
                        </a>
                        <div>
                            Total: {$qtd.{$d.5}|default:""}</div>
                        </div>
                        {/if}
                </td>
                <td><div class="well">
                        {if $d.6|default:"" ne ""}
                    <a class="btn btn-primary btn-large" href="?add=1&data={$ano}-{$m}-{$d.6}" rel="superbox[iframe][1100x500]">
                        {$d.6|default:""}
                    </a>
                        <div>
                            Total: {$qtd.{$d.6}|default:""}</div>
                    </div>
                    {/if}
                </td>
        </tr>
       {/foreach}
    </tbody>
</table>
</div>
{else}    
    <div>
        <form method="POST" class="form form-horizontal well">
            <fieldset>
                <legend>Digitação de Pré-Escala</legend>
                <div class="control-group">
                    <label class="control-label">Data: </label>
                    <div class="controls">
                        <input type="text" name="data" id="data" class="data" value="{$smarty.get.data|date_format:"%d/%m/%Y"}" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Pecuarista: </label>
                    <div class="controls">
                        <input type="text" name="pecuarista" id="pecuarista" class="input-xxlarge" value="{$pecuarista|default:""}" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Corretor: </label>
                    <div class="controls">
                        <select name="corretor">
                            <option value="0">Selecione ...</option>
                            {foreach from=$cor item=c}
                                <option value="{$c.cor_id}" {if $cr|default:"" eq $c.cor_id} selected {/if}>{$c.cor_cod} - {$c.cor_nome}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="container-fluid" >
                            <div class="row-fluid">
                             <div class="span3 well">
                            <label>Qtd. Boi</label>                            
                                <input class="int form-control" type="text" name="qtdBoi" value="{$qtdBoi|default:"0"}"  />
                                </div>
                                <div class="span3 well">
                            <label class="">Qtd. Vaca</label>
                                <input class="int input-small" type="text" name="qtdVaca" value="{$qtdVaca|default:"0"}" />
                                </div>
                                <div class="span3 well">
                            <label class="">Qtd. Novilha</label>
                                <input class="int input-small" type="text" name="qtdNov" value="{$qtdNov|default:"0"}" />
                                </div>
                                <div class="span3 well">
                            <label class="">Qtd. Touro</label>
                                <input class="int input-small" type="text" name="qtdTouro" value="{$qtdTouro|default:"0"}" />
                                </div>
                            </div>
                        </div>
               <div class="control-group">
                   <input type="submit" class="btn" name="acao" value="{$op}" />
                   <input type="button" class="btn" name="acao" value="Visualizar" onclick="window.open('view_preEscala.php?data='+document.getElementById('data').value, 'Print', 'channelmode=yes')" />
                   <input type="hidden" value="{$id|default:""}" name="id" />
               </div>
            </fieldset>
        </form>
    </div>
 <div>
     <table border="0" class="table table-hover well">
       <thead>
         <tr>
            <th>Pecuarista</th>
            <th>Corretor</th>
            <th>Qtd. Boi</th>
            <th>Qtd. Vaca</th>
            <th>Qtd. Nov</th>
            <th>Qtd. Touro</th>
            <th>#</th>
         </tr>
        </thead>
	       <tbody>
	           {foreach from=$lista item=pe}
	           <tr>
	               <td>{$pe.pecuarista}</td>
	               <td>{$pe.cor_cod} - {$pe.cor_nome}</td>
	               <td>{$pe.qtdBoi}</td>
	               <td>{$pe.qtdVaca}</td>
	               <td>{$pe.qtdNov}</td>
	               <td>{$pe.qtdTouro}</td>
	               <td>
	                   {if $pe.situacao eq "e"}
	                       <i class="icon-lock" title="Para desbloquear é preciso excluir da escala de abate!"></i>
	                   {else}
	                        <a href="?editar={$pe.id}&data={$smarty.get.data}" class="icon-pencil" title="Editar!"></a>
	                        <a href="?del={$pe.id}&data={$smarty.get.data}" class="icon-remove" title="Remover da pré-escala!"></a>
	                        <a href="?conf={$pe.id}&data={$smarty.get.data}" class="icon-ok" title="Confirmar na escala!"></a>
	                   {/if}
	               </td>
	           </tr>
	           {/foreach}
	       </tbody>
    </table>
</div>


{/if}
{include file="../../view/rodape.tpl"}