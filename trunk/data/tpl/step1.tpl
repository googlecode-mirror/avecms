{strip}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>{$version_setup}</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link href="data/tpl/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="data/overlib/overlib.js" type="text/javascript"></script>
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
				<div class="SideTitleLHS">{$la.install_step} <span class="TitleStep">1</span></div>
				<div class="SideTitleRHS">{$la.database_setting}</div>
				<div class="clearer">&nbsp;</div>
			</div>
		</div>

		{if $warnnodb}
			<div class="helpError">{$warnnodb}</div>
		{else}
			<div class="helpTitle">{$la.database_setting_desc}</div>
		{/if}

		<form action="install.php" method="post" enctype="multipart/form-data" name="s" id="s">
			<table cellspacing="10" cellpadding="0" border="0">
				<tr>
					<td>{$la.dbserver}</td>
					<td><input class="text" name="dbhost" type="text" id="dbhost" value="{$dbhost|default:"localhost"}" /></td>
					<td style="padding: 0px 0px 2px 0px;"><a title="{$la.olh_host}" href="#" class="LinkTitleHelp">?</a></td>
				</tr>
				<tr>
					<td>{$la.dbuser}</td>
					<td><input class="text" name="dbuser" type="text" id="dbuser" value="{$dbuser|default:"root"}" /></td>
					<td style="padding: 0px 0px 2px 0px;"><a title="{$la.olh_user}" href="#" class="LinkTitleHelp">?</a></td>
				</tr>
				<tr>
					<td>{$la.dbpass}</td>
					<td><input class="text" name="dbpass" type="text" id="dbpass" value="{$dbpass}" /></td>
					<td style="padding: 0px 0px 2px 0px;"><a href="#" title="{$la.olh_pass}" class="LinkTitleHelp">?</a></td>
				</tr>
				<tr>
					<td>{$la.dbname}</td>
					<td><input class="text" name="dbname" type="text" id="dbname" value="{$dbname}" /></td>
					<td style="padding: 0px 0px 2px 0px;"><a title="{$la.olh_name}" href="#" class="LinkTitleHelp">?</a></td>
				</tr>
				<tr>
					<td>{$la.dbprefix}</td>
					<td><input class="text" name="dbprefix" type="text" id="dbprefix" value="{$dbprefix|default:"$_pref_"}" /></td>
					<td style="padding: 0px 0px 2px 0px;"><a title="{$la.olh_prf}" href="#" class="LinkTitleHelp">?</a></td>
				</tr>
			</table>

			<div class="Item">
				<div class="SideTitle">
					<div class="SideTitleLHS">{$la.install_step} <span class="TitleStep">2</span></div>
					<div class="SideTitleRHS">{$la.install_type}</div>
					<div class="clearer">&nbsp;</div>
				</div>
			</div>

			<table cellspacing="10" cellpadding="0" border="0">
				<tr>
					<td>{$la.install_setting_desc}</td>
					<td>
						<select name="InstallType">
							<option value="1" selected>{$la.install_demo}</option>
							<option value="0">{$la.install_clear}</option>
						</select>
					</td>
				</tr>
			</table>

			<div class="Notice">
				<div class="AlertObject">
					{$la.database_setting_foot}
				</div>
			</div>

			<div align="right">
				<input name="step" type="hidden" id="step" />
				<input name="subaction" type="hidden" id="subaction" value="newset" />
				<input accesskey="e" name="Submit" type="submit" class="button" value="{$la.database_setting_save}" />&nbsp;
				<input onclick="if(confirm('{$la.confirm_exit}')) location.href='data/exit.html'" type="button" class="button" value="{$la.exit}" />
			</div>
		</form>

		<div id="clearfooter">&nbsp;</div>

	</div>
</div>

<div id="footer">&nbsp;</div>

</body>
</html>

{/strip}