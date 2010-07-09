<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_query"></div>
	<div class="HeaderTitle"><h2>{#REQUEST_TITLE#}</h2></div>
	<div class="HeaderText">{#REQUEST_TIP#}</div>
</div>

<script language="javascript">
function copyQuery(page) {ldelim}
	var dname = window.prompt('{#REQUEST_PLEASE_NAME#}', '');
	if (dname=='' || dname==null) {ldelim}
		alert('{#REQUEST_COPY_FAILED#}');
		return false;
	{rdelim} else {ldelim}
		window.location.href = page + '&cname=' + dname;
	{rdelim}
{rdelim}
</script>

{if check_permission('request_new')}
<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('request_title_new').value == '') {ldelim}
		alert("{#REQUEST_ENTER_NAME#}");
		document.getElementById('request_title_new').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>

<h4>{#REQUEST_NEW#}</h4>
<form method="post" action="index.php?do=request&amp;action=new&amp;cp={$sess}" onSubmit="return check_name();">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="second">
				{#REQUEST_NAME3#}&nbsp;
				<input type="text" id="request_title_new" name="request_title_new" value="" style="width: 250px;">&nbsp;
				<input type="submit" class="button" value="{#REQUEST_BUTTON_ADD#}" />
			</td>
		</tr>
	</table>
</form>
{/if}

<h4>{#REQUEST_ALL#}</h4>

<table width="100%" border="0" cellspacing="1" cellpadding="8">
	<tr class="tableheader">
		<td width="10">{#REQUEST_ID#}</td>
		<td scope="row">{#REQUEST_NAME#}</td>
		<td width="2%" scope="row">{#REQUEST_SYSTEM_TAG#}</td>
		<td scope="row">{#REQUEST_AUTHOR#}</td>
		<td scope="row">{#REQUEST_DATE_CREATE#}</td>
		<td colspan="4">{#REQUEST_ACTIONS#}</td>
	</tr>

	{foreach from=$items item=item}
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td width="10" class="itcen">{$item->Id}</td>

			<td>
				<a title="{$item->request_description|escape|default:#REQUEST_NO_DESCRIPTION#}" href="index.php?do=request&amp;action=edit&amp;Id={$item->Id}&amp;cp={$sess}&amp;rubric_id={$item->rubric_id}">
					<strong>{$item->request_title|escape}</strong>
				</a>
			</td>

			<td width="2%"><input name="aiid" readonly type="text" id="aiid" value="[tag:request:{$item->Id}]"></td>

			<td>{$item->request_author|escape}</td>

			<td class="time">
				{$item->request_created|date_format:$TIME_FORMAT|pretty_date}
			</td>

			<td width="1%" align="center">
				<a title="{#REQUEST_EDIT#}" href="index.php?do=request&amp;action=edit&amp;Id={$item->Id}&amp;cp={$sess}&amp;rubric_id={$item->rubric_id}">
					<img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" />
				</a>
			</td>

			<td width="1%" align="center">
				<a title="{#REQUEST_CONDITION_EDIT#}" onclick="cp_pop('index.php?do=request&action=konditionen&rubric_id={$item->rubric_id}&Id={$item->Id}&pop=1&cp={$sess}','750','600','1')" href="javascript:void(0);">
					<img src="{$tpl_dir}/images/icon_query.gif" alt="" border="0" />
				</a>
			</td>

			<td width="1%" align="center">
				{if check_permission('request_new')}
					<a title="{#REQUEST_COPY#}" onClick="copyQuery('index.php?do=request&action=copy&Id={$item->Id}&cp={$sess}&rubric_id={$item->rubric_id}');" href="javascript:void(0);">
						<img src="{$tpl_dir}/images/icon_copy.gif" alt="" border="0" />
					</a>
				{else}
					<img src="{$tpl_dir}/images/icon_copy_no.gif" alt="" border="0" />
				{/if}
			</td>

			<td width="1%" align="center">
				{if check_permission('request_del')}
					<a title="{#REQUEST_DELETE#}" onclick="return confirm('{#REQUEST_DELETE_CONFIRM#}');" href="index.php?do=request&action=delete_query&rubric_id={$item->rubric_id}&Id={$item->Id}&cp={$sess}">
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
		<img class="absmiddle" src="{$tpl_dir}/images/arrow.gif" alt="" border="0" /> <strong>{#REQUEST_LEGEND#}</strong><br />
		<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /> - {#REQUEST_EDIT#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_query.gif" alt="" border="0" /> - {#REQUEST_CONDITION_EDIT#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_copy.gif" alt="" border="0" /> - {#REQUEST_COPY#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /> - {#REQUEST_DELETE#}
	</div>
</div><br />

{if $page_nav}
	<div class="infobox">{$page_nav}</div>
	<br />
{/if}