<?php

namespace App\Http\Controllers\system;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpressCollection;
use App\Http\Resources\ExpressComCollection;
use App\Imports\ExpressComImport;
use App\Models\ExpressCom;
use App\Models\Expresses;
use App\Services\ExpressService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ExpressController extends Controller
{
    /**
     * 查看快递列表
     */
    public function index()
    {
        $params = $this->validateWith([
            'page' => ['nullable', 'int'],
            'per_page' => ['nullable', 'int'],
        ]);
        $query = Expresses::query();
        $data = $query->paginate($params['per_page'] ?? 30);
        return ExpressCollection::collection($data);
    }

    /**
     * 查询快递
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function queryExpress($id)
    {
        $express = Expresses::findOrFail($id);
        $res = app(ExpressService::class)->queryExpress($express->expressCom->com, $express->num);
        return $this->response->ok(json_decode($res, true));
    }

    /**
     * 存储快递单号
     * @param Request $request
     */
    public function store(Request $request)
    {
        $params = $request->validate([
            'express_com_id' => ['required', 'int'],
            'num' => ['required', 'string']
        ]);
        $params['user_id'] = auth()->user()->id;
        Expresses::create($params);
        $this->response->ok();
    }

    /**
     * 搜索快递公司
     */
    public function searchExpressCom()
    {
        $params = $this->validateWith([
            'name' => ['required', 'string'],
        ]);
        $data = ExpressCom::where('name', 'like', '%' . $params['name'] . '%')->where('is_use', '0')->get();
        return ExpressComCollection::collection($data);
    }

    /**
     * 开启关闭快递公司
     * @param $id
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handleExpressCom($id)
    {
        $params = $this->validateWith([
            'is_use' => ['required', 'in:0,1'],
        ]);

        $com = ExpressCom::findOrFail($id);
        $com->is_use = $params['is_use'];
        $res = $com->save();

        if (!$res) {
            return $this->response->unprocessableEntity('更新失败');
        }

        return $this->response->ok();
    }

    /**
     * 获取启用的快递公司列表
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function expressComList(Request $request)
    {
        $data = ExpressCom::where('is_use', '1')->get();
        return ExpressComCollection::collection($data);
    }

    /**
     * 导入快递公司
     * @param Request $request
     */
    public function importExpressCom(Request $request)
    {
        Excel::import(new ExpressComImport(), $request->file('expressCom'));
    }
}
