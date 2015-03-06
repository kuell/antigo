{include file="../../view/topo.tpl"}
{if $op|default:"" eq ""}
    {literal}
    <script>
    function excluir(idTaxa){
            if(confirm("Deseja realmente excluir este registro!!!")){
                $.post("taxa.php", {id: idTaxa, 
                                    acao: "delete"}, function(val){
                    alert(val)
                  //  location = "taxa.php";
                    })
            }
            return false;
        }   

    function getAjuste(){
        window.open('Ajustes.php?'+$('form').serialize(), 'Print', 'channelmode=yes, scrollbars=1');
    } 

    </script>
    {/literal}
<div class="well form-search">
<form class="form-search" method="GET">
    <fieldset>
        <legend>Controle de taxas</legend>
            <label>Data:</label>
            <?php !empty($_GET['datai'])? echo $_GET['datai']: echo date('d/m/Y'); ?>
                <input type="text" name="datai" value="{$smarty.get.datai|default:($smarty.now|date_format:"%d/%m/%Y")}" class="data">
                <input type="text" name="dataf" value="{$smarty.get.dataf|default:($smarty.now|date_format:"%d/%m/%Y")}" class="data">
            <label>Corretor: </label>
            <select name="cor">
                <option value="">Todos</option>
                {foreach from=$cor item=c}
                <option value="{$c.cor_id}" {if $smarty.get.cor|default:"" eq $c.cor_id}selected{/if} >{$c.cor_cod} - {$c.cor_nome}</option>
            {/foreach}
            </select>
            
            <input name="acao" value="Buscar" type="submit" class="btn" />
            <button value="Buscar" type="button" class="btn" onclick="getAjuste()">Ajustes</button>            
    </fieldset>
</form>
</div>
<div class="span12 offset1">
<table class="table table-striped" align="center">
    <thead>
        <tr>
            <th>Cod</th>
            <th>Data</th>
            <th>Corretor</th>
            <th colspan="2">
                <a href="?add&data={($data|default:$smarty.now)|date_format:"%d/%m/%Y"}" class="btn btn-primary">Adicionar</a> 
            </th>
        </tr>
        </thead>
        {foreach $taxa as $row}
    <tbody>
        
        <tr>
            <td>{$row.id}</td>
            <td>{$row.data|date_format:"%d/%m/%Y"}</td>
            <td>{$row.cor_cod} - {$row.cor_nome}</td>
            <td>
                <div class="input-append">
                    <a data-toggle="tooltip" href="?grupo={$row.id}" rel="superbox[iframe][1000x500]" class="btn">Itens</a>
                    <a href="?edit={$row.id}" class="btn">editar</a>
                    <a href="#" class="btn disabled">excluir</a>
            </div></td>
        </tr>
    </tbody>
    {/foreach}
</table>
 </div>
{else}
{literal}
    <script>
        $(function(){
            $("select[name=corretor]").blur(function(){
                if($(this).val() == ""){
                    alert("Este campo deve ser preenchido!")
                    $(this).focus();
                }
                else{
                $.post("taxa.php", {cor:$(this).val(),
                                    acao:"buscar",
                                    data: $("input[name=data]").val()
                                    }, function(val){
                                        if(val !=0){
                                            alert("\t Antenção!!! \n Já existe um lançamento para este corretor neste dia!");
                                            location = "taxa.php";
                                        }
                                    })
                }
            });
        })
            
    </script>
{/literal}
<div class="">
<form method="POST" class="form-inline">
    <fieldset>
        <legend>Controle de Taxas</legend>
        <div class="span7 offset5">
    <div class="control-group">
        <label class="control-label">Usuario: </label>
        <div class="controls">
            <input type="text" class="disabled" name="id" value="{$smarty.session.kt_login_user}" /> 
        </div>     
    </div>
    <div class="control-group">
        <label class="control-label">Data:</label>
        <div class="controls">
            <input type="text" name="data" class="validate[required] data" value="{($t.data|default:$data)|date_format:"%d/%m/%Y"}" /> 
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Corretor</label>
        <div class="controls">    
            <select name="corretor" class="validate[required]">
                     <option value="">Selecione ...</option>
                    {foreach from=$cor item=c}
                        <option value="{$c.cor_id}" {if $c.cor_id eq $t.corretor|default:""}selected={/if} >{$c.cor_cod} - {$c.cor_nome}</option>
                    {/foreach}
            </select>
        </div>
    </div>
   <div class="control-group" >
       <label class="control-label">Observação: </label>
       {$t.obs|default:""}
       <div class="controls">
           <textarea cols="50" rows="5" name="obs">{$t.obs|default:""}</textarea> 
       </div>
   </div>
   <div class="control-group">
       <input class="btn" type="submit" value="{$op|default:""}" name="acao" />  
       
        {if $smarty.get.edit|default:"" ne ""}
            <a href="?grupo={$smarty.get.edit}" rel="superbox[iframe][900x500]" class="btn btn-primary">Itens</a>  
        {/if}
       <input class="btn" type="button" value="Visualizar" name="acao" />  
       <input class="btn" type="button" value="Voltar" name="acao" onclick="location = '?data={($t.data|default:$data)|date_format:"%d/%m/%Y"}'" />
       <input type="hidden" name="id" value="{$smarty.get.edit|default:""}">
    </div>
       </div>
       </fieldset>
</form>
        </div>
{/if}
{include file="../../view/rodape.tpl"}