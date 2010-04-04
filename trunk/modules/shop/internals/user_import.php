<?php

if (!defined('USER_IMPORT')) exit;

$csv_available_fields = array(
	'Id'             => $GLOBALS['config_vars']['UserImport_Id'],
	'Kennwort'       => $GLOBALS['config_vars']['UserImport_Kennwort'],
	'Email'          => $GLOBALS['config_vars']['UserImport_Email'],
	'Strasse'        => $GLOBALS['config_vars']['UserImport_Strasse'],
	'HausNr'         => $GLOBALS['config_vars']['UserImport_HausNr'],
	'Postleitzahl'   => $GLOBALS['config_vars']['UserImport_Postleitzahl'],
	'city'           => $GLOBALS['config_vars']['UserImport_City'],
	'Telefon'        => $GLOBALS['config_vars']['UserImport_Telefon'],
	'Telefax'        => $GLOBALS['config_vars']['UserImport_Telefax'],
	'Bemerkungen'    => $GLOBALS['config_vars']['UserImport_Bemerkungen'],
	'Vorname'        => $GLOBALS['config_vars']['UserImport_Vorname'],
	'Nachname'       => $GLOBALS['config_vars']['UserImport_Nachname'],
	'UserName'       => $GLOBALS['config_vars']['UserImport_UserName'],
	'Benutzergruppe' => $GLOBALS['config_vars']['UserImport_Benutzergruppe'],
	'Registriert'    => $GLOBALS['config_vars']['UserImport_Registriert'],
	'Status'         => $GLOBALS['config_vars']['UserImport_Status'],
	'ZuletztGesehen' => $GLOBALS['config_vars']['UserImport_ZuletztGesehen'],
	'Land'           => $GLOBALS['config_vars']['UserImport_Land'],
	'GebTag'         => $GLOBALS['config_vars']['UserImport_GebTag'],
	'emc'            => $GLOBALS['config_vars']['UserImport_emc'],
	'IpReg'          => $GLOBALS['config_vars']['UserImport_IpReg'],
	'new_pass'       => $GLOBALS['config_vars']['UserImport_newPass'],
	'Firma'          => $GLOBALS['config_vars']['UserImport_Firma'],
	'UStPflichtig'   => $GLOBALS['config_vars']['UserImport_UStPflichtig']
);

$AVE_Template->assign('method', 'shop');
$AVE_Template->assign('next', 0);

