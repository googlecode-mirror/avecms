<div id="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_query">&nbsp;</div>
    <div class="HeaderTitle"><h2>{#REQUEST_CONDITIONS#}<span style="color: #000;">&nbsp;&gt;&nbsp;{$QureyName|escape:html|stripslashes}</span></h2></div>
    <div class="HeaderText">{#REQUEST_CONDITION_TIP#}</div>
</div>
<div class="upPage">&nbsp;</div><br />

<form action="index.php?do=request&action=konditionen&sub=save&RubrikId={$smarty.request.RubrikId|escape|stripslashes}&Id={$smarty.request.Id|escape|stripslashes}&pop=1&cp={$sess}" method="post">
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
    {if $afkonditionen}
      <tr class="tableheader">
        <td width="1"><img src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /></td>
        <td>{#REQUEST_FROM_FILED#}</td>
        <td>{#REQUEST_OPERATOR#}</td>
        <td>{#REQUEST_VALUE#}</td>
      </tr>
    {/if}

    {foreach name=cond from=$afkonditionen item=condition}
      <tr class="{cycle name='k' values='first,second'}">
        <td width="1"><input title="{#REQUEST_MARK_DELETE#}" name="del[{$condition->Id}]" type="checkbox" id="del_{$condition->Id}" value="1"></td>

        <td width="200">
          <select name="Feld[{$condition->Id}]" id="Feld_{$condition->Id}" style="width:200px">
          {foreach from=$felder item=feld}
            <option value="{$feld->Id}" {if $condition->Feld==$feld->Id}selected{/if}>{$feld->Titel|escape:html|stripslashes}</option>
          {/foreach}
          </select>
        </td>

        <td width="150">
          <select style="width:150px" name="Operator[{$condition->Id}]" id="Operator_{$condition->Id}">
            <option value="==" {if $condition->Operator=='=='}selected{/if}>{#REQUEST_COND_SELF#}</option>
            <option value="!=" {if $condition->Operator=='!='}selected{/if}>{#REQUEST_COND_NOSELF#}</option>
            <option value="%%" {if $condition->Operator=='%%'}selected{/if}>{#REQUEST_COND_USE#}</option>
            <option value="--" {if $condition->Operator=='--'}selected{/if}>{#REQUEST_COND_NOTUSE#}</option>
            <option value="%" {if $condition->Operator=='%'}selected{/if}>{#REQUEST_COND_START#}</option>
            <option value="<=" {if $condition->Operator=='<='}selected{/if}>{#REQUEST_SMALL1#}</option>
            <option value=">=" {if $condition->Operator=='>='}selected{/if}>{#REQUEST_BIG1#}</option>
            <option value="<" {if $condition->Operator=='<'}selected{/if}>{#REQUEST_SMALL2#}</option>
            <option value=">" {if $condition->Operator=='>'}selected{/if}>{#REQUEST_BIG2#}</option>

          </select>
        </td>

        <td><input style="width:200px" name="Wert[{$condition->Id}]" type="text" id="Wert_{$condition->Id}" value="{$condition->Wert|escape}" /> {if !$smarty.foreach.cond.last}{if $condition->Oper=='AND'}{#REQUEST_CONR_AND#}{else}{#REQUEST_CONR_OR#}{/if}{/if}</td>
      </tr>
    {/foreach}
   </table>
<h4>{#REQUEST_NEW_CONDITION#}</h4>
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
      <tr class="tableheader">
        <td colspan="2">{#REQUEST_FROM_FILED#}</td>
        <td>{#REQUEST_OPERATOR#}</td>
        <td>{#REQUEST_VALUE#}</td>
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
            <option value="==" {if $condition->Operator=='=='}selected{/if}>{#REQUEST_COND_SELF#}</option>
            <option value="!=" {if $condition->Operator=='!='}selected{/if}>{#REQUEST_COND_NOSELF#}</option>
            <option value="%%" {if $condition->Operator=='%%'}selected{/if}>{#REQUEST_COND_USE#}</option>
            <option value="--" {if $condition->Operator=='--'}selected{/if}>{#REQUEST_COND_NOTUSE#}</option>
            <option value="%" {if $condition->Operator=='%'}selected{/if}>{#REQUEST_COND_START#}</option>
            <option value="<=" {if $condition->Operator=='<='}selected{/if}>{#REQUEST_SMALL1#}</option>
            <option value=">=" {if $condition->Operator=='>='}selected{/if}>{#REQUEST_BIG1#}</option>
            <option value="<" {if $condition->Operator=='<'}selected{/if}>{#REQUEST_SMALL2#}</option>
            <option value=">" {if $condition->Operator=='>'}selected{/if}>{#REQUEST_BIG2#}</option>
          </select>
        </td>

        <td class="first"><input style="width:200px" name="Wert_Neu" type="text" id="Wert_Neu" value="" /> <select style="width:60px" name="Oper_Neu" id="Oper_Neu"><option value="OR" {if $condition->Oper=='OR'}selected{/if}>{#REQUEST_CONR_OR#}</option><option value="AND" {if $condition->Oper=='AND'}selected{/if}>{#REQUEST_CONR_AND#}</option></select></td>
      </tr>
   </table>

<br />
<div style="padding:5px">
  <input type="submit" value="{#BUTTON_SAVE#}" class="button" />
  <input onclick="self.close();" type="button" class="button" value="{#REQUEST_BUTTON_CLOSE#}" />
</div>
</form>
