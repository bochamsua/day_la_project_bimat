<?php
    require_once(dirname(__FILE__).'/../boot.php');
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"><?php _t('FTP settings')?></h4>
        </div>
        <form class="form-horizontal" data-sgform="ajax" data-type="storeFtpSettings">
            <div class="modal-body sg-modal-body">
                <div class="col-md-12">
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="ftpHost"><?php echo _t('Host *')?></label>
                        <div class="col-md-8">
                            <input id="ftpHost" name="ftpHost" type="text" class="form-control input-md">
                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="ftpUser"><?php echo _t('User *')?></label>
                        <div class="col-md-8">
                            <input id="ftpUser" name="ftpUser" type="text" class="form-control input-md">
                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="ftpPass"><?php echo _t('Password *')?></label>
                        <div class="col-md-8">
                            <input id="ftpPass" name="ftpPass" type="text" class="form-control input-md">
                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="ftpPort"><?php echo _t('Port *')?></label>
                        <div class="col-md-8">
                            <input id="ftpPort" name="ftpPort" type="text" class="form-control input-md" value="21">
                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="ftpRoot"><?php echo _t('Root directory *')?></label>
                        <div class="col-md-8">
                            <input id="ftpRoot" name="ftpRoot" type="text" class="form-control input-md" value="/">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="sgBackup.storeFtpSettings()"><?php echo _t('Save')?></button>
            </div>
        </form>
    </div>
</div>