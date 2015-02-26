{include file="../../view/topo.tpl"}

<div>
    <form class="well form-search" method="POST">
    <div class="control-group">
        <label class="controls">Cod. Taxa: </label>
            <span class="badge">{$smarty.get.idTaxa}</span> 
        <label class="controls">Data: </label>
            <span class="badge">{$taxa.0.data|date_format:"%d/%m/%Y"}</span> 
        <label class="controls">Corretor: </label>
            <span class="badge">{$taxa.0.cor_cod} - {$taxa.0.cor_nome}</span> 
    </div>
    
    <label>Item: </label>
    <select name="idItem" class="validate[required]">
                        <option value="">Selecione ...</option>
                        {foreach from=$item item=i}
                        <option value="{$i.id}">{$i.descricao}</option>
                        {/foreach}
                    </select>
    <label>Qtd.:</label>
    <input type="text" size="5" name="qtd" class="validate[required] valor" value="" /> 
    
    <label>Peso.:</label>
    <input type="text" size="5" name="peso" class="validate[required] valor" value="" /> 
    
    <label>Valor: </label>
    <input type="text" size="5" class="validate[required] valor" name="valor" value="" />
    
    <label>Tipo: </label>
    <select name="tipo">
        <option value="c">A PAGAR</option>
        <option value="d">A RECEBER</option>
        <option value="i" selected>INFORMATIVO</option>
    </select>
    
    <input type="submit" value="Incluir" class="btn" name="acao" /> 
    <input type="hidden" value="{$smarty.get.idTaxa}" name="idTaxa" />
    </form>
</div>
        <div>
            <table border="0" class="table table-hover">
                <thead>
                    <tr>
                        <th>Grupo</th>
                        <th>Item</th>
                        <th>Qtd</th>
                        <th>Peso</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$taxaItem item=it}
                    <tr>
                        <td>{$it.grupo}</td>
                        <td>{$it.item}</td>
                        <td>{$it.qtd|string_format:"%.2f"}</td>
                        <td>{$it.peso|string_format:"%.2f"}</td>
                        <td>{$it.valor|string_format:"%.2f"}</td>
                        <td>{if $it.tipo eq "d"} 
                                A RECEBER 
                            {else if $it.tipo eq "c"} 
                                A PAGAR 
                            {else}
                                INFORMATIVO
                                {/if}</td>
                        <td>
                            <div class="input-append">
                                <a href="?excluirItem&idTaxa={$smarty.get.idTaxa}&item={$it.idItem}&grupo={$smarty.get.g}" class="icon-remove"></a>
                            </div>
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>

        
        </div>
{include file="../../view/rodape.tpl"}