jQuery.fn.extend({
tabs: function(){

 // this.each(function(){console.log(this);});
  this.each(function(){ createOneTab(this); });

  return;


  function createOneTab(container){
    var obj = container.jQuery?container:$(container);
    var elements = $('>.tab-body > .tab-body-element ',container);
    //console.log(elements[0]);
    //console.log(elements);
    elements.css({display:'none'});
    //$(elements[0]).css({display:'block'});

    var handles = $('>.tab-header > .tab-handle',container);
    handles.each(function(index,handle){
        var bodies = elements;
        var me = handle;
        me.idx = index;
        var siblings = handles;
        $(me).click(
          function(){
            bodies.css({display: 'none'});
            $(bodies[this.idx]).css({display:'block'});
            handles.removeClass('active-tab-handle');
            $(this).addClass('active-tab-handle');
          }
        );
    });

    $(handles[0]).click();

  }
 // this.each(createOneTab);
}
});
