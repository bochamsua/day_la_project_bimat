<?php
    require_once(dirname(__FILE__).'/../boot.php');
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"><?php _t('Amazon settings')?></h4>
        </div>
        <form class="form-horizontal" data-sgform="ajax" data-type="storeAmazonSettings">
            <div class="modal-body sg-modal-body">
                <div class="col-md-12">
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="amazonBucket"><?php echo _t('Bucket *')?></label>
                        <div class="col-md-8">
                            <input id="amazonBucket" name="amazonBucket" type="text" class="form-control input-md">
                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="amazonAccessKey"><?php echo _t('Access Key *')?></label>
                        <div class="col-md-8">
                            <input id="amazonAccessKey" name="amazonAccessKey" type="text" class="form-control input-md">
                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="amazonSecretAccessKey"><?php echo _t('Secret Access Key *')?></label>
                        <div class="col-md-8">
                            <input id="amazonSecretAccessKey" name="amazonSecretAccessKey" type="text" class="form-control input-md">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="amazonBucketRegion"><?php echo _t('Region *')?></label>
                        <div class="col-md-8">
                            <select class="form-control input-md" id="amazonBucketRegion" name="amazonBucketRegion">
                                <option value="us-east-1">US Standard</option>
                                <option value="us-west-2">Oregon</option>
                                <option value="us-west-1">Northern California</option>
                                <option value="eu-west-1">Ireland</option>
                                <option value="ap-southeast-1">Singapore</option>
                                <option value="ap-northeast-1">Tokyo</option>
                                <option value="ap-southeast-2">Sydney</option>
                                <option value="sa-east-1">Sao Paulo</option>
                                <option value="eu-central-1">Frankfurt</option>
                                <option value="ap-northeast-2">Seoul</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="sgBackup.storeAmazonSettings()"><?php echo _t('Save')?></button>
            </div>
        </form>
    </div>
</div>
