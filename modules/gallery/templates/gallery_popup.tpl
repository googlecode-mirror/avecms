<!-- gallery_popup.tpl -->
{strip}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>{$gallery->gallery_title|escape}</title>
{if $smarty.request.theme_folder != ''}
<link href="templates/{$smarty.request.theme_folder}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="templates/{$smarty.request.theme_folder}/js/common.js" type="text/javascript"></script>
<script src="templates/{$smarty.request.theme_folder}/overlib/overlib.js" type="text/javascript"></script>
{else}
<link href="{$tpl_path}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="{$tpl_path}/js/common.js" type="text/javascript"></script>
<script src="{$tpl_path}/overlib/overlib.js" type="text/javascript"></script>
{/if}
</head>

<body style="margin:0">
	<div style="padding:30px">
		<div style="padding:10px">
{*
			<div id="module_header" style="text-align:center">
				<h1>{$gallery->gallery_title|escape}</h1>
			</div>

			<div style="text-align:left">{$gallery->gallery_description|escape}</div>
*}
			<div id="module_content" style="background-color:#fff;width:660px;margin:0 auto">
				{include file="$path/gallery.tpl"}<br />
				<br />

				<div align="center">
					<input type="button" class="button" onclick="window.close();" title="{#WinClose#}" alt="{#WinClose#}" value="{#WinClose#}"/><br />
					<br />
				</div>
			</div>

		</div>
	</div>

</body>
</html>

{/strip}
<!-- /gallery_popup.tpl -->
