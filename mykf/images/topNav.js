var ua = navigator.userAgent;
var opera = /opera [56789]|opera\/[56789]/i.test(ua);
var webkit = /webkit/i.test(ua);
var ie = !opera && /MSIE/.test(ua);
var ie50 = ie && /MSIE 5\.[01234]/.test(ua);
var ie6 = ie && /MSIE [6789]/.test(ua);
var ie7 = ie && /MSIE [789]/.test(ua);
var ieBox = ie && (document.compatMode == null || document.compatMode != "CSS1Compat");
var moz = !opera && !webkit && /gecko/i.test(ua);
var nn6 = !opera && /netscape.*6\./i.test(ua);

// define the default values
webfxMenuDefaultWidth			= 88;

webfxMenuDefaultBorderLeft		= 0;
webfxMenuDefaultBorderRight		= 0;
webfxMenuDefaultBorderTop		= 0;
webfxMenuDefaultBorderBottom	= 0;
webfxMenuDefaultPaddingLeft		= 0;
webfxMenuDefaultPaddingRight	= 0;
webfxMenuDefaultPaddingTop		= 0;
webfxMenuDefaultPaddingBottom	= 0;

webfxMenuDefaultShadowLeft		= 0;
webfxMenuDefaultShadowRight		= ie && !ie50 && /win32/i.test(navigator.platform) ? 4 :0;
webfxMenuDefaultShadowTop		= 0;
webfxMenuDefaultShadowBottom	= ie && !ie50 && /win32/i.test(navigator.platform) ? 4 : 0;

webfxMenuItemDefaultHeight		= 18;
webfxMenuItemDefaultText		= "Untitled";
webfxMenuItemDefaultHref		= "javascript:void(0)";

webfxMenuSeparatorDefaultHeight	= 6;

webfxMenuDefaultEmptyText		= "Empty";

webfxMenuDefaultUseAutoPosition	= nn6 ? false : true;

// other global constants
webfxMenuImagePath				= "";

webfxMenuUseHover				= opera || webkit ? true : false;
webfxMenuHideTime				= 500;
webfxMenuShowTime				= 200;

var webFXMenuHandler = {
	idCounter		:	0,
	idPrefix		:	"webfx-menu-object-",
	all				:	{},
	getId			:	function () { return this.idPrefix + this.idCounter++; },
	overMenuItem	:	function (oItem) {
		if (this.showTimeout != null)
			window.clearTimeout(this.showTimeout);
		if (this.hideTimeout != null)
			window.clearTimeout(this.hideTimeout);
		var jsItem = this.all[oItem.id];
		if (webfxMenuShowTime <= 0)
			this._over(jsItem);
		else
			//this.showTimeout = window.setTimeout(function () { webFXMenuHandler._over(jsItem) ; }, webfxMenuShowTime);
			// I hate IE5.0 because the piece of shit crashes when using setTimeout with a function object
			this.showTimeout = window.setTimeout("webFXMenuHandler._over(webFXMenuHandler.all['" + jsItem.id + "'])", webfxMenuShowTime);
	},
	outMenuItem	:	function (oItem) {
		if (this.showTimeout != null)
			window.clearTimeout(this.showTimeout);
		if (this.hideTimeout != null)
			window.clearTimeout(this.hideTimeout);
		var jsItem = this.all[oItem.id];
		if (webfxMenuHideTime <= 0)
			this._out(jsItem);
		else
			//this.hideTimeout = window.setTimeout(function () { webFXMenuHandler._out(jsItem) ; }, webfxMenuHideTime);
			this.hideTimeout = window.setTimeout("webFXMenuHandler._out(webFXMenuHandler.all['" + jsItem.id + "'])", webfxMenuHideTime);
	},
	blurMenu		:	function (oMenuItem) {
		window.setTimeout("webFXMenuHandler.all[\"" + oMenuItem.id + "\"].subMenu.hide();", webfxMenuHideTime);
	},
	_over	:	function (jsItem) {
		if (jsItem.subMenu) {
			jsItem.parentMenu.hideAllSubs();
			jsItem.subMenu.show();
		}
		else
			jsItem.parentMenu.hideAllSubs();
	},
	_out	:	function (jsItem) {
		// find top most menu
		var root = jsItem;
		var m;
		if (root instanceof WebFXMenuButton)
			m = root.subMenu;
		else {
			m = jsItem.parentMenu;
			while (m.parentMenu != null && !(m.parentMenu instanceof WebFXMenuBar))
				m = m.parentMenu;
		}
		if (m != null)
			m.hide();
	},
	hideMenu	:	function (menu) {
		if (this.showTimeout != null)
			window.clearTimeout(this.showTimeout);
		if (this.hideTimeout != null)
			window.clearTimeout(this.hideTimeout);

		this.hideTimeout = window.setTimeout("webFXMenuHandler.all['" + menu.id + "'].hide()", webfxMenuHideTime);
	},
	showMenu	:	function (menu, src, dir) {
		if (this.showTimeout != null)
			window.clearTimeout(this.showTimeout);
		if (this.hideTimeout != null)
			window.clearTimeout(this.hideTimeout);
		if (arguments.length < 3)
			dir = "vertical";

		menu.show(src, dir);
	}
};

