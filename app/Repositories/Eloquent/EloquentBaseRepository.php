<?php

namespace App\Repositories\Eloquent;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentBaseRepository extends AbstractRepository
{
	public function canDelete($command) {
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		if (method_exists($command, 'canDelete')) {
			$result->put('status', $command->canDelete());	
		} else {
			$result->put('status', true);	
		}
		
		return $result;
	}
	
	public function canSoftDelete($command) {
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		if (method_exists($command, 'canSoftDelete')) {
			$result->put('status', $command->canSoftDelete());	
		} else {
			$result->put('status', true);	
		}
		
		return $result;
	}
	
	public function canRestore($command) {
		$result = collect([]);
		$result->put('message', null);
		
		if (method_exists($command, 'canRestore')) {
			$result->put('status', $command->canRestore());	
		} else {
			$result->put('status', true);	
		}
		
		return $result;
	}

	public function select($array_select, $paginate = null) {
		Log::info('Function all.');
		$query = $this->entity->select($array_select);
		return $paginate ? $query->paginate($paginate) : $query->get();
	}
	
	public function paginateWithTrashed($query = null, $paginate = null, $orderAttributes = null, $filterAttributes = null, $page = null)
    {
		if (isset($query)) {
			return $this->getWithTrashed($query, $paginate, $orderAttributes, $filterAttributes, $page);
		} else {
			if ($this->isSoftDelete()) {
				$query = $this->entity->withTrashed();
			} else {
				$query = $this->entity;
			}
			$query->select($this->getInstance()->getTable().'.*');
			return $this->getWithTrashed($query, $paginate, $orderAttributes, $filterAttributes, $page);
		}
	}
	
	/**
     * @param $id
     * @return mixed
     */
    public function findWithTrashed($id)
    {
		$model = $this->entity->withTrashed()->find($id);

        if (!$model) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->entity->getModel()),
                $id
            );
        }

        return $model;
    }
	
	/**
     * @param $id
     * @return mixed
     */
    public function forceDelete($id)
    {
        return $this->find($id)->forceDelete();
    }
	
	public function countWithTrashed($query = null, $filterAttributes = null) {
	
		if (is_null($query)) {
			$query = $this->entity;
		}
		
		if ($this->isSoftDelete()) {
			$query = $query->withTrashed();
		}
		
		if (isset($filterAttributes) && $filterAttributes->isNotEmpty()) {
			Log::info('Hay Filtros-Valor');
			foreach ($filterAttributes->keys() as $attributeKey) {
				Log::info('Key: '.$attributeKey);
				if (!str_contains($attributeKey, '.')) {
					$value = $filterAttributes->get($attributeKey);
					Log::info('value:'.$value.' FIN');
					if(is_numeric($value)) {
						Log::info('Adding NUMBER--------------------------');
						$query = $query->where($attributeKey, $value);
					} else {
						$query = $query->where($attributeKey, 'like', '%'.$value.'%');
					}
				} else {
					$this->addNestedFilters($query, $attributeKey, $filterAttributes);
				}
			}
			// print_r($query->getBindings());
			Log::info('COUNT IF SQL: '.$query->toSql());
			// Log::info('IF SQL: '.$query->toBase()->count());
			return $query->count($this->getInstance()->getTable().'.id');
		}
		Log::info('COUNT: '.$query->toSql());
		return $query->count($this->getInstance()->getTable().'.id');
	}
	
	/**
     * @param $id
     * @return mixed
     */
    public function find($id) {
		Log::info('Find.');
		if ($this->isSoftDelete()) {
			return $this->findWithTrashed($id);
		} else {
			return parent::find($id);
		}
	}
	
	/**
     * @param $id
     * @return mixed
     */
    public function isSoftDelete() {
		return $this->entity->isSoftDelete();
	}
	
	public function updateSoftDelete($id) {
		if ($this->isSoftDelete()) {
			$command = $this->find($id);
			if ($command->trashed()) {
				$result = $this->canRestore($command);
				if ($result['status']) {
					$command->restore();
					Log::info('Command Restore.');
				}
			} else {
				$this->softDeleteCascade($command);
				Log::info('Command Deleted.');
			}
		}
	}
	
	protected function softDeleteCascade($command) {
		$command->delete();
	}
	
	protected function addNestedFilters($query, $attributeKey, $filterAttributes) {
		Log::info('addNestedFilters');
		Log::info('KEY: '.$attributeKey);
		$value = $filterAttributes->get($attributeKey);
		Log::info('VALUE: '.$value);
		if(is_numeric($value)) {
			Log::info('Adding NUMBER-------------------------- ');
			$query->where($attributeKey, $value);
		} else {
			$query->where($attributeKey, 'like', '%'.$value.'%');
		}
	}
	
     /**
     * @return mixed
     */
    protected function getWithTrashed($query, $paginate = null, $orderAttributes = null, $filterAttributes = null, $page = null)
    {
		if (isset($filterAttributes) && $filterAttributes->isNotEmpty()) {
			Log::info('Hay Filtros-Valor');
			foreach ($filterAttributes->keys() as $attributeKey) {
				if (!str_contains($attributeKey, '.')) {
					Log::info('Key: '.$attributeKey);
					$value = $filterAttributes->get($attributeKey);
					Log::info('value: '.$value);
					if(is_numeric($value)) {
						Log::info('Adding NUMBER-------------------------- ');
						$query->where($this->getInstance()->getTable().'.'.$attributeKey, $value);
					} else {
						$query->where($this->getInstance()->getTable().'.'.$attributeKey, 'like', '%'.$value.'%');
					}
				} else {
					$this->addNestedFilters($query, $attributeKey, $filterAttributes);
				}
			}
			
		};
		
		if (!empty($orderAttributes)&& $orderAttributes->isNotEmpty()) {
			foreach ($orderAttributes->keys() as $attributeKey) {
				$order = $orderAttributes->get($attributeKey);
				if (str_contains($attributeKey, '-')) {
					$aux = explode('-', $attributeKey);
					$relation = $this->getRelation($aux[0]);
					if (isset($relation)) {
						$query->join($relation->getRelated()->getTable(), $relation->getQualifiedForeignKey(), '=', $relation->getRelated()->getQualifiedKeyName());
						$query->orderBy($relation->getRelated()->getTable().'.'.$aux[1], $order);
					}
				} else {
					$query->orderBy($this->getInstance()->getTable().'.'.$attributeKey, $order);
				}
			}
		};
		
		Log::info('------------SQL: '.$query->toSql());
		if ($paginate) {
			$total = $query->count($this->getInstance()->getTable().'.id');
			$auxList = $query->paginate($paginate, null, null, $page);
			$list = array();
			foreach ($auxList as $element) {
				array_push($list, $element);
			}

			Log::info('***************TOTAL GET: '.$total);
			return new LengthAwarePaginator($list, $total, $paginate, $page);
		} else {
			return $query->get();
		}
		
		//return $paginate ? $query->paginate($paginate, ['distinct ('.$this->getInstance()->getTable().'.id)'], null, $page) : $query->get();
	}
	
	public function getRelation($relationName) {
		return $this->getInstance()->$relationName();
	}
}
