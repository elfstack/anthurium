<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\DataCollection;
use App\Models\UserGroup;
use App\Utils\ConfigUtils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar;

class ConfigController extends Controller
{
    public function config() {
        $permissions = app()->make(PermissionRegistrar::class)
            ->getPermissions()
            ->pluck('roles.*.name', 'name');

        $configs = Configuration::all();

        // $configs['user.membership_application.data_collection'] = DataCollection::memberApplicationForm();

        return [
            'name' => getenv('APP_NAME'),
            'timezone' => getenv('APP_TIMEZONE'),
            'configs' => $configs,
            'permissions' => $permissions
        ];
    }

    /**
     * Update configurations
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request) {
        // TODO: resolve conflicts while multiple user editing the config

        $sanitized = $request->input();

        $configKeys = [];
        foreach ($sanitized as $key=>$value) {
            array_push($configKeys, $key);
            ConfigUtils::set($key, $value);
        }

        return response()->json([
            'message' => 'success',
            'configs' => Configuration::getConfigs($configKeys)
        ]);
    }
}
