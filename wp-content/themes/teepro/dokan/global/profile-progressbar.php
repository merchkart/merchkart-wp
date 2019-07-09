<?php
/**
 *  Profile Progressbar template
 *
 *  @since 2.4
 *
 *  @package dokan
 */
?>
<div class="dokan-panel dokan-panel-default dokan-profile-completeness">
    <div class="dokan-panel-body">
    	<h3 class="m-progress-title"><?php print $progress . esc_html__( '% Profile complete', 'teepro' ) ?></h3>
    	<div class="mgb15"><?php print $next_todo; ?></div>
    <div class="dokan-progress m-dokan-progress">

        <div class="dokan-progress-bar dokan-progress-bar-info dokan-progress-bar-striped" role="progressbar"
             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php print $progress ?>%">
        </div>
    </div>
    
   </div>
</div>
