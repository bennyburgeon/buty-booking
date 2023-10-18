@extends('layouts-new.front')

@section('content')
    <section class="bg-white py-100">
        <div class="container">
            <div class="row ">
                <div class="col-lg-9 m-auto col-12">
                    <form class="contact-form p-3 p-lg-5 p-md-5" id="contact_form" method="post">
                        @csrf
                        <div class="heading text-center">
                            <h3 class="font-weight-bold">@lang('front.headings.payment')</h3>
                            <br><br><br>
                            <p class="mt-0 mt-lg-2 mt-md-2 f-16 text-success">@lang('front.bookingSuccessful')</p>
                        </div>
                        <div class="row mt-30">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-6 d-flex clearCartBtnDiv justify-content-end">
                                <a href="{{ route('front.index') }}" class="primary-btn btn-md mt-4 btn f-13 h-30 d-flex mr-2">
                                    <i class="las la-home f-18 mr-2"></i> @lang('front.navigation.backToHome')
                                </a>
                                <a href="{{ route('admin.bookings.index') }}" target="_blank" class="outline-btn btn-md mt-4 btn f-13 h-30 d-flex me-4">
                                    <i class="las la-clock f-18 me-1"></i>@lang('front.viewRecentOrders')
                                </a>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

