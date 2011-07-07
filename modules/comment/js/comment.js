function cAction(obj,action){
	var cid = $(obj).parents('.mod_comment_box').attr('id');
	if (action=='answer'){
		$('#parent_id').val(cid);
		$('#mod_comment_new').insertAfter('#'+cid);
		return;
	}
	if (UGROUP==1){
		$.get(aveabspath+'index.php',{
			module: 'comment',
			action: action,
			docid: DOC_ID,
			Id: cid
		},function(){
			if (action=='delete'){
				$(obj).parents('.mod_comment_comment').eq(0).remove();
			}
			if (action=='open'){
				$(obj).unbind('click')
					.click(function(){cAction(obj,'close');})
					.html(COMMENT_SITE_CLOSE);
			}
			if (action=='close'){
				$(obj).unbind('click')
					.click(function(){cAction(obj,'open');})
					.html(COMMENT_SITE_OPEN);
			}
			if (action=='unlock'){
				$(obj).unbind('click')
					.click(function(){cAction(obj,'lock');})
					.attr('title',COMMENT_LOCK_LINK)
					.find('img').attr('src',aveabspath+'modules/comment/templates/images/lock.gif');
			}
			if (action=='lock'){
				$(obj).unbind('click')
					.click(function(){cAction(obj,'unlock');})
					.attr('title',COMMENT_UNLOCK_LINK)
					.find('img').attr('src',aveabspath+'modules/comment/templates/images/unlock.gif');
			}
		});
	}
};

function validate(formData,jqForm,options){
	$('.error_message').remove();
	var form = jqForm[0];
	if (!form.comment_author_name.value){
		alert(COMMENT_ERROR_AUTHOR);
		$(form.comment_author_name).focus();
		return false;
	}
	if (!form.comment_author_email.value){
		alert(COMMENT_ERROR_EMAIL);
		$(form.comment_author_email).focus();
		return false;
	}
	if (!form.comment_text.value){
		alert(COMMENT_ERROR_TEXT);
		$(form.comment_text).focus();
		return false;
	}
	if (IS_IM && !form.securecode.value){
		alert(COMMENT_ERROR_CAPTCHA);
		$(form.securecode).focus();
		return false;
	}
	return true;
};

function setClickable(){
	$('.editable_text').click(function(){
		var cid = $(this).parents('.mod_comment_box').attr('id');
		var revert = $(this).html();
		var textarea = '<p><textarea rows="7" id="ta_'+cid+'" class="editable">'+revert+'</textarea></p>';
		var charsLeft = '<p>'+COMMENT_CHARS_LEFT+' <span class="charsLeft" id="charsLeft_'+cid+'"></span></p>';
		var buttonSave = '<input type="button" value="'+COMMENT_BUTTON_EDIT+'" class="button saveButton" /> ';
		var buttonReset = '<input type="button" value="'+COMMENT_BUTTON_CANCEL+'" class="button cancelButton" />';
		$(this).after('<div class="box"><div class="block" id="forms"><fieldset><legend>'+COMMENT_EDIT_TITLE
			+'</legend>'+textarea+buttonSave+buttonReset+charsLeft+'</fieldset></div></div>').remove();
		$('.saveButton').click(function(){saveChanges(this,false,cid);});
		$('.cancelButton').click(function(){saveChanges(this,revert,cid);});
		$('#ta_'+cid).limit(MAX_CHARS,'#charsLeft_'+cid);
	})
	.addClass('tooltip')
	.attr('title',COMMENT_EDIT_LINK)
	.mouseover(function(){$(this).addClass('editable');})
	.mouseout(function(){$(this).removeClass('editable');});
	$('#in_message').limit(MAX_CHARS,'#charsLeft_new');
	$('.mod_comment_answer').click(function(){cAction(this,'answer');});
	if (UGROUP==1){
		$('.mod_comment_delete').click(function(){cAction(this,'delete');});
		$('.mod_comment_lock').click(function(){cAction(this,'lock');});
		$('.mod_comment_unlock').click(function(){cAction(this,'unlock');});
	}
};

function saveChanges(obj,cancel,cid){
	if (!cancel){
		var t = $(obj).parent().children().children().val();
		$.post(aveabspath+'index.php',{
			module: 'comment',
			action: 'edit',
			Id: cid,
			text: t
		},
		function(txt){
			$(obj).parent().parent().parent().after('<div class="mod_comment_text editable_text">'+txt+'</div>').remove();
			var now = new Date();
			var date = now.toLocaleFormat(COMMENT_DATE_TIME_FORMAT);
			$('#'+cid).find('.mod_comment_changed').html(' ('+COMMENT_TEXT_CHANGED+' '+date+')');
			setClickable();
		});
	}
	else {
		$(obj).parent().parent().parent().after('<div class="mod_comment_text editable_text">'+cancel+'</div>').remove();
		setClickable();
	}
};

function displayNewComment(data){
	if (data=='wrong_securecode'){
		$('#captcha').after('<div class="error_message">'+COMMENT_WRONG_CODE+'</div>');
		$('#securecode').focus();
	}
	else {
		$('#end'+$('#parent_id').val()).before(data);
		$('#parent_id').val('');
		$('#mod_comment_new').insertAfter('#end').resetForm();
		setClickable();
	}
	getCaptha();
};

$(document).ready(function(){
	setClickable();
	$('#mod_comment_new form').submit(function(){
		$(this).ajaxSubmit({
			url: aveabspath+'index.php?ajax=1',
			beforeSubmit: validate,
			success: displayNewComment,
			timeout: 3000
		});
		return false;
	});
	$('#buttonReset').click(function(){
		$('#parent_id').val('');
		$('#mod_comment_new').insertAfter('#end').resetForm();
	});
	if (UGROUP==1){
		$('#mod_comment_open').click(function(){cAction(this,'open');});
		$('#mod_comment_close').click(function(){cAction(this,'close');});
	}
});