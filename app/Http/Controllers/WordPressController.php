<?php

namespace App\Http\Controllers;

use App\AppPlugin\BlogPost\Models\Blog;
use App\AppPlugin\BlogPost\Models\BlogCategory;
use App\AppPlugin\BlogPost\Models\BlogCategoryTranslation;
use App\AppPlugin\BlogPost\Models\BlogPhotoThumbnail;
use App\AppPlugin\BlogPost\Models\BlogTags;
use App\AppPlugin\BlogPost\Models\BlogTagsTranslation;
use App\AppPlugin\BlogPost\Models\BlogTranslation;
use App\Helpers\AdminHelper;
use Corcel\Model\Taxonomy;
use Corcel\Model\Post;
use Illuminate\Support\Carbon;

class WordPressController extends Controller {


public function CheckId(){
    $posts = Post::published()->where('post_type', 'post')->where('ID',53172)->get();
    dd($posts);
}


#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #   UpdatePhotoPath
    public function UpdatePhotoPath($url) {
        $thumbnail = str_replace(['https://articlesarticle.com/', 'http://articlesarticle.com/'], ['', ''], $url);
        return $thumbnail;
    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #  ImportPostsCategory
    public function ImportPostsCategory() {
        $cats = Taxonomy::category()->get();
        $SaveData = 0;
        $index = 0;

        foreach ($cats as $cat) {
            echobr($cat->term->name ?? '');
            echobr($cat->term->slug ?? '');
            echobr($cat->term_taxonomy_id ?? '');
            echobr($cat->description ?? '');
            echobr($cat->parent ?? '');
            echobr($cat->count ?? '');
            echobr("$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$");

            if ($SaveData and $index > 0) {
                $newCat = new BlogCategory();

                $newCat->old_id = $cat->term_taxonomy_id;
                $newCat->old_parent = $cat->parent;
                $newCat->count = $cat->count;
                $newCat->save();

                $newTranslation = new BlogCategoryTranslation();
                $newTranslation->category_id = $newCat->id;
                $newTranslation->locale = "ar";
                $newTranslation->slug = urldecode($cat->term->slug);
                $newTranslation->name = $cat->term->name;
                $newTranslation->des = $cat->description;
                $newTranslation->g_title = $cat->term->name;
                $newTranslation->g_des = AdminHelper::seoDesClean($cat->description);
                $newTranslation->save();
            }

            $index++;

        }

    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| # ImportPosts
    public function ImportPosts() {
        set_time_limit(0);
        $SaveData = 0;


        if ($SaveData) {
//            dd('hi');
//            $posts = Post::published()->where('post_type', 'post')->get();
//            $posts = Post::published()->where('post_type', 'post')->skip(0)->take(1000)->get();
//            $posts = Post::published()->where('post_type', 'post')->skip(1000)->take(1000)->get();
//            $posts = Post::published()->where('post_type', 'post')->skip(2000)->take(1000)->get();
//            $posts = Post::published()->where('post_type', 'post')->skip(3000)->take(1000)->get();
//            $posts = Post::published()->where('post_type', 'post')->skip(4000)->take(1000)->get();
//            $posts = Post::published()->where('post_type', 'post')->skip(5000)->take(1000)->get();
//            $posts = Post::published()->where('post_type', 'post')->skip(6000)->take(1000)->get();
//            dd(count($posts));
        } else {
            $posts = Post::published()->where('post_type', 'post')->with('attachment')->with('taxonomies')->take(1)->get();
        }

        foreach ($posts as $post) {


            $tagArr = array();
            if ($SaveData  == 0) {
                echobr($post->ID);
                echobr($post->post_date);
                echobr($post->post_modified);
                echobr(urldecode($post->post_name));
                echobr(self::UpdatePhotoPath($post->thumbnail->attachment->guid));
            }


            if (isset($post->thumbnail->attachment->guid)) {
                $photo = self::UpdatePhotoPath($post->thumbnail->attachment->guid);
            } else {
                $photo = null;
            }


            $newPost = new Blog();
            $newPost->old_id = $post->ID;
            $newPost->published_at = $post->post_date;
            $newPost->created_at = $post->post_date;
            $newPost->updated_at = $post->post_modified;
            $newPost->photo = $photo;
            $newPost->photo_thum_1 = $photo;

            foreach ($post->taxonomies as $taxonomies){
                if($taxonomies->taxonomy == 'post_tag'){
                    $tagArr =  array_merge($tagArr,[$taxonomies->term_id]);
                }
                if($taxonomies->taxonomy == 'category'){
                    $newPost->old_cat = $taxonomies->term_id;
                }
            }

            $newPost->old_tags = serialize($tagArr);

            if ($SaveData) {
                $newPost->save();
            }

            if (isset($post->thumbnail->attachment->guid)) {
                $allsize = $post->thumbnail->allsize();
                if ($allsize != null) {
                    foreach ($allsize as $key => $value) {
                        $thisDir = dirname($post->thumbnail->attachment->guid . '/' . $value['file']);
                        $saveThumbnail = new BlogPhotoThumbnail();
                        $saveThumbnail->blog_id = $newPost->id;
                        $saveThumbnail->key = $key;
                        $saveThumbnail->file = $value['file'];
                        $saveThumbnail->width = $value['width'];
                        $saveThumbnail->height = $value['height'];
                        $saveThumbnail->url = self::UpdatePhotoPath($thisDir);
                        if ($SaveData) {
                            $saveThumbnail->save();
                        }
                    }
                }
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


        }


    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #   syncBlogCategory
    public function syncBlogCategory() {
        dd('hi');
        $AllCats = BlogCategory::all();
        foreach ($AllCats as $cat) {
            $thisId = $cat->id;
            $oldId = $cat->old_id;
            $AllPost = Blog::where('old_cat', $oldId)->get();
            foreach ($AllPost as $post) {
                $post->categories()->sync([$thisId]);
            }
            echobr(count($AllPost));
        }
    }


#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #   UpdateTags
    public  function UpdateTags(){
        dd('hi');
        $AllPost = Blog::where('update_tags', null)->take(150)->get();
//        $AllPost = Blog::where('update_tags', null)->where('id',4385)->take(1)->get();
        foreach ($AllPost as $post){
             $oldTags = unserialize($post->old_tags);
             $newTags = array();
             foreach ($oldTags as $oldTag){
                 $newTagModel = BlogTags::where('old_id',$oldTag)->first();
                 $newTags =  array_merge($newTags,[$newTagModel->id]);
             }
            $post->tags()->sync($newTags);
            $post->update_tags = 1;
            $post->save();
        }
        echobr( $AllPost = Blog::where('update_tags', null)->take(500)->count());

    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #   ImportTags
    public function ImportTags() {
        set_time_limit(0);
        $SaveData =0;

        if ($SaveData) {
            $tags = Taxonomy::where('taxonomy','post_tag')->with('term')->get();
        } else {
            $tags = Taxonomy::where('taxonomy', 'post_tag')->take('1')->with('term')->get();
        }

//        dd(count($tags));

        foreach ($tags as $tag){

            $newTag = new BlogTags();
            $newTag->old_id  = $tag->term_id ;
            $newTag->count  = $tag->count ;
            $newTag->old_count  = $tag->count ;

            if($SaveData){
                $newTag->save();
                $newTranslation = new BlogTagsTranslation();
                $newTranslation->tag_id = $newTag->id ;
                $newTranslation->locale = "ar" ;
                $newTranslation->slug =  urldecode($tag->term->slug);
                $newTranslation->name = $tag->term->name ;
                $newTranslation->save() ;
            }else{
                echobr($tag->term_id);
                echobr($tag->count);
                echobr($tag->term->name);
                echobr(urldecode($tag->term->slug));
            }
        }
    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #
    public function CountSlug(){
        set_time_limit(0);
        $blogs = BlogTranslation::where('slug_count',null)->take(1000)->get();
        $blogs = BlogTranslation::where('slug_count','>',1)->take(1000)->get();

        foreach ($blogs as $blog){
            $count = BlogTranslation::where('slug',$blog->slug)->count();
            $blog->slug_count = $count ;
            $blog->save() ;
        }

    }





#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #
    public function UpdateMeta($saveData, $row, $val) {
        $saveTranslation = BlogTranslation::where("blog_id", $saveData)->where('locale', 'ar')->first();
        if ($saveTranslation != null) {
            $saveTranslation->$row = $val;
            $saveTranslation->save();
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
            $newPost->created_at = $post->post_date;
            $newPost->updated_at = $post->post_modified;
            $newPost->published_at = Carbon::parse($post->post_date)->format("Y-m-d");
            if ($post->thumbnail != null) {
                $thumbnail = str_replace('https://cottton.shop/', '', $post->thumbnail);
                $newPost->photo = $thumbnail;
                $newPost->photo_thum_1 = $thumbnail;
            }
            $newPost->save();

            $newTranslation = new BlogTranslation();
            $newTranslation->blog_id = $newPost->id;
            $newTranslation->locale = "ar";
            $newTranslation->slug = urldecode($post->post_name);;
            $newTranslation->name = $post->post_title;
            $newTranslation->des = $post->post_content;
            $newTranslation->save();

            foreach ($post->meta as $meta) {
                $Line = $meta->meta_key . " > " . $meta->meta_value;

                if ($meta->meta_key == '_yoast_wpseo_primary_category') {
                    $newPost->old_cat = $meta->meta_value;
                    $newPost->save();
                }

                if ($meta->meta_key == '_yoast_post_redirect_info') {
                    $newPost->redirect_info = $meta->meta_value;
                    $newPost->save();
                }


                if ($meta->meta_key == '_yoast_wpseo_title') {
                    self::UpdateMeta($newPost->id, 'g_title', $meta->meta_value);
                }

                if ($meta->meta_key == '_yoast_wpseo_metadesc') {
                    self::UpdateMeta($newPost->id, 'g_des', $meta->meta_value);
                }


                echobr($Line);

            }
            echobr("----------------------------");
        }

    }

}
