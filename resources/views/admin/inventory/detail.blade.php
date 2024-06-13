@extends('layouts.admin.dashboard')
@section('title', $title)
@section('content')
@include('shared.admin.page_title')

<section class="section">
   <div class="row align-items-top">
      <!-- Address Card -->
         <div class="col-lg-4 mb-4">
            <div class="card card_custom">
               <div class="card-header card_header_custom">Address
                  @if($record->address_verified == 0 && $record->category_id !== \App\Enums\Category::CAPITAL)
                     <a class="nav-link button-right" href="#" id="verify-address" inventoryId="{{$record->id}}">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 576 512" class="react-icons" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M528 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h480c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zm0 400H48V80h480v352zM208 256c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm-89.6 128h179.2c12.4 0 22.4-8.6 22.4-19.2v-19.2c0-31.8-30.1-57.6-67.2-57.6-10.8 0-18.7 8-44.8 8-26.9 0-33.4-8-44.8-8-37.1 0-67.2 25.8-67.2 57.6v19.2c0 10.6 10 19.2 22.4 19.2zM360 320h112c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8H360c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8zm0-64h112c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8H360c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8zm0-64h112c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8H360c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8z"></path></svg>&nbsp;Verify Address
                     </a>
                  @endif
               </div>
               <div class="card-body">
                  @if($record->category_id !== \App\Enums\Category::CAPITAL)
                     {{ $record->street ? $record->street.',' : '' }} {{ $record->city ? $record->city.',' : '' }} <br>{{ $record->state->name ?? '' }} {{ $record->zipcode ?? '' }}

                     <div><span class="address @if($record->address_verified == 0){{'unverified'}}@else {{'verified'}} @endif">@if($record->address_verified == 0) <i class="bi bi-exclamation-triangle"></i> Unverified @else <i class="bi bi-check-circle"></i> Deliverable @endif</span></div>
                  @endif
               </div>
            </div>
         </div>
      <!-- End Address Card -->

      <!-- Details Card -->
         <div class="col-lg-4 mb-4">
            <div class="card card_custom">
               <div class="card-header card_header_custom">Details
                  <a class="nav-link edit button-right" href="{{ isset($record->id) ? url('admin/inventory/' .$record->id. '/edit') : '#' }}">
                     <i class="bi bi-pencil" aria-hidden="true"></i>&nbsp;Edit
                  </a>
               </div>
               <div class="card-body">
                  @if($record->category_id !== \App\Enums\Category::CAPITAL)
                     Parcel numbers: {{ $record->parcel_number ?? '' }}<br>
                  @else
                     Name: {{ $record->name ?? '' }}<br>
                  @endif
                  @if($record->category_id == \App\Enums\Category::LAND)
                     Total acres: {{ $record->total_acres ?? '' }}<br>
                     Total cost: {{env('CURRENCY').$record->total_cost ?? '' }}<br>
                     Per acre cost: {{env('CURRENCY').$record->per_acre_cost ?? '' }}<br>
                  @endif
                  @if($record->category_id == \App\Enums\Category::RESIDENTIAL)
                     Bedrooms: {{ $record->bedroom ?? '' }}<br>
                     Square footage: {{ $record->square_footage ?? '' }}<br>
                     Price: {{env('CURRENCY').$record->price ?? '' }}<br>
                  @endif
                  @if($record->category_id !== \App\Enums\Category::CAPITAL)
                     Origination fee: {{env('CURRENCY').$record->origination_fee ?? '' }}<br>
                     Closing fee: {{env('CURRENCY').$record->closing_fee ?? '' }}<br>
                     End of term pro rata: {{env('CURRENCY').$record->end_of_term_pro_rata ?? '' }}<br>
                     Total price: {{env('CURRENCY').$record->total_price ?? '' }}<br>
                  @endif

                  @if($record->investor)
                     Investor: {{ $record->investor->name ?? '' }}<br>
                     Investor percentage: {{ $record->investor_percentage.'%' ?? '' }}<br>
                  @endif

                  @if($record->ltv)
                     LTV: {{$record->ltv.'%'}}<br>
                  @endif

                  @if(isset($inventoryPropotion)) 
                     Bank loan amount: {{env('CURRENCY').$inventoryPropotion}}
                  @endif
               </div>
            </div>
         </div>
      <!-- End Details Card -->

      <!-- Buyer's Information Card -->
         <div class="col-lg-4 mb-4">
            <div class="card card_custom">
               <div class="card-header card_header_custom">Buyer's Information</div>
               <div class="card-body">
                  <table class="table table-borderless custom_border_less_table table_break">
                     <thead>
                        <tr>
                           <th scope="col">Name</th>
                           <th scope="col">Email</th>
                           <th scope="col">Payment Method</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           @if($record->loan)
                              <td>{{$record->loan->client->name}}</td>
                              <td>{{$record->loan->client->email}}</td>
                              <td>
                                 @php
                                    $allowedPaymentMethods = json_decode($record->loan->client->allowed_payment_method);
                                 @endphp
                                 @foreach($paymentMethods as $item)
                                    @if(isset($allowedPaymentMethods) && in_array($item->id, $allowedPaymentMethods))
                                       {{$item->name}}
                                    @endif
                                 @endforeach
                              </td>
                           @else
                              <td></td>
                              <td></td>
                              <td></td>
                           @endif
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>   
         </div>
      <!-- End Buyer's Information Card -->
   </div>

   <div class="row align-items-top">
      <!-- Description Card -->
         <div class="col-lg-12">
            <div class="card">
               <div class="card-header card_header_custom">Description
                  @if(empty($record->description))
                     <a class="nav-link button-right" href="#" id="btn-open-add-inventory-description-modal">
                        <i class="bi bi-plus" aria-hidden="true"></i>Add Description
                     </a>
                  @else
                     <a class="nav-link button-right" href="#" class="edit-description" id="edit-description">
                        <i class="bi bi-pencil" aria-hidden="true"></i>&nbsp;Edit
                     </a>
                  @endif
               </div>
               <div class="card-body">
                  @if(empty($record->description))
                     No data found!
                  @else
                     {{$record->description}}
                  @endif
               </div>
            </div>
         </div>
      <!-- End Description Card -->
   </div>

   <div class="row align-items-top">
      <!-- Notes Card -->
         <div class="col-lg-6">
            <div class="card">
               <div class="card-header card_header_custom">Notes
                  <a class="nav-link button-right" href="#" id="btn-open-add-inventory-note-modal">
                     <i class="bi bi-plus" aria-hidden="true"></i>Add Note
                  </a>
               </div>
               <div class="card-body">
                  @if(count($record->inventoryNotes) == 0)
                     No data found!
                  @else
                     @foreach($record->inventoryNotes as $notes)
                     <div class="notes_div_custom">
                        <div class="notes_div_left">
                           <div class="notes_div_left_text">
                              <span>{{$notes->user->name}}</span>
                              <span class="text_time">{{$notes->created_at}}</span>
                           </div>
                           <div class="notes_div_left_desc">
                           {{$notes->note}} 
                           </div>
                        </div>
                        <div class="notes_div_right">
                           <a href="#" class="edit-note" data-note-id="{{ $notes->id }}">Edit</a>
                           <a href="#" class="delete-note" data-note-id="{{ $notes->id }}">Delete</a>
                        </div>
                     </div>
                     @endforeach
                  @endif
               </div>
            </div>
         </div>
      <!-- End Notes Card -->

      <!-- Files Card -->
         <div class="col-lg-6">
            <div class="card">
               <div class="card-header card_header_custom">Files
                  <a class="nav-link btn-add-files button-right" href="#">
                     <i class="bi bi-plus" aria-hidden="true"></i> Add Files
                  </a>
               </div>
            
               <div class="card-body">
                  @if(count($record->inventoryFiles) == 0)
                     No data found!
                  @else
                     @foreach($record->inventoryFiles as $files)
                        <div class="notes_div_custom">
                           <div class="notes_div_left">
                              <div class="notes_div_left_text">
                                 <span>{{$files->user->name}}</span>
                                 <span class="text_time">{{$files->created_at}}</span>
                              </div>
                              <div class="notes_div_left_desc">
                                 <i class="bi bi-file-earmark-fill"></i>
                                 <a href="{{URL::asset('uploads/inventory-files/'.$record->id.'/'.$files->file_name)}}" target="_blank">
                                    {{$files->file_title}} {{$files->file_name}} 
                                 </a>
                              </div>
                           </div>
                           <div class="notes_div_right">
                           <a href="#" class="delete-file" data-file-id="{{ $files->id }}">Delete</a>
                           </div>
                        </div>
                     @endforeach
                  @endif
               </div>
            </div>
         </div>
      <!-- End Files Card -->
   </div>

   <div class="row align-items-top">
      <!-- Reports Card -->
         <div class="col-lg-12">
            <div class="card">
               <div class="card-header card_header_custom">Report</div>
               <div class="card-body">
                  <table class="table table-borderless custom_border_less_table table_break">
                     <thead>
                        <tr>
                           <th scope="col">Loan Label</th>
                           <th scope="col">Total Amount</th>
                           <th scope="col">Received Amount</th>
                           <th scope="col">Last Payment Date</th>
                           <th scope="col">Loan Duration (in years)</th>
                           <th scope="col">Total Payment Overdue Charges</th>
                           <th scope="col">Total Escrow Amount</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if($record->loan)
                           <tr>
                              <td>{{$record->loan->loan_label}}</td>
                              <td>{{env('CURRENCY').$record->loan->total_payment}}</td>
                              @php
                                 $receivedAmount = 0;
                                 $lateFeeAmount = 0;
                              @endphp
                              @foreach($record->loan->loanEntry as $loanEntry)
                                 @php
                                    $receivedAmount += $loanEntry->received_amount;
                                 @endphp
                                 @if($record->loan->late_fee_application !== 3 && $loanEntry->late_fee_applied == 1)
                                    @php $lateFeeAmount += $record->loan->late_fee_amount; @endphp
                                 @endif
                              @endforeach
                              <td>{{env('CURRENCY').$receivedAmount}}</td>
                              <td>{{ (!empty($value->latestLoanEntry->paid_date)) ? date('d M, Y', strtotime($value->latestLoanEntry->paid_date)) : '-' }}</td>
                              <td>{{$record->loan->duration}}</td>
                              <td>{{env('CURRENCY').$lateFeeAmount}}</td>
                              <td>{{env('CURRENCY').$record->loan->latestEscrow->payment_amount}}</td>
                           </tr>
                        @else
                           <tr>
                              <td colspan="100" class="no-record-found">No data found!</td>
                           </tr>
                        @endif
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      <!-- End Reports Card -->

      <!-- Bank Loan Reports Card -->
         <div class="col-lg-12">
            <div class="card">
               <div class="card-header card_header_custom">Bank Loan Report</div>
               <div class="card-body">
                  <table class="table table-borderless custom_border_less_table table_break">
                     <thead>
                        <tr>
                           <th scope="col">Total Amount</th>
                           <th scope="col">Paid Amount</th>
                           <th scope="col">Last Payment Date</th>
                           <th scope="col">Loan Duration (in years)</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(isset($bankLoans))
                           @php
                              $totalAmount = 0;
                              $paidAmount = 0;
                           @endphp
                           @foreach($bankLoans->bankLoanEntry as $loanEntry)
                              @php
                                 $totalAmount += $loanEntry->amount;
                                 $paidAmount += $loanEntry->paid_amount;
                              @endphp
                           @endforeach
                           <tr>
                              <td>{{env('CURRENCY').$totalAmount}}</td>
                              <td>{{env('CURRENCY').$paidAmount}}</td>
                              <td>{{ (!empty($bankLoans->latestBankLoanEntry->paid_date)) ? date('d M, Y', strtotime($bankLoans->latestBankLoanEntry->paid_date)) : '-' }}</td>
                              <td>{{$bankLoans->duration}}</td>
                           </tr>
                        @else
                           <tr>
                              <td colspan="100" class="no-record-found">No data found!</td>
                           </tr>
                        @endif
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      <!-- End Reports Card -->
   </div>
