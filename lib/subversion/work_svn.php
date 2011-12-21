<?php
include_once("phpsvnclient.php");
$svn  = new phpsvnclient;
$svn->setRepository("http://svn.1gb.ru/avecms");
$svn->setAuth(SVN_LOGIN, SVN_PASSWORD);

$log_svn = $svn->getRepositoryLogs(BILD_VERSION);
$AVE_Template->assign('log_svn', $log_svn);
?>