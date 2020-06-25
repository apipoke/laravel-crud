@extends('layouts.app', ['title' => 'New Post'])

{{-- @section('head')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection --}}

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
            New Post
        </div>
        <div class="card-body">
          <form class="" action="/posts/store" method="post" enctype="multipart/form-data">
            @csrf
              @include('posts/partials/form-control', ['submit' => 'Create'])
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection

{{-- @section('script')
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('.select2').select2({
        placeholder : "Chose some tags"
      });
    });
  </script>
@endsection --}}
