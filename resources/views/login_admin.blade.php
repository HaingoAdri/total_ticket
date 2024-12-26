<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ticketing - Connexion</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/Image 1.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css')  }}" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" style="background-color: rgb(254, 102, 102);" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{ asset('assets/images/logos/Image1.png ') }}" width="180" alt="">
                </a>
                <p class="text-center">Engagé pour une énergie meilleur</p>
                <form action="{{route('connexion')}}" method="post">
					@csrf
					@if(session('success'))
						<div class="alert alert-success" role="alert">
						{{ session('success') }}
						</div>
					@endif
					@if(session('error'))
						<div class="alert alert-danger" role="alert">
						{{ session('error') }}
						</div>	
					@endif
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label">Identifiant employés (Matricule) ou email</label>
						<input type="email" class="form-control" name="email" aria-describedby="emailHelp">
					</div>
					<div class="mb-4">
						<label for="exampleInputPassword1" class="form-label">Mot de passe</label>
						<input type="password" class="form-control" name="pass" id="exampleInputPassword1">
					</div>
					<div class="d-flex align-items-center justify-content-between mb-4">
						<div class="form-check">
						<input class="form-check-input danger" type="checkbox" value="" id="flexCheckChecked" checked>
						<label class="form-check-label text-dark" for="flexCheckChecked">
							Garder session ?
						</label>
						</div>
						<a class="text-danger fw-bold" href="{{route('lost_pass')}}">Mots de passe oublier ?</a>
					</div>
					<input type="submit" class="btn btn-danger w-100 py-8 fs-4 mb-4 rounded-2" value="Se connecter">
					<div class="d-flex align-items-center justify-content-center">
						<p class="fs-4 mb-0 fw-bold">Nouvelle recrue?</p>
						<a class="text-danger fw-bold ms-2" href="{{route('register')}}">Création de compte</a>
					</div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>