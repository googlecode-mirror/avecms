<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>{$version_setup}</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link href="data/tpl/style.css" rel="stylesheet" type="text/css" />

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
				alert("Please read and accept terms to submit");
				return false;
			{rdelim}
		{rdelim}
	{rdelim}
</script>

</head>

<body id="body">

<div class="wrapper">
	<div class="step step_1"></div>
	<h1 align="right">{$la.liztexttitle}</h1>
	<p>&nbsp;</p>
	<div class="eula">
		{include file="../eula/ru.tpl"}
	</div>
	<form action="install.php" method="post" enctype="multipart/form-data" name="s" id="s" onSubmit="return defaultagree(this)">
		<label><input name="agreecheck" type="checkbox" onClick="agreesubmit(this)" />&nbsp;<span class="small">{$la.lizagree}</span></label>
		<input name="force" type="hidden" id="force" value="{$smarty.request.force|escape|stripslashes}" />
		<input name="step" type="hidden" id="step" value="2" />
		<div align="center" class="go_buttons">
			<input accesskey="e" name="Submit" type="submit" class="button" value="{$la.eulaok}" disabled />
			<input onclick="if(confirm('{$la.confirm_exit}')) location.href='data/exit.html'" type="button" class="button" value="{$la.exit}" />
		</div>
	</form>
	
	<script language="javascript" type="text/javascript">
		document.forms.s.agreecheck.checked=false;
	</script>
</div>

</body>
</html>