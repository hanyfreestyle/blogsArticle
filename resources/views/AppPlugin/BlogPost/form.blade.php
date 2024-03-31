@extends('admin.layouts.app')
@section('StyleFile')
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height:500px;
            direction: rtl;
            text-align: right;
        }
        .ck-content .image {
            /* Block images */
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

{{--<script src="{{defAdminAssets('ckeditor5/ckeditor.js')}}"></script>--}}
{{--<script>--}}
{{--    ClassicEditor--}}
{{--        .create( document.querySelector( '#editor' ), {--}}
{{--            language: 'ar',--}}
{{--            ckfinder:{--}}
{{--                uploadUrl:"{{route('Blog.BlogPost.CkeditorUpload',['_token'=>csrf_token()])}}",--}}

{{--            },--}}
{{--            toolbar: {--}}
{{--                items: [--}}
{{--                    'exportPDF','exportWord', '|',--}}
{{--                    'findAndReplace', 'selectAll', '|',--}}
{{--                    'heading', '|',--}}
{{--                    'bold', 'italic', 'strikethrough', 'underline','removeFormat', '|',--}}
{{--                    'bulletedList', 'numberedList', 'todoList', '|',--}}
{{--                    'outdent', 'indent', '|',--}}
{{--                    'undo', 'redo',--}}
{{--                    '-',--}}
{{--                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',--}}
{{--                    'alignment', '|',--}}
{{--                    'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',--}}
{{--                    'specialCharacters', 'horizontalLine', 'pageBreak', '|',--}}

{{--                    'sourceEditing'--}}
{{--                ],--}}
{{--                shouldNotGroupWhenFull: true--}}
{{--            },--}}

{{--        } )--}}
{{--        .catch( error => {--}}
{{--            console.log( error );--}}
{{--        } );--}}
{{--</script>--}}

<script src="{{defAdminAssets('ckeditor5/super_ckeditor.js')}}"></script>

<script>
    // This sample still does not showcase all CKEditor&nbsp;5 features (!)
    // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
    CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
        ckfinder:{
            uploadUrl:"{{route('Blog.BlogPost.CkeditorUpload',['_token'=>csrf_token()])}}",

        },

        // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
        toolbar: {
            items: [
                'exportPDF','exportWord', '|',
                'findAndReplace', 'selectAll', '|',
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline','removeFormat', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'outdent', 'indent', '|',
                'undo', 'redo',
                '-',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                'alignment', '|',
                'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                'specialCharacters', 'horizontalLine', 'pageBreak', '|',

                'sourceEditing'
            ],
            shouldNotGroupWhenFull: true
        },

        language: 'ar',
        list: {
            properties: {
                styles: true,
                startIndex: true,
                reversed: true
            }
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
            ]
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
        placeholder: 'Welcome to CKEditor 5!',
        // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif'
            ],
            supportAllValues: true
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
        fontSize: {
            options: [ 10, 12, 14, 'default', 18, 20, 22 ],
            supportAllValues: true
        },
        // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
        // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
        htmlSupport: {
            allow: [
                {
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }
            ]
        },
        // Be careful with enabling previews
        // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
        htmlEmbed: {
            showPreviews: true
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
        link: {
            decorators: {
                addTargetToExternalLinks: true,
                defaultProtocol: 'https://',
                toggleDownloadable: {
                    mode: 'manual',
                    label: 'Downloadable',
                    attributes: {
                        download: 'file'
                    }
                }
            }
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
        mention: {
            feeds: [
                {
                    marker: '@',
                    feed: [
                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                        '@sugar', '@sweet', '@topping', '@wafer'
                    ],
                    minimumCharacters: 1
                }
            ]
        },
        // The "superbuild" contains more premium features that require additional configuration, disable them below.
        // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
        removePlugins: [
            // These two are commercial, but you can try them out without registering to a trial.
            // 'ExportPdf',
            // 'ExportWord',
            'AIAssistant',
            'CKBox',
            'CKFinder',
            'EasyImage',
            // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
            // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
            // Storing images as Base64 is usually a very bad idea.
            // Replace it on production website with other solutions:
            // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
            // 'Base64UploadAdapter',
            'RealTimeCollaborativeComments',
            'RealTimeCollaborativeTrackChanges',
            'RealTimeCollaborativeRevisionHistory',
            'PresenceList',
            'Comments',
            'TrackChanges',
            'TrackChangesData',
            'RevisionHistory',
            'Pagination',
            'WProofreader',
            // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
            // from a local file system (file://) - load this site via HTTP server if you enable MathType.
            'MathType',
            // The following features are part of the Productivity Pack and require additional license.
            'SlashCommand',
            'Template',
            'DocumentOutline',
            'FormatPainter',
            'TableOfContents',
            'PasteFromOfficeEnhanced',
            'CaseChange'
        ]
    });
</script>


{{--    <x-admin.table.sweet-delete-js/>--}}
{{--    <link rel="stylesheet" href="{{ defAdminAssets('jqueryui/jquery-ui.min.css') }}">--}}
{{--    <script src="{{defAdminAssets('jqueryui/jquery-ui.min.js')}}"></script>--}}
    <x-admin.java.update-slug :view-type="$pageData['ViewType']"/>

    @if($viewEditor)
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
