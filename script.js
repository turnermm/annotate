 jQuery( document ).ready(function() {    
  var last_anno_open; 
   jQuery("span.anno") .mouseover(function() {       
      var title = jQuery( this ).attr('title');     
      open_anno(title,600);
    });
    
  jQuery("span.anno") .click(function() {       
      var title = jQuery( this ).attr('title');     
      open_anno(title,1);
    });
    
    function open_anno(title,tm) {
       setTimeout(function() {
            if(last_anno_open)     {
                  hide(	jQuery(last_anno_open));	   
           }
           last_anno_open = "span." + title;
		     show(jQuery("span." + title));
           }, tm);         
    }

   jQuery("span.annotation").mouseover(function() {    
        show( jQuery(this));  
	// jQuery(this).css('display','inline-block');
   });	
   jQuery("span.annotation").mouseout(function() {     
       hide(jQuery(this));
    // jQuery(this).css('display','none');
   });	

   jQuery("span.annotation").dblclick(function() {     
       hide(jQuery(this));
   });	
   
   jQuery("span.anno_exit").click(function() {     
	    hide( jQuery(this).parent().parent());
    });	
	
	var show = function(object) {
		object.css('visibility','visible');
	};
	var hide = function(object) {
		object.css('visibility','hidden');
	};
});
    
 	


