<script language="JavaScript" type="text/javascript">
<!--
	var text_enter_url      =  "{#FORUMS_TEXT_ENTER_URL#}";
	var text_enter_url_name =  "{#FORUMS_TEXT_ENTER_URL_NAME#}";
	var text_enter_image    =  "{#FORUMS_TEXT_ENTER_IMAGE#}";
	var text_enter_email    =  "{#FORUMS_TEXT_ENTER_EMAIL#}";
	var error_no_url        =  "{#FORUMS_ERROR_NO_URL#}";
	var error_no_title      =  "{#FORUMS_ERROR_NO_TITLE#}";
	var error_no_email      =  "{#FORUMS_ERROR_NO_EMAIL#}";
	var prompt_start        =  "{#FORUMS_PROMPT_START#}";
	var list_prompt         =  "{#FORUMS_LIST_PROMPT#}";
	var list_prompt2        =  "{#FORUMS_LIST_PROMPT2#}";
-->
</script>
<table width="100%"  border="0" cellspacing="1" cellpadding="0">
	<tr>
		<td>
			<select style="height:18px" onmouseover="MWJ_getPosition();" onchange="changefont(this.options[this.selectedIndex].value, 'FONT')" name="ffont">
				<option value="0" selected="selected"> {#FORUMS_FORMAT_FONT#} </option>
			{foreach from=$listfonts item=fonts}
				<option style="font-family: {$fonts.font};font-size:12px" value="{$fonts.font}"> {$fonts.fontname} </option>
			{/foreach}
			</select>
			<select style="height:18px" onchange="changefont(this.options[this.selectedIndex].value, 'SIZE')"  name="fsize">
				<option value="0" selected="selected"> {#FORUMS_FORMAT_FONT_SIZE#} </option>
			{foreach from=$sizedropdown item=size}
				<option style="font-size:1{$size.size}px" value="{$size.size}"> {$size.size} </option>
			{/foreach}
			</select>
			<select style="height:18px"  onchange="changefont(this.options[this.selectedIndex].value, 'COLOR')" name="fcolor">
				<option value="0" selected="selected"> {#FORUMS_FORMAT_FONT_COLOR#} </option>
			{foreach from=$colordropdown item=color}
				<option style="color: {$color.color}; font-weight:bold" value="{$color.color}"> {$color.fontcolor} </option>
			{/foreach}
			</select>
				<input class="button" title="{#FORUMS_CLOSE_TAGS#}" onclick='closeall();' type="button" value="{#FORUMS_CLOSE_TAGS#}"/>
				<input name="kmode" type="hidden" id="kmode">
				<input name="kmode" type="hidden" id="kmode" value="normal">
		</td>
	</tr>
	<tr>
		<td>
			<input class="button" accesskey="b" title="{#FORUMS_FORMAT_BOLD#}" style="margin-right:1px;FONT-WEIGHT: bold" onclick='easytag("B")' type="button" value="B" name="B" />
			<input class="button" accesskey="i" title="{#FORUMS_FORMAT_ITALIC#}" style="margin-right:1px;font-style:italic" onclick='easytag("I")' type="button" value="I" name="I" />
			<input class="button" accesskey="u" title="{#FORUMS_FORMAT_UNDERLINE#}" style="margin-right:1px;TEXT-DECORATION: underline" onclick='easytag("U")' type="button" value="U" name="U" />
			<input class="button" accesskey="h" title="{#FORUMS_FORMAT_URL#}" style="margin-right:1px;" onclick="tag_url()" type="button" value="URL" name="url" />
			<input class="button" accesskey="e" title="{#FORUMS_FORMAT_EMAIL#}" style="margin-right:1px;" onclick="tag_email()" type="button" value="@" name="email" />
			<input class="button" accesskey="g" title="{#FORUMS_FORMAT_IMAGE#}" style="margin-right:1px;" onclick="tag_image()" type="button" value="IMG" name="img" />
			<input class="button" accesskey="q" title="{#FORUMS_FORMAT_QUOTE#}" style="margin-right:1px;" onclick='easytag("QUOTE")' type="button" value="QUOTE" name="QUOTE" />
			<input class="button" accesskey="p" title="{#FORUMS_FORMAT_CODE#}" style="margin-right:1px;" onclick='easytag("CODE")' type="button" value="CODE" name="CODE" />
			<input class="button" accesskey="x" title="{#FORUMS_FORMAT_PHP#}" style="margin-right:1px;" onclick='easytag("PHP")' type="button" value="PHP" name="PHP" />
			<input class="button" accesskey="1" title="{#FORUMS_FORMAT_LIST#}" style="margin-right:1px;" onclick='tag_list()' type="button" value="*" name="LIST" />
		</td>
	</tr>
</table>