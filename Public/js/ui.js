/**
�Զ���ӷָ����ĸ�ʽ�������Ч��
�����������ʱ���Զ���ÿ��λ�ӷָ���
**/
function formatnumber(fnumber,fdivide,fpoint,fround){
	var fnum = fnumber + ����;
	var revalue="";
	if(fnum==null){
		for(var i=0;i<fpoint;i++)revalue+="0";
		return "0."+revalue;
	}
	fnum = fnum.replace(/^\sall|\sall$/g,����);
	if(fnum==""){
		for(var i=0;i<fpoint;i++)revalue+="0";
		return "0."+revalue;
	}
	fnum=fnum.replace(/,/g,"");
	if(fround){
		var temp = "0.";
		for(var i=0;i<fpoint;i++)temp+="0";
		temp += "5";
		fnum = Number(fnum) + Number(temp);
		fnum += ����;
	}
	var arrayf=fnum.split(".");
	if(fdivide){
		if(arrayf[0].length>3){
			while(arrayf[0].length>3){
				revalue=","+arrayf[0].substring(arrayf[0].length-3,arrayf[0].length)+revalue;
				arrayf[0]=arrayf[0].substring(0,arrayf[0].length-3);
			}
		}
	}
	revalue=arrayf[0]+revalue;
	if(arrayf.length==2&&fpoint!=0){
		arrayf[1]=arrayf[1].substring(0,(arrayf[1].length<=fpoint)?arrayf[1].length:fpoint);
		if(arrayf[1].length<fpoint)
		for(var i=0;i<fpoint-arrayf[1].length;i++)arrayf[1]+="0";
		revalue+="."+arrayf[1];
	}else if(arrayf.length==1&&fpoint!=0){
		revalue+=".";
		for(var i=0;i<fpoint;i++)revalue+="0";
	}
	return revalue;
}

/**
��дСд�Ľ�� , �Զ������д
**/
var stmp = "";
function nst(t)
{
	if(t.value==stmp) return;
	var ms = t.value.replace(/[^\d\.]/g,"").replace(/(\.\d{2}).+$/,"$1").replace(/^0+([1-9])/,"$1").replace(/^0+$/,"0");
	var txt = ms.split(".");
	while(/\d{4}(,|$)/.test(txt[0]))
	txt[0] = txt[0].replace(/(\d)(\d{3}(,|$))/,"$1,$2");
	t.value = stmp = txt[0]+(txt.length>1?"."+txt[1]:"");
	bbb.value = number2num1(ms-0);
}
function number2num1(strg)
{
	var number = Math.round(strg*100)/100;
	number = number.toString(10).split('.');
	var a = number[0];
	if (a.length > 12)
	return "��ֵ������Χ��֧�ֵ������ֵΪ 999999999999.99";
	var e = "��Ҽ��������½��ƾ�";
	var num1 = "";
	var len = a.length-1;
	for (var i=0 ; i<=len; i++)
	num1 += e.charAt(parseInt(a.charAt(i))) + [["Բ","��","��"][Math.floor((len-i)/4)],"ʰ","��","Ǫ"][(len-i)%4];
	if(number.length==2 && number[1]!="")
	{
		var a = number[1];
		for (var i=0 ; i<a.length; i++)
		num1 += e.charAt(parseInt(a.charAt(i))) + ["��","��"][i];
	}
	num1 = num1.replace(/���|��ʰ|��Ǫ|���/g,"��");
	num1 = num1.replace(/��{2,}/g,"��");
	num1 = num1.replace(/��(?=Բ|��|��)/g,"");
	num1 = num1.replace(/����/,"��");
	num1 = num1.replace(/^Բ��?/,"");
	if(num1!="" && !/��$/.test(num1))
	num1 += "��";
	return num1;
}
/**demo
Сд��<input type="text" name="aaa" onkeyup="nst(this)"><br>
��д��<input type="text" name="bbb" size=80>
**/