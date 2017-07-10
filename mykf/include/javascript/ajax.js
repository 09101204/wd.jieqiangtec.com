/******************************************************************************
  Crossday Eqmk.com! Board - Ajax for Eqmk!
  Copyright 2001-2006 Comsenz Inc. (http://www.comsenz.com)
*******************************************************************************/
var xml_http_building_link = '请等待，正在建立连接...';
var xml_http_sending = '请等待，正在发送数据...';
var xml_http_loading = '请等待，正在接受数据...';
var xml_http_load_failed = '通信失败，请刷新重新尝试';
var xml_http_data_in_processed = '请等待，数据正在处理中...';

function Ajax(recvType,statusId) {
	var aj = new Object();
	aj.statusId = statusId ? document.getElementById(statusId) : null;
	aj.targetUrl = '';
	aj.sendString = '';
	aj.recvType = recvType ? recvType : 'HTML';//HTML XML
	aj.resultHandle = null;

	aj.createXMLHttpRequest = function() {
		var request = false;
		if(window.XMLHttpRequest) {
			request = new XMLHttpRequest();
			if(request.overrideMimeType) {
				request.overrideMimeType('text/xml');
			}
		}else if(window.ActiveXObject) {
			var versions = ['Microsoft.XMLHTTP', 'MSXML.XMLHTTP', 'Microsoft.XMLHTTP', 'Msxml2.XMLHTTP.7.0', 'Msxml2.XMLHTTP.6.0', 'Msxml2.XMLHTTP.5.0', 'Msxml2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP'];
			for(var i=0; i<versions.length; i++) {
				try {
					request = new ActiveXObject(versions[i]);
					if(request) {
						return request;
					}
				} catch(e) {
					//alert(e.message);
				}
			}
		}
		return request;
	}

	aj.XMLHttpRequest = aj.createXMLHttpRequest();

	aj.processHandle = function() {
    if(aj.statusId){
      aj.statusId.style.display = '';
		}
		if(aj.XMLHttpRequest.readyState == 1) {
			if(aj.statusId)aj.statusId.innerHTML = xml_http_building_link;
		} else if(aj.XMLHttpRequest.readyState == 2) {
			if(aj.statusId)aj.statusId.innerHTML = xml_http_sending;
		} else if(aj.XMLHttpRequest.readyState == 3) {
			if(aj.statusId)aj.statusId.innerHTML = xml_http_loading;
		} else if(aj.XMLHttpRequest.readyState == 4) {
			if(aj.XMLHttpRequest.status == 200) {
				if(aj.statusId)aj.statusId.innerHTML = xml_http_data_in_processed;
				if(aj.recvType == 'HTML') {
					aj.resultHandle(aj.XMLHttpRequest.responseText);
				} else if(aj.recvType == 'XML') {
					aj.resultHandle(aj.XMLHttpRequest.responseXML);
				}
        if(aj.statusId){
          aj.statusId.style.display = 'none';
				}
			} else {
				if(aj.statusId)aj.statusId.innerHTML = xml_http_load_failed;
			}
		}
	}

	aj.get = function(targetUrl, resultHandle) {
		aj.targetUrl = targetUrl.indexOf("?") ? targetUrl+"&rand="+Math.random() :targetUrl+"?rand="+Math.random();
		aj.XMLHttpRequest.onreadystatechange = aj.processHandle;
		aj.resultHandle = resultHandle;
		if(window.XMLHttpRequest) {
			aj.XMLHttpRequest.open('GET', aj.targetUrl);
			aj.XMLHttpRequest.send(null);
		} else {
		        aj.XMLHttpRequest.open("GET", targetUrl, true);
		        aj.XMLHttpRequest.send();
		}
	}

	aj.post = function(targetUrl, sendString, resultHandle) {
		aj.targetUrl = targetUrl.indexOf("?") ? targetUrl+"&rand="+Math.random() :targetUrl+"?rand="+Math.random();
		aj.sendString = sendString;
		aj.XMLHttpRequest.onreadystatechange = aj.processHandle;
		aj.resultHandle = resultHandle;
		aj.XMLHttpRequest.open('POST', targetUrl);
		aj.XMLHttpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;charset=UTF-8');
		aj.XMLHttpRequest.send(aj.sendString);
	}
	return aj;
}