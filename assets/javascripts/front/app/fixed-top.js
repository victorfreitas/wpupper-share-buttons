WPUSB( 'WPUSB.FixedTop', function(FixedTop, $, utils) {

	FixedTop.create = function(container) {
		this.class = utils.addPrefix( 'fixed-top' );
		this.$el   = container.byElement( this.class );

		if ( !this.$el.length ) {
			return;
		}

		this.$el = $( this.$el.get(0) );
        this.init();
	};

	FixedTop.init = function() {
		this.scroll = this.$el.get(0).getBoundingClientRect();

		if ( this.isInvalidScroll() ) {
			this.scroll.static = 450;
		}

		this.context = window;
		this.addEventListener();
	};

	FixedTop.addEventListener = function() {
		$( this.context ).scroll( this._setPositionFixed.bind( this ) );
	};

	FixedTop._setPositionFixed = function() {
		var scroll = ( this.scroll.static || this.scroll.top );

		if ( $(this.context).scrollTop() > scroll ) {
			this.$el.addClass( this.class );
			return;
		}

		this.$el.removeClass( this.class );
	};

	FixedTop.isInvalidScroll = function() {
		return ( 1 > this.scroll.top );
	};

}, {} );