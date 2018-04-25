<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class MultipleUniqueRule implements Rule
{
    protected $repository;
	protected $data;
	/**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($repository, $data)
    {
        $this->repository = $repository;
		$this->data = $data;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
		if (method_exists($this->repository->entity(), 'getUniqueAttributes')) {
			$collectionFilter = collect([]);
			foreach ($this->repository->getInstance()->getUniqueAttributes() as $attributeKey) {
				Log::info('Key: '.$attributeKey);
				Log::info('value: '.$this->data[$attributeKey]);
				$collectionFilter->put($attributeKey, $this->data[$attributeKey]);
			}
			
			$count = $this->repository->countWithTrashed($collectionFilter);
			Log::info('count: '.$count);
			return ($count == 0);
			
		}
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Already Exists';
    }
}
