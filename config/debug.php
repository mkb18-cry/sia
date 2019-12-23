<?php 
//Added by Andre
//*********************************************************************
//This is for Developer. If you will search bug of this site 

//This Method is get output from input; 
//INPUT		: $db
//OUTPUT	: Result of your database server	
function web_debug($data) {
	ob_start();
	var_dump($data);
	$c = ob_get_contents();
	ob_end_clean();
 
	$c = preg_replace("/\r\n|\r/", "\n", $c);
	$c = str_replace("]=>\n", '] = ', $c);
	$c = preg_replace('/= {2,}/', '= ', $c);
	$c = preg_replace("/\[\"(.*?)\"\] = /i", "[$1] = ", $c);
	$c = preg_replace('/    /', "        ", $c);
	$c = preg_replace("/\"\"(.*?)\"/i", "\"$1\"", $c);
 
	$c = htmlspecialchars($c, ENT_NOQUOTES);
 
	// Expand numbers (ie. int(2) 10 => int(1) 2 10, float(6) 128.64 => float(1) 6 128.64 etc.)
	$c = preg_replace("/(int|float)\(([0-9\.]+)\)/ie", "'$1('.strlen('$2').') <span class=\"number\">$2</span>'", $c);
	
	// Syntax Highlighting of Strings. This seems cryptic, but it will also allow non-terminated strings to get parsed.
	$c = preg_replace("/(\[[\w ]+\] = string\([0-9]+\) )\"(.*?)/sim", "$1<span class=\"string\">\"", $c);
	$c = preg_replace("/(\"\n{1,})( {0,}\})/sim", "$1</span>$2", $c);
	$c = preg_replace("/(\"\n{1,})( {0,}\[)/sim", "$1</span>$2", $c);
	$c = preg_replace("/(string\([0-9]+\) )\"(.*?)\"\n/sim", "$1<span class=\"string\">\"$2\"</span>\n", $c);
	
	$regex = array(
			// Numberrs
			'numbers' => array('/(^|] = )(array|float|int|string|resource|object\(.*\)|\&amp;object\(.*\))\(([0-9\.]+)\)/i', '$1$2(<span class="number">$3</span>)'),
			
			// Keywords
			'null' => array('/(^|] = )(null)/i', '$1<span class="keyword">$2</span>'),
			'bool' => array('/(bool)\((true|false)\)/i', '$1(<span class="keyword">$2</span>)'),
			
			// Types
			'types' => array('/(of type )\((.*)\)/i', '$1(<span class="type">$2</span>)'),
			
			// Objects
			'object' => array('/(object|\&amp;object)\(([\w]+)\)/i', '$1(<span class="object">$2</span>)'),
			
			// Function
			'function' => array('/(^|] = )(array|string|int|float|bool|resource|object|\&amp;object)\(/i', '$1<span class="function">$2</span>('),
	);
	
	foreach ($regex as $x) {
			$c = preg_replace($x[0], $x[1], $c);
	}
	
	$style = '
	/* outside div - it will float and match the screen */
	.dumpr {
			margin: 2px;
			padding: 2px;
			background-color: #fbfbfb;
			float: left;
			clear: both;
	}
	/* font size and family */
	.dumpr pre {
			color: #000000;
			font-size: 9pt;
			font-family: "Courier New",Courier,Monaco,monospace;
			margin: 0px;
			padding-top: 5px;
			padding-bottom: 7px;
			padding-left: 9px;
			padding-right: 9px;
	}
	/* inside div */
	.dumpr div {
			background-color: #fcfcfc;
			border: 1px solid #d9d9d9;
			float: left;
			clear: both;
	}
	/* syntax highlighting */
	.dumpr span.string {color: #c40000;}
	.dumpr span.number {color: #ff0000;}
	.dumpr span.keyword {color: #007200;}
	.dumpr span.function {color: #0000c4;}
	.dumpr span.object {color: #ac00ac;}
	.dumpr span.type {color: #0072c4;} 
	.legenddumpr {
		background-color: #fcfcfc;
		border: 1px solid #d9d9d9;
		padding: 2px;           
	}        
	';
	
	$style = preg_replace("/ {2,}/", "", $style);
	$style = preg_replace("/\t|\r\n|\r|\n/", "", $style);
	$style = preg_replace("/\/\*.*?\*\//i", '', $style);
	$style = str_replace('}', '} ', $style);
	$style = str_replace(' {', '{', $style);
	$style = trim($style);
 
	$c = trim($c);
	$c = preg_replace("/\n<\/span>/", "</span>\n", $c);
	
	$isi = "";
	$isi .= "<style type=\"text/css\">".$style."</style>\n";
	$isi .=  '<fieldset class="dumpr">';
		$isi .=  '<legend class="legenddumpr">'.basename($_SERVER['SCRIPT_FILENAME']).'</legend>';
		//echo '<div>';
			$isi .=  '<pre>'.$c.'</pre>';
		//echo '</div>';
		
	$isi .=  '</fieldset>';
	$isi .=  "<div style=\"clear:both;\">&nbsp;</div>";
	ob_end_flush();
	return $isi;
}
?>