WPUSB( 'WPUSB.Components.Datepicker', function(Model, $, utils) {

	var DATE_FORMAT = 'yy-mm-dd';

	Model.fn.start = function() {
		this.to   = this.elements.startDate.datepicker( this.getOptions() );
		this.from = this.elements.endDate.datepicker( this.getOptions() );
		this.init();
	};

	Model.fn.init = function() {
		this.addEventListener();
	};

	Model.fn.addEventListener = function() {
		this.to.on( 'change', this._onChangeTo.bind( this ) );
		this.from.on( 'change', this._onChangeFrom.bind( this ) );
	};

	Model.fn._onChangeTo = function(event) {
		this.from.datepicker( 'option', 'minDate', this.getDate( event.currentTarget.value ) );
	};

	Model.fn._onChangeFrom = function(event) {
		this.to.datepicker( 'option', 'maxDate', this.getDate( event.currentTarget.value ) );
	};

	Model.fn.getDate = function(value) {
		return value ? $.datepicker.parseDate( DATE_FORMAT, value ) : null;
	};

	Model.fn.getOptions = function() {
		var overrideDefaults = ( utils.getGlobalVars( 'datepickerDefaults' ) || {} )
		  , currentDefaults  = {
		  	dateFormat       : DATE_FORMAT,
			maxDate          : '+0D',
			yearRange        : '-25:+0',
			changeMonth      : true,
			changeYear       : true,
			gotoCurrent      : true,
			showButtonPanel  : true,
			showOn           : 'focus',
			hideIfNoPrevNext : true,
			numberOfMonths   : 1,
			beforeShow       : this._onBeforeShow
		};

		return $.extend( currentDefaults, overrideDefaults );
	};

	Model.fn._onBeforeShow = function(element, instance) {
		WPUSB.vars.body.addClass( utils.addPrefix( 'datepicker-container' ) );
	};

});