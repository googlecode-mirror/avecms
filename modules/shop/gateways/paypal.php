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

<body onLoad="document.process.submit();">

<p>&nbsp;</p>
<p>&nbsp;</p>
<div align="center">
  <h2>Sichere Zahlungs - Seite</h2>
</div>

<p align="center" class="f">Sie werden nun zur Zahlung zu <strong>Paypal</strong> weiter geleitet...<br>
Sollten Sie nicht weiter geleitet werden, klicken Sie bitte auf die Grafik. </p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="process" id="process">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?php echo $row_gw->InstId; ?>">
<input type="hidden" name="item_name" value="<?php echo $row_gw->ZahlungsBetreff; ?>">
<input type="hidden" name="item_number" value="<?php echo $OrderId; ?>">
<input type="hidden" name="amount" value="<?php echo number_format($_SESSION['BasketSumm'], '2', '.', ''); ?>">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="currency_code" value="<?php echo $Waehrung; ?>">

<center>
<input type="image" src="https://www.paypal.com/de_DE/i/btn/x-click-but3.gif" style="border:0px;" border="0" name="submit" alt="Zahlen Sie mit PayPal - schnell, kostenlos und sicher!">
</center>
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