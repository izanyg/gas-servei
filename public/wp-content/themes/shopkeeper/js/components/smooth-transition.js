jQuery( function($) {

	"use strict";

	// smooth transition
	if( getbowtied_scripts_vars.smooth_transition ) {

		if( $('#header-loader-under-bar').length ) {
			NProgress.configure({
				template: '<div class="bar" role="bar"></div>',
				parent: '#header-loader',
				showSpinner: false,
				easing: 'ease',
				minimum: 0.3,
				speed: 500,
			});
		}

		$('#st-container').addClass('fade_in').removeClass('fade_out');
		$('#header-loader-under-bar').addClass('hidden');
		NProgress.start();
		NProgress.done();

		$(window).on('beforeunload', function() {
			$('#st-container').addClass('fade_out').removeClass('fade_in');
			$('#header-loader-under-bar').removeClass('hidden');
		});
	}
});
