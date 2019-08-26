Handlebars.registerHelper('className', function(prefix, network, layout) {
  layout = /^(rounded|square)$/.test(layout) ? '-'.concat(layout) : '';

  return ''.concat(prefix, '-', network, layout);
});

Handlebars.registerPartial('socialIcon',
  '<svg class="{{prefix}}-svg {{prefix}}-{{itemClass}}-{{layout}}" data-item="icons-color">' +
    '<use xlink:href="#{{className prefix itemClass layout}}"></use>' +
  '</svg>'
);
