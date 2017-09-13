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
        $sections = collect($request->get('sections'));
        $sections->each(function ($section) use ($file) {
            // @TODO: Validate

            // Store
            $file->sections()->create($section);
        });
//        $file = $file->create($request->only(['name', 'path']));

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
