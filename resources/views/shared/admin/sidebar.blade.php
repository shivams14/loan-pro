 <?php
   use App\Enums\UserRole;
   use Illuminate\Support\Facades\Route;

   $currentAction = '';
   $currentController = '';
   $latestRouteName = Route::getCurrentRoute()->getActionName();
   $latestRouteNameArr = explode('@', $latestRouteName);
   if (!empty($latestRouteNameArr)) {
      if (isset($latestRouteNameArr[0])) {
         $conrollerArr =  explode("\\", $latestRouteNameArr[0]);
         $currentController = end($conrollerArr);
      }
      $currentAction = $latestRouteNameArr[1];
   }
   $userData = auth()->guard()->user();

   $activeArrAction = array('index', 'edit', 'create');
   $userType = 'admin';
   $route = '';
   if(auth()->user()->user_role == UserRole::CLIENT) {
      $userType = 'customer';
      $route = 'customer.';
   }
?>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
   <ul class="sidebar-nav" id="sidebar-nav">
      <?php $activeArrController = array('AdminController', 'CustomerController'); ?>
      <li class="nav-item">
         <a class="nav-link <?php echo (in_array($currentController, $activeArrController)) ? '' : 'collapsed'; ?>" href="{{URL($userType.'/dashboard')}}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
         </a>
      </li>

      @if($userType == 'admin')
         <?php $activeArrController = array('InventoryController'); ?>
         <li class="nav-item">
            <a class="nav-link  <?php echo (in_array($currentController, $activeArrController)) ? '' : 'collapsed'; ?>" href="{{URL($userType.'/inventory')}}">
               <i class="bi bi-card-list"></i>
               <span>Inventory</span>
            </a>
         </li>

         <?php $activeArrController = array('ClientController'); ?>
         <li class="nav-item">
            <a class="nav-link <?php echo (in_array($currentController, $activeArrController)) ? '' : 'collapsed'; ?>" href="{{URL($userType.'/client')}}">
               <i class="bi bi-menu-button-wide"></i>
               <span>Clients</span>
            </a>
         </li>
      @endif

      <?php $activeArrController = array('SupportController'); ?>
      <li class="nav-item">
         <a class="nav-link <?php echo (in_array($currentController, $activeArrController)) ? '' : 'collapsed'; ?>" href="{{ route($route.'support') }}">
            <i class="bi bi-layout-text-window-reverse"></i>
            <span>Support</span>
         </a>
      </li>

      <?php $activeArrController = array('ProfileController'); ?>
      <li class="nav-item">
         <a class="nav-link <?php echo (in_array($currentController, $activeArrController)) ? '' : 'collapsed'; ?>" href="{{ route($route.'profile', auth()->user()->id) }}">
            <i class="bi bi-person"></i>
            <span>Profile</span>
         </a>
      </li>

      <li class="nav-heading">Masters</li>

      
      <?php
         $activeArrController = array('ClientTypeController', 'InventoryTypeController');
         $activeArrAction = array('index', 'edit', 'create', 'show');
      ?>
      <li class="nav-item <?php echo (in_array($currentController, $activeArrController)) ? 'active' : ''; ?>">
         <a class="nav-link <?php echo (in_array($currentController, $activeArrController)) ? '' : 'collapsed'; ?> " data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-menu-button-wide"></i><span>Management</span><i class="bi bi-chevron-down ms-auto"></i>
         </a>
         <ul id="components-nav" class="nav-content collapse <?php echo (in_array($currentController, $activeArrController)) ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
            @if($userType == 'admin')
               <li>
                  <a href="{{URL($userType.'/inventory-type')}}" class="<?php echo ((in_array($currentAction, $activeArrAction)) && ($currentController == 'InventoryTypeController')) ? 'active' : ''; ?>">
                     <i class="bi bi-circle"></i><span>Inventory Type</span>
                  </a>
               </li>
               <li>
                  <a href="{{URL($userType.'/client-type')}}" class="<?php echo ((in_array($currentAction, $activeArrAction)) && ($currentController == 'ClientTypeController')) ? 'active' : ''; ?>">
                     <i class="bi bi-circle"></i><span>Client Type</span>
                  </a>
               </li>
            @endif
         </ul>
      </li>

      <li class="nav-item">
         <a class="nav-link collapsed" href="{{URL($userType.'/logout')}}">
            <i class="bi bi-box-arrow-in-right"></i>
            <span>Logout</span>
         </a>
      </li>
   </ul>
</aside>