function WebFXMenu() {
	this._menuItems	= [];
	this._subMenus	= [];
	this.id			= webFXMenuHandler.getId();
	this.top		= 0;
	this.left		= 0;
	this.shown		= false;
	this.parentMenu	= null;
	webFXMenuHandler.all[this.id] = this;
}

WebFXMenu.prototype.width			= webfxMenuDefaultWidth;
WebFXMenu.prototype.emptyText		= webfxMenuDefaultEmptyText;
WebFXMenu.prototype.useAutoPosition	= webfxMenuDefaultUseAutoPosition;

WebFXMenu.prototype.borderLeft		= webfxMenuDefaultBorderLeft;
WebFXMenu.prototype.borderRight		= webfxMenuDefaultBorderRight;
WebFXMenu.prototype.borderTop		= webfxMenuDefaultBorderTop;
WebFXMenu.prototype.borderBottom	= webfxMenuDefaultBorderBottom;

WebFXMenu.prototype.paddingLeft		= webfxMenuDefaultPaddingLeft;
WebFXMenu.prototype.paddingRight	= webfxMenuDefaultPaddingRight;
WebFXMenu.prototype.paddingTop		= webfxMenuDefaultPaddingTop;
WebFXMenu.prototype.paddingBottom	= webfxMenuDefaultPaddingBottom;

WebFXMenu.prototype.shadowLeft		= webfxMenuDefaultShadowLeft;
WebFXMenu.prototype.shadowRight		= webfxMenuDefaultShadowRight;
WebFXMenu.prototype.shadowTop		= webfxMenuDefaultShadowTop;
WebFXMenu.prototype.shadowBottom	= webfxMenuDefaultShadowBottom;

WebFXMenu.prototype.add = function (menuItem) {
	this._menuItems[this._menuItems.length] = menuItem;
	if (menuItem.subMenu) {
		this._subMenus[this._subMenus.length] = menuItem.subMenu;
		menuItem.subMenu.parentMenu = this;
	}

	menuItem.parentMenu = this;
};

WebFXMenu.prototype.show = function (relObj, sDir) {
	if (this.useAutoPosition)
		this.position(relObj, sDir);

	var divElement = document.getElementById(this.id);
	divElement.style.left = opera ? this.left : this.left + "px";
	divElement.style.top = opera ? this.top : this.top + "px";
	divElement.style.visibility = "visible";
	this.shown = true;
	if (this.parentMenu)
		this.parentMenu.show();
};

WebFXMenu.prototype.hide = function () {
	this.hideAllSubs();
	var divElement = document.getElementById(this.id);
	divElement.style.visibility = "hidden";
	this.shown = false;
};

