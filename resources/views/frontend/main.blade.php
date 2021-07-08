<!DOCTYPE html>
<html lang="en">
<style>
  body {
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.733) 100%, transparent),
      url('media/main/main-bg.jpg');
    background-size: cover;
    background-position: center;
  }

  #main {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .form-card {
    background: #fff;
    padding: 1.5rem 1.5rem 1.5rem 1.5rem;
    margin: 1.5rem 1.5rem 1.5rem 1.5rem;
  }

  h4 {
    font-family: sans-serif;
    font-size: 2rem;
    display: inline-block;
    padding: 1rem;
    font-weight: 400;
    text-align: center position: relative;
    opacity: 1;
    transform: scale(1);
    transition: transform 0.5s ease, opacity 1s ease;
  }

  .is-loading h4 {
    transform: scale(0.9);
    opacity: 0;
  }

  h4:before,
  h4:after {
    height: 2px;
    width: 100%;
    content: "";
    background: #e0e0e0;
    display: block;
    position: absolute;
    transition: width 0.4s ease;
    transition-delay: 0.8s;
  }

  h4:before {
    top: 0;
    left: 0;
  }

  h4:after {
    bottom: 0;
    right: 0;
  }

  .is-loading h4:before,
  .is-loading h4:after {
    width: 0;
  }
</style>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
  </script>
  <title>Apply Job</title>
</head>

<body>
  <section id="main" class="is-loading">
    <div class="container">
      <div class="py-0">
        <div class="form-card rounded-lg">
          <h4 class="d-block text-center">Pendaftaran Rekrutmen 2021</h4>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Pilih formasi</label>
            <select class="form-control" id="exampleFormControlSelect1" name="id">
              <option value="">Pilih Formasi</option>
              @foreach (($data ?? array()) as $item)
              <option value="{{ $item['id_formation'] }}">{{ $item['name'] }}</option>
              @endforeach
            </select>
          </div>
          <div id="klasifikasi" class="form-group" style="display: none">
            <div class="alert alert-success" role="alert">
              <h5 class="alert-heading text-center">Kualifikasi & Syarat</h5>
              <hr>
              <pre></pre>
              <hr>
            </div>
          </div>
          <a id="redirect" href="#" class="btn btn-block btn-success">Submit</a>
        </div>
      </div>
    </div>
  </section>
</body>
<script>
  $(document).ready(function() {
    setTimeout(function() {
    $("#main").removeClass("is-loading");
    }, 100)

    $('select[name="id"]').on("change", function () {
        $('#redirect').attr('href', '/registration/'+$(this).val())
        $.ajax({
            url: '/'+$(this).val(),
            type: 'GET',
            success: function (response){
                $('#klasifikasi').removeAttr("style");
                $('#klasifikasi pre').empty();
                $('#klasifikasi pre').append(response.description);
            }
        });
    });
  });
</script>

</html>
