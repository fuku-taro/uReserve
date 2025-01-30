<!doctype html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InterventionImage demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    <div class="container py-4">
      <div class="row">
        <div class="col-xl-6 m-auto">

          @if (Session::has('success'))
              <div class="alert alert-success">
                {{ Session::get('success') }}
              </div>

          @elseif(Session::has('error'))
              <div class="alert alert-danger">
                {{ Session::get('error') }}
              </div>
          @endif

          <form action="{{ route('image.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Image Intervention in Laravel</h4>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="image">画像</label><br>
                  <input type="file" name="image" id="image">
                  <x-input-error for="image" class="mt-2 text-danger" />
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">アップロード</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
