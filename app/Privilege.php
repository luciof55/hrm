<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Privilege extends Model
{
    use Notifiable;
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_id', 'resource_id', 'id'];
	
	/**
     * The attributes uses to sort.
     *
     * @var array
     */
    protected $orderAttributes = ['role_id', 'resource_id'];
	
	/**
     * Unique attributes to validate.
     *
     * @var array
     */
    protected $uniqueAttributes = ['role_id', 'resource_id'];
	
	/**
     * The attributes uses to filter.
     *
     * @var array
     */
    protected $filterAttributes = ['role_id', 'resource_id',];
	
	public function role()
    {
        return $this->belongsTo('App\Role');
    }
	
	public function resource()
    {
        return $this->belongsTo('App\Resource');
    }
	
	public function getOrderAttributes() {
		return $this->orderAttributes;
	}
	
	public function getUniqueAttributes() {
		return $this->uniqueAttributes;
	}
	
	public function getFilterAttributes() {
		return $this->filterAttributes;
	}
	public function isSoftDelete() {
		return false;
	}
}
