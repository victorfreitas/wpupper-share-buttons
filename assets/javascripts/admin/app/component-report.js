WPUSB( 'WPUSB.Components.Report', function(Model, $, utils) {

	Model.fn.start = function() {
		this.init();
	};

	Model.fn.init = function() {
		this.$el.addEvent( 'click', 'toggle', this );
	};

	Model.fn._onClickToggle = function(event) {
		var icon = $( event.currentTarget ).find( 'i' );

		icon.toggleClass( 'active' );

		this.elements.toggle.slideToggle( 'slow', 'swing', this._slideToggleComplete.bind( this, icon ) );
	};

	Model.fn._slideToggleComplete = function(icon) {
		var pattern = new RegExp( '(' + this.data.cookieName + '=)([0-9])(;)', 'g' );

		this.makeCookie( this.data.cookieName, document.cookie.match( pattern ) ? '' : 1 );
	};

	Model.fn.makeCookie = function(name, value) {
		var d = new Date();

		if ( value ) {
			d.setMonth( d.getMonth() + 12 );
		}

		document.cookie = name + '=' + value + ';expires=' + d + ';path=' + window.location.pathname;
	};

});