<?php
class Recommend {

/**
 *	ябниярбю
 */

/**
 *	бмеьмхе лерндш
 */

	function displayLink() {
		global $AVE_Template, $mod;

		$AVE_Template->assign('page', base64_encode(redirectLink()));
		$AVE_Template->assign('theme_folder', $mod['theme_folder']);
		$AVE_Template->display($mod['tpl_dir'] . 'recommend_link.tpl');
	}

	function displayForm($theme_folder) {
		global $AVE_Template, $mod;

		$AVE_Template->assign('theme_folder', $theme_folder);
		$AVE_Template->display($mod['tpl_dir'] . 'recommend_form.tpl');
	}

	function sendForm($theme_folder) {
		global $AVE_Template, $mod, $AVE_Globals;

//		$mail_absender = $AVE_Globals->mainSettings('mail_from');
//		$mail_name = $AVE_Globals->mainSettings('mail_from_name');
		$message = $mod['config_vars']['RECOMMEND_MESSAGE'];
		$message = str_replace("%N%", "\n", $message);
		$message = str_replace("%PAGE%", base64_decode($_POST['page']), $message);
		$message = str_replace("&amp;", "&", $message);

		$AVE_Globals->cp_mail(
			$_POST['receiver_email'],
			$message,
			$mod['config_vars']['RECOMMEND_SUBJECT'],
			$_POST['recommend_email'],
			$_POST['recommend_name'],
			'text'
		);
		$AVE_Template->display($mod['tpl_dir'] . 'recommend_thankyou.tpl');
	}

/**
 *	бмсрпеммхе лерндш
 */

}
?>