WebFXMenu.prototype.hideAllSubs = function () {
	for (var i = 0; i < this._subMenus.length; i++) {
		if (this._subMenus[i].shown)
			this._subMenus[i].hide();
	}
};
WebFXMenu.prototype.toString = function () {
	var top = this.top + this.borderTop + this.paddingTop;
	var str = "<div id='" + this.id + "' class='webfx-menu' style='" +
	"width:" + (!ieBox  ?
		this.width - this.borderLeft - this.paddingLeft - this.borderRight - this.paddingRight  :
		this.width) + "px;" +
	(this.useAutoPosition ?
		"left:" + this.left + "px;" + "top:" + this.top + "px;" :
		"") +
	(ie50 ? "filter: none;" : "") +
	"'>";

	if (this._menuItems.length == 0) {
		str +=	"<span class='webfx-menu-empty'>" + this.emptyText + "</span>";
	}
	else {
		// loop through all menuItems
		for (var i = 0; i < this._menuItems.length; i++) {
			var mi = this._menuItems[i];
			str += mi;
			if (!this.useAutoPosition) {
				if (mi.subMenu && !mi.subMenu.useAutoPosition)
					mi.subMenu.top = top - mi.subMenu.borderTop - mi.subMenu.paddingTop;
				top += mi.height;
			}
		}

	}

	str += "</div>";

	for (var i = 0; i < this._subMenus.length; i++) {
		this._subMenus[i].left = this.left + this.width - this._subMenus[i].borderLeft;
		str += this._subMenus[i];
	}

	return str;
};
// WebFXMenu.prototype.position defined later
function WebFXMenuItem(sText, sHref, sToolTip, oSubMenu, sTarget, sICO) {
	this.text = sText || webfxMenuItemDefaultText;
	this.href = (sHref == null || sHref == "") ? webfxMenuItemDefaultHref : sHref;
	this.subMenu = oSubMenu;
	if (oSubMenu)
		oSubMenu.parentMenuItem = this;
	this.toolTip = sToolTip;
	this.id = webFXMenuHandler.getId();
	this.target = sTarget;//by:tianya
	this.ico = sICO;
	webFXMenuHandler.all[this.id] = this;
};
WebFXMenuItem.prototype.height = webfxMenuItemDefaultHeight;
WebFXMenuItem.prototype.toString = function () {
	return	"<a" +
			" id='" + this.id + "'" +
			" href=\"" + this.href + "\"" +
			(this.target ? " target=\"" + this.target + "\"" : "") +
			(this.toolTip ? " title=\"" + this.toolTip + "\"" : "") +
			" onmouseover='webFXMenuHandler.overMenuItem(this)'" +
			(webfxMenuUseHover ? " onmouseout='webFXMenuHandler.outMenuItem(this)'" : "") +
			(this.subMenu ? " unselectable='on' tabindex='-1'" : "") +
			">" +
			(this.ico ? "<img class='buttonico1' src=\"" + webfxMenuImagePath + this.ico + "\">" : "<img class='buttonico' src=\""+webfxMenuImagePath +"empty.gif\">") +

			 "<span>"+this.text +"<\/span>"+
			(this.subMenu ? "<img class='arrow' src=\"" + webfxMenuImagePath + "arrow.right.png\">" : "") +
			"</a>";
};


function WebFXMenuSeparator() {
	this.id = webFXMenuHandler.getId();
	webFXMenuHandler.all[this.id] = this;
};
WebFXMenuSeparator.prototype.height = webfxMenuSeparatorDefaultHeight;
WebFXMenuSeparator.prototype.toString = function () {
	return	"<div" +
			" id='" + this.id + "'" +
			(webfxMenuUseHover ?
			" onmouseover='webFXMenuHandler.overMenuItem(this)'" +
			" onmouseout='webFXMenuHandler.outMenuItem(this)'"
			:
			"") +
			"></div>"
};

function WebFXMenuBar() {
	this._parentConstructor = WebFXMenu;
	this._parentConstructor();
}
WebFXMenuBar.prototype = new WebFXMenu;
WebFXMenuBar.prototype.toString = function () {
	var str = "<div id='" + this.id + "' class='webfx-menu-bar'>";

	// loop through all menuButtons
	for (var i = 0; i < this._menuItems.length; i++)
		str += this._menuItems[i];

	str += "</div>";

	for (var i = 0; i < this._subMenus.length; i++)
		str += this._subMenus[i];

	return str;
};

