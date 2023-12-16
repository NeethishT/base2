<?php
namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Collections\AboutUsCollection;
use App\Collections\MenusCollection;
use Illuminate\Http\Request;
use App\Http\Requests\AddAboutUsRequest;
use App\Http\Requests\EditAboutUsRequest;
use Illuminate\Support\Arr;
use App\Models\Auth\CmsRole;
use App\Utils\CommonUtils;
class AboutusController extends Controller
{
    use CommonUtils;
    protected $AboutUsCollection;
    public function __construct(){
        $this->AboutUsCollection = new AboutUsCollection();
    }
    public function list()
    {
        $List = $this->AboutUsCollection
                            ->orderBy('is_active', 'desc')
                            ->paginate(10);
        return view('aboutus.list', ['list' => $List]);
    }
    public function view($slug)
    {
        $about = $this->AboutUsCollection->where('_id', '=', $slug)
                            ->firstOrFail();
        $about["sub_contents"] = base64_decode($about['sub_contents']);
        $about["page_content"] = base64_decode($about['page_content']);
        $category_name = MenusCollection::where('is_active',1)->where('module',"About Us")->get();
        return view('aboutus.view', ['about' => $about,'category_name' => $category_name]);
    }

    public function add(Request $request, AboutUsCollection $aboutUsCollection, CmsRole $cmsRoleModel)
    {
        $category_name= MenusCollection::where('is_active',1)->where('module',"About Us")->get();
        $roles = $cmsRoleModel->where('is_active', '=', 1)
                            ->get();

        return view('aboutus.add', ['category_name' => $category_name,'roles' => $roles]);
    }

    public function save(AddAboutUsRequest $request, AboutUsCollection $aboutUsCollection)
    {    

        $count = $aboutUsCollection->select('aboutus_id')->orderBy('aboutus_id','desc')->first();
        $aboutus_id = (empty($count) === false) ? $count['aboutus_id']+1:1;
        $aboutus = $aboutUsCollection->create([
            'aboutus_id' => $aboutus_id,
            'category' => $request->category,
            'page_content' => base64_encode($request->page_content),
            'slug' => $request->slug,
            'title' => $request->title,
            'sub_contents' => base64_encode($request->sub_contents),
            'module' => "about-us",
            'is_active' => empty($request->is_active) === false ? 1 : 0,
            'created_date' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            'updated_date' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString()
        ]);
        $title = $request->title;
        $modified = null;
        //meta table insert
        $metaCommonSaveData = array(
            'slug' => $request->slug,
            'title' => $request->title,
            'module' => "company",
            'sub_module' => "About Us",
            'is_active' => empty($request->is_active) === false ? 1 : 0,
        );
        $metaController = new MetaController();
        $metaCommonSave = $metaController->metaCommonSave($metaCommonSaveData);        

        if(empty($aboutus->_id) === false){
            $this->cmsUserActivity('About Us','About Us has been created successfully.', $modified, $title);
            return redirect()->route('cms.aboutus.list')->with('success', 'About Us has been created successfully.');
        } 

        return redirect()->back()->with('error', 'About Us creation has been failed.');
    }

    public function edit($slug, Request $request, AboutUsCollection $aboutUsCollection, CmsRole $cmsRoleModel)
    { 

        $about = $aboutUsCollection->find($slug);
        $about["sub_contents"] = base64_decode($about['sub_contents']);
        $about["page_content"] = base64_decode($about['page_content']);
        $category_name = MenusCollection::where('is_active',1)->where('module',"About Us")->get();
        $roles = $cmsRoleModel->where('is_active', '=', 1)
                            ->get();
        return view('aboutus.edit', ['about' => $about, 'category_name' => $category_name, 'roles' => $roles]);
    }

