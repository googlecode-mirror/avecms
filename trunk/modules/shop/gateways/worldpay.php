<?php
if(!defined('BASE_DIR') || !isset($_SESSION['BasketSumm'])) exit;
?>

<style type="text/css">
<!--
h1, h2, h3 {font-family: Arial, Helvetica, sans-serif;}
.f{
	font-size: 16px;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>
<?php if ($row_gw->InstId == '') { ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center" class="f"><strong>FEHLER!</strong><br />Es wurde keine Installations - ID angegeben!...</p>
<?php exit; } ?>

<body onLoad="document.process.submit();">

<p>&nbsp;</p>
<p>&nbsp;</p>
<div align="center">
  <h2>Sichere Zahlungs - Seite</h2>
</div>
<p align="center" class="f">Sie werden nun zur Zahlung zu <strong>Worldpay</strong> weiter geleitet...<br>
  Sollten Sie nicht weiter geleitet werden, klicken Sie bitte auf die Schaltfl&auml;che &quot;Bezahlen&quot; . </p>
<form action="https://select.worldpay.com/wcc/purchase" method="post" name="process" id="process">
	<input name="instId" type="hidden" value="<?php echo $row_gw->InstId; ?>" />
	<input name="cartId" type="hidden" value="<?php echo $OrderId; ?>" />
	<input name="amount" type="hidden" value="<?php echo number_format($_SESSION['BasketSumm'], '2', '.', ''); ?>" />
	<input name="currency" type="hidden" value="<?php echo $Waehrung; ?>" />
	<input name="desc" type="hidden" value="<?php echo $row_gw->ZahlungsBetreff; ?>" />
	<input name="testMode" type="hidden" value="<?php echo $row_gw->TestModus; ?>" />
	<input name="M_uid" type="hidden" value="<?php echo (isset($_SESSION['BasketSumm']) ? number_format($_SESSION['BasketSumm'], '2', '.', '') : $_SESSION['user_email']); ?>" />
	<input name="M_hid" type="hidden" value="<?php echo $OrderId; ?>" />
	<input name="M_articles" type="hidden" value="<?php echo (serialize($_SESSION['Product'])); ?>" />
	<input name="name" type="hidden" value="<?php echo $_SESSION['billing_firstname'] . ' ' . $_SESSION['billing_lastname']; ?>" />
	<input name="address" type="hidden" value="<?php echo $_SESSION['billing_firstname'] . ' ' . $_SESSION['billing_lastname'] . ', ' . $_SESSION['billing_street'] . ' ' . $_SESSION['billing_streetnumber']; ?>" />
	<input name="postcode" type="hidden" value="<?php echo $_SESSION['billing_zip']; ?>" />
	<input name="tel" type="hidden" value="<?php echo $_SESSION['OrderPhone']; ?>" />
	<input name="fax" type="hidden" value="" />
	<input name="email" type="hidden" value="<?php echo $_SESSION['OrderEmail']; ?>" />
	<input name="country" type="hidden" value="<?php echo $_SESSION['billing_country']; ?>" />
	<div align="center"><input type="submit" value="Bezahlen" /></div>
</form>
<?php
unset($_SESSION['Zwisumm']);
unset($_SESSION['BasketSumm']);
unset($_SESSION['BasketOverall']);
unset($_SESSION['ShippingSummOut']);
unset($_SESSION['ShippingSumm']);
unset($_SESSION['ShipperId']);
unset($_SESSION['IsShipper']);
unset($_SESSION['Product']);
unset($_SESSION['VatInc']);
unset($_SESSION['GewichtSumm']);
unset($_SESSION['PaymentId']);
unset($_SESSION['TransId']);
unset($_SESSION['CouponCode']);
unset($_SESSION['CouponCodeId']);
?>