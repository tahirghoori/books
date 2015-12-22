<?php

    if(isset($book)){
    $title= $book->title;
    $author= $book->author;
    $method= "put";
    $action= "update";
    }
    else{
    $title="";
    $author="";
    $method="post";
    $action= "add";
    }



?>
<h3>Add/Update records </h3>
<form action="{{$action}}" method="POST" id="entry">

    <div class="form-group">
        <label>Title</label>

        <input type="text" name="title" class='form-control' value="{{$title}}"><br/>
    </div>

    <div class="form-group">
        <label>Author</label>
        <input type="text" name="author" class='form-control' value="{{$author}}"/>
    </div>

    <input type="hidden" name="_method" value="{{$method}}"/>
    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
    <input type="submit" value="Submit" class='btn btn-primary'/>


</form>