<?php

namespace App\Http\Controllers\Users;


use App\Http\Controllers\Controller;
use App\Models\User\HrProfile;
use App\Models\User\HrProfileFile;
use Illuminate\Support\Facades\File;

class HrProfileFileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:manage_hr');
    }

    public function store(HrProfile $profile)
    {
        $file = $profile->files()->create(request()->except('file'));

        $fileName = str_slug($file->type) . '-' . $file->id . '.' . request()->file('file')->extension();

        request()->file('file')->storeAs(
            'hr/' . $profile->id, $fileName
        );

        $file->update([
            'location' => 'hr/' . $profile->id . '/' . $fileName
        ]);

        alert()->success('File Uploaded');

        return redirect()->back();
    }

    public function show(HrProfile $profile, HrProfileFile $file)
    {
        $path = storage_path('app') . '/' . $file->location;

        if ($file->profile != $profile || !File::exists($path)) {
            abort('404');
        }

        return Response()->download($path);
    }
}
