<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr class="tableheader">
		<td colspan="2">{#SettingsMain#}&nbsp;</td>
	</tr>
	<tr>
		<td width="200" class="first">{#Can_Comment#}</td>
		<td class="second">
			<input type="radio" name="can_comment" id="can_comment" value="1" {if $row->can_comment==1}checked{/if} />{#Yes#}
			<input type="radio" name="can_comment" id="can_comment" value="0" {if $row->can_comment!=1}checked{/if} />{#No#}
		</td>
	</tr>
	<tr>
		<td width="200" valign="top" class="first">
			{#PermInf#}
			<br />
			<small>{#MultiInf#}</small>
		</td>
		<td class="second">
			<select style="width:200px" name="user_group[]" size="5" multiple="multiple">
				{foreach from=$groups item=group}
					<option value="{$group->user_group}"{if @in_array($group->user_group, $groups_form)} selected="selected"{/if}>{$group->user_group_name}</option>
				{/foreach}
			</select>
		</td>
	</tr>
</table>
