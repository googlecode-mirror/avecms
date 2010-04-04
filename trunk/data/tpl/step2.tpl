{strip}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>{$version_setup}</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link href="data/tpl/style.css" rel="stylesheet" type="text/css" />
{* <script language="javascript" src="data/tpl/agree.js" type="text/javascript"></script> *}

<script language="javascript" type="text/javascript">
	var checkobj;

	function agreesubmit(el){ldelim}
		checkobj=el;
		if (document.all||document.getElementById){ldelim}
			for (i=0;i<checkobj.form.length;i++){ldelim}
				var tempobj=checkobj.form.elements[i];
				if (tempobj.type.toLowerCase()=="submit"){ldelim}
					tempobj.disabled=!checkobj.checked;
				{rdelim}
			{rdelim}
		{rdelim}
	{rdelim}

	function defaultagree(el){ldelim}
		if (!document.all&&!document.getElementById){ldelim}
			if (window.checkobj&&checkobj.checked){ldelim}
				return true;
			{rdelim}
			else{ldelim}
				alert("Please read/accept terms to submit form");
				return false;
			{rdelim}
		{rdelim}
	{rdelim}
</script>
</head>

<body>
<div id="container">
	<div id="header">&nbsp;</div>
	<div id="content">
		<div id="pageLogo"><img src="data/tpl/ave_logo.jpg" width="186" height="76" alt="Logotype" /></div>
		<div id="pageHeaderTitle">{$version_setup}</div>
		<div class="clearer">&nbsp;</div>

		<div class="Item">
			<div class="SideTitle">
				<div class="SideTitleLHS">{$la.install_step} <span class="TitleStep">3</span></div>
				<div class="SideTitleRHS">{$la.liztexttitle}</div>
				<div class="clearer">&nbsp;</div>
			</div>
		</div>

		<div class="helpTitle">{$la.liztext}</div>

		<table cellspacing="10" cellpadding="0" border="0">
			<tr>
				<td>
					<div class="databody">
						{include file="../eula/ru.tpl"}
					</div>
				</td>
			</tr>
		</table>

		<form action="install.php" method="post" enctype="multipart/form-data" name="s" id="s" onSubmit="return defaultagree(this)">
			<table cellspacing="5" cellpadding="0" border="0" class="TdNotice">
				<tr>
					<td><input name="agreecheck" type="checkbox" onClick="agreesubmit(this)" /></td>
					<td>{$la.lizagree}</td>
				</tr>
			</table>

			<div align="right">
				<input name="demo" type="hidden" id="demo" value="{$smarty.get.demo}" />
				<input name="step" type="hidden" id="step" value="1" />
				<input accesskey="e" name="Submit" type="submit" class="button" value="{$la.eulaok}" disabled />&nbsp;
				<input onclick="if(confirm('{$la.confirm_exit}')) location.href='data/exit.html'" type="button" class="button" value="{$la.exit}" />
			</div>
		</form>

		<script language="javascript" type="text/javascript">
			document.forms.s.agreecheck.checked=false;
		</script>

		<div id="clearfooter">&nbsp;</div>

	</div>
</div>

<div id="footer">&nbsp;</div>

</body>
</html>

{/strip}