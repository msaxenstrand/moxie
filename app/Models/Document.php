<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['title', 'description', 'file_name', 'size', 'mime_type', 'path', 'document_type_id'];

    protected $with = ['documentType'];

    public function documentType()
    {
        return $this->belongsTo('App\Models\DocumentType');
    }
}
