jQuery(document).ready( function() {
    sgBackup.initCloudSwitchButtons();
    sgBackup.initCloudFolderSettings();
});

sgBackup.initCloudSwitchButtons = function(){
    jQuery('.sg-switch').bootstrapSwitch();
    jQuery('.sg-switch').on('switchChange.bootstrapSwitch', function(event, state) {
        var storage = jQuery(this).attr('data-storage'),
            url = jQuery(this).attr('data-remote');
        that = jQuery(this);
        //If switch is on
        if(state) {
            jQuery('.alert').remove();
            if(storage == 'dropbox' || storage == 'gdrive'){
                var curlRequirementCheck = new sgRequestHandler('curlChecker', {});
                that.bootstrapSwitch('indeterminate',true);
                curlRequirementCheck.callback = function(response){
                    if(typeof response.success !== 'undefined'){
                        if (storage == 'dropbox'){
                            jQuery(location).attr('href',getAjaxUrl(url));
                        }
                        else if (storage == 'gdrive'){
                            jQuery(location).attr('href',getAjaxUrl(url));
                        }
                    }
                    else{
                        var alert = sgBackup.alertGenerator(response.error, 'alert-danger');
                        jQuery('.sg-cloud-container legend').after(alert);
                        that.bootstrapSwitch('state',false);
                    }
                };
                curlRequirementCheck.run();
            }
            else if (storage == 'ftp') {
                jQuery('input[data-storage=ftp]').bootstrapSwitch('indeterminate',true);
                sgBackup.isFtpConnected = false;
                jQuery('#ftp-settings').click();
            }
            else {
                jQuery('input[data-storage=amazon]').bootstrapSwitch('indeterminate',true);
                sgBackup.isAmazonConnected = false;
                jQuery('#amazon-settings').click();
            }
        }
        else {
            var ajaxHandler = new sgRequestHandler(url, {cancel: true});
            ajaxHandler.callback = function(response){
                jQuery('.sg-'+storage+'-user').remove();
            };
            ajaxHandler.run();
        }
    });
};

sgBackup.storeAmazonSettings = function(){
    var error = [];
    //Validation
    jQuery('.alert').remove();
    var amazonForm = jQuery('form[data-type=storeAmazonSettings]');
    amazonForm.find('input').each(function(){
        if(jQuery(this).val()<=0){
            var errorTxt = jQuery(this).closest('div').parent().find('label').html().slice(0,-2);
            error.push(errorTxt+' field is required.');
        }
    });

    //If any error show it and abort ajax
    if(error.length){
        var alert = sgBackup.alertGenerator(error, 'alert-danger');
        jQuery('#sg-modal .modal-header').prepend(alert);
        return false;
    }

    //Before Ajax call
    jQuery('.modal-footer .btn-primary').attr('disabled','disabled');
    jQuery('.modal-footer .btn-primary').html('Connecting...');

    //Get user credentials
    var amazonBucket = jQuery('#amazonBucket').val();
    var amazonAccessKey = jQuery('#amazonAccessKey').val();
    var amazonSecretAccessKey = jQuery('#amazonSecretAccessKey').val();
    var region = jQuery('#amazonBucketRegion').val();

    //On Success
    var ajaxHandler = new sgRequestHandler('cloudAmazon',amazonForm.serialize());
    ajaxHandler.dataIsObject = false;
    ajaxHandler.callback = function(response){
        jQuery('.alert').remove();
        if(typeof response.success !== 'undefined'){
            sgBackup.isAmazonConnected = true;
            jQuery('input[data-storage=amazon]').bootstrapSwitch('state',true);
            jQuery('#sg-modal').modal('hide');
        }
        else{
            //if error
            var alert = sgBackup.alertGenerator(response, 'alert-danger');
            jQuery('#sg-modal .modal-header').prepend(alert);

            //Before Ajax call
            jQuery('.modal-footer .btn-primary').removeAttr('disabled');
            jQuery('.modal-footer .btn-primary').html('Save');
        }
    };
    ajaxHandler.run();
};

sgBackup.storeFtpSettings = function(){
    var error = [];
    //Validation
    jQuery('.alert').remove();
    var ftpForm = jQuery('form[data-type=storeFtpSettings]');
    ftpForm.find('input').each(function(){
        if(jQuery(this).val()<=0){
            var errorTxt = jQuery(this).closest('div').parent().find('label').html().slice(0,-2);
            error.push(errorTxt+' field is required.');
        }
    });

    //If any error show it and abort ajax
    if(error.length){
        var alert = sgBackup.alertGenerator(error, 'alert-danger');
        jQuery('#sg-modal .modal-header').prepend(alert);
        return false;
    }

    //Before Ajax call
    jQuery('.modal-footer .btn-primary').attr('disabled','disabled');
    jQuery('.modal-footer .btn-primary').html('Connecting...');

    //Get user credentials
    var ftpHost = jQuery('#ftpHost').val();
    var ftpUser = jQuery('#ftpUser').val();
    var ftpPort = jQuery('#ftpPort').val();
    var ftpString = ftpUser+'@'+ftpHost+':'+ftpPort;

    //On Success
    var ajaxHandler = new sgRequestHandler('cloudFtp',ftpForm.serialize());
    ajaxHandler.dataIsObject = false;
    ajaxHandler.callback = function(response){
        jQuery('.alert').remove();
        if(typeof response.success !== 'undefined'){
            sgBackup.isFtpConnected = true;
            jQuery('input[data-storage=ftp]').bootstrapSwitch('state',true);
            jQuery('#sg-modal').modal('hide');
            sgBackup.addUserInfo(ftpString);
        }
        else{
            //if error
            var alert = sgBackup.alertGenerator(response, 'alert-danger');
            jQuery('#sg-modal .modal-header').prepend(alert);

            //Before Ajax call
            jQuery('.modal-footer .btn-primary').removeAttr('disabled');
            jQuery('.modal-footer .btn-primary').html('Save');
        }
    };
    ajaxHandler.run();
};
sgBackup.initCloudFolderSettings = function(){
    jQuery('#cloudFolder').on('input', function(){
        jQuery('#sg-save-cloud-folder').fadeIn();
    });
    jQuery('#sg-save-cloud-folder').click(function(){
        jQuery('.alert').remove();
        var cloudFolderName = jQuery('#cloudFolder').val(),
            cloundFolderRequest = new sgRequestHandler('saveCloudFolder',{cloudFolder: cloudFolderName}),
            saveBtn = jQuery(this);
        var alert = sgBackup.alertGenerator('Destination folder is required.','alert-danger');
        if(cloudFolderName.length<=0)
        {
            jQuery('.sg-cloud-container legend').after(alert);
            return;
        }
        saveBtn.attr('disabled','disabled');
        saveBtn.html('Saving...');
        cloundFolderRequest.callback = function(response){
            if(typeof response.success !== 'undefined'){
                var successAlert = sgBackup.alertGenerator('Successfully saved.','alert-success');
                jQuery('.sg-cloud-container legend').after(successAlert);
                saveBtn.fadeOut();
            }
            else{
                jQuery('.sg-cloud-container legend').after(alert);
            }
            saveBtn.removeAttr('disabled');
            saveBtn.html('Save');
        };
        cloundFolderRequest.run();
    });
};

sgBackup.addUserInfo = function(info){
    jQuery('.sg-user-info .sg-helper-block').remove();
    jQuery('.sg-user-info br').remove();
    jQuery('.sg-user-info').append('<br/><span class="text-muted sg-user-email sg-helper-block">'+info+'</span>');
};
