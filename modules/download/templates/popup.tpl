<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$pname}</title>
<meta http-equiv="pragma" content="no-cache" />
<meta name="robots" content="noindex,nofollow" />
<link href="templates/{$smarty.request.theme_folder}/css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="templates/{$smarty.request.theme_folder}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="templates/{$smarty.request.theme_folder}/js/common.js" type="text/javascript"></script>
<script src="templates/{$smarty.request.theme_folder}/overlib/overlib.js" type="text/javascript"></script>
</head>
<body id="forums_pop">
{if $ErrorType==''}
{literal}
<script>
var time = new Date;
var time = time.getTime();
var to = "document.forms['name'].elements['name']";
{/literal}
var bis = time+{$wait};
{literal}
var text = "";
function activate()
{
noch = bis-time-1;
eval(to+".disabled = true");
if(time < bis)
{
	eval(to+'.value = "" + noch + " ' + text + '"');
	time = time+1;
	window.setTimeout("activate()", 1000);
}
else
{
	eval(to+".disabled = false");
	eval(to+".value = \"" + text+ "\"");
	document.getElementById('counter').style.display='none';
	{/literal}
	location.href='index.php?module=download&action=get_file&file_id={$smarty.get.file_id}&pop=1&theme_folder={$smarty.get.theme_folder}&stop=1';
	window.opener.location.reload();
	{literal}
}
}

function redirTo(path,fid,theme)
{
	window.open(path,'DlEx','width=800,height=600,scrollbars=1,menubar=1,location=1,toolbar=1,resizable=1');
	location.href='index.php?module=download&action=get_file&file_id=' + fid + '&pop=1&theme_folder=' +  theme +'&count=1&sub_action=getfile';
}
</script>
{/literal}
{/if}
<table width="100%" border="0" cellpadding="15" cellspacing="1">
  <tr>
    <td class="forum_info_meta" height="270" valign="top" align="center">

	{if $ErrorType=='MaxDownloadsDayReached'}
	<h1>{#Error#}</h1>
	<br />
	<br />
	{#LimitMessage#}

	{elseif $ErrorType=='NoPayUser'}
	<h1>{#Error#}</h1>
	<br />
	<br />
	Внимание:Недостаточная проплата или полное отсутствие проплаты для загрузки файла.
	Если Вы считаете, что произошла ошибка - обратитесь к администрации ресурса.
	{elseif $ErrorType=='ExclDenied'}
	<h1>{#Error#}</h1>
	<br />
	<br />
 	Внимание:Данный файл является эксклюзивным и доступен для загрузки только один раз после оплаты.<br>
 	Если Вы считаете, что произошла ошибка - обратитесь к администрации ресурса.

	{elseif $ErrorType=='FileNotFound'}
	<h1>{#Error#}</h1>
	<br />
	<br />
	{#NotFound#}

	{elseif $ErrorType=='NoPerm'}
	<h1>{#Error#}</h1>
	<br />
	<br />
	{#NoPermLoad#}
	{else}
	<div>
	<h1>{#DownloadT#}</h1>
	<br />
	<br />
	<h1>{$pname}</h1>
	</div>
	<br />
	<form id="name" name="name" method="post" action="index.php?module=download&amp;action=get_file&amp;file_id={$smarty.get.file_id}&amp;pop=1&amp;theme_folder={$smarty.get.theme_folder}&amp;sub_action=getfile">




	{if $Pfad}

	<p>

	<input class="button" type="button" value="{#DownloadStart#}"  onclick="redirTo('{$Pfad}','{$smarty.get.file_id}','{$smarty.get.theme_folder}');" />
	&nbsp;<input type="button" class="button" value="{#Close#}" onClick="window.close()" />
	</p>
	{else}
	<div id="counter" style="display:none">
	<br />
	{#DownloadStartsIn#}<input style="width:10px; background:transparent; border:0px; font-weight:bold" name="name" type="text" id="name" value="" /> {#Seconds#}
	<br />
	</div>
	<p>
	{if $smarty.request.stop==1}
	{else}

	<body onload="document.name.submit(); document.getElementById('counter').style.display=''; activate();"></body>
	{/if}
	<input  class="button" type="submit" value="{#DownloadStart#}"  onclick="document.getElementById('counter').style.display='';activate()" />&nbsp;
	<input type="button" class="button" value="{#Close#}" onClick="window.close()" />
	</p>
	{/if}
	</form>
	{if $FileMirros}
	<strong>{#Mirrors#}</strong>
	<br />
		{foreach from=$FileMirros item=FM}
		<a target="_blank" href="{$FM}">{$FM}</a><br />
		{/foreach}
	{/if}
	{/if}

	</td>
  </tr>
</table>
<p align="center">

</p>
</body>
</html>
