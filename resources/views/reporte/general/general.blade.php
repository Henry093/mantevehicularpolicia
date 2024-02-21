@extends('tablar::page')
@section('title')
    @lang('Dashboard')
@endsection
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title text-center">
                        Policía Nacional del Ecuador Sub Zona 7 Loja
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
          <div class="row row-cards">
            <div class="col-sm-6 col-lg-3">
              <div class="card card-md">
                  <div class="card-body text-center">
                      <div class="text-uppercase text-secondary font-weight-medium">Dependencias</div>
                      <div class="display-5 fw-bold my-3">{{ $totalDependencias }}</div>
                      <ul class="list-unstyled lh-lg">
                          <li><strong>{{ $totalDependencias }}</strong> Dependencia(s)</li>
                      </ul>
                      <div class="text-center mt-4">
                          <a href="/dependencias" class="btn w-100">Dependencias</a>
                      </div>
                  </div>
              </div>
          </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card card-md">
                <div class="card-body text-center">
                  <div class="text-uppercase text-secondary font-weight-medium">Personas</div>
                  <div class="display-5 fw-bold my-3">{{ $totalUsuarios }}</div>
                  <ul class="list-unstyled lh-lg">
                    <li><strong>{{ $totalUsuarios }}</strong> Persona(s)</li>
                  </ul>
                  <div class="text-center mt-4">
                    <a href="/users" class="btn w-100">Personas</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card card-md">
                <div class="card-body text-center" green>
                  <div class="text-uppercase text-secondary font-weight-medium">Vehículos</div>
                  <div class="display-5 fw-bold my-3">{{ $totalVehiculos }}</div>
                  <ul class="list-unstyled lh-lg">
                    <li><strong>{{ $totalVehiculos }}</strong> Vehículo(s)</li>
                  </ul>
                  <div class="text-center mt-4">
                    <a href="/vehiculos" class="btn w-100">Vehiculos</a>
                  </div>
                </div>
              </div>
            </div> 
            <div class="col-sm-6 col-lg-3">
              <div class="card card-md">
                <div class="card-body text-center">
                  <div class="text-uppercase text-secondary font-weight-medium">Mantenimientos</div>
                  <div class="display-5 fw-bold my-3">{{ $totalMantenimientos }}</div>
                  <ul class="list-unstyled lh-lg">
                    <li><strong>{{ $totalMantenimientos }}</strong> Mantenimiento(s)</li>
                  </ul>
                  <div class="text-center mt-4">
                    <a href="/rmantenimientos" class="btn w-100">Mantenimientos</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card card-md">
                <div class="card-body text-center">
                  <div class="text-uppercase text-secondary font-weight-medium">Recepción Vehículo</div>
                  <div class="display-5 fw-bold my-3">{{ $totalRecepciones }}</div>
                  <ul class="list-unstyled lh-lg">
                    <li><strong>{{ $totalRecepciones }}</strong> Recepción Vehículo(s)</li>
                  </ul>
                  <div class="text-center mt-4">
                    <a href="/vehirecepciones" class="btn w-100">Recepción Vehículo</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card card-md">
                <div class="card-body text-center">
                  <div class="text-uppercase text-secondary font-weight-medium">Entrega Vehículo</div>
                  <div class="display-5 fw-bold my-3">{{ $totalEntregas }}</div>
                  <ul class="list-unstyled lh-lg">
                    <li><strong>{{ $totalEntregas }}</strong> Entrega Vehículo(s)</li>
                  </ul>
                  <div class="text-center mt-4">
                    <a href="/registrarmantenimientos" class="btn w-100">Entrega Vehículo</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card card-md">
                <div class="card-body text-center">
                  <div class="text-uppercase text-secondary font-weight-medium">Reclamos</div>
                  <div class="display-5 fw-bold my-3">{{ $totalReclamos }}</div>
                  <ul class="list-unstyled lh-lg">
                    <li><strong>{{ $totalReclamos }}</strong> Reclamo(s)</li>
                  </ul>
                  <div class="text-center mt-4">
                    <a href="/registrarmantenimientos" class="btn w-100">Reclamos</a>
                  </div>
                </div>
              </div>
            </div> 
          </div>
        </div>
      </div>
@endsection
