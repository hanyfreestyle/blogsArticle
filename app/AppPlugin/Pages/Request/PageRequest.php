<?php

namespace App\AppPlugin\Pages\Request;

use App\Helpers\AdminHelper;
use App\Http\Controllers\AdminMainController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PageRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    protected function prepareForValidation() {
        $data = $this->toArray();
        $data = AdminMainController::prepareSlug($data);
        $this->merge($data);
    }

    public function rules(Request $request): array {

        $addLang = json_decode($request->add_lang);
        foreach ($addLang as $key => $lang) {
            $request->merge([$key . '.slug' => AdminHelper::Url_Slug($request[$key]['slug'])]);
        }

        $id = $this->route('id');

        $rules = [
            'categories' => 'required|array|min:1',
        ];

        $rules += AdminMainController::FormRequestSeo($id, $addLang, 'page_translations','page_id');

        return $rules;
    }
}
