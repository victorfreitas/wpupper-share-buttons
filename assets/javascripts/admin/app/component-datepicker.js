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
		this.addEventListeners();

		this.$el.datepicker({
			onSelect: function() {
				var filter = $( '#filter-by-date' );
				filter.val(0);
				filter.prop( 'disabled', true );
			}
		});
	};

	Model.fn.addEventListeners = function() {
		this.$el.on( 'keyup', this._onKeyUp.bind( this ) );
	};

	Model.fn._onKeyUp = function(e) {
		if ( this.$el.val() !== '' ) {
			return;
		}

		if ( this.checkIfAllIsEmpty() ) {
			$( '#filter-by-date' ).prop( 'disabled', false );
		}
	};

	Model.fn.checkIfAllIsEmpty = function() {
		var components = $( '[data-wpusb-component="datepicker"]' )
		  , isEmpty    = true
		;

		components.each(function(key,item) {
			if ( item.value !== '' ) {
				isEmpty = false;
			}
		});

		return isEmpty;
	};

});