<?php
	require_once "config.php";

 	$test_str = "";
 	if (mb_substr(@$_REQUEST['LMI_PAYEE_PURSE'],0,1) == 'Z') {
	 	$fz = true;
 	} else {
	 	$fz = false;
 	}
 	$test_str.= $fz?$wmz_purse:$wmr_purse;
 	$test_str.= @$_REQUEST['LMI_PAYMENT_AMOUNT'];
 	$test_str.= @$_REQUEST['LMI_PAYMENT_NO'];
 	$test_str.= @$_REQUEST['LMI_MODE'];
 	$test_str.= @$_REQUEST['LMI_SYS_INVS_NO'];
 	$test_str.= @$_REQUEST['LMI_SYS_TRANS_NO'];
 	$test_str.= @$_REQUEST['LMI_SYS_TRANS_DATE'];
 	$test_str.= $fz?$wmz_secretkey:$wmr_secretkey;
 	$test_str.= @$_REQUEST['LMI_PAYER_PURSE'];
 	$test_str.= @$_REQUEST['LMI_PAYER_WM'];
	$md5sum = strtoupper(md5($test_str));
	$hash_check = (@$_REQUEST['LMI_HASH'] == $md5sum);

 	if (!$hash_check) {
 		die("Hack attempt!");
 	}

 	$pay_amount = @$_REQUEST['LMI_PAYMENT_AMOUNT'];
  $pay_fileid = @$_REQUEST['pay_fileid'];
	$pay_userid = @$_REQUEST['pay_userid'];
	$pay_date=pretty_date(strftime(DATE_FORMAT), $_SESSION['user_language']);
	$pay_userIP = @$_REQUEST['pay_userIP'];

	if (!mb_strlen($pay_userid)) $pay_userid="0";
	if (!mb_strlen($pay_amount) || !mb_strlen($pay_fileid)) {
	 	$str="ЋиЁЎЄ  ЇаЁ § ЇЁбЁ Ї« вҐ¦ . Џ а ¬Ґвал:\n";
	 	$str.="Љ®иҐ«ҐЄ Їа®¤ ўж :".@$_REQUEST['LMI_PAYEE_PURSE']."\n";
	 	$str.="‘г¬¬  Ї« вҐ¦ :".@$_REQUEST['LMI_PAYMENT_AMOUNT']."\n";
	 	$str.="Ќ®¬Ґа Ї« вҐ¦ :".@$_REQUEST['LMI_PAYMENT_NO']."\n";
	 	$str.="’Ґбв®ўл© аҐ¦Ё¬:".@$_REQUEST['LMI_MODE']."\n";
	 	$str.="Ќ®¬Ґа бзҐв  ў бЁбвҐ¬Ґ WebMoney Transfer:".@$_REQUEST['LMI_SYS_INVS_NO']."\n";
	 	$str.="Ќ®¬Ґа Ї« вҐ¦  ў бЁбвҐ¬Ґ WebMoney Transfer:".@$_REQUEST['LMI_SYS_TRANS_NO']."\n";
	 	$str.="„ в  Ё ўаҐ¬п аҐ «м­®Ј® Їа®е®¦¤Ґ­Ёп Ї« вҐ¦ :".@$_REQUEST['LMI_SYS_TRANS_DATE']."\n";
	 	$str.="Љ®иҐ«ҐЄ Ї®ЄгЇ вҐ«п:".@$_REQUEST['LMI_PAYER_PURSE']."\n";
	 	$str.="WM-Ё¤Ґ­вЁдЁЄ в®а Ї®ЄгЇ вҐ«п:".@$_REQUEST['LMI_PAYER_WM']."\n";
	 	$str.="#\n";

  	$open = fopen("wm_error.log","a");
  	fwrite($open, $str);
  	fclose($open);
  	die("Error: no pay or no file");
	}

  $link = mysql_connect($host, $login, $pass) or die("Could not connect");
  mysql_select_db($db) or die("Could not select database");

  $query = "SELECT Pay,Pay_Type FROM " . $perfix . "_modul_download_files WHERE Id = ".$pay_fileid."";
	$result = mysql_query($query) or die("Query failed");
	if ($row = mysql_fetch_array($result)) {

		if ($row['Pay_Type']==0 && $row['Excl_Pay']==0) {
			$sum=max($row['Pay']-$pay_amount,0);
		  $query = "UPDATE " . $perfix . "_modul_download_files SET Pay=".$sum." WHERE Id = '".$pay_fileid."'";
			$result = mysql_query($query) or die("Query failed");
		}

		$query = "INSERT INTO " . $perfix . "_modul_download_payhistory VALUES ('',{$pay_userid},".$pay_amount.",{$pay_fileid},'{$pay_date}','{$pay_userIP}')";
		$result = mysql_query($query) or die("Query failed");

	}

	mysql_close($link);
?>