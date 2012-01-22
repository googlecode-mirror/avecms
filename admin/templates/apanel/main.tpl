<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>{#MAIN_PAGE_TITLE#} - {*#SUB_TITLE#*} ({$smarty.session.user_name|escape})</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="pragma" content="no-cache" />
<meta name="generator" content="Bluefish 2.0.3" />
<meta name="Expires" content="Mon, 06 Jan 1990 00:00:01 GMT" />
<link href="{$tpl_dir}/css/style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_dir}/js/jquery/css/mbTooltip.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="{$tpl_dir}/js/jquery/jquery.js"></script>
<script type="text/javascript" src="{$tpl_dir}/js/jquery/jquery.form.js"></script>
<script type="text/javascript" src="{$tpl_dir}/js/jquery/plugin/jquery.timers.js"></script>
<script type="text/javascript" src="{$tpl_dir}/js/jquery/plugin/jquery.dropshadow.js"></script>
<script type="text/javascript" src="{$tpl_dir}/js/cpcode.js"></script>
<script type="text/javascript" src="{$tpl_dir}/js/jquery/ui/jquery-ui.min.js"></script>
<link type="text/css" href="{$tpl_dir}/js/jquery/ui/jquery-ui.css" rel="stylesheet" />
<script>
  var ave_path = "{$ABS_PATH}";
  var ave_theme = "{$smarty.const.DEFAULT_THEME_FOLDER}"; 
  var ave_admintpl = "{$tpl_dir}";  
</script>
</head>
<body>
<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td id="tableheader_main">
      <div id="noticeAreaLogin"> <a href="index.php"><strong>{#MAIN_PAGE_TITLE#}</strong><br />
        {#MAIN_LINK_HOME#}</a> </div>
      <div id="noticeAreaProfileSection">
        <div>{#MAIN_USER_ONLINE#} <strong style="color:#fff;">{$smarty.session.user_name|escape}</strong></div>
        <div><a onClick="return confirm('{#MAIN_LOGOUT_CONFIRM#}')" href="admin.php?do=logout">{#MAIN_LINK_LOGOUT#}</a></div>
      </div>
      <div id="noticeAreaReturnToSite"> <a target="_blank" href="../index.php?module=login&action=wys_adm&sub=off"><strong>{#MAIN_LINK_SITE#}</strong></a><br />
        <a target="_blank" href="../index.php?module=login&action=wys_adm&sub=on">{#MAIN_LINK_SITE_GO#}</a>
      </div>
      </div>
    </td>
  </tr>
  {if $smarty.request.do != ''}
  <tr>
    <td valign="top" height="25">
      <div id="mainSectionLinks" style="height:30px;">
        <ul>
          {$navi}
        </ul>
      </div>
    </td>
  </tr>
  {/if}
  <tr>
    <td valign="top" id="content">{$content}</td>
  </tr>
  <tr>
    <td id="tablebottom">{$smarty.const.APP_INFO}</td>
  </tr>
</table>
</body>
</html>