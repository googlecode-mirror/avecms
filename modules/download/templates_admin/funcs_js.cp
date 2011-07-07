<script language="javascript">
{literal}
var ie  = document.all  ? 1 : 0;
 function selall(kselect)
 {
   	var fmobj = document.kform;
   	for (var i=0;i<fmobj.elements.length;i++)
	{
   		var e = fmobj.elements[i];
   		if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)) 
		{
   			e.checked = fmobj.allbox.checked;
   		}
   	}
 }
  
   function CheckCheckAll(kselect) {
   	var fmobj = document.kform;
   	var TotalBoxes = 0;
   	var TotalOn = 0;
   	for (var i=0;i<fmobj.elements.length;i++) {
   		var e = fmobj.elements[i];
   		if ((e.name != 'allbox') && (e.type=='checkbox')) {
   			TotalBoxes++;
   			if (e.checked) {
   				TotalOn++;
   			}
   		}
   	}
   	if (TotalBoxes==TotalOn) {fmobj.allbox.checked=true;}
   	else {fmobj.allbox.checked=false;}
   }
   function select_read() {
   	var fmobj = document.kform;
   	for (var i=0;i<fmobj.elements.length;i++) {
   		var e = fmobj.elements[i];
   		if ((e.type=='hidden') && (e.value == 1) && (! isNaN(e.name) ))
   		{
   			eval("fmobj.msgid_" + e.name + ".checked=true;");
   			
   		}
   	}
   }
   function desel() {
   	var fmobj = document.uactions;
   	for (var i=0;i<fmobj.elements.length;i++) {
   		var e = fmobj.elements[i];
   		if (e.type=='checkbox') {
   			e.checked=false;
   			
   		}
   	}
   }
{/literal}
 </script>