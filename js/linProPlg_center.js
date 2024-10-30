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

jQuery(document).ready(function(){
if ((ClientOS.Engine.Windows && (linProPlg.windows=='true')) || (ClientOS.Engine.Mac && (linProPlg.mac=='true')) || (linProPlg.test == 'true')) {
		jQuery('body').prepend('<div id="ie6w_div"><div id="ie6w_frame"><div id="ie6w_t1">' + convertehtml(linProPlg.t1) + '</div><div id="ie6w_t2">' + convertehtml(linProPlg.t2) + '</div><div id="ie6w_t3">' + convertehtml(linProPlg.t3) + '</div><div id="ie6w_browsers"></div></div></div>');
		jQuery('#ie6w_div').css({
			"position": "fixed",
			"overflow": "hidden",
			"z-index": "1500",
			"left": "0px",
			"top": "0px",
			"height": "100%",
			"width": "1000",
			"background-color": "#000000",
			"font-family": "Verdana, Arial, Helvetica, sans-serif",
			"font-size": "11px",
			"color": "#000000"
		}).width(jQuery(window).width()).height(jQuery(window).height());
		jQuery('#ie6w_div #ie6w_frame').css({
			"position": "absolute",
			"overflow": "hidden",
			"background-color": "#FFFFFF",
			"left": "50%",
			"top": "50%",
			"height": "350px",
			"width": "450px",
			"margin-top": "-150px",
			"margin-left": "-225px"
		}).css({
			"margin-top": "-" + (jQuery('#ie6w_div #ie6w_frame').outerHeight()/2) + "px",
			"margin-left": "-" + (jQuery('#ie6w_div #ie6w_frame').outerWidth()/2) + "px"
		});
		jQuery('#ie6w_div #ie6w_frame #ie6w_t1').css({
			"position": "absolute",
			"left": "15px",
			"top": "20px",
			"font-family": "Impact, Verdana, Arial",
			"font-size": "42px",
			"font-weight": "bold",
			"color": "#990000"
		});
		jQuery('#ie6w_div #ie6w_frame #ie6w_t2').css({
				"position": "absolute",
				"width": "400px",
 				"left": "25px",
				"top": "60px",
				"font-family": "Verdana, Arial, Helvetica, sans-serif",
				"font-size": "16px",
				"color": "#000000",
				"text-align": "justify"
		}).width(jQuery('#ie6w_div #ie6w_frame').width() - 50);
		jQuery('#ie6w_div #ie6w_frame #ie6w_t3').css({
				"position": "absolute",
				"width": "400px",
 				"left": "25px",
				"top": "210px",
				"font-family": "Verdana, Arial, Helvetica, sans-serif",
				"font-size": "12px",
				"font-weight": "bold",
				"color": "#000000",
				"text-align": "justify"
		}).width(jQuery('#ie6w_div #ie6w_frame').width() - 50).css({
				"top": (jQuery('#ie6w_div #ie6w_frame #ie6w_t2').outerHeight() + 85) + "px"
		});
		var ie6w_b = 0;
		if(linProPlg.centos=='true') {
			ie6w_b++;
			jQuery('#ie6w_div #ie6w_frame #ie6w_browsers').prepend('<a href="' + linProPlg.centosURL + '" target="_blank"><img src="' + linProPlg.url + '/img/centos-button.png" alt="get CentOS!" width="128" height="64" border="0" /></a>');
		}
		if(linProPlg.ubuntu=='true') {
			ie6w_b++;
			jQuery('#ie6w_div #ie6w_frame #ie6w_browsers').prepend('<a href="' + linProPlg.ubuntuURL + '" target="_blank"><img src="' + linProPlg.url + '/img/ubuntu-button.png" alt="get Ubuntu!" width="128" height="64" border="0" /></a>');
		}
		if(linProPlg.linuxMint=='true') {
			ie6w_b++;
			jQuery('#ie6w_div #ie6w_frame #ie6w_browsers').prepend('<a href="' + linProPlg.linuxMintURL + '" target="_blank"><img src="' + linProPlg.url + '/img/linuxMint-button.png" alt="get Linux Mint!" width="128" height="64" border="0" /></a>');
		}
		if(linProPlg.fedora=='true') {
			ie6w_b++;
			jQuery('#ie6w_div #ie6w_frame #ie6w_browsers').prepend('<a href="' + linProPlg.fedoraURL + '" target="_blank"><img src="' + linProPlg.url + '/img/fedora-button.png" alt="get Fedora!" width="128" height="64" border="0" /></a>');
		}
		jQuery('#ie6w_div #ie6w_frame #ie6w_browsers').css({
				"height": "66px",
				"bottom": "7px",
				"right": "7px",
				"position": "absolute",
				"overflow": "hidden",
				"text-align": "right"
		}).width(128 * ie6w_b);
		
		jQuery('#ie6w_div').click(function () {
			jQuery('#ie6w_div').remove();
    	});
		jQuery('#ie6w_div #ie6w_frame').click(function () {
			jQuery('#ie6w_div').remove();
    	});
}
});
if (linProPlg.jstest == 'true' && linProPlg.test == 'true') { alert('LinuxPromoPlg:End'); }
