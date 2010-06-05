<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#ModName#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div>
{include file="$source/download_topnav.tpl"}
<h4>{#DownloadOverview#}</h4>

<div class="infobox" style="padding:0px">
  <form  method="post" action="index.php?do=modules&action=modedit&mod=download&moduleaction=overview&cp={$sess}">
    <table width="100%" border="0" cellpadding="8" cellspacing="1">
      <tr>
        <td width="120" class="first"><label for="pq">{#SearchWord#}</label></td>
        <td width="100" class="second"><input class="mod_shop_inputfields" style="width:150px" name="dl_query" id="pq" type="text" value="{$smarty.request.dl_query|stripslashes|escape:html}" />        </td>
        <td width="130" align="right" class="first"><label for="pc">{#ProductCategs#}</label></td>
        <td class="second"><select style="width:150px" name="KatId">
          <option value="Alle">{#All#}</option>

{foreach from=$Categs item=pc}

          <option value="{$pc->Id}" {if $pc->Elter == 0}style="font-weight:bold"{/if} {if $pc->Id==$smarty.request.KatId}selected="selected"{/if}>{$pc->visible_title}</option>

{/foreach}

        </select></td>
      </tr>

      <tr>
        <td width="120" class="first">{#ActiveInactive#}</td>
        <td width="100" class="second">
		<label><input type="radio" name="Aktiv" value="Alle"  {if $smarty.request.Aktiv=='' || $smarty.request.Aktiv=='Alle'}checked{/if}/>{#All#}</label>
		<label><input type="radio" name="Aktiv" value="1" {if $smarty.request.Aktiv=='1'}checked="checked"{/if}  />{#Active#}</label>
		<label><input type="radio" name="Aktiv" value="0" {if $smarty.request.Aktiv=='0'}checked="checked"{/if}  />{#InActive#}</label>		</td>
        <td align="right" class="first"><label for="rs">{#Recordset#}</label>        </td>
        <td class="second"><select class="mod_shop_inputfields" name="recordset" id="rs">

{section name=recordset loop=200}
	{assign var=sel value=''}
	{if $smarty.request.recordset == ''}
		{if $smarty.section.recordset.index+1==$recordset}
		{assign var=sel value='selected'}
		{/if}
		{else}
		{if $smarty.section.recordset.index+1==$smarty.request.recordset}
		{assign var=sel value='selected'}
	{/if}
	{/if}

            <option value="{$smarty.section.recordset.index+1}" {$sel}>{$smarty.section.recordset.index+1}</option>

{/section}

          </select>
		  <input type="hidden" name="page" value="{$smarty.request.page|default:1}" />
        <input name="submit" type="submit" class="button" value="{#ButtonSearch#}" /></td>
      </tr>
    </table>
  </form>
</div>
<br>
<form  name="kform" action="index.php?do=modules&action=modedit&mod=download&moduleaction=overview&cp={$sess}&sub=save" method="post">
  <table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
    <tr class="tableheader">
      <td><input name="allbox" type="checkbox" id="d" onclick="selall();" value="" /></td>
      <td><a class="header" href="index.php?do=modules&action=modedit&mod=download&moduleaction=overview&cp={$sess}&recordset={$smarty.request.recordset|default:$recordset}&sort={if $smarty.request.sort=='name_desc'}name_asc{else}name_desc{/if}{$search_string}{$search_categ_string}{$aktiv_categ_string}">{#DlTitle#}</a></td>
      <td><a class="header" href="index.php?do=modules&action=modedit&mod=download&moduleaction=overview&cp={$sess}&recordset={$smarty.request.recordset|default:$recordset}&sort={if $smarty.request.sort=='categ_desc'}categ_asc{else}categ_desc{/if}{$search_string}{$search_categ_string}{$aktiv_categ_string}">{#DlCateg#}</a></td>
      <td><a class="header" href="index.php?do=modules&action=modedit&mod=download&moduleaction=overview&cp={$sess}&recordset={$smarty.request.recordset|default:$recordset}&sort={if $smarty.request.sort=='categ_desc'}categ_asc{else}categ_desc{/if}{$search_string}{$search_categ_string}{$aktiv_categ_string}">Остаток платежа</a></td>
      <td><a class="header" href="index.php?do=modules&action=modedit&mod=download&moduleaction=overview&cp={$sess}&recordset={$smarty.request.recordset|default:$recordset}&sort={if $smarty.request.sort=='download_desc'}download_asc{else}download_desc{/if}{$search_string}{$search_categ_string}{$aktiv_categ_string}">{#DlDownloads#}</a></td>
      <td align="center"><a class="header" href="index.php?do=modules&action=modedit&mod=download&moduleaction=overview&cp={$sess}&recordset={$smarty.request.recordset|default:$recordset}&sort={if $smarty.request.sort=='datum_desc'}datum_asc{else}datum_desc{/if}{$search_string}{$search_categ_string}{$aktiv_categ_string}">{#DlCreated#}</a></td>
      <td align="center"><a class="header" href="index.php?do=modules&action=modedit&mod=download&moduleaction=overview&cp={$sess}&recordset={$smarty.request.recordset|default:$recordset}&sort={if $smarty.request.sort=='geaendert_desc'}geaendert_asc{else}geaendert_desc{/if}{$search_string}{$search_categ_string}{$aktiv_categ_string}">{#DLChanged#}</a></td>
      <td>{#DlUp#}</td>
      <td>{#DlForPayOk#}</td>
      <td>{#DlVipPay#}</td>
      <td>{#DlDownload#}</td>
      <td width="1%" colspan="3" align="center">{#DlAction#}</td>
    </tr>
    {foreach from=$Files item=i}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
      <td width="1%"><input title="{#DlmarkDel#}" type="checkbox" name="Del[{$i->Id}]" value="1">      </td>
      <td width="180">
	  <input style="width:180px" type="text" name="Name[{$i->Id}]" value="{$i->Name|stripslashes}" />
	  </td>
      <td width="1%" align="center">
<select style="width:150px" name="KatId[{$i->Id}]">
{*foreach from=$i->Categ item=pc*}
{foreach from=$Categs item=pc}
<option value="{$pc->Id}" {if $pc->Elter == 0}style="font-weight:bold"{/if} {if $pc->Id==$i->KatId}selected="selected"{/if}>{$pc->visible_title}</option>
{/foreach}
</select>
	  </td>
	    <td width="1%" align="center" nowrap="nowrap">{$i->Pay} {if $i->Pay_val == 0}${else}руб.{/if}</td>

      <td width="1%" align="center" nowrap="nowrap">{$i->Downloads}</td>
      <td width="1%" nowrap="nowrap"><span class="itcen">{$i->Datum|date_format:$TIME_FORMAT|pretty_date}</span>

	  <br />
	  <small>
	  <a href="#" onclick="cp_pop('index.php?do=user&action=edit&Id={$i->Autor_Erstellt}&cp={$sess}&pop=1');">{$i->Author}</a>
	  </small>
	  </td>
	<td width="1%" nowrap="nowrap">
	  {if $i->Geaendert}
	  <span class="itcen">{$i->Geaendert|date_format:$TIME_FORMAT|pretty_date}</span> <br />
	  <small><a href="#" onclick="cp_pop('index.php?do=user&action=edit&Id={$i->Autor_Erstellt}&cp={$sess}&pop=1');">{$i->AuthorG}</a></small>
	  {else}
	  &nbsp;
	  {/if}
	</td>
	<td width="1%">
	{if $i->Pay_Type == 0}
	{#Yes#}
	{else}
	{#No#}
	{/if}
	</td>
	<td width="1%">
	{if $i->Only_Pay == 1}
	{#Yes#}
	{else}
	{#No#}
	{/if}
	</td>
	</td>
	<td width="1%">
	{if $i->Excl_Pay == 1}
	{#Yes#}
	{else}
	{#No#}
	{/if}
	</td>
	</td>
	<td width="1%">
	{if $i->Excl_Chk == 1}
	{#Yes#}
	{else}
	{#No#}
	{/if}
	</td>
	<td>
	  <!-- AKTIONEN -->
	  <a title="{#DlEdit#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=download&moduleaction=edit&cp={$sess}&pop=1&Id={$i->Id}','980','740','1','edit_download');">
	  <img src="{$tpl_dir}/images/icon_edit.gif" alt="{#DokEdit#}" border="0" />
	  </a>
</td><td>
	  {if $i->Aktiv == 1}
	 <a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=download&moduleaction=setmodus&cp={$sess}&Status=off&Id={$i->Id}','1','1','1','status')" title="{#SetOffline#}"><img src="{$tpl_dir}/images/icon_unlock.gif" alt="" border="0" /></a>
	  {else}
	  <a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=download&moduleaction=setmodus&cp={$sess}&Status=on&Id={$i->Id}','1','1','1','status')" title="{#SetOnline#}"><img src="{$tpl_dir}/images/icon_lock.gif" alt="" border="0" /></a>
	  {/if}
</td><td>
	  {if $i->Comments>=1}
	  <a title="{#EditComments#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=download&moduleaction=editcomments&cp={$sess}&pop=1&Id={$i->Id}','980','740','1','edit_download');">
	  <img src="{$tpl_dir}/images/icon_iscomment.gif" alt="{#EditComments#}" border="0" />
	  </a>
	  {else}<img src="{$tpl_dir}/images/icon_blank.gif" border="0" />{/if}
	  </td>
    </tr>
    {/foreach}
  </table>
  <br />

<input type="hidden" name="page" value="{$smarty.request.page|default:1}" />
  <input class="button" type="submit" value="{#ButtonSave#}" />
</form>
<br />
<br />
{$page_nav}