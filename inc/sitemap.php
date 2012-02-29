<?
header("Content-type: text/xml");
@date_default_timezone_set('Europe/Moscow');

define('START_MICROTIME', microtime());
define('BASE_DIR', str_replace("\\", "/", dirname(dirname(__FILE__))));
if (! @filesize(BASE_DIR . '/inc/db.config.php')) { header('Location:install.php'); exit; }
if (! empty($_REQUEST['thumb'])) {require(BASE_DIR . '/functions/func.thumbnail.php'); exit; }
if(substr($_SERVER['REQUEST_URI'],0,strlen('/index.php?'))!='/index.php?'){$_SERVER['REQUEST_URI']=str_ireplace('_','-',$_SERVER['REQUEST_URI']);}
$domain='http://'.str_ireplace('www.','',$_SERVER['SERVER_NAME']).'/';
require(BASE_DIR . '/inc/init.php');
echo '<?xml version="1.0" encoding="UTF-8"?>';

?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc><?php echo $domain;?></loc>
    <lastmod><?php echo date("Y-m-d");?></lastmod>
    <changefreq>always</changefreq>
  </url>
  <?
$sql="SELECT 
 document_alias,
 document_changed 
FROM ".PREFIX."_documents 
where 
 document_status=1
 AND document_expire>UNIX_TIMESTAMP()
";
$res=$AVE_DB->Query($sql);
while($row=$res->FetchAssocArray()){
?>
  <url>
    <loc><?php echo $domain.$row['document_alias'];?>/</loc>
    <lastmod><?php echo date("Y-m-d",$row["document_changed"])?></lastmod>
    <changefreq>weekly</changefreq>
  </url>
  <?
}
?>
</urlset>
