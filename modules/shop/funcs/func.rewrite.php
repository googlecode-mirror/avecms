<?php

function shopRewrite($s)
{
	$s = preg_replace('/index.php(?:\?)module=shop&(?:amp;)*action=product_detail&(?:amp;)*product_id=(\d+)&(?:amp;)*categ=(\d+)&(?:amp;)*navop=(\d+)/', 'product-\\1-\\2-\\3.html', $s);
	$s = preg_replace('/index.php(?:\?)module=shop&(?:amp;)*categ=(\d+)&(?:amp;)*parent=(\d+)&(?:amp;)*navop=(\d+)&(?:amp;)*page=(\d+)/', 'category-\\1-\\2-\\3-\\4.html', $s);
	$s = preg_replace('/index.php(?:\?)module=shop&(?:amp;)*categ=(\d+)&(?:amp;)*parent=(\d+)&(?:amp;)*navop=(\d+)/', 'category-\\1-\\2-\\3.html', $s);
	$s = preg_replace('/index.php(?:\?)module=shop&(?:amp;)*manufacturer=(\d+)/', 'manufacturer-\\1.html', $s);
	$s = preg_replace('/index.php(?:\?)module=shop&(?:amp;)*action=showbasket/', 'basket.html', $s);
	$s = preg_replace('/index.php(?:\?)module=shop&(?:amp;)*action=myorders&(?:amp;)*sub=request/', 'request.html', $s);
	$s = preg_replace('/index.php(?:\?)module=shop&(?:amp;)*action=myorders/', 'my-orders.html', $s);
$s = preg_replace('/index.php(?:\?)module=shop&(?:amp;)*action=mydownloads&(?:amp;)*sub=getfile&(?:amp;)*Id=(\d+)&(?:amp;)*FileId=([\x21-\xFF]+)&(?:amp;)*getId=(\d+)/', 'getfile-\\1-\\2.html', $s);
	$s = preg_replace('/index.php(?:\?)module=shop&(?:amp;)*action=mydownloads/', 'my-downloads.html', $s);
	$s = preg_replace('/index.php(?:\?)module=shop&(?:amp;)*action=infopage&(?:amp;)*page=imprint/', 'shop-about.html', $s);
	$s = preg_replace('/index.php(?:\?)module=shop&(?:amp;)*action=infopage&(?:amp;)*page=(datainf|shippinginf|agb)/', '\\1.html', $s);
	$s = preg_replace('/index.php(?:\?)module=shop&(?:amp;)*action=(checkout|wishlist)(&(?:amp;)*pop=1)*/', '\\1.html', $s);
	$s = preg_replace('/index.php(?:\?)module=shop&(?:amp;)*page=(\{s\})/', 'shop-\\1.html', $s);
	$s = preg_replace('/index.php(?:\?)module=shop(?!&)/', 'shop.html', $s);
	$s = preg_replace('/.html&(?:amp;)*print=1/', '-print.html', $s);

	return $s;
}

?>