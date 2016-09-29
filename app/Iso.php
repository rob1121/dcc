<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iso extends Model
{
    protected $fillable = [ 'spec_no', 'name', 'document', 'revision', 'revision_date' ];
}
