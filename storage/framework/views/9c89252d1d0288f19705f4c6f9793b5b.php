    


<?php $__env->startSection('content'); ?>
<div class="container-fluid" id="app">
    <section>
        
       <users usertoken="<?php echo e($data['token']); ?>" url="<?php echo e(url('/')); ?>"></users>

    </section>


</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\asset_tag_pepsi\public_html\resources\views/user/index.blade.php ENDPATH**/ ?>