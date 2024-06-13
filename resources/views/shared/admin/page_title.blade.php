@php
    $userType = 'admin';
@endphp
@if(auth()->user()->user_role == \App\Enums\UserRole::CLIENT)
    @php
        $userType = 'customer';
    @endphp
@endif
<div class="pagetitle">
   <h1>{{$title}}</h1>
   <nav>
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{URL($userType.'/dashboard')}}">Home</a></li>
         <li class="breadcrumb-item active">{{$title}}</li>
      </ol>
   </nav>
</div><!-- End Page Title -->