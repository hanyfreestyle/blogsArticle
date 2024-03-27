@extends('web.layouts.app')
@section('content')

    <div id="blog" class="blog-area">
        <div class="blog-inner area-padding">
            <div class="blog-overly"></div>

            @foreach($categories as $category)
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="section-headline text-center">
                                <h2>{{$category->name}}</h2>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        @foreach($category->homeBlog as $blog)
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="single-blog">
                                    <a href="#">
                                        <div class="single_blog_img">
                                            <x-site.def.img :row="$blog" def="blog" class="blog_img rounded-4" w="400" h="240" />
                                        </div>
                                    </a>
                                    <div class="blog-meta">
                                        <div class="date-type">
                                            <i class="fa fa-calendar"></i>{{$blog->getHomeFormatteDate()}}
                                        </div>
                                    </div>
                                    <div class="blog-text">
                                        <h3><a href="blog.html" class="crop_line_1"  >{{$blog->name}}</a></h3>
                                        <p>{{PrintShortDes($blog,'200')}}</p>
                                    </div>
                                    <div class="text-left">
                                        <a href="{{route('blog_view',$blog->slug)}}" class="ready-btn">{{__('web/def.units_read_more')}}</a>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>


@endsection
