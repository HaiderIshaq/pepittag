<?php $__env->startSection('content'); ?>
<div class="container-fluid" id="app">
    
    <survey-images 
    url="<?php echo e(url('/')); ?>"
    usertoken="<?php echo e($data['token']); ?>"
    id="<?php echo e($data['id']); ?>"
    userid="<?php echo e($data['user_id']); ?>"
    
    ></survey-images>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.surveyapp', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1006556.cloudwaysapps.com/subtcffarm/public_html/resources/views/assets/surveyimages.blade.php ENDPATH**/ ?>