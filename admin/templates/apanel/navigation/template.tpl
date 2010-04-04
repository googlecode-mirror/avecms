<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_navi">&nbsp;</div>
	{if $smarty.request.action == 'new'}
		<div class="HeaderTitle">
			<h2>{#NAVI_SUB_TITLE4#}</h2>
		</div>
	{else}
		<div class="HeaderTitle">
			<h2>{#NAVI_SUB_TITLE3#}<span style="color: #000;">&nbsp;&gt;&nbsp;{$nav->titel|escape}</span></h2>
		</div>
	{/if}
	<div class="HeaderText">{#NAVI_TIP_TEMPLATE2#}</div>
</div>
<div class="upPage">&nbsp;</div><br />

<form name="navitemplate" method="post" action="{$formaction}">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td width="200" class="first"><strong>{#NAVI_TITLE#}</strong></td>
			<td class="second"><input style="width:400px" name="titel" type="text" id="titel" value="{$nav->titel|escape}"></td>
		</tr>

		<tr>
			<td width="200" class="first"><strong>{#NAVI_EXPAND#}</strong></td>
			<td class="second"><input name="Expand" type="checkbox" id="Expand" value="1" {if $nav->Expand==1}checked{/if}></td>
		</tr>

		<tr>
			<td width="200" class="first">{#NAVI_GROUPS#}</td>
			<td class="second">
				{if $smarty.request.action=='new'}
					<select  name="Gruppen[]"  multiple="multiple" size="5" style="width:200px">
						{foreach from=$row->AvGroups item=g}
							<option value="{$g->Benutzergruppe}" selected>{$g->Name|escape}</option>
						{/foreach}
					</select>
				{else}
					<select  name="Gruppen[]"  multiple="multiple" size="5" style="width:200px">
						{foreach from=$nav->AvGroups item=g}
							{assign var='sel' value=''}
							{if $g->Benutzergruppe}
								{if (in_array($g->Benutzergruppe,$nav->Gruppen)) }
									{assign var='sel' value='selected'}
								{/if}
							{/if}
							<option value="{$g->Benutzergruppe}" {$sel}>{$g->Name|escape}</option>
						{/foreach}
					</select>
				{/if}
			</td>
		</tr>

		<tr>
			<td width="200" class="first"><strong>{#NAVI_HEADER_START#}</strong><br />{#NAVI_HEADER_TIP#}</td>
			<td class="second"><textarea style="width:100%" name="vor" rows="4" id="vor">{$nav->vor|escape}</textarea></td>
		</tr>

		<tr>
			<td width="200" class="first"><strong>{#NAVI_FOOTER_END#}</strong><br />{#NAVI_FOOTER_TIP#}</td>
			<td class="second"><textarea style="width:100%" name="nach" rows="4" id="nach">{$nav->nach|escape}</textarea></td>
		</tr>

		<tr>
			<td colspan="2" class="tableheader">{#NAVI_LEVEL1#}</td>
		</tr>

		<tr>
			<td class="first"><strong>{#NAVI_HTML_START#}</strong></td>
			<td class="second"><input style="width:400px" name="ebene1_v" type="text" id="ebene1_v" value="{$nav->ebene1_v|escape}" /></td>
		</tr>

		<tr>
			<td class="first"><strong>{#NAVI_HTML_END#}</strong></td>
			<td class="second"><input style="width:400px" name="ebene1_n" type="text" id="ebene1_n" value="{$nav->ebene1_n|escape}" /></td>
		</tr>

		<tr>
			<td width="200" class="first">
				<strong>{#NAVI_LINK_INACTIVE#}</strong><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:cp_insert('[cp:target]','ebene1', 'navitemplate');">[cp:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:cp_insert('[cp:link]','ebene1', 'navitemplate');">[cp:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:cp_insert('[cp:linkname]','ebene1', 'navitemplate');">[cp:linkname]</a>
			</td>
			<td class="second"><textarea style="width:100%" name="ebene1" rows="4" id="ebene1">{$nav->ebene1|escape}</textarea></td>
		</tr>

		<tr>
			<td width="200" class="first">
				<strong>{#NAVI_LINK_ACTIVE#}</strong><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:cp_insert('[cp:target]','ebene1a', 'navitemplate');">[cp:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:cp_insert('[cp:link]','ebene1a', 'navitemplate');">[cp:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:cp_insert('[cp:linkname]','ebene1a', 'navitemplate');">[cp:linkname]</a>
			</td>
			<td class="second"><textarea style="width:100%" name="ebene1a" rows="4" id="ebene1a">{$nav->ebene1a|escape}</textarea></td>
		</tr>

		<tr>
			<td colspan="2" class="tableheader">{#NAVI_LEVEL2#}</td>
		</tr>

		<tr>
			<td class="first"><strong>{#NAVI_HTML_START#}</strong></td>
			<td class="second"><input style="width:400px" name="ebene2_v" type="text" id="ebene2_v" value="{$nav->ebene2_v|escape}" /></td>
		</tr>

		<tr>
			<td class="first"><strong>{#NAVI_HTML_END#}</strong></td>
			<td class="second"><input style="width:400px" name="ebene2_n" type="text" id="ebene2_n" value="{$nav->ebene2_n|escape}" /></td>
		</tr>

		<tr>
			<td width="200" class="first">
				<strong>{#NAVI_LINK_INACTIVE#}</strong><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:cp_insert('[cp:target]','ebene2', 'navitemplate');">[cp:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:cp_insert('[cp:link]','ebene2', 'navitemplate');">[cp:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:cp_insert('[cp:linkname]','ebene2', 'navitemplate');">[cp:linkname]</a>
			</td>
			<td class="second"><textarea style="width:100%" name="ebene2" rows="4" id="ebene2">{$nav->ebene2|escape}</textarea></td>
		</tr>

		<tr>
			<td class="first">
				<strong>{#NAVI_LINK_ACTIVE#}</strong><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:cp_insert('[cp:target]','ebene2a', 'navitemplate');">[cp:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:cp_insert('[cp:link]','ebene2a', 'navitemplate');">[cp:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:cp_insert('[cp:linkname]','ebene2a', 'navitemplate');">[cp:linkname]</a>
			</td>
			<td class="second"><textarea style="width:100%" name="ebene2a" rows="4" id="ebene2a">{$nav->ebene2a|escape}</textarea></td>
		</tr>

		<tr>
			<td colspan="2" class="tableheader">{#NAVI_LEVEL3#}</td>
		</tr>

		<tr>
			<td class="first"><strong>{#NAVI_HTML_START#}</strong></td>
			<td class="second"><input style="width:400px" name="ebene3_v" type="text" id="ebene3_v" value="{$nav->ebene3_v|escape}" /></td>
		</tr>

		<tr>
			<td class="first"><strong>{#NAVI_HTML_END#}</strong></td>
			<td class="second"><input style="width:400px" name="ebene3_n" type="text" id="ebene3_n" value="{$nav->ebene3_n|escape}" /></td>
		</tr>

		<tr>
			<td class="first">
				<strong>{#NAVI_LINK_INACTIVE#}</strong><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:cp_insert('[cp:target]','ebene3', 'navitemplate');">[cp:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:cp_insert('[cp:link]','ebene3', 'navitemplate');">[cp:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:cp_insert('[cp:linkname]','ebene3', 'navitemplate');">[cp:linkname]</a>
			</td>
			<td class="second"><textarea style="width:100%" name="ebene3" rows="4" id="ebene3">{$nav->ebene3|escape}</textarea></td>
		</tr>

		<tr>
			<td class="first">
				<strong>{#NAVI_LINK_ACTIVE#}</strong><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:cp_insert('[cp:target]','ebene3a', 'navitemplate');">[cp:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:cp_insert('[cp:link]','ebene3a', 'navitemplate');">[cp:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:cp_insert('[cp:linkname]','ebene3a', 'navitemplate');">[cp:linkname]</a>
			</td>
			<td class="second"><textarea style="width:100%" name="ebene3a" rows="4" id="ebene3a">{$nav->ebene3a|escape}</textarea></td>
		</tr>
	</table><br />

	<input accesskey="s" type="submit" class="button" value="{#NAVI_BUTTON_SAVE#}" />
</form>