    public function update($slug, EditAboutUsRequest $request, AboutUsCollection $aboutUsCollection)
    {
        $about = $aboutUsCollection->find($slug);

        //meta table update
        $metaController = new MetaController();
        $metaSlug = $about->slug;

        $about->category = $request->category;
        $about->slug = $request->slug;
        $about->title = $request->title;
        $about->page_content =  base64_encode($request->page_content);
        $about->sub_contents =  base64_encode($request->sub_contents);
        $about->module =  $request->tab_slug;
        $about->is_active = empty($request->is_active) === false ? 1 : 0;
        $about->updated_date = Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString();

        $activityData = "";
        $title = $request->slug;
        if($about->getOriginal('category') != $request['category']) {
            $activityData .= "Category ".$about->getOriginal('category'). " has been changed to " .$request['category'].", ";
        }
        if($about->getOriginal('slug') != $request['slug']) {
            $activityData .= "slug ".$about->getOriginal('slug'). " has been changed to " .$request['slug'].", ";
        }
        if($about->getOriginal('title') != $request['title']) {
            $activityData .= "Title ".$about->getOriginal('title'). " has been changed to " .$request['title'].", ";
        }
        if(base64_decode($about->getOriginal('page_content')) != $request['page_content']) {
            $activityData .= "Page content has been changed".", ";
        }
        if(base64_decode($about->getOriginal('sub_contents')) != $request['sub_contents']) {
            $activityData .= "Sub content has been changed".", ";
        }
        if($about->getOriginal('is_active') != $about->is_active) {
            $activityData .= "is-active ".$about->getOriginal('is_active'). " has been changed to " .$about->is_active.", ";
        }
        
        if($about->save()){

            //meta table update
            $statusUpdateData = array(
                'slug' => $request->slug,
                'title' =>  $request->title,
                'module' => "company",
                'sub_module' => "About Us",
                'is_active' => empty($request->is_active) === false ? 1 : 0,
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString()
            );
            $metaCommonSave = $metaController->metaCommonUpdate($metaSlug,$statusUpdateData);

            $this->cmsUserActivity('About Us','About Us has been updated successfully.', $activityData, $title);
            return redirect()->route('cms.aboutus.list')->with('success', 'About Us has been updated successfully.');
        }

        return redirect()->back()->with('error', 'About Us updation has been failed.');
    }

    public function delete($token, Request $request)
    {

    }

    public function search(Request $request,  AboutUsCollection $aboutUsCollection)
    {
        $query = $request->all();
        unset($query['_token']);
        $list = $aboutUsCollection->orWhere('category', 'like', '%'.$request->get('q').'%')
                        ->orWhere('slug', 'like', '%'.$request->get('q').'%')
                        ->orWhere('title', 'like', '%'.$request->get('q').'%')
                        ->orderBy('updated_date', 'desc')
                        ->paginate(10)
                        ->setPath('')
                        ->appends($query);

        return view('aboutus.list', ['list' => $list])->withQuery(Arr::query($query));
    }

    public function status($slug, $type, Request $request, AboutUsCollection $aboutUsCollection)
    {
        $aboutus = $aboutUsCollection->where('_id', '=', $slug)
                            ->firstOrFail();

        $metaController = new MetaController();
        $title = $aboutus->title;

        if($type == 'active'){
            $aboutus->is_active = 1;
            $aboutus->save();

            //meta table is_active update
            $statusUpdateData = array(
                'slug' => $aboutus->slug,
                'is_active' => 1,
    
            );
            $metaCommonSave = $metaController->metaCommonStatusUpdate($statusUpdateData);
            $this->cmsUserActivity('About Us','About Us has been activated successfully.', $type, $title);
            return redirect()->route('cms.aboutus.list')
                            ->with('success', 'About Us has been activated successfully.');
        }

        if($type == 'inactive'){
            $aboutus->is_active = 0;
            $aboutus->save();

            //meta table is_active update
            $statusUpdateData = array(
                'slug' => $aboutus->slug,
                'is_active' => 0,
    
            );
            $metaCommonSave = $metaController->metaCommonStatusUpdate($statusUpdateData);
            $this->cmsUserActivity('About Us','About Us has been disabled successfully.', $type, $title);
            return redirect()->route('cms.aboutus.list')
                        ->with('success', 'About Us has been disabled successfully.');
        }

        return redirect()->route('cms.aboutus.list')
                    ->with('error', 'Oops! About Us status change has been failed. Try again later.');
    }
}
