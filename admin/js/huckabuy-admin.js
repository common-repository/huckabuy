jQuery(document).ready(function ($) {

	var Elm = $(this);
	console.log(Elm.index());

	if (Elm.index() < 0) {
		Elm.index(0);
	}

	$('.wrap section').hide();
	$('.wrap section').eq(0).show();

	// Tab based navigation on settings page
	$('.wrap .nav-tab-wrapper a').click(function (e) {
		e.preventDefault();

		var Elm = $(this);

		Elm.blur();



		$('.wrap .nav-tab-wrapper a').removeClass('nav-tab-active');
		$('.wrap .nav-tab-wrapper a').eq(Elm.index()).addClass('nav-tab-active');

		$('.wrap section').hide();
		$('.wrap section').eq(Elm.index()).show();
	});

	// on the settings form submit, handle passing the values to an external API:

	$('#huckabuy-settings-form').submit(function (e) {
		e.preventDefault();

		var form = $(this);
		// parse the data from each input field:
		var data = form.serializeArray();

		const twitterProfile = data.find((item) => item.name === 'huckabuy_option_name[twitter_profile]');
		const facebookProfile = data.find((item) => item.name === 'huckabuy_option_name[facebook_profile]');
		const linkedinProfile = data.find((item) => item.name === 'huckabuy_option_name[linkedin_profile]');
		const searchPath = data.find((item) => item.name === 'huckabuy_option_name[search_path]');
		const hostname = data.find((item) => item.name === 'hostname');

		$.ajax({
			url: 'https://api.dashboard.huckabuy.com/api/wordpress-plugin/settings-updated',
			type: 'POST',
			data: JSON.stringify({
				hostname: hostname.value,
				settings: {
					'socials': {
						'twitter_profile': twitterProfile.value,
						'facebook_profile': facebookProfile.value,
						'linkedin_profile': linkedinProfile.value,
					},
					'search_path': searchPath.value,
				},
			}),
			crossDomain: true,
			dataType: 'jsonp',
			contentType: 'application/json',
			headers: {
				'X-HB-WP-Plugin': 'OhuThJpkZ0PaoQVyoETCE0kE',
			},
			success: function (data) {
				// if successful, show a success message below the form:
				$('#huckabuy-settings-form').append('<div class="notice notice-success is-dismissible"><p>Settings saved successfully!</p></div>');
				// remove the success message after 5 seconds:
				setTimeout(function () {
					$('.notice-success').remove();
				}, 5000);
			},
			error: function (data) {
				if (data && data.status === 200) {
					// if successful, show a success message below the form:
					$('#huckabuy-settings-form').append('<div class="notice notice-success is-dismissible"><p>Settings saved successfully!</p></div>');
					// remove the success message after 5 seconds:
					setTimeout(function () {
						$('.notice-success').remove();
					}, 5000);
				}
			},
		});


	});

});