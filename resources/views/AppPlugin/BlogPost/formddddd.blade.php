@extends('admin.layouts.app')
@section('StyleFile')
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height:500px;
        }
        .ck-content .image {
            max-width: 80%;
            margin: 20px auto;
        }
    </style>

@endsection
@section('content')
    <x-admin.hmtl.breadcrumb :pageData="$pageData"/>

    <x-admin.hmtl.top-edit-page :page-data="$pageData" :row="$rowData"  />


       <form class="mainForm " action="{{route($PrefixRoute.'.update',intval($rowData->id))}}" method="post" enctype="multipart/form-data">
           @csrf
           <input type="hidden" name="form_type" value="{{$pageData['ViewType']}}">
           <div class="row">


               <div class="col-lg-12">
                   <x-admin.card.normal>

                <textarea id="editor" name="w3review" rows="4" cols="50">
                At w3schools.com you will learn how to make a website. They offer free tutorials in all web development technologies.
                </textarea>




                   </x-admin.card.normal>
               </div>


           </div>
           <x-admin.form.submit-role-back :page-data="$pageData"/>
           <div class="row mt-5 mb-5"></div>
       </form>



@endsection


@push('JsCode')



    <x-admin.java.update-slug :view-type="$pageData['ViewType']"/>

    @if($viewEditor)
        <script src="{{defAdminAssets('ckeditor5/super_ckeditor.js')}}"></script>
        <x-admin.form.ckeditor5/>
{{--        <x-admin.form.ckeditor-jave height="350" :enlang="false"/>--}}
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
