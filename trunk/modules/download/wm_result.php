<?php
	require_once "config.php";

 	$test_str = "";
 	if (substr(@$_REQUEST['LMI_PAYEE_PURSE'],0,1) == 'Z') {
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
	$pay_date=strftime("%d.%m.%Y");
	$pay_userIP = @$_REQUEST['pay_userIP'];

	if (!strlen($pay_userid)) $pay_userid="0";
	if (!strlen($pay_amount) || !strlen($pay_fileid)) {
	 	$str="Ошибка при записи платежа. Параметры:\n";
	 	$str.="Кошелек продавца:".@$_REQUEST['LMI_PAYEE_PURSE']."\n";
	 	$str.="Сумма платежа:".@$_REQUEST['LMI_PAYMENT_AMOUNT']."\n";
	 	$str.="Номер платежа:".@$_REQUEST['LMI_PAYMENT_NO']."\n";
	 	$str.="Тестовый режим:".@$_REQUEST['LMI_MODE']."\n";
	 	$str.="Номер счета в системе WebMoney Transfer:".@$_REQUEST['LMI_SYS_INVS_NO']."\n";
	 	$str.="Номер платежа в системе WebMoney Transfer:".@$_REQUEST['LMI_SYS_TRANS_NO']."\n";
	 	$str.="Дата и время реального прохождения платежа:".@$_REQUEST['LMI_SYS_TRANS_DATE']."\n";
	 	$str.="Кошелек покупателя:".@$_REQUEST['LMI_PAYER_PURSE']."\n";
	 	$str.="WM-идентификатор покупателя:".@$_REQUEST['LMI_PAYER_WM']."\n";
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