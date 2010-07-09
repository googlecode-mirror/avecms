var fluid = {
	Ajax : function(){
		$("#loading").hide();
		var content = $("#ajax-content").hide();
		$("#toggle-ajax").bind("click", function(e) {
	        if ( $(this).is(".hidden") ) {
	            $("#ajax-content").empty();

	            $("#loading").show();
				/*$("#ajax-content").load("/fluid960gs/data/ajax-response.html", function() {*/
				/*$("#ajax-content").load(aveabspath+"index.php?module=login&action=login&onlycontent=1", function() {*/
				$("#ajax-content").load(aveabspath+"templates/960px/data/ajax-response.html", function() {
	            	$("#loading").hide();
	            	content.slideDown();
	            });
	        }
	        else {
	            content.slideUp();
	        }
	        if ($(this).hasClass('hidden')){
	            $(this).removeClass('hidden').addClass('visible');
	        }
	        else {
	            $(this).removeClass('visible').addClass('hidden');
	        }
	        e.preventDefault();
	    });
	},
	Toggle : function(){
		var default_hide = {"log-in-forms": true };
		$.each(
			["poll", "popcommentors", "popnews", "lastcomments", "section-menu", "tables", "forms", "login-forms", "login-forms1", "accordion-block", "shopbasket", "shop-search", "myordersbox", "shopinfobox", "shoppopprods"],
			function() {
				var el = $("#" + (this == 'accordon' ? 'accordion-block' : this) );
				if (default_hide[this]) {
					el.hide();
					$("[id='toggle-"+this+"']").addClass("hidden")
				}
				$("[id='toggle-"+this+"']")
				.bind("click", function(e) {
					if ($(this).hasClass('hidden')){
						$(this).removeClass('hidden').addClass('visible');
						el.slideDown();
					} else {
						$(this).removeClass('visible').addClass('hidden');
						el.slideUp();
					}
					e.preventDefault();
				});
			}
		);
	},
	Kwicks : function(){
		var animating = false;
	    $("#kwick .kwick")
	        .bind("mouseenter", function(e) {
	            if (animating) return false;
	            animating == true;
	            $("#kwick .kwick").not(this).animate({ "width": 68 }, 200);
	            $(this).animate({ "width": 320 }, 200, function() {
	                animating = false;
	            });
	        });
	    $("#kwick").bind("mouseleave", function(e) {
	        $(".kwick", this).animate({ "width": 118 }, 200);
	    });
	},
	SectionMenu : function(){
		$("#section-menu")
	        .accordion({
	            "header": "a.menuitem"
	        })
	        .bind("accordionchangestart", function(e, data) {
	            data.newHeader.next().andSelf().addClass("current");
	            data.oldHeader.next().andSelf().removeClass("current");
	        })
	        .find("a.menuitem:first").addClass("current")
	        .next().addClass("current");
	},
	Accordion: function(){
		$("#accordion").accordion({
	        'header': "h3.atStart"
	    }).bind("accordionchangestart", function(e, data) {
	        data.newHeader.css({
	            "font-weight": "bold",
	            "background": "#D2EF72"
	        });

	        data.oldHeader.css({
	            "font-weight": "normal",
	            "background": "#eee"
	        });
	    }).find("h3.atStart:first").css({
	        "font-weight": "bold",
	        "background": "#D2EF72"
	    });
	}
}

jQuery(function ($) {
	if($("#accordion").length){fluid.Accordion();}
	if($("[id$='ajax']").length){fluid.Ajax();}
	if($("[id^='toggle']").length){fluid.Toggle();}
	if($("#kwick .kwick").length){fluid.Kwicks();}
	if($("#section-menu").length){fluid.SectionMenu();}
});

this.tooltip = function(){
	/* CONFIG */
		xOffset = 10;
		yOffset = 20;
		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result
	/* END CONFIG */
	$("a.tooltip").hover(function(e){
		this.t = this.title;
		this.title = "";
		$("body").append("<p id='tooltip'>"+ this.t +"</p>");
		$("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");
    },
	function(){
		this.title = this.t;
		$("#tooltip").remove();
    });
	$("a.tooltip").mousemove(function(e){
		$("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});
};

// starting the script on page load
$(document).ready(function(){
	tooltip();
});