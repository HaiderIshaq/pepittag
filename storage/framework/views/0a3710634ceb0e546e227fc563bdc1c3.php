<?php $__env->startSection('content'); ?>
<div class="container-fluid" id="app">
    
    <create-asset usertoken="<?php echo e($data['token']); ?>"></create-asset>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1006556.cloudwaysapps.com/subtcffarm/public_html/resources/views/assets/create.blade.php ENDPATH**/ ?>