@extends('web.layouts.app')
@section('content')

    <div id="blog" class="blog-area">
        <div class="blog-inner area-padding">
            <div class="blog-overly"></div>


                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="section-headline text-center">
                                <h2>الاقسام</h2>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        @foreach($categories as $category)
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="single-blog">
                                    <a href="{{route('CategoryView',$category->slug)}}">
                                        <div class="category_img">
                                            <x-site.def.img :row="$category" def="blog" class="blog_img rounded-4" w="400" h="240" />
                                        </div>
                                    </a>

                                    <div class="category_text text-center">
                                        <h3><a href="{{route('CategoryView',$category->slug)}}" class="crop_line_1">{{$category->name}} ({{$category->count}})</a></h3>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            <x-site.def.pagination :rows="$categories"/>

        </div>
    </div>

@endsection
