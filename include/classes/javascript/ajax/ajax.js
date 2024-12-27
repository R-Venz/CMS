
//========================================================================================================================================================================================================================================================
  var AJAX = function(){
 
 AJAX.prototype.httpRequest = function ()
					{ var xmlHttp=null;  
						try{  xmlHttp = new XMLHttpRequest();                                    // Firefox, Opera 8.0+, Safari 
							}catch(e){
											try{ xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");    // Internet Explorer
											}catch(e){ xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");}
											}
					return xmlHttp; }

//========================================================================================================================================================================================================================================================	
  
   AJAX.prototype.replaceAll = function(strSource, str1, str2, ignore) 
         {    return strSource.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
          } 
//========================================================================================================================================================================================================================================================
  
   AJAX.prototype.stripeChar = function(str)
	           { str = this.replaceAll(str,"'","`");
			     str = this.replaceAll(str,'"',"`");
			     str = str.replace(/[\'\|\"\^\\\/\#\$\%\*\=\!]/g,'');
				 str = str.replace(/^\s+|\s+$/g,'');
				 return str;}
				 
//========================================================================================================================================================================================================================================================
  AJAX.prototype.isJsonFormat = function(str)
	           {try {JSON.parse(str);}
			    catch (e) { return false; }
                return true; }
				 
//========================================================================================================================================================================================================================================================

 
//========================================================================================================================================================================================================================================================
AJAX.prototype.progressBar = function(status, caption='Please wait...'){ 
		if (status=='open') {
			document.querySelector('#dataLoader').style.display = "block";
			document.querySelector('#loaderCaption').innerHTML = caption;
		}else{
			document.querySelector('#dataLoader').style.display = "none";
			document.querySelector('#loaderCaption').innerHTML = "";
		}
	}
 }
// STRINGS ====================================================================================
// KEY validation - Numbers
function validate(evt) {
	var theEvent = evt || window.event;

	// Handle paste
	if (theEvent.type === 'paste') {
	    key = event.clipboardData.getData('text/plain');
	} else {
	// Handle key press
	    var key = theEvent.keyCode || theEvent.which;
	    key = String.fromCharCode(key);
	}
	var regex = /[0-9]|\./;
	if( !regex.test(key) ) {
	  theEvent.returnValue = false;
	  if(theEvent.preventDefault) theEvent.preventDefault();
	}
}
// decoder from base64
function decodestr(str) {
 	return decodeURIComponent(escape(window.atob(str)));
}

$.fn.modal.Constructor.prototype._enforceFocus = function() {};