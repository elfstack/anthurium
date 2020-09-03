<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar;

class ConfigController extends Controller
{
    public function config() {
        $permission = app()->make(PermissionRegistrar::class)
            ->getPermissions()
            ->pluck('roles.*.name', 'name');

        return [
            'name' => getenv('APP_NAME'),
            'timezone' => getenv('APP_TIMEZONE'),
            'permissions' => $permission
        ];
    }

    public function getConfigGroup(string $group) {
        return response()->json([
            'group' => $group,
            'configs' => Configuration::getGroup($group)
        ]);
    }

    public function update(Request $request) {
        $sanitized = $request->input();

        foreach ($sanitized as $key=>$value) {
            // ignore value ends with repr
            $suffix = substr($key, -5, 5);
            if ($suffix === '_repr') {
                continue;
            }
            Configuration::set($key, $value);
        }

        return response()->json([
            'message' => 'success'
        ]);
    }
    /**
     * TODO: query config version
     */
    public function version() {
    }
}
