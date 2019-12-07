var ajax = (function () {


function xhr() {
	if (window.XMLHttpRequest) {
    	// code for modern browsers
    	return xmlhttp = new XMLHttpRequest();
 	} else {
    	// code for old IE browsers
    	return xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	} 
}


function _send(xhr, method, url, data, headers) {
	return new Promise(function(resolve, reject) {
		let uri = "";
		if (!(data instanceof FormData)) {
			if (method == "GET" || method == "get") {
				uri = ((/\?/).test(url) ? "&" : "?") + encodeDataToUrl(data);
				data = null;
			} else {
				data = JSON.stringify (data);
			}
		} else {

		}
		
		xhr.open(method, url + uri, true);
		let contentType = false;
		if (headers) {
			for (var i in headers) {
				if (i == "Content-type")
					contentType = true;
				xhr.setRequestHeader (i, headers[i]);
			}	
		}
		if (!contentType) {
			xhr.setRequestHeader ("Content-Type", "charset:utf-8");
		}
		
		xhr.send(data);
		xhr.onreadystatechange = function() {
			if (this.readyState == 4) {
				if (this.status == 200 || this.status == 201) {
					resolve (this, this.responseText, this.status);
				} else {
					reject (this, this.responseText, this.status);
				}
			}
		};
	});
}

function encodeDataToUrl (data) {
	if (data instanceof Array) {
		return data
			.map ( (v, i) => `${i}=${encodeURIComponent(v)}`)
			.join ('&');
	} else {
		return Object
			.keys (data)
			.map ( (v) => `${v}=${encodeURIComponent(data[v])}`)
			.join ('&');
	}
}

return {
	send: function (url, method, object, headers) {
		return _send(xhr(), method, url, object, headers);
	},
	get: (url, object, headers) => { return ajax.send (url, 'get', object, headers) },
	post: (url, object, headers) => ajax.send (url, 'post', object, headers),
	put: (url, object, headers) => ajax.send (url, 'put', object, headers),
	_delete: (url, object, headers) => ajax.send (url, 'delete', object, headers),
	
}
})();
