<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine
 Short Desc: Full Russian Security Power Pack
 Version: 2.0 (Service Pack 2)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: March 18, 2008
::::::::::::::::::::::::::::::::::::::::*/

if(!defined("VOTETOPIC")) exit;

	$q_forum = "SELECT f.id
		FROM
			" . PREFIX . "_modul_forum_forum AS f,
			" . PREFIX . "_modul_forum_topic AS t
		WHERE
			t.id = " . intval($_POST['t_id']) . " AND
			t.forum_id = f.id
	";

	$r_forum = $GLOBALS['AVE_DB']->Query($q_forum);
	$forum = $r_forum->FetchRow();
	$permissions = $this->getForumPermissionsByUser($forum->id, UID);

	if ($permissions[FORUM_PERMISSION_CAN_RATE_TOPIC] == 0)
	{
		header("Location:index.php?module=forums");
		exit;
	} else {
		$q_sel_rating = "SELECT uid, rating, ip FROM " . PREFIX . "_modul_forum_rating WHERE topic_id = " . $_POST['t_id'];
		$r_sel_rating = $GLOBALS['AVE_DB']->Query($q_sel_rating);

		$rating = $r_sel_rating->FetchRow();
		$r_uid = @explode(",", $rating->uid);
		$ip = @explode(",", $rating->ip);

		if(@is_numeric(UID)){
			$v_uid = UID;
		} else {
			$v_uid = "";
		}

		if(UID != 0 || UID != "UID" || UID != ""){
			// wenn user eingeloggt ist und kein gast abstimmen darf
			if (!in_array(UID, $r_uid)) {

				// wenn noch niemand bewertet hat
				if ($rating->rating == "") {

					$q_rating = "
						UPDATE
							" . PREFIX . "_modul_forum_rating
						SET
							rating = '" . $_POST['rating'] . "',
							ip = '" . $_SERVER['REMOTE_ADDR'] . "',
							uid = '" . $v_uid . "'
						WHERE
							topic_id = " . $_POST['t_id'];
				} else {
					$q_rating = "
						UPDATE
							" . PREFIX . "_modul_forum_rating
						SET
							rating = CONCAT(rating, ',', '" . $_POST['rating'] . "'),
							uid = CONCAT(uid, ',', '" . $v_uid . "'),
							ip = CONCAT(ip, ',', '" . $_SERVER['REMOTE_ADDR'] . "')
						WHERE
							topic_id = " . $_POST['t_id'];
				}

				$r_rating = $GLOBALS['AVE_DB']->Query($q_rating);
			}
			// ansonstenn nicht angemeldete benutzer
		} else {

			// wenn keine uid gloabl ist (gast)
			if (!in_array($_SERVER['REMOTE_ADDR'], $ip)) {
				if ($rating->rating == "") {
					$q_rating = "
					UPDATE
						" . PREFIX . "_modul_forum_rating
					SET
						rating = '" . $_POST['rating'] . "',
						ip = '" . $_SERVER['REMOTE_ADDR'] . "',
						uid = '" . $v_uid . "'
					WHERE
						topic_id = " . $_POST['t_id'];
				} else {
					$q_rating = "
					UPDATE
						" . PREFIX . "_modul_forum_rating
					SET
						rating = CONCAT(rating, ',', '" . $_POST['rating'] . "'),
						ip = CONCAT(ip, ',', '" . $_SERVER['REMOTE_ADDR'] . "'),
						uid = CONCAT(uid, ',', '" . $v_uid . "'),
					WHERE
						topic_id = " . $_POST['t_id'];
				}

				$r_rating = $GLOBALS['AVE_DB']->Query($q_rating);
			}
		} // ende wenn gast abstimmen darf

		header("Location:" . $_SERVER['HTTP_REFERER']);
		exit;
	}
?>