<?php

namespace App\Model\Gondola;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
	
	protected $table = 'categories';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label', 'id', 'code', 'parent', 
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
    protected $orderAttributes = ['label',];

	/**
     * The attributes uses to filter.
     *
     * @var array
     */
    protected $filterAttributes = ['label', ];
	
	public function canDelete() {
		return true;
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
