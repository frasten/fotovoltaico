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

$txtdb_WEBGUI_version = "0.5.3"; // DO NOT CHANGE THIS!!


#--------------------------------------------------------------------------------#
# Path to "txt-db-api.php"
#--------------------------------------------------------------------------------#

$txtdbapi = "../txt-db-api.php";


#--------------------------------------------------------------------------------#
# Path to the default language file
#--------------------------------------------------------------------------------#

$default_language = "english.php";


#--------------------------------------------------------------------------------#
# Path to the default template
#--------------------------------------------------------------------------------#

$templateroot = "themes/default";
$templatepath = $templateroot."/tpl";


#--------------------------------------------------------------------------------#
# Array of alternative templates, starts with index ZERO!
#--------------------------------------------------------------------------------#

$templates[0]['path'] = "themes/default/tpl";
$templates[0]['root'] = "themes/default";
$templates[0]['desc'] = "default";

//$templates[1]['path'] = "themes/it_emx";
//$templates[1]['desc'] = "Italian version";

#--------------------------------------------------------------------------------#
# Style variables
#--------------------------------------------------------------------------------#

$layout = $templateroot."/layout.inc.php";


#--------------------------------------------------------------------------------#
# Define Default variable values
#--------------------------------------------------------------------------------#

// default limit values with a sql select query 
$LIMIT_OFFSET = 0;
$LIMIT_RESULT = 10;


#--------------------------------------------------------------------------------#
?>
