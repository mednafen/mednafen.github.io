/***************************************************************************
* copyright            : (C) 2001-2006 Advanced Internet Designs Inc.
* email                : forum@prohost.org
* $Id$
*
* This program is free software; you can redistribute it and/or modify it 
* under the terms of the GNU General Public License as published by the 
* Free Software Foundation; version 2 of the License, or 
* (at your option) any later version.
***************************************************************************/

var JS_HELPOFF = false;
/* indentify the browser */
var DOM = (document.getElementById) ? 1 : 0;
var NS4 = (document.layers) ? 1 : 0;
var IE4 = (document.all) ? 1 : 0;
var OPERA = navigator.userAgent.indexOf("Opera") > -1 ? 1 : 0;
var MAC = navigator.userAgent.indexOf("Mac") > -1 ? 1 : 0;

/* edit box stuff */
function insertTag(obj, stag, etag)
{
	if (navigator.userAgent.indexOf("MSIE") > -1 && !OPERA) {
		insertTagIE(obj, stag, etag);
	} else {
		insertTagMoz(obj, stag, etag);
	}
	obj.focus();
}

function insertTagNS(obj, stag, etag)
{
	obj.value = obj.value+stag+etag;
}

function insertTagMoz(obj, stag, etag)
{
	var txt;

	if (window.getSelection) {
		txt = window.getSelection();
	} else if (document.getSelection) {
		txt = document.getSelection();
	}

	if (!txt || txt == '') {
		var t = document.getElementById('txtb');
		if (t.selectionStart == t.selectionEnd) {
			t.value = t.value.substring(0, t.selectionStart) + stag + etag +  t.value.substring(t.selectionEnd, t.value.length);
			return;
		}
		txt = t.value.substring(t.selectionStart, t.selectionEnd);
		if (txt) {
			t.value = t.value.substring(0, t.selectionStart) + stag + txt + etag +  t.value.substring(t.selectionEnd, t.value.length);
			return;
		}
	}
	obj.value = obj.value+stag+etag;
}

function insertTagIE(obj, stag, etag)
{
	var r = document.selection.createRange();
	if( document.selection.type == 'Text' && (obj.value.indexOf(r.text) != -1) ) {
		a = r.text;
		r.text = stag+r.text+etag;
		if ( obj.value.indexOf(document.selection.createRange().text) == -1 ) {
			document.selection.createRange().text = a;
		}
	}
	else insertAtCaret(obj, stag+etag);	
}

function dialogTag(obj, qst, def, stag, etag)
{
	var q = prompt(qst, def);
	if ( !q ) return;
	stag = stag.replace(/%s/i, q);
	insertTag(obj, stag, etag);
}

function url_insert()
{
	if ( check_selection() )
		dialogTag(document.post_form.msg_body, 'Location:', 'http://', '[url=%s]', '[/url]');
	else
		dialogTag(document.post_form.msg_body, 'Location:', 'http://', '[url]%s[/url]', '');
}

function check_selection()
{
	var rn;
	var sel;
	var r;

	if (window.getSelection && window.getSelection()) {
		return 1;
	}

	if ( document.layers ) return 0;
	if ( navigator.userAgent.indexOf("MSIE") < 0 ) return 0;

	r = document.selection.createRange();

	if ( r.text.length && (document.post_form.msg_body.value.indexOf(r.text) != -1) ) {
		a = document.selection.createRange().text;
		rn = Math.random();
		r.text = r.text + ' ' + rn;
		
		if ( document.post_form.msg_body.value.indexOf(rn) != -1 ) {
			sel = 1;
		} else {
			sel = 0;
		}
		
		document.selection.createRange().text = a;
	}
	
	return sel;
}

function storeCaret(textEl)
{
	 if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}

function insertAtCaret(textEl, text)
{
	if (textEl.createTextRange && textEl.caretPos)
	{
		var caretPos = textEl.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
	}
	else 
		textEl.value  =  textEl.value + text;
}

function email_insert()
{
	if ( check_selection() ) {
		dialogTag(document.post_form.msg_body, 'Email:', '', '[url=mailto:%s]', '[/url]');
	}	
	else
		dialogTag(document.post_form.msg_body, 'Email:', '', '[email]%s[/email]', '');
}

function image_insert()
{
	dialogTag(document.post_form.msg_body, 'Image URL:', 'http://', '[img]%s[/img]', '');
}

