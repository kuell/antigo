
if(typeof Widgets=="undefined"){Widgets={};}
Widgets.Tabset=Class.create();Widgets.Tabset.prototype={activeElement:-1,shownElement:-1,loadedElements:[],htmlProvider:null,domElement:null,defaultOptions:{method:"get"},detectStyle:function(){var s=YAHOO.util.Dom.get(this.id).getAttribute("style");if(typeof s=="undefined"||s==null){this.options.has_width=false;this.options.has_height=false;}else{if(typeof s=="object"){s=s.cssText;}else{s=s.toString();}
this.options.has_width=s.match(/width\s*:/i);this.options.has_height=s.match(/height\s*:/i);}},initialize:function(id,_3,_4){this.id=id;this.urls=_3||null;this.options=Object.extend({method:"get",dimensions:{},has_width:false,has_height:false},_4||{});var _5=new Kore.JSLoader();_5.addFile("includes/jaxon/widgets/widgets.js");_5.addFile("includes/yui/yahoo/yahoo.js");_5.addFile("includes/yui/dom/dom.js");_5.addFile("includes/yui/event/event.js");_5.addFile("includes/yui/animation/animation.js");_5.addFile("includes/kore/js/browser/browser.js");if(this.urls!=null){_5.addFile("includes/yui/connection/connection.js");_5.addFile("includes/kore/js/error.js");_5.addFile("includes/kore/js/dataprovider/transporter.js");_5.addFile("includes/kore/js/dataprovider/dataprovider.js");_5.addFile("includes/kore/js/dataprovider/htmlprovider.js");_5.addFile("includes/kore/js/dataprovider/htmlprocessor.js");}
try{_5.loadFiles(function(){if(!Kore.isOkForAjax()){return false;}
if(Kore.is.ie&&(Kore.is.version==6)){try{document.execCommand("BackgroundImageCache",false,true);}
catch(e){}}
Widgets.general_actions.addActions(this);Kore.addUnloadListener(this.unload,this);this.render();}.bind(this));_5=null;}
catch(e){}},unload:function(){delete this.htmlProvider;},render:function(){if(!YAHOO.util.Dom.get(this.id).offsetHeight){var _6=this;window.setTimeout(function(){this.render();}.bind(this),10);return;}
this.loadedElements=[];if(this.urls!=null){this.htmlProvider=new Kore.HtmlProvider(null,this);this.htmlProvider.finalizeEvent.subscribe(this.onUpdate,this,true);}
YAHOO.util.Dom.removeClass(this.id,"phprendering");YAHOO.util.Dom.removeClass(this.id,"htmlrendering");this.detectStyle();if(this.options.has_width){this.options.dimensions.width=parseInt(YAHOO.util.Dom.getStyle(this.id,"width"),10);}
if(this.options.has_height){this.options.dimensions.height=parseInt(YAHOO.util.Dom.getStyle(this.id,"height"),10);}
var _7=YAHOO.util.Dom.getElementsByClassName("tabset_tabs","ul",YAHOO.util.Dom.get(this.id))[0];this.title_height=parseInt(_7.offsetHeight,10);var _8=_7.getElementsByTagName("li");for(var i=0;i<_8.length;i++){if(!this.urls||this.urls==null){this.loadedElements.push(i);}
_8[i].setAttribute("tab_number",i);_8[i].id=this.id+"tab"+i;if(YAHOO.util.Dom.hasClass(_8[i],"selected")){this.loadedElements.push(i);this.activeElement=this.shownElement=i;}
var _a=_8[i].getElementsByTagName("a")[0];try{_a.hideFocus=true;}
catch(e){}
YAHOO.util.Event.addListener(_a,"click",this.showElementEvt,this,true);if(this.options.has_width){YAHOO.util.Dom.get(this.id+"tab"+i+"-body").style.width=this.options.dimensions.width+"px";}
if(this.options.has_height){YAHOO.util.Dom.get(this.id+"tab"+i+"-body").style.height=this.options.dimensions.height-this.title_height+"px";}}
if(Kore.is.ie&&(Kore.is.version==6)){window.setTimeout(function(){for(var i=0;i<_8.length;i++){if(/selected/.test(_8[i].className)){_8[i].style.position="relative";}}},0);}},animateShow:function(){YAHOO.util.Dom.removeClass(YAHOO.util.Dom.get(this.id+"tab"+this.shownElement),"selected");YAHOO.util.Dom.removeClass(YAHOO.util.Dom.get(this.id+"tab"+this.shownElement+"-body"),"body_active");YAHOO.util.Dom.addClass(YAHOO.util.Dom.get(this.id+"tab"+this.activeElement),"selected");var _c=YAHOO.util.Dom.get(this.id+"tab"+this.activeElement+"-body");var _d=YAHOO.util.Dom.getElementsByClassName("tabContent","div",_c)[0];this.fade(_d);YAHOO.util.Dom.addClass(YAHOO.util.Dom.get(this.id+"tab"+this.activeElement+"-body"),"body_active");this.shownElement=this.activeElement;},showElement:function(_e){this.activeElement=_e;if(this.shownElement==this.activeElement){return;}
if(this.activeElement>=0){if(!this.loadedElements.include(this.activeElement)){YAHOO.util.Dom.addClass(YAHOO.util.Dom.get(this.id+"tab"+this.activeElement).getElementsByTagName("a")[0],"loading");var _f=this;var _10=YAHOO.util.Dom.get(_f.id+"tab"+_f.activeElement+"-body");this.domElement=YAHOO.util.Dom.getElementsByClassName("tabContent","div",_10)[0];this.loadInfo();}else{this.animateShow();}}},setUrl:function(url){this.urls[this.activeElement]=url;},loadInfo:function(_12){this.htmlProvider=new Kore.HtmlProvider(null,this,_12);this.htmlProvider.finalizeEvent.subscribe(this.onUpdate,this,true);var url=this.urls[this.activeElement];var _14=Kore.Url.getParamsFromCurrentUrl(true);var _15=_14[1];var _16=_14[0];if(/__state/.test(_15)){if(_15!=""){url+=((/\?/.test(url))?"&":"?")+_15;}}else{if(_16!=""){url+=((/\?/.test(url))?"&":"?")+_16;}}
if(!/KT_ajax_request=true/.test(url)){url+=((/\?/.test(url))?"&":"?")+"KT_ajax_request=true";}
this.htmlProvider.URL=url;if(this.fullUrl==null){this.fullUrl=window.location.href.toString().replace(/\/[^\/]*$/,"/")+this.urls[this.activeElement];}
this.htmlProvider.getContent();},fade:function(el,_18,end){if(Kore.is.safari){el.style.visibility="visible";return;}
if(typeof _18!="number"){_18=0;}
if(typeof end!="number"){end=100;}
var _1a=this;if(Kore.is.ie){var pel=el;var bg="";var _1d="";if(pel.currentStyle){_1d=pel.currentStyle.backgroundColor;}
while(pel){if(pel.currentStyle){bg=pel.currentStyle.backgroundColor;if(bg!=""&&bg!="transparent"){break;}}
pel=pel.parentElement;}
if(bg=="transparent"){bg="";}
YAHOO.util.Dom.setStyle(el,"background-color",bg||"#FFF");}
el.style.opacity="0";var _f=new YAHOO.util.Anim(el,{opacity:{from:(_18/100),to:(end/100)}},1);if(Kore.is.ie&&Kore.is.v<7){_f.onComplete.subscribe(function(){el.style.filter="";YAHOO.util.Dom.setStyle(el,"background-color",_1d);},this,true);}
var hf=false;_f.onStart.subscribe(function(){el.style.visibility="hidden";hf=true;});_f.onTween.subscribe(function(){if(hf){el.style.visibility="visible";hf=false;}});_f.animate();},onUpdate:function(){this.animateShow();this.loadedElements.push(this.activeElement);YAHOO.util.Dom.removeClass(YAHOO.util.Dom.get(this.id+"tab"+this.activeElement).getElementsByTagName("a")[0],"loading");this.initLinks();this.initForms();},showElementEvt:function(e){var el=YAHOO.util.Event.getTarget(e,false);this.showElement(parseInt(el.parentNode.getAttribute("tab_number"),10));YAHOO.util.Event.stopEvent(e);return false;}};function tabset_showTab(e,_23,_24){window[_23].showElement(_24);YAHOO.util.Event.stopEvent(e);}