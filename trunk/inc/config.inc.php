<?	//Использовать ЧПУ<br> Адреса вида index.php будут преобразованы в /home/
	define('REWRITE_MODE',true);

	//Использовать транслит в ЧПУ <br> адреса вида /страница/ поменяються на /page/
	define('TRANSLIT_URL',true);

	//Cуффикс ЧПУ
	define('URL_SUFF','/');

	//Тема публичной части
	define('DEFAULT_THEME_FOLDER','ave');

	//Тема панели администратора
	define('DEFAULT_ADMIN_THEME_FOLDER','apanel');

	//Язык по умолчанию
	define('DEFAULT_LANGUAGE','ru');

	//Хранить сессии в БД
	define('SESSION_SAVE_HANDLER',false);

	//Время жизни сессии (Значение по умолчанию 24 минуты)
	define('SESSION_LIFETIME',604800);

	//Время жизни cookie автологина (60*60*24*14 - 2 недели)
	define('COOKIE_LIFETIME',1209600);

	//Вывод статистики и списка выполненых запросов
	define('PROFILING',false);

	//Отправка писем с ошибками MySQL
	define('SEND_SQL_ERROR',false);

	//Контролировать изменения tpl файлов <br>После настройки сайта установить - false
	define('SMARTY_COMPILE_CHECK',true);

	//Консоль отладки Smarty
	define('SMARTY_DEBUGGING',false);

	//Создание папок для кэширования <br>Установите это в false если ваше окружение PHP не разрешает создание директорий от имени Smarty. Поддиректории более эффективны, так что используйте их, если можете.
	define('SMARTY_USE_SUB_DIRS',true);

	//Кэширование скомпилированных шаблонов документов
	define('CACHE_DOC_TPL',true);

	//Время жизни кэша (300 = 5 минут)
	define('CACHE_LIFETIME',604800);

	//Yandex MAP API REY
	define('YANDEX_MAP_API_KEY','');

	//Google MAP API REY
	define('GOOGLE_MAP_API_KEY','');

	//Адрес Memcached сервера
	define('Memcached_Server','');

	//Порт Memcached сервера
	define('Memcached_Port','');

	//Версия сборки
	define('BILD_VERSION',320);
	
	//Проверка обновлений
	define('SVN_ACTIVE',false);

	//Логин от SVN репозитария
	define('SVN_LOGIN','public');

	//Пароль от SVN репозитария
	define('SVN_PASSWORD','public');

?>