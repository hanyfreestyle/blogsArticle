<?php

namespace App\AppPlugin\Pages;

use App\AppPlugin\Pages\Models\PageCategory;
use App\AppPlugin\Pages\Models\PageCategoryTranslation;
use App\AppPlugin\Pages\Request\PageCategoryRequest;
use App\Helpers\AdminHelper;

use App\Http\Controllers\AdminMainController;
use App\Http\Traits\CrudTraits;
use App\Http\Traits\CategoryTraits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;


class PageCategoryController extends AdminMainController {

    use CrudTraits;
    use CategoryTraits;

    function __construct(PageCategory $model, PageCategoryTranslation $translation) {

        parent::__construct();
        $this->controllerName = "PageCategory";
        $this->PrefixRole = 'Pages';
        $this->selMenu = "Pages.";
        $this->PrefixCatRoute = "";
        $this->PageTitle = __('admin/pages.app_menu_category');
        $this->PrefixRoute = $this->selMenu . $this->controllerName;
        $this->model = $model;

        $this->UploadDirIs = 'pages-cat';
        $this->translation = $translation;
        $this->translationdb = 'category_id';


        self::SetCatTree(false, 2);

        $this->categoryIcon = false;
        View::share('categoryIcon', $this->categoryIcon);

        $sendArr = [
            'TitlePage' => $this->PageTitle,
            'PrefixRoute' => $this->PrefixRoute,
            'PrefixRole' => $this->PrefixRole,
            'AddConfig' => true,
            'configArr' => ["editor" => 0, 'iconfilterid' => 0, 'labelView' => 0],
            'yajraTable' => false,
            'AddLang' => false,
        ];

        self::loadConstructData($sendArr);

    }
#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| # ClearCash
    public function ClearCash() {
        Cache::forget('ssssssss');
    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #     CategoryStoreUpdate
    public function CategoryStoreUpdate(PageCategoryRequest $request, $id = 0) {

        return self::TraitsCategoryStoreUpdate($request, $id);
    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #     destroyException
    public function destroyException($id) {
        $deleteRow = PageCategory::where('id', $id)
            ->withCount('del_category')
            ->withCount('del_page')
            ->firstOrFail();



        if($deleteRow->del_category_count == 0 and $deleteRow->del_page_count == 0) {
            try {
                DB::transaction(function () use ($deleteRow, $id) {
                    $deleteRow = AdminHelper::DeleteAllPhotos($deleteRow);
                    AdminHelper::DeleteDir($this->UploadDirIs, $id);
                    $deleteRow->forceDelete();
                });
            } catch (\Exception $exception) {
                return back()->with(['confirmException' => '', 'fromModel' => 'CategoryPages', 'deleteRow' =>
                    $deleteRow]);
            }
        } else {
            return back()->with(['confirmException' => '', 'fromModel' => 'CategoryPages', 'deleteRow' => $deleteRow]);
        }

        self::ClearCash();
        return back()->with('confirmDelete', "");
    }


}
