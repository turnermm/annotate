 jQuery( document ).ready(function() {    
  var last_anno_open; 
   jQuery("span.anno") .mouseover(function() {       
      var title = jQuery( this ).attr('title');     
      open_anno(title,1200);
    });
    
  jQuery("span.anno") .click(function() {       
      var title = jQuery( this ).attr('title');     
      open_anno(title,1);
    });
    
    function open_anno(title,tm) {
       setTimeout(function() {
            if(last_anno_open)     {
              jQuery(last_anno_open) .css('display','none');
           }
           last_anno_open = "span." + title;
           jQuery("span." + title).css('display','inline-block');           
           }, tm);         
    }

   jQuery("span.annotation").mouseover(function() {     
	 jQuery(this).css('display','inline-block');
   });	
   jQuery("span.annotation").mouseout(function() {     
     jQuery(this).css('display','none');
   });	

   jQuery("span.annotation").click(function() {     
	 jQuery(this).css('display','none');
   });	
   
   jQuery("span.anno_exit").click(function() {     
	 jQuery(this).parent().parent().css('display','none');
    });	
});
    
 	


