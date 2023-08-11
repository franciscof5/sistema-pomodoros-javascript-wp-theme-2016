<?php
/*
Plugin Name: Readme Parser
Plugin URI: http://www.tomsdimension.de/wp-plugins/readme-parser
Description: Loads and formats (a little) readme files [readme-parser url="http://www.xyz.com/readme.txt"]
Version: 0.3
Author: Tom Braider
Author URI: http://www.tomsdimension.de
*/


class readme_parser
{

/**
 * constructor
 */
function __construct()
{
	add_shortcode('readme-parser', array(&$this, 'shortcode'));
}



/**
 * parses parameters
 *
 * @param string $atts parameters
 * @param string $content spoiler content
 * @return unknown
 */
function shortcode( $atts, $content )
{
	extract(shortcode_atts(array('url' => ''), $atts));
	if (empty($url))
		$url = $content;
	return $this->replace( $url );
}



/**
 * creates readme code
 *
 * @param string $url URL of textfile readme.txt
 * @return string readme code
 */
function replace( $url )
{
	// no/wrong url
	if ( empty($url) or basename($url) != 'readme.txt')
		return false;

	// read file
	$file = @file_get_contents( $url );
	if (empty($file))
		return '<b>Readme Parser: readme.txt nicht gefunden!</b>';
	
	// line end to \n
	$file = preg_replace("/(\n\r|\r\n|\r|\n)/", "\n", $file);

	// place version
	$file = $this->get_version( $file );
	
	// set screenshot links
	$file = $this->get_screenshots( $url, $file );

	// headlines
	$s = array('===','==','=' );
	$r = array('h2' ,'h3','h4');
	for ( $x = 0; $x < sizeof($s); $x++ )
		$file = preg_replace('/(.*?)'.$s[$x].'(?!\")(.*?)'.$s[$x].'(.*?)/', '$1<'.$r[$x].'>$2</'.$r[$x].'>$3', $file);

	// inline
	$s = array('\*\*','\''  );
	$r = array('b'   ,'code');
	for ( $x = 0; $x < sizeof($s); $x++ )
		$file = preg_replace('/(.*?)'.$s[$x].'(?!\s)(.*?)(?!\s)'.$s[$x].'(.*?)/', '$1<'.$r[$x].'>$2</'.$r[$x].'>$3', $file);
	
	// ' _italic_ '
	$file = preg_replace('/(\s)_(\S.*?\S)_(\s|$)/', ' <em>$2</em> ', $file);
	
	// ul lists	
	$s = array('\*','\+','\-');
	for ( $x = 0; $x < sizeof($s); $x++ )
		$file = preg_replace('/^['.$s[$x].'](\s)(.*?)(\n|$)/m', '<li>$2</li>', $file);
	$file = preg_replace('/\n<li>(.*?)/', '<ul><li>$1', $file);
	$file = preg_replace('/(<\/li>)(?!<li>)/', '$1</ul>', $file);
	
	// ol lists
	$file = preg_replace('/(\d{1,2}\.)\s(.*?)(\n|$)/', '<li>$2</li>', $file);
	$file = preg_replace('/\n<li>(.*?)/', '<ol><li>$1', $file);
	$file = preg_replace('/(<\/li>)(?!(\<li\>|\<\/ul\>))/', '$1</ol>', $file);
	
	// ol screenshots style
	$file = preg_replace('/(?=Screenshots)(.*?)<ol>/', '$1<ol class="readme-parser-screenshots">', $file);
	
	// line breaks
	$file = preg_replace('/(.*?)(\n)/', "$1<br/>\n", $file);
	$file = preg_replace('/(1|2|3|4)(><br\/>)/', '$1>', $file);
	$file = str_replace('</ul><br/>', '</ul>', $file);
	$file = str_replace('<br/><br/>', '<br/>', $file);
	
	// urls
	$file = str_replace('http://www.', 'www.', $file);
	$file = str_replace('www.', 'http://www.', $file);
	$file = preg_replace('#(^|[^\"=]{1})(http://|ftp://|mailto:|https://)([^\s<>]+)([\s\n<>]|$)#', '$1<a href="$2$3">$3</a>$4', $file);
		
	// divs
	$file = preg_replace('/(<h3> Description <\/h3>)/', "$1\n<div id=\"readme-description\" class=\"readme-div\">\n", $file);
	$file = preg_replace('/(<h3> Installation <\/h3>)/', "</div>\n$1\n<div id=\"readme-installation\" class=\"readme-div\">\n", $file);
	$file = preg_replace('/(<h3> Frequently Asked Questions <\/h3>)/', "</div>\n$1\n<div id=\"readme-faq\" class=\"readme-div\">\n", $file);
	$file = preg_replace('/(<h3> Screenshots <\/h3>)/', "</div>\n$1\n<div id=\"readme-screenshots\" class=\"readme-div\">\n", $file);
	$file = preg_replace('/(<h3> Arbitrary section <\/h3>)/', "</div>\n$1\n<div id=\"readme-arbitrary\" class=\"readme-div\">\n", $file);
	$file = preg_replace('/(<h3> Changelog <\/h3>)/', "</div>\n$1\n<div id=\"readme-changelog\" class=\"readme-div\">\n", $file);
	$file = $file.'</div>';
	
	// promotion ;)
	$promo = '<div style="text-align:right;"><small>created by <a href="http://www.tomsdimension.de/wp-plugins/readme-parser">Readme Parser</a></small></div>';

	return  '<div class="readme-parser">'.$file.$promo.'</div>';
}



/**
 * inserts version in after plugin name
 *
 * @param string $file file
 * @return string file
 */
function get_version( $file )
{
	$start = strpos( $file, 'Stable tag:' ) + 12;
	$end = strpos( $file, "\n", $start );
	$version = substr( $file, $start, $end - $start );
	$file = str_replace( ' ===', ' '.$version.' ===', $file );
	return $file;
}



/**
 * replaces screenshots with links to images if exists
 *
 * @param string $url URL of readme.txt
 * @param string $file file
 * @return string file
 */
function get_screenshots( $url, $file )
{
	$pos = strpos( $file, '== Screenshots ==' );
	
	if ( $pos === false )
		return $file;
	
	$start = $pos + 17;
	$end = strpos( $file, '== ', $start );
	
	$subfile = substr( $file, $start, $end - $start );
	$rows = explode( "\n", $subfile ); 
	
	$newsubfile = "\n";
	
	foreach ( $rows as $row )
	{
		for ( $number = 1; $number <= 9; $number++ )
		{
			if ( substr( $row, 0, 1) == $number )
			{
				foreach ( array('png','jpg','gif') as $ext )
				{
					$img = dirname($url).'/screenshot-'.$number.'.'.$ext;
					$mime = @getimagesize($img);
					if ( strpos($mime['mime'], 'image') !== false )
					{
						$newsubfile .= $number.'. <a href="'.$img.'"><img src="'.$img.'" title="'.$row.'" /></a><br />'.$row."\n";
						break;
					}
				}
				break;
			}
		}
	}
	
	if ( $newsubfile != "\n" )
		$file = str_replace( $subfile, $newsubfile, $file );
	return $file;
}

} // class

new readme_parser();

