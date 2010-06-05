(function($){$.fn.extend({limit:function(limit,element){var interval,f;var self=$(this);$(this).focus(function(){interval=window.setInterval(substring,100)});$(this).blur(function(){clearInterval(interval);substring()});substringFunction="function substring(){ var val = $(self).val();var length = val.length;if(length > limit){$(self).val($(self).val().substring(0,limit));}";if(typeof element!='undefined')substringFunction+="if($(element).html() != limit-length){$(element).html((limit-length<=0)?'0':limit-length);}";substringFunction+="}";eval(substringFunction);substring()}})})(jQuery);

$(document).ready(function(){
	function check_username(){
		$.ajax({
			beforeSend: function(){ $("#checkUsername").show(); },
			type: 'post',
			url: 'index.php',
			data: ({ module: 'login', action: 'checkusername', username: $("#username").val() }),
			timeout: 3000,
			success: function(data){ $("#checkUsername").hide(); $("#checkResultUsername").html(data); }
		});
	};

	function check_email(){
		$.ajax({
			beforeSend: function(){ $("#checkEmail").show(); },
			type: 'post',
			url: 'index.php',
			data: ({ module: 'login', action: 'checkemail', email: $("#email").val() }),
			timeout: 3000,
			success: function(data){ $("#checkEmail").hide(); $("#checkResultEmail").html(data); }
		});
	};

	$("#username").change(function(){ check_username(); });
	$("#email").change(function(){ check_email(); });
});

function getCaptha(){
	now = new Date();
	$('#captcha img').attr('src',aveabspath+'inc/captcha.php?cd='+now);
};

$(document).ready(function(){
	$('#captcha img').click(function(){getCaptha();});
});

//$(document).ready(function(){
//	$("ul.menu_v>li[class!=active]>ul").hide();
//	$("ul.menu_v>li").hover(function()
//	{
//		$(this).siblings().children("ul:visible").not($(this).children("ul").slideDown("slow")).slideUp("slow");
//	});
//});

function popup(datei,name,breite,hoehe,noresize)
{
	var posX=(screen.availWidth-breite)/2;
	var posY=(screen.availHeight-hoehe)/2;
	var resizable = (noresize==1) ? 0 : 1;
	window.open(datei,name,"resizable="+resizable+",scrollbars=1,width=" + breite + ",height=" + hoehe + "screenX=" + posX + ",screenY=" + posY + ",left=" + posX + ",top=" + posY + "");
}

function galpop(datei,name,breite,hoehe,noresize)
{
	var posX=(screen.availWidth-breite)/2;
	var posY=(screen.availHeight-hoehe)/2;
	var resizable = (noresize==1) ? 0 : 1;
	var scrollbar = (document.all) ? 0 : 1;
	window.open(datei,name,"resizable="+resizable+",scrollbars="+scrollbar+",width=" + breite + ",height=" + hoehe + "screenX=" + posX + ",screenY=" + posY + ",left=" + posX + ",top=" + posY + "");
}

function textCounter(field, countfield, maxlimit)
{
	if (field.value.length > maxlimit)
	{
		field.value = field.value.substring(0, maxlimit);
	} else {
		countfield.value = maxlimit - field.value.length;
	}
}

function elemX (element) {
	var x = 0;
	while (element) {
		x += element.offsetLeft;
		element = element.offsetParent;
	}
	return x;
}

function elemY (element) {
	var y = 0;
	while (element) {
		y += element.offsetTop;
		element = element.offsetParent;
	}
	return y;
}

function getWidth (element) {
	return element.offsetWidth;
}

function getHeight (element) {
	return element.offsetHeight;
}

function elemObj(elementId) {
	if (document.all)
		return document.all[elementId];
	else if (document.getElementById)
		return document.getElementById(elementId);
	else
		return null;
}

function show_hide_text(divObj,text) {
    var div = divObj.parentNode.getElementsByTagName('div')[1];
    if (div.style.display == 'none') {
        div.style.display = 'block';
        divObj.innerHTML = text;
    } else {
        div.style.display = 'none';
        divObj.innerHTML = text;
    }
}