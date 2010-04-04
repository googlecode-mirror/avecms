{$pageheader}
<title>{$pname}</title>
<meta http-equiv="pragma" content="no-cache" />
<meta name="robots" content="noindex,nofollow" />
<link href="templates/{$smarty.request.theme_folder|default:$smarty.session.THEME_FOLDER}/css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="templates/{$smarty.request.theme_folder|default:$smarty.session.THEME_FOLDER}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="templates/{$smarty.request.theme_folder|default:$smarty.session.THEME_FOLDER}/js/common.js" type="text/javascript"></script>
<script src="templates/{$smarty.request.theme_folder|default:$smarty.session.THEME_FOLDER}/overlib/overlib.js" type="text/javascript"></script>
</head>

<body id="forums_pop">
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="500" border="0" align="center" cellpadding="15" cellspacing="0" class="forum_tableborder">
	<tr>
		<td align="center" class="forum_info_meta" style="padding:25px">
			{$content}
		</td>
	</tr>
</table>
<meta http-equiv="refresh" content="3;URL={$GoTo}" />
</body>
</html>
