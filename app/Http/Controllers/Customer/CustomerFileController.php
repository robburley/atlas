<?php

namespace App\Http\Controllers\Customer;


use App\Helpers\FileConversion;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerFileRequest;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerFile;
use App\Models\Customer\CustomerFileType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class CustomerFileController extends Controller
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
        //
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
     * @param  \App\Models\Customer $customer
     * @param Model $related
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer, CustomerFileRequest $request)
    {
        if ($request->file('file')) {
            $file = $customer->files()->create($request->except('file'));

            $fileType = CustomerFileType::find($request->get('customer_file_type_id'));

            $fileName = $fileType->slug . '/' . $fileType->slug . ' - ' . $file->id;

            $original = $request->file('file')->storeAs(
                $customer->id, $fileName . '.' . $request->file('file')->extension()
            );

            $conversion = new FileConversion(
                $original,
                $request->file('file')->extension(),
                $fileName,
                $customer,
                $fileType->slug != 'letterhead'
            );

            $fileName = $conversion->convert();

            $file->update([
                'location' => $customer->id . '/' . $fileName
            ]);

            $customer->notes()->create([
                'customer_note_type_id' => 5,
                'body'                  => 'A ' . $fileType->name . ' file has been uploaded.',
                'notable_type'          => $request->get('related_type'),
                'notable_id'            => $request->get('related_id'),
            ]);
        } else {
            alert()->error('Please Upload a file');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @param CustomerFile $file
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Customer $customer, CustomerFile $file, $render = null)
    {
        if (!$file->type->permission || auth()->user()->hasPermission($file->type->permission->slug)) {
            $path = storage_path('app') . '/' . $file->location;

            if ($file->customer != $customer || !File::exists($path)) {
                abort('404');
            }

            try {
                if (is_null($render)) {
                    return Response()->download($path);
                }

                $file = File::get($path);
                $type = File::mimeType($path);

                $response = Response::make($file, 200);
                $response->header("Content-Type", $type);

                return $response;
            } catch (\Exception $e) {
                abort(404);
            }
        }

        abort(404);
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
     * @param Customer $customer
     * @param CustomerFile $file
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Customer $customer, CustomerFile $file)
    {
        Storage::delete($file->location);

        $file->delete();

        alert()->success('File Deleted');

        return redirect()->back();
    }
}
