<!--

function selectRowsInit() {
	// for every table row ...
	var rows = document.getElementsByTagName('tr');
	for ( var i = 0; i < rows.length; i++ )
	{
		// ... with the class 'row'...
		if ( 'row' != rows[i].className.substr(0,3) )
		{
			continue;
		}
		// ... add event listeners ...
		// ... to highlight the row on mouseover ...
		if ( navigator.appName == 'Microsoft Internet Explorer' )
		{
			// but only for IE, other browsers are handled by :hover in css
			rows[i].onmouseover = function()
			{
				this.className += ' hover';
			}
			rows[i].onmouseout = function()
			{
				this.className = this.className.replace( ' hover', '' );
			}
		}
	}
}

if (window.attachEvent) window.attachEvent("onload", selectRowsInit); // IE specific
//else window.onload=selectRowsInit;

//-->