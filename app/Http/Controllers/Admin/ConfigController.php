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
        $sanitized = $request->input();

        $configKeys = [];
        foreach ($sanitized as $key=>$value) {
            array_push($configKeys, $key);
            Configuration::set($key, $value);
        }

        return response()->json([
            'message' => 'success',
            'configs' => Configuration::getConfigs($configKeys)
        ]);
    }

    /**
     * Get hash of current configuration
     *
     * @return JsonResponse
     * TODO: query config version, can utilize cache when implemented
     */
    public function version() {
        return response()->json([
            'hash' => Configuration::lastUpdatedAt()
        ]);
    }
}
