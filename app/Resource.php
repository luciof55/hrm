<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Resource extends Model
{
   use Notifiable;
   
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'id',
    ];
	
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
	
	public function rolespermissions()
    {
        return $this->hasMany('App\RolePermission');
    }
	
	public function roles() {
		return $this->belongsToMany('App\Role', 'roles_permissions');
	}
	
	public function getOrderAttributes() {
		return $this->orderAttributes;
	}
	
	public function getFilterAttributes() {
		return $this->filterAttributes;
	}
	public function isSoftDelete() {
		return false;
	}
}
