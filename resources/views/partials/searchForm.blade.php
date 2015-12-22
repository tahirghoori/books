<form action="search" method="GET" id="entry">

    <div class="form-group">
        <label>Search String</label>

        <input type="text" name="searchQuery" class='form-control' /><br/>
    </div>

    <div class="form-group">
        <label>Type</label>
        <select name="criteria">
            <option value="title">Title</option>
            <option value="author">Author</option>
        </select>

    </div>

    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
    <input type="submit" value="Search" class='btn btn-primary'/>


</form>