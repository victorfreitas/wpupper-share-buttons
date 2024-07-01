this["WPUSB"] = this["WPUSB"] || {};
this["WPUSB"]["Templates"] = this["WPUSB"]["Templates"] || {};

this["WPUSB"]["Templates"]["fixed"] = Handlebars.template({"1":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=container.hooks.helperMissing, alias3="function", alias4=container.escapeExpression, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "\n"
    + ((stack1 = lookupProperty(helpers,"if").call(alias1,(depth0 != null ? lookupProperty(depth0,"first") : depth0),{"name":"if","hash":{},"fn":container.program(2, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":3,"column":1},"end":{"line":23,"column":8}}})) != null ? stack1 : "")
    + "\n			<div class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":25,"column":15},"end":{"line":25,"column":25}}}) : helper)))
    + "-item "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":25,"column":31},"end":{"line":25,"column":41}}}) : helper)))
    + "-"
    + alias4(((helper = (helper = lookupProperty(helpers,"itemClass") || (depth0 != null ? lookupProperty(depth0,"itemClass") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemClass","hash":{},"data":data,"loc":{"start":{"line":25,"column":42},"end":{"line":25,"column":55}}}) : helper)))
    + "\">\n				<a title=\"Tweet\" class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":26,"column":28},"end":{"line":26,"column":38}}}) : helper)))
    + "-"
    + alias4(((helper = (helper = lookupProperty(helpers,"btnClass") || (depth0 != null ? lookupProperty(depth0,"btnClass") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"btnClass","hash":{},"data":data,"loc":{"start":{"line":26,"column":39},"end":{"line":26,"column":51}}}) : helper)))
    + " "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":26,"column":52},"end":{"line":26,"column":62}}}) : helper)))
    + "-btn "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":26,"column":67},"end":{"line":26,"column":77}}}) : helper)))
    + "-layout-"
    + alias4(((helper = (helper = lookupProperty(helpers,"currentLayout") || (depth0 != null ? lookupProperty(depth0,"currentLayout") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"currentLayout","hash":{},"data":data,"loc":{"start":{"line":26,"column":85},"end":{"line":26,"column":102}}}) : helper)))
    + "\" data-item=\"bg-color\">\n"
    + ((stack1 = container.invokePartial(lookupProperty(partials,"socialIcon"),depth0,{"name":"socialIcon","data":data,"indent":"\t\t\t\t\t","helpers":helpers,"partials":partials,"decorators":container.decorators})) != null ? stack1 : "")
    + "				</a>\n			</div>\n\n"
    + ((stack1 = lookupProperty(helpers,"if").call(alias1,(depth0 != null ? lookupProperty(depth0,"last") : depth0),{"name":"if","hash":{},"fn":container.program(5, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":31,"column":1},"end":{"line":35,"column":8}}})) != null ? stack1 : "")
    + "\n";
},"2":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=container.hooks.helperMissing, alias3="function", alias4=container.escapeExpression, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "	<div id=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":4,"column":10},"end":{"line":4,"column":20}}}) : helper)))
    + "-container-fixed\"\n	     data-preview-layout=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"layout") || (depth0 != null ? lookupProperty(depth0,"layout") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data,"loc":{"start":{"line":5,"column":27},"end":{"line":5,"column":37}}}) : helper)))
    + "\"\n		 class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":6,"column":10},"end":{"line":6,"column":20}}}) : helper)))
    + " "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":6,"column":21},"end":{"line":6,"column":31}}}) : helper)))
    + "-layout-"
    + alias4(((helper = (helper = lookupProperty(helpers,"currentLayout") || (depth0 != null ? lookupProperty(depth0,"currentLayout") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"currentLayout","hash":{},"data":data,"loc":{"start":{"line":6,"column":39},"end":{"line":6,"column":56}}}) : helper)))
    + "-content "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":6,"column":65},"end":{"line":6,"column":75}}}) : helper)))
    + "-"
    + alias4(((helper = (helper = lookupProperty(helpers,"fixedLayout") || (depth0 != null ? lookupProperty(depth0,"fixedLayout") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"fixedLayout","hash":{},"data":data,"loc":{"start":{"line":6,"column":76},"end":{"line":6,"column":91}}}) : helper)))
    + " "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":6,"column":92},"end":{"line":6,"column":102}}}) : helper)))
    + "-"
    + alias4(((helper = (helper = lookupProperty(helpers,"layout") || (depth0 != null ? lookupProperty(depth0,"layout") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data,"loc":{"start":{"line":6,"column":103},"end":{"line":6,"column":113}}}) : helper)))
    + " "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":6,"column":114},"end":{"line":6,"column":124}}}) : helper)))
    + "-fixed "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":6,"column":131},"end":{"line":6,"column":141}}}) : helper)))
    + "-fixed-"
    + alias4(((helper = (helper = lookupProperty(helpers,"fixedLayout") || (depth0 != null ? lookupProperty(depth0,"fixedLayout") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"fixedLayout","hash":{},"data":data,"loc":{"start":{"line":6,"column":148},"end":{"line":6,"column":163}}}) : helper)))
    + " social-share\">\n\n		 <div data-element=\"buttons\" class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":8,"column":38},"end":{"line":8,"column":48}}}) : helper)))
    + "-"
    + alias4(((helper = (helper = lookupProperty(helpers,"layout") || (depth0 != null ? lookupProperty(depth0,"layout") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data,"loc":{"start":{"line":8,"column":49},"end":{"line":8,"column":59}}}) : helper)))
    + "-container "
    + alias4(((helper = (helper = lookupProperty(helpers,"square2Class") || (depth0 != null ? lookupProperty(depth0,"square2Class") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"square2Class","hash":{},"data":data,"loc":{"start":{"line":8,"column":70},"end":{"line":8,"column":86}}}) : helper)))
    + "\">\n\n			<div class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":10,"column":15},"end":{"line":10,"column":25}}}) : helper)))
    + "-item "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":10,"column":31},"end":{"line":10,"column":41}}}) : helper)))
    + "-total-share\">\n				<div class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":11,"column":16},"end":{"line":11,"column":26}}}) : helper)))
    + "-counts\">\n					<span data-element=\"total-share\" data-item=\"text\">\n						"
    + alias4(((helper = (helper = lookupProperty(helpers,"counter") || (depth0 != null ? lookupProperty(depth0,"counter") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"counter","hash":{},"data":data,"loc":{"start":{"line":13,"column":6},"end":{"line":13,"column":17}}}) : helper)))
    + "\n					</span>\n\n"
    + ((stack1 = lookupProperty(helpers,"if").call(alias1,(depth0 != null ? lookupProperty(depth0,"isFixed2") : depth0),{"name":"if","hash":{},"fn":container.program(3, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":16,"column":5},"end":{"line":19,"column":12}}})) != null ? stack1 : "")
    + "\n				</div>\n			</div>\n";
},"3":function(container,depth0,helpers,partials,data) {
    var helper, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "						<span data-element=\"fixed-label-text\"\n							  data-item=\"text\">"
    + container.escapeExpression(((helper = (helper = lookupProperty(helpers,"shareCountLabel") || (depth0 != null ? lookupProperty(depth0,"shareCountLabel") : depth0)) != null ? helper : container.hooks.helperMissing),(typeof helper === "function" ? helper.call(depth0 != null ? depth0 : (container.nullContext || {}),{"name":"shareCountLabel","hash":{},"data":data,"loc":{"start":{"line":18,"column":26},"end":{"line":18,"column":45}}}) : helper)))
    + "</span>\n";
},"5":function(container,depth0,helpers,partials,data) {
    var helper, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "			<span class=\""
    + container.escapeExpression(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : container.hooks.helperMissing),(typeof helper === "function" ? helper.call(depth0 != null ? depth0 : (container.nullContext || {}),{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":32,"column":16},"end":{"line":32,"column":26}}}) : helper)))
    + "-toggle\"></span>\n		</div>\n	</div>\n";
},"compiler":[8,">= 4.3.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return ((stack1 = lookupProperty(helpers,"each").call(depth0 != null ? depth0 : (container.nullContext || {}),depth0,{"name":"each","hash":{},"fn":container.program(1, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":1,"column":0},"end":{"line":37,"column":9}}})) != null ? stack1 : "");
},"usePartial":true,"useData":true});

