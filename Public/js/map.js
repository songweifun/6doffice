// JavaScript Document
/* ======================================================================================
����ĺ������û�������еġ������ͼ��ʱ�򿪵�ͼ���ڡ�
��������������ĸ��ֲ�����CID,width,height�Ȳ�����Ҫ���ڲ������ʱ���úã���name�Ȳ���ֵ������ҳ����
��ȡ�������������NID������ֵ�����޸Ĵ�NID����ı�㣬��������µı�㣨�ο�˵���ĵ�����                          
====================================================================================== */
function insertMap() {
    var url = "proxy.php?api=template1000&CID=anleye&tid=tid1000&width=600&height=400&zoom=10&control=2		   &cityName="+encodeURIComponent(document.getElementById("cityName").value)+"&nid="+document.getElementById("nid").value+
          "&name="+encodeURIComponent(document.getElementById("name").value)+
          "&address="+encodeURIComponent(document.getElementById("address").value)+
          "&phone="+encodeURIComponent(document.getElementById("phone").value);
	var winname = window.open(url, '_blank');
  }


/* ======================================================================================
������ύ����ť�󣬳�����Զ�����setNid�������Զ����ɵ�nid���������û������Լ��ڷ�������Ӵ����nid��������                          
====================================================================================== */
function setNid(nid) {
    document.getElementById("nid").value = nid;
  }