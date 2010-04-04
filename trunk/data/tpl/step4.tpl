{strip}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>{$version_setup}</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link href="data/tpl/style.css" rel="stylesheet" type="text/css" />
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
				<div class="SideTitleLHS">{$la.install_step} <span class="TitleStep">5</span></div>
				<div class="SideTitleRHS">{$la.install_finish_header}</div>
				<div class="clearer">&nbsp;</div>
			</div>
		</div>

		{$la.install_finish_body}

		<table cellspacing="10" cellpadding="0" border="0">
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>

		<div id="clearfooter">&nbsp;</div>

	</div>
</div>

<div id="footer">&nbsp;</div>

</body>
</html>

{/strip}