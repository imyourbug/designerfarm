@extends('layout.main')
@push('styles')
<title>TẢI FILE FREEPIK GIÁ RẺ</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="/css/style.css" rel="stylesheet" type="text/css">
<link href="/css/sb-admin-2.min.css" rel="stylesheet">
<link href="/css/package/index.css" rel="stylesheet">
@endpush
@push('scripts')
<script>
  $(document).ready(function() {
    var intervalGetUrl = null;
    // default
    $('#Freepik').click();
    //
    $('#getlink_btn').click(function() {

    });
  });
</script>
@endpush
@section('content')
<div class="container" style="margin-top: 100px;">
  <div class="h-pricing-table__info h-grid" style="text-align: center;"><!--[-->
    <h2>Chọn gói hoàn hảo cho bạn</h2>
    <p class="h-pricing-table__description">Get started in complete confidence. Our 30-day money-back guarantee means it's risk-free.</p><!--]--><!---->
  </div>
  <div class="row">
    @foreach ($packages as $package)

    @endforeach
    <div class="col-lg-4 col-md-6 col-sm-6">
      <div class="item-box-blog">
        <div class="item-box-blog-image">
          <!--Date-->
          <div class="item-box-blog-date bg-blue-ui white"> <span class="mon">Augu 01</span> </div>
          <!--Image-->
          <figure> <img alt="" src="https://cdn.pixabay.com/photo/2017/02/08/14/25/computer-2048983_960_720.jpg"> </figure>
        </div>
        <div class="item-box-blog-body">
          <!--Heading-->
          <div class="item-box-blog-heading">
            <a href="#" tabindex="0">
              <h5>News Title</h5>
            </a>
          </div>
          <!--Data-->
          <div class="item-box-blog-data" style="padding: px 15px;">
            <p><i class="fa fa-user-o"></i> Admin, <i class="fa fa-comments-o"></i> Comments(3)</p>
          </div>
          <!--Text-->
          <div class="item-box-blog-text">
            <p>Lorem ipsum dolor sit amet, adipiscing. Lorem ipsum dolor sit amet, consectetuer adipiscing. Lorem ipsum dolor sit amet, adipiscing. Lorem ipsum dolor sit amet, adipiscing. Lorem ipsum dolor sit amet, consectetuer adipiscing. Lorem ipsum dolor.</p>
          </div>
          <div class="mt"> <a href="#" tabindex="0" class="btn bg-blue-ui white read">read more</a> </div>
          <!--Read More Button-->
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
