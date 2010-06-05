<?php

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_userpage;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_userpage_items;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_userpage_values;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_userpage_guestbook;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_userpage_template;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_userpage (
  id int(1) unsigned NOT NULL auto_increment,
  group_id tinytext,
  can_comment tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (Id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_userpage_items (
  Id int(10) unsigned NOT NULL auto_increment,
  title varchar(250) NOT NULL default '',
  type varchar(250) NOT NULL default '',
  value text NOT NULL default '',
  active tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (Id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_userpage_values (
  id int(10) unsigned NOT NULL auto_increment,
  uid varchar(15) NOT NULL default '',
  PRIMARY KEY  (Id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_userpage_guestbook (
  id int(10) unsigned NOT NULL auto_increment,
  uid varchar(12) NOT NULL default '',
  ctime varchar(12) NOT NULL default '',
  author varchar(12) NOT NULL default '',
  title varchar(250),
  message text,
  PRIMARY KEY  (Id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_userpage_template (
  id int(1) unsigned NOT NULL auto_increment,
  tpl text NOT NULL default '',
  PRIMARY KEY  (Id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO  CPPREFIX_modul_userpage VALUES ('1', '1', '1');";
$modul_sql_install[] = "INSERT INTO  CPPREFIX_modul_userpage_template VALUES ('1', '
<br />
[cp:header-1]
[cp:header-2]

<div id=\"userpage\">
  <table width=\"100%\" align=\"center\">
    <tr valign=\"top\">
      <td align=\"right\">
        <!-- *********** BENUTZERBOX *********** -->
        <div class=\"mod_userpage_border_profil\">
          <div class=\"mod_userpage_header\">
            <strong>[cp:benutzername] [cp_lang:UPheader]</strong>
            <span class=\"mod_userpage_right\">[cp:onlinestatus]</span>
          </div>

          <div class=\"mod_userpage_profil\">
            <strong>[cp_lang:UPname]:</strong>
            <br />
            [cp:name]
            <br />
            <strong>[cp_lang:UPcountry]:</strong>
            <br />
            [cp:land]
            <br />
            <strong>[cp_lang:UPreg]:</strong>
            <br />
            [cp:registriert]
            <br />
          </div>

          <div class=\"mod_userpage_avatar\">
            [cp:avatar]
          </div>
        </div>
        <br />
        [cp_guestbook:3]
      </td>

      <td width=\"50\"></td>

      <!-- *********** LINKE BOX *********** -->
      <td>
        <div class=\"mod_userpage_border\">
          <div class=\"mod_userpage_header\">
            <strong>[cp_lang:UPabout]</strong>
          </div>

          <div class=\"mod_userpage_content\">
            [cp:interessen]
            [cp:kontakt]
            [cp:webseite]
            [cp:geburtstag]
            [cp:geschlecht]
          </div>
        </div>
      </td>

    </tr>
  </table>

</div><br />
');";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>