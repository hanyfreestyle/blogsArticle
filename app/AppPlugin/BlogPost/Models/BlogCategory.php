<?php

namespace App\AppPlugin\BlogPost\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class BlogCategory extends Model implements TranslatableContract {

    use Translatable;
    use HasRecursiveRelationships;

    public $translatedAttributes = ['slug', 'name', 'des', 'g_title', 'g_des'];
    protected $fillable = [''];
    protected $table = "blog_categories";
    protected $primaryKey = 'id';
    protected $translationForeignKey = 'category_id';

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #     scopeDef
    public function scopeDef(Builder $query): Builder {
        return $query->with('translation')->withCount('children');
    }



//#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
//#|||||||||||||||||||||||||||||||||||||| #
//    public function faqs() {
//        return $this->belongsToMany(Faq::class, 'faqcategory_faq', 'category_id', 'faq_id')->with('more_photos')
//            ->withPivot('postion')->orderBy('postion');
//    }

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #  Delete Counts
#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    public function del_category(): HasMany {
        return $this->hasMany(BlogCategory::class, 'parent_id');
    }

    public function del_blog() {
        return $this->belongsToMany(Blog::class, 'blogcategory_blog', 'category_id', 'blog_id')
            ->withTrashed();
    }

    public function homeBlog() {
        return $this->belongsToMany(Blog::class, 'blogcategory_blog', 'category_id', 'blog_id')
            ->orderBy('created_at','desc');
    }

}


//#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
//#|||||||||||||||||||||||||||||||||||||| #
//public function slugs(): HasMany {
//    return $this->hasMany(FaqCategoryTranslation::class, 'category_id', 'id');
//}




