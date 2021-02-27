<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DataCollection;
use App\Utils\ConfigUtils;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\PermissionRegistrar;

class ConfigController extends Controller
{
    /**
     * Get site config
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function config() {
        return response()->json([
            'name' => getenv('APP_NAME'),
            'timezone' => getenv('APP_TIMEZONE'),
            'user.can_register' => ConfigUtils::get('user.can_register'),
            'user.can_apply_membership' => ConfigUtils::get('user.can_apply_membership'),
            'user.member_application.data_collection' => DataCollection::memberApplicationForm()
        ]);
    }
}