function WebFXMenuButton(sText, sHref, sToolTip, oSubMenu, sICO) {
	this._parentConstructor = WebFXMenuItem;
	this._parentConstructor(sText, sHref, sToolTip, oSubMenu);
	this.ico = sICO;
}
WebFXMenuButton.prototype = new WebFXMenuItem;
WebFXMenuButton.prototype.toString = function () {
	return	"<span><a" +
			" id='" + this.id + "'" +
			" href=\"" + this.href + "\"" +
			(this.target ? " target=\"" + this.target + "\"" : "") +
			(this.toolTip ? " title=\"" + this.toolTip + "\"" : "") +
			(webfxMenuUseHover ?
				(" onmouseover='webFXMenuHandler.overMenuItem(this)'" +
				" onmouseout='webFXMenuHandler.outMenuItem(this)'") :
				(
					" onfocus='webFXMenuHandler.overMenuItem(this)'" +
					(this.subMenu ?
						" onblur='webFXMenuHandler.blurMenu(this)'" :
						""
					)
				)) +
			">" +
			(this.ico ? "<img class='buttonico' src=\"" + webfxMenuImagePath + this.ico + "\">" : "") +
			this.text +
			(this.subMenu ? " <img class='arrow' src=\"" + webfxMenuImagePath + "arrow.down.png\" align='absmiddle'>" : "") +
			"</a></span>";
};


/* Position functions */

function getInnerLeft(el) {
	if (el == null) return 0;
	if (ieBox && el == document.body || !ieBox && el == document.documentElement) return 0;
	return getLeft(el) + getBorderLeft(el);
}

function getLeft(el) {
	if (el == null) return 0;
	return el.offsetLeft + getInnerLeft(el.offsetParent);
}

function getInnerTop(el) {
	if (el == null) return 0;
	if (ieBox && el == document.body || !ieBox && el == document.documentElement) return 0;
	return getTop(el) + getBorderTop(el);
}

function getTop(el) {
	if (el == null) return 0;
	return el.offsetTop + getInnerTop(el.offsetParent);
}

function getBorderLeft(el) {
	return ie ?
		el.clientLeft :
		parseInt(window.getComputedStyle(el, null).getPropertyValue("border-left-width"));
}

function getBorderTop(el) {
	return ie ?
		el.clientTop :
		parseInt(window.getComputedStyle(el, null).getPropertyValue("border-top-width"));
}

function opera_getLeft(el) {
	if (el == null) return 0;
	return el.offsetLeft + opera_getLeft(el.offsetParent);
}

function opera_getTop(el) {
	if (el == null) return 0;
	return el.offsetTop + opera_getTop(el.offsetParent);
}

function getOuterRect(el) {
	return {
		left:	(opera ? opera_getLeft(el) : getLeft(el)),
		top:	(opera ? opera_getTop(el) : getTop(el)),
		width:	el.offsetWidth,
		height:	el.offsetHeight
	};
}

// mozilla bug! scrollbars not included in innerWidth/height
function getDocumentRect(el) {
	return {
		left:	0,
		top:	0,
		width:	(ie ?
					(ieBox ? document.body.clientWidth : document.documentElement.clientWidth) :
					window.innerWidth
				),
		height:	(ie ?
					(ieBox ? document.body.clientHeight : document.documentElement.clientHeight) :
					window.innerHeight
				)
	};
}

function getScrollPos(el) {
	return {
		left:	(ie ?
					(ieBox ? document.body.scrollLeft : document.documentElement.scrollLeft) :
					window.pageXOffset
				),
		top:	(ie ?
					(ieBox ? document.body.scrollTop : document.documentElement.scrollTop) :
					window.pageYOffset
				)
	};
}

/* end position functions */

