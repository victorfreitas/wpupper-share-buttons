WPUSB( 'WPUSB.Components.Datepicker', function(Model, $, utils) {

	Model.fn.start = function() {
		this.setDefaults();
		this.init();
		this.addEventListeners();
	};

	Model.fn.setDefaults = function() {
		$.datepicker.regional['pt-BR'] = {
			closeText		: 'Fechar',
			prevText		: '&#x3c;Anterior',
			nextText		: 'Pr&oacute;ximo&#x3e;',
			currentText		: 'Hoje',
			monthNames 		: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho', 'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
			monthNamesShort : ['Jan','Fev','Mar','Abr','Mai','Jun', 'Jul','Ago','Set','Out','Nov','Dez'],
			dayNames 		: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
			dayNamesShort 	: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
			dayNamesMin 	: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
			weekHeader 		: 'Sm',
			dateFormat 		: 'dd/mm/yy',
			firstDay 		: 0,
			isRTL 			: false,
			yearSuffix 		: '',
			showMonthAfterYear: false
		};

		$.datepicker.setDefaults( $.datepicker.regional['pt-BR'] );
	};

	Model.fn.addEventListeners = function() {
		this.$el.on( 'keyup', this.onKeyUp.bind(this) );
	};

	Model.fn.init = function() {
		this.$el.datepicker({
			onSelect: function() {
				var filter = $( '#filter-by-date' );
				filter.val(0);
				filter.prop( 'disabled', true );
			}
		});
	};

	Model.fn.onKeyUp = function(e) {
		if ( this.$el.val() === '' ) {
			if ( this.checkIfAllIsEmpty() ) {
				$( '#filter-by-date' ).prop( 'disabled', false );
			}
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