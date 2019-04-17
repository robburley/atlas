<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    /**
     * Create a new dashboard controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $validator = Validator::make(request()->all(), [
           'input' => 'min:3'
        ]);

        if(!$validator->passes()) {
            alert()->error('Please search for 3 or more characters', 'Search Failed');

            return redirect()->back();
        };

        $results = Customer::where('company_name', 'LIKE', '%' . request()->input . '%')
                           ->orWhere('telephone_number', 'LIKE', '%' . request()->input . '%')
                           ->orWhereHas('contacts', function ($query) {
                               $query->where('surname', 'LIKE', '%' . request()->input . '%')
                                     ->orWhere('email_address', 'LIKE', '%' . request()->input . '%');
                           })
                           ->permissions()
                           ->paginate(50);

        return view('search.index', [
            'results' => $results,
            'searchTerm' => request()->input
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
