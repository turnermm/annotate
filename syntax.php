<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
   *
   * class       plugin_ckgedit_specials
   * @author     Myron Turner <turnermm02@shaw.ca>
*/
        
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');


class syntax_plugin_annotate extends DokuWiki_Syntax_Plugin {


    /**
     * What kind of syntax are we?
     */
    function getType(){
        return 'substition';
    }
   
    /**
     * What about paragraphs?
     */

    function getPType(){      
      // return 'block';
    }

    /**
     * Where to sort in?
     */ 
    function getSort(){
        return 155;
    }


    /**
     * Connect pattern to lexer
     */
     public function connectTo($mode) {
		 $this->Lexer->addEntryPattern(
		 '<@anno:\d\d?>(?=.*?</@anno>)',$mode,
		 'plugin_annotate');
		 
		 $this->Lexer->addSpecialPattern(
		 '<anno:\d\d?>.*?</anno>',$mode,'plugin_annotate');	
      
	 }
     

 public function postConnect() { 
       $this->Lexer->addExitPattern('</@anno>','plugin_annotate'); 
 }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, Doku_Handler $handler){

        switch($state) {    
          case DOKU_LEXER_ENTER :
		   $match = str_replace(':','_',substr($match,2,-1));	
			   return array($state, $match);
          case DOKU_LEXER_UNMATCHED :  
            //  msg(htmlentities($match));		  
              return array($state, $match);
          case DOKU_LEXER_EXIT :   return array($state, '');                
          case DOKU_LEXER_SPECIAL: 			  
		      $inner = substr($match,6,-7);
			 // msg($inner);	
			  return array($state, $inner); 
       }
         return array($state, "" );
       
    }

   /**
     * Create output
     */
    function render($mode, Doku_Renderer $renderer, $data) {
		//return false;
        if($mode == 'xhtml'){
            list($state, $xhtml) = $data;
            switch ($state) {
                case DOKU_LEXER_ENTER : 
				    $tip = '<span class="annotation ui-widget-content '. $xhtml . '">';
				    $renderer->doc .= $tip;
				break;                                                        
                case DOKU_LEXER_UNMATCHED : 
				 // msg(htmlentities($xhtml));
                $renderer->doc .= '<span id="anno_close"><span class="anno_exit">close</span> </span>';
                $renderer->doc .= htmlentities($xhtml); break;
                case DOKU_LEXER_EXIT : 
				    $renderer->doc .= "</span>"; break; 
				case DOKU_LEXER_SPECIAL:
				  //  msg(htmlentities($xhtml));
					list($which,$text)= explode('>',$xhtml); 
                    $title = 'anno_' .$which;
				    $renderer->doc .= '<span class="anno" title="' .$title.'">' .htmlentities($text).'</span>';				     break;	
				
        }
           return true;
        }
        return false;
    }
    
  function write_debug($what) {
     $handle = fopen("blog_pats.txt", "a");
     fwrite($handle,"$what\n");
     fclose($handle);
  }
}


