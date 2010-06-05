<script language="Javascript" type="text/javascript" src="editarea/edit_area_full.js"></script>
<script language="Javascript" type="text/javascript" src="editarea/templates.js"></script>

<div id="pageHeaderTitle" style="padding-top:7px;">
	<div class="h_tpl">&nbsp;</div>
	{if $smarty.request.action=='new'}
		<div class="HeaderTitle"><h2>{#TEMPLATES_TITLE_NEW#}</h2></div>
		<div class="HeaderText">{#TEMPLATES_WARNING2#}</div>
	{else}
		<div class="HeaderTitle"><h2>{#TEMPLATES_TITLE_EDIT#}<span style="color:#000;">&nbsp;&gt;&nbsp;{$row->TplName|escape:html}{$smarty.request.TempName|escape:html}</span></h2></div>
		<div class="HeaderText">{#TEMPLATES_WARNING1#}</div>
	{/if}
</div>
<div class="upPage">&nbsp;</div><br />

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	{if $smarty.request.action=='new'}
		<tr>
			<td class="tableheader">{#TEMPLATES_LOAD_INFO#}</td>
		</tr>

		<tr>
			<td class="first">
				<form action="index.php?do=templates&action=new" method="post">
					<select name="theme_pref">
						<option></option>
						{$sel_theme}
					</select>
					<input type="hidden" name="TempName" value="{$smarty.request.TempName|escape:html}">
					<input type="submit" class="button" value="{#TEMPLATES_BUTTON_LOAD#}">
				</form>
			</td>
		</tr>
	{/if}

	<form name="f_tpl" id="f_tpl" method="post" action="{$formaction}">
		{assign var=js_form value='f_tpl'}
		<tr>
			<td class="tableheader">{#TEMPLATES_NAME#}</td>
		</tr>

		<tr class="{cycle name='ta' values='first,second'}">
			<td>
				{foreach from=$errors item=message}
					<ul>
						<li>{$message}</li>
					</ul>
				{/foreach}
				<input name="TplName" type="text" value="{$row->TplName|default:$smarty.request.TempName|escape:html}" size="50" maxlength="50" >
			</td>
		</tr>

		<tr>
			<td class="tableheader">{#TEMPLATES_HTML#}</td>
		</tr>

		<tr>
			<td class="second">
				{if $php_forbidden==1}
					<div class="infobox_error">{#TEMPLATES_USE_PHP#} </div>
				{/if}

				<textarea {$read_only} class="{if $php_forbidden==1}tpl_code_readonly{/if}" wrap="off" style="width:100%; height:500px" name="Template" id="Template">{$row->Template|default:$prefab|escape:html}</textarea>
				<div class="infobox">
					{assign var=js_textfeld value='Template'}
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<ol>', '</ol>');">OL</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<ul>', '</ul>');">UL</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<li>', '</li>');">LI</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<p>', '</p>');">P</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<strong>', '</strong>');">B</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<em>', '</em>');">I</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<h1>', '</h1>');">H1</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<h2>', '</h2>');">H2</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<h3>', '</h3>');">H3</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<div>', '</div>');">DIV</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<pre>', '</pre>');">PRE</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<br />', '');">BR</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '\t', '');">TAB</a>&nbsp;|
				</div>
			</td>
		</tr>

		<tr>
			<td class="second">
				<table width="100%" border="0" cellspacing="1" cellpadding="4">
					<col width="250"></col>
					<tr class="tableheader">
						<td class="first">{#TEMPLATES_TAGS#}</td>
						<td class="first">{#TEMPLATES_TAG_DESC#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:theme:',']');">[cp:theme:folder]</a>
						</td>
						<td class="first">{#TEMPLATES_THEME_FOLDER#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:pagename]','');">[cp:pagename]</a>
						</td>
						<td class="first">{#TEMPLATES_PAGENAME#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:title]','');">[cp:title]</a>
						</td>
						<td class="first">{#TEMPLATES_TITLE#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:keywords]','');">[cp:keywords]</a>
						</td>
						<td class="first">{#TEMPLATES_KEYWORDS#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:description]','');">[cp:description]</a>
						</td>
						<td class="first">{#TEMPLATES_DESCRIPTION#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:indexfollow]','');">[cp:indexfollow]</a>
						</td>
						<td class="first">{#TEMPLATES_INDEXFOLLOW#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:path]','');">[cp:path]</a>
						</td>
						<td class="first">{#TEMPLATES_PATH#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:mediapath]','');">[cp:mediapath]</a>
						</td>
						<td class="first">{#TEMPLATES_MEDIAPATH#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:maincontent]','');">[cp:maincontent]</a>
						</td>
						<td class="first">{#TEMPLATES_MAINCONTENT#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:quickfinder]','');">[cp:quickfinder]</a>
						</td>
						<td class="first">{#TEMPLATES_QUICKFINDER#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:document]','');">[cp:document]</a>
						</td>
						<td class="first">{#TEMPLATES_DOCUMENT#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:printlink]','');">[cp:printlink]</a>
						</td>
						<td class="first">{#TEMPLATES_PRINTLINK#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:home]','');">[cp:home]</a>
						</td>
						<td class="first">{#TEMPLATES_HOME#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:version]','');">[cp:version]</a>
						</td>
						<td class="first">{#TEMPLATES_VERSION#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[mod_navigation:',']');">[mod_navigation:õõõ]</a>
						</td>
						<td class="first">{#TEMPLATES_NAVIGATION#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:if_print]\n','\n[/cp:if_print]');">[cp:if_print][/cp:if_print]</a>
						</td>
						<td class="first">{#TEMPLATES_IF_PRINT#}</td>
					</tr>

					<tr>
						<td class="first">
							<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:donot_print]\n','\n[/cp:donot_print]');">[cp:donot_print][/cp:donot_print]</a>
						</td>
						<td class="first">{#TEMPLATES_DONOT_PRINT#}</td>
					</tr>
{*
					{foreach from=$tags item=tag}
						<tr>
							<td class="first">
								<a title="{#TEMPLATES_TAG_INSERT#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '{$tag->cp_tag}','');">{$tag->cp_tag}</a>
							</td>
							<td class="first">{$tag->cp_desc}</td>
						</tr>
					{/foreach}
*}
				</table>
			</td>
		</tr>

		<tr class="{cycle name='ta' values='first,second'}">
			<td class="second">
				<input type="hidden" name="Id" value="{$smarty.request.Id}">
				<input class="button" type="submit" value="{if $smarty.request.action=='new'}{#TEMPLATES_BUTTON_ADD#}{else}{#TEMPLATES_BUTTON_SAVE#}{/if}" />
			</td>
		</tr>
	</form>
</table>