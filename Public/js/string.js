//��ȡ�����ַ���ǰ�����е��ַ�
function getFront(mainStr,searchStr){
    foundOffset=mainStr.indexOf(searchStr);
    if(foundOffset==-1){
       return null;
    }
    return mainStr.substring(0,foundOffset);
}
//��ȡ�����ַ�������������ַ�
function getEnd(mainStr,searchStr){
    foundOffset=mainStr.indexOf(searchStr);
    if(foundOffset==-1){
       return null;
    }
    return mainStr.substring(foundOffset+searchStr.length,mainStr.length);
}
//���ַ��� searchStr ǰ������ַ��� insertStr 
function insertString(mainStr,searchStr,insertStr){
    var front=getFront(mainStr,searchStr);
    var end=getEnd(mainStr,searchStr);
    if(front!=null && end!=null){
       return front+insertStr+searchStr+end;
    }
    return null;
}
//ɾ���ַ��� deleteStr
function deleteString(mainStr,deleteStr){
    return replaceString(mainStr,deleteStr,"");
}
//���ַ��� searchStr �޸�Ϊ replaceStr
function replaceString(mainStr,searchStr,replaceStr){
    var front=getFront(mainStr,searchStr);
    var end=getEnd(mainStr,searchStr);
    if(front!=null && end!=null){
       return front+replaceStr+end;
    }
    return null;
}