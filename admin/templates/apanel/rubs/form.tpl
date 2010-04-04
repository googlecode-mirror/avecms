<script language="Javascript" type="text/javascript" src="editarea/edit_area_full.js"></script>
<script language="Javascript" type="text/javascript" src="editarea/rubrics.js"></script>
{strip}

<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_rubs">&nbsp;</div>
	{if $smarty.request.action=='new'}
		<div class="HeaderTitle"><h2>{#RUBRIK_TEMPLATE_NEW#}<span style="color: #000;"> &gt; {$row->RubrikName}</span></h2></div>
	{else}
		<div class="HeaderTitle"><h2>{#RUBRIK_TEMPLATE_EDIT#}<span style="color: #000;"> &gt; {$row->RubrikName}</span></h2></div>
	{/if}
	<div class="HeaderText">{#RUBRIK_TEMPLATE_TIP#}</div>
</div>
<div class="upPage">&nbsp;</div><br />

<form name="f_tpl" id="f_tpl" method="post" action="{$formaction}">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		{if $errors}
			<tr>
				<td class="tableheader">{#RUBRIK_HTML#}</td>
			</tr>

			<tr class="{cycle name='ta' values='first,second'}">
				<td>
				{foreach from=$errors item=e}
					{assign var=message value=$e}
					<ul>
						<li>{$message}</li>
					</ul>
				{/foreach}
				</td>
			</tr>
		{/if}

		<tr>
			<td class="tableheader">{#RUBRIK_HTML#}</td>
		</tr>

		<tr>
			<td class="second">
				{if $php_forbidden==1}
					<div class="infobox_error">{#RUBRIK_PHP_DENIDED#} </div>
				{/if}

				<textarea {$read_only} class="{if $php_forbidden==1}tpl_code_readonly{else}{/if}" wrap="off" style="width:100%; height:350px" name="RubrikTemplate" id="RubrikTemplate">{$row->RubrikTemplate|default:$prefab|escape:html}</textarea>

				<div class="infobox">
					{assign var=js_textfeld value='RubrikTemplate'}
					{assign var=js_form value='f_tpl'}|&nbsp;
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
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '\t', '');">TAB</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:title]', '');">[cp:title]</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:mediapath]', '');">[cp:mediapath]</a>&nbsp;|&nbsp;
					<a title="{#RUBRIK_VIEWS_INFO#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[views]', '');">[views]</a>&nbsp;|&nbsp;
					<a title="{#RUBRIK_HIDE_INFO#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[hide:', ']\n\n[/hide]');">[hide:X,X][/hide]</a>&nbsp;|
				</div>
			</td>
		</tr>

		<tr>
			<td class="second" style="padding:0px">
				<table width="100%" border="0" cellspacing="1" cellpadding="4">
					<tr class="tableheader">
						<td width="10%">{#RUBRIK_ID#}</td>
						<td width="20%">{#RUBRIK_FIELD_NAME#}</td>
						<td width="30%">{#RUBRIK_FIELD_TYPE#}</td>
						<td>&nbsp;</td>
					</tr>

					{foreach from=$tags item=tag}
						<tr>
							<td width="10%" class="first"><a title="{#RUBRIK_INSERT_HELP#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cprub:{$tag->Id}]', '');">[cprub:{$tag->Id}]</a></td>
							<td width="10%" class="first"><strong>{$tag->Titel}</strong></td>
							<td width="10%" class="first">
								{section name=feld loop=$feld_array}
									{if $tag->RubTyp == $feld_array[feld].id}{$feld_array[feld].name}{/if}
								{/section}
							</td>
							<td class="first">&nbsp;</td>
						</tr>
					{/foreach}
				</table>
			</td>
		</tr>

		<tr class="{cycle name='ta' values='first,second'}">
			<td class="second">
				<input type="hidden" name="Id" value="{$smarty.request.Id}">
				<input class="button" type="submit" value="{#RUBRIK_BUTTON_TPL#}" />
			</td>
		</tr>
	</table>
</form>

{/strip}