</section>

<!-- Add notes for inventory Modal -->
<div class="modal fade" id="inventoryNoteModal" tabindex="-1">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Add Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="card">
               <div class="card-body">
                  <h5 class="card-title">Add Note</h5>
                  <form id="form-add-inventory-note" method="">
                     <input type="hidden" value="{{$record->id}}" id="inventory_id" name="inventory_id" />
                     <input type="hidden" value="{{Auth::user()->id}}" id="user_id" name="user_id" />
                     <div class="row">
                        <!-- <div class="col-6"> -->
                           <textarea class="form-control" name="inventory_note" id="inventory_note" rows="5" cols="100"></textarea>
                        <!-- </div> -->
                     </div>
                     <div class="text-danger" id="validation-errors"> 
                     </div>
                  </form>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               <button type="button" id="btn-add-inventory-note" class="btn btn-primary">Save changes</button>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Update note for inventory Modal -->
<div class="modal fade" id="inventoryEditNoteModal" tabindex="-1">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Edit Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="card">
               <div class="card-body">
                  <h5 class="card-title">Update Note</h5>
                  <form id="form-update-inventory-note" >
               
                     <input type="hidden" value="{{$record->id}}" id="inventory_id" name="inventory_id" />
                     <input type="hidden" value="{{Auth::user()->id}}" id="user_id" name="user_id" />
                     <input type="hidden"  id="note_id" name="note_id" />
                     <div class="row">
                        <!-- <div class="col-6"> -->
                           <textarea class="form-control" name="edit_inventory_note" id="edit_inventory_note" rows="5" cols="100"></textarea>
                        <!-- </div> -->
                     </div>
                     <div class="text-danger" id="validation-errors"> 
                     </div>
                  </form>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               <button type="button" id="btn-update-inventory-note" class="btn btn-primary">Update changes</button>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Delete confirmation modal for notes -->
