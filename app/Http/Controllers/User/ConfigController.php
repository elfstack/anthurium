<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DataCollection;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\PermissionRegistrar;

class ConfigController extends Controller
{
    /**
     * Get site config
     *
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function config() {
        $configs = app()->make('anthurium-config');

        return response()->json([
            'name' => getenv('APP_NAME'),
            'timezone' => getenv('APP_TIMEZONE'),
            'allow_member_application' => $configs->get('member.application.open'),
            'member_application_data_collection' => DataCollection::memberApplicationForm()
        ]);
    }
}
