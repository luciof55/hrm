<?php

namespace App\Model\Administration;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'anio', 'id', 'seller_id', 'account_id', 'category_id', 'zonas', 'comentarios',
    ];
	
	/**
     * The attributes uses to sort.
     *
     * @var array
     */
    protected $orderAttributes = ['anio',];

	/**
     * The attributes uses to filter.
     *
     * @var array
     */
    protected $filterAttributes = ['anio',];

	public function getInterviewKey() {
		return $this->anio . '_' . $this->account_id;
	}
	
	public function seller() {
		 return $this->belongsTo('App\Model\Administration\Seller')->withTrashed();
	}
	
	public function account() {
		 return $this->belongsTo('App\Model\Administration\Account')->withTrashed();
	}
	
	public function category() {
		 return $this->belongsTo('App\Model\Gondola\Category')->withTrashed();
	}
	
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
		return false;
	}
}