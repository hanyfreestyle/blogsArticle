@extends('web.layouts.app')
@section('content')

    <div class="blog-page area-padding mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <article class="blog-post-wrapper">
                                <h1 class="blogview_h1 mb-3">{{$blog->name}}</h1>
                                <div class="post_thumbnail">
                                    <x-site.def.img :row="$blog" def="blog" class="blog_img rounded-4" w="400" h="240" />
                                </div>
                                <div class="post-information blog_info">

{{--                                    <div class="entry-meta">--}}
{{--                                        <span class="Blogviewdate"><i class="bi bi-clock"></i>{{$blog->getHomeFormatteDate()}}</span>--}}
{{--                                    </div>--}}
                                    <div class="entry-content blog_des_view">
                                        {!! $blog->des !!}
                                    </div>
                                    <div class="tag_div">
                                        @foreach($blog->tags as $tag)
                                             <a href="{{route('TagView',$tag->slug)}}" class="tag_name">#{{$tag->name}}</a>
                                        @endforeach
                                    </div>

                                </div>
                            </article>
                            <div class="clear"></div>


                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="page-head-blog">

{{--                        <div class="single-blog-page">--}}
{{--                            <form action="#">--}}
{{--                                <div class="search-option">--}}
{{--                                    <input type="text" placeholder="Search...">--}}
{{--                                    <button class="button" type="submit">--}}
{{--                                        <i class="bi bi-search"></i>--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}

                        <div class="single-blog-page">
                            <div class="left-blog">
                                <h4>الاقسام</h4>
                                <ul class="blog_view_cat_list">
                                    @foreach($categories as $category)
                                        <li><a href="{{route('CategoryView',$category->slug)}}">{{$category->name}} ({{$category->count}})</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>


                        <div class="single-blog-page">

                            <div class="left-blog">
                                <h4>مقالات ذات صلة</h4>
                                <div class="recent-post">
                                    @foreach($ReletedBlog as $blog)
                                        <div class="recent-single-post">
                                            <div class="post-img">
                                                <a href="{{route('blog_view',[$blog->slug,'.html'])}}">
                                                    <x-site.def.img :row="$blog" def="blog" class="blog_img rounded-4" w="400" h="240" />
                                                </a>
                                            </div>
                                            <div class="pst-content">
                                                <p><a href="{{route('blog_view',[$blog->slug,'.html'])}}"> {{$blog->name}}</a></p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>


                        <div class="single-blog-page">
                            <div class="left-tags blog-tags">
                                <div class="popular-tag left-side-tags left-blog">
                                    <h4>popular tags</h4>
                                    <ul>
                                        @foreach($popularTags as $tag)
                                            <li><a href="{{route('TagView',$tag->slug)}}">{{$tag->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>

@endsection
