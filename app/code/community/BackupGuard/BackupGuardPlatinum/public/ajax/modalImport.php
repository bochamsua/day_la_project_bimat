<?php
    require_once(dirname(__FILE__).'/../boot.php');
    $backupDirectory = SGConfig::get('SG_BACKUP_DIRECTORY');
    $maxUploadSize = ini_get('upload_max_filesize');
    $dropbox = SGConfig::get('SG_DROPBOX_ACCESS_TOKEN');
    $gdrive = SGConfig::get('SG_GOOGLE_DRIVE_REFRESH_TOKEN');
    $ftp = SGConfig::get('SG_STORAGE_FTP_CONNECTED');
    $amazon = SGConfig::get('SG_AMAZON_KEY');
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"><?php _t('Import from')?></h4>
        </div>
        <div class="modal-body sg-modal-body" id="sg-modal-inport-from">
            <div class="col-md-12" id="modal-import-1">
                <div class="form-group">
                    <table class="table table-striped paginated sg-backup-table">
                        <tbody>
                            <tr>
                                <td class="file-select-radio"><input name="storage-radio" type="radio" value="local-pc"></td>
                                <td></td>
                                <td><?php _t('Local PC')?></td>
                            </tr>
                            <?php if(SGBoot::isFeatureAvailable('DOWNLOAD_FROM_CLOUD')): ?>
                                <tr>
                                    <td class="file-select-radio"><input name="storage-radio" type="radio" value="<?php echo SG_STORAGE_AMAZON?>" <?php echo empty($amazon)?'disabled="disabled"':''?>></td>
                                    <td><span class="btn-xs sg-status-icon sg-status-34 active">&nbsp;</span></td>
                                    <td><?php _t('Amazon S3')?></td>
                                </tr>
                                <tr>
                                    <td class="file-select-radio"><input name="storage-radio" type="radio" value="<?php echo SG_STORAGE_DROPBOX?>" <?php echo empty($dropbox)?'disabled="disabled"':''?>></td>
                                    <td><span class="btn-xs sg-status-icon sg-status-32 active">&nbsp;</span></td>
                                    <td><?php _t('Dropbox')?></td>
                                </tr>
                                <tr>
                                    <td class="file-select-radio"><input name="storage-radio" type="radio" value="<?php echo SG_STORAGE_FTP?>" <?php echo empty($ftp)?'disabled="disabled"':''?>></td>
                                    <td><span class="btn-xs sg-status-icon sg-status-31 active">&nbsp;</span></td>
                                    <td><?php _t('FTP')?></td>
                                </tr>
                                <tr>
                                    <td class="file-select-radio"><input name="storage-radio" type="radio" value="<?php echo SG_STORAGE_GOOGLE_DRIVE?>" <?php echo empty($gdrive)?'disabled="disabled"':''?>></td>
                                    <td><span class="btn-xs sg-status-icon sg-status-33 active">&nbsp;</span></td>
                                    <td><?php _t('Google Drive')?></td>
                                </tr>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12" id="modal-import-2">
                <div class="form-group">
                    <label class="col-md-2 control-label sg-upload-label" for="textinput"><?php _t('SGBP file')?></label>
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    <?php _t('Browse')?>&hellip; <input type="file" class="sg-backup-upload-input" name="sgbpFile" accept=".sgbp" data-max-file-size="<?php echo convertToBytes($maxUploadSize.'B'); ?>">
                                </span>
                            </span>
                            <input type="text" class="form-control" readonly>
                        </div>
                        <br/>
                        <span class="help-block">Note: If your file is bigger than <?php echo $maxUploadSize; ?>B, you can copy it inside the following folder and it will be automatically detected: <br/><strong><?php echo realpath($backupDirectory);?></strong></span>
                    </div>
                </div>
            </div>
             <?php if(SGBoot::isFeatureAvailable('DOWNLOAD_FROM_CLOUD')): ?>
                <div class="col-md-12" id="modal-import-3">
                    <table class="table table-striped paginated sg-backup-table" id="sg-archive-list-table">
                        <thead>
                        <tr>
                            <th></th>
                            <th><?php _t('Filename')?></th>
                            <th><?php _t('Size')?></th>
                            <th><?php _t('Date')?></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            <?php endif;?>
            <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="pull-left btn btn-default" id="switch-modal-import-pages-back" onclick="sgBackup.previousPage()"><?php echo _t('Back')?></button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _t("Close")?></button>
            <button type="button" class="btn btn-primary" id="switch-modal-import-pages-next" data-remote="importBackup" onclick="sgBackup.nextPage()"><?php echo _t('Next')?></button>
            <button type="button" data-remote="importBackup" id="uploadSgbpFile" class="btn btn-primary"><?php echo _t('Import')?></button>
        </div>
    </div>
</div>
