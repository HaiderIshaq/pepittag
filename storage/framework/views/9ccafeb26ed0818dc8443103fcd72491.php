<?php $__env->startSection('content'); ?>
<div class="container-fluid" id="app">
    
    <edit-survey 
    usertoken="<?php echo e($data['token']); ?>"
    id="<?php echo e($data['id']); ?>"
    userid="<?php echo e($data['user_id']); ?>"
    assetstatus="<?php echo e($data['asset_survey_status']); ?>"
    sitestatus="<?php echo e($data['site_survey_status']); ?>"
    
    ></edit-survey>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.surveyapp', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1006556.cloudwaysapps.com/subtcffarm/public_html/resources/views/assets/editsurvey.blade.php ENDPATH**/ ?>