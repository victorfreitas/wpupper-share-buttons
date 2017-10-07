this["WPUSB"] = this["WPUSB"] || {};
this["WPUSB"]["Templates"] = this["WPUSB"]["Templates"] || {};

this["WPUSB"]["Templates"]["fixed"] = Handlebars.template({"1":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=helpers.helperMissing, alias3="function", alias4=container.escapeExpression;

  return "\n"
    + ((stack1 = helpers["if"].call(alias1,(depth0 != null ? depth0.first : depth0),{"name":"if","hash":{},"fn":container.program(2, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n			<div class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias4(((helper = (helper = helpers.itemClass || (depth0 != null ? depth0.itemClass : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemClass","hash":{},"data":data}) : helper)))
    + "\">\n				<a title=\"Tweet\" class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias4(((helper = (helper = helpers.btnClass || (depth0 != null ? depth0.btnClass : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"btnClass","hash":{},"data":data}) : helper)))
    + " "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-btn "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-layout-"
    + alias4(((helper = (helper = helpers.currentLayout || (depth0 != null ? depth0.currentLayout : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"currentLayout","hash":{},"data":data}) : helper)))
    + "\" data-item=\"bg-color\">\n					<i class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias4(((helper = (helper = helpers.itemClass || (depth0 != null ? depth0.itemClass : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemClass","hash":{},"data":data}) : helper)))
    + "-"
    + alias4(((helper = (helper = helpers.fixedLayout || (depth0 != null ? depth0.fixedLayout : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"fixedLayout","hash":{},"data":data}) : helper)))
    + "\" data-item=\"icons-color\"></i>\n				</a>\n			</div>\n\n"
    + ((stack1 = helpers["if"].call(alias1,(depth0 != null ? depth0.last : depth0),{"name":"if","hash":{},"fn":container.program(5, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n";
},"2":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=helpers.helperMissing, alias3="function", alias4=container.escapeExpression;

  return "	<div id=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-container-fixed\"\n	     data-preview-layout=\""
    + alias4(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\"\n		 class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + " "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-layout-"
    + alias4(((helper = (helper = helpers.currentLayout || (depth0 != null ? depth0.currentLayout : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"currentLayout","hash":{},"data":data}) : helper)))
    + "-content "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias4(((helper = (helper = helpers.fixedLayout || (depth0 != null ? depth0.fixedLayout : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"fixedLayout","hash":{},"data":data}) : helper)))
    + " "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias4(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data}) : helper)))
    + " "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-fixed "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-fixed-"
    + alias4(((helper = (helper = helpers.fixedLayout || (depth0 != null ? depth0.fixedLayout : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"fixedLayout","hash":{},"data":data}) : helper)))
    + " social-share\">\n\n		 <div data-element=\"buttons\" class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias4(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data}) : helper)))
    + "-container "
    + alias4(((helper = (helper = helpers.square2Class || (depth0 != null ? depth0.square2Class : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"square2Class","hash":{},"data":data}) : helper)))
    + "\">\n\n			<div class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-total-share\">\n				<div class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-counts\">\n					<span data-element=\"total-share\" data-item=\"text\">\n						"
    + alias4(((helper = (helper = helpers.counter || (depth0 != null ? depth0.counter : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"counter","hash":{},"data":data}) : helper)))
    + "\n					</span>\n\n"
    + ((stack1 = helpers["if"].call(alias1,(depth0 != null ? depth0.isFixed2 : depth0),{"name":"if","hash":{},"fn":container.program(3, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n				</div>\n			</div>\n";
},"3":function(container,depth0,helpers,partials,data) {
    var helper;

  return "						<span data-element=\"fixed-label-text\"\n							  data-item=\"text\">"
    + container.escapeExpression(((helper = (helper = helpers.shareCountLabel || (depth0 != null ? depth0.shareCountLabel : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0 != null ? depth0 : (container.nullContext || {}),{"name":"shareCountLabel","hash":{},"data":data}) : helper)))
    + "</span>\n";
},"5":function(container,depth0,helpers,partials,data) {
    var helper;

  return "			<span class=\""
    + container.escapeExpression(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0 != null ? depth0 : (container.nullContext || {}),{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-toggle\"></span>\n		</div>\n	</div>\n";
},"compiler":[7,">= 4.0.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers.each.call(depth0 != null ? depth0 : (container.nullContext || {}),depth0,{"name":"each","hash":{},"fn":container.program(1, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "");
},"useData":true});

this["WPUSB"]["Templates"]["share-preview"] = Handlebars.template({"1":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=helpers.helperMissing, alias3="function", alias4=container.escapeExpression;

  return "\n"
    + ((stack1 = helpers["if"].call(alias1,(depth0 != null ? depth0.first : depth0),{"name":"if","hash":{},"fn":container.program(2, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n	<div class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias4(((helper = (helper = helpers.itemClass || (depth0 != null ? depth0.itemClass : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemClass","hash":{},"data":data}) : helper)))
    + "\">\n		<a class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-button "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-btn\" title=\""
    + alias4(((helper = (helper = helpers.itemTitle || (depth0 != null ? depth0.itemTitle : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemTitle","hash":{},"data":data}) : helper)))
    + "\"\n		   data-item=\"bg-color\">\n\n			<i class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias4(((helper = (helper = helpers.itemClass || (depth0 != null ? depth0.itemClass : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemClass","hash":{},"data":data}) : helper)))
    + "-"
    + alias4(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\"\n			   data-item=\"icons-color\"></i>\n\n"
    + ((stack1 = helpers["if"].call(alias1,(depth0 != null ? depth0.itemInside : depth0),{"name":"if","hash":{},"fn":container.program(5, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "		</a>\n\n"
    + ((stack1 = helpers["if"].call(alias1,(depth0 != null ? depth0.hasCounter : depth0),{"name":"if","hash":{},"fn":container.program(7, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "	</div>\n\n";
},"2":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=helpers.helperMissing, alias3="function", alias4=container.escapeExpression;

  return "		<div id=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-container-"
    + alias4(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\"\n             data-preview-layout=\""
    + alias4(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\"\n			 class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + " "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias4(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data}) : helper)))
    + " social-share "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-preview\">\n\n"
    + ((stack1 = helpers["if"].call(alias1,(depth0 != null ? depth0.title : depth0),{"name":"if","hash":{},"fn":container.program(3, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "");
},"3":function(container,depth0,helpers,partials,data) {
    var helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=helpers.helperMissing, alias3="function", alias4=container.escapeExpression;

  return "			<div class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-title\">\n			 	<span>"
    + alias4(((helper = (helper = helpers.title || (depth0 != null ? depth0.title : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"title","hash":{},"data":data}) : helper)))
    + "</span>\n			 </div>\n";
},"5":function(container,depth0,helpers,partials,data) {
    var helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=helpers.helperMissing, alias3="function", alias4=container.escapeExpression;

  return "				<span class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-title "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-btn-inside\"\n					  data-item=\"inside\">"
    + alias4(((helper = (helper = helpers.itemInside || (depth0 != null ? depth0.itemInside : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemInside","hash":{},"data":data}) : helper)))
    + "</span>\n";
},"7":function(container,depth0,helpers,partials,data) {
    var helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=helpers.helperMissing, alias3="function", alias4=container.escapeExpression;

  return "			<span class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-count "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-counter\"\n				  data-item=\"text\">"
    + alias4(((helper = (helper = helpers.counter || (depth0 != null ? depth0.counter : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"counter","hash":{},"data":data}) : helper)))
    + "</span>\n";
},"compiler":[7,">= 4.0.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers.each.call(depth0 != null ? depth0 : (container.nullContext || {}),depth0,{"name":"each","hash":{},"fn":container.program(1, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "</div>\n<button class=\"button\" data-action=\"no-title\"></button>\n<button class=\"button\" data-action=\"no-counter\"></button>";
},"useData":true});

this["WPUSB"]["Templates"]["square-plus"] = Handlebars.template({"1":function(container,depth0,helpers,partials,data) {
    var stack1, alias1=depth0 != null ? depth0 : (container.nullContext || {});

  return "\n"
    + ((stack1 = helpers["if"].call(alias1,(depth0 != null ? depth0.first : depth0),{"name":"if","hash":{},"fn":container.program(2, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n"
    + ((stack1 = helpers.unless.call(alias1,(depth0 != null ? depth0.first : depth0),{"name":"unless","hash":{},"fn":container.program(7, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "");
},"2":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=helpers.helperMissing, alias3="function", alias4=container.escapeExpression;

  return "\n"
    + ((stack1 = helpers["if"].call(alias1,(depth0 != null ? depth0.title : depth0),{"name":"if","hash":{},"fn":container.program(3, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n		<div id=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-container-square-plus\"\n		     data-preview-layout=\""
    + alias4(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\"\n		     class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + " "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias4(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data}) : helper)))
    + " social-share "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-preview\">\n\n			<div class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-counter "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-total-share\">\n				<div class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-shares-count\" data-item=\"text\">"
    + alias4(((helper = (helper = helpers.counter || (depth0 != null ? depth0.counter : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"counter","hash":{},"data":data}) : helper)))
    + "</div>\n\n				<div class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-shares-text\"\n					 data-element=\"square-plus-text\"\n					 data-item=\"text\"\n					 data-title=\""
    + alias4(((helper = (helper = helpers.shareCountLabel || (depth0 != null ? depth0.shareCountLabel : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"shareCountLabel","hash":{},"data":data}) : helper)))
    + "\"></div>\n\n				<span class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-pipe\" data-pipe=\"&#x0007C;\" data-item=\"text\"></span>\n			</div>\n\n			<div class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias4(((helper = (helper = helpers.itemClass || (depth0 != null ? depth0.itemClass : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemClass","hash":{},"data":data}) : helper)))
    + " "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-full "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-inside\">\n				<a href=\"#\" class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-link "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-btn\" title=\""
    + alias4(((helper = (helper = helpers.itemTitle || (depth0 != null ? depth0.itemTitle : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemTitle","hash":{},"data":data}) : helper)))
    + "\" data-item=\"bg-color\">\n\n					<i class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias4(((helper = (helper = helpers.itemClass || (depth0 != null ? depth0.itemClass : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemClass","hash":{},"data":data}) : helper)))
    + "-square-plus\" data-item=\"icons-color\"></i>\n\n"
    + ((stack1 = helpers["if"].call(alias1,(depth0 != null ? depth0.inside : depth0),{"name":"if","hash":{},"fn":container.program(5, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "				</a>\n			</div>\n";
},"3":function(container,depth0,helpers,partials,data) {
    var helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=helpers.helperMissing, alias3="function", alias4=container.escapeExpression;

  return "			<div class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-title\">\n			 	<span>"
    + alias4(((helper = (helper = helpers.title || (depth0 != null ? depth0.title : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"title","hash":{},"data":data}) : helper)))
    + "</span>\n			 </div>\n";
},"5":function(container,depth0,helpers,partials,data) {
    var helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=helpers.helperMissing, alias3="function", alias4=container.escapeExpression;

  return "						<span class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-title "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-btn-inside\"\n							  data-item=\"inside\"\n							  data-title=\""
    + alias4(((helper = (helper = helpers.itemName || (depth0 != null ? depth0.itemName : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemName","hash":{},"data":data}) : helper)))
    + "\"></span>\n";
},"7":function(container,depth0,helpers,partials,data) {
    var helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=helpers.helperMissing, alias3="function", alias4=container.escapeExpression;

  return "		<div class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias4(((helper = (helper = helpers.itemClass || (depth0 != null ? depth0.itemClass : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemClass","hash":{},"data":data}) : helper)))
    + "\">\n			<a href=\"#\" class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-link "
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-btn\" title=\""
    + alias4(((helper = (helper = helpers.itemTitle || (depth0 != null ? depth0.itemTitle : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemTitle","hash":{},"data":data}) : helper)))
    + "\" data-item=\"bg-color\">\n				<i class=\""
    + alias4(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias4(((helper = (helper = helpers.itemClass || (depth0 != null ? depth0.itemClass : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemClass","hash":{},"data":data}) : helper)))
    + "-square-plus\" data-item=\"icons-color\"></i>\n			</a>\n		</div>\n";
},"compiler":[7,">= 4.0.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers.each.call(depth0 != null ? depth0 : (container.nullContext || {}),depth0,{"name":"each","hash":{},"fn":container.program(1, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "</div>\n<button class=\"button\" data-action=\"no-title\"></button>\n<button class=\"button\" data-action=\"no-counter\"></button>";
},"useData":true});