<?php $__env->startSection('content'); ?>
<div class="container-fluid" id="app">
    
    <survey-editinfo 
    usertoken="<?php echo e($data['token']); ?>"
    id="<?php echo e($data['id']); ?>"
    userid="<?php echo e($data['user_id']); ?>"
    surveytypeis="<?php echo e($data['survey_type']); ?>"
    
    ></survey-editinfo>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.surveyapp', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\asset_tag_pepsi\public_html\resources\views/assets/surveyeditinfo.blade.php ENDPATH**/ ?>