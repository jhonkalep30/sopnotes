<?php

namespace App\Http\Controllers\ACL;

use App\Components\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\ACL\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $model = Menu::class;

    public function view()
    {
        return view('acl.menu.index');
    }
    
    public function data(Request $request)
    {
        $data = $this->model::when(@$request->q, function($q) use ($request){
                    return $q->where('label', 'like', '%'.$request->q.'%')
                             ->orWhere('type', 'like', '%'.$request->q.'%');
                })->when(@$request->type, function($q) use ($request){
                    return $q->whereIn('type', is_array($request->type) ? $request->type : [$request->type]);
                })->when(@$request->selectedId, function($q) use ($request){
                    return $q->where('id', '!=', $request->selectedId);
                });

        if(@$request->paginate) return $data->paginate(@$request->paginate ?? 10);
        return ResponseHelper::sendResponse($data->get(), 'Success!');
    }

    public function list(Request $request)
    {
        $result = [];
        $searching = @$request->search ? true : false;

        // SECTIONS
        $sections = $this->model::where('type', 'section')->orderBy('order')->get();
        foreach ($sections as $section) {
            
            $addSection = true;
            if($searching && (!str_contains(strtolower($section->type), strtolower($request->search)) && !str_contains(strtolower($section->label), strtolower($request->search)))){
                $addSection = false;
            }

            // GROUPS AND OR LINKS
            $groups = $this->model::whereIn('type', ['group', 'link'])->where('parent_id', $section->id)->orderBy('order')->get();
            $groupDatas = [];

            foreach ($groups as $group) {
                
                $addGroup = true;
                if($searching && (!str_contains(strtolower($group->type), strtolower($request->search)) && !str_contains(strtolower($group->label), strtolower($request->search)))){
                    $addGroup = false;
                }

                // ADD PERMISSION
                $group['permission_key'] = @$group->permission->permission_key;

                // LINKS
                $links = $this->model::where('type', 'link')->where('parent_id', $group->id)->orderBy('order')->get();
                $linkDatas = [];

                foreach ($links as $link) {

                    $addLink = true;
                    if($searching && (!str_contains(strtolower($link->type), strtolower($request->search)) && !str_contains(strtolower($link->label), strtolower($request->search)))){
                        $addLink = false;
                    }

                    // ADD PERMISSION
                    $link['permission_key'] = @$link->permission->permission_key;

                    if($addLink) $linkDatas[] = $link;
                    if(!$addGroup && $addLink) $addGroup = true;
                }

                if(count($linkDatas) > 0) $group['links'] = $linkDatas;
                if($addGroup) $groupDatas[] = $group;
                if(!$addSection && $addGroup) $addSection = true;
            }

            // // LINKS :: BY SECTION
            // $links = $this->model::where('type', 'link')->where('parent_id', $section->id)->orderBy('order')->get();
            // $linkSectionDatas = [];

            // foreach ($links as $link) {

            //     $addLink = true;
            //     if($searching && (!str_contains(strtolower($link->type), strtolower($request->search)) && !str_contains(strtolower($link->label), strtolower($request->search)))){
            //         $addLink = false;
            //     }

            //     if($addLink) $linkSectionDatas[] = $link;
            //     if(!$addSection && $addLink) $addSection = true;
            // }

            // if(count($linkSectionDatas) > 0) $section['links'] = $groupDatas;
            if(count($groupDatas) > 0) $section['groups'] = $groupDatas;
            if($addSection) $result[] = $section;
        }

        // $data = $this->model::when(@$request->search, function($q) use ($request){
        //             return $q->where('label', 'like', '%'.$request->search.'%')
        //                      ->orWhere('type', 'like', '%'.$request->search.'%');
        //         })->get();

        // $sections = [];
        // $result = [];
        // foreach ($data as $menu) {
        //     // $
        // }

        // dd(123);

        return ResponseHelper::sendResponse($result, 'Success!');
    }

    public function detail($id)
    {
        $data = $this->model::with('parent', 'permission')->whereId($id)->first();
        if(!$data) return ResponseHelper::sendError('Failed to get data!');

        return ResponseHelper::sendResponse($data, 'Success!');
    }

    public function save(Request $request)
    {
        // PURGE BY TYPE
        switch($request->type){
            case 'section':
                $request['icon'] = null;
                $request['parent_id'] = null;
                $request['permission_id'] = null;
                $request['url'] = null;
                break;

            case 'group':
                $request['permission_id'] = null;
                $request['url'] = null;
                break;
        }

        $data = \DB::transaction(function () use ($request) {
            $model = $this->model::whereId(@$request->id)->first() ?? new $this->model;
            $rules = (@$request->id ? $model->ruleOnUpdate() : $model->rule());

            if(in_array($request->type, ['group', 'link']))
                $rules['parent_id'] = 'required|numeric|exists:menus,id';

            \Validator::make($request->except('id'), $rules)->validate();

            if(@$request->id){
                $model->update($request->except('id'));
            }else{
                $model = $this->model::updateOrCreate($request->all());
            }

            return $model;
        });

        if(!$data) return ResponseHelper::sendError(trans('Failed to save data, please try again.'));
        return ResponseHelper::sendResponse($data, trans('Data has been saved!'));
    }

    public function delete($id)
    {
        $data = $this->model::whereId($id)->first();
        if(!$data) return ResponseHelper::sendError('Failed to get data!');
        
        $data->delete();

        return ResponseHelper::sendResponse([], 'Data has been deleted!');
    }

    public function hide($id)
    {
        $data = $this->model::whereId($id)->first();
        if(!$data) return ResponseHelper::sendError('Failed to get data!');
        
        // UPDATE CURRENT
        $hidden = ($data->is_hidden ? 0 : 1);
        $data->update(['is_hidden' => $hidden]);

        $changeIds = [$id];
        $hiddenInverse = ($hidden ? 0 : 1);

        // GET PARENT
        if($parentAlpha = $this->model::whereId($data->parent_id)->first()){

            if(!$this->model::whereParentId($data->parent_id)->where('is_hidden', $hiddenInverse)->first()){
                $parentAlpha->update(['is_hidden' => $hidden]);
                $changeIds[] = $parentAlpha->id;
            }

            // $parentAlpha->update(['is_hidden' => $hidden]);
            // $changeIds[] = $parentAlpha->id;

            if($parentBeta = $this->model::whereId($parentAlpha->parent_id)->first()){

                if(!$this->model::whereParentId($parentAlpha->parent_id)->where('is_hidden', $hiddenInverse)->first()){
                    $parentBeta->update(['is_hidden' => $hidden]);
                    $changeIds[] = $parentBeta->id;
                }

                // // OTHERS
                // $parentBetaOthers = $this->model::whereParentId($parentAlpha->parent_id)
                //                     ->where('is_hidden', $hiddenInverse)
                //                     ->get()->count();

                // if($parentBetaOthers > 0)

                // $parentBeta->update(['is_hidden' => $hidden]);
                // $changeIds[] = $parentBeta->id;

            }
        }

        // GET CHILDS
        foreach($this->model::whereParentId($id)->get() as $childAlpha){
            
            $childAlpha->update(['is_hidden' => $hidden]);
            $changeIds[] = $childAlpha->id;

            foreach($this->model::whereParentId(@$childAlpha->id)->get() as $childBeta){
                
                $childBeta->update(['is_hidden' => $hidden]);
                $changeIds[] = $childBeta->id;

            }
        }

        return ResponseHelper::sendResponse(['hidden' => $hidden,'ids' => $changeIds], 'Success!');
    }
}
