{include file="../../view/topo.tpl"}
{if $op|default:"" eq ""}
<div class="offset1">
<table class="table table-hover">
    <thead>
        <tr>
            <th>Cod</th>
            <th>Grupo</th>
            <th>Descricao</th>
            <th colspan="2">
                <a href="?add" class="btn btn-primary">Adicionar</a>
            </th>
        </tr>
    </thead>
        {foreach $item as $row}
        <tr>
            <td>{$row.id}</td>
            <td>{$row.descGrupo}</td>
            <td>{$row.descricao}</td>
            <td>
                <div class="input-append">
                    <a href="?editar={$row.id}" class="btn" /><i class="icon-pencil" ></i></a>
                <a href="#" class="btn" ><i class="icon-remove" /></i></a>
                </div>
            </td>
        </tr>
        {/foreach}
</table>
</div>

    {else}    
        <div class="offset1">
    <h1>Controle de Itens</h1>
    <form method="POST" class="form">
        <div class="control-group">
            <input type="hidden" value="{$smarty.get.editar}" name="id" />
            <label class="control-label">Grupo: </label>
            <div class="controls"> 
                <select name="grupo" class="validate[required]">
                        <option value="0"> Selecione ...</option>
                        {foreach from=$grupo item=g}
                            <option value="{$g.id}" {if $i.0.grupo|default:"" eq $g.id}selected="" {/if}>{$g.descricao}</option>
                        {/foreach}
                    </select> 
            </div>
        </div>
                    <div class="control-groupl">
                        <label class="control-label">Descricao: </label>
                        <div> <input type="text" name="descricao" value="{$i.0.descricao|default:""}" class="validate[required] input-xlarge" /> </div>
                    </div>
                    <div class="controls">
                        <input type="submit" name="acao" class="btn" value="{$op}" />
                    </div>
    </form>
</div>
{/if}
{include file="../../view/rodape.tpl"}