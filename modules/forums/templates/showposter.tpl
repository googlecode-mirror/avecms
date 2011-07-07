{$header}
<title>{#TitlePostings#}</title>
<meta http-equiv="pragma" content="no-cache" />
<meta name="robots" content="index,follow" />
<link href="templates/{$smarty.request.theme_folder|escape}/css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="templates/{$smarty.request.theme_folder|escape}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="templates/{$smarty.request.theme_folder|escape}/js/common.js" type="text/javascript"></script>
<script src="templates/{$smarty.request.theme_folder|escape}/overlib/overlib.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
<!--
window.moveTo(1,1);
//-->
</script>
</head>
<body id="forums_pop">
	<table width="100%" border="0" cellpadding="15" cellspacing="1">
		<tr>
			<td class="forum_info_meta">
				<table width="100%" border="0" cellpadding="4" cellspacing="1">
					<tr>
						<td class="forum_header"><strong>{#Author#}</strong></td>
						<td class="forum_header"><strong>{#Postings#}</strong></td>
					</tr>
					{foreach from=$poster item=post}
						<tr>
							<td><a target="_blank" href="index.php?module=forums&amp;show=userprofile&amp;user_id={$post->BenutzerId}">{$post->BenutzerName}</a></td>
							<td>{$post->ucount}</td>
						</tr>
					{/foreach}
				</table>
			</td>
		</tr>
	</table>

	<p align="center"><input type="button" class="button" value="{#Close#}" onClick="window.close()" /></p>
</body>
</html>