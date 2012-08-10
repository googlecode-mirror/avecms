<?php
define('BILD_VERSION',file_get_contents(BASE_DIR . '/inc/current_revision.txt'));
if (SVN_ACTIVE == true) {
	include_once("phpsvnclient.php");
	$svn =  new phpsvnclient(SVN_URL);
	$svn -> setAuth(SVN_LOGIN,SVN_PASSWORD);
	$last_rev = $svn -> getVersion();
	if ($last_rev > BILD_VERSION) {
		$log_svn = $svn -> getRepositoryLogs("",(int)BILD_VERSION+1,$last_rev);
		$AVE_Template->assign('log_svn',$log_svn);
		$AVE_Template->assign('svn_link',SVN_LINK);
		$AVE_Template->assign('svn_url',SVN_URL);
	}
}
?>