this["WPUSB"]["Templates"]["share-preview"] = Handlebars.template({"1":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=container.hooks.helperMissing, alias3="function", alias4=container.escapeExpression, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "\n"
    + ((stack1 = lookupProperty(helpers,"if").call(alias1,(depth0 != null ? lookupProperty(depth0,"first") : depth0),{"name":"if","hash":{},"fn":container.program(2, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":3,"column":1},"end":{"line":13,"column":8}}})) != null ? stack1 : "")
    + "\n	<div class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":15,"column":13},"end":{"line":15,"column":23}}}) : helper)))
    + "-item "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":15,"column":29},"end":{"line":15,"column":39}}}) : helper)))
    + "-"
    + alias4(((helper = (helper = lookupProperty(helpers,"itemClass") || (depth0 != null ? lookupProperty(depth0,"itemClass") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemClass","hash":{},"data":data,"loc":{"start":{"line":15,"column":40},"end":{"line":15,"column":53}}}) : helper)))
    + "\">\n		<a class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":16,"column":12},"end":{"line":16,"column":22}}}) : helper)))
    + "-button "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":16,"column":30},"end":{"line":16,"column":40}}}) : helper)))
    + "-btn\" title=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"itemTitle") || (depth0 != null ? lookupProperty(depth0,"itemTitle") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemTitle","hash":{},"data":data,"loc":{"start":{"line":16,"column":53},"end":{"line":16,"column":66}}}) : helper)))
    + "\"\n		   data-item=\"bg-color\">\n\n"
    + ((stack1 = container.invokePartial(lookupProperty(partials,"socialIcon"),depth0,{"name":"socialIcon","data":data,"indent":"      ","helpers":helpers,"partials":partials,"decorators":container.decorators})) != null ? stack1 : "")
    + "\n"
    + ((stack1 = lookupProperty(helpers,"if").call(alias1,(depth0 != null ? lookupProperty(depth0,"itemInside") : depth0),{"name":"if","hash":{},"fn":container.program(5, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":21,"column":3},"end":{"line":24,"column":10}}})) != null ? stack1 : "")
    + "		</a>\n\n"
    + ((stack1 = lookupProperty(helpers,"if").call(alias1,(depth0 != null ? lookupProperty(depth0,"hasCounter") : depth0),{"name":"if","hash":{},"fn":container.program(7, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":27,"column":2},"end":{"line":30,"column":9}}})) != null ? stack1 : "")
    + "	</div>\n\n";
},"2":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=container.hooks.helperMissing, alias3="function", alias4=container.escapeExpression, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "		<div id=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":4,"column":11},"end":{"line":4,"column":21}}}) : helper)))
    + "-container-"
    + alias4(((helper = (helper = lookupProperty(helpers,"layout") || (depth0 != null ? lookupProperty(depth0,"layout") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data,"loc":{"start":{"line":4,"column":32},"end":{"line":4,"column":42}}}) : helper)))
    + "\"\n             data-preview-layout=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"layout") || (depth0 != null ? lookupProperty(depth0,"layout") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data,"loc":{"start":{"line":5,"column":34},"end":{"line":5,"column":44}}}) : helper)))
    + "\"\n			 class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":6,"column":11},"end":{"line":6,"column":21}}}) : helper)))
    + " "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":6,"column":22},"end":{"line":6,"column":32}}}) : helper)))
    + "-"
    + alias4(((helper = (helper = lookupProperty(helpers,"layout") || (depth0 != null ? lookupProperty(depth0,"layout") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data,"loc":{"start":{"line":6,"column":33},"end":{"line":6,"column":43}}}) : helper)))
    + " social-share "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":6,"column":57},"end":{"line":6,"column":67}}}) : helper)))
    + "-preview\">\n\n"
    + ((stack1 = lookupProperty(helpers,"if").call(alias1,(depth0 != null ? lookupProperty(depth0,"title") : depth0),{"name":"if","hash":{},"fn":container.program(3, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":8,"column":2},"end":{"line":12,"column":10}}})) != null ? stack1 : "");
},"3":function(container,depth0,helpers,partials,data) {
    var helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=container.hooks.helperMissing, alias3="function", alias4=container.escapeExpression, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "			<div class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":9,"column":15},"end":{"line":9,"column":25}}}) : helper)))
    + "-title\">\n			 	<span>"
    + alias4(((helper = (helper = lookupProperty(helpers,"title") || (depth0 != null ? lookupProperty(depth0,"title") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"title","hash":{},"data":data,"loc":{"start":{"line":10,"column":11},"end":{"line":10,"column":20}}}) : helper)))
    + "</span>\n			 </div>\n";
},"5":function(container,depth0,helpers,partials,data) {
    var helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=container.hooks.helperMissing, alias3="function", alias4=container.escapeExpression, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "				<span class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":22,"column":17},"end":{"line":22,"column":27}}}) : helper)))
    + "-title "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":22,"column":34},"end":{"line":22,"column":44}}}) : helper)))
    + "-btn-inside\"\n					  data-item=\"inside\">"
    + alias4(((helper = (helper = lookupProperty(helpers,"itemInside") || (depth0 != null ? lookupProperty(depth0,"itemInside") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemInside","hash":{},"data":data,"loc":{"start":{"line":23,"column":26},"end":{"line":23,"column":40}}}) : helper)))
    + "</span>\n";
},"7":function(container,depth0,helpers,partials,data) {
    var helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=container.hooks.helperMissing, alias3="function", alias4=container.escapeExpression, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "			<span class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":28,"column":16},"end":{"line":28,"column":26}}}) : helper)))
    + "-count "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":28,"column":33},"end":{"line":28,"column":43}}}) : helper)))
    + "-counter\"\n				  data-item=\"text\">"
    + alias4(((helper = (helper = lookupProperty(helpers,"counter") || (depth0 != null ? lookupProperty(depth0,"counter") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"counter","hash":{},"data":data,"loc":{"start":{"line":29,"column":23},"end":{"line":29,"column":34}}}) : helper)))
    + "</span>\n";
},"compiler":[8,">= 4.3.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return ((stack1 = lookupProperty(helpers,"each").call(depth0 != null ? depth0 : (container.nullContext || {}),depth0,{"name":"each","hash":{},"fn":container.program(1, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":1,"column":0},"end":{"line":33,"column":9}}})) != null ? stack1 : "")
    + "</div>\n<button class=\"button\" data-action=\"no-title\"></button>\n<button class=\"button\" data-action=\"no-counter\"></button>\n";
},"usePartial":true,"useData":true});

