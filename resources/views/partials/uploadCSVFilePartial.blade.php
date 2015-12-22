Please only upload a csv file. The file must not have blank rows. On excel use 2 columns,
<br/> the left column should contain book's title and the right its' author.
<br/> Please take a look at this <a href="downloads/sample.csv">Sample File </a>
<br/>

<form method="post" action="bulkUpload" enctype="multipart/form-data">
    <input type="file" name="csvFileName" style="display:inline;"/>
    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
    <input type="submit" value="Upload" class="btn btn-primary" style="display:inline;"/>
</form>