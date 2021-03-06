<script language="Javascript" type="text/javascript">
$(document).ready(function(){ldelim}
	$('#doc_search').hide();
{rdelim});
</script>

<link rel="stylesheet" href="{$tpl_dir}/js/jquery/plugin/jquery-ui-time.css" type="text/css">	
<script src="{$tpl_dir}/js/jquery/plugin/jquery-ui-time.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){ldelim}
		$('#document_published').datepicker({ldelim}
			timeOnlyTitle: 'Выберите время',
			timeText: 'Время',
			hourText: 'Часы',
			minuteText: 'Минуты',
			secondText: 'Секунды',
			currentText: 'Теперь',
			closeText: 'Закрыть',
			
			onClose: function(dateText, inst) {ldelim}
	        var endDateTextBox = $('#document_expire');
	        if (endDateTextBox.val() != '') {ldelim}
	            var testStartDate = new Date(dateText);
	            var testEndDate = new Date(endDateTextBox.val());
	            if (testStartDate > testEndDate)
	                endDateTextBox.val(dateText);
	        {rdelim}
	        else {ldelim}
	            endDateTextBox.val(dateText);
	        {rdelim}
		    {rdelim},
		    onSelect: function (selectedDateTime){ldelim}
		        var start = $(this).datetimepicker('getDate');
		        $('#document_expire').datetimepicker('option', 'minDate', new Date(start.getTime()));
		    {rdelim}
		{rdelim});
		
		
		$('#document_expire').datepicker({ldelim}
			timeOnlyTitle: 'Выберите время',
			timeText: 'Время',
			hourText: 'Часы',
			minuteText: 'Минуты',
			secondText: 'Секунды',
			currentText: 'Теперь',
			closeText: 'Закрыть',
			
			onClose: function(dateText, inst) {ldelim}
	        var startDateTextBox = $('#document_published');
	        if (startDateTextBox.val() != '') {ldelim}
	            var testStartDate = new Date(startDateTextBox.val());
	            var testEndDate = new Date(dateText);
	            if (testStartDate > testEndDate)
	                startDateTextBox.val(dateText);
	        {rdelim}
	        else {ldelim}
	            startDateTextBox.val(dateText);
	        {rdelim}
	    {rdelim},
	    onSelect: function (selectedDateTime){ldelim}
	        var end = $(this).datetimepicker('getDate');
	        $('#document_published').datetimepicker('option', 'maxDate', new Date(end.getTime()) );
	    {rdelim}
		{rdelim});	
	{rdelim});
</script>
	
<table cellspacing="1" cellpadding="8" border="0" width="100%">
	<tr>
		<td class="second">
			<div id="otherLinks">
				<a href="javascript:void(0);" onclick="$('#doc_search').toggle();">
					<div class="taskTitle">{#MAIN_SEARCH_DOCUMENTS#}</div>
				</a>
			</div>
		</td>
	</tr>
</table>

<form method="get" id="doc_search" action="index.php">
	<input type="hidden" name="do" value="docs" />
	{if $smarty.request.action}<input type="hidden" name="action" value="{$smarty.request.action}" />
	{/if}{if $smarty.request.target}<input type="hidden" name="target" value="{$smarty.request.target}" />
	{/if}{if $smarty.request.doc}<input type="hidden" name="doc" value="{$smarty.request.doc}" />
	{/if}{if $smarty.request.document_alias}<input type="hidden" name="document_alias" value="{$smarty.request.document_alias}" />
	{/if}{if $smarty.request.selurl}<input type="hidden" name="selurl" value="{$smarty.request.selurl}" />
	{/if}{if $smarty.request.idonly}<input type="hidden" name="idonly" value="{$smarty.request.idonly}" />
	{/if}{if $smarty.request.sort}<input type="hidden" name="sort" value="{$smarty.request.sort}" />
	{/if}{if $smarty.request.pop}<input type="hidden" name="pop" value="{$smarty.request.pop}" />
	{/if}<input type="hidden" name="TimeSelect" value="1" />
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="first">
			<td rowspan="2" class="second"><strong>{#MAIN_TIME_PERIOD#}</strong></td>
			<td nowrap="nowrap">
				<input id="document_published" name="document_published" type="text" value="{$smarty.request.document_published|date_format:"%d.%m.%Y"}" />
			</td>
			<td class="second"><strong>{#MAIN_TITLE_SEARCH#}</strong></td>
			<td nowrap="nowrap">
				<input style="width:160px" type="text" name="QueryTitel" value="{$smarty.request.QueryTitel|escape|stripslashes}" />&nbsp;
				<input style="cursor:help" title="{#MAIN_SEARCH_HELP#}" type="button" class="button" value="?" />
			</td>
			<td class="second"><strong>{#MAIN_SELECT_RUBRIK#}</strong></td>
			<td>
				<select name="rubric_id" style="width:185px">
					<option value="all">{#MAIN_ALL_RUBRUKS#}</option>
					{foreach from=$rubrics item=rubric}
						<option value="{$rubric->Id}" {if $smarty.request.rubric_id==$rubric->Id}selected{/if}>{$rubric->rubric_title|escape}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr class="first">
			<td nowrap="nowrap">
				<input id="document_expire" name="document_expire" type="text" value="{$smarty.request.document_expire|date_format:"%d.%m.%Y"}" />
			</td>
			<td class="second"><strong>{#MAIN_ID_SEARCH#}</strong></td>
			<td><input style="width:160px" type="text" name="doc_id" value="{$smarty.request.doc_id|escape|stripslashes}" /></td>
			<td class="second"><strong>{#MAIN_DOCUMENT_STATUS#}</strong></td>
			<td>
				<select style="width:185px" name="status">
					<option value="All">{#MAIN_ALL_DOCUMENTS#}</option>
					<option value="Opened" {if $smarty.request.status=='Opened'}selected{/if}>{#MAIN_DOCUMENT_ACTIVE#}</option>
					<option value="Closed" {if $smarty.request.status=='Closed'}selected{/if}>{#MAIN_DOCUMENT_INACTIVE#}</option>
					<option value="Deleted" {if $smarty.request.status=='Deleted'}selected{/if}>{#MAIN_TEMP_DELETE_DOCS#}</option>
				</select>
			</td>
		</tr>

		<tr class="first">
			<td colspan="6" class="second"><strong>{#MAIN_RESULTS_ON_PAGE#}</strong>&nbsp;
				<select style="width:95px" name="Datalimit">
					{section loop=150 name=dl step=15}
						<option value="{$smarty.section.dl.index+15}" {if $smarty.request.Datalimit==$smarty.section.dl.index+15}selected{/if}>{$smarty.section.dl.index+15}</option>
					{/section}
				</select>
				&nbsp;
				<input style="width:85px" type="submit" class="button" value="{#MAIN_BUTTON_SEARCH#}" />
			</td>
		</tr>
	</table>
	<input type="hidden" name="cp" value="{$sess}" />
</form>
