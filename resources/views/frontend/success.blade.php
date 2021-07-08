<!DOCTYPE html>
<html lang="en">

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
  <title>Pendaftaran Berhasil</title>
</head>

<body>
  <section>
    <div class="container-fluid">
      <div class="content d-flex flex-column justify-content-center align-items-center">
        <img src="{{ asset('media/main/bg-hospital.png') }}" alt="Hospital">
        <div class="title text-center">Terima kasih telah mendaftar</div>
        <div class="text">Pastikan cek email dan nomor handphone aktif untuk informasi lebih lanjut</div>
      </div>
    </div>
  </section>
</body>

</html>
<style>
  body {
    color: #f1faee;
  }

  img {
    height: 15rem;
    width: 20rem;
  }

  .content {
    font-family: 'Helvetica Neue';
    font-size: 30px;
    height: 100vh;
  }

  .title {
    font-weight: bold;
    color: #1d3557;
  }

  .text {
    margin-top: 15px;
    font-size: 25px;
    color: #e63946;
    text-align: center;
    font-family: 'Helvetica Neue';
  }
</style>
