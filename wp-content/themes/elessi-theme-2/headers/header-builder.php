<div class="header-wrapper header-type-builder">
    <?php //!-- Top bar --
    elessi_header_topbar();
    //!-- End Top bar --
    
    //!-- Masthead --?>
    <div class="header-content-builder nasa-header-content-builder">
        <div id="masthead" class="site-header">
            <?php echo isset($header_builder) ? $header_builder : ''; ?>
        </div>
    </div>
</div>