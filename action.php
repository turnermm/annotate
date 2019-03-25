<?php
/**
 *@author    Myron Turner <turnermm02@shaw.ca> 
 */
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');
class action_plugin_annotate extends DokuWiki_Action_Plugin {
    public function register(Doku_Event_Handler $controller) {     
	  $controller->register_hook('DOKUWIKI_STARTED', 'BEFORE', $this, 'handle_started',array('before'));   
    }
    function handle_started(Doku_Event $event, $param) {  
        global $JSINFO;
        $JSINFO['anno_mouseout'] = $this->getConf('mouseout') ;
        $JSINFO['anno_dblclick'] = $this->getConf('dblclick') ;
        $JSINFO['anno_radius'] = $this->getConf('radius') ;
        msg('<pre>' .print_r($JSINFO,1) .'</pre>');
    }
  }  
	