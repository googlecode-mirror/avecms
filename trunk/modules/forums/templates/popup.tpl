{$pageheader}
<title>{$pname}</title>
<meta http-equiv="pragma" content="no-cache" />
<meta name="robots" content="noindex,nofollow" />
<link href="templates/{$smarty.request.theme_folder}/css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="templates/{$smarty.request.theme_folder}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="templates/{$smarty.request.theme_folder}/js/common.js" type="text/javascript"></script>
<script src="templates/{$smarty.request.theme_folder}/overlib/overlib.js" type="text/javascript"></script>
</head>
<body id="forums_pop">
<table width="100%" border="0" cellpadding="15" cellspacing="1">
  <tr>
    <td class="forum_info_meta">
	{$content}
	  </td>
  </tr>
</table>
<p align="center">
<input type="button" class="button" value="{#FORUMS_BUTTON_CLOSE#}" onclick="window.close()" />
</p>
</body>
</html>
