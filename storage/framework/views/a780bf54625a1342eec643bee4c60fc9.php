    
    


<?php $__env->startSection('content'); ?>
<div class="container-fluid" id="app">
    
    <section>
        
       <dashboard 
       usertoken="<?php echo e($data['token']); ?>"
       userregion="<?php echo e($data['region']); ?>"
       usercity="<?php echo e($data['city']); ?>"
       usercity="<?php echo e($data['city']); ?>"
       usercityname="<?php echo e($data['city_name']); ?>"
       userregion="<?php echo e($data['region']); ?>"
       usersubcityname="<?php echo e($data['sub_city_name']); ?>"
       usersubcityid="<?php echo e($data['sub_city']); ?>"

       url="<?php echo e(url('/')); ?>"></dashboard>

    </section>


</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\asset_tag_pepsi\public_html\resources\views/home.blade.php ENDPATH**/ ?>