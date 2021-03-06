<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

define('APP_NAME', 'AVE.cms');
define('APP_VERSION', '2.09RC2');
define('APP_INFO',' &copy; 2008-2012 <a target="_blank" href="http://www.overdoze.ru/">Overdoze.Ru</a>');

$GLOBALS['CMS_CONFIG']['REWRITE_MODE']=Array('DESCR' =>'Использовать ЧПУ<br> Адреса вида index.php будут преобразованы в /home/','default'=>true,'TYPE'=>'bool','VARIANT'=>''); 
$GLOBALS['CMS_CONFIG']['TRANSLIT_URL']=Array('DESCR' =>'Использовать транслит в ЧПУ <br> адреса вида /страница/ поменяються на /page/','default'=>true,'TYPE'=>'bool','VARIANT'=>''); 
$GLOBALS['CMS_CONFIG']['URL_SUFF']=Array('DESCR' =>'Cуффикс ЧПУ','default'=>'/','TYPE'=>'string','VARIANT'=>'');
$themes=array();
foreach (glob(dirname(dirname(__FILE__))."/templates/*") as $filename) {
	if(is_dir($filename))$themes[]=basename($filename);
}
$GLOBALS['CMS_CONFIG']['DEFAULT_THEME_FOLDER']=Array('DESCR' =>'Тема публичной части','default'=>'ave','TYPE'=>'dropdown','VARIANT'=>$themes); 
$themes=array();
foreach (glob(dirname(dirname(__FILE__))."/admin/templates/*") as $filename) {
	if(is_dir($filename))$themes[]=basename($filename);
}
$GLOBALS['CMS_CONFIG']['DEFAULT_ADMIN_THEME_FOLDER']=Array('DESCR' =>'Тема панели администратора','default'=>'apanel','TYPE'=>'dropdown','VARIANT'=>$themes);
$GLOBALS['CMS_CONFIG']['UPLOAD_AVATAR_DIR'] = array('DESCR' =>'Директория для хранения аватаров','default'=>'uploads/avatars','TYPE'=>'string','VARIANT'=>'');
$GLOBALS['CMS_CONFIG']['DEFAULT_LANGUAGE']=Array('DESCR' =>'Язык по умолчанию','default'=>'ru','TYPE'=>'dropdown','VARIANT'=>array('ru','en','ua')); 
$GLOBALS['CMS_CONFIG']['SESSION_SAVE_HANDLER']=Array('DESCR' =>'Хранить сессии в БД','default'=>false,'TYPE'=>'bool','VARIANT'=>''); 
$GLOBALS['CMS_CONFIG']['SESSION_LIFETIME']=Array('DESCR' =>'Время жизни сессии (Значение по умолчанию 24 минуты)','default'=>60*24,'TYPE'=>'integer','VARIANT'=>''); 
$GLOBALS['CMS_CONFIG']['COOKIE_LIFETIME']=Array('DESCR' =>'Время жизни cookie автологина (60*60*24*14 - 2 недели)','default'=>60*60*24*14,'TYPE'=>'integer','VARIANT'=>''); 
$GLOBALS['CMS_CONFIG']['PROFILING']=Array('DESCR' =>'Вывод статистики и списка выполненых запросов','default'=>false,'TYPE'=>'bool','VARIANT'=>''); 
$GLOBALS['CMS_CONFIG']['SEND_SQL_ERROR']=Array('DESCR' =>'Отправка писем с ошибками MySQL','default'=>false,'TYPE'=>'bool','VARIANT'=>''); 
$GLOBALS['CMS_CONFIG']['SMARTY_COMPILE_CHECK']=Array('DESCR' =>'Контролировать изменения tpl файлов <br>После настройки сайта установить - false','default'=>true,'TYPE'=>'bool','VARIANT'=>''); 
$GLOBALS['CMS_CONFIG']['SMARTY_DEBUGGING']=Array('DESCR' =>'Консоль отладки Smarty','default'=>false,'TYPE'=>'bool','VARIANT'=>''); 
$GLOBALS['CMS_CONFIG']['SMARTY_USE_SUB_DIRS']=Array('DESCR' =>'Создание папок для кэширования <br>Установите это в false если ваше окружение PHP не разрешает создание директорий от имени Smarty. Поддиректории более эффективны, так что используйте их, если можете.','default'=>false,'TYPE'=>'bool','VARIANT'=>''); 
$GLOBALS['CMS_CONFIG']['CACHE_DOC_TPL']=Array('DESCR' =>'Кэширование скомпилированных шаблонов документов','default'=>true,'TYPE'=>'bool','VARIANT'=>''); 
$GLOBALS['CMS_CONFIG']['CACHE_LIFETIME']=Array('DESCR' =>'Время жизни кэша (300 = 5 минут)','default'=>0,'TYPE'=>'integer','VARIANT'=>''); 
$GLOBALS['CMS_CONFIG']['YANDEX_MAP_API_KEY']=Array('DESCR' =>'Yandex MAP API REY','default'=>'','TYPE'=>'string','VARIANT'=>'');
$GLOBALS['CMS_CONFIG']['GOOGLE_MAP_API_KEY']=Array('DESCR' =>'Google MAP API REY','default'=>'','TYPE'=>'string','VARIANT'=>'');
$GLOBALS['CMS_CONFIG']['Memcached_Server']=Array('DESCR' =>'Адрес Memcached сервера','default'=>'','TYPE'=>'string','VARIANT'=>'');
$GLOBALS['CMS_CONFIG']['Memcached_Port']=Array('DESCR' =>'Порт Memcached сервера','default'=>'','TYPE'=>'string','VARIANT'=>'');
$GLOBALS['CMS_CONFIG']['SVN_ACTIVE'] = array('DESCR' =>'Проверка обновлений','default'=>false,'TYPE'=>'bool','VARIANT'=>'');
$GLOBALS['CMS_CONFIG']['SVN_URL'] = array('DESCR' =>'Адрес SVN репозитария (включая папку, изменения которой Вас интересуют, например, trunk)','default'=>'http://avecms.googlecode.com/svn/trunk/','TYPE'=>'string','VARIANT'=>'');
$GLOBALS['CMS_CONFIG']['SVN_LINK'] = array('DESCR' =>'Часть ссылки SVN репозитария до номера ревизии для просмотра информации','default'=>'http://code.google.com/p/avecms/source/detail?r=','TYPE'=>'string','VARIANT'=>'');
$GLOBALS['CMS_CONFIG']['SVN_LOGIN'] = array('DESCR' =>'Логин для SVN репозитария','default'=>'','TYPE'=>'string','VARIANT'=>'');
$GLOBALS['CMS_CONFIG']['SVN_PASSWORD'] = array('DESCR' =>'Пароль для SVN репозитария','default'=>'','TYPE'=>'string','VARIANT'=>'');

@include(dirname(dirname(__FILE__)).'/inc/config.inc.php');
foreach($GLOBALS['CMS_CONFIG'] as $k=>$v)
{
	if(!defined($k))
		define($k,$v['default']);
}

?>