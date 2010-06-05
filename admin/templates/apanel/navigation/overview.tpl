<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_navi">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#NAVI_SUB_TITLE#}</h2></div>
	<div class="HeaderText">{#NAVI_TIP_TEMPLATE#}</div>
</div>

{if check_permission('navigation_new')}
<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('NaviName').value == '') {ldelim}
		alert("{#NAVI_ENTER_NAME#}");
		document.getElementById('NaviName').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>

<h4>{#NAVI_NEW_MENU#}</h4>
<form method="post" action="index.php?do=navigation&amp;action=new&amp;cp={$sess}" onSubmit="return check_name();">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="second">
				{#NAVI_TITLE2#}&nbsp;
				<input type="text" id="NaviName" name="NaviName" value="" style="width:250px" />&nbsp;
				<input type="submit" class="button" value="{#NAVI_BUTTON_ADD_MENU#}" />
			</td>
		</tr>
	</table>
</form>
{/if}

<h4>{#NAVI_ALL#}</h4>
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr class="tableheader">
		<td width="10">{#NAVI_ID#}</td>
		<td>{#NAVI_NAME#}</td>
		<td>{#NAVI_SYSTEM_TAG#}</td>
		<td colspan="4">{#NAVI_ACTIONS#}</td>
	</tr>

	{foreach from=$mod_navis item=item}
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td width="10" class="itcen">{$item->id}</td>
			<td>
				<strong>
					{if check_permission('navigation_edit')}
						<a title="{#NAVI_EDIT_ITEMS#}" href="index.php?do=navigation&amp;action=entries&amp;cp={$sess}&amp;id={$item->id}">{$item->titel|escape:html|stripslashes}</a>
					{else}
						{$item->titel|escape:html|stripslashes}
					{/if}
				</strong>
			</td>
			<td><input type="text" value="[mod_navigation:{$item->id}]" size="15" readonly></td>
			<td width="1%" align="center">
				{if check_permission('navigation_edit')}
					<a title="{#NAVI_EDIT_TEMPLATE#}" href="index.php?do=navigation&amp;action=templates&amp;cp={$sess}&amp;id={$item->id}"><img src="{$tpl_dir}/images/icon_template.gif" alt="" border="0"  /></a>
				{else}
					<img src="{$tpl_dir}/images/icon_template_no.gif" alt="" border="0"  />
				{/if}
			</td>
			<td width="1%" align="center">
				{if check_permission('navigation_edit')}
					<a title="{#NAVI_EDIT_ITEMS#}" href="index.php?do=navigation&amp;action=entries&amp;cp={$sess}&amp;id={$item->id}"><img src="{$tpl_dir}/images/icon_navigation.gif" alt="" border="0" /></a>
				{else}
					<img src="{$tpl_dir}/images/icon_navigation_no.gif" alt="" border="0" />
				{/if}
			</td>
			<td width="1%" align="center">
				{if check_permission('navigation_new')}
					<a title="{#NAVI_COPY_TEMPLATE#}" href="index.php?do=navigation&amp;action=copy&amp;cp={$sess}&amp;id={$item->id}"><img src="{$tpl_dir}/images/icon_copy.gif" alt="" border="0" /></a>
				{else}
					<img src="{$tpl_dir}/images/icon_copy_no.gif" alt="" border="0" />
				{/if}
			</td>
			<td width="1%" align="center">
				{if $item->id==1}
					<img src="{$tpl_dir}/images/icon_delete_no.gif" alt="" border="0" />
				{else}
					{if check_permission('navigation_edit')}
						<a title="{#NAVI_DELETE#}" onclick="return confirm('{#NAVI_DELETE_CONFIRM#}');" href="index.php?do=navigation&amp;action=delete&amp;cp={$sess}&amp;id={$item->id}"><img src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /></a>
					{else}
						<img src="{$tpl_dir}/images/icon_delete_no.gif" alt="" border="0" />
					{/if}
				{/if}
			</td>
		</tr>
	{/foreach}
</table><br />
<br />

<div class="iconHelpSegmentBox">
	<div class="segmentBoxHeader">
		<div class="segmentBoxTitle">&nbsp;</div>
	</div>
	<div class="segmentBoxContent">
		<img class="absmiddle" src="{$tpl_dir}/images/arrow.gif" alt="" border="0" /> <strong>{#NAVI_LEGEND#}</strong><br />
		<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_template.gif" alt="" border="0" /> - {#NAVI_EDIT_TEMPLATE#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_navigation.gif" alt="" border="0" /> - {#NAVI_EDIT_ITEMS#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_copy.gif" alt="" border="0" /> - {#NAVI_COPY_TEMPLATE#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /> - {#NAVI_DELETE#}
	</div>
</div>