{$pageheader}
<title>{$pname}</title>
<meta http-equiv="pragma" content="no-cache" />
<meta name="robots" content="noindex,nofollow" />
<link href="templates/{$smarty.request.theme_folder|default:$smarty.session.THEME_FOLDER|escape}/css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="templates/{$smarty.request.theme_folder|default:$smarty.session.THEME_FOLDER|escape}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="templates/{$smarty.request.theme_folder|default:$smarty.session.THEME_FOLDER|escape}/js/common.js"></script>
<script src="templates/{$smarty.request.theme_folder|default:$smarty.session.THEME_FOLDER|escape}/overlib/overlib.js"></script>
</head>

<body id="guest_pop">
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="100%" border="0" align="center" cellpadding="15" cellspacing="0" class="guest_tableborder">
	<tr>
		<td align="center" class="guest_info_meta" style="padding:25px">
			{$content}
		</td>
	</tr>
</table>
<meta http-equiv="refresh" content="3;URL={$GoTo}" />
</body>
</html>