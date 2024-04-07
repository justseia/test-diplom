<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\EducationImages;
use Illuminate\Http\Request;
use SimpleXMLElement;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $educations = Education::select('id', 'title', 'created_at')->get();
        $selectedEducation = $educations->first();
        return view('backend.education.index')->with([
            'educations' => $educations,
            'selectedEducation' => $selectedEducation
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.education.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        if (!empty($request->id)) {
            $education = Education::find($request->id);
            if (!empty($education)) {
                $is_info = 1;
                if (!empty($request->info)) {
                    $education->info = $request->info;
                }
                if (!empty($request->diseases)) {
                    $education->diseases = $request->diseases;
                    $is_info = 0;
                }
                $maxUrlsPerEducation = 10;

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        if (EducationImages::where('education_id', $education->id)->count() >= $maxUrlsPerEducation) {
                            // Maximum limit reached, handle accordingly (e.g., display an error message)
                            return response()->json(['error' => 'Maximum limit of URLs reached for this education.'], 422);
                        } else {
                            // Store the uploaded image in storage/app/public directory
                            $path = $image->store('public');
                            $fileName = basename($path);

                            $educationImages = EducationImages::create([
                                'education_id' => $education->id,
                                'url' => $fileName,
                                'is_info' => $is_info
                            ]);
                        }
                    }
                }
                $education->save();
            }
        } else {
            $this->validate($request, [
                'title' => 'required|max:120',
            ]);

            $education = Education::create([
                'title' => $request->title
            ]);
        }

        return redirect()->route('education.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function info($id)
    {
        $info = Education::select('id', 'title', 'info')->where('id', $id)->first();
        $info_images = EducationImages::select('url')->where('education_id', $info->id)->where('is_info', 1)->get();
        return view('backend.education.info')->with([
            'info' => $info,
            'info_images' => $info_images,
        ]);
    }

    public function diseases($id)
    {
        $diseases = Education::select('id', 'title', 'diseases')->where('id', $id)->first();
        $diseases_images = EducationImages::select('url')->where('education_id', $diseases->id)->where('is_info', 0)->get();

        return view('backend.education.diseases')->with([
            'diseases' => $diseases,
            'diseases_images' => $diseases_images,
        ]);
    }

    public function import(Request $request)
    {
        // Get the uploaded file
        $xmlFile = $request->file('xml_file');

        // Load the XML content
        $xmlContent = file_get_contents($xmlFile->path());
        $educations = new SimpleXMLElement($xmlContent);

        // Iterate through each <education> element
        foreach ($educations->education as $education) {
            // Create a new Education model instance
            $newEducation = new Education();

            // Assign values from XML to model properties
            $newEducation->title = (string)$education->name;
            $newEducation->info = (string)$education->info;
            $newEducation->diseases = (string)$education->diseases;

            // Save the model to database
            $newEducation->save();
        }

        return redirect()->route('education.index');
    }
}
