<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use Notifiable;
	use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'id',
    ];
	
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
	
	/**
     * The attributes uses to sort.
     *
     * @var array
     */
    protected $orderAttributes = ['name'];
	
	/**
     * The attributes uses to filter.
     *
     * @var array
     */
    protected $filterAttributes = ['name', 'id'];
	
	public function profilesroles()
    {
        return $this->hasMany('App\ProfileRole');
    }
	
	public function privileges()
    {
        return $this->hasMany('App\Privilege');
    }
	
	public function profiles() {
		return $this->belongsToMany('App\Profile', 'profiles_roles');
	}
	
	public function resources() {
		return $this->belongsToMany('App\Resource', 'privileges');
	}
	
	public function canDelete() {
		return $this->profiles->isEmpty() && $this->resources->isEmpty();
	}
	
	public function getOrderAttributes() {
		return $this->orderAttributes;
	}
	
	public function getFilterAttributes() {
		return $this->filterAttributes;
	}
	public function isSoftDelete() {
		return true;
	}
}
