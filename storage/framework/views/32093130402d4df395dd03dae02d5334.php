    


<?php $__env->startSection('content'); ?>
<div class="container-fluid">
   
    <div class="row">

        <div class="col-md-12 mt-3">
            <h4>
                <b>Upload Jobs in bulk</b>
            </h4>

                <form action="<?php echo e(route('upload')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row mt-2 mb-2">
                        <div class="col-md-12">
                            <input type="file" name="csv">
                        </div>
                    </div>
                    <div class="row mt-2 mb-2">
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="inlineRadio1" value="1">
                                <label class="form-check-label" for="inlineRadio1">Cooler / Freezer</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="inlineRadio2" value="2">
                                <label class="form-check-label" for="inlineRadio2">Vehicle</label>
                              </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary btn-sm" value="Submit">
              </form>

        </div>

    </div>

</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1006556.cloudwaysapps.com/subtcffarm/public_html/resources/views/jobs.blade.php ENDPATH**/ ?>