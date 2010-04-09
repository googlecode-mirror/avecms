
<!-- queries.tpl -->
{strip}

<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_query"></div>
	<div class="HeaderTitle"><h2>{#QUERY_TITLE#}</h2></div>
	<div class="HeaderText">{#QUERY_TIP#}</div>
</div>

<script language="javascript">
function copyQuery(page) {ldelim}
	var dname = window.prompt('{#QUERY_PLEASE_NAME#}', '');
	if (dname=='' || dname==null) {ldelim}
		alert('{#QUERY_COPY_FAILED#}');
		return false;
	{rdelim} else {ldelim}
		window.location.href = page + '&cname=' + dname;
	{rdelim}
{rdelim}
</script>

{if checkPermission('abfragen_neu')}
<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('QueryName').value == '') {ldelim}
		alert("{#QUERY_ENTER_NAME#}");
		document.getElementById('QueryName').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>

<h4>{#QUERY_NEW#}</h4>
<form method="post" action="index.php?do=queries&amp;action=new&amp;cp={$sess}" onSubmit="return check_name();">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="second">
				{#QUERY_NAME3#}&nbsp;
				<input type="text" id="QueryName" name="QueryName" value="" style="width: 250px;">&nbsp;
				<input type="submit" class="button" value="{#QUERY_BUTTON_ADD#}" />
			</td>
		</tr>
	</table>
</form>
{/if}

<h4>{#QUERY_ALL#}</h4>

<table width="100%" border="0" cellspacing="1" cellpadding="8">
	<tr class="tableheader">
		<td width="10">{#QUERY_ID#}</td>
		<td scope="row">{#QUERY_NAME#}</td>
		<td width="2%" scope="row">{#QUERY_SYSTEM_TAG#}</td>
		<td scope="row">{#QUERY_AUTHOR#}</td>
		<td scope="row">{#QUERY_DATE_CREATE#}</td>
		<td colspan="4">{#QUERY_ACTIONS#}</td>
	</tr>

	{foreach from=$items item=item}
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td width="10" class="itcen">{$item->Id}</td>

			<td>
				<a title="{$item->Beschreibung|stripslashes|default:#QUERY_NO_DESCRIPTION#}" href="index.php?do=queries&amp;action=edit&amp;Id={$item->Id}&amp;cp={$sess}&amp;RubrikId={$item->RubrikId}">
					<strong>{$item->Titel|escape:html|stripslashes}</strong>
				</a>
			</td>

			<td width="2%"><input name="aiid" readonly type="text" id="aiid" value="[cprequest:{$item->Id}]"></td>

			<td>{$item->Autor}</td>

			<td class="time">
				{$item->Erstellt|date_format:$TIME_FORMAT|pretty_date:$DEF_LANGUAGE}
			</td>

			<td width="1%" align="center">
				<a title="{#QUERY_EDIT#}" href="index.php?do=queries&amp;action=edit&amp;Id={$item->Id}&amp;cp={$sess}&amp;RubrikId={$item->RubrikId}">
					<img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" />
				</a>
			</td>

			<td width="1%" align="center">
				<a title="{#QUERY_CONDITION_EDIT#}" onclick="cp_pop('index.php?do=queries&action=konditionen&RubrikId={$item->RubrikId}&Id={$item->Id}&pop=1&cp={$sess}','750','600','1')" href="javascript:void(0);">
					<img src="{$tpl_dir}/images/icon_query.gif" alt="" border="0" />
				</a>
			</td>

			<td width="1%" align="center">
				{if checkPermission('abfragen_neu')}
					<a title="{#QUERY_COPY#}" onClick="copyQuery('index.php?do=queries&action=copy&Id={$item->Id}&cp={$sess}&RubrikId={$item->RubrikId}');" href="javascript:void(0);">
						<img src="{$tpl_dir}/images/icon_copy.gif" alt="" border="0" />
					</a>
				{else}
					<img src="{$tpl_dir}/images/icon_copy_no.gif" alt="" border="0" />
				{/if}
			</td>

			<td width="1%" align="center">
				{if checkPermission('abfragen_loesch')}
					<a title="{#QUERY_DELETE#}" onclick="return confirm('{#QUERY_DELETE_CONFIRM#}');" href="index.php?do=queries&action=delete_query&RubrikId={$item->RubrikId}&Id={$item->Id}&cp={$sess}">
						<img src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" />
					</a>
				{else}
					<img src="{$tpl_dir}/images/icon_delete_no.gif" alt="" border="0" />
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
		<img class="absmiddle" src="{$tpl_dir}/images/arrow.gif" alt="" border="0" /> <strong>{#QUERY_LEGEND#}</strong><br />
		<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /> - {#QUERY_EDIT#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_query.gif" alt="" border="0" /> - {#QUERY_CONDITION_EDIT#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_copy.gif" alt="" border="0" /> - {#QUERY_COPY#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /> - {#QUERY_DELETE#}
	</div>
</div><br />

{if $page_nav}
	<div class="infobox">{$page_nav}</div>
	<br />
{/if}

{/strip}
<!-- /queries.tpl -->
