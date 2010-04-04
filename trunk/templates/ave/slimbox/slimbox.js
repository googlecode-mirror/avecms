/*
	Slimbox v1.63 - The ultimate lightweight Lightbox clone
	(c) 2007-2008 Christophe Beyls <http://www.digitalia.be>
	MIT-style license.
*/
var Slimbox;(function(){var G={},H=0,F,M,B,T,U,P,E,N,K=new Image(),L=new Image(),Y,b,Q,I,X,a,J,Z,C;window.addEvent("domready",function(){$(document.body).adopt($$([Y=new Element("div",{id:"lbOverlay"}).addEvent("click",O),b=new Element("div",{id:"lbCenter"}),a=new Element("div",{id:"lbBottomContainer"})]).setStyle("display","none"));Q=new Element("div",{id:"lbImage"}).injectInside(b).adopt(I=new Element("a",{id:"lbPrevLink",href:"#"}).addEvent("click",D),X=new Element("a",{id:"lbNextLink",href:"#"}).addEvent("click",S));J=new Element("div",{id:"lbBottom"}).injectInside(a).adopt(new Element("a",{id:"lbCloseLink",href:"#"}).addEvent("click",O),Z=new Element("div",{id:"lbCaption"}),C=new Element("div",{id:"lbNumber"}),new Element("div",{styles:{clear:"both"}}));E={overlay:new Fx.Tween(Y,{property:"opacity",duration:500}).set(0),image:new Fx.Tween(Q,{property:"opacity",duration:500,onComplete:A}),bottom:new Fx.Tween(J,{property:"margin-top",duration:400})}});Slimbox={open:function(f,e,d){F=$extend({loop:false,overlayOpacity:0.8,resizeDuration:400,resizeTransition:false,initialWidth:250,initialHeight:250,animateCaption:true,showCounter:true,counterText:"����������� {x} �� {y}"},d||{});if(typeof f=="string"){f=[[f,e]];e=0}M=f;F.loop=F.loop&&(M.length>1);c();R(true);P=window.getScrollTop()+(window.getHeight()/15);E.resize=new Fx.Morph(b,$extend({duration:F.resizeDuration,onComplete:A},F.resizeTransition?{transition:F.resizeTransition}:{}));b.setStyles({top:P,width:F.initialWidth,height:F.initialHeight,marginLeft:-(F.initialWidth/2),display:""});E.overlay.start(F.overlayOpacity);H=1;return V(e)}};Element.implement({slimbox:function(d,e){$$(this).slimbox(d,e);return this}});Elements.implement({slimbox:function(d,g,f){g=g||function(h){return[h.href,h.title]};f=f||function(){return true};var e=this;e.removeEvents("click").addEvent("click",function(){var h=e.filter(f,this);return Slimbox.open(h.map(g),h.indexOf(this),d)});return e}});function c(){Y.setStyles({top:window.getScrollTop(),height:window.getHeight()})}function R(d){["object",window.ie?"select":"embed"].forEach(function(f){Array.forEach(document.getElementsByTagName(f),function(g){if(d){G[g]=g.style.visibility}g.style.visibility=d?"hidden":G[g]})});Y.style.display=d?"":"none";var e=d?"addEvent":"removeEvent";window[e]("scroll",c)[e]("resize",c);document[e]("keydown",W)}function W(d){switch(d.code){case 27:case 88:case 67:O();break;case 37:case 80:D();break;case 39:case 78:S()}return false}function D(){return V(T)}function S(){return V(U)}function V(d){if((H==1)&&(d>=0)){H=2;B=d;T=((B||!F.loop)?B:M.length)-1;U=B+1;if(U==M.length){U=F.loop?0:-1}$$(I,X,Q,a).setStyle("display","none");E.bottom.cancel().set(0);E.image.set(0);b.className="lbLoading";N=new Image();N.onload=A;N.src=M[d][0]}return false}function A(){switch(H++){case 2:b.className="";Q.setStyles({backgroundImage:"url("+M[B][0]+")",display:""});$$(Q,J).setStyle("width",N.width);$$(Q,I,X).setStyle("height",N.height);Z.set("html",M[B][1]||"");C.set("html",(F.showCounter&&(M.length>1))?F.counterText.replace(/{x}/,B+1).replace(/{y}/,M.length):"");if(T>=0){K.src=M[T][0]}if(U>=0){L.src=M[U][0]}if(b.clientHeight!=Q.offsetHeight){E.resize.start({height:Q.offsetHeight});break}H++;case 3:if(b.clientWidth!=Q.offsetWidth){E.resize.start({width:Q.offsetWidth,marginLeft:-Q.offsetWidth/2});break}H++;case 4:a.setStyles({top:P+b.clientHeight,marginLeft:b.style.marginLeft,visibility:"hidden",display:""});E.image.start(1);break;case 5:if(T>=0){I.style.display=""}if(U>=0){X.style.display=""}if(F.animateCaption){E.bottom.set(-J.offsetHeight).start(0)}a.style.visibility="";H=1}}function O(){if(H){H=0;N.onload=$empty;for(var d in E){E[d].cancel()}$$(b,a).setStyle("display","none");E.overlay.chain(R).start(0)}return false}})();

// AUTOLOAD CODE BLOCK (MAY BE CHANGED OR REMOVED)
Slimbox.scanPage = function() {
	var links = $$("a").filter(function(el) {
		return el.rel && el.rel.test(/^lightbox/i);
	});
	$$(links).slimbox({/* Put custom options here */}, null, function(el) {
		return (this == el) || ((this.rel.length > 8) && (this.rel == el.rel));
	});
};
window.addEvent("domready", Slimbox.scanPage);
