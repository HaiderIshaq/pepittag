    


<?php $__env->startSection('content'); ?>
<div class="container-fluid" id="app">
    <section>
        
       <user-edit  usertoken="<?php echo e($data['token']); ?>" jobid="<?php echo e($data['id']); ?>" url="<?php echo e(url('/')); ?>"></user-edit>

    </section>


</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1006556.cloudwaysapps.com/subtcffarm/public_html/resources/views/user/edit.blade.php ENDPATH**/ ?>