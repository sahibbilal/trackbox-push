(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	jQuery(document).on('click','#add_compaign',function (){
		var _len = $('.track_box_push_custom').length;
		_len = parseInt(_len) + parseInt(1);
		var _html = '<tr class="track_box_push_custom">' +
			'<th scope="row">' +
			'<label for="track_box_push_apiKey">Account Details '+_len+'</label>' +
			'</th>' +
			'<td>' +
			'<input style="margin-bottom: 10px" type="text" name="track_box_push_options[custom]['+_len+'][username]" data-custom="custom" placeholder="Username" required=><br />' +
			'<input style="margin-bottom: 10px" type="text" name="track_box_push_options[custom]['+_len+'][password]" data-custom="custom" placeholder="Password" required=><br />' +
			'<input style="margin-bottom: 10px" type="text" name="track_box_push_options[custom]['+_len+'][weblink]" data-custom="custom" placeholder="Web Link" required=><br />' +
			'<input style="margin-bottom: 10px" type="text" name="track_box_push_options[custom]['+_len+'][ai]" data-custom="custom" placeholder="AI" required=><br />' +
			'<input style="margin-bottom: 10px" type="text" name="track_box_push_options[custom]['+_len+'][ci]" data-custom="custom" placeholder="CI" required=><br />' +
			'<input style="margin-bottom: 10px" type="text" name="track_box_push_options[custom]['+_len+'][gi]" data-custom="custom" placeholder="GI" required=><br />' +
			'<textarea style="width: 177px;" name="track_box_push_options[custom]['+_len+'][mpc][]" data-custom="custom" placeholder="Mpc_1=abc,Mpc_2=test" required=>MPC_1 = FreeParam, MPC_2 = FreeParam, MPC_3 = FreeParam, MPC_4 = FreeParam, MPC_5 = FreeParam, MPC_6 = FreeParam, MPC_7 = FreeParam, MPC_8 = FreeParam, MPC_9 = FreeParam, MPC_10 = FreeParam</textarea>' +
			'</td></tr>';
		var ajax = $(this).attr('data-ajax');
		var apnd = $(this).closest('tr');
		$.ajax({
			type: "POST",
			url: ajax,
			data: {
				action: "save_customer_details",
				_len: _len,
			},
			dataType: "html",
			cache: false,
			success: function(res) {
				$(_html).insertBefore(apnd);
			},
		});

	})

})( jQuery );
