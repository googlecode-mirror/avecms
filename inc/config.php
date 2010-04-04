<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

$config['mod_rewrite']                = '1';          // {1|0} ЧПУ
$config['url_suff']                   = '.html';      // суфикс ЧПУ
$config['default_theme_folder']       = 'ave';        // тема публичной части
$config['default_admin_theme_folder'] = 'apanel';     // тема панели администратора
$config['default_language']           = 'ru';         // язык по умолчанию
$config['session_save_handler']       = true;         // хранить сессии в БД
$config['session_lifetime']           = 60*24;        // время жизни сессии (Значение по умолчанию 24 минуты)
$config['cookie_lifetime']            = 60*60*24*14;  // время жизни cookie автологина (60*60*24*14 - 2 недели)
$config['sql_debug']                  = false;        // {true|false} вывод статистики и списка выполненых запросов
$config['sql_error']                  = false;        // {true|false} отправка писем с ошибками MySQL
$config['compile_check']              = false;        // {true|false} контролировать изменения tpl файлов (после настройки сайта установить - false)
$config['debugging']                  = false;        // {true|false} консоль отладки Smarty
$config['cache_doc_tpl']              = false;        // {true|false} кэширование скомпилированных шаблонов документов
$config['cache_lifetime']             = 60*60*24;     // время жизни кэша (60*60*24 - 1 сутки)
$config['cookie_domain']              = '.ave209.ru'; // имя домена используемое для cookie

?>