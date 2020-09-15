<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar;

class ConfigController extends Controller
{
    public function config() {
        $permission = app()->make(PermissionRegistrar::class)
            ->getPermissions()
            ->pluck('roles.*.name', 'name');

        $configs = Configuration::all();

        return [
            'name' => getenv('APP_NAME'),
            'timezone' => getenv('APP_TIMEZONE'),
            'configs' => $configs,
            'permissions' => $permission
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
            // Configuration::set($key, $value);
            app('AnthuriumConfig')->set($key, $value);
        }

        return response()->json([
            'message' => 'success',
            'configs' => Configuration::getConfigs($configKeys)
        ]);
    }
}
