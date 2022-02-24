<?php

namespace App\Console\Commands;

use App\Models\UserModel;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a admin user';

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
     * @return int
     */
    public function handle()
    {
        $user = UserModel::where('username','admin')->first();
        if($user){
            $this->info('anmin账号已存在，请直接登录');
            return null;
        }
        try {
            UserModel::create([
                'username' => 'admin',
                'password' => bcrypt('123456')
            ]);
            $this->info('账号admin密码123456');
        }catch (\Exception $exception){
            $this->info('创建失败');
        }

        return null;
    }
}
