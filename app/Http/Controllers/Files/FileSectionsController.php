<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;

class FileSectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param File $file
     * @return \Illuminate\Http\Response
     */
    public function index(File $file)
    {
        return view('app.files.sections.index', ['file' => $file]);
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
     * @param File $file
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, File $file)
    {
        $file->sections()->delete();

        $sections = collect($request->get('sections'));
        $sections->each(function ($section) use ($file) {
            // @TODO: Validate
            if ($this->validSection($section)) {
                $file->sections()->create($section);
            }
        });

        return redirect($file->route('/sections'));
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
     * @param File $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        $file->load('sections');

        return view('app.files.sections.edit', compact('file'));
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

    private function validSection($section)
    {
        return isset($section['content']) && !empty($section['content']);
    }
}
