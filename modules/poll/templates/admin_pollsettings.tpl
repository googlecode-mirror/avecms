
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<col width="200">
	<tr class="tableheader">
		<td colspan="2">{#POLL_SETTINGS_TITLE#}</td>
	</tr>
	<tr>
		<td class="first">{#POLL_NAME#}:</td>
		<td class="second">
			<input name="poll_name" type="text" id="poll_name" value="{$row->poll_title}" size="50" />
		</td>
	</tr>
	<tr>
		<td class="first">{#POLL_STATUS#}?</td>
		<td class="second">
			<input type="radio" name="poll_status" id="poll_status" value="1" {if $row->poll_status==1}checked{/if} />{#POLL_YES#}
			<input type="radio" name="poll_status" id="poll_status" value="0" {if $row->poll_status!=1}checked{/if} />{#POLL_NO#}
		</td>
	</tr>
	<tr>
		<td class="first">{#POLL_CAN_COMMENT#}</td>
		<td class="second">
			<input type="radio" name="poll_can_comment" id="poll_can_comment" value="1" {if $row->poll_can_comment==1}checked{/if} />{#POLL_YES#}
			<input type="radio" name="poll_can_comment" id="poll_can_comment" value="0" {if $row->poll_can_comment!=1}checked{/if} />{#POLL_NO#}
		</td>
	</tr>
	<tr>
		<td class="first">{#POLL_START_TIME#}</td>
		<td class="second">
			{html_select_date prefix="" field_array="sd" time=$start field_order="DMY" start_year="-10" end_year="+10"} -
			{html_select_time prefix="" field_array="st" time=$start use_24_hours=true display_seconds=false}
		</td>
	</tr>
	<tr>
		<td class="first">{#POLL_END_TIME#}</td>
		<td class="second">
			{html_select_date prefix="" field_array="ed" time=$end field_order="DMY" start_year="-10" end_year="+10"} -
			{html_select_time prefix="" field_array="et" time=$end use_24_hours=true display_seconds=false}
		</td>
	</tr>
	<tr>
		<td valign="top" class="first">{#POLL_USER_GROUPS#}<br /><small>{#POLL_GROUP_INFO#}</small></td>
		<td class="second">
			<select style="width:200px"  name="groups[]" size="5" multiple="multiple">
				{html_options options=$groups selected=$selected}
			</select>
		</td>
	</tr>
	{if $smarty.request.id == ''}
		<tr>
			<td class="second" colspan="2"><input type="submit" class="button" value="{#POLL_BUTTON_SAVE#}" /></td>
		</tr>
	{/if}
</table>
