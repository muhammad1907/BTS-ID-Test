<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{

    protected $fillable = ['checklist_id', 'item_name'];
}
