<?php

namespace App\Http\Controllers;

use App\AppPlugin\BlogPost\Models\Blog;
use App\AppPlugin\BlogPost\Models\BlogCategory;
use App\AppPlugin\BlogPost\Models\BlogCategoryTranslation;
use App\AppPlugin\BlogPost\Models\BlogPhotoThumbnail;
use App\AppPlugin\BlogPost\Models\BlogTranslation;
use App\Helpers\AdminHelper;
use Corcel\Model\Meta\ThumbnailMeta;
use Corcel\Model\Taxonomy;
use Corcel\Model\Post;
use Illuminate\Support\Carbon;

class WordPressController extends Controller {

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

        $SaveData = 0;

        if ($SaveData) {
            $posts = Post::published()->where('post_type', 'post')->with('attachment')->with('taxonomies')->take(1)->get();

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
