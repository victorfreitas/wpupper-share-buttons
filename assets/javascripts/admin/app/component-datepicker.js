WPUSB( 'WPUSB.Components.Datepicker', function(Model, $, utils) {

	Model.fn.start = function() {
		this.init();
	};

	Model.fn.init = function() {
		this.$el.datepicker( this.getOptions() );
	};

	Model.fn.getOptions = function() {
		var overrideDefaults = ( utils.getGlobalVars( 'datepickerDefaults' ) || {} )
		  , currentDefaults  = {
		  	dateFormat       : 'yy-mm-dd',
			maxDate          : '+0D',
			yearRange        : '-25:+0',
			changeMonth      : true,
			changeYear       : true,
			gotoCurrent      : true,
			showButtonPanel  : true,
			showOn           : 'focus',
			hideIfNoPrevNext : true,
			numberOfMonths   : 1,
			onSelect         : this._onSelectDate.bind( this ),
			beforeShow       : this._onBeforeShow
		};

		return $.extend( currentDefaults, overrideDefaults );
	};

	Model.fn._onSelectDate = function(selectedDate, instance) {
		var input  = instance.input
		  , option = input.data( 'to' ) ? 'minDate' : 'maxDate'
		  , name   = ( !input.data( 'to' ) ) ? 'start_date' : 'end_date'
		  , date   = $.datepicker.parseDate( instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings )
		;

		WPUSB.vars.body.find( 'input[name="' + name + '"]' ).datepicker( 'option', option, date );
	};

	Model.fn._onBeforeShow = function(element, instance) {
		WPUSB.vars.body.addClass( utils.addPrefix( 'datepicker-container' ) );
	};

});