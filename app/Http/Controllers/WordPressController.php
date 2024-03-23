<?php

namespace App\Http\Controllers;

use App\AppPlugin\BlogPost\Models\Blog;
use App\AppPlugin\BlogPost\Models\BlogCategory;
use App\AppPlugin\BlogPost\Models\BlogCategoryTranslation;
use App\AppPlugin\BlogPost\Models\BlogTranslation;
use App\Helpers\AdminHelper;
use Corcel\Model\Meta\ThumbnailMeta;
use Corcel\Model\Taxonomy;

use Corcel\Model\Post;
use Illuminate\Support\Carbon;

class WordPressController extends Controller {

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #  ImportPostsCategory
    public function ImportPostsCategory() {
        $cats = Taxonomy::category()->get();
        $SaveData = 0 ;
        $index = 0;

        foreach ($cats as $cat){

            echobr($cat->term->name ?? '');
            echobr($cat->term->slug ?? '' );
            echobr($cat->term_taxonomy_id ?? '');
            echobr($cat->description ?? '');
            echobr($cat->parent ?? '');
            echobr($cat->count ?? '');
            echobr("$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$");


            if($SaveData and $index >  0){
                $newCat = new BlogCategory();

                $newCat->old_id = $cat->term_taxonomy_id;
                $newCat->old_parent = $cat->parent;
                $newCat->count = $cat->count;
                $newCat->save();

                $newTranslation = new BlogCategoryTranslation();
                $newTranslation->category_id = $newCat->id ;
                $newTranslation->locale = "ar" ;
                $newTranslation->slug =  urldecode($cat->term->slug);
                $newTranslation->name = $cat->term->name ;
                $newTranslation->des  = $cat->description ;
                $newTranslation->g_title  = $cat->term->name ;
                $newTranslation->g_des  =  AdminHelper::seoDesClean($cat->description) ;
                $newTranslation->save() ;
            }

            $index++;

        }


//        dd($cats);
    }


#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #
    public function indexsssssssssssssss(){
        $SaveData = 0 ;

        if($SaveData){
            $posts = Post::published()->where('post_type', 'product')->with('attachment')
                ->take(5555555555555555555)->get();

        }else{
            $posts = Post::published()->where('post_type', 'product')->with('attachment')->take(2)->get();
        }

        foreach ($posts as $post) {
            echobr($post->ID);
            if(isset($post->thumbnail->attachment->guid)){
                $photo = self::UpdatePhotoPath($post->thumbnail->attachment->guid);
            }else{
                $photo = null;
            }

            $newProduct = new Product();
            $newProduct->old_id = $post->ID;
            $newProduct->created_at  = $post->post_date;
            $newProduct->updated_at   = $post->post_modified;
            $newProduct->photo   = $photo;

            if ($SaveData){
                $newProduct->save();
            }
            if(isset($post->thumbnail->attachment->guid)){
                $allsize = $post->thumbnail->allsize();

                if($allsize != null){
                    foreach ($allsize as $key => $value){
                        $thisDir = dirname($post->thumbnail->attachment->guid .'/'.$value['file']);
                        $saveThumbnail = new ProductPhotoThumbnail();
                        $saveThumbnail->product_id = $newProduct->id;
                        $saveThumbnail->key = $key;
                        $saveThumbnail->file = $value['file'];
                        $saveThumbnail->width = $value['width'];
                        $saveThumbnail->height = $value['height'];
                        $saveThumbnail->url = self::UpdatePhotoPath($thisDir);
                        if ($SaveData){
                            $saveThumbnail->save();
                        }
                    }
                }
            }


//            dd('stop');
//            $newTranslation = new ProductTranslation();
//            $newTranslation->product_id = $newProduct->id ;
//            $newTranslation->locale = "ar" ;
//            $newTranslation->slug =  urldecode($post->post_name); ;
//            $newTranslation->name = $post->post_title ;
//            $newTranslation->des  = $post->post_content ;
//            if ($SaveData){
//                $newTranslation->save() ;
//            }



        }


    }



#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #   ImportPosts
    public function indexssssssssssssssss() {

        //$posts = Post::published()->where('post_type', 'post')->get();


        $SaveData = 0 ;

        if($SaveData){
            $posts = Post::published()->where('post_type', 'post')->get();
        }else{
            $posts = Post::published()->where('post_type', 'product')->take(2)->get();
        }

        $cats = Taxonomy::where('taxonomy', 'pa_الماركة')->with('meta')->take(1)->get();
        $posts = Post::published()->where('ID', 47745)->with('taxonomies')->take(2)->get();
        $posts = Post::published()->where('ID', 47745)->with('taxonomies')->with('comments')->with('attachment')->first();

        dd(Post::published()->where('post_type', 'product')->count());


//        const SIZE_THUMBNAIL = 'thumbnail';
//        const SIZE_MEDIUM = 'medium';
//        const SIZE_LARGE = 'large';
//        const SIZE_FULL = 'full';
       dd( $posts->thumbnail->size(ThumbnailMeta::SIZE_THUMBNAIL));
        dd($posts->getTermsAttribute());
       foreach ($posts->taxonomies as $tt){
           echobr($tt->term_id . " ".$tt->taxonomy);
       }

       dd('stop');

        foreach ($posts as $post) {
            echobr($post->ID);
            echobr('##############################################');

//            $newPost = new Blog();
//            $newPost->old_id = $post->ID;
//            $newPost->created_at  = $post->post_date;
//            $newPost->updated_at   = $post->post_modified;
//            $newPost->published_at   = Carbon::parse($post->post_date)->format("Y-m-d");
//            if($post->thumbnail != null){
//                $thumbnail = str_replace('https://cottton.shop/','',$post->thumbnail);
//                $newPost->photo  = $thumbnail;
//                $newPost->photo_thum_1  = $thumbnail;
//            }
//
//            if ($SaveData){
//                $newPost->save();
//            }
//
//
//            $newTranslation = new BlogTranslation();
//            $newTranslation->blog_id = $newPost->id ;
//            $newTranslation->locale = "ar" ;
//            $newTranslation->slug =  urldecode($post->post_name); ;
//            $newTranslation->name = $post->post_title ;
//            $newTranslation->des  = $post->post_content ;
//            if ($SaveData){
//                $newTranslation->save() ;
//            }


            foreach ($post->meta as $meta) {
                $Line = $meta->meta_key . " > " . $meta->meta_value;

//                if ($SaveData){
//                    if ($meta->meta_key == '_yoast_wpseo_primary_category' ) {
//                        $newPost->old_cat = $meta->meta_value;
//                        $newPost->save();
//                    }
//
//                    if ($meta->meta_key == 'rank_math_primary_category' ) {
//                        $newPost->old_cat = $meta->meta_value;
//                        $newPost->save();
//                    }
//
//
//                    if ($meta->meta_key == '_yoast_post_redirect_info' ) {
//                        $newPost->redirect_info = $meta->meta_value;
//                        $newPost->save();
//                    }
//
//
//                    if ($meta->meta_key == '_yoast_wpseo_title') {
//                        self::UpdateMeta($newPost->id,'g_title',$meta->meta_value);
//                    }
//
//                    if ($meta->meta_key == '_yoast_wpseo_metadesc') {
//                        self::UpdateMeta($newPost->id,'g_des',$meta->meta_value);
//                    }
//
//                }

                echobr($Line);
            }
            echobr("----------------------------");
        }
    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #ImportCat
    public function indexImportCat(){
        $cats = Taxonomy::where('taxonomy', 'product_cat')->with('meta')->take(500000)->get();
        $saveData = 0;


        foreach ($cats as $cat){
            $newBrand = new Category();


            $newBrand->old_id = $cat->term_id;
            $newBrand->product_count = $cat->count;
            $newBrand->old_parent =$cat->parent;
            if($saveData){$newBrand->save();}


            $newTranslation = new CategoryTranslation();
            $newTranslation->category_id = $newBrand->id ;
            $newTranslation->locale = "ar" ;
            $newTranslation->slug = urldecode($cat->term->slug);
            $newTranslation->name = $cat->term->name ;
            $newTranslation->des  = $cat->description ;
            $newTranslation->g_title  = $cat->term->name ;
            $newTranslation->g_des  =  AdminHelper::seoDesClean($cat->description) ;
            if($saveData){$newTranslation->save() ;}

            foreach ($cat->meta as $metas){
                if($metas->meta_key != 'below_category_content'){
                    echobr($metas->meta_key." ".$metas->meta_value);
                }else{
                    echobr($metas->meta_key);
                }

                if( $metas->meta_key == 'below_category_content'){
                    $newTranslation->des  =  $metas->meta_value ;
                    $newTranslation->g_des  =  AdminHelper::seoDesClean($metas->meta_value) ;
                    if($saveData){$newTranslation->save() ;}
                }

                if( $metas->meta_key == 'product_count_product_cat'){
                    $newBrand->product_count = $cat->count;
                    if($saveData){$newBrand->save();}
                }


                if( $metas->meta_key == 'thumbnail_id'){
                    $post = Post::find($metas->meta_value);
                    if(isset($post->guid)){
                        $newBrand->photo = self::UpdatePhotoPath($post->guid);
                        $newBrand->photo_thum_1 = self::UpdatePhotoPath($post->guid);
                        if($saveData){$newBrand->save();}
                    }
                }

            }
            echobr('###############################$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$');
        }

    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #ImportBrands
    public function indexImportBrands(){
//    $cat = Taxonomy::where('taxonomy', 'yith_product_brand')->with('posts')->take(1)->get();
        $cats = Taxonomy::where('taxonomy', 'yith_product_brand')->with('meta')->take(1)->get();
        $saveData = 0 ;


        foreach ($cats as $cat){
            $newBrand = new Brand();
            $newBrand->old_id = $cat->term_id;
            $newBrand->product_count = $cat->count;
            $newBrand->old_parent =$cat->parent;
            if($saveData){$newBrand->save();}

            $newTranslation = new BrandTranslation();
            $newTranslation->brand_id = $newBrand->id ;
            $newTranslation->locale = "ar" ;
            $newTranslation->slug = urldecode($cat->term->slug);
            $newTranslation->name = $cat->term->name ;
            $newTranslation->des  = $cat->description ;
            if($saveData){$newTranslation->save() ;}

            foreach ($cat->meta as $metas){
                echobr($metas->meta_key." ".$metas->meta_value);

                if( $metas->meta_key == 'thumbnail_id'){
                    $post = Post::find($metas->meta_value);
                    if(isset($post->guid)){
                        $newBrand->photo_thum_1 = self::UpdatePhotoPath($post->guid);
                        if($saveData){$newBrand->save();}
                    }
                }

                if( $metas->meta_key == 'banner_id' ){
                    $post = Post::find($metas->meta_value);
                    if(isset($post->guid)){
                        $newBrand->photo = self::UpdatePhotoPath($post->guid);
                        if($saveData){$newBrand->save();}
                    }
                }

                if( $metas->meta_key == 'rank_math_description'){
                    $newTranslation->g_des  =  $metas->meta_value ;
                    if($saveData){$newTranslation->save() ;}
                }

                if( $metas->meta_key == 'rank_math_title'){
                    $g_title = str_replace(['%term%','%title%','|'],['','',''],$metas->meta_value);
                    $newTranslation->g_title  = trim($g_title) ;
                    if($saveData){$newTranslation->save() ;}
                }

            }
        }


        $getAllBrand = Brand::where('photo','=',null)->where('photo_thum_1','!=',null)->get();
        foreach ($getAllBrand as $Update){
            $Update->photo = $Update->photo_thum_1 ;
            $Update->save() ;
        }



    }


#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #   UpdatePhotoPath
    public function UpdatePhotoPath($url){
        $thumbnail = str_replace(['https://cottton.shop/','http://cottton.shop/'],['',''],$url);
        return $thumbnail;
    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #   syncBlogCategory
    public function indexXXX(){
        $AllCats = BlogCategory::all();
        foreach ($AllCats as $cat){
            $thisId = $cat->id ;
            $oldId = $cat->old_id ;
            $AllPost = Blog::where('old_cat',$oldId)->get();
            foreach ($AllPost as $post){
                $post->categories()->sync([$thisId]);
            }
            echobr(count($AllPost));
        }
        dd($AllCats);
    }





#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #   ImportPosts
    public function indexII() {

        //$posts = Post::published()->where('post_type', 'post')->get();


        $SaveData = 0 ;

        if($SaveData){
            $posts = Post::published()->where('post_type', 'post')->get();
        }else{
            $posts = Post::published()->where('post_type', 'post')->where('ID',57483)->take(25)->get();
        }


        foreach ($posts as $post) {
            echobr($post->ID);
            echobr('##############################################');

            $newPost = new Blog();
            $newPost->old_id = $post->ID;
            $newPost->created_at  = $post->post_date;
            $newPost->updated_at   = $post->post_modified;
            $newPost->published_at   = Carbon::parse($post->post_date)->format("Y-m-d");
            if($post->thumbnail != null){
                $thumbnail = str_replace('https://cottton.shop/','',$post->thumbnail);
                $newPost->photo  = $thumbnail;
                $newPost->photo_thum_1  = $thumbnail;
            }

            if ($SaveData){
                $newPost->save();
            }


            $newTranslation = new BlogTranslation();
            $newTranslation->blog_id = $newPost->id ;
            $newTranslation->locale = "ar" ;
            $newTranslation->slug =  urldecode($post->post_name); ;
            $newTranslation->name = $post->post_title ;
            $newTranslation->des  = $post->post_content ;
            if ($SaveData){
                $newTranslation->save() ;
            }


            foreach ($post->meta as $meta) {
                $Line = $meta->meta_key . " > " . $meta->meta_value;

                if ($SaveData){
                    if ($meta->meta_key == '_yoast_wpseo_primary_category' ) {
                        $newPost->old_cat = $meta->meta_value;
                        $newPost->save();
                    }

                    if ($meta->meta_key == 'rank_math_primary_category' ) {
                        $newPost->old_cat = $meta->meta_value;
                        $newPost->save();
                    }


                    if ($meta->meta_key == '_yoast_post_redirect_info' ) {
                        $newPost->redirect_info = $meta->meta_value;
                        $newPost->save();
                    }


                    if ($meta->meta_key == '_yoast_wpseo_title') {
                        self::UpdateMeta($newPost->id,'g_title',$meta->meta_value);
                    }

                    if ($meta->meta_key == '_yoast_wpseo_metadesc') {
                        self::UpdateMeta($newPost->id,'g_des',$meta->meta_value);
                    }

                }

               echobr($Line);
            }
            echobr("----------------------------");
        }
    }





#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #
public function UpdateMeta($saveData,$row,$val){
    $saveTranslation = BlogTranslation::where("blog_id", $saveData)->where('locale', 'ar')->first();
    if($saveTranslation != null){
        $saveTranslation->$row = $val ;
        $saveTranslation->save() ;
    }
}


    #@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #
    public function indexSSSS() {

        $posts = Post::published()->where('post_type', 'post')->take(25)->get();

        foreach ($posts as $post) {
            echobr($post->ID);
            echobr('##############################################');

            $newPost = new Blog();
            $newPost->old_id = $post->ID;
            $newPost->created_at  = $post->post_date;
            $newPost->updated_at   = $post->post_modified;
            $newPost->published_at   = Carbon::parse($post->post_date)->format("Y-m-d");
            if($post->thumbnail != null){
                $thumbnail = str_replace('https://cottton.shop/','',$post->thumbnail);
                $newPost->photo  = $thumbnail;
                $newPost->photo_thum_1  = $thumbnail;
            }
            $newPost->save();

            $newTranslation = new BlogTranslation();
            $newTranslation->blog_id = $newPost->id ;
            $newTranslation->locale = "ar" ;
            $newTranslation->slug =  urldecode($post->post_name); ;
            $newTranslation->name = $post->post_title ;
            $newTranslation->des  = $post->post_content ;
            $newTranslation->save() ;

            foreach ($post->meta as $meta) {
                $Line = $meta->meta_key . " > " . $meta->meta_value;

                if ($meta->meta_key == '_yoast_wpseo_primary_category' ) {
                    $newPost->old_cat = $meta->meta_value;
                    $newPost->save();
                }

                if ($meta->meta_key == '_yoast_post_redirect_info' ) {
                    $newPost->redirect_info = $meta->meta_value;
                    $newPost->save();
                }


                if ($meta->meta_key == '_yoast_wpseo_title') {
                    self::UpdateMeta($newPost->id,'g_title',$meta->meta_value);
                }

                if ($meta->meta_key == '_yoast_wpseo_metadesc') {
                    self::UpdateMeta($newPost->id,'g_des',$meta->meta_value);
                }


                echobr($Line);

            }
            echobr("----------------------------");
        }

    }

}
