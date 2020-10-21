<?php 
	get_header(); 
	$cerio_settings = cerio_global_settings();
?>
<div class="page-404">
	<div class="content-page-404">
		<div class="title-error">
			<?php if(isset($cerio_settings['title-error']) && $cerio_settings['title-error']){
				echo esc_html($cerio_settings['title-error']);
			}else{
				echo esc_html__('404', 'cerio');
			}?>
		</div>
		<div class="sub-title">
			<?php if(isset($cerio_settings['sub-title']) && $cerio_settings['sub-title']){
				echo esc_html($cerio_settings['sub-title']);
			}else{
				echo esc_html__("Oops! That page can't be found.", "cerio");
			}?>
		</div>
		<div class="sub-error">
			<?php if(isset($cerio_settings['sub-error']) && $cerio_settings['sub-error']){
				echo esc_html($cerio_settings['sub-error']);
			}else{
				echo esc_html__('Sorry, but the page you are looking for is not found. Please, make sure you have typed the current URL.', 'cerio');
			}?>
		</div>
		<a class="btn" href="<?php echo esc_url( home_url('/') ); ?>">
			<?php if(isset($cerio_settings['btn-error']) && $cerio_settings['btn-error']){
				echo esc_html($cerio_settings['btn-error']);}
			else{
				echo esc_html__('Go To Home', 'cerio');
			}?>
		</a>
	</div>
</div>
<?php
get_footer();