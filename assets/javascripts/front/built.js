!function(a,b){"use strict";var c=function(d,e){var f=d.split("."),g=c.Core(),h=a,i=f.length,j=0;for(j;j<i;j++)h[f[j]]=i-1===j?g:h[f[j]]||{},h=h[f[j]];return"function"==typeof e&&(h.utils=c.utils,e.call(null,h,b)),h};c.Core=function(){var a=this,b=function(){},c=function(c){var d;return d=new b,d.$el=c,d.data=c.data(),d.utils=a.utils,d.elements=a.getDataByName(c,"element"),d.start.apply(d,arguments),d};return c.fn=c.prototype,b.prototype=c.fn,c.fn.start=function(){},c},c.getDataByName=function(a,b){var c={},d=this;return a.find("[data-"+b+"]").each(function(e,f){var g=d.utils.toDataSetName(f.dataset[b]),h="by"+d.utils.ucfirst(b);c[g]||(c[g]=a[h](f.dataset[b]))}),c},c.utils={prefix:"wpusb",getGlobalVars:function(a){return(window.WPUSBVars||{})[a]},getAjaxUrl:function(){return this.getGlobalVars("ajaxUrl")},getContext:function(){return this.getGlobalVars("context")},getLocale:function(){return this.getGlobalVars("WPLANG")},getPreviewTitles:function(){return this.getGlobalVars("previewTitles")},getPathUrl:function(a){return decodeURIComponent(a).split(/[?#]/)[0]},getTime:function(){return(new Date).getTime()},decodeUrl:function(a){return decodeURIComponent(a)},ucfirst:function(a){return this.parseName(a,/(\b[a-z])/g)},toDataSetName:function(a){return this.parseName(a,/(-)\w/g)},isMobile:function(){return/Android|webOS|iPhone|iPad|iPod|BlackBerry|Tablet OS|IEMobile|Opera Mini/i.test(navigator.userAgent)},parseName:function(a,b){return a.replace(b,function(a){return a.toUpperCase()}).replace(/-/g,"")},remove:function(a){a.fadeOut("fast",function(){a.remove()})},getId:function(a){return!!a&&document.getElementById(a)},hashStr:function(a){var b,c=0,d=0,e=a.length;if(!e)return c;for(d;d<e;d++)b=a.charCodeAt(d),c=(c<<10)-c+b,c&=c;return Math.abs(c)}},a.WPUSB=c}(window,jQuery),WPUSB("WPUSB.BuildComponents",function(a,b){a.create=function(c){var d="[data-"+a.utils.prefix+"-component]";c.findComponent(d,b.proxy(this,"_start"))},a._start=function(a){"undefined"!=typeof WPUSB.Components&&this._iterator(a)},a._iterator=function(a){var c;a.each(function(a,d){d=b(d),c=this.utils.ucfirst(this.getComponent(d)),this._callback(c,d)}.bind(this))},a.getComponent=function(a){var b=a.data(this.utils.prefix+"-component");return b?b:""},a._callback=function(a,b){var c=WPUSB.Components[a];return"function"==typeof c?void c.call(null,b):void console.log('Component "'+a+'" is not a function.')}},{}),function(a){a.fn.byElement=function(a){return this.find('[data-element="'+a+'"]')},a.fn.byAction=function(a){return this.find('[data-action="'+a+'"]')},a.fn.byReferrer=function(a){return this.find('[data-referrer="'+a+'"]')},a.fn.byComponent=function(a,b){return this.find("[data-"+b+'-component="'+a+'"]')},a.fn.addEvent=function(b,c,d){var e=d.utils.ucfirst(["_on",b,c].join("-"));this.byAction(c).on(b,a.proxy(d,e))},a.fn.findComponent=function(b,c){var d=a(this).find(b);return d.length&&"function"==typeof c&&c.call(null,d,a(this)),d.length},a.fn.isEmptyValue=function(){return!a.trim(this.val())}}(jQuery),WPUSB("WPUSB.Application",function(a,b){a.init=function(a){WPUSB.BuildComponents.create(a),WPUSB.FixedTop.create(a),WPUSB.FixedContext.create(a)}}),WPUSB("WPUSB.Components.CounterSocialShare",function(a,b){a.fn.start=function(){return this.isShareCountsDisabled()?void this.renderExtras():(this.setParams(),void this.init())},a.fn.isShareCountsDisabled=function(){return 1===this.data.disabledShareCounts},a.fn.setParams=function(){this.prefix=this.utils.prefix+"-",this.facebook=this.elements.facebook,this.twitter=this.elements.twitter,this.google=this.elements.googlePlus,this.pinterest=this.elements.pinterest,this.linkedin=this.elements.linkedin,this.tumblr=this.elements.tumblr,this.totalShare=this.elements.totalShare,this.totalCounter=0,this.facebookCounter=0,this.twitterCounter=0,this.googleCounter=0,this.linkedinCounter=0,this.pinterestCounter=0,this.tumblrCounter=0,this.max=6},a.fn.init=function(){this.renderExtras(),this.addEventListeners(),this.request()},a.fn.addEventListeners=function(){this.$el.addEvent("click","open-popup",this),WPUSB.ToggleButtons.create(this.$el.data("element"),this)},a.fn.request=function(){this.items=[{reference:"facebookCounter",element:"facebook",url:"https://graph.facebook.com/?id="+this.data.elementUrl},{reference:"twitterCounter",element:"twitter",url:"https://public.newsharecounts.com/count.json?url="+this.data.elementUrl},{reference:"tumblrCounter",element:"tumblr",url:"https://api.tumblr.com/v2/share/stats?url="+this.data.elementUrl},{reference:"googleCounter",element:"google",url:"https://clients6.google.com/rpc",data:this.getParamsGoogle(),method:"POST",dataType:"json",processData:!0,contentType:"application/json"},{reference:"linkedinCounter",element:"linkedin",url:"https://www.linkedin.com/countserv/count/share?url="+this.data.elementUrl},{reference:"pinterestCounter",element:"pinterest",url:"https://api.pinterest.com/v1/urls/count.json?url="+this.data.elementUrl}],this._eachAjaxSocial()},a.fn._eachAjaxSocial=function(){this.items.forEach(this._iterateItems.bind(this))},a.fn._iterateItems=function(a,b){var c=0;this.totalShare&&this.totalShare.text(c),this[a.element]&&this[a.element].text(c),this._getJSON(a)},a.fn._getJSON=function(a){var c=b.extend({dataType:"jsonp"},a),d=b.ajax(c);d.done(b.proxy(this,"_done",a)),d.fail(b.proxy(this,"_fail",a))},a.fn._done=function(a,b){var c=this.getNumberByData(a.element,b);this[a.reference]=c,this.max-=1,this.totalCounter+=c,this[a.element]&&this[a.element].text(this.formatCounts(c)),!this.max&&this.totalShare&&this.totalShare.text(this.formatCounts(this.totalCounter))},a.fn._fail=function(a,b,c){this[a.reference]=0,this[a.element]&&this[a.element].text(0)},a.fn.getNumberByData=function(a,b){switch(a){case"facebook":return this.getTotalShareFacebook(b.share);case"tumblr":return this.getTotalShareTumblr(b.response);case"google":return this.getTotalShareGooglePlus(b);default:return parseInt(b.count)||0}},a.fn.getTotalShareGooglePlus=function(a){var b={};return"object"==typeof a.error?(console.log("Google+ count error: "+a.error.message),0):"object"==typeof a.result?(b.metadata=a.result.metadata||{},b.globalCounts=b.metadata.globalCounts||{},parseInt(b.globalCounts.count)):(console.log("Google+ count fail"),0)},a.fn.getTotalShareFacebook=function(a){return"object"==typeof a?parseInt(a.share_count):0},a.fn.getTotalShareTumblr=function(a){return"object"==typeof a?parseInt(a.note_count):0},a.fn.getParamsGoogle=function(){return JSON.stringify({id:this.utils.decodeUrl(this.data.elementUrl),key:"p",method:"pos.plusones.get",jsonrpc:"2.0",apiVersion:"v1",params:{nolog:!0,id:this.utils.decodeUrl(this.data.elementUrl),source:"widget",userId:"@viewer",groupId:"@self"}})},a.fn._onClickOpenPopup=function(a){if(!this.data.report){var c={action:"wpusb_share_count_reports",reference:this.data.attrReference,count_facebook:this.facebookCounter,count_twitter:this.twitterCounter,count_google:this.googleCounter,count_linkedin:this.linkedinCounter,count_pinterest:this.pinterestCounter,count_tumblr:this.tumblrCounter,nonce:this.data.attrNonce};b.ajax({method:"POST",url:this.utils.getAjaxUrl(),data:c})}},a.fn.formatCounts=function(a){switch(this.c=a.toString(),Math.pow(10,this.c.length-1)){case 1e8:return this.t(3)+this.i(3,4)+"M";case 1e7:return this.t(2)+this.i(2,3)+"M";case 1e6:return this.t(1)+this.i(1,2)+"M";case 1e5:return this.t(3)+this.i(4,3)+"K";case 1e4:return this.t(2)+this.i(2,3)+"K";case 1e3:return this.t(1)+this.i(1,2)+"K";default:return a}},a.fn.t=function(a){return this.c.substring(0,a)},a.fn.i=function(a,b){var c=this.c.substring(a,b);return c&&"0"!==c?"."+c:""},a.fn.renderExtras=function(){WPUSB.FeaturedReferrer.create(this.$el),WPUSB.OpenPopup.create(this.$el)}}),WPUSB("WPUSB.Components.ButtonsSection",function(a,b){var c={};a.fn.start=function(){this.prefix="."+this.utils.prefix,this.id=this.$el.find(this.prefix+"-share a").data("modal-id"),this.modalId=this.utils.prefix+"-modal-container-"+this.id,this.maskId=this.utils.prefix+"-modal-"+this.id,this.init()},a.fn.init=function(){this.setModal(),this.setMask(),WPUSB.OpenPopup.create(this.modal),this.addEventListener(),c[this.id]=!0},a.fn.setModal=function(){var a=this.$el.byElement(this.modalId);c[this.id]||WPUSB.vars.body.append(a.clone()),a.show(),this.modal=WPUSB.vars.body.byElement(this.modalId),this.close=this.modal.find(this.prefix+"-btn-close"),this.setSizes(),this.setPosition(),a.remove()},a.fn.setMask=function(){var a=this.$el.byElement(this.maskId);c[this.id]||WPUSB.vars.body.append(a.clone()),this.mask=WPUSB.vars.body.byElement(this.maskId),a.remove()},a.fn.addEventListener=function(){this.mask.addEvent("click","close-popup",this),this.mask.on("click",this._onClickClosePopup.bind(this)),this.$el.on("click",'[data-modal-id="'+this.id+'"]',this._onClickOpenModalNetworks.bind(this))},a.fn._onClickClosePopup=function(a){a.preventDefault(),this.closeModal()},a.fn._onClickOpenModalNetworks=function(a){a.preventDefault(),this.openModal()},a.fn.setSizes=function(){this.setTop(),this.setLeft()},a.fn.closeModal=function(){this.mask.css("opacity",0),this.mask.hide(),this.modal.hide()},a.fn.openModal=function(){this.mask.css("opacity",1),this.mask.show(),this.modal.show()},a.fn.setTop=function(){var a=.5*window.innerHeight,b=.5*this.modal.height(),c=a-b;this.btnTop=c-20+"px",this.top=c+"px"},a.fn.setLeft=function(){var a=.5*window.innerWidth,b=.5*this.modal.width(),c=a-b;this.btnRight=c-40+"px",this.left=c+"px"},a.fn.setPosition=function(){this.modal.css({top:this.top,left:this.left}),this.close.css({top:this.btnTop,right:this.btnRight})}}),WPUSB("WPUSB.FeaturedReferrer",function(a,b){a.create=function(a){this.prefix=this.utils.prefix+"-",this.$el=a,this.init()},a.init=function(){this.$el.attr("class").match("-fixed")||this.setReferrer()},a.setReferrer=function(){return this.isMatch("twitter")||this.isMatch("t")?void this.showReferrer("twitter"):this.isMatch("google")?void this.showReferrer("google-plus"):this.isMatch("facebook")?void this.showReferrer("facebook"):void(this.isMatch("linkedin")&&this.showReferrer("linkedin"))},a.showReferrer=function(a){var b=this.prefix+"referrer",c=this.$el.byReferrer(a);this.$el.find("."+this.prefix+"count").remove(),this.$el.find("."+this.prefix+"counter").remove(),this.$el.prepend(c),c.addClass(b),this.refTitle(c)},a.refTitle=function(a){if(!a.find("span[data-title]").length){var b='<span data-title="'+a.data("ref-title")+'"></span>';a.find("a").append(b)}},a.isMatch=function(a){var b=document.referrer,c=new RegExp("^https?://([^/]+\\.)?"+a+"\\.com?(/|$)","i");return b.match(c)}},{}),WPUSB("WPUSB.FixedContext",function(a,b){a.create=function(a){this.$el=a.find("#"+this.utils.prefix+"-container-fixed"),this.id=this.utils.getContext(),this.id&&this.$el.length&&this.init()},a.init=function(){this.setContext(),this.context&&(this.setRect(),this.setLeft(this.rect.left),this.alignButtons())},a.setContext=function(){this.context=this.getElement()},a.setRect=function(){this.rect=this.context.getBoundingClientRect(),this.top=this.rect.top},a.setLeft=function(a){this.left=a-this.$el.width()},a.alignButtons=function(){this.$el.byAction("close-buttons").remove(),this.changeClass(),this.$el.css("left",this.left),this.setLeftMobile()},a.setLeftMobile=function(){window.innerWidth>769||this.$el.css("left","initial")},a.changeClass=function(){var a=this.utils.prefix;this.$el.hasClass(a+"-fixed-left")||(this.$el.removeClass(a+"-fixed-right"),this.$el.addClass(a+"-fixed-left"))},a.getElement=function(){var a=this.id.replace(/[^A-Z0-9a-z-_]/g,""),b=this.utils.getId(a);return b?"":this.addNotice(b,a),b},a.addNotice=function(a,b){a||console.log("WPUSB: ID ("+b+") not found")}},{}),WPUSB("WPUSB.FixedTop",function(a,b){a.create=function(a){this["class"]=WPUSB.vars.prefix+"-fixed-top",this.$el=a.byElement(this["class"]),this.$el.length&&(this.$el=b(this.$el.get(0)),this.init())},a.init=function(){this.scroll=this.$el.get(0).getBoundingClientRect(),this.isInvalidScroll()&&(this.scroll["static"]=300),this.context=window,this.addEventListener()},a.addEventListener=function(){b(this.context).scroll(this._setPositionFixed.bind(this))},a._setPositionFixed=function(){var a=this.scroll["static"]||this.scroll.top;return b(this.context).scrollTop()>a?void this.$el.addClass(this["class"]):void this.$el.removeClass(this["class"])},a.isInvalidScroll=function(){return 1>this.scroll.top}},{}),WPUSB("WPUSB.OpenPopup",function(a,b){a.create=function(a){this.$el=a,this.init()},a.init=function(){return this.utils.isMobile()?this.setMessengerUrl():void this.addEventListener()},a.addEventListener=function(){this.$el.addEvent("click","open-popup",this)},a._onClickOpenPopup=function(a){a.preventDefault();var b=jQuery(a.currentTarget),c="685",d="500";this.popupCenter(b.attr("href"),"Share",c,d)},a.popupCenter=function(a,b,c,d){var e,f;return c=c||screen.width,d=d||screen.height,e=.5*screen.width-.5*c,f=.5*screen.height-.5*d,window.open(a,b,"menubar=no,toolbar=no,status=no,width="+c+",height="+d+",toolbar=no,left="+e+",top="+f)},a.setMessengerUrl=function(){var a=this.$el.find("[data-messenger-mobile]");a.length&&a.attr("href",a.data("messenger-mobile"))}},{}),WPUSB("WPUSB.ToggleButtons",function(a,b){a.create=function(a,b){"fixed"===a&&(this.$el=b.$el,this.buttons=b.elements.buttons,this.prefix=this.utils.prefix+"-",this.init())},a.init=function(){this.addEventListener()},a.addEventListener=function(){this.$el.addEvent("click","close-buttons",this)},a._onClickCloseButtons=function(a){var c=this.prefix+"icon-right",d=this.prefix+"toggle-active";this.buttons.toggleClass(this.prefix+"buttons-hide"),b(a.currentTarget).toggleClass(c+" "+d),a.preventDefault()}}),jQuery(function(a){var b=a("body");WPUSB.vars={body:b,prefix:"wpusb"},WPUSB.Application.init.apply(WPUSB.utils,[b])});