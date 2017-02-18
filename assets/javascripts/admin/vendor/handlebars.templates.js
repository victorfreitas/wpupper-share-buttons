(function() {
var template = Handlebars.template, templates = WPUSB.Templates = WPUSB.Templates || {};
templates['fixed'] = template({"1":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.first : depth0),{"name":"if","hash":{},"fn":container.program(2, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n			<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "\">\n				<a title=\"Tweet\" class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.btn_class || (depth0 != null ? depth0.btn_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"btn_class","hash":{},"data":data}) : helper)))
    + " "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-btn\" data-item=\"bg-color\">\n					<i class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.fixed_layout || (depth0 != null ? depth0.fixed_layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"fixed_layout","hash":{},"data":data}) : helper)))
    + "\" data-item=\"icons-color\"></i>\n				</a>\n			</div>\n\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.last : depth0),{"name":"if","hash":{},"fn":container.program(5, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n";
},"2":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "	<div id=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-container-fixed\"\n	     data-preview-layout=\""
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\"\n		 class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + " "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.fixed_layout || (depth0 != null ? depth0.fixed_layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"fixed_layout","hash":{},"data":data}) : helper)))
    + " "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + " "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-fixed "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-fixed-"
    + alias3(((helper = (helper = helpers.fixed_layout || (depth0 != null ? depth0.fixed_layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"fixed_layout","hash":{},"data":data}) : helper)))
    + " social-share\">\n\n		 <div data-element=\"buttons\" class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + "-container\">\n\n			<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-total-share\">\n				<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-counts\">\n					<span data-element=\"total-share\" data-item=\"text\">\n						"
    + alias3(((helper = (helper = helpers.counter || (depth0 != null ? depth0.counter : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"counter","hash":{},"data":data}) : helper)))
    + "\n					</span>\n\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.is_fixed_2 : depth0),{"name":"if","hash":{},"fn":container.program(3, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n				</div>\n			</div>\n";
},"3":function(container,depth0,helpers,partials,data) {
    return "						<span data-element=\"fixed-label-text\"\n							  data-item=\"text\">Shares</span>\n";
},"5":function(container,depth0,helpers,partials,data) {
    var helper;

  return "			<span class=\""
    + container.escapeExpression(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-toggle\"></span>\n		</div>\n	</div>\n";
},"compiler":[7,">= 4.0.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers.each.call(depth0,depth0,{"name":"each","hash":{},"fn":container.program(1, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "");
},"useData":true});

templates['share-preview'] = template({"1":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.first : depth0),{"name":"if","hash":{},"fn":container.program(2, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n	<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "\">\n		<a class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-button "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-btn\" title=\""
    + alias3(((helper = (helper = helpers.item_title || (depth0 != null ? depth0.item_title : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_title","hash":{},"data":data}) : helper)))
    + "\"\n		   data-item=\"bg-color\">\n\n			<i class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\"\n			   data-item=\"icons-color\"></i>\n\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.item_inside : depth0),{"name":"if","hash":{},"fn":container.program(5, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "		</a>\n\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.has_counter : depth0),{"name":"if","hash":{},"fn":container.program(7, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "	</div>\n\n";
},"2":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "		<div id=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-container-"
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\"\n             data-preview-layout=\""
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\"\n			 class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + " "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + " social-share "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-preview\">\n\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.title : depth0),{"name":"if","hash":{},"fn":container.program(3, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "");
},"3":function(container,depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "			<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-title\">\n			 	<span>"
    + alias3(((helper = (helper = helpers.title || (depth0 != null ? depth0.title : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"title","hash":{},"data":data}) : helper)))
    + "</span>\n			 </div>\n";
},"5":function(container,depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "				<span class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-title "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-btn-inside\"\n					  data-item=\"inside\">"
    + alias3(((helper = (helper = helpers.item_inside || (depth0 != null ? depth0.item_inside : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_inside","hash":{},"data":data}) : helper)))
    + "</span>\n";
},"7":function(container,depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "			<span class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-count "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-counter\"\n				  data-item=\"text\">"
    + alias3(((helper = (helper = helpers.counter || (depth0 != null ? depth0.counter : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"counter","hash":{},"data":data}) : helper)))
    + "</span>\n";
},"compiler":[7,">= 4.0.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers.each.call(depth0,depth0,{"name":"each","hash":{},"fn":container.program(1, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "</div>\n<button class=\"button\" data-action=\"no-title\"></button>\n<button class=\"button\" data-action=\"no-counter\"></button>";
},"useData":true});

templates['square-plus'] = template({"1":function(container,depth0,helpers,partials,data) {
    var stack1;

  return "\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.first : depth0),{"name":"if","hash":{},"fn":container.program(2, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n"
    + ((stack1 = helpers.unless.call(depth0,(depth0 != null ? depth0.first : depth0),{"name":"unless","hash":{},"fn":container.program(7, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "");
},"2":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.title : depth0),{"name":"if","hash":{},"fn":container.program(3, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n		<div id=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-container-square-plus\"\n		     data-preview-layout=\""
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\"\n		     class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + " "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + " social-share "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-preview\">\n\n			<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-counter "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-total-share\">\n				<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-shares-count\" data-item=\"text\">"
    + alias3(((helper = (helper = helpers.counter || (depth0 != null ? depth0.counter : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"counter","hash":{},"data":data}) : helper)))
    + "</div>\n\n				<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-shares-text\"\n					 data-element=\"square-plus-text\"\n					 data-item=\"text\"\n					 data-title=\""
    + alias3(((helper = (helper = helpers.share_count_label || (depth0 != null ? depth0.share_count_label : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"share_count_label","hash":{},"data":data}) : helper)))
    + "\"></div>\n\n				<span class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-pipe\" data-pipe=\"&#x0007C;\" data-item=\"text\"></span>\n			</div>\n\n			<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + " "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-full "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-inside\">\n				<a href=\"#\" class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-link "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-btn\" title=\""
    + alias3(((helper = (helper = helpers.item_title || (depth0 != null ? depth0.item_title : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_title","hash":{},"data":data}) : helper)))
    + "\" data-item=\"bg-color\">\n\n					<i class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "-square-plus\" data-item=\"icons-color\"></i>\n\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.inside : depth0),{"name":"if","hash":{},"fn":container.program(5, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "				</a>\n			</div>\n";
},"3":function(container,depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "			<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-title\">\n			 	<span>"
    + alias3(((helper = (helper = helpers.title || (depth0 != null ? depth0.title : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"title","hash":{},"data":data}) : helper)))
    + "</span>\n			 </div>\n";
},"5":function(container,depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "						<span class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-title "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-btn-inside\"\n							  data-item=\"inside\"\n							  data-title=\""
    + alias3(((helper = (helper = helpers.item_name || (depth0 != null ? depth0.item_name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_name","hash":{},"data":data}) : helper)))
    + "\"></span>\n";
},"7":function(container,depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "		<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "\">\n			<a href=\"#\" class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-link "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-btn\" title=\""
    + alias3(((helper = (helper = helpers.item_title || (depth0 != null ? depth0.item_title : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_title","hash":{},"data":data}) : helper)))
    + "\" data-item=\"bg-color\">\n				<i class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "-square-plus\" data-item=\"icons-color\"></i>\n			</a>\n		</div>\n";
},"compiler":[7,">= 4.0.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers.each.call(depth0,depth0,{"name":"each","hash":{},"fn":container.program(1, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "</div>\n<button class=\"button\" data-action=\"no-title\"></button>\n<button class=\"button\" data-action=\"no-counter\"></button>";
},"useData":true});
}());