/*
*���ߣ���Ҹ�
*ʱ�䣺2008-1-12
*���ܣ����ض��ŷ��͵�״̬��0Ϊδ���ͣ�1Ϊ������
*/

var xmlHttp;

function createXMLHttpRequest()
{
	if (window.ActiveXObject)
	{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTp");	
	}
	else if (window.XMLHttpRequest)
	{
		xmlHttp = new XMLHttpRequest();	
	}
}

function sendNote()
{
	document.getElementById("sendNote").innerHTML="<a href=\"javascript:sendNote();\"><img src='..\/themes\/default\/images\/aanniu_19.GIF\' border='0'><\/a>";
	document.getElementById("vtext").innerHTML="��ע����ն��ţ���������е���֤��";
	createXMLHttpRequest();
	var url = "SendNote.php";
	xmlHttp.onreadystatechange = handleStateChange;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function handleStateChange()
{
	if (xmlHttp.readyState == 4)
	{
		if (xmlHttp.status == 200)
		{
			//alert(xmlHttp.responseText);
			//var SendInfo = xmlHttp.responseText;
		}
	}
}