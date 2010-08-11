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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="tableheader">
			<div id="noticeAreaBrowser">
				<h1 class="mediapool">{#MAIN_FILE_MANAGER_TITLE#}</h1>
			</div>
		</td>
	</tr>
</table>

<form style="display:inline;" name="dat" onSubmit="return false;">
	<table width="100%" border="0" cellpadding="5" cellspacing="1">
		<tr class="third">
			<td>
				<input type="text" name="dateiname" size="20" style="width:100%;" readonly="readonly" />
			</td>
			<td width="5%" align="right" nowrap="nowrap">
				<input type="button" class="button" onClick="NewFolder();" value="{#MAIN_MP_CREATE_FOLDER#}" />&nbsp;
				<input type="button" class="button" onClick="updlg();" value="{#MAIN_MP_UPLOAD_FILE#}" />
			</td>
		</tr>
	</table>

	<table width="100%"  border="0" cellpadding="5" cellspacing="1">
		<tr class="second" valign="top">
			<td width="100%">
				{assign var=height value=490}
				<div style="border:1px solid #D4D4D4;overflow:hidden;height:{$height}px;width:100%">
					<iframe frameborder="0" name="zf" id="zf" width="100%" height="{$height}" scrolling="Yes" src="browser.php?typ={$smarty.request.typ|escape}&cpengine={$sess}&dir=/&action=list"></iframe>
				</div>
			</td>
		</tr>
	</table>

	{if $smarty.request.typ!=''}
		<table width="100%" border="0" cellpadding="5" cellspacing="1">
			<tr class="third">
				<td>
					<input type="text" name="fn" size="20" style="width:100%;" readonly="readonly" />
				</td>
				<td width="1%" align="right">
					<input type="button" class="button" onClick="submitTheForm();" value="{#MAIN_MP_FILE_INSERT#}" />
				</td>
			</tr>
		</table>
	{/if}
</form>

<script type="text/javascript">
function submitTheForm() {ldelim}
	if (document.dat.fn.value == '') {ldelim}
		alert('{#MAIN_MP_PLEASE_SELECT#}');
	{rdelim}
	else {ldelim}
{if $smarty.request.fillout=='textfield'}
		window.opener.document.dokument['{$smarty.request.target|escape}'].value = document.dat.dateiname.value + document.dat.fn.value;
{else}
{if $smarty.request.target=='filename'}
		window.opener.document.target['f_href'].value = '{$mediapath}' + document.dat.dateiname.value + document.dat.fn.value;

{elseif $smarty.request.target=='link'}
		window.opener.document.getElementById('txtUrl').value = '{$mediapath}' + document.dat.dateiname.value + document.dat.fn.value;

{elseif $smarty.request.target=='link_image'}
		window.opener.document.getElementById('txtLnkUrl').value = '{$cppath}/{$mediapath}' + document.dat.dateiname.value + document.dat.fn.value;
		window.opener.UpdatePreview();

{elseif $smarty.request.target=='txtUrl'}
{if $smarty.request.nosource=='1'}
		window.opener.document.getElementById('txtUrl').value = '{$mediapath}' + document.dat.dateiname.value + document.dat.fn.value;
		window.opener.UpdatePreview();
{else}
		window.opener.document.getElementById('txtUrl').value = '{$cppath}/{$mediapath}' + document.dat.dateiname.value + document.dat.fn.value;
		window.opener.UpdatePreview();
{/if}

{elseif $smarty.request.target=='navi'}
		window.opener.document.getElementById('{$smarty.request.id|escape}').value = '{$cppath}/{$mediapath}' + document.dat.dateiname.value + document.dat.fn.value;

{elseif $smarty.request.target=='img_feld' || $target_img=='img_feld'}
		window.opener.document.getElementById('img_feld__{$pop_id}').value = '{$mediapath}' + document.dat.dateiname.value + document.dat.fn.value;
		window.opener.document.getElementById('span_feld__{$pop_id}').style.display = '';
		window.opener.document.getElementById('_img_feld__{$pop_id}').src = '../index.php?thumb=/{$mediapath}' + document.dat.dateiname.value + document.dat.fn.value;

{elseif $smarty.request.target=='f_url'}
		window.opener.document.target['f_url'].value='{$cppath}/{$mediapath}' + document.dat.dateiname.value + document.dat.fn.value;

{elseif $smarty.request.target!='all'}
{if $smarty.request.fillout=='dl'}
		window.opener.document.getElementById('{$smarty.request.target|escape}').value = '{$mediapath}' + document.dat.dateiname.value + document.dat.fn.value;
{else}
		window.opener.updatePreview();
{/if}

{else}
		window.opener.document.dokument['img_{$smarty.request.target|escape}'].{if $smarty.request.target=='vide'}dyn{/if}src = '{$cppath}/{$mediapath}' + document.dat.dateiname.value + document.dat.fn.value;
		window.opener.document.dokument['{$smarty.request.target|escape}'].value = document.dat.dateiname.value + document.dat.fn.value;
{/if}
{/if}
		setTimeout("self.close();", 100);
    {rdelim}
{rdelim}

function NewFolder() {ldelim}
	var dname = window.prompt('{#MAIN_ADD_FOLDER#}', 'newfolder');
	if (dname=='' || dname==null) {ldelim}
		alert('{#MAIN_NO_ADD_FOLDER#}');
	{rdelim}
	else {ldelim}
		parent.frames['zf'].location.href='browser.php?typ={$smarty.request.typ|escape}&dir=' + document.dat.dateiname.value + '&cpengine={$sess}&action=list&newdir=' + dname;
	{rdelim}
{rdelim}

function updlg() {ldelim}
	var url = 'browser.php?cpengine={$sess}&action=upload&pfad=' + document.dat.dateiname.value + '&typ={$smarty.request.typ|escape}';
	var winWidth = 500;
	var winHeight = 300;
	var w = (screen.width - winWidth)/2;
	var h = (screen.height - winHeight)/2 - 60;
	var name = 'upload2mp';
	var features = 'scrollbars=no,width='+winWidth+',height='+winHeight+',top='+h+',left='+w;
	window.open(url,name,features);
{rdelim}
</script>

</body>
</html>