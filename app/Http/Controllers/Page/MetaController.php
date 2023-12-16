<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\CmsUser;
use App\Models\CmsRole;
use Illuminate\Http\Request;
use App\Collections\MetaCollection;
use Illuminate\Support\Arr;
use App\Http\Requests\AddMetaRequest;
use App\Http\Requests\EditMetaRequest;
use MongoDB\BSON\UTCDateTime  as DateTime;
use App\Utils\CommonUtils;

class MetaController extends Controller
{   
    use CommonUtils;
    public function list(Request $request, MetaCollection $metaCollection)
    {  
        $metaList = $metaCollection->orderBy('is_active', 'desc')
                        ->paginate(10);

        return view('meta.list', ['metaList' => $metaList]);
    }

    public function add(Request $request, CmsRole $cmsRoleModel)
    {  
        $roles = $cmsRoleModel->where('is_active', '=', 1)
                            ->get();

        return view('meta.add', ['roles' => $roles]);
    }

    public function save(AddMetaRequest $request, MetaCollection $metaCollection)
    {   
        $meta = $metaCollection->create([
            'slug' => $request->slug,
            'title' => $request->title,
            'module' => $request->module,
            'sub_module' => $request->sub_module,
            'meta_title' =>$request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'is_product' => empty($request->is_product) === false ? 1 : 0,
            'is_active' => empty($request->is_active) === false ? 1 : 0,
            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString()
        ]);
        $title = $request->title;
        $modified = null;
        if(empty($meta->_id) === false){
            $this->cmsUserActivity('Meta','Meta has been created successfully.', $modified, $title);
            return redirect()->route('cms.meta.list')->with('success', 'Meta has been created successfully.');
        }

        return redirect()->back()->with('error', 'Meta creation has been failed.');
    }

    public function edit($slug, Request $request, CmsUser $cmsUserModel, CmsRole $cmsRoleModel, MetaCollection $metaCollection)
    {   
        // $user = $cmsUserModel->where('token', '=', $token)
        //                 ->firstOrFail();             
        // $selectedRoles = $user->roles()->pluck('cms_role_id')->toArray();
        $meta = $metaCollection->find($slug);
        $roles = $cmsRoleModel->where('is_active', '=', 1)
                             ->get();
        return view('meta.edit', ['roles' => $roles, 'meta' => $meta]); 
    }

    public function update($token, EditMetaRequest $request, MetaCollection $metaCollection)
    {   
        $meta = $metaCollection->find($token);
        $meta->slug = $request->slug;
        $meta->title = $request->title;
        $meta->module = $request->module;
        $meta->sub_module = $request->sub_module;
        $meta->meta_title = $request->meta_title;
        $meta->meta_description = $request->meta_description;
        $meta->meta_keywords = $request->meta_keywords;
        $meta->is_product = empty($request->is_product) === false ? 1 : 0;
        $meta->is_active = empty($request->is_active) === false ? 1 : 0;
        $meta->updated_at = Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString();

        $activityData = "";
        $title = $request->title;

        if($meta->getOriginal('slug') != $request->slug) {
            $activityData .= "Meta-Slug ".$meta->getOriginal('slug'). " has been changed to " .$request->slug.", ";
        }
        if($meta->getOriginal('title') != $request->title) {
            $activityData .= "Title ".$meta->getOriginal('title'). " has been changed to " .$request->title.", ";
        }
        if($meta->getOriginal('module') != $request->module) {
            $activityData .= "Meta-module ".$meta->getOriginal('module'). " has been changed to " .$request->module.", ";
        }
        if($meta->getOriginal('sub_module') != $request->sub_module) {
            $activityData .= "Meta-sub-module ".$meta->getOriginal('sub_module'). " has been changed to " .$request->sub_module.", ";
        }
        if($meta->getOriginal('meta_title') != $request->meta_title) {
            $activityData .= "Meta-title ".$meta->getOriginal('meta_title'). " has been changed to " .$request->meta_title.", ";
        }
        if($meta->getOriginal('meta_description') != $request->meta_description) {
            $activityData .= "Meta-desc has been changed".", ";
        }
        if($meta->getOriginal('meta_keywords') != $request->meta_keywords) {
            $activityData .= "Meta-keywords ".$meta->getOriginal('meta_keywords'). " has been changed to " .$request->meta_keywords.", ";
        }
        if($meta->getOriginal('is_product') != $meta->is_product) {
            $activityData .= "Meta-is_product ".$meta->getOriginal('is_product'). " has been changed to " .$meta->is_product.", ";
        }
        if($meta->getOriginal('is_active') != $meta->is_active) {
            $activityData .= "Meta-is_active ".$meta->getOriginal('is_active'). " has been changed to " .$meta->is_active.", ";
        }

        if($meta->save()){
            $this->cmsUserActivity('Meta','Meta has been updated successfully.',$activityData, $title);
            return redirect()->route('cms.meta.list')->with('success', 'Meta has been updated successfully.');
        }

        return redirect()->back()->with('error', 'Meta updation has been failed.');
    }

