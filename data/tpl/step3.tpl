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
				<div class="SideTitleLHS">{$la.install_step} <span class="TitleStep">4</span></div>
				<div class="SideTitleRHS">{$la.stepstatus}</div>
				<div class="clearer">&nbsp;</div>
			</div>
		</div>

		<div class="helpTitle">{$la.header_logindata}</div>

		{if $errors}
			{foreach from=$errors item="error"}
				<div class="helpError">&bull; {$error}</div>
			{/foreach}
		{/if}

		<form action="install.php" method="post" enctype="multipart/form-data" name="s" id="s">
			<table cellspacing="10" cellpadding="0" border="0">
				<tr>
					<td>* {$la.username}</td>
					<td><input style="width:250px"  class="text" name="username" type="text" id="username" value="Admin" /></td>
				</tr>
				<tr>
					<td>* {$la.email}</td>
					<td><input style="width:250px"  class="text" name="email" type="text" id="email" value="{$email|escape:"html"}" /></td>
				</tr>
				<tr>
					<td>* {$la.password}</td>
					<td><input style="width:250px"  class="text" name="pass" type="password" id="pass" value="{$pass|escape:"html"}" /></td>
				</tr>
{*
				<tr>
					<td>{$la.firstname}</td>
					<td><input style="width:250px"  class="text" name="firstname" type="text" id="firstname" value="{$smarty.request.firstname|escape:'html'}" /></td>
				</tr>
				<tr>
					<td>{$la.lastname}</td>
					<td><input style="width:250px"  class="text" name="lastname" type="text" id="lastname" value="{$smarty.request.lastname|escape:'html'}" /></td>
				</tr>
				<tr>
					<td>{$la.street}</td>
					<td>
						<input style="width:250px"  class="text" name="street" type="text" id="street" value="{$smarty.request.street|escape:'html'}" />
						<input style="width:40px"  class="text" name="hnr" type="text" id="hnr" value="{$smarty.request.hnr|escape:'html'}" />
					</td>
				</tr>
				<tr>
					<td>{$la.zip} / {$la.town}</td>
					<td>
						<input style="width:40px" class="text" name="zip" type="text" id="zip" value="{$smarty.request.zip|escape:'html'}" />
						<input style="width:250px" class="text" name="town" type="text" id="town" value="{$smarty.request.town|escape:'html'}" />
					</td>
				</tr>
				<tr>
					<td>{$la.phone}</td>
					<td><input style="width:250px" class="text" name="fon" type="text" id="fon" value="{$smarty.request.fon|default:''|escape:'html'}" /></td>
				</tr>
*}
			</table>

			<div class="Notice">
				<div class="AlertObject">
					{$la.loginstar}
				</div>
			</div>

			<div align="right">
				<input name="demo" type="hidden" id="demo" value="{$smarty.get.demo}" />
				<input name="step" type="hidden" id="step" value="3" />
				<input name="substep" type="hidden" id="substep" value="final" />
				<input name="Senden"type="submit" class="button" onclick="document.s.sumit.disabled();" value="{$la.button_setup_final}" />
			</div>
		</form>

		<div id="clearfooter">&nbsp;</div>

	</div>
</div>

<div id="footer">&nbsp;</div>

</body>
</html>

{/strip}