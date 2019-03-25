 /**
  * @author Myron Turner <turnermm02@shaw.ca>
  */
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
		    var elem;
            if(last_anno_open)     {
              jQuery(last_anno_open) .css('display','none');
           }
		   if(jQuery("p." + title)) {	
		      elem = 'p';
		   }
           else {
			   elem = 'span';
		   }			   
           last_anno_open = elem + '.' + title;		 
           jQuery("p." + title).css('display','inline-block');           
           }, tm);         
    }

      jQuery("span[id^='anno_close'") .each(function() {       
         var clss = jQuery(this).parent().attr('class');
         if(typeof clss != 'undefined') {
             if(clss.match(/_r/) ) {
				if (!jQuery(this).parent().css('border-radius')) {
				    jQuery(this).parent().css('border-radius','15px');
				}
                 jQuery(this).css('border-radius','10px');
             }
         }
    });
    
/*anno-dclk-over */
/*span[class*='anno-dclk-over']*/
   if(JSINFO['anno_mouseout']) {       
   jQuery("span[class*='annotation'],p[class*='annotation'], .anno-dclk-over").mouseover(function() {     
	 jQuery(this).css('display','inline-block');
   });	
   jQuery("span[class*='annotation'],p[class*='annotation'], .anno-dclk-over").mouseout(function() {     
     jQuery(this).css('display','none');
   });	
   }
    if(JSINFO['anno_dblclick']) {   
   jQuery("span[class*='annotation'],p[class*='annotation'], .anno-dclk-over").dblclick(function() {     
	 jQuery(this).css('display','none');
   });	
   }
   jQuery("span.anno_exit").click(function() {     
	 jQuery(this).parent().parent().css('display','none');
    });	
});
    


