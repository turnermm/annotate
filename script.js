    jQuery( document ).ready(function() {            
   jQuery("span.anno") .mouseover(function() {
       var title = jQuery( this ).attr('title');     
      setTimeout(function() {
       jQuery("span." + title).css('display','inline-block');           
       }, 1000);         
    });
	
   jQuery("span.anno_exit").click(function() {     
	 jQuery(this).parent().parent().css('display','none');
    });	
});
    
 	


