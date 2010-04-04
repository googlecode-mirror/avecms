{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#CONTACT_MODULE_NAME#}</h2></div>
	<div class="HeaderText">{#CONTACT_MODULE_INFO#}</div>
</div><br />

<div class="infobox">
	<a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=contact&moduleaction=new&cp={$sess}&pop=1','1000','850','1','modcontactnew');">{#CONTACT_CREATE_FORM#}</a>
</div><br />

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr class="tableheader">
		<td>{#CONTACT_FORM_NAME#} </td>
		<td>{#CONTACT_SYSTEM_TAG#}</td>
		<td>{#CONTACT_MESSAGES#}</td>
		<td colspan="2">{#CONTACT_ACTIONS#}</td>
	</tr>

	{foreach from=$items item=item}
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td>
				<a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=contact&moduleaction=edit&cp={$sess}&id={$item->Id}&pop=1','1000','850','1','modcontactedit');"><strong>{$item->form_name|stripslashes|escape:html}</strong></a>
			</td>

			<td>
				<input type="text" value="[mod_contact:{$item->Id}]" size="20" readonly>
			</td>

			<td>
				<a href="index.php?do=modules&action=modedit&mod=contact&moduleaction=showmessages_new&cp={$sess}&id={$item->Id}">{#CONTACT_NO_ANSWERED#}{$item->messages}</a> |
				<a href="index.php?do=modules&action=modedit&mod=contact&moduleaction=showmessages_old&cp={$sess}&id={$item->Id}">{#CONTACT_ANSWERED#}{$item->messages_new}</a>
			</td>

			<td width="1%" align="center">
				<a title="{#CONTACT_EDIT_FORM#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=contact&moduleaction=edit&cp={$sess}&id={$item->Id}&pop=1','1000','850','1','modcontactedit');"><img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
			</td>

			<td width="1%" align="center">
				<a onclick="return confirm('{#CONTACT_DELETE_CONFIRM#}');" title="{#CONTACT_DELETE_FORM#}" href="index.php?do=modules&action=modedit&mod=contact&moduleaction=delete&cp={$sess}&id={$item->Id}"><img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" /></a>
			</td>
		</tr>
	{/foreach}
</table><br />

{if $page_nav}
	<div class="infobox">{$page_nav}</div>
{/if}

{/strip}