function window_open(url,winName,width,height)
{
	xpos = (screen.width-width)/2;
	ypos = (screen.height-height)/2;
	options = "scrollbars=1,width="+width+",height="+height+",left="+xpos+",top="+ypos+"position:absolute";
	window.open(url,winName,options);
}

function layerVis(layer, on)
{
	thisDiv = document.getElementById(layer);
	if (thisDiv) {
		if (thisDiv.style.display == "none") {
			thisDiv.style.display = "block";
		} else {
			thisDiv.style.display = "none";
		}
	}
}

function fud_msg_focus(mid_hash)
{
	if (!window.location.hash) {
		self.location.replace(window.location+"#"+mid_hash);
	}
}

function chng_focus(phash)
{
	window.location.hash = phash;
}

function highlightWord(node,word,Wno)
{
	// Iterate into this nodes childNodes
	if (node.hasChildNodes) {
		for (var i = 0; node.childNodes[i]; i++) {
			highlightWord(node.childNodes[i], word, Wno);
		}
	}

	// And do this node itself
	if (node.nodeType == 3) { // text node
		var tempNodeVal = node.nodeValue.toLowerCase();
		var pn = node.parentNode;
		var nv = node.nodeValue;

		if ((ni = tempNodeVal.indexOf(word)) == -1 || pn.className.indexOf('st') != -1) return;

		// Create a load of replacement nodes
		before = document.createTextNode(nv.substr(0,ni));
		after = document.createTextNode(nv.substr(ni+word.length));
		if (document.all) {
			hiword = document.createElement('<span class="st'+Wno+'"></span>');
		} else {
			hiword = document.createElement("span");
			hiword.setAttribute('class', 'st'+Wno);
		}
		hiword.appendChild(document.createTextNode(word));
		pn.insertBefore(before,node);
		pn.insertBefore(hiword,node);
		pn.insertBefore(after,node);
		pn.removeChild(node);
	}
}

function highlightSearchTerms(searchText)
{
	searchText = searchText.toLowerCase()
	var terms = searchText.split(" ");
	var e = document.getElementsByTagName('span'); // message body

	for (var i = 0; e[i]; i++) {
		if (e[i].className != 'MsgBodyText') continue;
		for (var j = 0, k = 0; j < terms.length; j++, k++) {
			if (k > 9) k = 0; // we only have 9 colors
			highlightWord(e[i], terms[j], k);
		}
	}

	e = document.getElementsByTagName('td'); // subject
	for (var i = 0; e[i]; i++) {
		if (e[i].className.indexOf('MsgSubText') == -1) continue;
		for (var j = 0, k = 0; j < terms.length; j++, k++) {
			if (k > 9) k = 0; // we only have 9 colors
			highlightWord(e[i], terms[j], k);
		}
	}
}

function rs_txt_box(name, col_inc, row_inc)
{
        if (IE4) {  
                var obj = document.all[name];
        } else {
                var obj = document.getElementById(name);
        }                                   

        obj.rows += row_inc;           
        obj.cols += col_inc;            
}

function topicVote(rating, topic_id, ses, sq)
{
	var responseFailure = function(o) { alert('XMLHTTPRequest Failure: ' + o.statusText + ' ' + o.allResponseHeaders + ' ' + o.status); }
	var rateTopic = function(o) { 
		if (o.responseText) {
			document.getElementById('threadRating').innerHTML = o.responseText;
			var p = document.getElementById('RateFrm').parentNode;
			p.removeChild(document.getElementById('RateFrm'));
		}
	}

	var callback = 
	{
		success:rateTopic,
		failure:responseFailure
	}

	YAHOO.util.Connect.asyncRequest('GET','index.php?t=ratethread&sel_vote='+rating+'&rate_thread_id='+topic_id+'&S='+ses+'&SQ='+sq,callback);
}

/*                                                                                                                                                      
Copyright (c) 2006, Yahoo! Inc. All rights reserved.                                                                                                    
Code licensed under the BSD License:                                                                                                                    
http://developer.yahoo.net/yui/license.txt                                                                                                              
version: 0.10.0                                                                                                                                         
*/ 

/* Copyright (c) 2006 Yahoo! Inc. All rights reserved. */

var YAHOO = window.YAHOO || {};

YAHOO.namespace = function( sNameSpace ) {

    if (!sNameSpace || !sNameSpace.length) {
        return null;
    }

    var levels = sNameSpace.split(".");

    var currentNS = YAHOO;

    for (var i=(levels[0] == "YAHOO") ? 1 : 0; i<levels.length; ++i) {
        currentNS[levels[i]] = currentNS[levels[i]] || {};
        currentNS = currentNS[levels[i]];
    }

    return currentNS;
};

