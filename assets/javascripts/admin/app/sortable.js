WPUSB( 'WPUSB.Sortable', function(Model, $, utils) {

	Model.create = function(container) {
		if ( !container.length ) {
			return;
		}

		this.element = container;
		this.init();
	};

	Model.init = function() {
		this.element.sortable( this.sortOptions() );
	};

	Model.sortOptions = function() {
		return {
			opacity     : 0.4,
			cursor      : 'move',
			tolerance   : 'pointer',
			items       : '> td',
			placeholder : utils.addPrefix( 'sortable-placeholder' ),
		};
	};

}, {} );