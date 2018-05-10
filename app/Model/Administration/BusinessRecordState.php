<?php

namespace App\Model\Administration;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enumeration\RecordStateType;

class BusinessRecordState extends Model
{
    use Notifiable;
	use SoftDeletes;
	
	protected $table = 'business_record_state';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'id', 'closed_state',
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
    protected $filterAttributes = ['name'];
	
	public function getClosedState() {
		$select_types = RecordStateType::getEnumTranslate();
		return $select_types->get($this->closed_state);
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
		return true;
	}
}
