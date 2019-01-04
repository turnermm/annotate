    jQuery( document ).ready(function() {            
   jQuery("span.anno") .mouseover(function() {
       var title = jQuery( this ).attr('title');     
      setTimeout(function() {
       jQuery("span." + title).css('display','inline-block');           
       }, 1200);         
    });
	
    jQuery("span.annotation").click(function() {     
	 jQuery(this).css('display','none');
    
   });	
   jQuery("span.anno_exit").click(function() {     
	 jQuery(this).parent().parent().css('display','none');
    });	
});
    
 	