    public function delete($token, Request $request)
    {

    }

    public function search(Request $request, MetaCollection $metaCollection)
    {
        $query = $request->all();
        unset($query['_token']);
        $metaList = $metaCollection->orWhere('slug', 'like', '%'.$request->get('q').'%')
                        ->orWhere('title', 'like', '%'.$request->get('q').'%')
                        ->orWhere('module', 'like', '%'.$request->get('q').'%')
                        ->orWhere('meta_title', 'like', '%'.$request->get('q').'%')
                        ->orWhere('meta_keywords', 'like', '%'.$request->get('q').'%')
                        ->orderBy('updated_at', 'desc')
                        ->paginate(10)
                        ->setPath('')
                        ->appends($query);

        return view('meta.list', ['metaList' => $metaList])->withQuery(Arr::query($query));
    }

    public function view($slug, MetaCollection $metaCollection)
    {
        $meta = $metaCollection->where('_id', '=', $slug)
                            ->firstOrFail();
        return view('meta.view', ['meta' => $meta]);
    }

    public function status($slug, $type, Request $request, MetaCollection $metaCollection)
    {
        $meta = $metaCollection->where('_id', '=', $slug)
                            ->firstOrFail();
        $title = $meta->title;
        if($type == 'active'){
            $meta->is_active = 1;
            $meta->save();
            $this->cmsUserActivity('Meta','Meta has been activated successfully.', $type, $title);
            return redirect()->route('cms.meta.list')
                            ->with('success', 'News has been activated successfully.');
        }

        if($type == 'inactive'){
            $meta->is_active = 0;
            $meta->save();

            $this->cmsUserActivity('Meta','Meta has been disabled successfully.', $type, $title);
            return redirect()->route('cms.meta.list')
                        ->with('success', 'Meta has been disabled successfully.');
        }

        return redirect()->route('cms.meta.list')
                    ->with('error', 'Oops! Meta status change has been failed. Try again later.');
    }
    
    public function metaCommonSave($data)
    {   
        $metaData  = MetaCollection::where('slug',$data['slug'])->first();
        if(empty($metaData) === true){
            $meta = MetaCollection::create([
                'slug' => empty($data['slug']) === false ? $data['slug'] : NULL,
                'title' => empty($data['title']) === false ? $data['title'] : NULL,
                'module' => empty($data['module']) === false ? $data['module'] : NULL,
                'sub_module' => empty($data['sub_module']) === false ? $data['sub_module'] : NULL,
                'meta_title' => empty($data['meta_title']) === false ? $data['meta_title'] : NULL,
                'meta_description' => empty($data['meta_description']) === false ? $data['meta_description'] : NULL,
                'meta_keywords' => empty($data['meta_keywords']) === false ? $data['meta_keywords'] : NULL,
                'is_product' => empty($data['is_product']) === false ? $data['is_product'] : 0,
                'is_active' => empty($data['is_active']) === false ? $data['is_active'] : 0,
                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString()
            ]);
            return $meta;
        }
    }

