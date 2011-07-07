<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>{$titel}</title>
<link href="templates/{$smarty.request.theme_folder}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="templates/{$smarty.request.theme_folder}/js/common.js" type="text/javascript"></script>
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
  <input onclick="window.close();" type="button" class="button" value="{#Close#}" />
</body>
</html>