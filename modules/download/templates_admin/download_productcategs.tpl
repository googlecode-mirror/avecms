<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#ModName#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div>
{include file="$source/download_topnav.tpl"}
<h4>{#ProductCategs#}</h4>
<form action="index.php?do=modules&action=modedit&mod=download&moduleaction=categs&cp={$sess}&sub=save" method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
  <tr class="tableheader">
    <td width="10%" nowrap="nowrap">{#ProductCategsName#}</td>
    <td align="center" width="10%">{#ProductCategsPosition#}</td>
    <td align="center" width="1%" colspan="3">{#ProductCategsActions#}</td>
	<td>&nbsp;</td>
    </tr>
  {foreach from=$ProductCategs item=ss}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
    <td width="10%" nowrap="nowrap">
	{if $ss->Elter != 0}
	{$ss->expander}&raquo;
	{/if}
	<input style="width:400px;border: solid 1px #ccc;{if $ss->Elter == 0}font-weight:bold; background:#ffffcc{/if}" name="KatName[{$ss->Id}]" type="text" value="{$ss->KatName|escape:html|stripslashes}">
	</td>
    <td width="50" align="center">
      <input name="Rang[{$ss->Id}]" type="text" style="width:40px;border: solid 1px #ccc;{if $ss->Elter == 0}font-weight:bold; background:#ffffcc"{/if}" value="{$ss->Rang}" />
	  </td>
    <td>
	<a title="{#ProductCategEEdit#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=download&moduleaction=edit_categ&cp={$sess}&pop=1&Id={$ss->Id}','980','740','1','edit_categ');"><img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
</td>
    <td>
<a title="{#ProductCategChild#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=download&moduleaction=new_categ&cp={$sess}&pop=1&Id={$ss->Id}','980','740','1','new_categ');"><img src="{$tpl_dir}/images/icon_7.gif" alt="" border="0" /></a>
</td>
    <td>
	<a onclick="return confirm('{#ConfirmDelCateg#}');" title="{#ProductCategEDelCateg#}" href="index.php?do=modules&action=modedit&mod=download&moduleaction=delcateg&Id={$ss->Id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" /></a>
</td>
    <td>
&nbsp;
</td>
    </tr>
  {/foreach}
 </table>
 <br />
 <input type="submit" class="button" value="{#ButtonSave#}">
</form>

<br />
{if $page_nav}
<br />
{$page_nav}
<br />
{/if}