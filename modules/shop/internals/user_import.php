<?php

if (!defined('USER_IMPORT')) exit;

$csv_available_fields = array(
	'Id'          => $GLOBALS['config_vars']['UserImport_Id'],
	'password'    => $GLOBALS['config_vars']['UserImport_Kennwort'],
	'email'       => $GLOBALS['config_vars']['UserImport_Email'],
	'street'      => $GLOBALS['config_vars']['UserImport_Strasse'],
	'street_nr'   => $GLOBALS['config_vars']['UserImport_HausNr'],
	'zipcode'     => $GLOBALS['config_vars']['UserImport_Postleitzahl'],
	'city'        => $GLOBALS['config_vars']['UserImport_City'],
	'phone'       => $GLOBALS['config_vars']['UserImport_Telefon'],
	'telefax'     => $GLOBALS['config_vars']['UserImport_Telefax'],
	'description' => $GLOBALS['config_vars']['UserImport_Bemerkungen'],
	'firstname'   => $GLOBALS['config_vars']['UserImport_Vorname'],
	'lastname'    => $GLOBALS['config_vars']['UserImport_Nachname'],
	'user_name'   => $GLOBALS['config_vars']['UserImport_UserName'],
	'user_group'  => $GLOBALS['config_vars']['UserImport_Benutzergruppe'],
	'reg_time'    => $GLOBALS['config_vars']['UserImport_Registriert'],
	'Status'      => $GLOBALS['config_vars']['UserImport_Status'],
	'last_visit'  => $GLOBALS['config_vars']['UserImport_ZuletztGesehen'],
	'country'     => $GLOBALS['config_vars']['UserImport_Land'],
	'birthday'    => $GLOBALS['config_vars']['UserImport_GebTag'],
	'emc'         => $GLOBALS['config_vars']['UserImport_emc'],
	'reg_ip'      => $GLOBALS['config_vars']['UserImport_IpReg'],
	'new_pass'    => $GLOBALS['config_vars']['UserImport_newPass'],
	'company'     => $GLOBALS['config_vars']['UserImport_Firma'],
	'taxpay'      => $GLOBALS['config_vars']['UserImport_UStPflichtig']
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
			// In den temporдren Ordner kopieren
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
				// Datei цffnen und Kopfzeile einlesen
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
					if ($csv_field != 'deleted' && $csv_field != 'del_time')
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
			// Nach temporдrere Datei suchen...
			// ========================================================
			$fileid = preg_replace('/[^0-9a-zA-Z]*/', '', $_REQUEST['fileid']);
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
			// Datei цffnen
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
					$Id          = '';
					$password    = '';
					$email       = '';
					$street      = '';
					$street_nr   = '';
					$zipcode     = '';
					$City        = '';
					$phone       = '';
					$telefax     = '';
					$description = '';
					$firstname   = '';
					$lastname    = '';
					$user_name   = '';
					$user_group  = '';
					$reg_time    = '';
					$status      = '';
					$last_visit  = '';
					$country     = '';
					$birthday    = '';
					$emc         = '';
					$reg_ip      = '';
					$new_pass    = '';
					$company     = '';
					$taxpay      = '';

					$i = 0;

					foreach ($row as $key=>$value)
					{
						// ========================================================
						// Feld erkennen...
						// ========================================================
						$field = @$_REQUEST['field_' . md5($key)];
						switch ($field)
						{
							case 'Id'          : $Id = $value; break;
							case 'password'    : $password = $value; break;
							case 'email'       : $email = $value; break;
							case 'street'      : $street = $value; break;
							case 'street_nr'   : $street_nr = $value; break;
							case 'zipcode'     : $zipcode = $value; break;
							case 'city'        : $city = $value; break;
							case 'phone'       : $phone = $value; break;
							case 'telefax'     : $telefax = $value; break;
							case 'description' : $description = $value; break;
							case 'firstname'   : $firstname = $value; break;
							case 'lastname'    : $lastname = $value; break;
							case 'user_name'   : $user_name = $value; break;
							case 'user_group'  : $user_group = $value; break;
							case 'reg_time'    : $reg_time = $value; break;
							case 'Status'      : $status = $value; break;
							case 'last_visit'  : $last_visit = $value; break;
							case 'country'     : $country = $value; break;
							case 'birthday'    : $birthday = $value; break;
							case 'emc'         : $emc = $value; break;
							case 'reg_ip'      : $reg_ip = $value; break;
							case 'new_pass'    : $new_pass = $value; break;
							case 'company'     : $company = $value; break;
							case 'taxpay'      : $taxpay = $value; break;
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
							$user_group = (isset($_REQUEST['user_group']) && $_REQUEST['user_group'] != 'FILE') ? $_REQUEST['user_group'] : $user_group;

							$AVE_DB->Query("
								UPDATE " . PREFIX . "_users
								SET
									password    = '" . $password . "',
									email       = '" . $email . "',
									street      = '" . $street . "',
									street_nr   = '" . $street_nr . "',
									zipcode     = '" . $zipcode . "',
									city        = '" . $city . "',
									phone       = '" . $phone . "',
									telefax     = '" . $telefax . "',
									description = '" . $description . "',
									firstname   = '" . $firstname . "',
									lastname    = '" . $lastname . "',
									user_name   = '" . $user_name . "',
									user_group  = '" . $user_group . "',
									reg_time    = '" . $reg_time . "',
									status      = '" . $status . "',
									last_visit  = '" . $last_visit . "',
									country     = '" . $country . "',
									birthday    = '" . $birthday . "',
									emc         = '" . $emc . "',
									reg_ip      = '" . $reg_ip . "',
									new_pass    = '" . $new_pass . "',
									company     = '" . $company . "',
									taxpay      = '" . $taxpay . "'
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
										Id          = '" . $Id . "',
										password    = '" . $password . "',
										email       = '" . $email . "',
										street      = '" . $street . "',
										street_nr   = '" . $street_nr . "',
										zipcode     = '" . $zipcode . "',
										city        = '" . $city . "',
										phone       = '" . $phone . "',
										telefax     = '" . $telefax . "',
										description = '" . $description . "',
										firstname   = '" . $firstname . "',
										lastname    = '" . $lastname . "',
										user_name   = '" . $user_name . "',
										user_group  = '" . $user_group . "',
										reg_time    = '" . $reg_time . "',
										status      = '" . $status . "',
										last_visit  = '" . $last_visit . "',
										country     = '" . $country . "',
										birthday    = '" . $birthday . "',
										emc         = '" . $emc . "',
										reg_ip      = '" . $reg_ip . "',
										new_pass    = '" . $new_pass . "',
										company     = '" . $company . "',
										taxpay      = '" . $taxpay . "'
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