<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>Video View - Focus Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://getbootstrap.com/docs/5.0/examples/pricing/pricing.css" crossorigin="anonymous">
  </head>
  <body>
    
<header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
  <p class="h5 my-0 me-md-auto fw-normal">Focus Academy</p>
  <nav class="my-2 my-md-0 me-md-3">
    <a class="p-2 text-dark" href="/videos/">Videos</a>
  </nav>
</header>

<main class="container">
  <div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">Video View</h1>
    <p class="lead">This is a video view page</p>
  </div>
    @if ($video)
      <h2>{{ $video->title }}</h2>
      <hr />
      <video width="720" height="360" controls id="video-url">   
      <source src="{{URL::asset('uploads/'.$video->video)}}" id="video-mp4" type="video/mp4">   
      <source src="{{URL::asset('uploads/'.$video->video)}}" id="video-ogg" type="video/ogg">   
      Your browser does not support the video tag. 
      </video>

      <hr />
      <p>Select quality</p>
      <div>
        <button class="btn btn-primary" onclick="changeVideo('1080p');" type="submit">1080p</button>
        <button class="btn btn-primary" onclick="changeVideo('720p');" type="submit">720p</button>
        <button class="btn btn-primary" onclick="changeVideo('360p');" type="submit">360p</button>
      </div>
      <hr />
    @else
      <tr>Video not Found.</tr>
    @endif
                    
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

function changeVideo($type){
  var img_src = $('#video-mp4').attr('src');
  var img_ogg = $('#video-ogg').attr('src');
  
  var res = img_src.split(".");
  res[res.length-2] = $type;
  var image_mp4 = res.join(".");

  res = img_ogg.split(".");
  res[res.length-2] = $type;
  var image_ogg = res.join(".");
  
  if(img_src != image_mp4){
    $('#video-mp4').attr("src", image_mp4);
  }
  if(img_ogg != image_ogg){
    $('#video-ogg').attr("src", image_ogg);
  }
}
</script>

    
  </body>
</html>