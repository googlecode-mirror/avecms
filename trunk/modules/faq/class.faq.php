<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine
 Short Desc: Full Russian Security Power Pack
 Version: 2.0 (Service Pack 1)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: February 22, 2008
::::::::::::::::::::::::::::::::::::::::*/

/*::::::::::::::::::::::::::::::::::::::::
 Module name: Faq
 Short Desc: Frequrent Answer and Questions
 Version: 1.0 alpha
 Authors:  Freeon (php_demon@mail.ru)
 Date: april 5, 2008
::::::::::::::::::::::::::::::::::::::::*/

// Base class of the module
class faq {

  // This function listen category in module
  function faqList($tpl_dir) {
 $faq = array();
    $sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM ". PREFIX ."_modul_faq");
    while ($result = $sql->FetchRow()){
      array_push($faq, $result);
    }
    $GLOBALS['AVE_Template']->assign("faq", $faq);
    $GLOBALS['AVE_Template']->assign("content", $GLOBALS['AVE_Template']->fetch($tpl_dir . "admin_faq_list.tpl"));

  }

  // add new category
  function Addfaq(){
    $faq = htmlspecialchars($_POST['new_faq']);
    $faq_desc = htmlspecialchars($_POST['new_faq_desc']);
    $GLOBALS['AVE_DB']->Query("INSERT INTO ". PREFIX ."_modul_faq (id,faq_name,description) VALUES ('','$faq', '$faq_desc')");
    header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp=".SESSION);

  }

  // delete category
  function Delfaq(){
    $id = addslashes($_GET['id']);
    $GLOBALS['AVE_DB']->Query("DELETE FROM ". PREFIX ."_modul_faq WHERE id = '$id'");
    $sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM ". PREFIX ."_modul_faq_quest WHERE parent=$id");
    while ($result = $sql->FetchRow()){
      $GLOBALS['AVE_DB']->Query("DELETE FROM ". PREFIX ."_modul_faq_quest WHERE parent=$id");
    }
    header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp=".SESSION);
  }

  // update category
  function SaveList(){
    foreach($_POST['faq_name'] as $id => $faq_name) {
      $GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_faq SET faq_name = '$faq_name' WHERE id = '$id'");
    }
    foreach($_POST['description'] as $id => $description) {
     $GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_faq SET description = '$description' WHERE id = '$id'");
    }
    header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp=".SESSION);
  }

  // This function listen questions in category
  function Editfaq($tpl_dir){
    $quest=array();
    $id = intval($_GET['id']);
    $sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM ". PREFIX ."_modul_faq_quest WHERE parent=$id");
    while ($result = $sql->FetchRow()){
      array_push($quest, $result);
    }
    $GLOBALS['AVE_Template']->assign("quest", $quest);
    $GLOBALS['AVE_Template']->assign("parent", $id);
    $GLOBALS['AVE_Template']->assign("content", $GLOBALS['AVE_Template']->fetch($tpl_dir . "admin_faq_edit.tpl"));
  }

  // save question
  function Savequest() {
      $id = addslashes($_POST['id']);
      $parent = addslashes($_POST['parent']);
      $quest = addslashes($_POST['quest']);
      $answer = addslashes($_POST['answer']);
      print $id;
      if ($id!==''){
      $GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_faq_quest SET quest = '".$quest."', answer = '".$answer."' WHERE id = '$id'"); }
      else if ($id==''){
      $GLOBALS['AVE_DB']->Query("INSERT INTO ". PREFIX ."_modul_faq_quest (id,quest,answer,parent) VALUES ('','$quest', '$answer','$parent')");  }
      header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=edit&cp=".SESSION."&id=".$parent);
  }

  // edit question
  function Edit_quest($tpl_dir) {
    $id = intval($_GET['id']);
    $parent = addslashes($_GET['parent']);
    $sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM ". PREFIX ."_modul_faq_quest WHERE id=$id");
    $rows=$sql->FetchRow();
    if ($parent==''){$parent=$rows->parent;}
    $GLOBALS['AVE_Template']->assign("parent", $parent);
    $GLOBALS['AVE_Template']->assign("id", $rows->id);
    $GLOBALS['AVE_Template']->assign("quest", $rows->quest);
    $GLOBALS['AVE_Template']->assign("answer", $rows->answer);
    $GLOBALS['AVE_Template']->assign("content", $GLOBALS['AVE_Template']->fetch($tpl_dir . "admin_quest_edit.tpl"));
  }

  // delete question
  function Del_quest() {
     $id = addslashes($_GET['id']);
     $sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM ". PREFIX ."_modul_faq_quest WHERE id=$id");
     $rows=$sql->FetchRow();
     $GLOBALS['AVE_DB']->Query("DELETE FROM ". PREFIX ."_modul_faq_quest WHERE id = '$id'");
     header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=edit&cp=".SESSION."&id=".$rows->parent);
  }

  // show faq
  function ShowFaq($tpl_dir, $id) {
    $sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM ". PREFIX ."_modul_faq WHERE id='$id'");
    $faq = $sql->FetchRow();
    $quest=array();
    $sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM ". PREFIX ."_modul_faq_quest WHERE parent=$id");
    while ($result = $sql->FetchRow()){
      array_push($quest, $result);
    }
    $GLOBALS['AVE_Template']->assign("quest", $quest);
    $GLOBALS['AVE_Template']->assign("faq_name", $faq->faq_name);
    $GLOBALS['AVE_Template']->assign("desc", $faq->description);
    $GLOBALS['AVE_Template']->display($tpl_dir . 'show_faq.tpl');

  }
}
?>