@extends('admin.layouts.app')
@section('content')
    <x-admin.hmtl.breadcrumb :pageData="$pageData"/>

    <x-admin.hmtl.top-edit-page :page-data="$pageData" :row="$rowData" view-web="{{$pageData['WebUrl']}}"  />

       <form class="mainForm " action="{{route($PrefixRoute.'.update',intval($rowData->id))}}" method="post" enctype="multipart/form-data">
           @csrf
           <input type="hidden" name="form_type" value="{{$pageData['ViewType']}}">
           <div class="row">
               <div class="col-lg-12">
                   @if($errors->has([]))
                       <div class="alert alert-danger alert-dismissible">
                           {{__('admin/alertMass.form_has_error')}}
                       </div>
                   @endif
               </div>

               <div class="col-lg-8">
                   <x-admin.card.normal>
                       <div class="row">
                           <input type="hidden" name="add_lang" value="{{json_encode($LangAdd)}}">
                           @foreach ( $LangAdd as $key=>$lang )
                               <x-admin.lang.meta-tage-filde :row="$rowData" :key="$key" :viewtype="$pageData['ViewType']" :label-view="$viewLabel"
                                                             :def-name="__('admin/blogPost.blog_text_name')" />
                           @endforeach
                       </div>

                       <div class="row">
                           <x-admin.form.select-multiple name="tag_id" :categories="$tags" :sel-cat="$selTags" col="12" :label="__('admin/blogPost.cat_text_tag')" />
                       </div>
                       <div class="row mt-5 mb-5"></div>
                   </x-admin.card.normal>
               </div>

               <div class="col-lg-4">
                   <x-admin.card.normal>
                       <div class="row">
                           <x-admin.form.select-multiple name="categories" :categories="$Categories" :sel-cat="$selCat" col="12" />
                           <x-admin.form.date-form name="published_at" value="{{old('published_at',$rowData->published_at)}}" :col="12" />
                           <x-admin.form.select-arr  name="is_active" select-type="selActiveBlog" :sendvalue="old('is_active',$selActive)" :label="__('admin/blogPost.blog_is_active')" col="12" />
                       </div>
                   </x-admin.card.normal>

                   @if($pageData['ViewType'] == 'Edit')
                       <x-admin.blog.review-table :row="$rowData"/>
                   @endif

                   <x-admin.card.normal>
                       <div class="row">
                           <x-admin.form.upload-model-photo :page="$pageData" :row="$rowData" :labelview="false" :remove="false" col="12"/>
                       </div>
                   </x-admin.card.normal>

               </div>
           </div>
           <x-admin.form.submit-role-back :page-data="$pageData"/>
           <div class="row mt-5 mb-5"></div>
       </form>
@endsection


@push('JsCode')
    <x-admin.java.update-slug :view-type="$pageData['ViewType']" :en="false"/>
    @if($viewEditor)
        <x-admin.form.ckeditor-jave height="350" :enlang="false"/>
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
