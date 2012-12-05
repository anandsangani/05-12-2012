function ajax()
{			

	xmlobj = give_xmlobj();
	var k;
	k = "getdata.php?s=" + document.getElementById("user_name").value;

	xmlobj.open("GET",k,false);
	xmlobj.send(null);
	
	document.getElementById("message").innerHTML = xmlobj.responseText;
	
}

function give_xmlobj()
{
	//new web browers
	if(window.XMLHttpRequest)
	{
		return new XMLHttpRequest();
	}
	
	//old web browsers
	if(window.ActiveXObject)
	{
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	return false;
}
