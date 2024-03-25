@extends('admin.layouts.app')

@section('content')
    <x-admin.hmtl.breadcrumb :pageData="$pageData"/>

    <x-admin.hmtl.top-edit-page :page-data="$pageData" :row="$rowData"  />

    <x-admin.hmtl.section>
        <x-admin.card.def :page-data="$pageData">
            <form class="mainForm" action="{{route($PrefixRoute.'.update',intval($rowData->id))}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <x-admin.form.date-form name="published_at" value="{{old('published_at',$rowData->published_at)}}" />
                    <x-admin.form.select-multiple name="categories" :categories="$Categories" :sel-cat="$selCat" col="9" />
                </div>




                <div class="row">
                    <x-admin.form.select-multiple name="tag_id" :categories="$tags" :sel-cat="$selTags" col="12" />

{{--                    <select class="is-invalid " id="user_select" multiple="multiple" name="tag_id[]" data-placeholder="" style="width: 100%;">--}}
{{--                        @foreach($tags as $tag )--}}
{{--                            <option value="{{$tag->id}}"--}}
{{--                            @if(is_array($selTags))--}}
{{--                                {{ (in_array($tag->id,$selTags)) ? 'selected' : ''}}--}}
{{--                                @endif--}}
{{--                                {{ (collect(old('tag_id'))->contains($tag->id)) ? 'selected':'' }}>{{ print_h1($tag)}}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}

{{--                    <x-admin.form.select-multiple name="blog_tag" :categories="$tags" :sel-cat="$selTags" col="12" />--}}



                </div>

                <div class="row">
                    <input type="hidden" name="add_lang" value="{{json_encode($LangAdd)}}">
                    @foreach ( $LangAdd as $key=>$lang )
                        <x-admin.lang.meta-tage-filde :row="$rowData" :key="$key" :viewtype="$pageData['ViewType']" :label-view="$viewLabel"
                                                      :def-name="__('admin/blogPost.blog_text_name')" />
                    @endforeach
                </div>

                <hr>
                <x-admin.form.check-active name="is_active" :row="$rowData" :page-view="$pageData['ViewType']"/>

                <hr>
                <div class="row">
                    <x-admin.form.input name="youtube" :row="$rowData" :label="__('admin/form.text_youtube')" col="4" tdir="en" :req="false"  />
                    @foreach ( $LangAdd as $key=>$lang )
                        <x-admin.form.trans-input name="youtube_title" :key="$key" :row="$rowData" :label="__('admin/form.text_youtube_title')" col="4" :req="false" :tdir="$key"/>
                    @endforeach
                </div>
                <hr>
                <x-admin.form.upload-model-photo :page="$pageData" :row="$rowData" col="6"/>
                <x-admin.form.submit-role-back :page-data="$pageData"/>
            </form>
        </x-admin.card.def>
    </x-admin.hmtl.section>

@endsection


@push('JsCode')
    <x-admin.table.sweet-delete-js/>
    <link rel="stylesheet" href="{{ defAdminAssets('jqueryui/jquery-ui.min.css') }}">
    <script src="{{defAdminAssets('jqueryui/jquery-ui.min.js')}}"></script>
    <x-admin.java.update-slug :view-type="$pageData['ViewType']"/>
    @if($viewEditor)
        <x-admin.form.ckeditor-jave height="350"/>
    @endif
    <script>
        $(document).ready(function() {
            $("#tag_id").select2({
                ajax: {
                    url: "{{route('Blog.BlogPost.TagsSearch')}}",
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            search: params.term,
                            type: 'TagsSearch',
                        }
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                },
                cache: false,
                placeholder: 'Search for a user...',
                tags: true,
                tokenSeparators: [','],
                minimumInputLength: 2,
                createTag: function (params) {
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true
                    }
                },
            });
        }).on('select2:select', function (e) {
            var data = e.params.data;
            if(data.newTag === true){
                $.ajax({
                    url:"{{route('Blog.BlogPost.TagsOnFly')}}",
                    method:"get",
                    data:{newTagData:data},
                    success:function(response) {
                        if (response.addDone === true){
                            $("#tag_id").find('[value="'+e.params.data.id+'"]').replaceWith('<option selected value="'+response.id+'">'+e.params.data.text+'</option>');
                        }
                    }
                });
            }
        });
    </script>

@endpush
