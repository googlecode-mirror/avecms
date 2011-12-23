<?php
include_once("phpsvnclient.php");
$svn  = new phpsvnclient;
$svn->setRepository("http://avecms.googlecode.com/svn/trunk/");
$svn->setAuth(SVN_LOGIN, SVN_PASSWORD);

$log_svn = $svn->getRepositoryLogs(BILD_VERSION);
$AVE_Template->assign('log_svn', $log_svn);
?>