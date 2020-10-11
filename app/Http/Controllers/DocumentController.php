<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \response(Document::all(), 200);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('document');
        $originalName = $file->getClientOriginalName();
        $path = $file->store('documents');
        $mimeType = File::mimeType($file);
        $size = File::size($file);

        $data = collect(array_merge($request->all(), [
           'file_name' => $originalName,
           'path' => $path,
           'mime_type' => $mimeType,
           'size' => $size
        ]))->toArray();

        $documentType = json_decode($request->get('document_type'), true);
        if (!isset($documentType['id'])) {
            $documentType = DocumentType::create([
                'name' => $documentType['name']
            ]);
        }

        $data['document_type_id'] = $documentType->id;

        $document = Document::create($data);

        return new Response($document, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $file = $request->file('document');
        $fileData = [];
        if ($file) {
            $document = Document::find($id);
            $path = $document->path;
            Storage::delete($path);
            $fileData = [
                'file_name' => $file->getClientOriginalName(),
                'path' => $file->store('documents'),
                'mime_type' => File::mimeType($file),
                'size' => File::size($file)
            ];
        }

        $data = collect(array_merge($request->all(), $fileData))->toArray();

        $document = Document::find($id)->updateOrCreate(['id' => $id], $data);
        return \response($document, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document = Document::find($id);
        $path = $document->path;
        if ($document->delete()) {
            Storage::delete($path);
        };
        return \response('deleted', 200);
    }
}
