WPUSB( 'WPUSB.Sortable', function(Model, $, utils) {

	Model.create = function(element) {
		if ( !element.length ) {
			return;
		}

    this.element = element;

		this.init();
	};

	Model.init = function() {
		this.element.sortable( this.sortOptions() );
	};

	Model.sortOptions = function() {
    var tdClassName = utils.addPrefix( 'td' );
    var placeholder = utils.addPrefix( 'sortable-placeholder' );

		return {
			opacity: 0.4,
			cursor: 'move',
      items: '> td',
      placeholder: tdClassName.concat( ' ', placeholder ),
		};
	};
}, {} );
