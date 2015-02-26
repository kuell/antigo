{if $smarty.get.lanc|default:"" eq ""}
    {include file="../../view/topo.tpl"}
{/if}
<h1>Inclusão</h1>
<div class="well form-search">
<ul class="nav nav-pills">
  {foreach from=$grupo item=g}
<li class="active">
       <a href="?addItem&idTaxa={$smarty.get.grupo}&g={$g.id}" rel="superbox[iframe][1000x500]" > {$g.descricao}</a>
  </li>
    {/foreach}
</ul>
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
                        <th>Tipo de Movimento</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$item item=i key=a }
                    <tr>
                        <td>{$i.grupo}</td>
                        <td>{$i.item}</td>
                        <td>{$i.qtd|string_format:"%.2f"}</td>
                        <td>{$i.peso|string_format:"%.2f"}</td>
                        <td>{$i.valor|string_format:"%.2f"}</td>
                        <td>{if $i.tipo eq "d"}
                                A RECEBER
                            {else if $i.tipo eq "c"}
                                A PAGAR
                            {else}
                                INFORMATIVO
                            {/if}
                        </td>
                    </tr>
                </tbody>
            {/foreach}
           </table>
    </div>
{include file="../../view/rodape.tpl"}