    public function metaCommonStatusUpdate($data)
    {
        $meta = MetaCollection::where('slug', '=', $data['slug'])
                            ->update(array('is_active'=>$data['is_active']));

        return $meta;
    }

    public function metaCommonUpdate($slug,$data)
    {
        $meta = MetaCollection::where('slug', '=', $slug)
                            ->update($data);

        return $meta;
    }
    
    public function updateMetaTitle(MetaCollection $metaCollection)
    {
        try
        {
            $data = $metaCollection->select('_id', 'slug', 'meta_title')->get();
            $totalRows = 0;
            foreach($data as $values)
            {
                $meta_title    = $values->meta_title;
                if(empty($meta_title) === false){
                    if (strpos($meta_title, 'Shriram Finance') !== false) {
                    }else{
                        if(strpos($meta_title, 'Shriram') !== false){
                            $meta_desc_replaced      = str_replace("Shriram", "Shriram Finance", $meta_title);
                            $metaUpdated[] = $metaCollection->where('_id', $values->_id)
                                    ->update(['meta_title'=>$meta_desc_replaced]);
                            $totalRows = array_sum($metaUpdated);
                        }
                    }
                }
                
            }
            
            return redirect()->route('cms.users.dashboard')->with('success', "Shriram".' To '."Shriram Finance".' '.$totalRows.' Records Replaced Successfully');
        }
        catch(Exception $e)
        {
            \Log::info("Error -->".$e->getMessage());
        }
    }

    public function updateMetaDescription(MetaCollection $metaCollection)
    {
        try
        {
            $data = $metaCollection->select('_id', 'slug', 'meta_description')->get();
            $totalRows = 0;
            foreach($data as $values)
            {
                $meta_description    = $values->meta_description;
                if(empty($meta_description) === false){
                    if (strpos($meta_description, 'Shriram Finance') !== false) {
                    }else{
                        if(strpos($meta_description, 'Shriram') !== false){
                            $meta_desc_replaced      = str_replace("Shriram", "Shriram Finance", $meta_description);
                            $metaUpdated[] = $metaCollection->where('_id', $values->_id)
                                    ->update(['meta_description'=>$meta_desc_replaced]);
                            $totalRows = array_sum($metaUpdated);
                        }
                    }
                }
                
            }
            
            return redirect()->route('cms.users.dashboard')->with('success', "Shriram".' To '."Shriram Finance".' '.$totalRows.' Records Replaced Successfully');
        }
        catch(Exception $e)
        {
            \Log::info("Error -->".$e->getMessage());
        }
    }

    public function updateTitle(MetaCollection $metaCollection)
    {
        try
        {
            $data = $metaCollection->select('_id', 'slug', 'title')->get();
            $totalRows = 0;
            foreach($data as $values)
            {
                // \Log::info("Meta Title ->".$values->title);            
                $title    = $values->title;
                if(empty($title) === false){
                    if (strpos($title, 'Shriram Finance') !== false) {
                    }else{
                        if(strpos($title, 'Shriram') !== false){
                            $meta_desc_replaced      = str_replace("Shriram", "Shriram Finance", $title);
                            $metaUpdated[] = $metaCollection->where('_id', $values->_id)
                                    ->update(['title'=>$meta_desc_replaced]);
                            $totalRows = array_sum($metaUpdated);
                        }
                    }
                }
                
            }
            
            return redirect()->route('cms.users.dashboard')->with('success', "Shriram".' To '."Shriram Finance".' '.$totalRows.' Records Replaced Successfully');
        }
        catch(Exception $e)
        {
            \Log::info("Error -->".$e->getMessage());
        }
    }
}