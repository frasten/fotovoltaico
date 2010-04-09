<?php
//////////////////////////////////////////////////////////////////////////////////
// Php Textfile DB WebGUI                                                       //
// Copyright 2007 - 2008 by Paul A. Canals y Trocha                             //
// p-ACT! Webdesign, http://www.p-act.net                                       //
//////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////
// Redistribution and use in source and binary forms, with or without           //
// modification, are permitted provided that the following conditions are met:  //
// Redistributions of source code must retain the above copyright notice, this  //
// list of conditions and the following disclaimer.                             //
// Redistributions in binary form must reproduce the above copyright notice,    //
// this list of conditions and the following disclaimer in the documentation    //
// and/or other materials provided with the distribution.                       //
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"  //
// AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE    //
// IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE   //
// ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE     //
// LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR          //
// CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF         //
// SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS     //
// INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN      //
// CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)      //
// ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF       //
// THE POSSIBILITY OF SUCH DAMAGE.                                              //
//////////////////////////////////////////////////////////////////////////////////

function convertSize($size) {
	// convertSize(filesize($file));
	$i=0;
	$iec = array(" B", " KB", " MB", " GB");
	while (($size/1024)>1)
	{
		$size=$size/1024;
		$i++;
	}
	return substr($size,0,strpos($size,'.')+3).$iec[$i];
}

function getPHPVersion() {
	$regs = array();
	if (ereg("^([0-9])\.([0-9])", phpversion(), $regs))
	{
		$version = (float)( $regs[1] . "." . $regs[2] );
	} else {
		$version = 2;
	}
	return $version;
}

function gettemplate($template,$extension="tpl") {
        global $templatepath;
        return str_replace("\"","\\\"",implode("",file($templatepath."/".$template.".".$extension)));
}

function dooutput($template) {
        global $bgcolor, $bgcolornavi, $bgcolormain, $hrcolor, $tablebg, $tablea, $tableb, $tablec, $font, $fontcolor, $fontcolorlink, $fontcolorwarn;
        
        $template = str_replace("{pagebgcolor}","$bgcolor",$template);
	$template = str_replace("{navibgcolor}","$bgcolornavi",$template);
	$template = str_replace("{mainbgcolor}","$bgcolormain",$template);
        $template = str_replace("{hrcolor}","$hrcolor",$template);
        $template = str_replace("{tablebordercolor}","$tablebg",$template);
        $template = str_replace("{tablea}","$tablea",$template);
        $template = str_replace("{tableb}","$tableb",$template);
        $template = str_replace("{tablec}","$tablec",$template);
        $template = str_replace("{font}","$font",$template);
        $template = str_replace("{fontcolor}","$fontcolor",$template);
        $template = str_replace("{fontcolorlink}","$fontcolorlink",$template);
        $template = str_replace("{fontcolorwarn}","$fontcolorwarn",$template);

        echo $template;
}

function nextPhase ($phase) {
	switch ($phase)
	{
		case "{tablea}": $phase = "{tableb}"; break;
		case "{tableb}": $phase = "{tablea}"; break;
	}
	return $phase;
}

function splitSql ($sql) {
	$sql_statements = array();
	$inQuotes=false;
	$element="";
		
	// handles \ escape Chars
	$lastWasEscapeChar=false;
		
	for($i=0;$i<strlen($sql);$i++)
	{
		$c=$sql{$i};
		switch($c)
		{
			case "\\":
				if($lastWasEscapeChar)
				{
					$lastWasEscapeChar=false;
				} else {
					$lastWasEscapeChar=true;
				}
				$element.= $c;
			break;
			case "'":
			case "\"":
				if(!$lastWasEscapeChar) $inQuotes=(!$inQuotes);
				$element.= $c;
			break;
			case ";":
				if ($inQuotes)
				{
					$element.= $c;
				} else {
					$sql_statements[] = $element;
					$element = "";
				}
			break;
			default:
				$element.= $c;
			break;
		}
	}
	
	if ($element != "") $sql_statements[] = $element;

	return $sql_statements;
}

?>