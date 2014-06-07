<?php

namespace nuvalis\Helpers;

class Helpers implements \Anax\DI\IInjectionAware
{

    use \Anax\DI\TInjectable;

	function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
	    $url = 'http://www.gravatar.com/avatar/';
	    $url .= md5( strtolower( trim( $email ) ) );
	    $url .= "?s=$s&d=$d&r=$r";
	    if ( $img ) {
	        $url = '<img src="' . $url . '"';
	        foreach ( $atts as $key => $val )
	            $url .= ' ' . $key . '="' . $val . '"';
	        $url .= ' />';
	    }
	    return $url;
	}

	function truncate($text, $chars = 250)
  	{

  	  if(strlen($text) > $chars) {

      $text = $text." ";
      $text = substr($text,0,$chars);
      $text = substr($text,0,strrpos($text,' '));
      $text = $text."...";
      
      }
      
      return $text;
  	}

  	function now()
  	{
  		return date("Y-m-d H:i:s");
  	}

  	function naturalizeMD($content, $chars = 250)
  	{

		$content = $this->textFilter->markdown($content);
		$content = strip_tags($content);
		$content = htmlentities($content);
		$content = $this->truncate($content, $chars);

		return $content;

  	}

}