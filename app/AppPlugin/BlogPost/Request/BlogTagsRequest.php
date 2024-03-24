<?php

namespace App\AppPlugin\BlogPost\Request;

use App\Helpers\AdminHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class BlogTagsRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    protected function prepareForValidation() {

        $data = $this->toArray();
        foreach (config('app.web_lang') as $key => $lang) {
            data_set($data, $key . '.slug', AdminHelper::Url_Slug($data[$key]['slug']));
        }
        $this->merge($data);
    }

    public function rules(Request $request): array {

        foreach(config('app.web_lang') as $key=>$lang){
            $request->merge([$key.'.slug' => AdminHelper::Url_Slug($request[$key]['slug'])]);
        }


        $id = $this->route('id');
        $rules = [];
        foreach (config('app.web_lang') as $key => $lang) {
            if($id == '0') {
                $rules[$key . ".name"] = "required|unique:blog_tags_translations,name";
                $rules[$key . ".slug"] = "required|unique:blog_tags_translations,slug";
            } else {
                $rules[$key . ".name"] = "required|unique:blog_tags_translations,name,$id,tag_id,locale,$key";
                $rules[$key . ".slug"] = "required|unique:blog_tags_translations,slug,$id,tag_id,locale,$key";
            }
        }
        return $rules;
    }
}



