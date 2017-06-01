<section class="banner">
  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
    @foreach ($sliders as $key => $slider)
      <li data-target="#carousel-example-generic" data-slide-to="{{$key}}" class="@if($key == '0'){{'active'}}@endif"></li>
    @endforeach
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      @foreach ($sliders as $key => $slider)
      <div class="item bg-wrap @if($key == '0'){{'active'}}@endif" style="background-image:url('{{ asset($slider->path) }}');">
      <div class="container">
        <div class="lg-caption">
          <h1>{{$slider->caption}}</h1>
          @if($slider->link)
            @if((!empty($slider->caption)) && strpos(strtolower($slider->caption), 'valentine') !== false )
           <!-- <a class="btn btn-default" data-toggle="modal" data-target="#valentine-promo">GET CODE</a> -->
           <a class="btn btn-default" href="{{url('package/valentines-package')}}">VIEW PACKAGE</a>
            @else
            <a class="btn btn-default" href="{{url().'/'.$slider->link}}">READ MORE</a>
            @endif
          @endif
        </div>
      </div>
      </div>
      @endforeach
    </div>
  </div>
</section>