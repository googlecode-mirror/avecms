{strip}

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr class="tableheader">
		<td colspan="2">{#POLL_SETTINGS_TITLE#}</td>
	</tr>

	<tr>
		<td width="200" class="first">{#POLL_NAME#}:</td>
		<td class="second">
			<input name="poll_name" type="text" id="poll_name" value="{$row->title}" size="50" />
		</td>
	</tr>

	<tr>
		<td width="200" class="first">{#POLL_STATUS#}?</td>
		<td class="second">
			<input type="radio" name="active" id="active" value="1" {if $row->active==1}checked{/if} />{#POLL_YES#}
			<input type="radio" name="active" id="active" value="0" {if $row->active!=1}checked{/if} />{#POLL_NO#}
		</td>
	</tr>

	<tr>
		<td width="200" class="first">{#POLL_CAN_COMMENT#}</td>
		<td class="second">
			<input type="radio" name="can_comment" id="can_comment" value="1" {if $row->can_comment==1}checked{/if} />{#POLL_YES#}
			<input type="radio" name="can_comment" id="can_comment" value="0" {if $row->can_comment!=1}checked{/if} />{#POLL_NO#}
		</td>
	</tr>

	<tr>
		<td width="200" class="first">{#POLL_START_TIME#}</td>
		<td class="second">
			<select name="s_day">
				{section name=s_day loop=32 start=1}
					<option value="{$smarty.section.s_day.index}" {if $s_day == $smarty.section.s_day.index or $day == $smarty.section.s_day.index}selected{/if}>
						{$smarty.section.s_day.index}
					</option>
				{/section}
			</select>

			<select name="s_mon">
				{section name=s_mon loop=13 start=1}
					<option value="{$smarty.section.s_mon.index}"{if $s_mon == $smarty.section.s_mon.index or $mon == $smarty.section.s_mon.index} selected{/if}>{$smarty.section.s_mon.index}</option>
				{/section}
			</select>

			<select name="s_year">
				{section name=s_year loop=$year+10 start=$year-2}
					<option value="{$smarty.section.s_year.index}"{if $s_year == $smarty.section.s_year.index or $year == $smarty.section.s_year.index} selected{/if}>{$smarty.section.s_year.index}</option>
				{/section}
			</select>

			&nbsp;-&nbsp;

			<select name="s_hour">
				{section name=s_hour loop=24 start=0}
					<option value="{$smarty.section.s_hour.index}"{if $s_hour == $smarty.section.s_hour.index or $hour == $smarty.section.s_hour.index} selected{/if}>{$smarty.section.s_hour.index}</option>
				{/section}
			</select>

			<select name="s_min">
				{section name=s_min loop=60 start=0}
					<option value="{$smarty.section.s_min.index}"{if $s_min == $smarty.section.s_min.index or $min == $smarty.section.s_min.index} selected{/if}>{$smarty.section.s_min.index}</option>
				{/section}
			</select>
		</td>
	</tr>

	<tr>
		<td width="200" class="first">{#POLL_END_TIME#}</td>
		<td class="second">
			<select name="e_day">
				{section name=e_day loop=32 start=1}
					<option value="{$smarty.section.e_day.index}"{if $e_day == $smarty.section.e_day.index or $day == $smarty.section.e_day.index} selected{/if}>{$smarty.section.e_day.index}</option>
				{/section}
			</select>

			<select name="e_mon">
				{section name=e_mon loop=13 start=1}
					<option value="{$smarty.section.e_mon.index}"{if $e_mon == $smarty.section.e_mon.index or $mon == $smarty.section.e_mon.index} selected{/if}>{$smarty.section.e_mon.index}</option>
				{/section}
			</select>

			<select name="e_year">
				{section name=e_year loop=$year+10 start=$year-2}
					<option value="{$smarty.section.e_year.index}"{if $e_year == $smarty.section.e_year.index or $year == $smarty.section.e_year.index} selected{/if}>{$smarty.section.e_year.index}</option>
				{/section}
			</select>

			&nbsp;-&nbsp;

			<select name="e_hour">
				{section name=e_hour loop=24 start=0}
					<option value="{$smarty.section.e_hour.index}"{if $e_hour == $smarty.section.e_hour.index or $hour == $smarty.section.e_hour.index} selected{/if}>{$smarty.section.e_hour.index}</option>
				{/section}
			</select>

			<select name="e_min">
				{section name=e_min loop=60 start=0}
					<option value="{$smarty.section.e_min.index}"{if $e_min == $smarty.section.e_min.index or $min == $smarty.section.e_min.index} selected{/if}>{$smarty.section.e_min.index}</option>
				{/section}
			</select>
		</td>
	</tr>

	<tr>
		<td width="200" valign="top" class="first">{#POLL_USER_GROUPS#}<br />	<small>{#POLL_GROUP_INFO#}</small></td>
		<td class="second">
			<select style="width:200px"  name="groups[]" size="5" multiple="multiple">
				{foreach from=$groups item=group}
					<option value="{$group->Benutzergruppe}" {if @in_array($group->Benutzergruppe, $groups_form) || $smarty.request.moduleaction=="new"}selected="selected"{/if}>{$group->Name}</option>
				{/foreach}
			</select>
		</td>
	</tr>

	{if $smarty.request.id == ''}
		<tr>
			<td class="second" colspan="2"><input type="submit" class="button" value="{#POLL_BUTTON_SAVE#}" /></td>
		</tr>
	{/if}

</table>

{/strip}