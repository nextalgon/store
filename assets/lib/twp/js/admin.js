(function ($) {
    var ajaxurl = store_lite_admin.ajax_url;
    var StorerNonce = store_lite_admin.ajax_nonce;
    var custom_theme_file_frame;


    // Dismiss notice
    $('.twp-custom-setup').click(function(){
        
        var data = {
            'action': 'store_lite_notice_dismiss',
            '_wpnonce': StorerNonce,
        };
    
        $.post(ajaxurl, data, function( response ) {

            $('.twp-storer-notice').hide();
            
        });

    });

    // Getting Start action
    $('.twp-install-active').click(function(){

        $(this).closest('.twp-storer-notice').addClass('twp-installing');

        var data = {
            'action': 'store_lite_install_plugins',
            '_wpnonce': StorerNonce,
        };
    
        $.post(ajaxurl, data, function( response ) {

            window.location.href = response;
            
        });

    });

    $('.theme-recommended-plugin .recommended-plugin-status').click(function(){
        
        var id = $(this).closest('.about-items-wrap').attr('id');

        $(this).addClass('twp-activating-plugin')
        var PluginName = $(this).closest('.theme-recommended-plugin').find('h2').text();
        var PluginStatus = $(this).attr('plugin-status');
        var PluginFile = $(this).attr('plugin-file');
        var PluginFolder = $(this).attr('plugin-folder');
        var PluginSlug = $(this).attr('plugin-slug');
        var pluginClass = $(this).attr('plugin-class');

        var data = {
            'single': true,
            'PluginStatus': PluginStatus,
            'PluginFile': PluginFile,
            'PluginFolder': PluginFolder,
            'PluginSlug': PluginSlug,
            'PluginName': PluginName,
            'pluginClass': pluginClass,
            'action': 'store_lite_install_plugins',
            '_wpnonce': StorerNonce,
        };
    
        $.post(ajaxurl, data, function( response ) {
            
            var active = store_lite_admin.active
            var deactivate = store_lite_admin.deactivate
            $('#'+id+' .recommended-plugin-status').empty();

            if( response == 'Deactivated' ){
                
                $('#'+id+' .theme-recommended-plugin').removeClass('recommended-plugin-active');
                $('#'+id+' .recommended-plugin-status').removeClass('twp-plugin-active');
                $('#'+id+' .recommended-plugin-status').addClass('twp-plugin-deactivate');
                $('#'+id+' .recommended-plugin-status').html(active);
                $('#'+id+' .recommended-plugin-status').attr('plugin-status','deactivate');

            }else if( response == 'Activated' ){
                
                $('#'+id+' .theme-recommended-plugin').addClass('recommended-plugin-active');
                $('#'+id+' .recommended-plugin-status').removeClass('twp-plugin-deactivate');
                $('#'+id+' .recommended-plugin-status').addClass('twp-plugin-active');
                $('#'+id+' .recommended-plugin-status').html(deactivate);
                $('#'+id+' .recommended-plugin-status').attr('plugin-status','active');

            }else{
                
                $('#'+id+' .theme-recommended-plugin').removeClass('recommended-plugin-active');
                $('#'+id+' .recommended-plugin-status').removeClass('twp-plugin-not-install');
                $('#'+id+' .recommended-plugin-status').addClass('twp-plugin-active');
                $('#'+id+' .recommended-plugin-status').html(active);
                $('#'+id+' .recommended-plugin-status').attr('plugin-status','deactivate');

            }

            $('.recommended-plugin-status').removeClass('twp-activating-plugin');
            
        });
    });

}(jQuery));