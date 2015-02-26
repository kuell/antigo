
if(typeof Widgets=="undefined"){Widgets={};}
Widgets.Dialog=Class.create();Widgets.Dialog.current=null;Widgets.Dialog.hideAll=function(_1){var _2=_1.overlay||(_1.overlay=YAHOO.util.Dom.get("overlay"));if(_2){_2.parentNode.removeChild(_2);}
var _3=_1.lightbox||(_1.overlay=YAHOO.util.Dom.get("lightbox"));if(_3){_3.parentNode.removeChild(_3);}};Widgets.Dialog.prototype={htmlProvider:null,domElement:null,initialize:function(_4,_5,_6){this.title=_4||"";this.url=_5||null;Widgets.Dialog.current=this;this.options=Object.extend({lightbox_class_name:"dialog",width:400,height:300,click_outside:false,loadingMessage:"loading content..."},_6||{});this.loader=new Kore.JSLoader();this.loader.addFile("includes/jaxon/widgets/widgets.js");this.loader.addFile("includes/yui/yahoo/yahoo.js");this.loader.addFile("includes/yui/dom/dom.js");this.loader.addFile("includes/yui/event/event.js");this.loader.addFile("includes/yui/animation/animation.js");if(this.url!=null){this.loader.addFile("includes/yui/connection/connection.js");this.loader.addFile("includes/kore/js/error.js");this.loader.addFile("includes/kore/js/browser/browser.js");this.loader.addFile("includes/kore/js/dataprovider/transporter.js");this.loader.addFile("includes/kore/js/dataprovider/dataprovider.js");this.loader.addFile("includes/kore/js/dataprovider/htmlprovider.js");this.loader.addFile("includes/kore/js/dataprovider/htmlprocessor.js");}
try{this.loader.loadFiles(function(){if(!Kore.isOkForAjax()){return false;}
if(Kore.is.ie&&(Kore.is.version==6)){try{document.execCommand("BackgroundImageCache",false,true);}
catch(e){}}
Widgets.general_actions.addActions(this);this.render();}.bind(this));}
catch(e){}},render:function(){this.initializeOverlay();if(this.options.click_outside){YAHOO.util.Event.addListener(this.overlay,"click",this.hideBox,this,true);}},initializeOverlay:function(){if(!this.overlay){var _7=document.getElementsByTagName("body")[0];var _8=document.createElement("div");_8.id="overlay";_8=_7.appendChild(_8);this.overlay=_8;Kore.getIncludesBase(this.initializeLightBox,this);}},initializeLightBox:function(_9){this.includesBase=_9;var _a=document.getElementsByTagName("body")[0];var _b=document.createElement("div");_b.id="lightbox";_b.style.width=this.options.width+"px";_b.style.height=this.options.height+"px";_b.className="loading";_b.innerHTML=""+"<div class=\"titleBar\">"+"<a href=\"#\" id=\"link__lbClose\">"+"<img src=\""+this.includesBase+"includes/jaxon/widgets/dialog/img/close.gif\" alt=\"Close\" "+"title=\"Close this window\" />"+"</a>"+"<p id=\"titleText\">"+this.title+"</p>"+"<img id=\"bgLayer\" src=\""+this.includesBase+"includes/jaxon/widgets/dialog/img/gradient_tab_blue.gif\" alt=\"\""+"width=\"100%\" height=\"23\" />"+"</div>"+"<div id=\"widgetLoader\">"+"<div id=\"loader_image\">&nbsp;</div>"+"<div id=\"loader_text\">"+this.options.loadingMessage+"</div>"+"</div>"+"<div class=\"contentArea\">"+"<div id=\"widgetContent\"></div>"+"</div>";_b=_a.appendChild(_b);this.lightbox=_b;this.closeButton=YAHOO.util.Dom.get("link__lbClose");YAHOO.util.Event.addListener(this.closeButton,"click",this.hideBox,this,true);this.showBox();},showBox:function(){this.getPageSize();if(Kore.is.ie){this.getScroll();this.getViewPortDim();this.handleSelectElements("hidden");this.overlay.style.display="block";this.overlay.style.height=(this.arrayPageSize[1]+100)+"px";this.overlay.style.width=this.arrayPageSize[0]+"px";this.fade(this.lightbox,0,100);this.lightbox.style.display="block";this.center(this.yPos);}else{this.getScroll();this.getMarginTop();if(Kore.is.mozilla){this.setMarginTop((-1)*this.yPos);}
this.overlay.style.display="block";this.overlay.style.height=this.arrayPageSize[1]+"px";this.overlay.style.width=this.arrayPageSize[0]+"px";this.fade(this.lightbox,0,100);this.lightbox.style.display="block";this.center(this.yPos);}
this.loadInfo();},hideBox:function(_c){if(_c){YAHOO.util.Event.stopEvent(_c);}
Widgets.Dialog.hideAll(this);if(Kore.is.ie){this.handleSelectElements("visible");}else{if(Kore.is.mozilla){this.setMarginTop(this.yMargin);this.setScroll(0,this.yPos);}}
return false;},fade:function(el,_e,_f){var _10=this;el.style.opacity="0";var _f=new YAHOO.util.Anim(el,{opacity:{from:(_e/100),to:_f/100}},1);var hf=false;_f.onStart.subscribe(function(){el.style.visibility="hidden";hf=true;});_f.onTween.subscribe(function(){if(hf){el.style.visibility="visible";_10.closeButton.focus();_10.closeButton.hideFocus=true;hf=false;}});_f.onComplete.subscribe(function(){var _13=YAHOO.util.Dom.getElementsByClassName("titleBar","div","lightbox")[0];_13.onselectstart=function(){return false;};});_f.animate();},getScroll:function(){if(self.pageYOffset){this.yPos=self.pageYOffset;}else{if(document.documentElement&&document.documentElement.scrollTop){this.yPos=document.documentElement.scrollTop;}else{if(document.body){this.yPos=document.body.scrollTop;}}}},setScroll:function(x,y){window.scrollTo(x,y);},getMarginTop:function(){var _16=document.getElementsByTagName("html")[0];var _m=YAHOO.util.Dom.getStyle(_16,"marginTop");this.yMargin=isNaN(parseInt(_m))?0:parseInt(_m);},setMarginTop:function(_18){var _19=document.getElementsByTagName("html")[0];_19.style.marginTop=_18+"px";},getViewPortDim:function(){if(document.documentElement&&document.documentElement.clientHeight){this._vpWidth=document.documentElement.clientWidth;this._vpHeight=document.documentElement.clientHeight;}else{if(document.body){this._vpWidth=document.body.clientWidth;this._vpHeight=document.body.clientHeight;}}},setOverflow:function(_1a){var _1b=document.getElementsByTagName("body")[0];_1b.style.overflow=_1a;var _1c=document.getElementsByTagName("html")[0];_1c.style.overflow=_1a;},getPageSize:function(){var _1d,yScroll;if(window.innerHeight&&window.scrollMaxY){_1d=document.body.scrollWidth;yScroll=window.innerHeight+window.scrollMaxY;}else{if(document.body.scrollHeight>document.body.offsetHeight){_1d=document.body.scrollWidth;yScroll=document.body.scrollHeight;}else{_1d=document.body.offsetWidth;yScroll=document.body.offsetHeight;}}
var _1e,windowHeight;if(self.innerHeight){_1e=self.innerWidth;windowHeight=self.innerHeight;}else{if(document.documentElement&&document.documentElement.clientHeight){_1e=document.documentElement.clientWidth;windowHeight=document.documentElement.clientHeight;}else{if(document.body){_1e=document.body.clientWidth;windowHeight=document.body.clientHeight;}}}
if(yScroll<windowHeight){pageHeight=windowHeight;}else{pageHeight=yScroll;}
if(_1d<_1e){pageWidth=_1e;}else{pageWidth=_1d;}
this.arrayPageSize=[pageWidth,pageHeight,_1e,windowHeight];},handleSelectElements:function(_1f){if(navigator.userAgent.toLowerCase().indexOf("msie")+1){selects=document.getElementsByTagName("select");for(i=0;i<selects.length;i++){selects[i].style.visibility=_1f;}}},setUrl:function(url){this.url=url;},loadInfo:function(_21){this.domElement=YAHOO.util.Dom.get("widgetContent");this.htmlProvider=new Kore.HtmlProvider(null,this,_21);this.htmlProvider.finalizeEvent.subscribe(this.onUpdate,this,true);var url=this.url;var _23=Kore.Url.getParamsFromCurrentUrl(true);var _24=_23[1];var _25=_23[0];if(/__state/.test(_24)){if(_24!=""){url+=((/\?/.test(url))?"&":"?")+_24;}}else{if(_25!=""){url+=((/\?/.test(url))?"&":"?")+_25;}}
if(!/KT_ajax_request=true/.test(url)){url+=((/\?/.test(url))?"&":"?")+"KT_ajax_request=true";}
this.htmlProvider.URL=url;if(this.fullUrl==null){this.fullUrl=window.location.href.toString().replace(/\/[^\/]*$/,"/")+this.url;}
this.htmlProvider.getContent();},onUpdate:function(){this.lightbox.className="done";var _26=YAHOO.util.Dom.getElementsByClassName("titleBar","div","lightbox")[0];var _27=YAHOO.util.Dom.getElementsByClassName("contentArea","div","lightbox")[0];if(!_27){return;}
_27.style.height=(this.options.height-_26.offsetHeight)+"px";this.initLinks();this.initForms();},center:function(_28){this.lightbox.style.left="50%";this.lightbox.style.top="50%";var TOP=Math.round((-1)*this.options.height/2);this.lightbox.style.marginTop=((typeof _28=="number")?(TOP+_28):TOP)+"px";this.lightbox.style.marginLeft=Math.round((-1)*this.options.width/2)+"px";}};