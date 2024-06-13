@extends('layouts.admin.dashboard')
@section('title', $title)
@section('content')
@include('shared.admin.page_title')

@php $route = ''; @endphp
@if(auth()->user()->user_role == \App\Enums\UserRole::CLIENT)
   @php $route = 'customer.'; @endphp
@endif

<section class="section dashboard">
   <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-8">
         <div class="row">
            @if($route == '')

            <div class="col-xxl-4 col-md-6">
               <div class="card info-card sales-card">
                  <div class="card-body">
                     <h5 class="card-title">Inventory <span>| Total</span></h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-cart"></i>
                        </div>
                        <div class="ps-3">
                           <h6>{{$total_inventory}}</h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-xxl-4 col-md-6">
               <div class="card info-card sales-card">
                  <div class="card-body">
                     <h5 class="card-title">Client <span>| Total</span></h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="ps-3">
                           <h6>{{$total_client}}</h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endif
         </div>
      </div>
      <!-- End Left side columns -->

      <!-- Right side columns -->
      <div class="col-lg-4">
         <!-- Top Selling -->
         <div class="col-12">
            <div class="card top-selling overflow-auto">

               <div class="card-body pb-0">
                  <h5 class="card-title">Latest Transaction</h5>

                  <table class="table table-borderless">
                     <thead>
                        <tr>
                           <th scope="col">Date</th>
                           <th scope="col">Loan</th>
                           <th scope="col">Amount</th>
                        </tr>
                     </thead>
                     <tbody>
                        <!--  -->
                     </tbody>
                  </table>
               </div>
            </div>
         </div><!-- End Top Selling -->
      </div><!-- End Right side columns -->
   </div>
</section>

@endsection