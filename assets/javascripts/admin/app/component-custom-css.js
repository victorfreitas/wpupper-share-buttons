WPUSB( 'WPUSB.Components.CustomCss', function(Model, $, utils) {

	Model.fn.start = function() {
		this.init();
	};

	Model.fn.init = function() {
		this.addNotice();
		this.setCodeMirror();
		this.addEventListener();
		this.setSize();
	};

	Model.fn.addNotice = function() {
		if ( ~window.location.href.indexOf( '#save-success' ) ) {
			$( '#updated-notice' ).show();
			window.location.hash = '';
		}
	};

	Model.fn.setCodeMirror = function() {
		this.codeMirror = CodeMirror.fromTextArea( this.elements.cssField.get(0), {
			lineNumbers       : true,
			lineWrapping      : true,
			mode              : 'css',
			theme             : 'seti',
			autoCloseBrackets : true,
			styleActiveLine   : true,
			matchBrackets     : true,
			showTrailingSpace : true,
			gutters           : ['CodeMirror-linenumbers']
		});
	};

	Model.fn.addEventListener = function() {
		this.codeMirror.on( 'keyup', this._onKeyupCodeMirror.bind( this ) );
		this.$el.addEvent( 'click', 'save-custom-css', this );
	};

	Model.fn.setSize = function() {
		var height = ( window.innerHeight - 300 );
		this.codeMirror.setSize( '100%', height );
	};

	Model.fn._onKeyupCodeMirror = function(cm, event) {
		var keyCode = event.keyCode;

		if ( keyCode >= 65 && keyCode <= 95 ) {
			CodeMirror.showHint( cm, CodeMirror.hint.css, { completeSingle : true } );
		}
	};

	Model.fn._onClickSaveCustomCss = function(event) {
		this.elements.btnSave.prop( 'disabled', true );
		this.elements.spinner.addClass( 'ajax-spinner-visible' );
		this.elements.error.text('');

		event.preventDefault();
		this.request();
	};

	Model.fn.request = function() {
		var params = {
			action     : this.addPrefix( 'save_custom_css', '_' ),
			custom_css : this.codeMirror.getValue(),
		};

		var ajax = $.ajax({
			type : 'POST',
			url  : utils.getAjaxUrl(),
			data : params
		});

		ajax.then( $.proxy( this, '_done' ), $.proxy( this, '_fail' ) );
	};

	Model.fn._done = function(response) {
		this.clear();

		if ( response.success ) {
			window.location.hash = 'save-success';
			window.location.reload(true);
			return;
		}

		this.elements.error.text( response.data );
	};

	Model.fn._fail = function(xhr, status, thrownError) {
		this.clear();
	};

	Model.fn.clear = function() {
		this.elements.btnSave.prop( 'disabled', false );
		this.elements.spinner.removeClass( 'ajax-spinner-visible' );
	};

});