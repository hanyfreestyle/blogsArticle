<x-admin.card.normal>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th> {{$row->userName->name}}</th>
            <th> {{$row->created_at}}</th>
        </tr>
        <tr>
            <th colspan="2">{{__('admin/blogPost.blog_review')}}</th>
        </tr>
        </thead>
        @foreach($row->reviews->take(5) as $review)
            <tr>
                <td>{{$review->userName->name}}</td>
                <td>{{$review->updated_at }}</td>
            </tr>
        @endforeach
    </table>
    @if(count($row->reviews) > 5)
{{--        ddd--}}
    @endif
</x-admin.card.normal>
