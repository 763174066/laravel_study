<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\UserModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

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
    protected $description = '创建超级管理员';

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
        $admin = Admin::query()->first('username');
        if ($admin) {
            $this->alert('超级管理员账号已存在，请查看');
            return;
        }

        $pwd = $this->inputPassword();

        $admin = Admin::query()->create([
            'username' => 'admin',
            'password' => Hash::make($pwd)
        ]);

        $this->info('创建成功');
        $this->info('账号：admin');
        $this->info('密码：' . $pwd);
    }

    private function inputPassword()
    {
        $pwd = $this->secret('请输入密码，至少6位！');
        if (strlen($pwd) < 6) {
            $this->inputPassword();
        }
        return $pwd;
    }
}
