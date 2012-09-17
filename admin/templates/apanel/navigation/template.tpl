<link rel="stylesheet" href="{$ABS_PATH}admin/codemirror/lib/codemirror.css">

<script src="{$ABS_PATH}admin/codemirror/lib/codemirror.js" type="text/javascript"></script>
<script src="{$ABS_PATH}admin/codemirror/mode/xml/xml.js"></script>
<script src="{$ABS_PATH}admin/codemirror/mode/javascript/javascript.js"></script>
<script src="{$ABS_PATH}admin/codemirror/mode/css/css.js"></script>
<script src="{$ABS_PATH}admin/codemirror/mode/clike/clike.js"></script>
<script src="{$ABS_PATH}admin/codemirror/mode/php/php.js"></script>

{literal}
    <style type="text/css">
      .activeline {background: #e8f2ff !important;}
      .CodeMirror-scroll {height: 70px;}
    </style>
{/literal}

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
				<a title="{#NAVI_LINK_ID#}" href="javascript:void(0);" onclick="textSelection1('[tag:linkid]', '');">[tag:linkid]</a><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:void(0);" onclick="textSelection1('[tag:target]', '');">[tag:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:void(0);" onclick="textSelection1('[tag:link]', '');">[tag:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:void(0);" onclick="textSelection1('[tag:linkname]', '');">[tag:linkname]</a>
			</td>
			<td class="second"><div class="coder_in"><textarea style="width:100%" name="navi_level1" rows="4" id="navi_level1">{$nav->navi_level1|escape}</textarea></div></td>
		</tr>

		<tr>
			<td width="200" class="first">HTML Tags</td>
			<td class="second">
				<div class="infobox">&nbsp;|
					<a href="javascript:void(0);" onclick="textSelection1('<ol>', '</ol>');"><strong>OL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<ul>', '</ul>');"><strong>UL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<li>', '</li>');"><strong>LI</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<p class=&quot;&quot;>', '</p>');"><strong>P</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<strong>', '</strong>');"><strong>B</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<em>', '</em>');"><strong>I</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<h1>', '</h1>');"><strong>H1</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<h2>', '</h2>');"><strong>H2</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<h3>', '</h3>');"><strong>H3</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<h4>', '</h4>');"><strong>H4</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<h5>', '</h5>');"><strong>H5</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<h6>', '</h6>');"><strong>H6</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<div>', '</div>');"><strong>DIV</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<a href=&quot;&quot; title=&quot;&quot;>', '</a>');"><strong>A</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<img src=&quot;&quot; alt=&quot;&quot; />', '');"><strong>IMG</strong></a>&nbsp;|&nbsp;					
					<a href="javascript:void(0);" onclick="textSelection1('<span>', '</span>');"><strong>SPAN</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<pre>', '</pre>');"><strong>PRE</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('<br />', '');"><strong>BR</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection1('\t', '');"><strong>TAB</strong></a>&nbsp;|
				</div>			
			</td>
		</tr>			
		
		<tr>
			<td width="200" class="first">
				<strong>{#NAVI_LINK_ACTIVE#}</strong><br />
				<a title="{#NAVI_LINK_ID#}" href="javascript:void(0);" onclick="textSelection2('[tag:linkid]', '');">[tag:linkid]</a><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:void(0);" onclick="textSelection2('[tag:target]', '');">[tag:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:void(0);" onclick="textSelection2('[tag:link]', '');">[tag:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:void(0);" onclick="textSelection2('[tag:linkname]', '');">[tag:linkname]</a>
			</td>
			<td class="second"><div class="coder_in"><textarea style="width:100%" name="navi_level1active" rows="4" id="navi_level1active">{$nav->navi_level1active|escape}</textarea></div></td>
		</tr>

		<tr>
			<td width="200" class="first">HTML Tags</td>
			<td class="second">
				<div class="infobox">&nbsp;|
					<a href="javascript:void(0);" onclick="textSelection2('<ol>', '</ol>');"><strong>OL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<ul>', '</ul>');"><strong>UL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<li>', '</li>');"><strong>LI</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<p class=&quot;&quot;>', '</p>');"><strong>P</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<strong>', '</strong>');"><strong>B</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<em>', '</em>');"><strong>I</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<h1>', '</h1>');"><strong>H1</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<h2>', '</h2>');"><strong>H2</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<h3>', '</h3>');"><strong>H3</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<h4>', '</h4>');"><strong>H4</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<h5>', '</h5>');"><strong>H5</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<h6>', '</h6>');"><strong>H6</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<div>', '</div>');"><strong>DIV</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<a href=&quot;&quot; title=&quot;&quot;>', '</a>');"><strong>A</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<img src=&quot;&quot; alt=&quot;&quot; />', '');"><strong>IMG</strong></a>&nbsp;|&nbsp;					
					<a href="javascript:void(0);" onclick="textSelection2('<span>', '</span>');"><strong>SPAN</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<pre>', '</pre>');"><strong>PRE</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<br />', '');"><strong>BR</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('\t', '');"><strong>TAB</strong></a>&nbsp;|
				</div>			
			</td>
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
				<a title="{#NAVI_LINK_ID#}" href="javascript:void(0);" onclick="textSelection3('[tag:linkid]', '');">[tag:linkid]</a><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:void(0);" onclick="textSelection3('[tag:target]', '');">[tag:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:void(0);" onclick="textSelection3('[tag:link]', '');">[tag:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:void(0);" onclick="textSelection3('[tag:linkname]', '');">[tag:linkname]</a>
			</td>
			<td class="second"><div class="coder_in"><textarea style="width:100%" name="navi_level2" rows="4" id="navi_level2">{$nav->navi_level2|escape}</textarea></div></td>
		</tr>

		<tr>
			<td width="200" class="first">HTML Tags</td>
			<td class="second">
				<div class="infobox">&nbsp;|
					<a href="javascript:void(0);" onclick="textSelection3('<ol>', '</ol>');"><strong>OL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<ul>', '</ul>');"><strong>UL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<li>', '</li>');"><strong>LI</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<p class=&quot;&quot;>', '</p>');"><strong>P</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<strong>', '</strong>');"><strong>B</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<em>', '</em>');"><strong>I</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<h1>', '</h1>');"><strong>H1</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<h2>', '</h2>');"><strong>H2</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<h3>', '</h3>');"><strong>H3</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<h4>', '</h4>');"><strong>H4</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<h5>', '</h5>');"><strong>H5</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<h6>', '</h6>');"><strong>H6</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<div>', '</div>');"><strong>DIV</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<a href=&quot;&quot; title=&quot;&quot;>', '</a>');"><strong>A</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<img src=&quot;&quot; alt=&quot;&quot; />', '');"><strong>IMG</strong></a>&nbsp;|&nbsp;					
					<a href="javascript:void(0);" onclick="textSelection3('<span>', '</span>');"><strong>SPAN</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<pre>', '</pre>');"><strong>PRE</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('<br />', '');"><strong>BR</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection3('\t', '');"><strong>TAB</strong></a>&nbsp;|
				</div>			
			</td>
		</tr>		
		
		<tr>
			<td class="first">
				<strong>{#NAVI_LINK_ACTIVE#}</strong><br />
				<a title="{#NAVI_LINK_ID#}" href="javascript:void(0);" onclick="textSelection4('[tag:linkid]', '');">[tag:linkid]</a><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:void(0);" onclick="textSelection4('[tag:target]', '');">[tag:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:void(0);" onclick="textSelection4('[tag:link]', '');">[tag:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:void(0);" onclick="textSelection4('[tag:linkname]', '');">[tag:linkname]</a>
			</td>
			<td class="second"><div class="coder_in"><textarea style="width:100%" name="navi_level2active" rows="4" id="navi_level2active">{$nav->navi_level2active|escape}</textarea></div></td>
		</tr>

		<tr>
			<td width="200" class="first">HTML Tags</td>
			<td class="second">
				<div class="infobox">&nbsp;|
					<a href="javascript:void(0);" onclick="textSelection4('<ol>', '</ol>');"><strong>OL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<ul>', '</ul>');"><strong>UL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<li>', '</li>');"><strong>LI</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<p class=&quot;&quot;>', '</p>');"><strong>P</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<strong>', '</strong>');"><strong>B</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<em>', '</em>');"><strong>I</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<h1>', '</h1>');"><strong>H1</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<h2>', '</h2>');"><strong>H2</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<h3>', '</h3>');"><strong>H3</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<h4>', '</h4>');"><strong>H4</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<h5>', '</h5>');"><strong>H5</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<h6>', '</h6>');"><strong>H6</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<div>', '</div>');"><strong>DIV</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<a href=&quot;&quot; title=&quot;&quot;>', '</a>');"><strong>A</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<img src=&quot;&quot; alt=&quot;&quot; />', '');"><strong>IMG</strong></a>&nbsp;|&nbsp;					
					<a href="javascript:void(0);" onclick="textSelection4('<span>', '</span>');"><strong>SPAN</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<pre>', '</pre>');"><strong>PRE</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('<br />', '');"><strong>BR</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection4('\t', '');"><strong>TAB</strong></a>&nbsp;|
				</div>			
			</td>
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
				<a title="{#NAVI_LINK_ID#}" href="javascript:void(0);" onclick="textSelection5('[tag:linkid]', '');">[tag:linkid]</a><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:void(0);" onclick="textSelection5('[tag:target]', '');">[tag:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:void(0);" onclick="textSelection5('[tag:link]', '');">[tag:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:void(0);" onclick="textSelection5('[tag:linkname]', '');">[tag:linkname]</a>
			</td>
			<td class="second"><div class="coder_in"><textarea style="width:100%" name="navi_level3" rows="4" id="navi_level3">{$nav->navi_level3|escape}</textarea></div></td>
		</tr>

		<tr>
			<td width="200" class="first">HTML Tags</td>
			<td class="second">
				<div class="infobox">&nbsp;|
					<a href="javascript:void(0);" onclick="textSelection5('<ol>', '</ol>');"><strong>OL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<ul>', '</ul>');"><strong>UL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<li>', '</li>');"><strong>LI</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<p class=&quot;&quot;>', '</p>');"><strong>P</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<strong>', '</strong>');"><strong>B</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<em>', '</em>');"><strong>I</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<h1>', '</h1>');"><strong>H1</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<h2>', '</h2>');"><strong>H2</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<h3>', '</h3>');"><strong>H3</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<h4>', '</h4>');"><strong>H4</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<h5>', '</h5>');"><strong>H5</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<h6>', '</h6>');"><strong>H6</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<div>', '</div>');"><strong>DIV</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<a href=&quot;&quot; title=&quot;&quot;>', '</a>');"><strong>A</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<img src=&quot;&quot; alt=&quot;&quot; />', '');"><strong>IMG</strong></a>&nbsp;|&nbsp;					
					<a href="javascript:void(0);" onclick="textSelection5('<span>', '</span>');"><strong>SPAN</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<pre>', '</pre>');"><strong>PRE</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('<br />', '');"><strong>BR</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection5('\t', '');"><strong>TAB</strong></a>&nbsp;|
				</div>			
			</td>
		</tr>		
		
		<tr>
			<td class="first">
				<strong>{#NAVI_LINK_ACTIVE#}</strong><br />
				<a title="{#NAVI_LINK_ID#}" href="javascript:void(0);" onclick="textSelection6('[tag:linkid]', '');">[tag:linkid]</a><br />
				<a title="{#NAVI_LINK_TARGET#}" href="javascript:void(0);" onclick="textSelection6('[tag:target]', '');">[tag:target]</a><br />
				<a title="{#NAVI_LINK_URL#}" href="javascript:void(0);" onclick="textSelection6('[tag:link]', '');">[tag:link]</a><br />
				<a title="{#NAVI_LINK_NAME#}" href="javascript:void(0);" onclick="textSelection6('[tag:linkname]', '');">[tag:linkname]</a>
			</td>
			<td class="second"><div class="coder_in"><textarea style="width:100%" name="navi_level3active" rows="4" id="navi_level3active">{$nav->navi_level3active|escape}</textarea></div></td>
		</tr>

		<tr>
			<td width="200" class="first">HTML Tags</td>
			<td class="second">
				<div class="infobox">&nbsp;|
					<a href="javascript:void(0);" onclick="textSelection6('<ol>', '</ol>');"><strong>OL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<ul>', '</ul>');"><strong>UL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<li>', '</li>');"><strong>LI</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<p class=&quot;&quot;>', '</p>');"><strong>P</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<strong>', '</strong>');"><strong>B</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<em>', '</em>');"><strong>I</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<h1>', '</h1>');"><strong>H1</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<h2>', '</h2>');"><strong>H2</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<h3>', '</h3>');"><strong>H3</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<h4>', '</h4>');"><strong>H4</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<h5>', '</h5>');"><strong>H5</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<h6>', '</h6>');"><strong>H6</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<div>', '</div>');"><strong>DIV</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<a href=&quot;&quot; title=&quot;&quot;>', '</a>');"><strong>A</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<img src=&quot;&quot; alt=&quot;&quot; />', '');"><strong>IMG</strong></a>&nbsp;|&nbsp;					
					<a href="javascript:void(0);" onclick="textSelection6('<span>', '</span>');"><strong>SPAN</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<pre>', '</pre>');"><strong>PRE</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('<br />', '');"><strong>BR</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection6('\t', '');"><strong>TAB</strong></a>&nbsp;|
				</div>			
			</td>
		</tr>		
	</table><br />

	<input accesskey="s" type="submit" class="button" value="{#NAVI_BUTTON_SAVE#}" />
