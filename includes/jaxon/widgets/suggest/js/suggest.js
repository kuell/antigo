
if(typeof Widgets=="undefined"){Widgets={};}
Widgets.Suggest=Class.create();Widgets.Suggest.prototype={initialize:function(id,_2,_3){this.id=id;this.input_field=_2;this.options=_3;var _4=new Kore.JSLoader();_4.addFile("includes/yui/yahoo/yahoo.js");_4.addFile("includes/yui/dom/dom.js");_4.addFile("includes/yui/event/event.js");_4.addFile("includes/yui/connection/connection.js");_4.addFile("includes/yui/animation/animation.js");_4.addFile("includes/yui/autocomplete/autocomplete.js");_4.addFile("includes/kore/js/error.js");_4.addFile("includes/kore/js/browser/browser.js");_4.addFile("includes/kore/js/dataprovider/transporter.js");_4.addFile("includes/kore/js/dataprovider/dataprovider.js");_4.addFile("includes/kore/js/dataprovider/jsonprovider.js");_4.loadFiles(function(){if(!Kore.isOkForAjax()){return false;}
this.render();}.bind(this));},render:function(){if(!YAHOO.util.Dom.get(this.input_field)){var _5=this;window.setTimeout(function(){_5.initialize(this.input_field,this.options);},10);return;}
var _5=this;this.relId=this.input_field+"_choices";this.fDScallback=function(a,b,_8){if(_8&&_8.content&&_8.content.choices){var _9=[];for(var i=0;i<_8.content.choices.length;i++){var _b=_8.content.choices[i];_9.push(new Array(_b));}
_5.oAutoComp._populateList(this.lastUserInput,_9,_5.oAutoComp);}};this.oACDS=new YAHOO.widget.DS_JSFunction(function(_c){this.lastUserInput=unescape(_c);window[this.id+"_getSuggestedEntries"]("{\""+_5.id+"_choice\":\""+this.lastUserInput+"\"}",_5.fDScallback.bind(this));}.bind(this));this.oAutoComp=new YAHOO.widget.AutoComplete(this.input_field,this.input_field+"_choices",this.oACDS,{alwaysShowContainer:false,useIFrame:false,queryDelay:0.2,maxResultsDisplayed:this.options["numberOfSuggestions"],allowBrowserAutocomplete:false});this.oAutoComp.formatResult=function(_d){var _e=this.lastUserInput.replace(/\\/g,"");_e=_e.replace(/([^\w\s])/g,"\\"+"$1");_e=_e.replace(/\s/g,"\\"+"s");var _f=_d[0];var REG=new RegExp(("^("+_e)+")","i");var _11=_f.replace(REG,"<em>$1</em>");return _11;}.bind(this);this.oAutoComp.containerExpandEvent.subscribe(this.onContainerExpand,this,true);this.oAutoComp.containerCollapseEvent.subscribe(this.onContainerCollapse,this,true);},onContainerExpand:function(){var _12=YAHOO.util.Dom.get(this.input_field);var _13=YAHOO.util.Region.getRegion(_12);YAHOO.util.Dom.setStyle(this.oAutoComp._oContainer,"display","block");YAHOO.util.Dom.setStyle(this.oAutoComp._oContainer,"visibility","visible");YAHOO.util.Dom.setXY(this.oAutoComp._oContainer,[_13.left,_13.bottom-1]);},onContainerCollapse:function(){YAHOO.util.Dom.setStyle(this.oAutoComp._oContainer,"visibility","hidden");}};