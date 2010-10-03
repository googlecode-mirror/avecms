<script language="Javascript" type="text/javascript" src="editarea/edit_area_compressor.php"></script>
<script language="Javascript" type="text/javascript" src="editarea/rubrics.js"></script>

<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_rubs">&nbsp;</div>
	{if $smarty.request.action=='new'}
		<div class="HeaderTitle"><h2>{#RUBRIK_TEMPLATE_NEW#}<span style="color: #000;"> &gt; {$row->rubric_title|escape}</span></h2></div>
	{else}
		<div class="HeaderTitle"><h2>{#RUBRIK_TEMPLATE_EDIT#}<span style="color: #000;"> &gt; {$row->rubric_title|escape}</span></h2></div>
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

				<textarea {$read_only} class="{if $php_forbidden==1}tpl_code_readonly{else}{/if}" wrap="off" style="width:100%; height:350px" name="rubric_template" id="rubric_template">{$row->rubric_template|default:$prefab|escape:html}</textarea>

				<div class="infobox">
					{assign var=js_textfeld value='rubric_template'}
					{assign var=js_form value='f_tpl'}
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<ol>', '</ol>');">OL</a> |
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<ul>', '</ul>');">UL</a> |
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<li>', '</li>');">LI</a> |
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<p>', '</p>');">P</a> |
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<strong>', '</strong>');">B</a> |
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<em>', '</em>');">I</a> |
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<h1>', '</h1>');">H1</a> |
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<h2>', '</h2>');">H2</a> |
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<h3>', '</h3>');">H3</a> |
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<div>', '</div>');">DIV</a> |
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<pre>', '</pre>');">PRE</a> |
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<br />', '');">BR</a> |
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '\t', '');">TAB</a> |
					<a title="{#RUBRIK_DOCID_INFO#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:docid]', '');">[tag:docid]</a> |
					<a title="{#RUBRIK_DOCDATE_INFO#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:docdate]', '');">[tag:docdate]</a> |
					<a title="{#RUBRIK_DOCTIME_INFO#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:doctime]', '');">[tag:doctime]</a> |
					<a title="{#RUBRIK_DOCAUTHOR_INFO#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:docauthor]', '');">[tag:docauthor]</a> |
					<a title="{#RUBRIK_VIEWS_INFO#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:docviews]', '');">[tag:docviews]</a> |
					<a title="{#RUBRIK_TITLE_INFO#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:title]', '');">[tag:title]</a> |
					<a title="{#RUBRIK_PATH_INFO#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:path]', '');">[tag:path]</a> |
					<a title="{#RUBRIK_MEDIAPATH_INFO#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:mediapath]', '');">[tag:mediapath]</a> |
					<a title="{#RUBRIK_HIDE_INFO#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:hide:', ']\n\n[/tag:hide]');">[tag:hide:X,X][/tag:hide]</a>
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
							<td width="10%" class="first"><a title="{#RUBRIK_INSERT_HELP#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:fld:{$tag->Id}]', '');">[tag:fld:{$tag->Id}]</a></td>
							<td width="10%" class="first"><strong>{$tag->rubric_field_title}</strong></td>
							<td width="10%" class="first">
								{section name=feld loop=$feld_array}
									{if $tag->rubric_field_type == $feld_array[feld].id}{$feld_array[feld].name}{/if}
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
				<input type="hidden" name="Id" value="{$smarty.request.Id|escape}">
				<input class="button" type="submit" value="{#RUBRIK_BUTTON_TPL#}" />
			</td>
		</tr>
	</table>
</form>