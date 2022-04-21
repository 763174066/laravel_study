<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\UserModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class CreatePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成权限列表';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $routes = Route::getRoutes();
        $arr = [];
        //获取全部路由名称
        foreach ($routes as $route) {
            $p = stripos($route->uri, 'api');
            if ($p === 0) {
                if (!empty($route->action['as'])) {
                    array_push($arr, $route->action['as']);
                }
            }
        }
        //将路由名称写入权限
        if(!empty($arr)){
            foreach ($arr as $item){
                Permission::query()->firstOrCreate([
                    'name' => $item
                ],[
                    'guard_name' => 'app'
                ]);
            }
        }
    }

}
