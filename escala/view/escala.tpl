{include file="../../view/topo.tpl"}
{literal}
<script type="text/javascript">
    
function exclui(id,data){
        if(confirm("ATENÇÃO \n Ao excluir este lote, ele automaticamente voltará a pré-escala na mesma data! \t \n Deseja realmente excluir este registro?")){
            location = "?excluir&id="+id+"&data="+data
            
        }
        return false
    }
    
</script>
{/literal}
{if $op|default:"" ne ""}
<div class="offset1">
    
    <form method="POST" class="form form-horizontal">
        <fieldset>
            <legend>Cadastro de Lote</legend>
            <div class="control-group">
                <label class="control-label" >Data: </label>   
                <div class="controls"> 
                    <input type="text" name="data" {if $smarty.get.id|default:"" ne ""} readonly {else}class="data" {/if} value="{$data|date_format:"%d/%m/%Y"}" />                   
                </div>
            </div>
                <div class="control-group">
                    <label class="control-label">Pecuarista:</label>
                    <div class="controls">
                        <input type="text" name="pecuarista" id="pecuarista" value="{$pecuarista|default:''}" size="70" />
                    </div>
                </div>
                    <div class="control-group">
                        <label class="control-label">Corretor: </label>
                        <div class="controls">
                            <select name="corretor" class="input-xxlarge">
                            <option value="">Selecione ...</option>
                            {foreach from=$corretor item=cor}
                                <option value="{$cor.cor_id}" {if $c|default:"" eq $cor.cor_id}selected{/if} >{$cor.cor_cod} - {$cor.cor_nome}</option>    
                            {/foreach}
                        </select>
                        
                        </div>
                    </div>
          
                        <legend>Escala</legend>
                        <div class="container-fluid" >
                            <div class="row-fluid">
                             <div class="span3 well">
                            <label>Qtd. Boi</label>                            
                                <input class="int" type="text" name="qtdBoi" value="{$qtdBoi|default:"0"}"  />
                                </div>
                                <div class="span3 well">
                            <label class="">Qtd. Vaca</label>
                                <input class="int" type="text" name="qtdVaca" value="{$qtdVaca|default:"0"}" />
                                </div>
                                <div class="span3 well">
                            <label class="">Qtd. Novilha</label>
                                <input class="int" type="text" name="qtdNov" value="{$qtdNov|default:"0"}" />
                                </div>
                                <div class="span3 well">
                            <label class="">Qtd. Touro</label>
                                <input class="int" type="text" name="qtdTouro" value="{$qtdTouro|default:"0"}" />
                                </div>
                            </div>
                        </div>
                                <div class="control-group well span11">
                                    <input type="submit" name="acao" value="{$op}" class="btn" />
                                    <input type="submit" name="acao" value="Voltar" class="btn" />
                                    <input type="hidden" name="id" id="id" value="{$smarty.get.id}" />
                       </div>
        </fieldset>

    </form>
 </div>
{else}
    <div class="offset1">
        <form method="GET" class="form form-horizontal" />
        <fieldset>
            <legend>Controle da escala de abate.</legend>
            <div class="control-group">
                <label class="control-label">Data: </label>
                <div class="controls">
                    <input type="text" class="data" name="data" id="data"  value="{($data|default:$smarty.now)|date_format:"%d/%m/%Y"}" />
                </div>
            </div>
                <div class="control-group">
                <label class="control-label">Hora de incio: </label>
                <div class="controls">
                    <input type="text" class="hora" name="hora" id="hora"  value="05:00" />
                </div>
            </div>
                <div class="control-group well span5">
                    <input class="btn" type="submit" value="Buscar" name="acao" />
                    <input class="btn" onclick="window.open('rel_escala.php?data='+document.getElementById('data').value+'&hora='+document.getElementById('hora').value, 'Print', 'channelmode=yes')" type="button" value="Escala" title="Escala todos os lotes selecionados!" name="acao" />
                </div>
                </fieldset>
            </form>
    </div>

<div class="offset1 span">
    <table border="0" class="table table-hover" align="center">
        <thead>
        <tr>
            <th>Lote</th>
            <th>Data</th>
            <th>Corretor</th>
            <th>Pecuarista</th>
            <th>Qtd. boi</th>
            <th>Qtd. Vaca</th>
            <th>Qtd. Nov.</th>
            <th>Qtd. Touro</th>
            <th>Total</th>
            <th>Duração</th>
            <th colspan="4"><a href="?add&data={($data|default:$smarty.now)|date_format:"%d/%m/%Y"}" class="btn btn-primary" >Adicionar</a></th>
        </tr>
        </thead>
        <tbody>
            
            {foreach from=$escala item=row name=esc}
        <tr>            
            <td>{$row.lote}</td>
            <td>{$row.data|date_format:"%d/%m/%Y"}</td>
            <td>{$row.cor_cod}</td>
            <td>{$row.pecuarista}</td>
            <td>{$row.qtdBoi}</td>
            <td>{$row.qtdVaca}</td>
            <td>{$row.qtdNov}</td>
            <td>{$row.qtdTouro}</td>
            <th class="well">{$row.qtdVaca+$row.qtdTouro+$row.qtdNov+$row.qtdBoi}</th>
            <td>{$row.duracao} min</td>
            <td>
                
                <a href="?editar&id={$row.id}&data={$row.data|date_format:"%d/%m/%Y"}" class="icon-pencil" title="Editar registro"></a>
                <a href="#" class="icon-remove" title="Remover da escala" onclick="exclui('{$row.id}', '{$row.data|date_format:"%d/%m/%Y"}')" ></a>
                {if $row.lote eq "1"}
                    <a href="?ordem=-1&lote={$row.lote}&data={$row.data|date_format:"%d/%m/%Y"}" class="icon-arrow-down"></a>
                {else if $smarty.foreach.esc.last eq 1}
                    <a href="?ordem=1&lote={$row.lote}&data={$row.data|date_format:"%d/%m/%Y"}" class="icon-arrow-up"></a>
                {else}
                    <a href="?ordem=1&lote={$row.lote}&data={$row.data|date_format:"%d/%m/%Y"}" class="icon-arrow-up"></a>
                    <a href="?ordem=-1&lote={$row.lote}&data={$row.data|date_format:"%d/%m/%Y"}" class="icon-arrow-down" ></a>
                {/if}
            </td>
        </tr>
        {/foreach}
        
        </tbody>
    </table>
</div>
                            
{/if}
</html>