YAHOO.log = function(sMsg,sCategory) {
    if(YAHOO.widget.Logger) {
        YAHOO.widget.Logger.log(null, sMsg, sCategory);
    } else {
        return false;
    }
};

YAHOO.namespace("util");
YAHOO.namespace("widget");
YAHOO.namespace("example");

/*
Copyright (c) 2006, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.net/yui/license.txt
*/

YAHOO.util.Connect =
{
	_msxml_progid:[
		'MSXML2.XMLHTTP.5.0',
		'MSXML2.XMLHTTP.4.0',
		'MSXML2.XMLHTTP.3.0',
		'MSXML2.XMLHTTP',
		'Microsoft.XMLHTTP'
		],

	_http_header:{},

	_has_http_headers:false,

	_isFormSubmit:false,

	_sFormData:null,

	_poll:[],

	_polling_interval:50,

	_transaction_id:0,

	setProgId:function(id)
	{
		this.msxml_progid.unshift(id);
	},

	setPollingInterval:function(i)
	{
		if(typeof i == 'number' && isFinite(i)){
			this._polling_interval = i;
		}
	},

	createXhrObject:function(transactionId)
	{
		var obj,http;
		try
		{
			http = new XMLHttpRequest();
			obj = { conn:http, tId:transactionId };
		}
		catch(e)
		{
			for(var i=0; i<this._msxml_progid.length; ++i){
				try
				{
					http = new ActiveXObject(this._msxml_progid[i]);
					if(http){
						obj = { conn:http, tId:transactionId };
						break;
					}
				}
				catch(e){}
			}
		}
		finally
		{
			return obj;
		}
	},

	getConnectionObject:function()
	{
		var o;
		var tId = this._transaction_id;

		try
		{
			o = this.createXhrObject(tId);
			if(o){
				this._transaction_id++;
			}
		}
		catch(e){}
		finally
		{
			return o;
		}
	},

	asyncRequest:function(method, uri, callback, postData)
	{
		var o = this.getConnectionObject();

		if(!o){
			return null;
		}
		else{
			if(this._isFormSubmit){
				if(method == 'GET'){
					uri += "?" +  this._sFormData;
				}
				else if(method == 'POST'){
					postData =  this._sFormData;
				}
				this._sFormData = '';
				this._isFormSubmit = false;
			}

			o.conn.open(method, uri, true);

			if(postData){
				this.initHeader('Content-Type','application/x-www-form-urlencoded');
			}

			if(this._has_http_headers){
				this.setHeader(o);
			}

			this.handleReadyState(o, callback);
			postData?o.conn.send(postData):o.conn.send(null);

			return o;
		}
	},

	handleReadyState:function(o, callback)
	{
		var oConn = this;
		try
		{
			this._poll[o.tId] = window.setInterval(
				function(){
					if(o.conn && o.conn.readyState == 4){
						window.clearInterval(oConn._poll[o.tId]);
						oConn._poll.splice(o.tId);
						oConn.handleTransactionResponse(o, callback);
					}
				}
			,this._polling_interval);
		}
		catch(e)
		{
			window.clearInterval(oConn._poll[o.tId]);
			oConn._poll.splice(o.tId);
			oConn.handleTransactionResponse(o, callback);
		}
	},

	handleTransactionResponse:function(o, callback)
	{
		if(!callback){
			this.releaseObject(o);
			return;
		}

		var httpStatus;
		var responseObject;

		try
		{
			httpStatus = o.conn.status;
		}
		catch(e){
			httpStatus = 13030;
		}

		if(httpStatus >= 200 && httpStatus < 300){
			responseObject = this.createResponseObject(o, callback.argument);
			if(callback.success){
				if(!callback.scope){
					callback.success(responseObject);
				}
				else{
					callback.success.apply(callback.scope, [responseObject]);
				}
			}
		}
		else{
			switch(httpStatus){
				case 12002:
				case 12029:
				case 12030:
				case 12031:
				case 12152:
				case 13030:
					responseObject = this.createExceptionObject(o, callback.argument);
					if(callback.failure){
						if(!callback.scope){
							callback.failure(responseObject);
						}
						else{
							callback.failure.apply(callback.scope,[responseObject]);
						}
					}
					break;
				default:
					responseObject = this.createResponseObject(o, callback.argument);
					if(callback.failure){
						if(!callback.scope){
							callback.failure(responseObject);
						}
						else{
							callback.failure.apply(callback.scope,[responseObject]);
						}
					}
			}
		}

		this.releaseObject(o);
	},

	createResponseObject:function(o, callbackArg)
	{
		var obj = {};
		var headerObj = {};

		try
		{
			var headerStr = o.conn.getAllResponseHeaders();
			var header = headerStr.split("\n");
			for(var i=0; i < header.length; i++){
				var delimitPos = header[i].indexOf(':');
				if(delimitPos != -1){
					headerObj[header[i].substring(0,delimitPos)] = header[i].substring(delimitPos+1);
				}
			}

			obj.tId = o.tId;
			obj.status = o.conn.status;
			obj.statusText = o.conn.statusText;
			obj.getResponseHeader = headerObj;
			obj.getAllResponseHeaders = headerStr;
			obj.responseText = o.conn.responseText;
			obj.responseXML = o.conn.responseXML;
			if(typeof callbackArg !== undefined){
				obj.argument = callbackArg;
			}
		}
		catch(e){}
		finally
		{
			return obj;
		}
	},

	createExceptionObject:function(tId, callbackArg)
	{
		var COMM_CODE = 0;
		var COMM_ERROR = 'communication failure';

		var obj = {};

		obj.tId = tId;
		obj.status = COMM_CODE;
		obj.statusText = COMM_ERROR;
		if(callbackArg){
			obj.argument = callbackArg;
		}

		return obj;
	},

	initHeader:function(label,value)
	{
		if(this._http_header[label] === undefined){
			this._http_header[label] = value;
		}
		else{
			this._http_header[label] =  value + "," + this._http_header[label];
		}

		this._has_http_headers = true;
	},

	setHeader:function(o)
	{
		for(var prop in this._http_header){
			o.conn.setRequestHeader(prop, this._http_header[prop]);
		}
		delete this._http_header;

		this._http_header = {};
		this._has_http_headers = false;
	},

	setForm:function(formId)
	{
		this._sFormData = '';
		if(typeof formId == 'string'){
			var oForm = (document.getElementById(formId) || document.forms[formId] );
		}
		else if(typeof formId == 'object'){
			var oForm = formId;
		}
		else{
			return;
		}
		var oElement, oName, oValue, oDisabled;
		var hasSubmit = false;

		for (var i=0; i<oForm.elements.length; i++){
			oDisabled = oForm.elements[i].disabled;
			if(oForm.elements[i].name != ""){
				oElement = oForm.elements[i];
				oName = oForm.elements[i].name;
				oValue = oForm.elements[i].value;
			}

			if(!oDisabled)
			{
				switch (oElement.type)
				{
					case 'select-one':
					case 'select-multiple':
						for(var j=0; j<oElement.options.length; j++){
							if(oElement.options[j].selected){
								this._sFormData += encodeURIComponent(oName) + '=' + encodeURIComponent(oElement.options[j].value || oElement.options[j].text) + '&';
							}
						}
						break;
					case 'radio':
					case 'checkbox':
						if(oElement.checked){
							this._sFormData += encodeURIComponent(oName) + '=' + encodeURIComponent(oValue) + '&';
						}
						break;
					case 'file':
					case undefined:
					case 'reset':
					case 'button':
						break;
					case 'submit':
						if(hasSubmit == false){
							this._sFormData += encodeURIComponent(oName) + '=' + encodeURIComponent(oValue) + '&';
							hasSubmit = true;
						}
						break;
					default:
						this._sFormData += encodeURIComponent(oName) + '=' + encodeURIComponent(oValue) + '&';
						break;
				}
			}
		}

		this._isFormSubmit = true;
		this._sFormData = this._sFormData.substr(0, this._sFormData.length - 1);
	},

	abort:function(o)
	{
		if(this.isCallInProgress(o)){
			window.clearInterval(this._poll[o.tId]);
			this._poll.splice(o.tId);
			o.conn.abort();
			this.releaseObject(o);

			return true;
		}
		else{
			return false;
		}
	},

	isCallInProgress:function(o)
	{
		if(o.conn){
			return o.conn.readyState != 4 && o.conn.readyState != 0;
		}
		else{
			return false;
		}
	},

	releaseObject:function(o)
	{
		o.conn = null;
		o = null;
	}
};
