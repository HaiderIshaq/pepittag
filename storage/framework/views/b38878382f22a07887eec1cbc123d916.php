     



<?php $__env->startSection('content'); ?>
<div class="container-fluid" id="app">
    

    <section>
        
       <surveyor-dashboard 
       usertoken="<?php echo e($data['token']); ?>"
       userid="<?php echo e($data['id']); ?>"
       username="<?php echo e($data['user_name']); ?>"
       usercity="<?php echo e($data['city']); ?>"
       usercityname="<?php echo e($data['city_name']); ?>"
       userregion="<?php echo e($data['region']); ?>"
       usersubcityname="<?php echo e($data['sub_city_name']); ?>"
       usersubcityid="<?php echo e($data['sub_city']); ?>"
       
       ></surveyor-dashboard>

    </section>

</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.surveyapp', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1006556.cloudwaysapps.com/subtcffarm/public_html/resources/views/homesur.blade.php ENDPATH**/ ?>