WebFXMenu.prototype.position = function (relEl, sDir) {
	var dir = sDir;
	// find parent item rectangle, piRect
	var piRect;
	if (!relEl) {
		var pi = this.parentMenuItem;
		if (!this.parentMenuItem)
			return;

		relEl = document.getElementById(pi.id);
		if (dir == null)
			dir = pi instanceof WebFXMenuButton ? "vertical" : "horizontal";

		piRect = getOuterRect(relEl);
	}
	else if (relEl.left != null && relEl.top != null && relEl.width != null && relEl.height != null) {	// got a rect
		piRect = relEl;
	}
	else
		piRect = getOuterRect(relEl);

	var menuEl = document.getElementById(this.id);
	var menuRect = getOuterRect(menuEl);
	var docRect = getDocumentRect();
	var scrollPos = getScrollPos();
	var pMenu = this.parentMenu;

	if (dir == "vertical") {
		if (piRect.left + menuRect.width - scrollPos.left <= docRect.width)
			this.left = piRect.left;
		else if (docRect.width >= menuRect.width)
			this.left = docRect.width + scrollPos.left - menuRect.width;
		else
			this.left = scrollPos.left;

		if (piRect.top + piRect.height + menuRect.height <= docRect.height + scrollPos.top)
			this.top = piRect.top + piRect.height;
		else if (piRect.top - menuRect.height >= scrollPos.top)
			this.top = piRect.top - menuRect.height;
		else if (docRect.height >= menuRect.height)
			this.top = docRect.height + scrollPos.top - menuRect.height;
		else
			this.top = scrollPos.top;
	}
	else {
		if (piRect.top + menuRect.height - this.borderTop - this.paddingTop <= docRect.height + scrollPos.top)
			this.top = piRect.top - this.borderTop - this.paddingTop;
		else if (piRect.top + piRect.height - menuRect.height + this.borderTop + this.paddingTop >= 0)
			this.top = piRect.top + piRect.height - menuRect.height + this.borderBottom + this.paddingBottom + this.shadowBottom;
		else if (docRect.height >= menuRect.height)
			this.top = docRect.height + scrollPos.top - menuRect.height;
		else
			this.top = scrollPos.top;

		var pMenuPaddingLeft = pMenu ? pMenu.paddingLeft : 0;
		var pMenuBorderLeft = pMenu ? pMenu.borderLeft : 0;
		var pMenuPaddingRight = pMenu ? pMenu.paddingRight : 0;
		var pMenuBorderRight = pMenu ? pMenu.borderRight : 0;

		if (piRect.left + piRect.width + menuRect.width + pMenuPaddingRight +
			pMenuBorderRight - this.borderLeft + this.shadowRight <= docRect.width + scrollPos.left)
			this.left = piRect.left + piRect.width + pMenuPaddingRight + pMenuBorderRight - this.borderLeft;
		else if (piRect.left - menuRect.width - pMenuPaddingLeft - pMenuBorderLeft + this.borderRight + this.shadowRight >= 0)
			this.left = piRect.left - menuRect.width - pMenuPaddingLeft - pMenuBorderLeft + this.borderRight + this.shadowRight;
		else if (docRect.width >= menuRect.width)
			this.left = docRect.width  + scrollPos.left - menuRect.width;
		else
			this.left = scrollPos.left;
	}
};














function constExpression(x) {
	return x;
}

function simplifyCSSExpression() {
	try {
		var ss,sl, rs, rl;
		ss = document.styleSheets;
		sl = ss.length

		for (var i = 0; i < sl; i++) {
			simplifyCSSBlock(ss[i]);
		}
	}
	catch (exc) {
		alert("Got an error while processing css. The page should still work but might be a bit slower");
		throw exc;
	}
}

function simplifyCSSBlock(ss) {
	var rs, rl;

	for (var i = 0; i < ss.imports.length; i++)
		simplifyCSSBlock(ss.imports[i]);

	if (ss.cssText.indexOf("expression(constExpression(") == -1)
		return;

	rs = ss.rules;
	rl = rs.length;
	for (var j = 0; j < rl; j++)
		simplifyCSSRule(rs[j]);

}

function simplifyCSSRule(r) {
	var str = r.style.cssText;
	var str2 = str;
	var lastStr;
	do {
		lastStr = str2;
		str2 = simplifyCSSRuleHelper(lastStr);
	} while (str2 != lastStr)

	if (str2 != str)
		r.style.cssText = str2;
}

function simplifyCSSRuleHelper(str) {
	var i, i2;
	i = str.indexOf("expression(constExpression(");
	if (i == -1) return str;
	i2 = str.indexOf("))", i);
	var hd = str.substring(0, i);
	var tl = str.substring(i2 + 2);
	var exp = str.substring(i + 27, i2);
	var val = eval(exp)
	return hd + val + tl;
}

function removeExpressions() {
	var all = document.all;
	var l = all.length;
	for (var i = 0; i < l; i++) {
		simplifyCSSRule(all[i]);
	}
}

if (/msie/i.test(navigator.userAgent) && window.attachEvent != null) {
	window.attachEvent("onload", function () {
		simplifyCSSExpression();

		removeExpressions();
	});
}



