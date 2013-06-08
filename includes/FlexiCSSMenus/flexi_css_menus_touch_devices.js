var xtd;
if (!xtd) xtd = {};

xtd.flexiCSSMenus_uagent = navigator.userAgent.toLowerCase();
xtd.flexiCSSMenus_smartphones = ["android", "blackberry", "iphone", "ipad", "series60", "symbian", "windows ce", "palm"];

xtd.addLoadEvent = function(str) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = function() {
		eval(str);
	}
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      eval(str);
    }
  }
}

xtd.flexiCSSMenus_isTouchDevice = function () {
	//return true; // for testing
	
	for(var i=0;i<xtd.flexiCSSMenus_smartphones.length;i++) { 
		if(xtd.flexiCSSMenus_uagent.indexOf(xtd.flexiCSSMenus_smartphones[i]) > -1) 
			return true;
	}
	
	return false;
}

xtd.flexiCSSMenus_addTouchDeviceBehavior = function() {
	var divs = document.getElementsByTagName("DIV");
	var menu, comment, start, end, type, props;
	
	for (var i=0;i<divs.length;i++) {
		if (divs[i].className && divs[i].className.indexOf("FM_CSS_") != -1 && divs[i].className.indexOf('_container') != -1) {
			menu = divs[i];
			
			start = menu.innerHTML.indexOf("<!--") + 4;
			end = menu.innerHTML.indexOf("-->");
			comment = menu.innerHTML.substring(start, end);
			props = comment.split(';');
			type = props[props.length - 2].replace('type=', '');

			xtd.flexiCSSMenus_addTouchDeviceBehaviorForElement(menu, type);
		}
	}
}

xtd.flexiCSSMenus_addTouchDeviceBehaviorForElement = function(elem, type) {
	var children = elem.childNodes;
	
	for (var i=0;i<children.length;i++) {
		if (children[i].tagName && children[i].tagName.toLowerCase() == "li") {
			children[i].addEventListener("click", xtd.flexiCSSMenus_clickHandlerForTouchDevices, false);
		}
		
		xtd.flexiCSSMenus_addTouchDeviceBehaviorForElement(children[i], type);
	}
}

if (xtd.flexiCSSMenus_isTouchDevice()) {
	var str = "xtd.flexiCSSMenus_addTouchDeviceBehavior();";
	xtd.addLoadEvent(str);
}


xtd.flexiCSSMenus_currentButton = null;
xtd.flexiCSSMenus_currentLevel = -1;

xtd.flexiCSSMenus_clickHandlerForTouchDevices = function(event) {
	var type = xtd.flexiCSSMenus_getMenuType(xtd.flexiCSSMenus_getButtonMenu(this));
	var submenu = this.getElementsByTagName("UL")[0];
	
	if(event.stopPropagation) event.stopPropagation();

	if(xtd.flexiCSSMenus_currentButton && (xtd.flexiCSSMenus_currentButton == this) || !submenu) { 
		return;
	} else { 
		event.preventDefault();
	}
	
 	try { 
		var node, level = xtd.flexiCSSMenus_getButtonLevel(this);
	} catch(e) { 
		alert('error 2');
	}

	//alert(level + " .. " + xtd.flexiCSSMenus_currentButton);
	if(level > xtd.flexiCSSMenus_currentLevel) { 
		xtd.flexiCSSMenus_currentButton = this;

		if(level > 0) { 
			node = xtd.flexiCSSMenus_currentButton.parentNode;	
			while(level > xtd.flexiCSSMenus_currentLevel && node.className.toLowerCase().indexOf('fm') < 0) { 
				if(node.tagName && node.tagName.toLowerCase() == "li") {
					xtd.flexiCSSMenus_selectButton(node, type);
					xtd.flexiCSSMenus_currentLevel--; 
				}
				node = node.parentNode;		
			}
		}		
		xtd.flexiCSSMenus_selectButton(xtd.flexiCSSMenus_currentButton, type);				
		xtd.flexiCSSMenus_currentLevel = level;
	} 

	if(level == xtd.flexiCSSMenus_currentLevel) { 
		try { 
			xtd.flexiCSSMenus_deselectButton(xtd.flexiCSSMenus_currentButton);
			xtd.flexiCSSMenus_currentButton = this;
			xtd.flexiCSSMenus_currentLevel = level;
			xtd.flexiCSSMenus_selectButton(xtd.flexiCSSMenus_currentButton, type);
		} catch(e) { 
			alert('error 3');
		}
	}
	
	if(level < xtd.flexiCSSMenus_currentLevel) { 
		xtd.flexiCSSMenus_deselectButton(xtd.flexiCSSMenus_currentButton);
		while(level < xtd.flexiCSSMenus_currentLevel) { 
			xtd.flexiCSSMenus_currentButton = xtd.flexiCSSMenus_currentButton.parentNode;
			if(xtd.flexiCSSMenus_currentButton.tagName && xtd.flexiCSSMenus_currentButton.tagName.toLowerCase() == "li") {
				xtd.flexiCSSMenus_deselectButton(xtd.flexiCSSMenus_currentButton, type);
				xtd.flexiCSSMenus_currentLevel--;
			}
		}
		xtd.flexiCSSMenus_currentButton = this;
		xtd.flexiCSSMenus_currentLevel = level;
		xtd.flexiCSSMenus_selectButton(xtd.flexiCSSMenus_currentButton, type);
	}
}

