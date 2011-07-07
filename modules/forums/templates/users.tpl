{$header}
<title>{#UserpopName#}</title>
<meta http-equiv="pragma" content="no-cache" />
<meta name="robots" content="index,follow" />
<link href="templates/{$smarty.request.theme_folder}/css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="templates/{$smarty.request.theme_folder}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="templates/{$smarty.request.theme_folder}/js/common.js" type="text/javascript"></script>
<script src="templates/{$smarty.request.theme_folder}/overlib/overlib.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
<!--
window.moveTo(1,1);
//-->
</script>
</head>
<script language="javascript" src="modules/forums/js/common.js"></script>
<body id="forums_pop">
	<table width="100%" border="0" cellpadding="15" cellspacing="1">
		<tr>
			<td class="forum_info_meta">
				<form method="post" action="index.php?module=forums&show=userpop&pop=1&theme_folder={$smarty.get.theme_folder}">
					<table width="100%" border="0" cellspacing="0" cellpadding="3">
						<tr>
							<td colspan="2" class="forum_header"><strong>{#UserPopSearchTo#}</strong></td>
						</tr>
						<tr>
							<td width="100">{#UserpopSearchT#}</td>
							<td><input name="BenutzerName" type="text" id="BenutzerName" value="{$smarty.request.BenutzerName|escape:html|stripslashes}" ></td>
						</tr>
						<tr>
							<td>{#UserpopMatch#}</td>
							<td>
								<input type="radio" name="Phrase" value="1" {if $smarty.post.Phrase=='1'}checked{/if}>{#MatchExact#}
								<input type="radio" name="Phrase" value="2" {if $smarty.post.Phrase=='' || $smarty.post.Phrase=='2'}checked{/if}>{#MatchLike#}
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" class="button" value="{#UserpopSearch#}"></td>
						</tr>
					</table>
				</form><br />

				<table width="100%" border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">
					<tr>
						<td class="forum_header"><strong>{#UserpopUName#}</strong></td>
						<td class="forum_header"><strong>{#UserpopUId#}</strong></td>
					</tr>
					{foreach from=$poster item=post}
						<tr class="{cycle name='' values='forum_post_first,forum_post_second'}">
							<td><a title="{#UserPopInsertInf#}" class="forum_links_small" href="javascript:void(0);" onClick="unametofield('{$post->BenutzerName}')">{$post->BenutzerName|truncate:40}</a></td>
							<td><a title="{#UserPopInsertInf#}" class="forum_links_small" href="javascript:void(0);" onClick="unametofield('{$post->BenutzerId}')">{$post->BenutzerId}</a></td>
						</tr>
					{/foreach}
				</table><br />
				{$nav}
			</td>
		</tr>
	</table>

	<p align="center"><input type="button" class="button" value="{#Close#}" onClick="window.close()" /></p>
</body>
</html>