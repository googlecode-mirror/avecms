<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>({$smarty.session.user_name|escape})</title>
<meta name="robots" content="noindex,nofollow">
<meta http-equiv="pragma" content="no-cache">
<meta name="generator" content="">
<meta name="Expires" content="Mon, 06 Jan 1990 00:00:01 GMT">
<link href="{$tpl_dir}/css/style.css" rel="stylesheet" type="text/css">
<script src="{$tpl_dir}/js/jquery/jquery.js" type="text/javascript"></script>
<script src="{$tpl_dir}/js/cpcode.js" type="text/javascript"></script>
</head>

<body>
<form action="browser.php?cpengine={$sess}&action=upload2&typ={$smarty.request.typ|escape}&pfad={$smarty.request.pfad|escape}" method="post" enctype="multipart/form-data" name="upform" id="upform" style="display:inline;">
	<center>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="middle" class="boxstandart">
					<table width="100%"  border="0" cellpadding="4" cellspacing="1" class="tableborder">
						<tr>
							<th class="tableheader">&nbsp;</th>
							<td class="tableheader">{#MAIN_MP_SELECT_FILES#}</td>
						</tr>

						{section name=files loop=5}
							<tr class="{cycle values='first,second'}">
								<td>#{$smarty.section.files.index+1}</td>
								<td><input name="upfile[]" type="file" id="upfile[]" size="60"></td>
							</tr>
						{/section}

						{if $smarty.request.typ=='bild'}
							<tr class="{cycle values='first,second'}">
								<td>&nbsp;</td>
								<td><input name="resize" type="checkbox" value="1" />&nbsp;{#MAIN_MP_IMAGE_RESIZE#}</td>
							</tr>
							<tr class="{cycle values='first,second'}">
								<td>&nbsp;</td>
								<td>
									<input name="w" type="text" value="120" size="3" />&nbsp;{#MAIN_MP_IMAGE_WIDTH#}&nbsp;
									<input name="h" type="text" value="90" size="3" />&nbsp;{#MAIN_MP_IMAGE_HEIGHT#}
								</td>
							</tr>
						{/if}

						<tr class="{cycle values='first,second'}">
							<td colspan="2">
								<input name="button" type="button" class="button" onclick="this.disabled=true;this.value='{#MAIN_BUTTON_WAIT#}';document.forms['upform'].submit();" value="{#MAIN_BUTTON_UPLOAD#}" />
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</center>
</form>

</body>
</html>