<?php

namespace App\Http\Controllers;

use App\Enums\Category as EnumsCategory;
use App\Enums\Status;
use App\Enums\Steps;
use App\Enums\UserRole;
use App\Models\BankLoan;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Category;
use App\Models\Country;
use App\Models\InventoryNote;
use App\Models\State;
use App\Models\InventoryFile;
use App\Models\InventoryType;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Exception;
use Illuminate\Validation\Rule;

class InventoryController extends Controller
{
    protected $data = [];

    public function __construct() {
        $this->data['title'] = 'Inventory';
        $this->data['customJS'] = 'admin_inventory';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Inventory::withoutTrashed()->latest()->get();
        $this->data['records'] = $records;
        return view('admin.inventory.index', $this->data);
    }

    public function getInventoryData()
    {
        $records = Inventory::select(['inventories.*', 'inventories.name as inventoryName'])->withoutTrashed()->with(['inventoryType']);

        return DataTables::eloquent($records)
            ->addColumn('inventory_name', function ($record) {
                return $record->inventoryName; // Access the related inventory type name
            })
            ->addColumn('category_name', function ($record) {
                if($record->category_id == EnumsCategory::LAND) {
                    return 'Land';
                } elseif($record->category_id == EnumsCategory::RESIDENTIAL) {
                    return 'Residential';
                } else {
                    return 'Capital';
                }
            })
            ->addColumn('status', function ($record) {
                if($record->status == Status::IDEA) {
                    return 'Idea';
                } elseif($record->status == Status::READY) {
                    return 'Ready';
                } elseif($record->status == Status::INPROGRESS) {
                    return 'In progress';
                } elseif($record->status == Status::COMPLETED) {
                    return 'Completed';
                } else {
                    return '-';
                }
            })
            ->addColumn('inventory_type_name', function ($record) {
                return $record->inventoryType->typeName; // Access the related inventory type name
            })
            ->addColumn('action', function ($record) {
                return '<a class="btn btn-primary" href="' . url('admin/inventory/' . $record->id . '/edit') . '">Edit</a>
                    <a class="btn btn-primary" href="' . url('admin/inventory/' . $record->id . '/detail') . '">Detail</a>
                    <form method="POST" action="' . route('inventory.destroy', $record->id) . '" style="display:inline" id="delete-inventory'.$record->id.'">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger confirm delete-inv-btn" id="'.$record->id.'">Delete</button>
                    </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['categories'] = Category::withoutTrashed()->latest()->get();
        $this->data['inventoryTypes'] = InventoryType::withoutTrashed()->latest()->get();
        $this->data['countries'] = Country::withoutTrashed()->oldest()->get();
        $this->data['states'] = State::withoutTrashed()->oldest()->get();
        $this->data['investor'] = User::withoutTrashed()->where('active_status', Status::ENABLE)->where('user_role', UserRole::INVESTOR)->get();
        $this->data['record'] = [];

        return view('admin.inventory.create', $this->data);
    }

    /* Validate the fields according to the steps */
    public function validateFields(Request $request) {
        $post = $request->all();
        // print_r($post);die;
        $returnData = [];
        $id = '';
        if(isset($post['update_form']) && !empty($post['update_form'])) {
            $id = $post['update_form'];
        }
        /* First Step */
        if($post['current_step'] == Steps::BASIC) {
            $rules = [
                'category_id'         => 'required|integer',
                'inventory_type_id'   => 'required|integer|exists:inventory_types,id',
                'status'              => 'required|integer',
                'is_own_inventory'    => 'nullable',
                'investor_id'         => 'sometimes|required_without:is_own_inventory|nullable|integer|'. Rule::exists('users', 'id')->where('user_role', UserRole::INVESTOR)->where('active_status', Status::ENABLE),
                'investor_percentage' => 'sometimes|required_without:is_own_inventory|nullable|numeric|between:0,99.99',
                'ltv'                 => 'sometimes|numeric|nullable'
            ];
            $messages = [
                'category_id.required'                 => 'Please select the category!',
                'inventory_type_id.required'           => 'Please select the inventory type!',
                'inventory_type_id.exists'             => 'Please select the valid inventory type!',
                'status.required'                      => 'Please select the status!',
                'investor_id.required_without'         => 'Please select the investor!',
                'investor_id.exists'                   => 'Please select the valid investor!',
                'investor_percentage.required_without' => 'Please enter the percentage!',
                'investor_percentage.numeric'          => 'Please enter the percentage in numeric!',
                'investor_percentage.between'          => 'Please enter the valid percentage in between 0 to 2 digits! (excluding digits after decimal)',
                'ltv.numeric'                          => 'Please enter the ltv in numeric!'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $returnData['status'] = Status::INTERNAL_ERROR;
                $returnData['messages'] = $validator->messages();
            } else {
                $returnData['status'] = Status::SUCCESS;
                $returnData['messages'] = 'Success';
            }
        }
        /* Second Step */
        if($post['current_step'] == Steps::DETAILS) {
            if($post['category_id'] == EnumsCategory::LAND) {
                $rules = [
                    'name'                 => 'required|unique:inventories,name,'.$id.',id,deleted_at,NULL|max:25',
                    'county'               => 'required|max:25',
                    'country_id'           => 'required|integer|exists:countries,id',
                    'state_id'             => 'required|integer|exists:states,id',
                    'total_acres'          => 'required|integer|min_digits:0|max_digits:4',
                    'total_cost'           => 'required|numeric|between:0,9999999999.99',
                    // 'total_cost'        => 'exclude_if:cost_of_development,2|required|numeric|between:0,9999999999.99',
                    'per_acre_cost'        => 'required|numeric|between:0,9999999999.99',
                    'origination_fee'      => 'required|numeric|between:0,9999999999.99',
                    'closing_fee'          => 'required|numeric|between:0,9999999999.99',
                    'end_of_term_pro_rata' => 'required|numeric|between:0,9999999999.99',
                    'total_price'          => 'required|numeric|between:0,9999999999.99'
                ];
            } elseif($post['category_id'] == EnumsCategory::RESIDENTIAL) {
                $rules = [
                    'street'               => 'required|unique:inventories,name,'.$id.',id,deleted_at,NULL|max:25',
                    'city'                 => 'required',
                    'county'               => 'required|max:25',
                    'country_residential'  => 'required|integer|exists:countries,id',
                    'state_residential'    => 'required|integer|exists:states,id',
                    'zipcode'              => 'required|integer|min_digits:0|max_digits:6',
                    'bedroom'              => 'nullable|integer|min_digits:0|max_digits:2',
                    'bathroom'             => 'nullable|integer|min_digits:0|max_digits:2',
                    'square_footage'       => 'nullable|integer|min_digits:0|max_digits:4',
                    'lot_area'             => 'nullable|integer|min_digits:0|max_digits:4',
                    'price'                => 'required|numeric|between:0,9999999999.99',
                    'origination_fee'      => 'required|numeric|between:0,9999999999.99',
                    'closing_fee'          => 'required|numeric|between:0,9999999999.99',
                    'end_of_term_pro_rata' => 'required|numeric|between:0,9999999999.99',
                    'total_price'          => 'required|numeric|between:0,9999999999.99'
                ];
            } else {
                $rules = [
                    'name' => 'required|unique:inventories,name,'.$id.',id,deleted_at,NULL|max:25'
                ];
            }
            $messages = [
                'name.required'                 => 'Please enter the name!',
                'name.unique'                   => 'This name has already been taken!',
                'name.max'                      => 'Please don\'t enter the name more than :max characters!',
                'county.required'               => 'Please enter the county!',
                'county.required'               => 'Please don\'t enter the county more than :max characters!',
                'country_id.required'           => 'Please select the country!',
                'country_id.exists'             => 'Please select the valid country!',
                'state_id.required'             => 'Please select the state!',
                'state_id.exists'               => 'Please select the valid state!',
                'country_residential.required'  => 'Please select the country!',
                'country_residential.exists'    => 'Please select the valid country!',
                'state_residential.required'    => 'Please select the state!',
                'state_residential.exists'      => 'Please select the valid state!',
                'total_acres.required'          => 'Please enter the total acres!',
                'total_acres.integer'           => 'Please enter the total acres in numeric!',
                'total_acres.min_digits'        => 'Please enter the valid total acres!',
                'total_acres.max_digits'        => 'Please don\'t enter the total acres more than :max digits!',
                'total_cost.required'           => 'Please enter the total cost!',
                'total_cost.numeric'            => 'Please enter the total cost in numeric!',
                'total_cost.between'            => 'Please enter the total cost in between 0 to 10 digits! (excluding digits after decimal)',
                'per_acre_cost.required'        => 'Please enter the per acre cost!',
                'per_acre_cost.numeric'         => 'Please enter the per acre cost in numeric!',
                'per_acre_cost.between'         => 'Please enter the per acre cost in between 0 to 10 digits! (excluding digits after decimal)',
                'street.required'               => 'Please enter the street address!',
                'street.unique'                 => 'This street address has already been taken!',
                'street.max'                    => 'Please don\'t enter the street address more than :max characters!',
                'city.required'                 => 'Please enter the city name!',
                'zipcode.required'              => 'Please enter the zip code!',
                'zipcode.integer'               => 'Please enter the zip code in numeric!',
                'zipcode.min_digits'            => 'Please enter the valid zip code!',
                'zipcode.max_digits'            => 'Please don\'t enter the zip code more than :max digits!',
                'bedroom.integer'               => 'Please enter the bedroom in numeric!',
                'bedroom.min_digits'            => 'Please enter the valid bedroom!',
                'bedroom.max_digits'            => 'Please don\'t enter the bedroom more than :max digits!',
                'bathroom.integer'              => 'Please enter the bathroom in numeric!',
                'bathroom.min_digits'           => 'Please enter the valid bathroom!',
                'bathroom.max_digits'           => 'Please don\'t enter the bathroom more than :max digits!',
                'square_footage.integer'        => 'Please enter the square footage in numeric!',
                'square_footage.min_digits'     => 'Please enter the valid square footage!',
                'square_footage.max_digits'     => 'Please don\'t enter the square footage more than :max digits!',
                'lot_area.integer'              => 'Please enter the lot area in numeric!',
                'lot_area.min_digits'           => 'Please enter the valid lot area!',
                'lot_area.max_digits'           => 'Please don\'t enter the lot area more than :max digits!',
                'price.required'                => 'Please enter the price!',
                'price.numeric'                 => 'Please enter the price in numeric!',
                'price.between'                 => 'Please enter the price in between 0 to 10 digits! (excluding digits after decimal)',
                'origination_fee.required'      => 'Please enter the origination fee!',
                'origination_fee.numeric'       => 'Please enter the origination fee in numeric!',
                'origination_fee.between'       => 'Please enter the origination fee in between 0 to 10 digits! (excluding digits after decimal)',
                'closing_fee.required'          => 'Please enter the closing fee!',
                'closing_fee.numeric'           => 'Please enter the closing fee in numeric!',
                'closing_fee.between'           => 'Please enter the closing fee in between 0 to 10 digits! (excluding digits after decimal)',
                'end_of_term_pro_rata.required' => 'Please enter the end of term pro rata!',
                'end_of_term_pro_rata.numeric'  => 'Please enter the end of term pro rata in numeric!',
                'end_of_term_pro_rata.between'  => 'Please enter the end of term pro rata in between 0 to 10 digits! (excluding digits after decimal)',
                'total_price.required'          => 'Please enter the total price!',
                'total_price.numeric'           => 'Please enter the total price in numeric!',
                'total_price.between'           => 'Please enter the total price in between 0 to 10 digits! (excluding digits after decimal)'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $returnData['status'] = Status::INTERNAL_ERROR;
                $returnData['messages'] = $validator->messages();
            } else {
                $returnData['status'] = Status::SUCCESS;
                $returnData['messages'] = 'Success';
            }
        }

        return response()->json($returnData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $insertArr = [];
            /* First Step */
            $category = $request->category_id;
            $insertArr['category_id'] = $category;
            $insertArr['inventory_type_id'] = $request->inventory_type_id;
            $insertArr['status'] = $request->status;
            $insertArr['is_own_inventory'] = ($request->is_own_inventory !== 'on') ? 0 : 1;
            if($insertArr['is_own_inventory'] == 0) {
                $insertArr['investor_id'] = $request->investor_id;
                $insertArr['investor_percentage'] = $request->investor_percentage;
            }

            $insertArr['ltv'] = $request->ltv;
            $insertArr['origination_fee'] = $request->origination_fee;
            $insertArr['closing_fee'] = $request->closing_fee;
            $insertArr['end_of_term_pro_rata'] = $request->end_of_term_pro_rata;
            $insertArr['total_price'] = $request->total_price;

            /* Second Step */
            if($category == EnumsCategory::LAND) {
                $insertArr['name'] = $request->name;
                $insertArr['county'] = $request->county;
                $insertArr['country_id'] = $request->country_id;
                $insertArr['state_id'] = $request->state_id;
                $insertArr['parcel_number'] = $request->parcel_number;
                $insertArr['total_acres'] = $request->total_acres;
                $insertArr['cost_of_development'] = $request->cost_of_development;
                $insertArr['total_cost'] = $request->total_cost;
                $insertArr['per_acre_cost'] = $request->per_acre_cost;
            } elseif($category == EnumsCategory::RESIDENTIAL) {
                $insertArr['name'] = $request->street;
                $insertArr['street'] = $request->street;
                $insertArr['city'] = $request->city;
                $insertArr['county'] = $request->county;
                $insertArr['country_id'] = $request->country_residential;
                $insertArr['state_id'] = $request->state_residential;
                $insertArr['zipcode'] = $request->zipcode;
                $insertArr['parcel_number'] = $request->parcel_number;
                $insertArr['bedroom'] = $request->bedroom;
                $insertArr['bathroom'] = $request->bathroom;
                $insertArr['square_footage'] = $request->square_footage;
                $insertArr['lot_area'] = $request->lot_area;
                $insertArr['lot_area_type'] = $request->lot_area_type;
                $insertArr['price'] = $request->price;
            } else {
                $insertArr['name'] = $request->name;
            }

            Inventory::create($insertArr);

            return redirect("admin/inventory/")->with('success', 'Inventory created successfully!');
        } catch (Exception $e) {
            return redirect("admin/inventory/")->with('danger', 'Something went wrong. Please try again!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $records = Inventory::with('category', 'inventoryType', 'country', 'state', 'inventoryNotes', 'inventoryFiles', 'loan')->withoutTrashed()->find($id);

        $this->data['paymentMethods'] = PaymentMethod::withoutTrashed()->latest()->get();

        $this->data['record'] = $records;

        /* Retrieving the bank loans related to this inventory */
        $bankLoans = BankLoan::withoutTrashed()->get();
        if(!empty($bankLoans)) {
            foreach($bankLoans as $bankLoan) {
                $inventory = ($bankLoan->loan_type == Status::GROUP_LOAN) ? json_decode($bankLoan->inventory_id) : $bankLoan->inventory_id;

                if($bankLoan->loan_type == Status::GROUP_LOAN) {
                    foreach($inventory as $value) {
                        if($records->id == $value) {
                            $this->data['bankLoans'] = BankLoan::find($bankLoan->id);
                            $loanAmount = $this->data['bankLoans']->loan_amount;
                            $inventoryIds = json_decode($this->data['bankLoans']->inventory_id);
                            $inventoryAmount = 0;
                            $inventoriesTotalAmount = 0;
                            foreach($inventoryIds as $inventoryId) {
                                $inventoryData = Inventory::find($inventoryId);
                                $totalAmount = 0;
                                if($inventoryData->category_id == EnumsCategory::LAND) {
                                    $totalAmount = $inventoryData->total_cost;
                                } elseif($inventoryData->category_id == EnumsCategory::RESIDENTIAL) {
                                    $totalAmount = $inventoryData->price;
                                }
                                $inventoriesTotalAmount += $totalAmount;
                            }
                            $this->data['totalAmountInv'] = $inventoriesTotalAmount;
                            if($records->category_id == EnumsCategory::LAND) {
                                $inventoryAmount = $records->total_cost;
                            } elseif($records->category_id == EnumsCategory::RESIDENTIAL) {
                                $inventoryAmount = $records->price;
                            }
                            if($inventoryAmount != 0) {
                                $percentage = $inventoryAmount / $this->data['totalAmountInv'] * 100;
                                $percentage = round($percentage, 2);
                                $this->data['inventoryPropotion'] = $loanAmount * $percentage / 100;
                            }
                            break;
                        }
                    }
                } else {
                    if($records->id == $inventory) {
                        $this->data['bankLoans'] = BankLoan::find($bankLoan->id);
                        $this->data['inventoryPropotion'] = $this->data['bankLoans']->loan_amount;
                        break;
                    }
                }
            }
        }
        return view('admin.inventory.detail', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $records = Inventory::with('category', 'inventoryType', 'country', 'state')->withoutTrashed()->find($id);

        $this->data['countries'] = Country::withoutTrashed()->oldest()->get();
        $this->data['states'] = State::withoutTrashed()->where('country_id', $records->country_id)->get();
        $this->data['categories'] = Category::withoutTrashed()->latest()->get();
        $this->data['inventoryTypes'] = InventoryType::withoutTrashed()->latest()->get();
        $this->data['investor'] = User::withoutTrashed()->where('active_status', Status::ENABLE)->where('user_role', UserRole::INVESTOR)->get();
        $this->data['record'] = $records;

        return view('admin.inventory.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = $request->all();
        $inventory = Inventory::withoutTrashed()->find($id);

        $inventory->category_id = $post['category_id'];

        if (isset($post['inventory_type_id']))
            $inventory->inventory_type_id = $post['inventory_type_id'];

        if (isset($post['status']))
            $inventory->status = $post['status'];

        $inventory->is_own_inventory = (isset($post['is_own_inventory']) && $post['is_own_inventory'] === 'on') ? 1 : 0;

        if ($inventory->is_own_inventory == 1) {
            $post['investor_id'] = null;
            $post['investor_percentage'] = null;
        }
        if (isset($post['investor_id']) || $post['investor_id'] == null)
            $inventory->investor_id = $post['investor_id'];

        if (isset($post['investor_percentage']) || $post['investor_percentage'] == null)
            $inventory->investor_percentage = $post['investor_percentage'];

        if (isset($post['ltv'])) {
            $inventory->ltv = $post['ltv'];
        } else {
            $inventory->ltv = null;
        }

        if (isset($post['origination_fee']))
            $inventory->origination_fee = $post['origination_fee'];

        if (isset($post['closing_fee']))
            $inventory->closing_fee = $post['closing_fee'];

        if (isset($post['end_of_term_pro_rata']))
            $inventory->end_of_term_pro_rata = $post['end_of_term_pro_rata'];

        if (isset($post['total_price']))
            $inventory->total_price = $post['total_price'];

        if ($inventory->category_id == EnumsCategory::LAND) {
            if (isset($post['name']))
                $inventory->name = $post['name'];

            if (isset($post['county']))
                $inventory->county = $post['county'];

            if (isset($post['country_id']))
                $inventory->country_id = $post['country_id'];

            if (isset($post['state_id']))
                $inventory->state_id = $post['state_id'];

            if (isset($post['parcel_number']))
                $inventory->parcel_number = $post['parcel_number'];

            if (isset($post['total_acres']))
                $inventory->total_acres = $post['total_acres'];

            if (isset($post['cost_of_development']))
                $inventory->cost_of_development = $post['cost_of_development'];

            if (isset($post['total_cost']))
                $inventory->total_cost = $post['total_cost'];

            if (isset($post['per_acre_cost']))
                $inventory->per_acre_cost = $post['per_acre_cost'];
        } elseif ($inventory->category_id == EnumsCategory::RESIDENTIAL) {
            if (isset($post['street']))
                $inventory->street = $inventory->name = $post['street'];

            if (isset($post['city']))
                $inventory->city = $post['city'];

            if (isset($post['county']))
                $inventory->county = $post['county'];

            if (isset($post['country_residential']))
                $inventory->country_id = $post['country_residential'];

            if (isset($post['state_residential']))
                $inventory->state_id = $post['state_residential'];

            if (isset($post['zipcode']))
                $inventory->zipcode = $post['zipcode'];

            if (isset($post['parcel_number']))
                $inventory->parcel_number = $post['parcel_number'];

            if (isset($post['bedroom']))
                $inventory->bedroom = $post['bedroom'];

            if (isset($post['bathroom']))
                $inventory->bathroom = $post['bathroom'];

            if (isset($post['square_footage']))
                $inventory->square_footage = $post['square_footage'];

            if (isset($post['lot_area']))
                $inventory->lot_area = $post['lot_area'];

            if (isset($post['lot_area_type']))
                $inventory->lot_area_type = $post['lot_area_type'];

            if (isset($post['price']))
                $inventory->price = $post['price'];
        } else {
            if (isset($post['name']))
                $inventory->name = $post['name'];
        }

        $inventory->save();

        return redirect("admin/inventory/")->with('success', 'Inventory updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventory = Inventory::withoutTrashed()->find($id);
        $inventory->delete();
        /* Deleting notes, files, loan entries, escrows and loan related to the inventory */
        $inventory->inventoryNotes()->delete();
        $inventory->inventoryFiles()->delete();
        $inventory->loan()->each(function ($item) {
            $item->loanEntry()->delete();
            $item->escrow()->delete();
            $item->supports()->delete();
        });
        $inventory->loan()->delete();

        return redirect()->back()->with('success', 'Inventory deleted successfully!');
    }

    /* Saving the notes */
    public function ajaxSaveNotes(Request $request)
    {
        $insertData = [];
        $insertData['user_id'] = $request->user_id;
        $insertData['inventory_id'] = $request->inventory_id;
        $insertData['note'] = $request->inventory_note;

        InventoryNote::create($insertData);

        return response()->json([
            'status'  => Status::SUCCESS,
            'message' => 'Note saved successfully!'
        ]);
    }

    /* Updating the notes */
    public function ajaxUpdateNotes(Request $request)
    {
        $id = $request->note_id;
        $note = InventoryNote::find($id);
        if (!$note) {
            return response()->json(['error' => 'Note not found'], 404);
        }

        $note->note = $request->edit_inventory_note;
        $note->save();
        return response()->json([
            'status'  => Status::SUCCESS,
            'message' => 'Note updated successfully!'
        ]);
    }

    /* Retrieving the note */
    public function getNoteDetails($id)
    {
        $note = InventoryNote::find($id);
        return response()->json(['note' => $note->note,'id' => $note->id]);
    }

    /* Deleting the note */
    public function ajaxDeleteNotes($id)
    {
        $note = InventoryNote::find($id);
        if ($note) {
            $note->delete();
            return response()->json([
                'status'  => Status::SUCCESS,
                'message' => 'Note deleted successfully!'
            ]);
        } else {
            return response()->json(['error' => 'Note not found'], 404);
        }
    }

    /* Deleting the file */
    public function ajaxDeletefile($id)
    {
        $InventoryFile = InventoryFile::find($id);
        if ($InventoryFile) {
            $InventoryFile->delete();
            return response()->json([
                'status'  => Status::SUCCESS,
                'message' => 'File deleted successfully!'
            ]);
        } else {
            return response()->json(['error' => 'Note not found'], 404);
        }
    }

    /* Saving the files */
    public function ajaxSavefiles(Request $request)
    {
        $user_id = $request->user_id;
        $inventory_id = $request->inventory_id;
        $fileTitle = $request->fileTitle;
        // Handle file upload
        if ($request->hasFile('file')) {
            $uploadedFiles = [];
            foreach ($request->file('file') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/inventory-files/'.$inventory_id), $filename);

                InventoryFile::create([
                    'file_name' => $filename,
                    'inventory_id' => $inventory_id,
                    'user_id' => $user_id,
                    'file_title' => $fileTitle
                ]);

                $uploadedFiles[] = $filename;
            }
            return response()->json([
                'status'  => Status::SUCCESS,
                'message' => 'Files uploaded successfully!'
            ]);
        }
    }

    /* Saving the description */
    public function ajaxSaveDescription(Request $request)
    {
        $inventory = Inventory::withoutTrashed()->find($request->inventory_id);
        if (!$inventory) {
            return response()->json(['error' => 'Note not found'], 404);
        }
        // Update the note content
        $inventory->description = $request->inventoryDescription;
        $inventory->save();
        return response()->json([
            'status'  => Status::SUCCESS,
            'message' => 'Description updated successfully!'
        ]);
    }

    /* Verifing the address */
    public function verifyAddress(Request $request) {
        $inventory = Inventory::withoutTrashed()->find($request->id);
        $inventory->address_verified = 1;
        $inventory->save();
        return response()->json([
            'status' => 200
        ]);
    }

    /* Get the inventory */
    public function getInventory(string $id) {
        $inventory = Inventory::withoutTrashed()->find($id);

        $returnData['status'] = Status::SUCCESS;
        $returnData['data'] = $inventory;
        $returnData['messages'] = 'Success';

        return response()->json($returnData);
    }
}
