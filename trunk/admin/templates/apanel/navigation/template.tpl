<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_navi">&nbsp;</div>
	{if $smarty.request.action == 'new'}
		<div class="HeaderTitle">
			<h2>{#NAVI_SUB_TITLE4#}</h2>
		</div>
	{else}
		<div class="HeaderTitle">
			<h2>{#NAVI_SUB_TITLE3#}<span style="color: #000;">&nbsp;&gt;&nbsp;{$nav->navi_titel|escape}</span></h2>
		</div>
	{/if}
	<div class="HeaderText">{#NAVI_TIP_TEMPLATE2#}</div>
</div>
<div class="upPage">&nbsp;</div><br />

<form name="navitemplate" method="post" action="{$formaction}">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td width="200" class="first"><strong>{#NAVI_TITLE#}</strong></td>
			<td class="second"><input style="width:400px" name="navi_titel" type="text" id="navi_titel" value="{$nav->navi_titel|default:$smarty.request.NaviName|escape}"></td>
		</tr>

		<tr>
			<td width="200" class="first"><strong>{#NAVI_EXPAND#}</strong></td>
			<td class="second"><input name="navi_expand" type="checkbox" id="navi_expand" value="1" {if $nav->navi_expand==1}checked{/if}></td>
		</tr>

		<tr>
			<td width="200" class="first">{#NAVI_GROUPS#}</td>
			<td class="second">
				<select  name="navi_user_group[]" multiple="multiple" size="5" style="width:200px">
					{if $smarty.request.action=='new'}
						{foreach from=$row->AvGroups item=g}
							<option value="{$g->user_group}" selected="selected">{$g->user_group_name|escape}</option>
						{/foreach}
					{else}
						{foreach from=$nav->AvGroups item=g}
							{assign var='sel' value=''}
							{if $g->user_group}
								{if (in_array($g->user_group, $nav->navi_user_group))}
									{assign var='sel' value=' selected="selected"'}
								{/if}
							{/if}
							<option value="{$g->user_group}"{$sel}>{$g->user_group_name|escape}</option>
						{/foreach}
					{/if}
				</select>
			</td>
		</tr>

		<tr>
			<td width="200" class="first"><strong>{#NAVI_HEADER_START#}</strong><br />{#NAVI_HEADER_TIP#}</td>
			<td class="second"><textarea style="width:100%" name="navi_begin" rows="4" id="navi_begin">{$nav->navi_begin|escape}</textarea></td>
		</tr>

		<tr>
			<td width="200" class="first"><strong>{#NAVI_FOOTER_END#}</strong><br />{#NAVI_FOOTER_TIP#}</td>
			<td class="second"><textarea style="width:100%" name="navi_end" rows="4" id="navi_end">{$nav->navi_end|escape}</textarea></td>
		</tr>

		<tr>
			<td colspan="2" class="tableheader">{#NAVI_LEVEL1#}</td>
		</tr>

		<tr>
			<td class="first"><strong>{#NAVI_HTML_START#}</strong></td>
			<td class="second"><input style="width:400px" name="navi_level1begin" type="text" id="navi_level1begin" value="{$nav->navi_level1begin|escape}" /></td>
		</tr>

		<tr>
			<td class="first"><strong>{#NAVI_HTML_END#}</strong></td>
			<td class="second"><input style="width:400px" name="navi_level1end" type="text" id="navi_level1end" value="{$nav->navi_level1end|escape}" /></td>
		</tr>

		<tr>
			<td width="200" class="first">
				<strong>{#NAVI_LINK_INACTIVE#}</strong><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:cp_insert('[tag:target]','navi_level1', 'navitemplate');">[tag:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:cp_insert('[tag:link]','navi_level1', 'navitemplate');">[tag:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:cp_insert('[tag:linkname]','navi_level1', 'navitemplate');">[tag:linkname]</a>
			</td>
			<td class="second"><textarea style="width:100%" name="navi_level1" rows="4" id="navi_level1">{$nav->navi_level1|escape}</textarea></td>
		</tr>

		<tr>
			<td width="200" class="first">
				<strong>{#NAVI_LINK_ACTIVE#}</strong><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:cp_insert('[tag:target]','navi_level1active', 'navitemplate');">[tag:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:cp_insert('[tag:link]','navi_level1active', 'navitemplate');">[tag:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:cp_insert('[tag:linkname]','navi_level1active', 'navitemplate');">[tag:linkname]</a>
			</td>
			<td class="second"><textarea style="width:100%" name="navi_level1active" rows="4" id="navi_level1active">{$nav->navi_level1active|escape}</textarea></td>
		</tr>

		<tr>
			<td colspan="2" class="tableheader">{#NAVI_LEVEL2#}</td>
		</tr>

		<tr>
			<td class="first"><strong>{#NAVI_HTML_START#}</strong></td>
			<td class="second"><input style="width:400px" name="navi_level2begin" type="text" id="navi_level2begin" value="{$nav->navi_level2begin|escape}" /></td>
		</tr>

		<tr>
			<td class="first"><strong>{#NAVI_HTML_END#}</strong></td>
			<td class="second"><input style="width:400px" name="navi_level2end" type="text" id="navi_level2end" value="{$nav->navi_level2end|escape}" /></td>
		</tr>

		<tr>
			<td width="200" class="first">
				<strong>{#NAVI_LINK_INACTIVE#}</strong><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:cp_insert('[tag:target]','navi_level2', 'navitemplate');">[tag:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:cp_insert('[tag:link]','navi_level2', 'navitemplate');">[tag:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:cp_insert('[tag:linkname]','navi_level2', 'navitemplate');">[tag:linkname]</a>
			</td>
			<td class="second"><textarea style="width:100%" name="navi_level2" rows="4" id="navi_level2">{$nav->navi_level2|escape}</textarea></td>
		</tr>

		<tr>
			<td class="first">
				<strong>{#NAVI_LINK_ACTIVE#}</strong><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:cp_insert('[tag:target]','navi_level2active', 'navitemplate');">[tag:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:cp_insert('[tag:link]','navi_level2active', 'navitemplate');">[tag:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:cp_insert('[tag:linkname]','navi_level2active', 'navitemplate');">[tag:linkname]</a>
			</td>
			<td class="second"><textarea style="width:100%" name="navi_level2active" rows="4" id="navi_level2active">{$nav->navi_level2active|escape}</textarea></td>
		</tr>

		<tr>
			<td colspan="2" class="tableheader">{#NAVI_LEVEL3#}</td>
		</tr>

		<tr>
			<td class="first"><strong>{#NAVI_HTML_START#}</strong></td>
			<td class="second"><input style="width:400px" name="navi_level3begin" type="text" id="navi_level3begin" value="{$nav->navi_level3begin|escape}" /></td>
		</tr>

		<tr>
			<td class="first"><strong>{#NAVI_HTML_END#}</strong></td>
			<td class="second"><input style="width:400px" name="navi_level3end" type="text" id="navi_level3end" value="{$nav->navi_level3end|escape}" /></td>
		</tr>

		<tr>
			<td class="first">
				<strong>{#NAVI_LINK_INACTIVE#}</strong><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:cp_insert('[tag:target]','navi_level3', 'navitemplate');">[tag:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:cp_insert('[tag:link]','navi_level3', 'navitemplate');">[tag:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:cp_insert('[tag:linkname]','navi_level3', 'navitemplate');">[tag:linkname]</a>
			</td>
			<td class="second"><textarea style="width:100%" name="navi_level3" rows="4" id="navi_level3">{$nav->navi_level3|escape}</textarea></td>
		</tr>

		<tr>
			<td class="first">
				<strong>{#NAVI_LINK_ACTIVE#}</strong><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:cp_insert('[tag:target]','navi_level3active', 'navitemplate');">[tag:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:cp_insert('[tag:link]','navi_level3active', 'navitemplate');">[tag:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:cp_insert('[tag:linkname]','navi_level3active', 'navitemplate');">[tag:linkname]</a>
			</td>
			<td class="second"><textarea style="width:100%" name="navi_level3active" rows="4" id="navi_level3active">{$nav->navi_level3active|escape}</textarea></td>
		</tr>
	</table><br />

	<input accesskey="s" type="submit" class="button" value="{#NAVI_BUTTON_SAVE#}" />
</form>
