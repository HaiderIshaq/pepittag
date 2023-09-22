    
    


<?php $__env->startSection('content'); ?>
<div class="container-fluid" id="app">
    <section>

       <statistics 
       usertoken="<?php echo e($data['token']); ?>"
       userregion="<?php echo e($data['region']); ?>"
       usercity="<?php echo e($data['city']); ?>"
       url="<?php echo e(url('/')); ?>"></statistics>

       

    </section>

<br><br><br><br>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1006556.cloudwaysapps.com/subtcffarm/public_html/resources/views/statistics.blade.php ENDPATH**/ ?>