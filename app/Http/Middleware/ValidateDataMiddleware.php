<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Closure;

class ValidateDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $validate = $this->validate($request);

        if ($validate->passes()) {
            return $next($request);
        }

        return response()->json([
            'status_code' => Response::HTTP_BAD_REQUEST,
            'error' => true,
            'error_message' => 'Invalid data',
            'error_description' => $validate->messages(),
        ], Response::HTTP_BAD_REQUEST);
    }

    private function defineModel(string $namespace): ?Model
    {
        $model = null;

        if (class_exists($namespace)) {
            $model = new $namespace();
        }

        return $model;
    }

    private function validate(Request $request)
    {
        $alias = $request->route()[1]['as'];
        $model = $this->defineModel($alias);

        if (empty($model)) {
            throw new InvalidArgumentException('The model ' . $alias . ' doesn\'t exists');
        }

        return Validator::make(
            $request->toArray(),
            $model->rules,
        );
    }
}