<div class="modal fade" id="confirmationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this note?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete confirmation modal for files -->
<div class="modal fade" id="fileconfirmationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this file?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmfileDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for adding files -->
<div class="modal fade" id="addFilesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Inventory Files</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="text-danger" id="file-validation-errors"></div>
                <form id="form-add-files" enctype="multipart/form-data">
                  @csrf
                   <input type="hidden" value="{{$record->id}}" id="inventory_id" name="inventory_id" />
                  <input type="hidden" value="{{Auth::user()->id}}" id="user_id" name="user_id" />
                  <div class="mb-3">
                        <label for="fileTitle" class="form-label">File Title</label>
                        <input class="form-control" type="text" id="fileTitle" name="fileTitle" placeholder="eg:Noc, Land papers" >
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Select Files</label>
                        <input class="form-control" type="file" id="file" name="file[]" multiple>
                    </div>
                  
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for adding inventory description -->
<div class="modal fade" id="inventoryAddDescriptionModal" tabindex="-1">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Add Description</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="card">
               <div class="card-body">
                  <h5 class="card-title">Add Description</h5>
                  <form id="form-add-inventory-description" >
               
                     <input type="hidden" value="{{$record->id}}" id="inventory_id" name="inventory_id" />
            
                     <div class="row">
                        <!-- <div class="col-6"> -->
                           <textarea class="form-control" name="inventoryDescription" id="inventoryDescription" rows="5" cols="100"></textarea>
                        <!-- </div> -->
                     </div>
                     <div class="text-danger" id="validation-errors"> 
                     </div>
                  </form>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               <button type="button" id="btn-add-inventory-description" class="btn btn-primary">Save changes</button>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Modal for updating inventory description -->
<div class="modal fade" id="inventoryEditDescriptionModal" tabindex="-1">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Edit Description</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="card">
               <div class="card-body">
                  <h5 class="card-title">Update Description</h5>
                  <form id="form-update-inventory-description" >
               
                     <input type="hidden" value="{{$record->id}}" id="inventory_id" name="inventory_id" />
            
                     <div class="row">
                        <!-- <div class="col-6"> -->
                           <textarea class="form-control"  name="inventoryDescription" id="editInventoryDescription" rows="5" cols="100">{{$record->description ? $record->description:''}}</textarea>
                        <!-- </div> -->
                     </div>
                     <div class="text-danger" id="validation-errors"> 
                     </div>
                  </form>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               <button type="button" id="btn-update-inventory-description" class="btn btn-primary">Update changes</button>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection