WPUSB( 'WPUSB.Components.Datepicker', function(Model, $, utils) {

	Model.fn.start = function() {
		this.setDefaults();
		this.init();
	};

	Model.fn.setDefaults = function() {
		var overrideDefaults = ( utils.getGlobalVars( 'datepickerDefaults' ) || {} )
		  , currentDefaults  = {
			maxDate          : '+0D',
			yearRange        : '-25:+0',
			changeMonth      : true,
			changeYear       : true,
			gotoCurrent      : true,
			showButtonPanel  : true,
			showOn           : 'focus',
			hideIfNoPrevNext : true,
			beforeShow       : function(element, instance) {
				WPUSB.vars.body.addClass( utils.addPrefix( 'datepicker-container' ) );
			}
		};

		$.datepicker.setDefaults( $.extend( currentDefaults, overrideDefaults ) );
	};

	Model.fn.init = function() {
		this.$el.datepicker({
			onSelect: function() {
				$( '#filter-by-date' ).val(0);
			}
		});
	};

});