<div id="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_query">&nbsp;</div>
    <div class="HeaderTitle"><h2>{#QUERY_CONDITIONS#}<span style="color: #000;">&nbsp;&gt;&nbsp;{$QureyName|escape:html|stripslashes}</span></h2></div>
    <div class="HeaderText">{#QUERY_CONDITION_TIP#}</div>
</div>
<div class="upPage">&nbsp;</div><br />

<form action="index.php?do=queries&action=konditionen&sub=save&RubrikId={$smarty.request.RubrikId}&Id={$smarty.request.Id}&pop=1&cp={$sess}" method="post">
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
    {if $afkonditionen}
      <tr class="tableheader">
        <td width="1"><img src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /></td>
        <td>{#QUERY_FROM_FILED#}</td>
        <td>{#QUERY_OPERATOR#}</td>
        <td>{#QUERY_VALUE#}</td>
      </tr>
    {/if}

    {foreach name=cond from=$afkonditionen item=kond}
      <tr class="{cycle name='k' values='first,second'}">
        <td width="1"><input title="{#QUERY_MARK_DELETE#}" name="del[{$kond->Id}]" type="checkbox" id="del_{$kond->Id}" value="1"></td>

        <td width="200">
          <select name="Feld[{$kond->Id}]" id="Feld_{$kond->Id}" style="width:200px">
          {foreach from=$felder item=feld}
            <option value="{$feld->Id}" {if $kond->Feld==$feld->Id}selected{/if}>{$feld->Titel|escape:html|stripslashes}</option>
          {/foreach}
          </select>
        </td>

        <td width="150">
          <select style="width:150px" name="Operator[{$kond->Id}]" id="Operator_{$kond->Id}">
            <option value="==" {if $kond->Operator=='=='}selected{/if}>{#QUERY_COND_SELF#}</option>
            <option value="!=" {if $kond->Operator=='!='}selected{/if}>{#QUERY_COND_NOSELF#}</option>
            <option value="%%" {if $kond->Operator=='%%'}selected{/if}>{#QUERY_COND_USE#}</option>
            <option value="--" {if $kond->Operator=='--'}selected{/if}>{#QUERY_COND_NOTUSE#}</option>
            <option value="%" {if $kond->Operator=='%'}selected{/if}>{#QUERY_COND_START#}</option>
            <option value="<=" {if $kond->Operator=='<='}selected{/if}>{#QUERY_SMALL1#}</option>
            <option value=">=" {if $kond->Operator=='>='}selected{/if}>{#QUERY_BIG1#}</option>
            <option value="<" {if $kond->Operator=='<'}selected{/if}>{#QUERY_SMALL2#}</option>
            <option value=">" {if $kond->Operator=='>'}selected{/if}>{#QUERY_BIG2#}</option>

          </select>
        </td>

        <td><input style="width:200px" name="Wert[{$kond->Id}]" type="text" id="Wert_{$kond->Id}" value="{$kond->Wert}" /> {if !$smarty.foreach.cond.last}{if $kond->Oper=='AND'}{#QUERY_CONR_AND#}{else}{#QUERY_CONR_OR#}{/if}{/if}</td>
      </tr>
    {/foreach}
   </table>
<h4>{#QUERY_NEW_CONDITION#}</h4>
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
      <tr class="tableheader">
        <td colspan="2">{#QUERY_FROM_FILED#}</td>
        <td>{#QUERY_OPERATOR#}</td>
        <td>{#QUERY_VALUE#}</td>
      </tr>

      <tr>
        <td width="1" class="first">&nbsp;</td>
        <td width="200" class="first">
          <select name="Feld_Neu" id="Feld_Neu" style="width:200px">
          {foreach from=$felder item=feld}
            <option value="{$feld->Id}">{$feld->Titel|escape:html|stripslashes}</option>
          {/foreach}
          </select>
        </td>

        <td width="150" class="first">
          <select style="width:150px" name="Operator_Neu" id="Operator_Neu">
            <option value="==" {if $kond->Operator=='=='}selected{/if}>{#QUERY_COND_SELF#}</option>
            <option value="!=" {if $kond->Operator=='!='}selected{/if}>{#QUERY_COND_NOSELF#}</option>
            <option value="%%" {if $kond->Operator=='%%'}selected{/if}>{#QUERY_COND_USE#}</option>
            <option value="--" {if $kond->Operator=='--'}selected{/if}>{#QUERY_COND_NOTUSE#}</option>
            <option value="%" {if $kond->Operator=='%'}selected{/if}>{#QUERY_COND_START#}</option>
            <option value="<=" {if $kond->Operator=='<='}selected{/if}>{#QUERY_SMALL1#}</option>
            <option value=">=" {if $kond->Operator=='>='}selected{/if}>{#QUERY_BIG1#}</option>
            <option value="<" {if $kond->Operator=='<'}selected{/if}>{#QUERY_SMALL2#}</option>
            <option value=">" {if $kond->Operator=='>'}selected{/if}>{#QUERY_BIG2#}</option>
          </select>
        </td>

        <td class="first"><input style="width:200px" name="Wert_Neu" type="text" id="Wert_Neu" value="" /> <select style="width:60px" name="Oper_Neu" id="Oper_Neu"><option value="OR" {if $kond->Oper=='OR'}selected{/if}>{#QUERY_CONR_OR#}</option><option value="AND" {if $kond->Oper=='AND'}selected{/if}>{#QUERY_CONR_AND#}</option></select></td>
      </tr>
   </table>

<br />
<div style="padding:5px">
  <input type="submit" value="{#BUTTON_SAVE#}" class="button" />
  <input onclick="self.close();" type="button" class="button" value="{#QUERY_BUTTON_CLOSE#}" />
</div>
</form>