if (!empty($_REQUEST['sub']))
{
	switch ($_REQUEST['sub'])
	{
		case 'importcsv':
			$TempDir = BASE_DIR . '/modules/shop/uploads/';
			$tpl_in = $AVE_Template->fetch($tpl_dir . 'shop_import_user.tpl');
			$error = false;
			$gone = true;
			$ValidFiles = array('text/csv','text/plain', 'application/csv', 'application/octet-stream', 'text/comma-separated-values', 'text/x-comma-separated-values', 'text/x-csv', 'application/vnd.ms-excel');
			if (isset($_FILES['csvfile']) && ( !in_array($_FILES['csvfile']['type'],$ValidFiles) ) )
			{
				$AVE_Template->assign('error',  $GLOBALS['config_vars']['ImportDataWrong']);
				$AVE_Template->assign('content', $tpl_in);
				$error = true;
				$gone = false;
			}

			// ========================================================
			// Datei leer?
			// ========================================================
			if (($error == true || !isset($_FILES['csvfile']) || $_FILES['csvfile']['size']<10) && ($gone == true))
			{
				$AVE_Template->assign('error', $GLOBALS['config_vars']['ImportNoData']);
				$AVE_Template->assign('content', $tpl_in);
				$error = true;
			}

			// ========================================================
			// In den temporären Ordner kopieren
			// ========================================================
			if ($error == false)
			{
				$fileid = md5(microtime().time().mt_rand(0, 1000));
				if (!move_uploaded_file($_FILES['csvfile']['tmp_name'], $TempDir . '/CSVIMPORT_user_' . $_SESSION['user_id'] . '_'.$fileid.'.txt'))
				{
					$AVE_Template->assign('error', $GLOBALS['config_vars']['ImportNotReadable']);
					$AVE_Template->assign('content', $tpl_in);
				}

				// ========================================================
				// Datei öffnen und Kopfzeile einlesen
				// ========================================================
				$fp = fopen($TempDir . '/CSVIMPORT_user_' . $_SESSION['user_id'] . '_'.$fileid.'.txt', 'r');
				$csv = new CSVReader($fp);
				$fields = $csv->Fields();
				fclose($fp);

				// ========================================================
				// valid?
				// ========================================================
				if ($csv->NumFields() < 1)
				{
					$AVE_Template->assign('error', $GLOBALS['config_vars']['ImportDataError']);
					$AVE_Template->assign('content', $tpl_in);
				}

				// ========================================================
				// Try to guess the fields
				// ========================================================
				$field_table = array();
				foreach ($fields as $csv_field)
				{
					$my_field = @$csv_assocs[$csv_field];
					if ($csv_field != 'Geloescht' && $csv_field != 'GeloeschtDatum')
					{
						$field_table[] = array(
						'id'		=> md5($csv_field),
						'csv_field'	=> $csv_field,
						'my_field'	=> $my_field
						);
					}
				}

				$ugroups = array();
				$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_user_groups");
				while ($row = $sql->FetchRow())
				{
					array_push($ugroups, $row);
				}

				// ========================================================
				// Werte zuweisen
				// ========================================================
				$AVE_Template->assign('Ugroups', $ugroups);
				$AVE_Template->assign('fileid', $fileid);
				$AVE_Template->assign('field_table', $field_table);
				$AVE_Template->assign('available_fields', $csv_available_fields);
				$AVE_Template->assign('next', 1);
				$AVE_Template->assign('datas', $csv->NumFields());
				$AVE_Template->assign('content', $tpl_in);
			}
			if ($error == true)
			{
				$AVE_Template->assign('content', $tpl_in);
			}
			break;

		case 'importcsv2':
			$error=false;
			$TempDir = BASE_DIR . '/modules/shop/uploads/';
			// ========================================================
			// Nach temporärere Datei suchen...
			// ========================================================
			$fileid = ereg_replace('([^0-9a-zA-Z]*)', '', $_REQUEST['fileid']);
			if (!file_exists($TempDir . '/CSVIMPORT_user_' . $_SESSION['user_id'] . '_'.$fileid.'.txt'))
			{
				$AVE_Template->assign('error', $GLOBALS['config_vars']['ImportNotReadable']);
				$AVE_Template->assign('content', $tpl_in);
				$error = true;
			}

			switch ($_REQUEST['existing'])
			{
				case 'replace': $existing = 'replace'; break;
				case 'ignore' : $existing = 'ignore';  break;
				default       : $existing = 'replace'; break;
			}

			// ========================================================
			// Datei öffnen
			// ========================================================
			$fp = fopen($TempDir . '/CSVIMPORT_user_' . $_SESSION['user_id'] . '_'.$fileid.'.txt', 'r');
			$csv = new CSVReader($fp);
			$fields = $csv->Fields();

			if ($error == true)
			{
				$AVE_Template->assign('content', $tpl_in);
			}

			while ($row = $csv->FetchRow())
			{
				if (count($row) == $csv->NumFields())
				{
					$Id             = '';
					$Kennwort       = '';
					$Email          = '';
					$Strasse        = '';
					$HausNr         = '';
					$Postleitzahl   = '';
					$City            = '';
					$Telefon        = '';
					$Telefax        = '';
					$Bemerkungen    = '';
					$Vorname        = '';
					$Nachname       = '';
					$UserName       = '';
					$Benutzergruppe = '';
					$Registriert    = '';
					$Status         = '';
					$ZuletztGesehen = '';
					$Land           = '';
					$GebTag         = '';
					$emc            = '';
					$IpReg          = '';
					$new_pass       = '';
					$Firma          = '';
					$UStPflichtig   = '';

					$i = 0;

					foreach ($row as $key=>$value)
					{
						// ========================================================
						// Feld erkennen...
						// ========================================================
						$field = @$_REQUEST['field_' . md5($key)];
						switch ($field)
						{
							case 'Id'             : $Id = $value; break;
							case 'Kennwort'       : $Kennwort = $value; break;
							case 'Email'          : $Email = $value; break;
							case 'Strasse'        : $Strasse = $value; break;
							case 'HausNr'         : $HausNr = $value; break;
							case 'Postleitzahl'   : $Postleitzahl = $value; break;
							case 'city'           : $city = $value; break;
							case 'Telefon'        : $Telefon = $value; break;
							case 'Telefax'        : $Telefax = $value; break;
							case 'Bemerkungen'    : $Bemerkungen = $value; break;
							case 'Vorname'        : $Vorname = $value; break;
							case 'Nachname'       : $Nachname = $value; break;
							case 'UserName'       : $UserName = $value; break;
							case 'Benutzergruppe' : $Benutzergruppe = $value; break;
							case 'Registriert'    : $Registriert = $value; break;
							case 'Status'         : $Status = $value; break;
							case 'ZuletztGesehen' : $ZuletztGesehen = $value; break;
							case 'Land'           : $Land = $value; break;
							case 'GebTag'         : $GebTag = $value; break;
							case 'emc'            : $emc = $value; break;
							case 'IpReg'          : $IpReg = $value; break;
							case 'new_pass'       : $new_pass = $value; break;
							case 'Firma'          : $Firma = $value; break;
							case 'UStPflichtig'   : $UStPflichtig = $value; break;
						}

					}

					// ========================================================
					// Wenn Produkt existiert, nicht aktualisieren
					// ========================================================
					if (trim($Id) != '')
					{
						$update = false;
						if ($existing == 'replace')
						{
							$sql = $AVE_DB->Query("
								SELECT COUNT(*)
								FROM " . PREFIX . "_users
								WHERE Id = '" . $Id . "'
							");
							$row = $sql->FetchArray();
							if ($row[0] > 0)
							$update = true;
						}

						if ($update)
						{
							$Benutzergruppe = (isset($_REQUEST['Benutzergruppe']) && $_REQUEST['Benutzergruppe'] != 'FILE') ? $_REQUEST['Benutzergruppe'] : $Benutzergruppe;

							$AVE_DB->Query("
								UPDATE " . PREFIX . "_users
								SET
									Kennwort       = '" . $Kennwort . "',
									Email          = '" . $Email . "',
									Strasse        = '" . $Strasse . "',
									HausNr         = '" . $HausNr . "',
									Postleitzahl   = '" . $Postleitzahl . "',
									city           = '" . $city . "',
									Telefon        = '" . $Telefon . "',
									Telefax        = '" . $Telefax . "',
									Bemerkungen    = '" . $Bemerkungen . "',
									Vorname        = '" . $Vorname . "',
									Nachname       = '" . $Nachname . "',
									`UserName`     = '" . $UserName . "',
									Benutzergruppe = '" . $Benutzergruppe . "',
									Registriert    = '" . $Registriert . "',
									Status         = '" . $Status . "',
									ZuletztGesehen = '" . $ZuletztGesehen . "',
									Land           = '" . $Land . "',
									GebTag         = '" . $GebTag . "',
									emc            = '" . $emc . "',
									IpReg          = '" . $IpReg . "',
									new_pass       = '" . $new_pass . "',
									Firma          = '" . $Firma . "',
									UStPflichtig   = '" . $UStPflichtig . "'
								WHERE
									Id  = '" . $Id . "'
								AND
									Id != '" . $_SESSION['user_id'] . "'
							");
						}
						else
						{
							if (isset($_REQUEST['DelData']) && $_REQUEST['DelData'] == '1')
							{
								$AVE_DB->Query("DELETE FROM " . PREFIX . "_users WHERE Id != '" . $_SESSION['user_id'] . "'");
								$AVE_DB->Query("ALTER TABLE " . PREFIX . "_users PACK_KEYS = 0 CHECKSUM = 0 DELAY_KEY_WRITE = 0 AUTO_INCREMENT = 1");
							}

							if ($Id != $_SESSION['user_id']) {
								$AVE_DB->Query("
									INSERT
									INTO " . PREFIX . "_users
									SET
										Id             = '" . $Id . "',
										Kennwort       = '" . $Kennwort . "',
										Email          = '" . $Email . "',
										Strasse        = '" . $Strasse . "',
										HausNr         = '" . $HausNr . "',
										Postleitzahl   = '" . $Postleitzahl . "',
										city           = '" . $city . "',
										Telefon        = '" . $Telefon . "',
										Telefax        = '" . $Telefax . "',
										Bemerkungen    = '" . $Bemerkungen . "',
										Vorname        = '" . $Vorname . "',
										Nachname       = '" . $Nachname . "',
										`UserName`     = '" . $UserName . "',
										Benutzergruppe = '" . $Benutzergruppe . "',
										Registriert    = '" . $Registriert . "',
										Status         = '" . $Status . "',
										ZuletztGesehen = '" . $ZuletztGesehen . "',
										Land           = '" . $Land . "',
										GebTag         = '" . $GebTag . "',
										emc            = '" . $emc . "',
										IpReg          = '" . $IpReg . "',
										new_pass       = '" . $new_pass . "',
										Firma          = '" . $Firma . "',
										UStPflichtig   = '" . $UStPflichtig . "'
								");
							}
						}
					}
				}
			}

			fclose($fp);
			unset($_REQUEST['action']);
			@unlink($TempDir . '/CSVIMPORT_user_' . $_SESSION['user_id'] . '_'.$fileid.'.txt');
			//header("Location:index.php?do=modules&action=modedit&mod=shop&moduleaction=shopimport&cp=".SESSION."&pop=1");
			echo '<script>window.close();</ script>';
			exit;
			//$AVE_Template->assign('ImportOk', 1);
			break;
	}
}

$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_import_user.tpl'));

?>