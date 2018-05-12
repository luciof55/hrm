<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class OwnerAuthorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $resource, $action)
    {
		Log::debug('OwnerAuthorize - Handle - Path: '.$request->path());
		Log::debug($request->query());
		Log::debug('OwnerAuthorize - Handle - resource: '.$resource);
		Log::debug('OwnerAuthorize - Handle - action: '.$action);

        if (!is_null($request->user())) {
			$values = explode('/', $request->path());
			Log::debug('OwnerAuthorize - Handle - user ID: '.$request->user()->id);
			Log::debug($values);
			if (!$this->isSuperAdmin($request->user(), $values[0])) {
				if (count($values) == 3 && $values[2] == $action) {
					Log::debug('OwnerAuthorize - Handle - ID: '.$values[1]);
					if (!$this->validate($resource, $values[1], $request->user()->id)) {
						return $this->redirect($request, $values);
					}
				} else {
					if (count($values) == 2 && $values[1] == $action) {
					}
				}
			}
        }
        return $next($request);
    }
	
	protected function isSuperAdmin($user, $resource) {
		$resource = $resource.'_'.'admin';
		return $user->hasResourceAccess($resource);
	}
	
	protected function redirect($request, $values) {
		$url = '/'.$values[0];
		foreach ($request->query() as $key => $val) {
			if (isset($val)) {
				if (isset($params)) {
					$params = $params.'&'.$key.'='.$val;
				} else {
					$params = $key.'='.$val;
				}
			}
		}
		if (isset($params)) {
			$url = $url.'?'.$params;
		}
		return redirect($url)->with('statusError', "No tiene permisos para editar, eliminar, habilitar o deshabilitar.");
	}
	
	protected function validate($class_name, $id, $user_id) {
		if (class_exists($class_name)) {
            $class = new \ReflectionClass($class_name);
			Log::debug('OwnerAuthorize - validate - clase encontrada: ' . $class_name);
			$instance = $class->newInstance();
			if ($instance->isSoftDelete()) {
				$instance = $instance->withTrashed()->find($id);
			} else {
				$instance = $instance->find($id);
			}
			if (isset($instance)) {
				if (isset($instance->user)) {
					Log::debug('OwnerAuthorize - validate -  owner user: '. $instance->user->id);
					if ($instance->user->id != $user_id) {
						return false;
					} else {
						return true;
					}
				} else {
					Log::debug('OwnerAuthorize - validate - No hay user.');
					return true;
				}
			} else {
				Log::debug('OwnerAuthorize - validate - No se creó el ID: ' . $id);
				return true;
			}
        } else {
			Log::debug('OwnerAuthorize - validate - No existe la calse: ' . $class_name);
			return true;
		}
	}
}