this["WPUSB"]["Templates"]["square-plus"] = Handlebars.template({"1":function(container,depth0,helpers,partials,data) {
    var stack1, alias1=depth0 != null ? depth0 : (container.nullContext || {}), lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "\n"
    + ((stack1 = lookupProperty(helpers,"if").call(alias1,(depth0 != null ? lookupProperty(depth0,"first") : depth0),{"name":"if","hash":{},"fn":container.program(2, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":3,"column":1},"end":{"line":38,"column":8}}})) != null ? stack1 : "")
    + "\n"
    + ((stack1 = lookupProperty(helpers,"unless").call(alias1,(depth0 != null ? lookupProperty(depth0,"first") : depth0),{"name":"unless","hash":{},"fn":container.program(7, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":40,"column":1},"end":{"line":46,"column":12}}})) != null ? stack1 : "");
},"2":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=container.hooks.helperMissing, alias3="function", alias4=container.escapeExpression, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "\n"
    + ((stack1 = lookupProperty(helpers,"if").call(alias1,(depth0 != null ? lookupProperty(depth0,"title") : depth0),{"name":"if","hash":{},"fn":container.program(3, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":5,"column":2},"end":{"line":9,"column":10}}})) != null ? stack1 : "")
    + "\n		<div id=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":11,"column":11},"end":{"line":11,"column":21}}}) : helper)))
    + "-container-square-plus\"\n		     data-preview-layout=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"layout") || (depth0 != null ? lookupProperty(depth0,"layout") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data,"loc":{"start":{"line":12,"column":28},"end":{"line":12,"column":38}}}) : helper)))
    + "\"\n		     class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":13,"column":14},"end":{"line":13,"column":24}}}) : helper)))
    + " "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":13,"column":25},"end":{"line":13,"column":35}}}) : helper)))
    + "-"
    + alias4(((helper = (helper = lookupProperty(helpers,"layout") || (depth0 != null ? lookupProperty(depth0,"layout") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"layout","hash":{},"data":data,"loc":{"start":{"line":13,"column":36},"end":{"line":13,"column":46}}}) : helper)))
    + " social-share "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":13,"column":60},"end":{"line":13,"column":70}}}) : helper)))
    + "-preview\">\n\n			<div class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":15,"column":15},"end":{"line":15,"column":25}}}) : helper)))
    + "-item "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":15,"column":31},"end":{"line":15,"column":41}}}) : helper)))
    + "-counter "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":15,"column":50},"end":{"line":15,"column":60}}}) : helper)))
    + "-total-share\">\n				<div class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":16,"column":16},"end":{"line":16,"column":26}}}) : helper)))
    + "-shares-count\" data-item=\"text\">"
    + alias4(((helper = (helper = lookupProperty(helpers,"counter") || (depth0 != null ? lookupProperty(depth0,"counter") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"counter","hash":{},"data":data,"loc":{"start":{"line":16,"column":58},"end":{"line":16,"column":69}}}) : helper)))
    + "</div>\n\n				<div class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":18,"column":16},"end":{"line":18,"column":26}}}) : helper)))
    + "-shares-text\"\n					 data-element=\"square-plus-text\"\n					 data-item=\"text\"\n					 data-title=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"shareCountLabel") || (depth0 != null ? lookupProperty(depth0,"shareCountLabel") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"shareCountLabel","hash":{},"data":data,"loc":{"start":{"line":21,"column":18},"end":{"line":21,"column":37}}}) : helper)))
    + "\"></div>\n\n				<span class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":23,"column":17},"end":{"line":23,"column":27}}}) : helper)))
    + "-pipe\" data-pipe=\"&#x0007C;\" data-item=\"text\"></span>\n			</div>\n\n			<div class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":26,"column":15},"end":{"line":26,"column":25}}}) : helper)))
    + "-item "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":26,"column":31},"end":{"line":26,"column":41}}}) : helper)))
    + "-"
    + alias4(((helper = (helper = lookupProperty(helpers,"itemClass") || (depth0 != null ? lookupProperty(depth0,"itemClass") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemClass","hash":{},"data":data,"loc":{"start":{"line":26,"column":42},"end":{"line":26,"column":55}}}) : helper)))
    + " "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":26,"column":56},"end":{"line":26,"column":66}}}) : helper)))
    + "-full "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":26,"column":72},"end":{"line":26,"column":82}}}) : helper)))
    + "-inside\">\n				<a href=\"#\" class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":27,"column":23},"end":{"line":27,"column":33}}}) : helper)))
    + "-link "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":27,"column":39},"end":{"line":27,"column":49}}}) : helper)))
    + "-btn\" title=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"itemTitle") || (depth0 != null ? lookupProperty(depth0,"itemTitle") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemTitle","hash":{},"data":data,"loc":{"start":{"line":27,"column":62},"end":{"line":27,"column":75}}}) : helper)))
    + "\" data-item=\"bg-color\">\n\n"
    + ((stack1 = container.invokePartial(lookupProperty(partials,"socialIcon"),depth0,{"name":"socialIcon","data":data,"indent":"          ","helpers":helpers,"partials":partials,"decorators":container.decorators})) != null ? stack1 : "")
    + "\n"
    + ((stack1 = lookupProperty(helpers,"if").call(alias1,(depth0 != null ? lookupProperty(depth0,"inside") : depth0),{"name":"if","hash":{},"fn":container.program(5, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":31,"column":5},"end":{"line":35,"column":12}}})) != null ? stack1 : "")
    + "				</a>\n			</div>\n";
},"3":function(container,depth0,helpers,partials,data) {
    var helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=container.hooks.helperMissing, alias3="function", alias4=container.escapeExpression, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "			<div class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":6,"column":15},"end":{"line":6,"column":25}}}) : helper)))
    + "-title\">\n			 	<span>"
    + alias4(((helper = (helper = lookupProperty(helpers,"title") || (depth0 != null ? lookupProperty(depth0,"title") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"title","hash":{},"data":data,"loc":{"start":{"line":7,"column":11},"end":{"line":7,"column":20}}}) : helper)))
    + "</span>\n			 </div>\n";
},"5":function(container,depth0,helpers,partials,data) {
    var helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=container.hooks.helperMissing, alias3="function", alias4=container.escapeExpression, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "						<span class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":32,"column":19},"end":{"line":32,"column":29}}}) : helper)))
    + "-title "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":32,"column":36},"end":{"line":32,"column":46}}}) : helper)))
    + "-btn-inside\"\n							  data-item=\"inside\"\n							  data-title=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"itemName") || (depth0 != null ? lookupProperty(depth0,"itemName") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemName","hash":{},"data":data,"loc":{"start":{"line":34,"column":21},"end":{"line":34,"column":33}}}) : helper)))
    + "\"></span>\n";
},"7":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=container.hooks.helperMissing, alias3="function", alias4=container.escapeExpression, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "		<div class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":41,"column":14},"end":{"line":41,"column":24}}}) : helper)))
    + "-item "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":41,"column":30},"end":{"line":41,"column":40}}}) : helper)))
    + "-"
    + alias4(((helper = (helper = lookupProperty(helpers,"itemClass") || (depth0 != null ? lookupProperty(depth0,"itemClass") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemClass","hash":{},"data":data,"loc":{"start":{"line":41,"column":41},"end":{"line":41,"column":54}}}) : helper)))
    + "\">\n			<a href=\"#\" class=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":42,"column":22},"end":{"line":42,"column":32}}}) : helper)))
    + "-link "
    + alias4(((helper = (helper = lookupProperty(helpers,"prefix") || (depth0 != null ? lookupProperty(depth0,"prefix") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"prefix","hash":{},"data":data,"loc":{"start":{"line":42,"column":38},"end":{"line":42,"column":48}}}) : helper)))
    + "-btn\" title=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"itemTitle") || (depth0 != null ? lookupProperty(depth0,"itemTitle") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"itemTitle","hash":{},"data":data,"loc":{"start":{"line":42,"column":61},"end":{"line":42,"column":74}}}) : helper)))
    + "\" data-item=\"bg-color\">\n"
    + ((stack1 = container.invokePartial(lookupProperty(partials,"socialIcon"),depth0,{"name":"socialIcon","data":data,"indent":"\t\t\t\t","helpers":helpers,"partials":partials,"decorators":container.decorators})) != null ? stack1 : "")
    + "			</a>\n		</div>\n";
},"compiler":[8,">= 4.3.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return ((stack1 = lookupProperty(helpers,"each").call(depth0 != null ? depth0 : (container.nullContext || {}),depth0,{"name":"each","hash":{},"fn":container.program(1, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":1,"column":0},"end":{"line":47,"column":9}}})) != null ? stack1 : "")
    + "</div>\n<button class=\"button\" data-action=\"no-title\"></button>\n<button class=\"button\" data-action=\"no-counter\"></button>\n";
},"usePartial":true,"useData":true});