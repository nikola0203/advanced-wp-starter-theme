<div class="wrap">
	<h1>Theme Custom CSS</h1>
	<?php settings_errors(); ?>
	<form id="save-custom-css-form" method="post" action="options.php" class="general-form">
		<?php settings_fields( 'custom-css-options' ); ?>
		<?php do_settings_sections( 'seo_one_click_theme-custom-css' ); ?>
		<?php submit_button(); ?>
	</form>
</div>
