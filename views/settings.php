<div class="wrap">
    <h2><?php echo $this->plugin->displayName; ?> &raquo; <?php _e('Canecto set-up', $this->plugin->name); ?></h2>

    <?php
    if (isset($this->message)) {
        ?>
        <div class="updated fade"><p><?php echo $this->message; ?></p></div>
        <?php
    }
    if (isset($this->errorMessage)) {
        ?>
        <div class="error fade"><p><?php echo $this->errorMessage; ?></p></div>
        <?php
    }
    ?>
    
    <div id="poststuff">
    	<div id="post-body" class="metabox-holder columns-2">
    		<!-- Content -->
    		<div id="post-body-content">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
	                <div class="postbox">
	                    <h3 class="hndle"><?php _e('Canecto set-up', $this->plugin->name); ?></h3>

	                    <div class="inside">
		                    <form action="options-general.php?page=<?php echo $this->plugin->name; ?>" method="post">
		                    	<p>
		                    		<label for="canecto_insert_header"><strong><?php _e('Site Id', $this->plugin->name); ?></strong></label>
		                    		<input type="text" name="canecto_insert_header" id="canecto_insert_header" class="widefat" style="font-family:Courier New;" value="<?php echo $this->settings['canecto_insert_header']; ?>">
		                    		<?php _e('Enter your Canecto Id.', $this->plugin->name); ?>
		                    	</p>

		                    	<?php wp_nonce_field($this->plugin->name, $this->plugin->name.'_nonce'); ?>
		                    	<p>
									<input name="submit" type="submit" name="Submit" class="button button-primary" value="<?php _e('Save', $this->plugin->name); ?>" />
								</p>
						    </form>
	                    </div>
	                </div>
	                <!-- /postbox -->

	                <?php
	                // RSS Feed
	                if (isset($this->dashboard)) {
	                	?>
		                <div id="canecto" class="postbox">
		                    <h3 class="hndle">
		                    	<?php _e('What is next?', $this->plugin->name); ?>
		                    </h3>

		                    <div class="inside">
			                    <?php
			                    $this->dashboard->outputDashboardWidget();
								?>
		                    </div>
		                </div>
		                <!-- /postbox -->
		                <?php
	                }
	                ?>
				</div>
				<!-- /normal-sortables -->
    		</div>
    		<!-- /post-body-content -->

    		<!-- Sidebar -->
    		<div id="postbox-container-1" class="postbox-container">
    			<?php require_once($this->plugin->folder.'/_modules/dashboard/views/sidebar.php'); ?>
    		</div>
    		<!-- /postbox-container -->
    	</div>
	</div>
</div>