webfxMenuImagePath = "images/"
webfxMenuUseHover  = true;
WebFXMenu.prototype.borderLeft  = 2;
WebFXMenu.prototype.borderRight = 2;
WebFXMenu.prototype.borderTop   = 2;
WebFXMenu.prototype.borderBottom= 2;
WebFXMenu.prototype.paddingLeft = 1;
WebFXMenu.prototype.paddingRight= 1;
WebFXMenu.prototype.paddingTop  = 1;
WebFXMenu.prototype.paddingBottom = 1;

WebFXMenu.prototype.shadowLeft = 0;
WebFXMenu.prototype.shadowRight	= 0;
WebFXMenu.prototype.shadowTop = 0;
WebFXMenu.prototype.shadowBottom = 0;


//var mySubMenu = new WebFXMenu;
//mySubMenu.add(new WebFXMenuItem("Menu Item 3", "http://www.domain.com", "Tool tip to show"));

//myMenu.add(new WebFXMenuItem("Menu Item 4 with sub menu", null, "Tool tip to show", mySubMenu));

//网站建设二级展开
var tmp = new WebFXMenu;
tmp.add(new WebFXMenuItem('网站建设','http://www.idcme.com','网站建设'));
tmp.add(new WebFXMenuItem('网站推广','http://www.idcme.com/mail.asp','企业邮箱'));
tmp.add(new WebFXMenuItem('域名注册','http://www.idcme.com/domain.asp','域名注册'));
tmp.add(new WebFXMenuItem('虚拟主机','http://www.idcme.com/hosting.as','虚拟主机'));

//客服系统二级展开
var tmp1 = new WebFXMenu;
tmp1.add(new WebFXMenuItem('客服系统','http://im.idcme.com','客服系统'));

//以上为二级菜单

//公司产品
var myMenu = new WebFXMenu;
myMenu.add(new WebFXMenuItem('网站建设',null,'网站建设',tmp));
myMenu.add(new WebFXMenuItem('客服系统',null,'客服系统',tmp1))

//服务支持
var myMenu1 = new WebFXMenu;
myMenu1.add(new WebFXMenuItem('客服中心','http://im.idcme.com/service.php','客服中心'));
myMenu1.add(new WebFXMenuItem('授权中心','http://im.idcme.com/service.php','授权中心'));
myMenu1.add(new WebFXMenuSeparator());//分隔线
myMenu1.add(new WebFXMenuItem('授权购买','http://im.idcme.com/service.php','授权购买',null,null,'au.gif'));
myMenu1.add(new WebFXMenuItem('服务套餐','http://im.idcme.com/price.php','服务套餐'));

//技术论坛
var myMenu3 = new WebFXMenu;
myMenu3.add(new WebFXMenuItem('使用交流',null,'使用交流'));
myMenu3.add(new WebFXMenuItem('综合交流',null,'综合交流'));
myMenu3.add(new WebFXMenuItem('模板中心',null,'模板中心'));


//帮助
var myMenu4 = new WebFXMenu;
myMenu4.add(new WebFXMenuItem('帮助中心','http://im.idcme.com/help.php','帮助中心',null,null,'helpc.gif'));
myMenu4.add(new WebFXMenuSeparator());//分隔线
myMenu4.add(new WebFXMenuItem('关于我们','http://im.idcme.com/about.php','关于我们'));

//以上为一级菜单

//导航条
var myBar = new WebFXMenuBar;
myBar.add(new WebFXMenuButton('官方网站','http://im.idcme.com',"官方网站",null,'home.gif'));
myBar.add(new WebFXMenuButton("公司产品", null, "公司产品",myMenu,'dede.gif'));
myBar.add(new WebFXMenuButton("服务支持", 'http://im.idcme.com/service.php', "服务支持",myMenu1,'service.gif'));
myBar.add(new WebFXMenuButton("技术论坛", null, "技术论坛",myMenu3,'bbs.gif'));
myBar.add(new WebFXMenuButton("帮&nbsp;&nbsp;&nbsp;助", null, "技术论坛",myMenu4,'help.gif'));

document.write("<link href=\"images\/topNav.css\" type=\"text\/css\" rel=\"stylesheet\">");
document.write("<div class=\"dedetoolbar\">");
document.write("<div class=\"commtopNav\">");
document.write("<div class=\"commtopNav_right\">");
document.write(myBar);
document.write("<\/div>");
document.write("<\/div>");
document.write("<\/div>");
");