</form>

    <script language="javascript">
{literal}    
      var editor1 = CodeMirror.fromTextArea(document.getElementById("navi_level1"), {
        lineNumbers: true,
		lineWrapping: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        onChange: function(){editor1.save();},
		onCursorActivity: function() {
		  editor.setLineClass(hlLine, null, null);
		  hlLine = editor1.setLineClass(editor.getCursor().line, null, "activeline");
		}
      });
	  var hlLine = editor1.setLineClass(0, "activeline");

      function getSelectedRange1() {
        return { from: editor1.getCursor(true), to: editor1.getCursor(false) };
      }

      function textSelection1(startTag,endTag) {
        var range = getSelectedRange1();
        editor1.replaceRange(startTag + editor1.getRange(range.from, range.to) + endTag, range.from, range.to)
        editor1.setCursor(range.from.line, range.from.ch + startTag.length);
      }

      var editor2 = CodeMirror.fromTextArea(document.getElementById("navi_level1active"), {
        lineNumbers: true,
		lineWrapping: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        onChange: function(){editor2.save();},
		onCursorActivity: function() {
		  editor2.setLineClass(hlLine, null, null);
		  hlLine = editor2.setLineClass(editor2.getCursor().line, null, "activeline");
		}
      });

      function getSelectedRange2() {
        return { from: editor2.getCursor(true), to: editor2.getCursor(false) };
      }

      function textSelection2(startTag,endTag) {
        var range = getSelectedRange2();
        editor2.replaceRange(startTag + editor2.getRange(range.from, range.to) + endTag, range.from, range.to)
        editor2.setCursor(range.from.line, range.from.ch + startTag.length);
      }

      var hlLine = editor2.setLineClass(0, "activeline");
	  
      var editor3 = CodeMirror.fromTextArea(document.getElementById("navi_level2"), {
        lineNumbers: true,
		lineWrapping: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        onChange: function(){editor3.save();},
		onCursorActivity: function() {
		  editor3.setLineClass(hlLine, null, null);
		  hlLine = editor3.setLineClass(editor3.getCursor().line, null, "activeline");
		}
      });

      function getSelectedRange3() {
        return { from: editor3.getCursor(true), to: editor3.getCursor(false) };
      }

      function textSelection3(startTag,endTag) {
        var range = getSelectedRange3();
        editor3.replaceRange(startTag + editor3.getRange(range.from, range.to) + endTag, range.from, range.to)
        editor3.setCursor(range.from.line, range.from.ch + startTag.length);
      }

      var hlLine = editor3.setLineClass(0, "activeline");

      var editor4 = CodeMirror.fromTextArea(document.getElementById("navi_level2active"), {
        lineNumbers: true,
		lineWrapping: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        onChange: function(){editor4.save();},
		onCursorActivity: function() {
		  editor4.setLineClass(hlLine, null, null);
		  hlLine = editor4.setLineClass(editor4.getCursor().line, null, "activeline");
		}
      });

      function getSelectedRange4() {
        return { from: editor4.getCursor(true), to: editor4.getCursor(false) };
      }

      function textSelection4(startTag,endTag) {
        var range = getSelectedRange4();
        editor4.replaceRange(startTag + editor4.getRange(range.from, range.to) + endTag, range.from, range.to)
        editor4.setCursor(range.from.line, range.from.ch + startTag.length);
      }

      var hlLine = editor4.setLineClass(0, "activeline");

      var editor5 = CodeMirror.fromTextArea(document.getElementById("navi_level3"), {
        lineNumbers: true,
		lineWrapping: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        onChange: function(){editor5.save();},
		onCursorActivity: function() {
		  editor5.setLineClass(hlLine, null, null);
		  hlLine = editor5.setLineClass(editor5.getCursor().line, null, "activeline");
		}
      });

      function getSelectedRange5() {
        return { from: editor5.getCursor(true), to: editor5.getCursor(false) };
      }

      function textSelection5(startTag,endTag) {
        var range = getSelectedRange5();
        editor5.replaceRange(startTag + editor5.getRange(range.from, range.to) + endTag, range.from, range.to)
        editor5.setCursor(range.from.line, range.from.ch + startTag.length);
      }

      var hlLine = editor5.setLineClass(0, "activeline");

      var editor6 = CodeMirror.fromTextArea(document.getElementById("navi_level3active"), {
        lineNumbers: true,
		lineWrapping: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        onChange: function(){editor6.save();},
		onCursorActivity: function() {
		  editor6.setLineClass(hlLine, null, null);
		  hlLine = editor6.setLineClass(editor6.getCursor().line, null, "activeline");
		}
      });

      function getSelectedRange6() {
        return { from: editor6.getCursor(true), to: editor6.getCursor(false) };
      }

      function textSelection6(startTag,endTag) {
        var range = getSelectedRange6();
        editor6.replaceRange(startTag + editor6.getRange(range.from, range.to) + endTag, range.from, range.to)
        editor6.setCursor(range.from.line, range.from.ch + startTag.length);
      }

      var hlLine = editor6.setLineClass(0, "activeline");		  
{/literal}
    </script>