<div class="wrap">
	<h1>Theme Custom Js</h1>
	<?php settings_errors(); ?>
	<form id="save-custom-js-form" method="post" action="options.php" class="general-form">
		<?php settings_fields( 'custom-js-options' ); ?>
		<?php do_settings_sections( 'seo_one_click_theme-custom-js' ); ?>
		<?php submit_button(); ?>
	</form>
</div>
