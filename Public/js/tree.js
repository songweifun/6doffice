

var treeBoxList = new Array();
/**
 * ���͵�ͼ���� 
 *
 * _plusMiddle     ͼ�� �Ӻ� �м�
 * _plusEnd        ͼ�� �Ӻ� ����
 * _minusMiddle    ͼ�� ���� �м�
 * _minusEnd       ͼ�� ���� ����
 * _line           ͼ�� ֱ��
 * _lineMiddle     ͼ�� ֱ�� �м�
 * _lineEnd        ͼ�� ֱ�� ����
 * _iconsType      ͼ������ text���ı�����ͼƬ��Ĭ�ϣ�
 */
function TreeIcons(_plusMiddle, _plusEnd, _minusMiddle, _minusEnd, _line,
        _lineMiddle, _lineEnd, _iconsType ) {
//    var prefix = "http://images.chinahouse.com";
    var prefix = commonImagePath;
    _plusMiddle     = (_plusMiddle) ? _plusMiddle 
                    : prefix + "images/tree_line_solid_plus.gif";
    _plusEnd        = (_plusEnd) ? _plusEnd
                    : prefix + "images/tree_line_solid_plus_end.gif";
    _minusMiddle    = (_minusMiddle) ? _minusMiddle
                    : prefix + "images/tree_line_solid_minus.gif";
    _minusEnd       = (_minusEnd) ? _minusEnd
                    : prefix + "images/tree_line_solid_minus_end.gif";
    _line           = (_line) ? _line
                    : prefix + "images/tree_line_solid_null.gif";
    _lineMiddle     = (_lineMiddle) ? _lineMiddle
                    : prefix + "images/tree_line_solid.gif";
    _lineEnd        = (_lineEnd) ? _lineEnd
                    : prefix + "images/tree_line_solid_null_end.gif";
    if (_iconsType=="text") { //Ϊ�ı�
        this.plusMiddle     = _plusMiddle;
        this.plusEnd        = _plusEnd;
        this.minusMiddle    = _minusMiddle;
        this.minusEnd       = _minusEnd;
        this.line           = _line;
        this.lineMiddle     = _lineMiddle;
        this.lineEnd        = _lineEnd;
    } else { //Ĭ��ΪͼƬ
        this.plusMiddle     = '<img src="' + _plusMiddle 
                                + '" align="absmiddle">';
        this.plusEnd        = '<img src="' + _plusEnd + '" align="absmiddle">';
        this.minusMiddle    = '<img src="' + _minusMiddle 
                                + '" align="absmiddle">';
        this.minusEnd       = '<img src="' + _minusEnd + '" align="absmiddle">';
        this.line           = _line;
        //this.line         = '<img src="' + _line + '" align="absmiddle">';
        this.lineMiddle     = '<img src="' + _lineMiddle 
                                + '" align="absmiddle">';
        this.lineEnd        = '<img src="' + _lineEnd + '" align="absmiddle">';
    }
}

/**
 * ������
 * 
 * _id
 * _width          ���
 * _height         �߶�
 * _treeIcons      ����ͼ����
 * _caption        ����
 * _expandEvent    չ���¼� function (node)
 * _closeEvent     �ر��¼� function (node)
 * _focusEvent     ����ı��¼� function (srcObj, destObj)
 * _loadEvent      �ڵ�װ���¼� function (node)
 * _clickEvent     �ڵ繫������¼� function (node)
 */
