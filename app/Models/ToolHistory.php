<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolHistory extends Model
{
    protected $fillable = [
        'tool_type',
        'input_file',
        'output_file',
        'original_size_kb',
        'processed_size_kb',
        'status',
    ];
}
