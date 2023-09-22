
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-body-tertiary sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
      <ul class="nav flex-column">
          <?php if(auth()->guard()->guest()): ?>
          <?php else: ?>
          <li class="nav-item">
              <a class="nav-link " aria-current="page" href="#">
                <b>Welcome </b><?php echo e(Auth::user()->name); ?> 
  
             
                
              </a>
            </li>
          <?php endif; ?>
          <?php if(Auth::user()->role==1 ||   Auth::user()->role==2 || Auth::user()->role==3): ?>

        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/home">
            
            <i class="fa fa-house p-2"></i>
            <b>Dashboard</b>
          </a>
        </li>
        <?php endif; ?>
        <?php if(Auth::user()->role==1): ?>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/users">
            
            <i class="fa fa-user p-2"></i>
            Users
          </a>
        </li>
        <?php endif; ?>
        <?php if(Auth::user()->role==1 ||  Auth::user()->role==5 ||  Auth::user()->role==2): ?>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/statistics">
            
            <i class="fa fa-chart-pie p-2"></i>
            Statistics
          </a>
        </li>
        <?php endif; ?>

        <li class="nav-item">
          <?php if(auth()->guard()->guest()): ?>
          <?php if(Route::has('login')): ?>
            <a class="nav-link px-3" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
  
          <?php endif; ?>
  
          
      <?php else: ?>   
          <li class="nav-item dropdown">
              
           <a class="nav-link px-3" href="<?php echo e(route('logout')); ?>"
           onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket mt-2" style="padding-left: 6px"></i>
                        <span style="margin-left: 5px">
                           <?php echo e(__('Logout')); ?>


                        </span> 
                        
                        </a>
  
  
           <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
               <?php echo csrf_field(); ?>
           </form>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                <?php echo e(__('Logout')); ?>

                  </a>
  
                  <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                      <?php echo csrf_field(); ?>
                  </form>
              </div>
          </li>
      <?php endif; ?>
  
        </li>
      </ul>        
    </div>
  </nav><?php /**PATH /home/1006556.cloudwaysapps.com/subtcffarm/public_html/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>