function TreeBox(_id, _width, _height, _treeIcons, _caption, _expandEvent,
        _closeEvent, _focusEvent, _loadEvent, _clickEvent) {
    /* ���� */
    this.id             = _id;
    this.caption        = (_caption) ? _caption : '';
    this.width          = _width;//(_width) ? _width : '100%';
    this.height         = _height;//(_height) ? _height : '100%';
    this.treeIcons      = (_treeIcons) ? _treeIcons : null;
    this.expandEvent    = (_expandEvent) ? _expandEvent : null;
    this.closeEvent     = (_closeEvent) ? _closeEvent : null;
    this.focusEvent     = (_focusEvent) ? _focusEvent : null;
    this.loadEvent      = (_loadEvent) ? _loadEvent : null;
    this.clickEvent     = (_clickEvent) ? _clickEvent : null;
    this.parent         = null;
    this.treeNodes      = new Array();
    this.nodes          = new Array();
    this.boxObj         = this;
    this.selected       = null;
    this.isLoaded       = true;
    this.noChild        = true;
    this.level          = 0;
    treeBoxList[_id]    = this;
    document.open('text/html');
//    document.writeln('<input name="selected_id_' + this.id 
//            + '" id="selected_id_' + this.id 
//            + '" type="hidden">');
    document.writeln('<input id="selected_id_' + this.id 
            + '" type="hidden">');
    document.close();
	
	

    
    /* ���� */
    /**
     * ������ʾ
     * toWrite ���Ϊ true����ֱ�������ҳ�棬ͬʱ��������HTML���룬����ֻ��������HTML���롣
     */
    this.show = function(toWrite) {
        var html;
        html = '<div id="tree_' + this.id + '" style="width:' + this.width
                + ';height:' + this.height 
                + ';overflow:auto" onSelectStart="return false">';
        if (this.treeNodes.length>0) {
            html += '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
            for (var i=0; i<this.treeNodes.length; i++) {
                html += this.treeNodes[i].show();
            }
            html += '</table>';
        }
        html += '</div>';
        /* ��� */
        if (toWrite) {
            document.open('text/html');
            document.writeln(html); 
            document.close();
        }
        return html;
    }
    
    /**
     * �������ڵ�
     *
     * _parent           ���ڵ�
     * _id               �ڵ�ID
     * _caption          ����
     * _icon             ͼ��
     * _description      ����
     * _clickEvent       ����¼�
     * _isExpanded       �Ƿ���չ����
     * _custom           �Զ���
     */
    this.createNode = function(_parent, _id, _caption, _icon, _description,
            _clickEvent, _isExpanded, _custom, icon_open, icon_select) {
		
		
		if (typeof(icon_open)=='undefined') {
			var icon_open = '';
		} 
		if (typeof(icon_select)=='undefined') {
			var icon_select = '';
		} 			

        if (typeof(this.nodes[_id])=='undefined') {
            this.nodes[_id] = new TreeNode(_parent, _id, _caption, _icon,
                    _description, _clickEvent, _isExpanded, _custom, icon_open, icon_select);
            return this.nodes[_id];
        } else {
            return null;
        }
    }
    
    /** չ�������ӽڵ� */
    this.expandAll = function(node) {
        if (!node) {
            node = this;
        }
        if (node.parent) {
            node.expand(true);
        }
        for (var i=0; i<node.treeNodes.length; i++) {
            this.expandAll(node.treeNodes[i]);
        }
    }
    /** �ر������ӽڵ� */
    this.closeAll = function(node) {
        if (!node) {
            node = this;
        }
        if (node.parent) {
            node.expand(false);
        }
        if (node.isLoaded) {
            for (var i=0; i<node.treeNodes.length; i++) {
                this.closeAll(node.treeNodes[i]);
            }
        }
    }
	

}

/**
 * ���ͽڵ���
 * 
 * _parent         ���ڵ�
 * _id             �ڵ�ID
 * _caption        ����
 * _icon           ͼ��
 * _description    ����
 * _clickEvent     ����¼�
 * _isExpanded     �Ƿ���չ����
 * _custom         �Զ��� 
 */ 
