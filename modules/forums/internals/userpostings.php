<?php

/**
 * ��������� ������������� (��� ���������)
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if (!defined("USERPOSTINGS")) exit;

global $AVE_DB, $AVE_Template, $mod;

if (isset($_GET['user_id']) && is_numeric($_GET['user_id']) && $_GET['user_id'] >= 1)
{
	$limit = (!empty($_REQUEST['pp']) && is_numeric($_REQUEST['pp']) && $_REQUEST['pp'] >= 1) ? $_REQUEST['pp'] : 15;

	// der beitragverfasser
	$poster = $AVE_DB->Query("
		SELECT
			u.avatar,
			us.user_group,
			u.avatar_default,
			u.uname,
			u.email,
			u.web_site,
			u.reg_time,
			u.signature,
			u.invisible,
			u.uid,
			us.firstname,
			us.user_group,
			us.lastname,
			ug.user_group_name
		FROM
			" . PREFIX . "_modul_forum_userprofile AS u
		JOIN
			" . PREFIX . "_users AS us
				ON us.Id = u.uid
		JOIN
			" . PREFIX . "_user_groups AS ug
				ON ug.user_group = us.user_group
		WHERE
			u.uid = '" . intval($_GET['user_id']) . "'
	")->FetchRow();

	$poster->Poster = $this->fetchusername($_GET['user_id']);

	$poster->user_posts = $AVE_DB->Query("
		SELECT COUNT(*)
		FROM " . PREFIX . "_modul_forum_post
		WHERE uid = '" . $poster->uid . "'
	")->GetCell();

	$poster->rank = $AVE_DB->Query("
		SELECT title
		FROM " . PREFIX . "_modul_forum_rank
		WHERE count < '" . $poster->user_posts . "'
		ORDER BY count DESC
		LIMIT 1
	")->GetCell();

	$poster->avatar = $this->getAvatar($poster->user_group,$poster->avatar,$poster->avatar_default);
	$poster->regdate = $poster->reg_time;
	$poster->user_sig = $this->kcodes($poster->signature);

	if (SMILIES==1) $poster->user_sig = $this->replaceWithSmileys($poster->signature);

	$AVE_Template->assign("poster", $poster);

	$a = get_current_page() * $limit - $limit;

	$result = $AVE_DB->Query("
		SELECT SQL_CALC_FOUND_ROWS
			p.id,
			p.title,
			p.topic_id,
			p.datum,
			p.use_bbcode,
			p.use_smilies,
			p.use_sig,
			p.message,
			p.attachment,
			f.id AS forum_id,
			f.title AS forum_title,
			t.title AS topic_title,
			t.views AS topic_views,
			t.replies AS topic_replies,
			t.forum_id AS AUA,
			u.uid,
			u.uname,
			c.group_id AS GRUPPEN_IDS
		FROM
			" . PREFIX . "_modul_forum_post AS p
		JOIN
			" . PREFIX . "_modul_forum_topic AS t ON t.id = p.topic_id
		JOIN
			" . PREFIX . "_modul_forum_forum AS f ON f.id = t.forum_id
		JOIN
			" . PREFIX . "_modul_forum_userprofile AS u ON u.uid = p.uid
		JOIN
			" . PREFIX . "_modul_forum_category AS c ON c.id = f.category_id
		WHERE
			p.uid = '" . intval($_GET['user_id']) . "' AND
			f.active = '1'
		ORDER BY p.datum DESC
		LIMIT " . $a . "," . $limit . "
	");

	$num = $AVE_DB->Query("SELECT FOUND_ROWS()")->GetCell();
	$seiten = ceil($num / $limit);

	// MISC-IDS...
	$my_group_id = array();

	if (!@is_numeric(UID) || UGROUP == 2)
	{
		$my_group_id[] = UGROUP;
	}
	else
	{
		$group_id_misc = $AVE_DB->Query("
			SELECT group_id_misc
			FROM " . PREFIX . "_modul_forum_userprofile
			WHERE uid = '" . UID . "'
		")->GetCell();

		if ($group_id_misc != "")
		{
			$my_group_id = @explode(";", UGROUP . ";" . $group_id_misc);
		}
		else
		{
			$my_group_id[] = UGROUP;
		}
	}

	$matches = array();
	while ($post = $result->FetchRow())
	{
		$post->datum = $this->datumtomytime($post->datum);
		$post->group_ids = @explode(",", $post->GRUPPEN_IDS);

		if (array_intersect($post->group_ids,$my_group_id))
		{
			// soll bbcode verwendet werden
			if ($post->use_bbcode == 1)
			{
				$post->message = $this->kcodes($post->message);
			}
			else
			{
				$post->message = nl2br($post->message);
			}
		}
		else
		{
			$post->message = $mod['config_vars']['FORUMS_DENIED_TEXT'];
			$post->flink = 'no';
		}

		$post->message = @$this->badwordreplace($post->message);
		$post->message = $this->high($post->message);
		$post->message = (SMILIES == 1 && $post->use_smilies == 1)
			? $this->replaceWithSmileys($post->message)
			: $post->message;
		$matches[] = $post;
	}

	if ($num > $limit)
	{
		$id = (!is_numeric($_REQUEST['id'])) ? 1 : $_REQUEST['id'];
		$page_nav = " <a class=\"page_navigation\" href=\"index.php?module=forums&amp;show=userpostings&amp;user_id=" . $_GET['user_id'] . "&amp;page={s}&amp;pp=" . $limit . "\">{t}</a> ";
		$page_nav = get_pagination($seiten, 'page', $page_nav);
		$AVE_Template->assign('pages', $page_nav);
	}
	$AVE_Template->assign("matches", $matches);
	$AVE_Template->assign("post_count", $num);

	define("MODULE_CONTENT", $AVE_Template->fetch($mod['tpl_dir'] . 'showpost.tpl'));
	define("MODULE_SITE", $mod['config_vars']['FORUMS_USER_POSTINGS']);
}
else
{
	header("Location:index.php?module=forums");
	exit;
}

?>