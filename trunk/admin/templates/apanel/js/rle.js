$().ready(function() {

	// ��������� �������� ��������
	$('#finder').elfinder({
		url : ave_path+'admin/redactor/elfinder/php/connector.php',
		lang : 'ru', 
	   height : 500,
	   title : '�������� ��������'
	}).elfinder('instance');
		

	// ������ ������ �����������
	$('.dialog_images').click(function() {
		var id = $(this).attr("rel");
		$('<div/>').dialogelfinder({
			url : ave_path+'admin/redactor/elfinder/php/connector.php',
			lang : 'ru',
			width : 1100,
			height: 600,
			modal : true, 
			title : '�������� ��������',
			getFileCallback : function(files, fm) {
				$("#"+id).val(files['url'].slice(1)); 
				$("#imm_"+id).html("<img src="+files['url']+">");
			},
			commandsOptions : {
				getfile : {
					oncomplete : 'destroy',
					folders : false
				}
			}
		})
	});	

	
	$('#elFinder a').hover(
		function () {
			$('#elFinder a').animate({
				'background-position' : '0 -45px'
			}, 300);
		},
		function () {
			$('#elFinder a').delay(400).animate({
				'background-position' : '0 0'
			}, 300);
		}
	);		
	$('#elRTE a').delay(800).animate({'background-position' : '0 0'}, 300);


	// ���������� ��������	
	var opt = {			
		cssClass : 'el-rte',
		toolbars :  {
			apanel : ['format', 'save', 'copypaste', 'undoredo', 'style', 'alignment', 'lists', 'links', 'images', 'fullscreen']
		},
		toolbar  : 'apanel',
		lang     : 'ru',
		allowTextNodes : 'true',
		height   : 500,
		cssfiles : [ave_path+'admin/redactor/elrte/css/elrte-inner.css'],	
		fmOpen : function(callback) {
	       $('<div />').dialogelfinder({
	          url : ave_path+'admin/redactor/elfinder/php/connector.php',
	          lang : 'ru',
	          width : 1100, 
	          height : 500,
	          title : '�������� ��������',
	          commandsOptions : {
               getfile : {
                   onlyURL  : true,
                   multiple : false,
                   folders  : false,
                   oncomplete : 'destroy'
               }
	           },
	          getFileCallback : callback
	      })
		}	
	};
	$('.editor').elrte(opt);


	// ���������� ��������
	var opts = {
		cssClass : 'el-rte',
		toolbars :  {
			small : ['format', 'copypaste', 'undoredo', 'alignment', 'lists', 'links']
		},
		toolbar  : 'small',
		lang     : 'ru',
		allowTextNodes : 'true',
		height   : 250,
		cssfiles : [ave_path+'admin/redactor/elrte/css/elrte-inner.css']
	};
	$('.small-editor').elrte(opts);
		
});
