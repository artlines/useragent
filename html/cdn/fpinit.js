(function(r,l,t){"undefined"!==typeof window&&"function"===typeof define&&define.amd?define(t):"undefined"!==typeof module&&module.exports?module.exports=t():l.exports?l.exports=t():l[r]=t()})("Fingerprint2",this,function(){var r=function(a,b){a=[a[0]>>>16,a[0]&65535,a[1]>>>16,a[1]&65535];b=[b[0]>>>16,b[0]&65535,b[1]>>>16,b[1]&65535];var c=[0,0,0,0];c[3]+=a[3]+b[3];c[2]+=c[3]>>>16;c[3]&=65535;c[2]+=a[2]+b[2];c[1]+=c[2]>>>16;c[2]&=65535;c[1]+=a[1]+b[1];c[0]+=c[1]>>>16;c[1]&=65535;c[0]+=a[0]+b[0];c[0]&=
    65535;return[c[0]<<16|c[1],c[2]<<16|c[3]]},l=function(a,b){a=[a[0]>>>16,a[0]&65535,a[1]>>>16,a[1]&65535];b=[b[0]>>>16,b[0]&65535,b[1]>>>16,b[1]&65535];var c=[0,0,0,0];c[3]+=a[3]*b[3];c[2]+=c[3]>>>16;c[3]&=65535;c[2]+=a[2]*b[3];c[1]+=c[2]>>>16;c[2]&=65535;c[2]+=a[3]*b[2];c[1]+=c[2]>>>16;c[2]&=65535;c[1]+=a[1]*b[3];c[0]+=c[1]>>>16;c[1]&=65535;c[1]+=a[2]*b[2];c[0]+=c[1]>>>16;c[1]&=65535;c[1]+=a[3]*b[1];c[0]+=c[1]>>>16;c[1]&=65535;c[0]+=a[0]*b[3]+a[1]*b[2]+a[2]*b[1]+a[3]*b[0];c[0]&=65535;return[c[0]<<
16|c[1],c[2]<<16|c[3]]},t=function(a,b){b%=64;if(32===b)return[a[1],a[0]];if(32>b)return[a[0]<<b|a[1]>>>32-b,a[1]<<b|a[0]>>>32-b];b-=32;return[a[1]<<b|a[0]>>>32-b,a[0]<<b|a[1]>>>32-b]},n=function(a,b){b%=64;return 0===b?a:32>b?[a[0]<<b|a[1]>>>32-b,a[1]<<b]:[a[1]<<b-32,0]},h=function(a,b){return[a[0]^b[0],a[1]^b[1]]},A=function(a){a=h(a,[0,a[0]>>>1]);a=l(a,[4283543511,3981806797]);a=h(a,[0,a[0]>>>1]);a=l(a,[3301882366,444984403]);return a=h(a,[0,a[0]>>>1])},B=function(a,b){a=a||"";b=b||0;for(var c=
    a.length%16,e=a.length-c,d=[0,b],g=[0,b],k,q,f=[2277735313,289559509],m=[1291169091,658871167],p=0;p<e;p+=16)k=[a.charCodeAt(p+4)&255|(a.charCodeAt(p+5)&255)<<8|(a.charCodeAt(p+6)&255)<<16|(a.charCodeAt(p+7)&255)<<24,a.charCodeAt(p)&255|(a.charCodeAt(p+1)&255)<<8|(a.charCodeAt(p+2)&255)<<16|(a.charCodeAt(p+3)&255)<<24],q=[a.charCodeAt(p+12)&255|(a.charCodeAt(p+13)&255)<<8|(a.charCodeAt(p+14)&255)<<16|(a.charCodeAt(p+15)&255)<<24,a.charCodeAt(p+8)&255|(a.charCodeAt(p+9)&255)<<8|(a.charCodeAt(p+10)&
    255)<<16|(a.charCodeAt(p+11)&255)<<24],k=l(k,f),k=t(k,31),k=l(k,m),d=h(d,k),d=t(d,27),d=r(d,g),d=r(l(d,[0,5]),[0,1390208809]),q=l(q,m),q=t(q,33),q=l(q,f),g=h(g,q),g=t(g,31),g=r(g,d),g=r(l(g,[0,5]),[0,944331445]);k=[0,0];q=[0,0];switch(c){case 15:q=h(q,n([0,a.charCodeAt(p+14)],48));case 14:q=h(q,n([0,a.charCodeAt(p+13)],40));case 13:q=h(q,n([0,a.charCodeAt(p+12)],32));case 12:q=h(q,n([0,a.charCodeAt(p+11)],24));case 11:q=h(q,n([0,a.charCodeAt(p+10)],16));case 10:q=h(q,n([0,a.charCodeAt(p+9)],8));case 9:q=
    h(q,[0,a.charCodeAt(p+8)]),q=l(q,m),q=t(q,33),q=l(q,f),g=h(g,q);case 8:k=h(k,n([0,a.charCodeAt(p+7)],56));case 7:k=h(k,n([0,a.charCodeAt(p+6)],48));case 6:k=h(k,n([0,a.charCodeAt(p+5)],40));case 5:k=h(k,n([0,a.charCodeAt(p+4)],32));case 4:k=h(k,n([0,a.charCodeAt(p+3)],24));case 3:k=h(k,n([0,a.charCodeAt(p+2)],16));case 2:k=h(k,n([0,a.charCodeAt(p+1)],8));case 1:k=h(k,[0,a.charCodeAt(p)]),k=l(k,f),k=t(k,31),k=l(k,m),d=h(d,k)}d=h(d,[0,a.length]);g=h(g,[0,a.length]);d=r(d,g);g=r(g,d);d=A(d);g=A(g);d=
    r(d,g);g=r(g,d);return("00000000"+(d[0]>>>0).toString(16)).slice(-8)+("00000000"+(d[1]>>>0).toString(16)).slice(-8)+("00000000"+(g[0]>>>0).toString(16)).slice(-8)+("00000000"+(g[1]>>>0).toString(16)).slice(-8)},C={preprocessor:null,audio:{timeout:1E3,excludeIOS11:!0},fonts:{swfContainerId:"fingerprintjs2",swfPath:"flash/compiled/FontList.swf",userDefinedFonts:[],extendedJsFonts:!1},screen:{detectScreenOrientation:!0},plugins:{sortPluginsFor:[/palemoon/i],excludeIE:!1},extraComponents:[],excludes:{enumerateDevices:!0,
        pixelRatio:!0,doNotTrack:!0,fontsFlash:!0},NOT_AVAILABLE:"not available",ERROR:"error",EXCLUDED:"excluded"},w=function(a,b){if(Array.prototype.forEach&&a.forEach===Array.prototype.forEach)a.forEach(b);else if(a.length===+a.length)for(var c=0,e=a.length;c<e;c++)b(a[c],c,a);else for(c in a)a.hasOwnProperty(c)&&b(a[c],c,a)},x=function(a,b){var c=[];if(null==a)return c;if(Array.prototype.map&&a.map===Array.prototype.map)return a.map(b);w(a,function(a,d,g){c.push(b(a,d,g))});return c},D=function(a,b){if(null==
    b)return a;var c;for(c in b){var e=b[c];null==e||Object.prototype.hasOwnProperty.call(a,c)||(a[c]=e)}return a},z=function(a){if(null==navigator.plugins)return a.NOT_AVAILABLE;for(var b=[],c=0,e=navigator.plugins.length;c<e;c++)navigator.plugins[c]&&b.push(navigator.plugins[c]);f(a)&&(b=b.sort(function(a,b){return a.name>b.name?1:a.name<b.name?-1:0}));return x(b,function(a){var b=x(a,function(a){return[a.type,a.suffixes]});return[a.name,a.description,b]})},v=function(a){var b=[];Object.getOwnPropertyDescriptor&&
Object.getOwnPropertyDescriptor(window,"ActiveXObject")||"ActiveXObject"in window?b=x("AcroPDF.PDF;Adodb.Stream;AgControl.AgControl;DevalVRXCtrl.DevalVRXCtrl.1;MacromediaFlashPaper.MacromediaFlashPaper;Msxml2.DOMDocument;Msxml2.XMLHTTP;PDF.PdfCtrl;QuickTime.QuickTime;QuickTimeCheckObject.QuickTimeCheck.1;RealPlayer;RealPlayer.RealPlayer(tm) ActiveX Control (32-bit);RealVideo.RealVideo(tm) ActiveX Control (32-bit);Scripting.Dictionary;SWCtl.SWCtl;Shell.UIHelper;ShockwaveFlash.ShockwaveFlash;Skype.Detection;TDCCtl.TDCCtl;WMPlayer.OCX;rmocx.RealPlayer G2 Control;rmocx.RealPlayer G2 Control.1".split(";"),
    function(b){try{return new window.ActiveXObject(b),b}catch(e){return a.ERROR}}):b.push(a.NOT_AVAILABLE);navigator.plugins&&(b=b.concat(z(a)));return b},f=function(a){for(var b=!1,c=0,e=a.plugins.sortPluginsFor.length;c<e;c++)if(navigator.userAgent.match(a.plugins.sortPluginsFor[c])){b=!0;break}return b},m=function(){var a=function(a){b.clearColor(0,0,0,1);b.enable(b.DEPTH_TEST);b.depthFunc(b.LEQUAL);b.clear(b.COLOR_BUFFER_BIT|b.DEPTH_BUFFER_BIT);return"["+a[0]+", "+a[1]+"]"};var b=E();if(!b)return null;
    var c=[],e=b.createBuffer();b.bindBuffer(b.ARRAY_BUFFER,e);var d=new Float32Array([-.2,-.9,0,.4,-.26,0,0,.732134444,0]);b.bufferData(b.ARRAY_BUFFER,d,b.STATIC_DRAW);e.itemSize=3;e.numItems=3;d=b.createProgram();var g=b.createShader(b.VERTEX_SHADER);b.shaderSource(g,"attribute vec2 attrVertex;varying vec2 varyinTexCoordinate;uniform vec2 uniformOffset;void main(){varyinTexCoordinate=attrVertex+uniformOffset;gl_Position=vec4(attrVertex,0,1);}");b.compileShader(g);var k=b.createShader(b.FRAGMENT_SHADER);
    b.shaderSource(k,"precision mediump float;varying vec2 varyinTexCoordinate;void main() {gl_FragColor=vec4(varyinTexCoordinate,0,1);}");b.compileShader(k);b.attachShader(d,g);b.attachShader(d,k);b.linkProgram(d);b.useProgram(d);d.vertexPosAttrib=b.getAttribLocation(d,"attrVertex");d.offsetUniform=b.getUniformLocation(d,"uniformOffset");b.enableVertexAttribArray(d.vertexPosArray);b.vertexAttribPointer(d.vertexPosAttrib,e.itemSize,b.FLOAT,!1,0,0);b.uniform2f(d.offsetUniform,1,1);b.drawArrays(b.TRIANGLE_STRIP,
        0,e.numItems);try{c.push(b.canvas.toDataURL())}catch(I){}c.push("extensions:"+(b.getSupportedExtensions()||[]).join(";"));c.push("webgl aliased line width range:"+a(b.getParameter(b.ALIASED_LINE_WIDTH_RANGE)));c.push("webgl aliased point size range:"+a(b.getParameter(b.ALIASED_POINT_SIZE_RANGE)));c.push("webgl alpha bits:"+b.getParameter(b.ALPHA_BITS));c.push("webgl antialiasing:"+(b.getContextAttributes().antialias?"yes":"no"));c.push("webgl blue bits:"+b.getParameter(b.BLUE_BITS));c.push("webgl depth bits:"+
        b.getParameter(b.DEPTH_BITS));c.push("webgl green bits:"+b.getParameter(b.GREEN_BITS));c.push("webgl max anisotropy:"+function(a){var b=a.getExtension("EXT_texture_filter_anisotropic")||a.getExtension("WEBKIT_EXT_texture_filter_anisotropic")||a.getExtension("MOZ_EXT_texture_filter_anisotropic");return b?(a=a.getParameter(b.MAX_TEXTURE_MAX_ANISOTROPY_EXT),0===a&&(a=2),a):null}(b));c.push("webgl max combined texture image units:"+b.getParameter(b.MAX_COMBINED_TEXTURE_IMAGE_UNITS));c.push("webgl max cube map texture size:"+
        b.getParameter(b.MAX_CUBE_MAP_TEXTURE_SIZE));c.push("webgl max fragment uniform vectors:"+b.getParameter(b.MAX_FRAGMENT_UNIFORM_VECTORS));c.push("webgl max render buffer size:"+b.getParameter(b.MAX_RENDERBUFFER_SIZE));c.push("webgl max texture image units:"+b.getParameter(b.MAX_TEXTURE_IMAGE_UNITS));c.push("webgl max texture size:"+b.getParameter(b.MAX_TEXTURE_SIZE));c.push("webgl max varying vectors:"+b.getParameter(b.MAX_VARYING_VECTORS));c.push("webgl max vertex attribs:"+b.getParameter(b.MAX_VERTEX_ATTRIBS));
    c.push("webgl max vertex texture image units:"+b.getParameter(b.MAX_VERTEX_TEXTURE_IMAGE_UNITS));c.push("webgl max vertex uniform vectors:"+b.getParameter(b.MAX_VERTEX_UNIFORM_VECTORS));c.push("webgl max viewport dims:"+a(b.getParameter(b.MAX_VIEWPORT_DIMS)));c.push("webgl red bits:"+b.getParameter(b.RED_BITS));c.push("webgl renderer:"+b.getParameter(b.RENDERER));c.push("webgl shading language version:"+b.getParameter(b.SHADING_LANGUAGE_VERSION));c.push("webgl stencil bits:"+b.getParameter(b.STENCIL_BITS));
    c.push("webgl vendor:"+b.getParameter(b.VENDOR));c.push("webgl version:"+b.getParameter(b.VERSION));try{var f=b.getExtension("WEBGL_debug_renderer_info");f&&(c.push("webgl unmasked vendor:"+b.getParameter(f.UNMASKED_VENDOR_WEBGL)),c.push("webgl unmasked renderer:"+b.getParameter(f.UNMASKED_RENDERER_WEBGL)))}catch(I){}if(!b.getShaderPrecisionFormat)return c;w(["FLOAT","INT"],function(a){w(["VERTEX","FRAGMENT"],function(d){w(["HIGH","MEDIUM","LOW"],function(e){w(["precision","rangeMin","rangeMax"],
        function(k){var g=b.getShaderPrecisionFormat(b[d+"_SHADER"],b[e+"_"+a])[k];"precision"!==k&&(k="precision "+k);k=["webgl ",d.toLowerCase()," shader ",e.toLowerCase()," ",a.toLowerCase()," ",k,":",g].join("");c.push(k)})})})});return c},u=function(){if("undefined"!==typeof navigator.languages)try{if(navigator.languages[0].substr(0,2)!==navigator.language.substr(0,2))return!0}catch(a){return!0}return!1},F=function(){var a=navigator.userAgent.toLowerCase(),b=navigator.oscpu,c=navigator.platform.toLowerCase();
    a=0<=a.indexOf("windows phone")?"Windows Phone":0<=a.indexOf("win")?"Windows":0<=a.indexOf("android")?"Android":0<=a.indexOf("linux")||0<=a.indexOf("cros")?"Linux":0<=a.indexOf("iphone")||0<=a.indexOf("ipad")?"iOS":0<=a.indexOf("mac")?"Mac":"Other";return("ontouchstart"in window||0<navigator.maxTouchPoints||0<navigator.msMaxTouchPoints)&&"Windows Phone"!==a&&"Android"!==a&&"iOS"!==a&&"Other"!==a||"undefined"!==typeof b&&(b=b.toLowerCase(),0<=b.indexOf("win")&&"Windows"!==a&&"Windows Phone"!==a||0<=
    b.indexOf("linux")&&"Linux"!==a&&"Android"!==a||0<=b.indexOf("mac")&&"Mac"!==a&&"iOS"!==a||(-1===b.indexOf("win")&&-1===b.indexOf("linux")&&-1===b.indexOf("mac"))!==("Other"===a))?!0:0<=c.indexOf("win")&&"Windows"!==a&&"Windows Phone"!==a||(0<=c.indexOf("linux")||0<=c.indexOf("android")||0<=c.indexOf("pike"))&&"Linux"!==a&&"Android"!==a||(0<=c.indexOf("mac")||0<=c.indexOf("ipad")||0<=c.indexOf("ipod")||0<=c.indexOf("iphone"))&&"Mac"!==a&&"iOS"!==a||(0>c.indexOf("win")&&0>c.indexOf("linux")&&0>c.indexOf("mac")&&
        0>c.indexOf("iphone")&&0>c.indexOf("ipad"))!==("Other"===a)?!0:"undefined"===typeof navigator.plugins&&"Windows"!==a&&"Windows Phone"!==a},J=function(){var a=navigator.userAgent.toLowerCase(),b=navigator.productSub;a=0<=a.indexOf("firefox")?"Firefox":0<=a.indexOf("opera")||0<=a.indexOf("opr")?"Opera":0<=a.indexOf("chrome")?"Chrome":0<=a.indexOf("safari")?"Safari":0<=a.indexOf("trident")?"Internet Explorer":"Other";if(("Chrome"===a||"Safari"===a||"Opera"===a)&&"20030107"!==b)return!0;b=eval.toString().length;
    if(37===b&&"Safari"!==a&&"Firefox"!==a&&"Other"!==a||39===b&&"Internet Explorer"!==a&&"Other"!==a||33===b&&"Chrome"!==a&&"Opera"!==a&&"Other"!==a)return!0;try{throw"a";}catch(e){try{e.toSource();var c=!0}catch(d){c=!1}}return c&&"Firefox"!==a&&"Other"!==a},G=function(){var a=document.createElement("canvas");return!(!a.getContext||!a.getContext("2d"))},H=function(){if(!G())return!1;var a=E();return!!window.WebGLRenderingContext&&!!a},K=function(a){var b=document.createElement("div");b.setAttribute("id",
    a.fonts.swfContainerId);document.body.appendChild(b)},L=function(a,b){window.___fp_swf_loaded=function(b){a(b)};var c=b.fonts.swfContainerId;K();window.swfobject.embedSWF(b.fonts.swfPath,c,"1","1","9.0.0",!1,{onReady:"___fp_swf_loaded"},{allowScriptAccess:"always",menu:"false"},{})},E=function(){var a=document.createElement("canvas"),b=null;try{b=a.getContext("webgl")||a.getContext("experimental-webgl")}catch(c){}b||(b=null);return b},M=[{key:"userAgent",getData:function(a){a(navigator.userAgent)}},
    {key:"webdriver",getData:function(a,b){a(null==navigator.webdriver?b.NOT_AVAILABLE:navigator.webdriver)}},{key:"language",getData:function(a,b){a(navigator.language||navigator.userLanguage||navigator.browserLanguage||navigator.systemLanguage||b.NOT_AVAILABLE)}},{key:"colorDepth",getData:function(a,b){a(window.screen.colorDepth||b.NOT_AVAILABLE)}},{key:"deviceMemory",getData:function(a,b){a(navigator.deviceMemory||b.NOT_AVAILABLE)}},{key:"pixelRatio",getData:function(a,b){a(window.devicePixelRatio||
            b.NOT_AVAILABLE)}},{key:"hardwareConcurrency",getData:function(a,b){var c=navigator.hardwareConcurrency?navigator.hardwareConcurrency:b.NOT_AVAILABLE;a(c)}},{key:"screenResolution",getData:function(a,b){var c=[window.screen.width,window.screen.height];b.screen.detectScreenOrientation&&c.sort().reverse();a(c)}},{key:"availableScreenResolution",getData:function(a,b){if(window.screen.availWidth&&window.screen.availHeight){var c=[window.screen.availHeight,window.screen.availWidth];b.screen.detectScreenOrientation&&
        c.sort().reverse()}else c=b.NOT_AVAILABLE;a(c)}},{key:"timezoneOffset",getData:function(a){a((new Date).getTimezoneOffset())}},{key:"timezone",getData:function(a,b){window.Intl&&window.Intl.DateTimeFormat?a((new window.Intl.DateTimeFormat).resolvedOptions().timeZone):a(b.NOT_AVAILABLE)}},{key:"sessionStorage",getData:function(a,b){try{var c=!!window.sessionStorage}catch(e){c=b.ERROR}a(c)}},{key:"localStorage",getData:function(a,b){try{var c=!!window.localStorage}catch(e){c=b.ERROR}a(c)}},{key:"indexedDb",
        getData:function(a,b){try{var c=!!window.indexedDB}catch(e){c=b.ERROR}a(c)}},{key:"addBehavior",getData:function(a){a(!(!document.body||!document.body.addBehavior))}},{key:"openDatabase",getData:function(a){a(!!window.openDatabase)}},{key:"cpuClass",getData:function(a,b){a(navigator.cpuClass||b.NOT_AVAILABLE)}},{key:"platform",getData:function(a,b){var c=navigator.platform?navigator.platform:b.NOT_AVAILABLE;a(c)}},{key:"doNotTrack",getData:function(a,b){a(navigator.doNotTrack?navigator.doNotTrack:
            navigator.msDoNotTrack?navigator.msDoNotTrack:window.doNotTrack?window.doNotTrack:b.NOT_AVAILABLE)}},{key:"plugins",getData:function(a,b){"Microsoft Internet Explorer"===navigator.appName||"Netscape"===navigator.appName&&/Trident/.test(navigator.userAgent)?b.plugins.excludeIE?a(b.EXCLUDED):a(v(b)):a(z(b))}},{key:"canvas",getData:function(a,b){if(G()){var c=[],e=document.createElement("canvas");e.width=2E3;e.height=200;e.style.display="inline";var d=e.getContext("2d");d.rect(0,0,10,10);d.rect(2,2,
            6,6);c.push("canvas winding:"+(!1===d.isPointInPath(5,5,"evenodd")?"yes":"no"));d.textBaseline="alphabetic";d.fillStyle="#f60";d.fillRect(125,1,62,20);d.fillStyle="#069";d.font=b.dontUseFakeFontInCanvas?"11pt Arial":"11pt no-real-font-123";d.fillText("Cwm fjordbank glyphs vext quiz, \ud83d\ude03",2,15);d.fillStyle="rgba(102, 204, 0, 0.2)";d.font="18pt Arial";d.fillText("Cwm fjordbank glyphs vext quiz, \ud83d\ude03",4,45);d.globalCompositeOperation="multiply";d.fillStyle="rgb(255,0,255)";d.beginPath();
            d.arc(50,50,50,0,2*Math.PI,!0);d.closePath();d.fill();d.fillStyle="rgb(0,255,255)";d.beginPath();d.arc(100,50,50,0,2*Math.PI,!0);d.closePath();d.fill();d.fillStyle="rgb(255,255,0)";d.beginPath();d.arc(75,100,50,0,2*Math.PI,!0);d.closePath();d.fill();d.fillStyle="rgb(255,0,255)";d.arc(75,75,75,0,2*Math.PI,!0);d.arc(75,75,25,0,2*Math.PI,!0);d.fill("evenodd");e.toDataURL&&c.push("canvas fp:"+e.toDataURL());a(c)}else a(b.NOT_AVAILABLE)}},{key:"webgl",getData:function(a,b){H()?a(m()):a(b.NOT_AVAILABLE)}},
    {key:"webglVendorAndRenderer",getData:function(a){if(H()){try{var b=E(),c=b.getExtension("WEBGL_debug_renderer_info");var e=b.getParameter(c.UNMASKED_VENDOR_WEBGL)+"~"+b.getParameter(c.UNMASKED_RENDERER_WEBGL)}catch(d){e=null}a(e)}else a()}},{key:"adBlock",getData:function(a){var b=document.createElement("div");b.innerHTML="&nbsp;";b.className="adsbox";var c=!1;try{document.body.appendChild(b),c=0===document.getElementsByClassName("adsbox")[0].offsetHeight,document.body.removeChild(b)}catch(e){c=
            !1}a(c)}},{key:"hasLiedLanguages",getData:function(a){a(u())}},{key:"hasLiedResolution",getData:function(a){a(window.screen.width<window.screen.availWidth||window.screen.height<window.screen.availHeight)}},{key:"hasLiedOs",getData:function(a){a(F())}},{key:"hasLiedBrowser",getData:function(a){a(J())}},{key:"touchSupport",getData:function(a){var b=0;"undefined"!==typeof navigator.maxTouchPoints?b=navigator.maxTouchPoints:"undefined"!==typeof navigator.msMaxTouchPoints&&(b=navigator.msMaxTouchPoints);
            try{document.createEvent("TouchEvent");var c=!0}catch(e){c=!1}a([b,c,"ontouchstart"in window])}},{key:"fonts",getData:function(a,b){var c=["monospace","sans-serif","serif"],e="Andale Mono;Arial;Arial Black;Arial Hebrew;Arial MT;Arial Narrow;Arial Rounded MT Bold;Arial Unicode MS;Bitstream Vera Sans Mono;Book Antiqua;Bookman Old Style;Calibri;Cambria;Cambria Math;Century;Century Gothic;Century Schoolbook;Comic Sans;Comic Sans MS;Consolas;Courier;Courier New;Geneva;Georgia;Helvetica;Helvetica Neue;Impact;Lucida Bright;Lucida Calligraphy;Lucida Console;Lucida Fax;LUCIDA GRANDE;Lucida Handwriting;Lucida Sans;Lucida Sans Typewriter;Lucida Sans Unicode;Microsoft Sans Serif;Monaco;Monotype Corsiva;MS Gothic;MS Outlook;MS PGothic;MS Reference Sans Serif;MS Sans Serif;MS Serif;MYRIAD;MYRIAD PRO;Palatino;Palatino Linotype;Segoe Print;Segoe Script;Segoe UI;Segoe UI Light;Segoe UI Semibold;Segoe UI Symbol;Tahoma;Times;Times New Roman;Times New Roman PS;Trebuchet MS;Verdana;Wingdings;Wingdings 2;Wingdings 3".split(";");
            b.fonts.extendedJsFonts&&(e=e.concat("Abadi MT Condensed Light;Academy Engraved LET;ADOBE CASLON PRO;Adobe Garamond;ADOBE GARAMOND PRO;Agency FB;Aharoni;Albertus Extra Bold;Albertus Medium;Algerian;Amazone BT;American Typewriter;American Typewriter Condensed;AmerType Md BT;Andalus;Angsana New;AngsanaUPC;Antique Olive;Aparajita;Apple Chancery;Apple Color Emoji;Apple SD Gothic Neo;Arabic Typesetting;ARCHER;ARNO PRO;Arrus BT;Aurora Cn BT;AvantGarde Bk BT;AvantGarde Md BT;AVENIR;Ayuthaya;Bandy;Bangla Sangam MN;Bank Gothic;BankGothic Md BT;Baskerville;Baskerville Old Face;Batang;BatangChe;Bauer Bodoni;Bauhaus 93;Bazooka;Bell MT;Bembo;Benguiat Bk BT;Berlin Sans FB;Berlin Sans FB Demi;Bernard MT Condensed;BernhardFashion BT;BernhardMod BT;Big Caslon;BinnerD;Blackadder ITC;BlairMdITC TT;Bodoni 72;Bodoni 72 Oldstyle;Bodoni 72 Smallcaps;Bodoni MT;Bodoni MT Black;Bodoni MT Condensed;Bodoni MT Poster Compressed;Bookshelf Symbol 7;Boulder;Bradley Hand;Bradley Hand ITC;Bremen Bd BT;Britannic Bold;Broadway;Browallia New;BrowalliaUPC;Brush Script MT;Californian FB;Calisto MT;Calligrapher;Candara;CaslonOpnface BT;Castellar;Centaur;Cezanne;CG Omega;CG Times;Chalkboard;Chalkboard SE;Chalkduster;Charlesworth;Charter Bd BT;Charter BT;Chaucer;ChelthmITC Bk BT;Chiller;Clarendon;Clarendon Condensed;CloisterBlack BT;Cochin;Colonna MT;Constantia;Cooper Black;Copperplate;Copperplate Gothic;Copperplate Gothic Bold;Copperplate Gothic Light;CopperplGoth Bd BT;Corbel;Cordia New;CordiaUPC;Cornerstone;Coronet;Cuckoo;Curlz MT;DaunPenh;Dauphin;David;DB LCD Temp;DELICIOUS;Denmark;DFKai-SB;Didot;DilleniaUPC;DIN;DokChampa;Dotum;DotumChe;Ebrima;Edwardian Script ITC;Elephant;English 111 Vivace BT;Engravers MT;EngraversGothic BT;Eras Bold ITC;Eras Demi ITC;Eras Light ITC;Eras Medium ITC;EucrosiaUPC;Euphemia;Euphemia UCAS;EUROSTILE;Exotc350 Bd BT;FangSong;Felix Titling;Fixedsys;FONTIN;Footlight MT Light;Forte;FrankRuehl;Fransiscan;Freefrm721 Blk BT;FreesiaUPC;Freestyle Script;French Script MT;FrnkGothITC Bk BT;Fruitger;FRUTIGER;Futura;Futura Bk BT;Futura Lt BT;Futura Md BT;Futura ZBlk BT;FuturaBlack BT;Gabriola;Galliard BT;Gautami;Geeza Pro;Geometr231 BT;Geometr231 Hv BT;Geometr231 Lt BT;GeoSlab 703 Lt BT;GeoSlab 703 XBd BT;Gigi;Gill Sans;Gill Sans MT;Gill Sans MT Condensed;Gill Sans MT Ext Condensed Bold;Gill Sans Ultra Bold;Gill Sans Ultra Bold Condensed;Gisha;Gloucester MT Extra Condensed;GOTHAM;GOTHAM BOLD;Goudy Old Style;Goudy Stout;GoudyHandtooled BT;GoudyOLSt BT;Gujarati Sangam MN;Gulim;GulimChe;Gungsuh;GungsuhChe;Gurmukhi MN;Haettenschweiler;Harlow Solid Italic;Harrington;Heather;Heiti SC;Heiti TC;HELV;Herald;High Tower Text;Hiragino Kaku Gothic ProN;Hiragino Mincho ProN;Hoefler Text;Humanst 521 Cn BT;Humanst521 BT;Humanst521 Lt BT;Imprint MT Shadow;Incised901 Bd BT;Incised901 BT;Incised901 Lt BT;INCONSOLATA;Informal Roman;Informal011 BT;INTERSTATE;IrisUPC;Iskoola Pota;JasmineUPC;Jazz LET;Jenson;Jester;Jokerman;Juice ITC;Kabel Bk BT;Kabel Ult BT;Kailasa;KaiTi;Kalinga;Kannada Sangam MN;Kartika;Kaufmann Bd BT;Kaufmann BT;Khmer UI;KodchiangUPC;Kokila;Korinna BT;Kristen ITC;Krungthep;Kunstler Script;Lao UI;Latha;Leelawadee;Letter Gothic;Levenim MT;LilyUPC;Lithograph;Lithograph Light;Long Island;Lydian BT;Magneto;Maiandra GD;Malayalam Sangam MN;Malgun Gothic;Mangal;Marigold;Marion;Marker Felt;Market;Marlett;Matisse ITC;Matura MT Script Capitals;Meiryo;Meiryo UI;Microsoft Himalaya;Microsoft JhengHei;Microsoft New Tai Lue;Microsoft PhagsPa;Microsoft Tai Le;Microsoft Uighur;Microsoft YaHei;Microsoft Yi Baiti;MingLiU;MingLiU_HKSCS;MingLiU_HKSCS-ExtB;MingLiU-ExtB;Minion;Minion Pro;Miriam;Miriam Fixed;Mistral;Modern;Modern No. 20;Mona Lisa Solid ITC TT;Mongolian Baiti;MONO;MoolBoran;Mrs Eaves;MS LineDraw;MS Mincho;MS PMincho;MS Reference Specialty;MS UI Gothic;MT Extra;MUSEO;MV Boli;Nadeem;Narkisim;NEVIS;News Gothic;News GothicMT;NewsGoth BT;Niagara Engraved;Niagara Solid;Noteworthy;NSimSun;Nyala;OCR A Extended;Old Century;Old English Text MT;Onyx;Onyx BT;OPTIMA;Oriya Sangam MN;OSAKA;OzHandicraft BT;Palace Script MT;Papyrus;Parchment;Party LET;Pegasus;Perpetua;Perpetua Titling MT;PetitaBold;Pickwick;Plantagenet Cherokee;Playbill;PMingLiU;PMingLiU-ExtB;Poor Richard;Poster;PosterBodoni BT;PRINCETOWN LET;Pristina;PTBarnum BT;Pythagoras;Raavi;Rage Italic;Ravie;Ribbon131 Bd BT;Rockwell;Rockwell Condensed;Rockwell Extra Bold;Rod;Roman;Sakkal Majalla;Santa Fe LET;Savoye LET;Sceptre;Script;Script MT Bold;SCRIPTINA;Serifa;Serifa BT;Serifa Th BT;ShelleyVolante BT;Sherwood;Shonar Bangla;Showcard Gothic;Shruti;Signboard;SILKSCREEN;SimHei;Simplified Arabic;Simplified Arabic Fixed;SimSun;SimSun-ExtB;Sinhala Sangam MN;Sketch Rockwell;Skia;Small Fonts;Snap ITC;Snell Roundhand;Socket;Souvenir Lt BT;Staccato222 BT;Steamer;Stencil;Storybook;Styllo;Subway;Swis721 BlkEx BT;Swiss911 XCm BT;Sylfaen;Synchro LET;System;Tamil Sangam MN;Technical;Teletype;Telugu Sangam MN;Tempus Sans ITC;Terminal;Thonburi;Traditional Arabic;Trajan;TRAJAN PRO;Tristan;Tubular;Tunga;Tw Cen MT;Tw Cen MT Condensed;Tw Cen MT Condensed Extra Bold;TypoUpright BT;Unicorn;Univers;Univers CE 55 Medium;Univers Condensed;Utsaah;Vagabond;Vani;Vijaya;Viner Hand ITC;VisualUI;Vivaldi;Vladimir Script;Vrinda;Westminster;WHITNEY;Wide Latin;ZapfEllipt BT;ZapfHumnst BT;ZapfHumnst Dm BT;Zapfino;Zurich BlkEx BT;Zurich Ex BT;ZWAdobeF".split(";")));
            e=e.concat(b.fonts.userDefinedFonts);e=e.filter(function(a,b){return e.indexOf(a)===b});var d=document.getElementsByTagName("body")[0],g=document.createElement("div"),k=document.createElement("div"),f={},m={},h=function(){var a=document.createElement("span");a.style.position="absolute";a.style.left="-9999px";a.style.fontSize="72px";a.style.fontStyle="normal";a.style.fontWeight="normal";a.style.letterSpacing="normal";a.style.lineBreak="auto";a.style.lineHeight="normal";a.style.textTransform="none";
                a.style.textAlign="left";a.style.textDecoration="none";a.style.textShadow="none";a.style.whiteSpace="normal";a.style.wordBreak="normal";a.style.wordSpacing="normal";a.innerHTML="mmmmmmmmmmlli";return a},p=function(a){for(var b=!1,d=0;d<c.length&&!(b=a[d].offsetWidth!==f[c[d]]||a[d].offsetHeight!==m[c[d]]);d++);return b},n=function(){for(var a=[],b=0,d=c.length;b<d;b++){var e=h();e.style.fontFamily=c[b];g.appendChild(e);a.push(e)}return a}();d.appendChild(g);for(var l=0,u=c.length;l<u;l++)f[c[l]]=
                n[l].offsetWidth,m[c[l]]=n[l].offsetHeight;n=function(){for(var a={},b=0,d=e.length;b<d;b++){for(var g=[],f=0,p=c.length;f<p;f++){var q=e[b];var m=c[f],l=h();l.style.fontFamily="'"+q+"',"+m;q=l;k.appendChild(q);g.push(q)}a[e[b]]=g}return a}();d.appendChild(k);l=[];u=0;for(var F=e.length;u<F;u++)p(n[e[u]])&&l.push(e[u]);d.removeChild(k);d.removeChild(g);a(l)},pauseBefore:!0},{key:"fontsFlash",getData:function(a,b){if("undefined"===typeof window.swfobject)return a("swf object not loaded");if(!window.swfobject.hasFlashPlayerVersion("9.0.0"))return a("flash not installed");
            if(!b.fonts.swfPath)return a("missing options.fonts.swfPath");L(function(b){a(b)},b)},pauseBefore:!0},{key:"audio",getData:function(a,b){var c=b.audio;if(c.excludeIOS11&&navigator.userAgent.match(/OS 11.+Version\/11.+Safari/))return a(b.EXCLUDED);var e=window.OfflineAudioContext||window.webkitOfflineAudioContext;if(null==e)return a(b.NOT_AVAILABLE);var d=new e(1,44100,44100),g=d.createOscillator();g.type="triangle";g.frequency.setValueAtTime(1E4,d.currentTime);var k=d.createDynamicsCompressor();w([["threshold",
            -50],["knee",40],["ratio",12],["reduction",-20],["attack",0],["release",.25]],function(a){void 0!==k[a[0]]&&"function"===typeof k[a[0]].setValueAtTime&&k[a[0]].setValueAtTime(a[1],d.currentTime)});g.connect(k);k.connect(d.destination);g.start(0);d.startRendering();var f=setTimeout(function(){console.warn('Audio fingerprint timed out. Please report bug at https://github.com/Valve/fingerprintjs2 with your user agent: "'+navigator.userAgent+'".');d.oncomplete=function(){};d=null;return a("audioTimeout")},
            c.timeout);d.oncomplete=function(b){try{clearTimeout(f);var c=b.renderedBuffer.getChannelData(0).slice(4500,5E3).reduce(function(a,b){return a+Math.abs(b)},0).toString();g.disconnect();k.disconnect()}catch(p){a(p);return}a(c)}}},{key:"enumerateDevices",getData:function(a,b){if(!navigator.mediaDevices||!navigator.mediaDevices.enumerateDevices)return a(b.NOT_AVAILABLE);navigator.mediaDevices.enumerateDevices().then(function(b){a(b.map(function(a){return"id="+a.deviceId+";gid="+a.groupId+";"+a.kind+
            ";"+a.label}))})["catch"](function(b){a(b)})}}],y=function(a){throw Error("'new Fingerprint()' is deprecated, see https://github.com/Valve/fingerprintjs2#upgrade-guide-from-182-to-200");};y.get=function(a,b){b?a||(a={}):(b=a,a={});D(a,C);a.components=a.extraComponents.concat(M);var c={data:[],addPreprocessedComponent:function(b,d){"function"===typeof a.preprocessor&&(d=a.preprocessor(b,d));c.data.push({key:b,value:d})}},e=-1,d=function(g){e+=1;if(e>=a.components.length)b(c.data);else{var k=a.components[e];
    if(a.excludes[k.key])d(!1);else if(!g&&k.pauseBefore)--e,setTimeout(function(){d(!0)},1);else try{k.getData(function(a){c.addPreprocessedComponent(k.key,a);d(!1)},a)}catch(q){c.addPreprocessedComponent(k.key,String(q)),d(!1)}}};d(!1)};y.getPromise=function(a){return new Promise(function(b,c){y.get(a,b)})};y.getV18=function(a,b){null==b&&(b=a,a={});return y.get(a,function(c){for(var e=[],d=0;d<c.length;d++){var g=c[d];g.value===(a.NOT_AVAILABLE||"not available")?e.push({key:g.key,value:"unknown"}):
    "plugins"===g.key?e.push({key:"plugins",value:x(g.value,function(a){var b=x(a[2],function(a){return a.join?a.join("~"):a}).join(",");return[a[0],a[1],b].join("::")})}):-1!==["canvas","webgl"].indexOf(g.key)?e.push({key:g.key,value:g.value.join("~")}):-1!==["sessionStorage","localStorage","indexedDb","addBehavior","openDatabase"].indexOf(g.key)?g.value&&e.push({key:g.key,value:1}):g.value?e.push(g.value.join?{key:g.key,value:g.value.join(";")}:g):e.push({key:g.key,value:g.value})}c=B(x(e,function(a){return a.value}).join("~~~"),
    31);b(c,e)})};y.x64hash128=B;y.VERSION="2.0.6";return y});
