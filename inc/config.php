<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

// ЧПУ
define('REWRITE_MODE', true);

// транслитерация ЧПУ
define('TRANSLIT_URL', true);

// суфикс ЧПУ
define('URL_SUFF', '/');

// тема публичной части
define('DEFAULT_THEME_FOLDER', 'ave');

// тема панели администратора
define('DEFAULT_ADMIN_THEME_FOLDER', 'apanel');

// язык по умолчанию
define('DEFAULT_LANGUAGE', 'ru');

// хранить сессии в БД
define('SESSION_SAVE_HANDLER', true);

// время жизни сессии (Значение по умолчанию 24 минуты)
define('SESSION_LIFETIME', 60*24);

// время жизни cookie автологина (60*60*24*14 - 2 недели)
define('COOKIE_LIFETIME', 60*60*24*14);

// {true|false} вывод статистики и списка выполненых запросов
define('PROFILING', false);

// {true|false} отправка писем с ошибками MySQL
define('SEND_SQL_ERROR', false);

// {true|false} контролировать изменения tpl файлов (после настройки сайта установить - false)
define('SMARTY_COMPILE_CHECK', true);

// {true|false} консоль отладки Smarty
define('SMARTY_DEBUGGING', false);

// {true|false} Установите это в false если ваше окружение PHP
// не разрешает создание директорий от имени Smarty.
// Поддиректории более эффективны, так что используйте их, если можете.
define('SMARTY_USE_SUB_DIRS', false);

// {true|false} кэширование скомпилированных шаблонов документов
define('CACHE_DOC_TPL', false);

// время жизни кэша (60*60*24 = 1 сутки)
define('CACHE_LIFETIME', 60*60*24*0);

// имя домена используемое для cookie
//define('COOKIE_DOMAIN', '.ave209.ru');

//Yandex MAP API REY
define('YANDEX_MAP_API_KEY', '');

//GOOGLE MAP API REY
define('GOOGLE_MAP_API_KEY', '');

define('APP_NAME', 'AVE.cms');
define('APP_VERSION', '2.09RC1');
define('APP_INFO', APP_NAME . ' ' . APP_VERSION . ' &copy; 2008-2010 <a target="_blank" href="http://www.overdoze.ru/">Overdoze.Ru</a>');

?>