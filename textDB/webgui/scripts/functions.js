<!--

function changeCSS(theClass,element,value) {
	//documentation for this script at http://www.shawnolson.net/a/503/
	var cssRules;
	if (document.getElementById) { cssRules = 'cssRules'; }
	else if (document.all) { cssRules = 'rules'; }
	for (var S = 0; S < document.styleSheets.length; S++)
	{
		for (var R = 0; R < document.styleSheets[S][cssRules].length; R++)
		{
			if (document.styleSheets[S][cssRules][R].selectorText == theClass)
			{
				document.styleSheets[S][cssRules][R].style[element] = value;
			}
		}
	}	
}


function checkNumeric(objName,comma,period,hyphen)
{
	var numberfield = objName;
	if (chkNumeric(objName,comma,period,hyphen) == false)
	{
		setTimeout(function(){numberfield.focus();},0); // Fix for FireFox bug
		setTimeout(function(){numberfield.select();},0); // Fix for FireFox bug
		return false;
	}
	else
	{
		return true;
	}
}

function chkNumeric(objName,comma,period,hyphen)
{
	var checkOK = "0123456789" + comma + period + hyphen;
	var checkStr = objName;
	var allValid = true;
	var decPoints = 0;
	var allNum = "";

	for (i = 0; i < checkStr.value.length; i++)
	{
		ch = checkStr.value.charAt(i);
		for (j = 0; j < checkOK.length; j++)
		if (ch == checkOK.charAt(j)) break;
		if (j == checkOK.length)
		{
			allValid = false;
			break;
		}
		if (ch != ",") allNum += ch;
	}
	if (!allValid)
	{	
		alert("Only numeric values are allowed in the Integer field! ");
		return false;
	}
}


function functionControl(selectbox,nullfield,textfield) { // v1.0

	var frm = document.forms[0];
	var box = eval ('frm.'+nullfield);
	var sel = eval ('frm.'+selectbox);
	var txt = eval ('frm.'+textfield);

	var mySelectedIndex = sel.selectedIndex;
	var mySelectedValue = sel[mySelectedIndex].value;
	var mySelectedText  = sel[mySelectedIndex].text;

	if ( mySelectedValue != '' )
	{
		if ( box != undefined )
		{
			box.disabled = false;
			box.checked = false;
			txt.disabled = false;
			txt.value = (txt.value=='NULL') ? '' : txt.value;
		}
	}
	else {
		sel.selectedIndex = 0;
	}
}


// Global variables
var fvalue = new Array;
var ftype  = new Array;
var fsaved = new Array;

function nullControl(typefield,checkbox,textfield) { // v1.0

	var frm = document.forms[0]; 
	var box = eval ('frm.'+checkbox);
	var inp = textfield;
	var typ = typefield.toLowerCase();
	var txt = eval ('frm.'+textfield);
	var val = '';

	if ( box.checked )
	{
		// put initial value in global array
		fvalue[inp] = txt.value;
		// set default value
		val = (typ == 'str') ? 'NULL' : '0';
		txt.disabled = true;
		txt.value = val;
	}
	else {
		// call initial value from global array
		val = (fvalue[inp]) ? fvalue[inp] : '';
		txt.disabled = false;
		txt.value = val;
	}
}


function typeControl(typefield,checkbox,textfield) { // v1.0

	var frm = document.forms[0]; 
	var box = eval ('frm.'+checkbox);
	var inp = textfield;
	var typ = typefield.toLowerCase();
	var txt = eval ('frm.'+textfield);
	var val = '';

	if ( box.checked )
	{
		if ( !fsaved[inp] || ftype[inp] != typ )
		{
			if ( txt.value != 'NULL' && txt.value != '0' && txt.value != '' )
			{
				// put initial value in global array
				fvalue[inp] = txt.value;			
				ftype[inp] = typ;
				fsaved[inp] = true;
			}
		}
		// set default value
		val = (typ == 'str') ? 'NULL' : '0';
		txt.disabled = true;
		txt.value = val;
	}
	else {
		// call initial value from global array
		val = (fvalue[inp]) ? fvalue[inp] : '';
		val = (ftype[inp] == typ) ? val : '';
		txt.disabled = false;
		txt.value = '';
	}
}


function valueControl(typevalue,selectbox,textfield) { // v1.0

	var frm = document.forms[0]; 
	var sel = eval ('frm.'+selectbox);
	var inp = textfield;
	var typ = typevalue.toLowerCase();
	var txt = eval ('frm.'+textfield);
	var val = '';

	var mySelectedIndex = sel.selectedIndex;
	var mySelectedValue = sel[mySelectedIndex].value;
	var mySelectedText  = sel[mySelectedIndex].text;

	if ( mySelectedText == 'NULL' )
	{
		if ( !fsaved[inp] || ftype[inp] != typ )
		{
			if ( txt.value != 'NULL' && txt.value != '0' && txt.value != '' )
			{
				// put initial value in global array
				fvalue[inp] = txt.value;			
				ftype[inp] = typ;
				fsaved[inp] = true;
			}
		}
		// set default value
		val = (typ == 'str') ? 'NULL' : '0';
		txt.disabled = true;
		txt.value = val;
	}
	else {
		// call initial value from global array
		val = (fvalue[inp]) ? fvalue[inp] : '';
		val = (ftype[inp] == typ) ? val : '';
		txt.disabled = false;
		txt.value = val;
	}
}


var WindowObjectReference = null; // global variable

function launchWindow(url,titel) {
	var w = 1024; var h = 768;
	if (WindowObjectReference == null || WindowObjectReference.closed)
	{
		if (document.all || document.layers) { w = screen.availWidth; h = screen.availHeight; }
		else { w = screen.width; h = screen.height; }
		var popW = 500; var popH = 240; var leftPos = (w-popW)/2, topPos = (h-popH)/2 - 10;
		WindowObjectReference = window.open(url,titel,'width=' + popW + ',height=' + popH + ',top=' + topPos + ',left=' + leftPos + ',menubar=no,resizable=1,scrollbars=0,status=1,toolbar=0');
	}
	WindowObjectReference.focus();
}


function reloadWindow(url,titel) {
	if (WindowObjectReference && !WindowObjectReference.closed)
	{
		WindowObjectReference = null;
		WindowObjectReference = launchWindow(url,titel)
	}
}

//-->