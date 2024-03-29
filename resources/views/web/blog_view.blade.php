@extends('web.layouts.app')
@section('content')
    <div class="area_padding">
        <div class="container">
            <div class="row">

                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 BlogView">
                            <h1 class="">{{$blog->name}}</h1>
                            <div class="blog_info">
                                <div class="printDate">
                                    <span class="user_id">{{__('web/def.user_name')}} : <span class="info"><a href="#">{{$blog->userName->name}}</a> </span> | </span>
                                    <span class="Blogviewdate">{{__('web/def.published_at')}} : <span class="info">{{$blog->getHomeFormatteDate()}}</span> | </span>
                                    <span class="user_id">{{__('web/def.user_review')}} : <span class="info"><a href="#">{{$blog->userName->name}}</a> </span> | </span>
                                    <span class="user_id">{{__('web/def.last_update')}} : <span class="info">{{$blog->getUpdateFormatteDate()}}</span> </span>
                                </div>

                                @if(!empty($contents))
                                    <div class="table_of_contents">
                                        @include('web.blog_table_of_contents', $contents)
                                    </div>
                                @endif

                                <div class="blog_des_view">
                                    {!! nl2br($blogBody) !!}
                                </div>

                                <div class="tag_div">
                                    <div class="title">{{__('web/def.tags')}}</div>
                                    @foreach($blog->tags as $tag)
                                        <a href="{{route('TagView',$tag->slug)}}" class="tag_name">#{{$tag->name}}</a>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="page-head-blog">

                        <div class="single-blog-page">
                            <div class="left-blog">
                                <h4>الاقسام</h4>
                                <ul class="blog_view_cat_list">
                                    @foreach($categories as $category)
                                        <li><a href="{{route('CategoryView',$category->slug)}}">{{$category->name}}
                                                ({{$category->count}})</a></li>
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
                                                    <x-site.def.img :row="$blog" def="blog" class="blog_img rounded-4"
                                                                    w="400" h="240"/>
                                                </a>
                                            </div>
                                            <div class="pst-content">
                                                <p>
                                                    <a href="{{route('blog_view',[$blog->slug,'.html'])}}"> {{$blog->name}}</a>
                                                </p>
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
