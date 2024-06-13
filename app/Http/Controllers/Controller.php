<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /* Get states according to the selected country */
    public function getState(Request $request) {
        $data = [];
        $data['states'] = State::withoutTrashed()->where('country_id', $request->countryId)->get();

        return view('admin.get_states', $data);
    }
}
