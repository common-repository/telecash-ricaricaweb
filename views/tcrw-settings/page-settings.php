<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h1><?php esc_html_e( tcrw_NAME ); ?> Settings</h1>

	<?php
		$active_tab = isset( $_REQUEST[ 'tab' ] ) ? $_REQUEST[ 'tab' ] : "general";
        ?>
	<h2 class="nav-tab-wrapper">
	    <a href="?page=telecash&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">General</a>
	    <a href="?page=telecash&tab=instances" class="nav-tab <?php echo $active_tab == 'instances' ? 'nav-tab-active' : ''; ?>">Instances</a>
	    <a href="?page=telecash&tab=translations" class="nav-tab <?php echo $active_tab == 'translations' ? 'nav-tab-active' : ''; ?>">Strings and translations</a>
	</h2>

	<form method="post" action="options.php" id="tcrwmanager">
	<?php if ($active_tab=="general") { ?>

		<?php settings_fields( 'tcrw_settings' ); ?>
		<?php do_settings_sections( 'tcrw_settings' ); ?>

		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes' ); ?>" />
		</p>

	<?php } elseif ($active_tab=="translations") { ?>

		<?php settings_fields( 'tcrw_settings-3' ); ?>
		<?php do_settings_sections( 'tcrw_settings-3' ); ?>

		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes' ); ?>" />
		</p>

	<?php } else { ?>

		<?php settings_fields( 'tcrw_settings-2' ); ?>
		<?php do_settings_sections( 'tcrw_settings-2' ); ?>

		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes' ); ?>" onclick="return checkSave(this.form);" />
		</p>

	<?php } ?>

	</form>


	<p style='font-size:1.2em;font-weight:bold;'>
		<a target='_blank' href='http://www.telecash.it/servizi/ricarica-web/plugins-ricaricaweb/#wordpress'>Read the guide</a>
	</p>


</div> <!-- .wrap -->
