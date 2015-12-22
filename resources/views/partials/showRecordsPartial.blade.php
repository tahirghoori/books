<table class="table table-striped table-bordered" style="margin-top:20px;width:900px;" id="records">
    <thead>
    <tr>
        <td>ID</td>
        <td style="width:30%">Title
            @if(Request::segment(1)!="search")
            <a href="?sortBy=title&order=asc"><span class="glyphicon glyphicon-arrow-up"></span></a>
            <a href="?sortBy=title&order=desc"><span class="glyphicon glyphicon-arrow-down"></span></a>
            @endif
        </td>
        <td>Author
            @if(Request::segment(1)!="search")
            <a href="?sortBy=author&order=asc"><span class="glyphicon glyphicon-arrow-up"></span></a>
            <a href="?sortBy=author&order=desc"><span class="glyphicon glyphicon-arrow-down"></span></a>
            @endif
        </td>
        <td>Show/Edit/Delete</td>
    </tr>
    </thead>
    <tbody>
    @foreach($books as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->title }}</td>
            <td>{{ $value->author }}</td>
            <td>
                <a class="btn btn-small btn-success" href="{{ URL::to('books/' . $value->id) }}">Show</a>
                <a class="btn btn-small btn-info" href="{{ URL::to('books/' . $value->id . '/edit') }}">Edit</a>
                <form action="{{ URL::to('books/' . $value->id. '/delete') }}" method="POST" style="display:inline;" >
                    <input type="hidden" name="_method" value="DELETE"/>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <input type="submit" value="Delete" class="btn btn-small btn-success" id="book{{$value->id}}"/>

                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>