// 1.1
if (linProPlg.jstest == 'true' && linProPlg.test == 'true') { alert('LinuxPromoPlg:Begin'); }

function convertehtml(str) {
	return str.replace(/&quot;/g,'"').replace(/&amp;/g,"&").replace(/&lt;/g,"<").replace(/&gt;/g,">");
}

var ClientOS = {
	Engine: {'name': 'unknown', 'version': ''}
};

ClientOS.Engine = {'name': detectOS(), 'version': ''};
ClientOS.Engine[ClientOS.Engine.name] = true;

jQuery(document).ready(function() {
if ((ClientOS.Engine.Windows && (linProPlg.windows=='true')) || (ClientOS.Engine.Mac && (linProPlg.mac=='true')) || (linProPlg.test == 'true')) {
		jQuery('body').prepend('<div id="ie6w_div"><div id="ie6w_icon"><img src="' + linProPlg.url + '/img/alert.gif" width="30" height="28" /></div><div id="ie6w_text"><strong><font color=RED>' + convertehtml(linProPlg.t1) + '</font></strong>: ' + convertehtml(linProPlg.t2) + '</div><div id="ie6w_browsers"></div></div>');
		jQuery('#ie6w_div').css({
			"overflow": "hidden",
			"z-index": "1500",
			"left": "0px",
			"top": "0px",
			"height": "66px",
			"width": "100%",
			"background-color": "#FFFF00",
			"font-family": "Verdana, Arial, Helvetica, sans-serif",
			"font-size": "11px",
			"color": "#000000",
			"clear": "both",
			"border-bottom-width": "1px",
			"border-bottom-style": "solid",
			"border-bottom-color": "#000000"
		}).width(jQuery(window).width());
		jQuery('#ie6w_div #ie6w_icon').css({
			"overflow": "hidden",
			"position": "absolute",
			"left": "0px",
			"top": "3px",
			"padding": "3px"
		});
		var ie6w_b = 0;
		if(linProPlg.centos=='true') {
			ie6w_b++;
			jQuery('#ie6w_div #ie6w_browsers').prepend('<a href="' + linProPlg.centosURL + '" target="_blank"><img src="' + linProPlg.url + '/img/centos-button.png" alt="get CentOS!" width="128" height="64" border="0" /></a>');
		}
		if(linProPlg.ubuntu=='true') {
			ie6w_b++;
			jQuery('#ie6w_div #ie6w_browsers').prepend('<a href="' + linProPlg.ubuntuURL + '" target="_blank"><img src="' + linProPlg.url + '/img/ubuntu-button.png" alt="get Ubuntu!" width="128" height="64" border="0" /></a>');
		}
		if(linProPlg.linuxMint=='true') {
			ie6w_b++;
			jQuery('#ie6w_div #ie6w_browsers').prepend('<a href="' + linProPlg.linuxMintURL + '" target="_blank"><img src="' + linProPlg.url + '/img/linuxMint-button.png" alt="get LinuxMint!" width="128" height="64" border="0" /></a>');
		}
		if(linProPlg.fedora=='true') {
			ie6w_b++;
			jQuery('#ie6w_div #ie6w_browsers').prepend('<a href="' + linProPlg.fedoraURL + '" target="_blank"><img src="' + linProPlg.url + '/img/fedora-button.png" alt="get Fedora!" width="128" height="64" border="0" /></a>');
		}
		jQuery('#ie6w_div #ie6w_browsers').css({
			"overflow": "hidden",
			"position": "absolute",
			"right": "0px",
			"top": "0px"
		}).width((ie6w_b *128)+12);
		jQuery('#ie6w_div #ie6w_text').css({
			"overflow": "hidden",
			"position": "absolute",
			"left": "36px",
			"top": "0px",
			"height": "66px",
			"width": "650px",
			"padding": "3px",
			"text-align": "left"
		}).width(jQuery(window).width() - jQuery('#ie6w_div #ie6w_icon').outerWidth() - jQuery('#ie6w_div #ie6w_browsers').outerWidth() - 6);
}
});
if (linProPlg.jstest == 'true' && linProPlg.test == 'true') { alert('LinuxPromoPlg:End'); }
