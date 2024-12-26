@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid" style="width:100%">
        
                    @if (session('status'))
                        {{-- <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div> --}}
                   @else

                   <div class="pagetitle">
                    <h1>{{trans('lang.dashboard')}}</h1>
                    <nav>
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">{{trans('lang.home')}}</a></li>
                        <li class="breadcrumb-item active">{{trans('lang.dashboard')}}</li>
                      </ol>
                    </nav>
                  </div>
              
                  <section class="section dashboard">
                    <div class="row">
              
                      <!-- Left side columns -->
                      <div class="col-lg-12">
                        <div class="row">
              
                          <!-- Sales Card -->
                          <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
              
                              <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                  <li class="dropdown-header text-start">
                                    <h6>{{trans('lang.filters')}}</h6>
                                  </li>
              
                                  <li><a class="dropdown-item" href="#">{{trans('lang.today')}}</a></li>
                                  <li><a class="dropdown-item" href="#">{{trans('lang.this_month')}}</a></li>
                                  <li><a class="dropdown-item" href="#">{{trans('lang.this_year')}}</a></li>
                                </ul>
                              </div>
              
                              <div class="card-body">
                                <h5 class="card-title">{{trans('lang.sales')}} <span>| {{trans('lang.today')}}</span></h5>
              
                                <div class="d-flex align-items-center">
                                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                  </div>
                                  <div class="ps-3">
                                    <h6> <?= round($today_total, 2) ?>  {{trans('lang.ryal')}}</h6>
                                    <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
              
                                  </div>
                                </div>
                              </div>
              
                            </div>
                          </div><!-- End Sales Card -->
              
                       
              
                    </div>
                  </section>
                    @endif

                </div>
            </div>
        </div>

@endsection


<script>

// window.Echo.channel('AppChannel_8')
// .listen('.myNotify', (e) => {
//   console.log(e);
// })
    window.Echo.channel('AppChannel_8')
    .listen('.App\\Events\\AppWebsocket', (e) => {
        console.log(e);
    });

</script>