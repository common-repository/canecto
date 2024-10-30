<?php
/**
* Dashboard RSS Feed Widget
*/
?>
<div class="rss-widget canecto_widget">
	<ul>
		<?php
		if (!empty($rssPosts->item)) {
			foreach ($rssPosts->item as $key=>$rssPost) {
				?>
				<li>
					<a href="<?php echo (string) $rssPost->link; ?>" target="_blank" class="rsswidget"><?php echo (string) $rssPost->title; ?></a> <span class="rss-date">– <span class="rss-date"><?php echo date('m.d.y', strtotime($rssPost->pubDate)); ?></span>
				</li>
				<?php
			}
		}
		?>
		
		<li>
			<p><?php _e('When the script is running Canceto starts learning from your users behavior. You receive a mail when Canceto get the data from this site and a new one when algorithms has findings for you to explore.', $this->plugin->name); ?></p>
			<hr />
			<a href="https://www.facebook.com/canecto" class="canecto_facebook" target="_blank"><?php _e('Follow us on Facebook', $this->dashboard->name); ?></a>
			<a href="https://www.linkedin.com/company/canecto.com" class="canecto_linkedin" target="_blank"><?php _e('Follow us on LinkedIn', $this->dashboard->name); ?></a>
		</li>
	</ul>
</div>