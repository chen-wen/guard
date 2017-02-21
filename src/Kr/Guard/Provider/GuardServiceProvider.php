<?php

namespace Kr\Guard\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class GuardServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        if (config('auth.authorizate.switch', false)) {
            $gate->before(function ($user, $ability) {
                if ($user->isSuper()) {
                    return true;
                }
            });

            $keys = \Kr\Guard\NamesConfigHelper::getKeys();
            foreach ($keys as $key) {
                $gate->define($key, function ($user) use ($key) {
                    return $user->hasAccess($key);
                });
            }
            $gate->before(function ($user, $ability) use ($keys) {
                if (!in_array($ability, $keys)) {
                    // 未定义的直接放行
                    return true;
                }
            });
        }

        // 注册行为日志
        app()->instance('access.log', new \Kr\Guard\Services\AccessLog);
    }
}
