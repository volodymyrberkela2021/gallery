<!DOCTYPE html>
<html>
<head>
    <title>Image Gallery Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/custom.css') }}"/>
</head>
<body>
<div class="container">
    <h3>Image Gallery</h3>
    <form action="{{ url('image-gallery') }}" class="form-image-upload" method="POST" enctype="multipart/form-data">
        {!! csrf_field() !!}
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        <div class="row">
            <div class="col-md-5">
                <strong>Title:</strong>
                <input type="text" name="title" class="form-control" placeholder="Title">
            </div>
            <div class="col-md-5">
                <strong>Tags:</strong>
                <input type="text" name="tags" class="form-control" placeholder="Tags(please fill it space separated)">
            </div>
            <div class="col-md-5">
                <strong>Image:</strong>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="col-md-2">
                <br/>
                <button type="submit" class="btn btn-success">Upload</button>
            </div>
        </div>


    </form>

    <div class="row">
        <div id="myBtnContainer">
            <button class="btn active" onclick="filterSelection('all')">Show all</button>
                @foreach($tags as $tag)
                    <button class="btn" id="{{ $tag }}" onclick="filterSelection('{{ $tag }}')"> {{ $tag }}</button>
                @endforeach
        </div>
        <div class='list-group gallery'>
            @if($images->count())
                @foreach($images as $image)
                        <div class="column {{ $image->tags }}">
                            <div class="content">
                                <img class="img-responsive" alt="Car" src="/images/{{ $image->image }}" />
                                <h4>{{ $image->title }}</h4>
                                <p>Tags: {{ $image->tags }}</p>
                            </div>
                        </div>
                @endforeach
            @endif
        </div>
        {{ $images->links() }}
    </div>
</div>


</body>


<script type="text/javascript">
    function filterSelection(c) {
        var x, i;
        x = document.getElementsByClassName("column");
        if (c == "all") {
            c = "";
            window.location.href="/image-gallery";
        } else {
            window.location.href="/image-gallery/"+ c +"";
        }
    };

    $(document).ready(function() {
        var parts = window.location.href.split('/');
        var lastSegment = parts.pop() || parts.pop();
        $("button#"+lastSegment+"").addClass(" active");
    });
</script>
</html>