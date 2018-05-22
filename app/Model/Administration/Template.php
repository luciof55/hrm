<?php

namespace App\Model\Administration;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'view_name', 'display_name'];
	
    public function isSoftDelete() {
		return false;
	}
}
