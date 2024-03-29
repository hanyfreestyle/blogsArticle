<?php

namespace App\AppPlugin\BlogPost;

use App\AppPlugin\BlogPost\Models\Blog;
use App\AppPlugin\BlogPost\Models\BlogCategory;
use App\AppPlugin\BlogPost\Models\BlogPhoto;
use App\AppPlugin\BlogPost\Models\BlogPhotoTranslation;
use App\AppPlugin\BlogPost\Models\BlogReview;
use App\AppPlugin\BlogPost\Models\BlogTags;
use App\AppPlugin\BlogPost\Models\BlogTagsTranslation;
use App\AppPlugin\BlogPost\Models\BlogTranslation;

use App\AppPlugin\BlogPost\Request\BlogPostRequest;
use App\Helpers\AdminHelper;
use App\Http\Controllers\AdminMainController;

use App\Http\Traits\CrudTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;


class BlogPostController extends AdminMainController {

    use CrudTraits;


    function __construct(Blog $model, BlogTranslation $translation,BlogCategory $modelCategory, BlogPhoto $modelPhoto , BlogPhotoTranslation $photoTranslation ) {
        parent::__construct();
        $this->controllerName = "BlogPost";
        $this->PrefixRole = 'Blog';
        $this->selMenu = "Blog.";
        $this->PrefixCatRoute = "";
        $this->PageTitle = __('admin/blogPost.app_menu_blog');
        $this->PrefixRoute = $this->selMenu . $this->controllerName;
        $this->model = $model;
        $this->modelCategory = $modelCategory;
        $this->modelPhoto = $modelPhoto;
        $this->photoTranslation = $photoTranslation;
        $this->modelPhotoColumn = 'blog_id';
        $this->UploadDirIs = 'blog';
        $this->translation = $translation;
        $this->translationdb = 'blog_id';

        $this->modelPhotoEdit = true;
        View::share('modelPhotoEdit', $this->modelPhotoEdit);

        $sendArr = [
            'TitlePage' => $this->PageTitle,
            'PrefixRoute' => $this->PrefixRoute,
            'PrefixRole' => $this->PrefixRole,
            'AddConfig' => true,
            'configArr' => ["editor" => 1, 'morePhotoFilterid' => 1],
            'yajraTable' => true,
            'AddLang' => true,
            'AddMorePhoto' => true,
            'restore' => 1,
        ];

        self::loadConstructData($sendArr);

    }


#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| # ClearCash
    public function ClearCash() {
        Cache::forget('CCCCCCCCCCCC');
    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #     index
    public function index() {
        $pageData = $this->pageData;
        $pageData['ViewType'] = "List";
        $pageData['SubView'] = false;
        $pageData['Trashed'] = $this->model::onlyTrashed()->count();

        if ($this->viewDataTable and $this->yajraTable){
            return view('AppPlugin.BlogPost.index_DataTable',compact('pageData'));
        }else{
            $rowData = self::getSelectQuery($this->model::def());
            return view('AppPlugin.BlogPost.index', compact('pageData', 'rowData'));
        }
    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #   DataTable
    public function DataTable(Request $request){
        if ($request->ajax()) {
            $data = $this->model::select(['blog_post.id','photo_thum_1','is_active','published_at'])->with('tablename');
            return self::DataTableAddColumns($data)->make(true);
        }
    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #     SoftDeletes
    public function SoftDeletes() {
        $pageData = $this->pageData;
        $pageData['ViewType'] = "deleteList";
        $pageData['SubView'] = false;
        $rowData = self::getSelectQuery($this->model::onlyTrashed());
        return view('AppPlugin.BlogPost.index', compact('pageData', 'rowData'));
    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #     SubCategory
    public function ListCategory($id) {
        $pageData = $this->pageData;
        $pageData['ViewType'] = "List";
        $pageData['SubView'] = true;
        $Category = $this->modelCategory::findOrFail($id);
        $rowData = self::getSelectQuery($this->model::def()->whereHas('categories', function ($query) use ($id) {
            $query->where('category_id', $id);
        }));
        return view('AppPlugin.BlogPost.index', compact('pageData', 'rowData'));
    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #     create
    public function create() {
        $pageData = $this->pageData;
        $pageData['ViewType'] = "Add";
        $Categories = BlogCategory::with('translation')->get();
        $rowData = $this->model::findOrNew(0);
        $LangAdd = self::getAddLangForAdd();
        $selCat = [];
        $tags = BlogTags::where('id','!=',0)->take(50)->get();
        $selTags = [];
        $selActive = 1;
        return view('AppPlugin.BlogPost.form',compact('pageData','rowData','Categories','LangAdd','selCat','tags','selTags','selActive'));
    }




#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #     edit
    public function edit($id) {
        $pageData = $this->pageData;
        $pageData['ViewType'] = "Edit";
        $Categories = $this->modelCategory::all();
        $rowData = $this->model::where('id', $id)->with('categories')->with('userName')->with('reviews')->firstOrFail();
        $selCat = $rowData->categories()->pluck('category_id')->toArray();
        $LangAdd = self::getAddLangForEdit($rowData);

        $selTags = $rowData->tags()->pluck('tag_id')->toArray();
        $tags = BlogTags::whereIn('id',$selTags)->take(50)->get();


        $selActive = $rowData->is_active ;
        return view('AppPlugin.BlogPost.form',compact('pageData','rowData','Categories','LangAdd','selCat','tags','selTags','selActive'));

    }


#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #     storeUpdate
    public function storeUpdate(BlogPostRequest $request, $id = 0) {
        $saveData = $this->model::findOrNew($id);
        try {
            DB::transaction(function () use ($request, $saveData) {
                $categories = $request->input('categories');
                $tags = $request->input('tag_id');
                $user_id = Auth::user()->id;

                $saveData->is_active = intval((bool)$request->input('is_active'));
                $saveData->youtube = $request->input('youtube');
                $saveData->published_at = SaveDateFormat($request,'published_at');
                if($request->input('form_type') == 'Add'){
                    $saveData->user_id = $user_id;
                }
                $saveData->save();

                if($request->input('form_type') == 'Edit'){
                    $blogReview = new BlogReview();
                    $blogReview->user_id = $user_id;
                    $blogReview->blog_id  = $saveData->id;
                    $blogReview->updated_at  = now();
                    $blogReview->save();
//                    dd('hi');
                }


                $saveData->categories()->sync($categories);
                $saveData->tags()->sync($tags);

                self::SaveAndUpdateDefPhoto($saveData, $request, $this->UploadDirIs, 'en.name');

                $addLang = json_decode($request->add_lang);
                foreach ($addLang as $key => $lang) {
                    $dbName = $this->translationdb;
                    $saveTranslation = $this->translation->where($dbName, $saveData->id)->where('locale', $key)->firstOrNew();
                    $saveTranslation->$dbName = $saveData->id;
                    $saveTranslation->youtube_title = $request->input($key.'.youtube_title');
                    $saveTranslation->slug = AdminHelper::Url_Slug($request->input($key . '.slug'));
                    $saveTranslation = self::saveTranslationMain($saveTranslation, $key, $request);
                    $saveTranslation->save();
                }

            });
        } catch (\Exception $exception) {
            return back()->with('data_not_save', "");
        }
        self::ClearCash();
        return self::redirectWhere($request, $id, $this->PrefixRoute . '.index');

    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #     ForceDeletes
    public function ForceDeleteException($id) {
        $deleteRow = $this->model::onlyTrashed()->where('id', $id)->with('more_photos')->firstOrFail();
        if(count($deleteRow->more_photos) > 0) {
            foreach ($deleteRow->more_photos as $del_photo) {
                AdminHelper::DeleteAllPhotos($del_photo);
            }
        }
        $deleteRow = AdminHelper::DeleteAllPhotos($deleteRow);
        AdminHelper::DeleteDir($this->UploadDirIs, $id);
        $deleteRow->forceDelete();
        self::ClearCash();
        return back()->with('confirmDelete', "");
    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #   TagsSearch

    public function TagsSearch(Request $request){

        if(!empty($_GET['type']) && $_GET['type'] == 'TagsSearch'){
            $search = $request->search;

            $employees = BlogTagsTranslation::orderby('name','asc')->select('id','name')->where('name', 'like', '%' .$search . '%')->limit(50)->get();

            $response = array();
            foreach($employees as $employee){
                $response[] = array("id"=>$employee->id,"text"=>$employee->name);
            }
            return response()->json($response);
        }
    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| # TagsOnFly
    public function TagsOnFly(Request $request){

        $response = array('addDone'=>false);

        if($request->newTagData['newTag'] == true){
            $slug = AdminHelper::Url_Slug($request->newTagData['text']);
            $slugCount = BlogTagsTranslation::where('slug',$slug)->count();
            if($slugCount == 0){
                $addNewTag = new BlogTags();
                $addNewTag->save();
                $newTranslation = new BlogTagsTranslation();
                $newTranslation->tag_id = $addNewTag->id;
                $newTranslation->locale = 'ar';
                $newTranslation->slug = $slug;
                $newTranslation->name = $request->newTagData['text'];
                $newTranslation->save();
                $response = array('addDone'=>true,'id'=>$addNewTag->id);
            }
        }

        return response()->json($response);
    }


}
