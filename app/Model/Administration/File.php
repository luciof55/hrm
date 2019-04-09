<?php

namespace App\Model\Administration;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filename', 'id', 'seller_id', 'original_filename'
    ];
	
	public function seller() {
		 return $this->belongsTo('App\Model\Administration\Seller')->withTrashed();
	}
}