xtd.flexiCSSMenus_deselectButton = function(button) {
	try { 
		if(button) {  
			button.getElementsByTagName('a')[0].className = "";
			var submenu = button.getElementsByTagName('ul');
			if(submenu.length > 0) { 
				submenu[0].style.display = "none";
			}
			
			var lis = submenu[0].getElementsByTagName('li');
			for(var i = 0; i < lis.length; i++) { 
				lis[i].style.position = "static";
			}
		}
	} catch(e) { 
	
	}
}

xtd.flexiCSSMenus_selectButton = function(button, type) { 
	button.getElementsByTagName('a')[0].className += " sel"; 
	
	var isTabbed = (type == "tabbed");
	if(isTabbed) { 
		button.style.position = "static";
	} else { 
		button.style.position = "relative";
	}
	
	try { 
		var submenu = button.getElementsByTagName('ul');
		submenu[0].style.zIndex = 1;
		if(submenu.length > 0) { 
			submenu[0].style.display = "block";	
		
			var lis = submenu[0].getElementsByTagName('li');
			for(var i = 0; i < lis.length; i++) { 
				lis[i].style.position = "relative";
			}
			
/*			var subsub = submenu[0].getElementsByTagName('ul')[0]
			if (subsub) {
				lis = subsub.getElementsByTagName('li');
				for(var i = 0; i < lis.length; i++) { 
					lis[i].style.position = "relative";
				}
			}
*/
		}
	} catch(e) { 
		alert('error 1');
	}
}


xtd.flexiCSSMenus_getButtonLevel = function(selectedNode) {
	try {
		var upULSNo = 0;
		
		//log("##getSelectedLevel##" + selectedNode.parentNode);
		while (selectedNode && selectedNode.className.toLowerCase().indexOf("fm") < 0) {
			//log("##selectedNode.parentNode.nodeName.toLowerCase()##" + selectedNode.parentNode.nodeName.toLowerCase());
			if (selectedNode.tagName && selectedNode.tagName.toLowerCase() == "ul") {
				upULSNo++;
			}
			selectedNode = selectedNode.parentNode;
		}
	} catch (e) {
		alert("Error in getSelectedLevel ##" + e);
	}
	return upULSNo;
}

xtd.flexiCSSMenus_getButtonMenu = function(selectedNode) {
	try {
		var upULSNo = 0;
		
		//log("##getSelectedLevel##" + selectedNode.parentNode);
		while (selectedNode && (selectedNode.className.toLowerCase().indexOf("fm_css_") == -1 || selectedNode.className.toLowerCase().indexOf("_container") == -1) ) {
			//log("##selectedNode.parentNode.nodeName.toLowerCase()##" + selectedNode.parentNode.nodeName.toLowerCase());
			selectedNode = selectedNode.parentNode;
		}
	} catch (e) {
		alert("Error in getButtonMenu ##" + e);
	}
	return selectedNode;
}

xtd.flexiCSSMenus_getMenuType = function(menuNode) {
	var menu, comment, start, end, type, props;
	menu = menuNode;
	
	start = menu.innerHTML.indexOf("<!--") + 4;
	end = menu.innerHTML.indexOf("-->");
	comment = menu.innerHTML.substring(start, end);
	props = comment.split(';');
	type = props[props.length - 2].replace('type=', '');
	
	return type;
}