function TreeNode(_parent, _id, _caption, _icon, _description, _clickEvent,
        _isExpanded, _custom, _iconOpen, _iconSelect) {
    /* ���� */
    this.id             = _id;
    this.parent         = _parent;
    this.caption        = _caption;
    this.icon           = _icon;
	this.iconClose      = _icon;	//�պ�ͼ��
	this.iconOpen       = '';		//չ��ͼ��
	this.iconSelect     = '';		//ѡ��ͼ��
	
    this.description    = (_description) ? _description : '';
    this.clickEvent     = (_clickEvent) ? _clickEvent : '';
    this.custom         = (_custom) ? _custom : '';
    this.isExpanded     = (_isExpanded) ? true : false;
    this.treeNodes      = new Array();
    this.isEnd          = true;
    this.isLoaded       = false;
    this.noChild        = true;
    this.level          = 0;
	
	
	
	
	if((typeof(_iconOpen)=='undefined') ){
		this.iconOpen   = _icon;
	} else {
		this.iconOpen = (_iconOpen!='')?_iconOpen:_icon;
	}
	
	if(typeof(_iconSelect)=='undefined'){
		this.iconSelect   = _icon;
	} else {
		this.iconSelect = (_iconOpen!='')?_iconOpen:_icon;	
	}
	
	if(this.isExpanded){
		this.icon 	= this.iconOpen;
	} else {
		this.icon 	= this.iconClose;	
	}
	
    if (this.parent) {
        if (this.parent.treeNodes.length>0) {
            this.parent.treeNodes[this.parent.treeNodes.length-1].isEnd = false;
        }
        this.parent.treeNodes[this.parent.treeNodes.length++] = this;
        this.boxObj = this.parent.boxObj;
        this.parent.noChild = false;
        this.level = this.parent.level+1;
    }
    
    /* ���� */
    /** ������ʾ */
    this.show = function() {
        var treeBoxObj = this.boxObj;
        
        /* ͼ�� */
        var tree_icon = (this.isExpanded) 
                        ? ( (this.isEnd) 
                            ? ( (this.treeNodes.length>0) 
                                ? treeBoxObj.treeIcons.minusEnd 
                                : treeBoxObj.treeIcons.lineEnd ) 
                            : ( (this.treeNodes.length>0) 
                                ? treeBoxObj.treeIcons.minusMiddle 
                                : treeBoxObj.treeIcons.lineMiddle) )
                        : ( (this.isEnd) 
                            ? treeBoxObj.treeIcons.plusEnd 
                            : treeBoxObj.treeIcons.plusMiddle );
        var line_icon = (this.isEnd) ? '' : treeBoxObj.treeIcons.line;
        
        /* �¼� */
        if (tree_icon==treeBoxObj.treeIcons.lineEnd 
                || tree_icon==treeBoxObj.treeIcons.lineMiddle) {
            var expand_event = '';
        } else {
            var expand_event = 'treeBoxList[\'' + treeBoxObj.id 
                    + '\'].nodes[\'' + this.id + '\'].expand()';
        }
        if (treeBoxObj.focusEvent) {
            var focus_event = 'node_change(this, document.getElementById(\'selected_id_' 
                    + treeBoxObj.id + '\'), ' + treeBoxObj.focusEvent 
                    + '(treeBoxList[\'' + treeBoxObj.id + '\'].selected,'
                    + 'treeBoxList[\'' + treeBoxObj.id + '\'].nodes[\'' 
                    + this.id + '\']))';
        } else {
            var focus_event = 'node_change(this, document.getElementById(\'selected_id_' 
                    + treeBoxObj.id + '\'), true)';
        }
        if (this.clickEvent) {
            click_event = this.clickEvent;
        } else if (treeBoxObj.clickEvent) {
            click_event = treeBoxObj.clickEvent + '(treeBoxList[\'' 
                    + treeBoxObj.id + '\'].nodes[\'' + this.id + '\'])';
        } else {
            click_event = '';
        }
        var html = '<tr height="18" style="cursor:default">';
        html += '<td id="tree_icon_' + this.id + '" nodeId="' + this.id 
                + '" onClick="' + expand_event
                + '" width="18" nowrap>';
        html += tree_icon;
        html += '</td>';
        html += '<td id="node_' + this.id + '" treeId="' + treeBoxObj.id 
                + '" nodeId="' + this.id + '" ' + this.custom 
                //+ ' onFocus="' + focus_event
                + ' onMouseDown="' + focus_event
                + '" onClick="' + click_event 
                + '" onDblClick="' + expand_event
                + '" title="' + this.description + '" nowrap><nobr>';
        html += '<input type="hidden" id="expand_' + this.id + '" value="' + ((this.isExpanded) ? 'yes' : '') 
                + '">';
//        html += '<input type="hidden" id="expand_' + this.id + '" name="expand_'
//                + this.id + '" value="' + ((this.isExpanded) ? 'yes' : '') 
//                + '">';
        if (this.icon) {
            html += '<img id="'+this.id+'_TreeIcon" width="16" height="16" src="' + this.icon 
                    + '" align="absmiddle">';
        }
        html += '&nbsp;' + this.caption;
        html += '</nobr></td>';
        html += '</tr>';
        if (this.isExpanded && this.treeNodes.length>0) {
            html += '<tr id="node_sub_tr_' + this.id + '">';
            html += '<td style="background-image:url(' + line_icon 
                    + ')" width="18" nowrap>';
            html += '</td>';
            html += '<td id="node_sub_td_' + this.id + '" nowrap>';
            html += '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
            for (var i=0; i<this.treeNodes.length; i++) {
                html += this.treeNodes[i].show();
            }
            html += '</table>';
            html += '</td>';
            html += '</tr>';
            this.isLoaded = true;
        } else {
            html += '<tr id="node_sub_tr_' + this.id 
                    + '" style="display:none">';
            html += '<td style="background-image:url(' + line_icon 
                    + ')" width="18" nowrap>';
            html += '</td>';
            html += '<td id="node_sub_td_' + this.id + '">';
            html += '</td>';
            html += '</tr>';
        }
        return html;
    }
    
    /** ����װ�� */
    this.reShow = function() {
        this.isLoaded = true;
        if (this.treeNodes.length) {
            var html = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
            for (var i=0; i<this.treeNodes.length; i++) {
                html += this.treeNodes[i].show();
            }
            html += '</table>';
            document.getElementById('node_sub_td_'+this.id).innerHTML = html;
        } else {
            var treeBoxObj = this.boxObj;
            var tree_icon = (this.isEnd) 
                    ? treeBoxObj.treeIcons.lineEnd 
                    : treeBoxObj.treeIcons.lineMiddle;
            document.getElementById('tree_icon_'+this.id).innerHTML = tree_icon;
        }
        return html;
    }
    
    /**
     * �����ӽڵ� 
     *
     * _id             �ڵ�ID
     * _caption        ����
     * _icon           ͼ��
     * _description    ����
     * _clickEvent     ����¼�
     * _isExpanded     �Ƿ���չ����
     * _custom         �Զ���
     */
    this.createNode = function(_id, _caption, _icon, _description, _clickEvent,
            _isExpanded, _custom, icon_open, icon_select) {        
				
		if (typeof(icon_open)=='undefined') {
			var icon_open = '';
		} 
		if (typeof(icon_select)=='undefined') {
			var icon_select = '';
		} 
		
		if (typeof(this.boxObj.nodes[_id])=='undefined') {
            this.boxObj.nodes[_id] = new TreeNode(this, _id, _caption, _icon, 
                    _description, _clickEvent, _isExpanded, _custom, icon_open, icon_select);
            return this.boxObj.nodes[_id];
        } else {
            return null;
        }
    }
    
    /** չ����رսڵ� */
    this.expand = function (flag) {
        if (typeof(flag)!='undefined') {
            var toExpand = (flag) ? true : false;
        } else {
            var toExpand = !this.isExpanded;
        }
        var eventFunction = (toExpand) ? this.boxObj.expandEvent 
                                       : this.boxObj.closeEvent;
        if (eventFunction) {
            var eventResult = eval(eventFunction + '(treeBoxList[\'' 
                    + this.boxObj.id + '\'].nodes[\'' + this.id + '\'])');
        } else {
            var eventResult = true;
        }
        if (toExpand == this.isExpanded || (this.isLoaded && this.noChild)) {
            return false;
        }
        if (eventResult) {
            var tr_obj = document.getElementById('node_sub_tr_' + this.id);
            var img_obj = document.getElementById('tree_icon_' + this.id);
            if (toExpand) {
                if (this.isLoaded) {
                    if (this.noChild!==true) {
                        img_obj.innerHTML = (this.isEnd) 
                                ? this.boxObj.treeIcons.minusEnd 
                                : this.boxObj.treeIcons.minusMiddle;
                    }
                    tr_obj.style.display = '';
                } else {
                    if (this.boxObj.loadEvent) {
                        eventResult = eval(this.boxObj.loadEvent 
                                + '(treeBoxList[\'' + this.boxObj.id 
                                + '\'].nodes[\'' + this.id + '\'])');
                    } else {
                        eventResult = true;
                    }
                    if (eventResult) {
                        this.isLoaded = true;
                        var html = '';
                        if (this.noChild) {
                            var node_obj = document.getElementById('node_' 
                                    + this.id);
                            img_obj.innerHTML = (this.isEnd) 
                                    ? this.boxObj.treeIcons.lineEnd 
                                    : this.boxObj.treeIcons.lineMiddle;
                            img_obj.onclick = null;
                            node_obj.ondblclick = null;
                        } else {
                            html += '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
                            for (var i=0; i<this.treeNodes.length; i++) {
                                html += this.treeNodes[i].show();
                            }
                            html += '</table>';
                            var td_obj = document.getElementById('node_sub_td_' 
                                    + this.id);
                            td_obj.innerHTML = html;
                            img_obj.innerHTML = (this.isEnd) 
                                    ? this.boxObj.treeIcons.minusEnd 
                                    : this.boxObj.treeIcons.minusMiddle;
                            tr_obj.style.display = '';
                        }
                    }
                }
                this.isExpanded = true;
            } else {
                if (this.noChild!==true) {
                    img_obj.innerHTML = (this.isEnd) 
                            ? this.boxObj.treeIcons.plusEnd 
                            : this.boxObj.treeIcons.plusMiddle;
                    }
                tr_obj.style.display = "none";
                this.isExpanded = false;
            }
            var expand_obj = document.getElementById("expand_" + this.id);
            if (expand_obj) {
                expand_obj.value = (this.isExpanded) ? "yes" : "";
            }
			
			if (this.icon) {
				if(this.isExpanded) {	//չ���ر�ͼ��
					document.getElementById(this.id+'_TreeIcon').src=this.iconOpen;
				}else{
					document.getElementById(this.id+'_TreeIcon').src=this.iconClose;
				}
			}
        }
    }
}

/**
 *  �ڵ㽹��ı�
 */
function node_change(obj, selected_id_obj, flag) {
    if (flag) {
        if (selected_id_obj.value) {
            var selected_obj = document.getElementById(selected_id_obj.value);
            if (selected_obj) {
                selected_obj.className = "";
            }
        }
        selected_id_obj.value = obj.id;
        obj.className = "itemSelected";
        var currentTree = treeBoxList[obj.getAttribute('treeId')];
        currentTree.selected = currentTree.nodes[obj.getAttribute('nodeId')];
    }
    //obj.blur();
}