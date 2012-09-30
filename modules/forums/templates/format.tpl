<script language="JavaScript" type="text/javascript">
<!--
	var text_enter_url      =  "";
	var text_enter_url_name =  "";
	var text_enter_image    =  "";
	var text_enter_email    =  "";
	var error_no_url        =  "";
	var error_no_title      =  "";
	var error_no_email      =  "";
	var prompt_start        =  "";

	var khelp_bold          =  "";
	var khelp_italic        =  "";
	var khelp_underline     =  "";
	var khelp_font          =  "";
	var khelp_size          =  "";
	var khelp_color         =  "";
	var khelp_close         =  "";
	var khelp_url           =  "";
	var khelp_image         =  "";
	var khelp_email         =  "";
	var khelp_quote         =  "";
	var khelp_list          =  "";
	var khelp_code          =  "";
	var khelp_php_code      =  "";
	var khelp_click_close   =  "";
	var list_prompt         =  "";
	var list_prompt2        =  "";
-->
</script>
<table width="100%"  border="0" cellspacing="1" cellpadding="0">
	<tr>
		<td>
			<select style="height:18px" onmouseover="MWJ_getPosition();" onchange="changefont(this.options[this.selectedIndex].value, 'FONT')" name="ffont">
				<option value="0" selected="selected"> {#Ffont#} </option>
			{foreach from=$listfonts item=fonts}
				<option style="font-family: {$fonts.font};font-size:12px" value="{$fonts.font}"> {$fonts.fontname} </option>
			{/foreach}
			</select>
			<select style="height:18px" onchange="changefont(this.options[this.selectedIndex].value, 'SIZE')"  name="fsize">
				<option value="0" selected="selected"> {#Fsize#} </option>
			{foreach from=$sizedropdown item=size}
				<option style="font-size:1{$size.size}px" value="{$size.size}"> {$size.size} </option>
			{/foreach}
			</select>
			<select style="height:18px"  onchange="changefont(this.options[this.selectedIndex].value, 'COLOR')" name="fcolor">
				<option value="0" selected="selected"> {#Fcolor#} </option>
			{foreach from=$colordropdown item=color}
				<option style="color: {$color.color}; font-weight:bold" value="{$color.color}"> {$color.fontcolor} </option>
			{/foreach}
			</select>
				<input class="button" title="{#CloseTags#}" onclick='closeall();' type="button" value="{#CloseTags#}"/>
				<input name="kmode" type="hidden" id="kmode">
				<input name="kmode" type="hidden" id="kmode" value="normal">
		</td>
	</tr>
	<tr>
		<td>
			<input class="button" accesskey="b" title="{#FormatBold#}" style="margin-right:1px;FONT-WEIGHT: bold" onclick='easytag("B")' type="button" value="B" name="B" />
			<input class="button" accesskey="i" title="{#FormatItalic#}" style="margin-right:1px;font-style:italic" onclick='easytag("I")' type="button" value="I" name="I" />
			<input class="button" accesskey="u" title="{#FormatUnderline#}" style="margin-right:1px;TEXT-DECORATION: underline" onclick='easytag("U")' type="button" value="U" name="U" />
			<input class="button" accesskey="h" title="{#FormatUrl#}" style="margin-right:1px;" onclick="tag_url()" type="button" value="URL" name="url" />
			<input class="button" accesskey="e" title="{#FormatEmail#}" style="margin-right:1px;" onclick="tag_email()" type="button" value="@" name="email" />
			<input class="button" accesskey="g" title="{#FormatImage#}" style="margin-right:1px;" onclick="tag_image()" type="button" value="IMG" name="img" />
			<input class="button" accesskey="q" title="{#FormatQuote#}" style="margin-right:1px;" onclick='easytag("QUOTE")' type="button" value="QUOTE" name="QUOTE" />
			<input class="button" accesskey="p" title="{#FormatCode#}" style="margin-right:1px;" onclick='easytag("CODE")' type="button" value="CODE" name="CODE" />
			<input class="button" accesskey="x" title="{#FormatPhp#}" style="margin-right:1px;" onclick='easytag("PHP")' type="button" value="PHP" name="PHP" />
			<input class="button" accesskey="1" title="{#FormatList#}" style="margin-right:1px;" onclick='tag_list()' type="button" value="*" name="LIST" />
		</td>
	</tr>
</table>