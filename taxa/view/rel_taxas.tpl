{include file="../../view/topo.tpl"}
<div class="well form-search">
    <form class="form-horizontal">
        <fieldset>
            <legend>Relatorio de Taxas</legend>
  <div class="control-group">
    <label class="control-label">Corretor: </label>
    <div class="controls">
        <select name="cor" id="cor">
            <option value="0">Todos ...</option>
            {foreach from=$cor item=corr}
                <option value="{$corr.cor_id}">{$corr.cor_cod} - {$corr.cor_nome}</option>
            {/foreach}
        </select>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Data: </label>
    <div class="controls">
        <input type="text" id="dataI" class="validate[required] data" value="{$smarty.now|date_format:"01/%m/%Y"}"> até
        <input type="text" id="dataF" class="validate[required] data" value="{$smarty.now|date_format:"%d/%m/%Y"}">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
        <button type="button" class="btn" onclick="window.open('rel_taxa.php?cor='+document.getElementById('cor').value+'&datai='+document.getElementById('dataI').value+'&dataf='+document.getElementById('dataF').value,'Print', 'channelmode=yes')">Buscar</button>
    </div>
  </div>
    </fieldset>
</form>
    
</div>

{include file="../../view/rodape.tpl"}