!function(a,b){"use strict";var c=function(d,e){var f=d.split("."),g=c.instantiate(),h=a,i=f.length,j=0;for(j;j<i;j++)h[f[j]]=i-1===j?g:h[f[j]]||{},h=h[f[j]];return"function"==typeof e&&e.call(null,h,b,c.utils),h};c.instantiate=function(){var a=function(){},b=function(b){var d,e={};return d=new a,d.$el=b,d.data=b.data(),b.find("[data-element]").each(function(a,d){var f=c.utils.ucfirst(d.dataset.element);e[f]||(e[f]=b.byElement(d.dataset.element))}),d.elements=e,d.start.apply(d,arguments),d};return b.fn=b.prototype,a.prototype=b.fn,b.fn.start=function(){},b},c.utils={prefix:"wpusb",ucfirst:function(a){return a=a.replace(/(?:-)\w/g,function(a){return a.toUpperCase()}),a.replace(/-/g,"")},getAjaxUrl:function(){return(window.WPUSBVars||{}).ajaxUrl},getContext:function(){return(window.WPUSBVars||{}).context},getLocale:function(){return(window.WPUSBVars||{}).WPLANG},getPreviewTitles:function(){return(window.WPUSBVars||{}).previewTitles},getPathUrl:function(a){var b=decodeURIComponent(a);return b.split(/[?#]/)[0]},getTime:function(){return(new Date).getTime()},hashStr:function(a){var b,c=0,d=0;if(!a.length)return c;for(d;d<a.length;d++)b=a.charCodeAt(d),c=(c<<10)-c+b,c&=c;return Math.abs(c)},decodeUrl:function(a){return decodeURIComponent(a)}},a.WPUSB=c}(window,jQuery),WPUSB("WPUSB.BuildComponents",function(a,b,c){a.create=function(a){var d="[data-"+c.prefix+"-component]";a.findComponent(d,b.proxy(this,"_start"))},a._start=function(a){"undefined"!=typeof WPUSB.Components&&this._iterator(a)},a._iterator=function(a){var c;a.each(function(d,e){e=b(e),c=a.ucfirst(this.getComponent(e)),this._callback(c,e)}.bind(this))},a.getComponent=function(a){var b=a.data(c.prefix+"-component");return b?b:""},a._callback=function(a,b){var c=WPUSB.Components[a];return"function"==typeof c?void c.call(null,b):void console.warn('Component "'+a+'" is not a function.')}},{}),function(a){a.fn.byElement=function(a){return this.find('[data-element="'+a+'"]')},a.fn.byAction=function(a){return this.find('[data-action="'+a+'"]')},a.fn.byReferrer=function(a){return this.find('[data-referrer="'+a+'"]')},a.fn.byComponent=function(a,b){return this.find("[data-"+b+'-component="'+a+'"]')},a.fn.findComponent=function(b,c){var d=a(this).find(b);return d.length&&"function"==typeof c&&c.call(null,d,a(this)),d.length},a.fn.ucfirst=function(a){return a=a.replace(/(?:^|-)\w/g,function(a){return a.toUpperCase()}),a.replace(/-/g,"")},a.fn.addEvent=function(b,c,d){var e=a.fn.ucfirst(["_on",b,c].join("-"));this.byAction(c).on(b,a.proxy(d,e))}}(jQuery),WPUSB("WPUSB.Application",function(a,b){a.init=function(a){WPUSB.BuildComponents.create(a),WPUSB.FixedTop.create(a)}}),WPUSB("WPUSB.Components.CounterSocialShare",function(a,b,c){a.fn.start=function(){this.isShareCountsDisabled()||(this.setParams(),this.init())},a.fn.isShareCountsDisabled=function(){return 1===this.data.disabledShareCounts},a.fn.setParams=function(){this.prefix=c.prefix+"-",this.facebook=this.elements.facebook,this.twitter=this.elements.twitter,this.google=this.elements.googlePlus,this.pinterest=this.elements.pinterest,this.linkedin=this.elements.linkedin,this.tumblr=this.elements.tumblr,this.totalShare=this.elements.totalShare,this.totalCounter=0,this.facebookCounter=0,this.twitterCounter=0,this.googleCounter=0,this.linkedinCounter=0,this.pinterestCounter=0,this.tumblrCounter=0,this.max=6},a.fn.init=function(){WPUSB.FeaturedReferrer.create(this.$el),WPUSB.OpenPopup.create(this.$el),WPUSB.FixedContext.create(this.$el),this.addEventListeners(),this.request()},a.fn.addEventListeners=function(){this.$el.addEvent("click","open-popup",this),WPUSB.ToggleButtons.create(this.$el.data("element"),this.$el)},a.fn.request=function(){this.items=[{reference:"facebookCounter",element:"facebook",url:"https://graph.facebook.com/?id="+this.data.elementUrl},{reference:"twitterCounter",element:"twitter",url:"https://public.newsharecounts.com/count.json?url="+this.data.elementUrl},{reference:"tumblrCounter",element:"tumblr",url:"https://api.tumblr.com/v2/share/stats?url="+this.data.elementUrl},{reference:"googleCounter",element:"google",url:"https://clients6.google.com/rpc",data:this.getParamsGoogle(),method:"POST",dataType:"json",processData:!0,contentType:"application/json"},{reference:"linkedinCounter",element:"linkedin",url:"https://www.linkedin.com/countserv/count/share?url="+this.data.elementUrl},{reference:"pinterestCounter",element:"pinterest",url:"https://api.pinterest.com/v1/urls/count.json?url="+this.data.elementUrl}],this._eachAjaxSocial()},a.fn._eachAjaxSocial=function(){this.items.forEach(this._iterateItems.bind(this))},a.fn._iterateItems=function(a,b){var c=0;this.totalShare&&this.totalShare.text(c),this[a.element]&&this[a.element].text(c),this._getJSON(a)},a.fn._getJSON=function(a){var c=b.extend({dataType:"jsonp"},a),d=b.ajax(c);d.done(b.proxy(this,"_done",a)),d.fail(b.proxy(this,"_fail",a))},a.fn._done=function(a,b){var c=this.getNumberByData(a.element,b);this[a.reference]=c,this.max-=1,this.totalCounter+=c,this[a.element]&&this[a.element].text(this.formatCounts(c)),!this.max&&this.totalShare&&this.totalShare.text(this.formatCounts(this.totalCounter))},a.fn._fail=function(a,b,c){this[a.reference]=0,this[a.element]&&this[a.element].text(0)},a.fn.getNumberByData=function(a,b){switch(a){case"facebook":return this.getTotalShareFacebook(b.share);case"tumblr":return this.getTotalShareTumblr(b.response);case"google":return this.getTotalShareGooglePlus(b);default:return parseInt(b.count)||0}},a.fn.getTotalShareGooglePlus=function(a){var b={};return"object"==typeof a.error?(console.log("Google+ count error: "+a.error.message),0):"object"==typeof a.result?(b.metadata=a.result.metadata||{},b.globalCounts=b.metadata.globalCounts||{},parseInt(b.globalCounts.count)):(console.log("Google+ count fail"),0)},a.fn.getTotalShareFacebook=function(a){return"object"==typeof a?parseInt(a.share_count):0},a.fn.getTotalShareTumblr=function(a){return"object"==typeof a?parseInt(a.note_count):0},a.fn.getParamsGoogle=function(){return JSON.stringify({id:c.decodeUrl(this.data.elementUrl),key:"p",method:"pos.plusones.get",jsonrpc:"2.0",apiVersion:"v1",params:{nolog:!0,id:c.decodeUrl(this.data.elementUrl),source:"widget",userId:"@viewer",groupId:"@self"}})},a.fn._onClickOpenPopup=function(a){if(!this.data.report){var d={action:"wpusb_share_count_reports",reference:this.data.attrReference,count_facebook:this.facebookCounter,count_twitter:this.twitterCounter,count_google:this.googleCounter,count_linkedin:this.linkedinCounter,count_pinterest:this.pinterestCounter,count_tumblr:this.tumblrCounter,nonce:this.data.attrNonce};b.ajax({method:"POST",url:c.getAjaxUrl(),data:d})}},a.fn.formatCounts=function(a){switch(this.c=a.toString(),Math.pow(10,this.c.length-1)){case 1e8:return this.t(3)+this.i(3,4)+"M";case 1e7:return this.t(2)+this.i(2,3)+"M";case 1e6:return this.t(1)+this.i(1,2)+"M";case 1e5:return this.t(3)+this.i(4,3)+"K";case 1e4:return this.t(2)+this.i(2,3)+"K";case 1e3:return this.t(1)+this.i(1,2)+"K";default:return a}},a.fn.t=function(a){return this.c.substring(0,a)},a.fn.i=function(a,b){var c=this.c.substring(a,b);return c&&"0"!==c?"."+c:""}}),WPUSB("WPUSB.Components.SocialModal",function(a,b,c){var d=[];a.fn.start=function(){this.prefix="."+c.prefix,this.body=WPUSB.vars.body,this.modal=this.body.find(this.prefix+"-modal-networks"),this.close=this.modal.find(this.prefix+"-btn-close"),this.init()},a.fn.init=function(){WPUSB.OpenPopup.create(this.modal),this.modal.show(),this.addEventListener(),this.setSizes(),this.setPosition(),this.modal.hide()},a.fn.addEventListener=function(){this.$el.addEvent("click","close-popup",this),this.$el.on("click",this._onClickMask.bind(this)),this.body.addEvent("click","open-modal-networks",this)},a.fn._onClickClosePopup=function(a){a.preventDefault(),this.closeModal()},a.fn._onClickMask=function(a){a.preventDefault(),this.closeModal()},a.fn._onClickOpenModalNetworks=function(a){a.preventDefault(),this.renderLinksUrl(a),this.openModal()},a.fn.renderLinksUrl=function(a){if(this.body.hasClass("home")){var c=b(a.currentTarget).closest(this.prefix),e=c.data(),f=this.modal.find(this.prefix+"-button-popup");f.each(function(a,b){d[a]||(d[a]=this.href),this.href=this.href.replace(/_permalink_/g,e.elementUrl).replace(/_title_/g,e.elementTitle)})}},a.fn.setSizes=function(){this.setTop(),this.setLeft()},a.fn.closeModal=function(){if(this.$el.css("opacity",0),this.$el.hide(),this.modal.hide(),this.body.hasClass("home")){var a=this.modal.find(this.prefix+"-button-popup");a.each(function(a,b){this.href=d[a]})}},a.fn.openModal=function(){this.$el.css("opacity",1),this.$el.show(),this.modal.show()},a.fn.setTop=function(){var a=.5*window.innerHeight,b=.5*this.modal.height(),c=a-b;this.btnTop=c-20+"px",this.top=c+"px"},a.fn.setLeft=function(){var a=.5*window.innerWidth,b=.5*this.modal.width(),c=a-b;this.btnRight=c-40+"px",this.left=c+"px"},a.fn.setPosition=function(){this.modal.css({top:this.top,left:this.left}),this.close.css({top:this.btnTop,right:this.btnRight})}}),WPUSB("WPUSB.FeaturedReferrer",function(a,b,c){a.create=function(a){this.prefix=WPUSB.vars.prefix+"-",this.$el=a,this.init()},a.init=function(){this.$el.attr("class").match("-fixed")||this.setReferrer()},a.setReferrer=function(){return this.isMatch("twitter")||this.isMatch("t")?void this.showReferrer("twitter"):this.isMatch("google")?void this.showReferrer("google-plus"):this.isMatch("facebook")?void this.showReferrer("facebook"):void(this.isMatch("linkedin")&&this.showReferrer("linkedin"))},a.showReferrer=function(a){var b=this.prefix+"referrer",c=this.$el.byReferrer(a);this.$el.find("."+this.prefix+"count").hide(),c.addClass(b),c.addClass(b+"-"+a),this.refTitle(c)},a.refTitle=function(a){if(!a.find("span[data-title]").length){var b='<span data-title="'+a.data("ref-title")+'"></span>';a.find("a").append(b)}},a.isMatch=function(a){var b=document.referrer,c=new RegExp("^https?://([^/]+\\.)?"+a+"\\.com?(/|$)","i");return b.match(c)}},{}),WPUSB("WPUSB.FixedContext",function(a,b,c){a.create=function(a){this.$el=a,this.isLayoutFixed()&&this.issetContext()&&this.init()},a.isLayoutFixed=function(){return this.$el.attr("class").match("-fixed-")},a.issetContext=function(){return this.id=c.getContext(),this.getContext(!0)},a.init=function(){this.setContext(),this.alignButtons()},a.setContext=function(){this.context=this.getContext(),this.setRect()},a.setRect=function(){this.rect=this.context.getBoundingClientRect(),this.top=this.rect.top,this.setLeft(this.rect.left)},a.setLeft=function(a){this.left=a-this.$el.width()},a.alignButtons=function(){this.$el.byAction("close-buttons").remove(),this.changeClass(),this.$el.css({left:this.left}),this.setLeftMobile()},a.setLeftMobile=function(){window.innerWidth>769||this.$el.css({left:"initial"})},a.changeClass=function(){var a=WPUSB.vars.prefix,b=this.$el.attr("class");b.match("-fixed-left")||(this.$el.removeClass(a+"-fixed-right"),this.$el.addClass(a+"-fixed-left"))},a.getContext=function(a){var b=this.id.replace(/[^A-Z0-9a-z-_]/g,""),c=document.getElementById(b);return a?this.sendNotice(b,c):"",c},a.sendNotice=function(a,b){a&&!b&&console.warn("WPUSB: Context not found.")}},{}),WPUSB("WPUSB.FixedTop",function(a,b){a.create=function(a){this["class"]=WPUSB.vars.prefix+"-fixed-top",this.$el=a.byElement(this["class"]),this.$el.length&&(this.$el=b(this.$el.get(0)),this.init())},a.init=function(){this.scroll=this.$el.get(0).getBoundingClientRect(),this.isInvalidScroll()&&(this.scroll["static"]=300),this.context=window,this.addEventListener()},a.addEventListener=function(){b(this.context).scroll(this._setPositionFixed.bind(this))},a._setPositionFixed=function(){var a=this.scroll["static"]||this.scroll.top;return b(this.context).scrollTop()>a?void this.$el.addClass(this["class"]):void this.$el.removeClass(this["class"])},a.isInvalidScroll=function(){return 1>this.scroll.top}},{}),WPUSB("WPUSB.OpenPopup",function(a,b){a.create=function(a){this.$el=a,this.init()},a.init=function(){return this.isMobile()?void this.mobileUrl():void this.addEventListener()},a.addEventListener=function(){this.$el.addEvent("click","open-popup",this)},a._onClickOpenPopup=function(a){a.preventDefault();var b=jQuery(a.currentTarget),c="685",d="500";this.popupCenter(b.attr("href"),"Compartilhar",c,d)},a.popupCenter=function(a,b,c,d){var e,f;return c=c||screen.width,d=d||screen.height,e=.5*screen.width-.5*c,f=.5*screen.height-.5*d,window.open(a,b,"menubar=no,toolbar=no,status=no,width="+c+",height="+d+",toolbar=no,left="+e+",top="+f)},a.isMobile=function(){return!!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)},a.mobileUrl=function(){var a=this.$el.find("[data-messenger-mobile]");a.attr("href",a.data("messenger-mobile"))}},{}),WPUSB("WPUSB.ShortUrl",function(a,b){a.create=function(a){this.$el=a,this.data=this.$el.data(),this.shareUrls=this.$el.find("a[href]"),this.checkToken()},a.checkToken=function(){this.data.token.trim()&&this.request()},a.request=function(){var a=b.proxy(this,"_done"),c=b.proxy(this,"_fail"),d={access_token:this.data.token,longUrl:this.longUrl()},e=b.ajax({url:"https://api-ssl.bitly.com/v3/shorten",data:d,dataType:"jsonp"});e.then(a,c)},a.longUrl=function(){return this.data.elementUrl+this.data.tracking},a._done=function(a){return 500===a.status_code?void console.warn("Bitly: "+a.status_txt):void this.shareUrls.each(b.proxy(this,"_each",a))},a._fail=function(a,b){console.warn(a)},a._each=function(a,c,d){var e=b(d),f=e.attr("href"),g=this.replaceUrl(a,f);e.attr("href",g)},a.replaceUrl=function(a,b){var c=encodeURIComponent(a.data.url),d=b.replace(/\[.*\]/,c);return d}},{}),WPUSB("WPUSB.ToggleButtons",function(a,b){a.create=function(a,b){"fixed"===a&&(this.$el=b,this.prefix=WPUSB.vars.prefix+"-",this.closeButtons=WPUSB.vars.body.byAction("close-buttons"),this.buttons=b.byElement("buttons"),this.init())},a.init=function(){this.addEventListener()},a.addEventListener=function(){this.closeButtons.on("click",this._onCloseButtons.bind(this))},a._onCloseButtons=function(a){a.preventDefault();var b=this.prefix+"icon-right",c=this.prefix+"toggle-active";this.buttons.toggleClass(this.prefix+"buttons"),this.closeButtons.toggleClass(b+" "+c)}}),jQuery(function(a){var b=a("body");WPUSB.vars={body:b,prefix:"wpusb"},WPUSB.Application.init.apply(null,[b])});