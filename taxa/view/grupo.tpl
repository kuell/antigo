{include file="../../view/topo.tpl"}

{if $op|default:"" eq ""}
<h4>Controle dos Grupos</h4>
<div class=" span7 offset1">
<table class="table table-striped" align="center">
    <thead>
        <tr>
            <th>Cod</th>
            <th>Descricao</th>
            <th colspan="2">
                <a class="btn btn-primary" href="?add">Adicionar</a></th>
        </tr>
    </thead>
    <tbody>
        {foreach $grupo as $row}
        <tr>
            <td>{$row.id}</td>
            <td>{$row.descricao}</td>
            <td>
                <div class="input-append">
                    <a href="?editar={$row.id}" class="btn"/><i class="icon-pencil"></i></a>
                    <a href="#" class="btn" /><i class="icon-remove"></i></a>
                </div>
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>
</div>
{else}
    <h1>Controle de Grupos</h1>
    <div class="span4 offset1">
        <form method="POST" class="form">
            <div class="control-group">
                <label class="control-label">Descricao: </label>
                <input type="hidden" name="id" value="{$grupo.0.id|default:""}" />
                <div class="controls"> 
                    <input type="text" name="descricao" value="{$grupo.0.descricao|default:""}" class="validate[required] input-xlarge" /> 
                </div>
            </div>
            <div>
                <input type="submit" name="acao" value="{$op}" class="btn" />
            </div>
    </form>
    </div>
{/if}        
{include file="../../view/rodape.tpl"}

