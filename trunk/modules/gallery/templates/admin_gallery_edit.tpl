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
      .CodeMirror-scroll {height: 300px;}
    </style>
{/literal}

<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#ModSettingGal#}</h2>
	</div>
	<div class="HeaderText">&nbsp;</div>
</div>

<div class="infobox">
	<a href="index.php?do=modules&action=modedit&mod=gallery&moduleaction=1&cp={$sess}">&raquo;&nbsp;{#GalView#}</a>
</div><br />

<form method="post" name="gallery_form" id="gallery_form" action="index.php?do=modules&action=modedit&mod=gallery&moduleaction=editgallery&id={$smarty.request.id|escape}&cp={$sess}&sub=save">
	{assign var=js_form value='gallery_form'}
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="200" class="first">
		<col class="second">
		<tr>
			<td class="tableheader">{#GallerySetParam#}</td>
			<td class="tableheader">{#GallerySetVal#}</td>
		</tr>

		<tr>
			<td>{#GalleryTitle#}</td>
			<td>
				<input name="gallery_title" type="text" id="gallery_title" value="{$gallery.gallery_title|escape}" size="40" style="width:500px" />
				<input name="gallery_title_old" type="hidden" value="{$gallery.gallery_title|escape}" />
			</td>
		</tr>

		<tr>
			<td>{#GalleryDesc#}</td>
			<td>
				<textarea name="gallery_description" cols="40" rows="5" id="gallery_description" style="width:500px">{$gallery.gallery_description|escape}</textarea>
			</td>
		</tr>

		<tr>
			<td>{#GalleryFolder#}</td>
			<td>
				<input name="gallery_folder" title="{#GalleryFolderDesc#}" type="text" id="gallery_folder" size="40" value="{$gallery.gallery_folder|escape}" style="width:500px" />
				<input name="gallery_folder_old" type="hidden" value="{$gallery.gallery_folder|escape}" />
			</td>
		</tr>

		<tr>
			<td>{#Watermark#}</td>
			<td>
				<input name="gallery_watermark" type="text" id="gallery_watermark" value="{$gallery.gallery_watermark|escape}" size="40" style="width:500px" />
			</td>
		</tr>

		<tr>
			<td>{#MaxWidth#}</td>
			<td>
				<input name="gallery_thumb_width" title="{#MaxWidthWarn#}" type="text" id="gallery_thumb_width" value="{$gallery.gallery_thumb_width}" size="5" maxlength="3" />
				<input name="thumb_width_old" type="hidden" value="{$gallery.gallery_thumb_width}" />
			</td>
		</tr>

		<tr>
			<td>{#MaxImagesERow#}</td>
			<td>
				<input name="gallery_image_on_line" type="text" id="gallery_image_on_line" value="{$gallery.gallery_image_on_line}" size="5" maxlength="2" />
			</td>
		</tr>

		<tr>
			<td class="first">{#MaxImagesPage#}</td>
			<td>
				<input name="gallery_image_on_page" type="text" id="gallery_image_on_page" value="{$gallery.gallery_image_on_page}" size="5" maxlength="4" />
			</td>
		</tr>

		<tr>
			<td>{#ShowHeader#}</td>
			<td>
				<input name="gallery_title_show" type="checkbox" id="gallery_title_show" value="1" {if $gallery.gallery_title_show == 1}checked="checked" {/if}/>
			</td>
		</tr>

		<tr>
			<td>{#Showdescr#}</td>
			<td>
				<input name="gallery_description_show" type="checkbox" id="gallery_description_show" value="1" {if $gallery.gallery_description_show == 1}checked="checked" {/if}/>
			</td>
		</tr>

		<tr>
			<td>{#ShowSize#}</td>
			<td>
				<input name="gallery_image_size_show" type="checkbox" id="gallery_image_size_show" value="1" {if $gallery.gallery_image_size_show == 1}checked="checked" {/if}/>
			</td>
		</tr>

		<tr>
			<td>{#OrderImage#}</td>
			<td>
				<select name="gallery_orderby" style="width:200px">
					<option value="dateasc" {if $gallery.gallery_orderby == 'dateasc'}selected="selected" {/if}/>{#OrderDateAsc#}</option>
					<option value="datedesc" {if $gallery.gallery_orderby == 'datedesc'}selected="selected" {/if}/>{#OrderDateDesc#}</option>
					<option value="titleasc" {if $gallery.gallery_orderby == 'titleasc'}selected="selected" {/if}/>{#OrderTitleAsc#}</option>
					<option value="titledesc" {if $gallery.gallery_orderby == 'titledesc'}selected="selected" {/if}/>{#OrderTitleDesc#}</option>
					<option value="position" {if $gallery.gallery_orderby == 'position'}selected="selected" {/if}/>{#OrderPosition#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td>{#TypeOut#}</td>
			<td>
				<select id="gallery_type" name="gallery_type" style="width:200px">
					<option value="1" {if $gallery.gallery_type == 1}selected="selected" {/if}/>{#TypeOut1#}</option>
					<option value="2" {if $gallery.gallery_type == 2}selected="selected" {/if}/>{#TypeOut2#}</option>
					<option value="3" {if $gallery.gallery_type == 3}selected="selected" {/if}/>{#TypeOut3#}</option>
					<option value="4" {if $gallery.gallery_type == 4}selected="selected" {/if}/>{#TypeOut4#}</option>
					<option value="5" {if $gallery.gallery_type == 5}selected="selected" {/if}/>{#TypeOut5#}</option>
					<option value="6" {if $gallery.gallery_type == 6}selected="selected" {/if}/>{#TypeOut6#}</option>
					<option value="7" {if $gallery.gallery_type == 7}selected="selected" {/if}/>{#TypeOut7#}</option>
				</select>
			</td>
		</tr>

		<tr class="tr-toggle">
			<td class="tableheader" colspan="2">{#GalleryScripts#}</td>
		</tr>

		<tr class="tr-toggle">
			<td>{#GalleryScriptsTag#}</td>
			<td>{#GalleryScripts#}</td>
		</tr>
		
		<tr class="tr-toggle">
			<td><strong><a title="{#GalleryTagId#}" href="javascript:void(0);" onclick="textSelection('[tag:gal:id]', '');">[tag:gal:id]</a></strong></td>
			<td rowspan="3">
				<div class="coder_in">
				<textarea name="gallery_script" cols="80" rows="10" id="gallery_script" style="width:100%">{$gallery.gallery_script|escape}</textarea>
				</div>
			</td>
		</tr>
		
		<tr class="tr-toggle">
			<td><strong><a title="{#GalleryTagFolder#}" href="javascript:void(0);" onclick="textSelection('[tag:gal:folder]', '');">[tag:gal:folder]</a></strong></td>
		</tr>

		<tr class="tr-toggle">
			<td></td>
		</tr>		
		
		<tr class="tr-toggle">
			<td>{#GalleryTags#}</td>
			<td>
				<div class="infobox">&nbsp;|
					<a href="javascript:void(0);" onclick="textSelection('<ol>', '</ol>');"><strong>OL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<ul>', '</ul>');"><strong>UL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<li>', '</li>');"><strong>LI</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<p class=&quot;&quot;>', '</p>');"><strong>P</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<strong>', '</strong>');"><strong>B</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<em>', '</em>');"><strong>I</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<h1>', '</h1>');"><strong>H1</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<h2>', '</h2>');"><strong>H2</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<h3>', '</h3>');"><strong>H3</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<h4>', '</h4>');"><strong>H4</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<h5>', '</h5>');"><strong>H5</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<h6>', '</h6>');"><strong>H6</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<div>', '</div>');"><strong>DIV</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<a href=&quot;&quot; title=&quot;&quot;>', '</a>');"><strong>A</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<img src=&quot;&quot; alt=&quot;&quot; />', '');"><strong>IMG</strong></a>&nbsp;|&nbsp;					
					<a href="javascript:void(0);" onclick="textSelection('<span>', '</span>');"><strong>SPAN</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<pre>', '</pre>');"><strong>PRE</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<br />', '');"><strong>BR</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('\t', '');"><strong>TAB</strong></a>&nbsp;|
				</div>				
			</td>
		</tr>
		
		<tr class="tr-toggle">
			<td class="tableheader" colspan="2">{#ImageTpl#}</td>
		</tr>

		<tr class="tr-toggle">
			<td>{#ImageTplTag#}</td>
			<td>{#ImageTpl#}</td>
		</tr>
		
		<tr class="tr-toggle">
			<td><strong><a title="{#GalleryTagId#}" href="javascript:void(0);" onclick="textSelection2('[tag:gal:id]', '');">[tag:gal:id]</a></strong></td>
			<td rowspan="8">
				<div class="coder_in">
				<textarea name="gallery_image_template" cols="80" rows="10" id="gallery_image_template" style="width:100%">{$gallery.gallery_image_template|escape}</textarea>
				</div>
			</td>
		</tr>

		<tr class="tr-toggle">
			<td><strong><a title="{#GalleryTagFolder#}" href="javascript:void(0);" onclick="textSelection2('[tag:gal:folder]', '');">[tag:gal:folder]</a></strong></td>
		</tr>

		<tr class="tr-toggle">
			<td><strong><a title="{#GalleryTagImgId#}" href="javascript:void(0);" onclick="textSelection2('[tag:img:id]', '');">[tag:img:id]</a></strong></td>
		</tr>

		<tr class="tr-toggle">
			<td><strong><a title="{#GalleryTagImgTitle#}" href="javascript:void(0);" onclick="textSelection2('[tag:img:title]', '');">[tag:img:title]</a></strong></td>
		</tr>

		<tr class="tr-toggle">
			<td><strong><a title="{#GalleryTagImgDesc#}" href="javascript:void(0);" onclick="textSelection2('[tag:img:description]', '');">[tag:img:description]</a></strong></td>
		</tr>

		<tr class="tr-toggle">
			<td><strong><a title="{#GalleryTagImgFilename#}" href="javascript:void(0);" onclick="textSelection2('[tag:img:filename]', '');">[tag:img:filename]</a></strong></td>
		</tr>

		<tr class="tr-toggle">
			<td><strong><a title="{#GalleryTagImgThumb#}" href="javascript:void(0);" onclick="textSelection2('[tag:img:thumbnail]', '');">[tag:img:thumbnail]</a></strong></td>
		</tr>		
		
		<tr class="tr-toggle">
			<td></td>
		</tr>	
		
		<tr class="tr-toggle">
			<td>{#GalleryTags#}</td>
			<td>
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
	</table>
	<br />
		<input type="submit" class="button" value="{#ButtonSave#}" />&nbsp;{#GalleryOr#}&nbsp;
		<input type="submit" class="button button_lev2" value="{#ButtonSaveEdit#}" />
		
		<span id="loading" style="display:none">&nbsp;&nbsp;&nbsp;<img src="{$tpl_dir}/js/jquery/images/ajax-loader-green.gif" border="0" /></span>
		<span id="checkResult"></span>		
</form>

    <script language="javascript">
    var sett_options = {ldelim}
		url: 'index.php?do=modules&action=modedit&mod=gallery&moduleaction=editgallery&id={$smarty.request.id|escape}&cp={$sess}&sub=save',
		beforeSubmit: function(){ldelim}
			$("#checkResult").html('');
			{rdelim},
        success: function(){ldelim}
			$("#checkResult").html('{#GalleryResultInfo#}');
			{rdelim}	
	{rdelim}

	$(document).ready(function(){ldelim}

	    $(".button_lev2").click(function(e){ldelim}
		    if (e.preventDefault) {ldelim}
		        e.preventDefault();
		    {rdelim} else {ldelim}
		        // internet explorer
		        e.returnValue = false;
		    {rdelim}
		    $("#gallery_form").ajaxSubmit(sett_options);
			return false;
		{rdelim});

	{rdelim});
	
	$("#loading")
		.bind("ajaxSend", function(){ldelim}$(this).show();{rdelim})
		.bind("ajaxComplete", function(){ldelim}$(this).hide();{rdelim});	

{literal}    
      var editor = CodeMirror.fromTextArea(document.getElementById("gallery_script"), {
        lineNumbers: true,
		lineWrapping: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        onChange: function(){editor.save();},
		onCursorActivity: function() {
		  editor.setLineClass(hlLine, null, null);
		  hlLine = editor.setLineClass(editor.getCursor().line, null, "activeline");
		}
      });
	  var hlLine = editor.setLineClass(0, "activeline");

      function getSelectedRange() {
        return { from: editor.getCursor(true), to: editor.getCursor(false) };
      }

      function textSelection(startTag,endTag) {
        var range = getSelectedRange();
        editor.replaceRange(startTag + editor.getRange(range.from, range.to) + endTag, range.from, range.to)
        editor.setCursor(range.from.line, range.from.ch + startTag.length);
      }
	  
      var hlLine = editor.setLineClass(0, "activeline");	  

      var editor2 = CodeMirror.fromTextArea(document.getElementById("gallery_image_template"), {
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
{/literal}
    </script>

<script>
{if $empty_gallery_title == 1}
alert("{#EmptyGalleryTitle#}");
{/if}{if $folder_exist == 1}
alert("{#FolderExists#}");
{/if}{if $gallery.gallery_type != 7}
$('.tr-toggle').hide();
{/if}
$(document).ready(function(){ldelim}
	$('#gallery_type').change(function(){ldelim}
		var gtype = $('#gallery_type').val();
		if (gtype == 7) $('.tr-toggle').show();
		else $('.tr-toggle').hide();
	{rdelim});
{rdelim});
</script>