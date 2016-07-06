(function() {
var template = Handlebars.template, templates = WPUPPER.Templates = WPUPPER.Templates || {};
templates['fixed'] = template({"1":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.first : depth0),{"name":"if","hash":{},"fn":container.program(2, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n	<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "\">\n		<a title=\"Tweet\" rel=\"nofollow\">\n		<i class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "-buttons \"></i>\n		</a>\n	</div>\n\n";
},"2":function(container,depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "		<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + " "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-buttons "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + " social-share\">\n\n			<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-total-share wpusb-counter\">\n				<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-button\">\n					<span>"
    + alias3(((helper = (helper = helpers.counter || (depth0 != null ? depth0.counter : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"counter","hash":{},"data":data}) : helper)))
    + "</span>\n				</div>\n			</div>\n";
},"compiler":[7,">= 4.0.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers.each.call(depth0,depth0,{"name":"each","hash":{},"fn":container.program(1, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "	<span class=\"wpusb-toggle\"></span>\n</div>\n\n<button class=\"button\" data-action=\"no-counter\"></button>";
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
    + "-button\" title=\""
    + alias3(((helper = (helper = helpers.item_title || (depth0 != null ? depth0.item_title : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_title","hash":{},"data":data}) : helper)))
    + "\">\n			<i class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\"></i>\n			<span class=\"wpusb-title\">"
    + alias3(((helper = (helper = helpers.item_inside || (depth0 != null ? depth0.item_inside : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_inside","hash":{},"data":data}) : helper)))
    + "</span>\n		</a>\n\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.has_counter : depth0),{"name":"if","hash":{},"fn":container.program(4, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "	</div>\n\n";
},"2":function(container,depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "		<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + " "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + " social-share "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-preview\">\n";
},"4":function(container,depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "			<span class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-count wpusb-counter\">"
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
    + ((stack1 = helpers.unless.call(depth0,(depth0 != null ? depth0.first : depth0),{"name":"unless","hash":{},"fn":container.program(5, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "");
},"2":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "		<div class=\""
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
    + "-counter wpusb-counter\">\n				<span class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-counter\">"
    + alias3(((helper = (helper = helpers.counter || (depth0 != null ? depth0.counter : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"counter","hash":{},"data":data}) : helper)))
    + "</span>\n				<span class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-text\" data-title=\"shares\"></span>\n				<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-slash\" data-slash=\""
    + ((stack1 = ((helper = (helper = helpers.slash || (depth0 != null ? depth0.slash : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"slash","hash":{},"data":data}) : helper))) != null ? stack1 : "")
    + "\"></div>\n			</div>\n\n			<div class=\""
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
    + "-link\" title=\""
    + alias3(((helper = (helper = helpers.item_title || (depth0 != null ? depth0.item_title : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_title","hash":{},"data":data}) : helper)))
    + "\">\n					<i class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "-square-plus\"></i>\n\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.inside : depth0),{"name":"if","hash":{},"fn":container.program(3, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "				</a>\n			</div>\n\n";
},"3":function(container,depth0,helpers,partials,data) {
    var helper;

  return "						<span class=\"wpusb-title\" data-title=\""
    + container.escapeExpression(((helper = (helper = helpers.item_name || (depth0 != null ? depth0.item_name : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"item_name","hash":{},"data":data}) : helper)))
    + "\"></span>\n";
},"5":function(container,depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "\n			<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "\">\n				<a href=\"#\" class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-link\" title=\""
    + alias3(((helper = (helper = helpers.item_title || (depth0 != null ? depth0.item_title : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_title","hash":{},"data":data}) : helper)))
    + "\">\n					<i class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "-square-plus\"></i>\n				</a>\n			</div>\n\n";
},"compiler":[7,">= 4.0.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers.each.call(depth0,depth0,{"name":"each","hash":{},"fn":container.program(1, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "</div>\n<button class=\"button\" data-action=\"no-title\"></button>\n<button class=\"button\" data-action=\"no-counter\"></button>";
},"useData":true});
}());