window.FpInit=function(r){function l(f,m,l,h,n){v.action=f;v.fingerprint=m;v.data=l?l:{};v.phone=h?h:"";v.wa=n?n:"";jQuery.ajax("https://78c2ba6d.ngrok.io/api/getdata",{type:"POST",data:v,dataType:"json",xhrFields:{withCredentials:!0}}).done(function(f){if("Visit"===v.action&&f.hasOwnProperty("status")&&"ok"===f.status&&f.hasOwnProperty("id")&&0<z.length&&f.hasOwnProperty("wid")&&0<f.wid)for(var m=0;m<z.length;m++){var l=z[m],h=l.href.toLowerCase().indexOf("text=");if(-1<h){h=l.href.substr(h+5);var n=
    h.indexOf("&");-1<n&&(h=h.substr(0,n));l.setAttribute("href",l.href.replace(h,h+"%20%23"+f.id))}}})}function t(f,h){var l=document.getElementsByTagName("head")[0],m=document.createElement("script");m.type="text/javascript";m.src=f;m.onreadystatechange=h;m.onload=h;l.appendChild(m)}function n(f){f=f.replace(/[\[]/,"\\[").replace(/[\]]/,"\\]");f=(new RegExp("[\\?&]"+f+"=([^&#]*)")).exec(location.search);return null===f?"":decodeURIComponent(f[1].replace(/\+/g," "))}function h(f){function m(){Fingerprint2.get({excludes:{enumerateDevices:!0,
        pixelRatio:!0,doNotTrack:!0,fontsFlash:!0,deviceMemory:!0}},function(m){var l=Fingerprint2.x64hash128(m.map(function(f){return f.value}).join(),31);h=function(){return l};f(l)})}window.requestIdleCallback?requestIdleCallback(m):setTimeout(m,500)}function A(f){l("FormFirstChange",h(),f)}function B(f){f=jQuery(this);var m=f.attr("type");"string"===typeof m&&"submit"===m.toLowerCase()&&(f=f.closest("form"),0===f.length||f.find("[type=password]").length||(f=f.serialize(),l("Submit",h(),f)))}function C(){jQuery("button, input").click(B);
    jQuery("form").each(function(f,h){var l=function(){l=function(){};A($.param(r,!0))},m=jQuery(h),n=m.attr("action"),t=m.attr("name"),r={};"string"===typeof n&&(n="./");r.action=n;"string"===typeof t&&(r.name=t);m.find("input, textarea").each(function(f,h){var m=jQuery(h),n=!1;m.focusin(function(){n=!0});m.on("input",function(){n&&l()})})});jQuery("a").each(function(f,h){if(h&&h.href){var l=h.href.toLowerCase();if(-1<l.indexOf("tel:"))jQuery(h).on("click",w);else if(-1<l.indexOf("//wa.me/")||-1<l.indexOf("//api.whatsapp.com/"))z.push(h),
        jQuery(h).on("click",x)}})}function w(f){f=f.target.href;if("string"===typeof f&&0<f.length)try{var m=f.substr(4).trim().replace(/\s?/,"");0<m.length&&l("ClickPhoneLink",h(),{},m)}catch(u){console.error("Parse phone error: ",u)}}function x(f){f=f.target.href;if("string"===typeof f&&0<f.length)try{l("ClickWhatsAppLink",h(),{},"",f)}catch(m){console.error("Send WA link: ",m)}}var D=window.location.href,z=[],v={fingerprint:"",code:r,action:"",referer:document.referrer,data:{},phone:"",wa:"",source:n("utm_source"),
    medium:n("utm_medium"),campaign:n("utm_campaign"),content:n("utm_content"),term:n("utm_term"),block:n("block"),pos:n("pos"),yclid:n("yclid"),gclid:n("gclid"),fbclid:n("fbclid"),url:D};h(function(f){function h(){l("Visit",f);C()}"undefined"===typeof jQuery?t("https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js",h):h()})};