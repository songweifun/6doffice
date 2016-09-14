/*
 * WEIP - Web-based Enterprise Information Platform
 * Copyright (C) 2005 WEIP Group (http://www.weip.cn/)
 * All rights reserved.
 * δ����ɣ���ֹ������ҵ��;��
 * 
 * �汾(Version):  0.1
 * ����޸�ʱ��(Modified): 0000-00-00 00:00:00
 * 
 * �ļ�����(File Authors):
 *      κ���� (catorwei@163.com)
 */
/**
 * XML������
 *
 * @package weip.lib.xml
 */
 
function WEIPXml(_url) {
	/** XML�ļ���URL */
	this.url = _url;
	/** XML�ĵ����� */
	this.oDocument = null;
	/** XMLHTTP���� */
	this.oXmlHttp = null;

	/** ��������� */
	this.isNS = isNetscape;
	this.isIE = isIE;

	/**
	 * ��ȡXmlHttp����
	 */
	this.getXmlHttp = function() {
		if (this.isIE) {
			try {
				this.oXmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					this.oXmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {
					// nothing
				}
			}
		} else if (window.XMLHttpRequest) {
			this.oXmlHttp = new XMLHttpRequest();
			//if (this.oXmlHttp.overrideMimeType) {
			//	this.oXmlHttp.overrideMimeType("text/xml");
			//}
		}
	}
	
	/**
	 * װ��XML�ļ�
	 */
	this.load = function(_content, _isAsynchronous, _mothed, _xmlUrl) {
		_isAsynchronous = (!_isAsynchronous) ? false : true;
		if (!this.oXmlHttp) {
			this.getXmlHttp();
		}
		if (_xmlUrl) {
			this.url = _xmlUrl;
		}
		if (!_mothed) {
			_mothed = 'POST';
		}
		this.oXmlHttp.open(_mothed, this.url, _isAsynchronous);
		if (_mothed == 'POST') {
			this.oXmlHttp.setRequestHeader('Content-Type', 
										   'application/x-www-form-urlencoded');
		}
		if (_content) {
			this.oXmlHttp.send(_content);
		} else {
			this.oXmlHttp.send(null);
		}
		if (!_isAsynchronous) {
			if (this.oXmlHttp.status == 200) {
				this.oDocument = this.oXmlHttp.responseXML;
				return true;
			} else {
				alert('XML �������: ' + this.oXmlHttp.statusText 
						+ ' (' + this.oXmlHttp.status + ')');
			}
		} else {
			this.oXmlHttp.onreadystatechange = function() {
				switch (this.oXmlHttp.readyState) {
				case 0 :	// δ��ʼ��
					this.onUninitialized(); break;
				case 1 :	// װ����
					this.onLoading(); break;
				case 2 :	// װ�����
					this.onLoaded(); break;
				case 3 :	// ������
					this.onInteractive(); break;
				case 4 :	// ���
					if (this.oXmlHttp.status == 200) {
						this.oDocument = this.oXmlHttp.responseXML;
						this.onComplete();
					} else {
						alert('XML �������: ' + this.oXmlHttp.statusText 
										+ ' (' + this.oXmlHttp.status + ')');
					}
					break;
				}
			}.bind(this);
		}
		return false;
	}
	
	this.onUninitialized = function() {};	// δ��ʼ��
	this.onLoading		 = function() {};	// װ����
	this.onLoaded		 = function() {};	// װ�����
	this.onInteractive	 = function() {};	// ������
	this.onComplete		 = function() {};	// ���

	/**
	 * ��ȡ�ڵ�����
	 */
	this.selectNodes = function(xpath) {
		if (this.isIE) {
			return this.oDocument.selectNodes(xpath);
		} else {
			var aNodeArray = new Array();
			var xPathResult = this.oDocument.evaluate(xpath, this.oDocument, 
					this.oDocument.createNSResolver(this.oDocument.documentElement), 
					XPathResult.ORDERED_NODE_ITERATOR_TYPE, null);
			if (xPathResult) {
				var oNode = xPathResult.iterateNext();
				while (oNode) {
					aNodeArray[aNodeArray.length] = oNode;
					oNode = xPathResult.iterateNext();
				}
			}
			return aNodeArray;
		}
	}

	/**
	 * ��ȡ�����ڵ�
	 */
	this.selectSingleNode = function(xpath) {
		if (this.isIE) {
			return this.oDocument.selectSingleNode(xpath);
		} else {
			var xPathResult = this.oDocument.evaluate(xpath, this.oDocument,
					this.oDocument.createNSResolver(this.oDocument.documentElement), 9, null);
			if ( xPathResult && xPathResult.singleNodeValue ) {
				return xPathResult.singleNodeValue;
			} else {
				return null;
			}
		}
	}

	/**
	 * ��ȡ�ڵ�textֵ
	 */
	this.getText = function(xpath) {
		var oNode = (typeof(xpath) == "string") ? this.selectSingleNode(xpath) : xpath;
		if (oNode) {
			return (isIE) ? oNode.text : oNode.textContent;
		} else {
			return this.oXmlHttp.responseText;
		}
	}

	/**
	 * ��ȡ�ڵ�����ֵ
	 */
	this.getAttribute = function(xpath, attributeName) {
		var oNode = (typeof(xpath) == "string") ? this.selectSingleNode(xpath) : xpath;
		if (oNode) {
			var oAttribute = oNode.attributes.getNamedItem(attributeName);
			return (oAttribute) ? oAttribute.value : null;
		} else {
			return null;
		}
	}
}

Function.prototype.bind = function() {
	var __method = this, args = $A(arguments), object = args.shift();
	return function() {
		return __method.apply(object, args.concat($A(arguments)));
	}
}

var $A = Array.from = function(iterable) {
	if (!iterable) return [];
	if (iterable.toArray) {
		return iterable.toArray();
	} else {
		var results = [];
		for (var i = 0; i < iterable.length; i++) {
			results.push(iterable[i]);
		}
		return results;
	}
}
