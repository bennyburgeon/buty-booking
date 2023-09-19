<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Social Auth
Route::get('/redirect/{provider}', ['uses' => 'Auth\LoginController@redirect', 'as' => 'social.login']);
Route::get('/callback/{provider}', ['uses' => 'Auth\LoginController@callback', 'as' => 'social.login-callback']);
Route::post('/zoom-webhook', 'ZoomWebhookController@index')->name('zoom-webhook');

Auth::routes();

// Admin routes
Route::group(['middleware' => 'auth'], function () {

    // Route::post('mark-notification-read', ['uses' => 'NotificationController@markAllRead'])->name('mark-notification-read');

    // Admin routes
    Route::group(
        ['namespace' => 'Admin', 'prefix' => 'account', 'as' => 'admin.'], function () {

            Route::post('business-services/delete-image/{id}', 'BusinessServiceController@deleteImage')->name('business-services.deleteImage');
            Route::post('business-services/store-images', 'BusinessServiceController@storeImages')->name('business-services.storeImages');
            Route::post('business-services/update-images', 'BusinessServiceController@updateImages')->name('business-services.updateImages');

            Route::get('coupons/data', 'CouponController@data')->name('coupons.data');

            Route::post('todo-items/update-todo-item', 'TodoItemController@updateTodoItem')->name('todo-items.updateTodoItem');

            Route::post('save-booking-times-field', 'SettingController@saveBookingTimesField')->name('save-booking-times-field');

            Route::post('getStartedNote/{id}', 'FrontSettingController@getStartedNote')->name('getStartedNote');

            Route::resources([
                'locations' => 'LocationController',
                'categories' => 'CategoryController',
                'business-services' => 'BusinessServiceController',
                'pages' => 'PageController',
                'settings' => 'SettingController',
                'booking-times' => 'BookingTimeController',
                'tax-settings' => 'TaxSettingController',
                'currency-settings' => 'CurrencySettingController',
                'language-settings' => 'LanguageSettingController',
                'email-settings' => 'SmtpSettingController',
                'zoom-settings' => 'ZoomSettingController',
                'theme-settings' => 'ThemeSettingController',
                'front-settings' => 'FrontSettingController',
                'front-section' => 'FrontSectionController',
                'new-deal' => 'NewDealController',
                'front-theme-settings' => 'FrontThemeSettingController',
                'customers' => 'CustomerController',
                'feedback' => 'FeedbackController',
                'credential' => 'PaymentCredentialSettingController',
                'sms-settings' => 'SmsSettingController',
                'coupons' => 'CouponController',
                'sms-settings' => 'SmsSettingController',
                'todo-items' => 'TodoItemController',
                'deals' => 'DealController',
                'advertisements' => 'AdvertisementController',
                'employee-schedule' => 'EmployeeScheduleSettingController',
                'office-leaves'     => 'OfficeLeaveController',
                'google-captcha-settings' => 'GoogleCaptchaSettingController',
                'social-auth-settings' => 'SocialAuthSettingController',
            ]);

            Route::post('updateCurrencyFormat/{id}', 'CurrencySettingController@updateCurrencyFormat')->name('update_currency_format');

            Route::post('updateWorking/{id}', 'EmployeeScheduleSettingController@updateWorking')->name('updateWorking');
            // Route::get('cancelUpdate', 'EmployeeScheduleSettingController@cancelUpdate')->name('cancelUpdate');

            Route::get('change-carousel-status', 'FrontThemeSettingController@changeCarouselStatus')->name('change-carousel-status');
            Route::get('carousel-autoplay', 'FrontThemeSettingController@carouselAutoplay')->name('carousel-autoplay');
            Route::post('add-seo-details', 'FrontThemeSettingController@addSeoDetails')->name('add-seo-details');
            Route::post('choose-front-theme', 'FrontThemeSettingController@chooseThemeOption')->name('choose-front-theme');
            Route::post('selectLocation', 'DealController@selectLocation')->name('deals.selectLocation');
            Route::post('selectServices', 'DealController@selectServices')->name('deals.selectServices');
            Route::get('resetSelection', 'DealController@resetSelection')->name('deals.resetSelection');
            Route::post('makeDealWithMultipleLocation', 'DealController@makeDealWithMultipleLocation')->name('deals.makeDealWithMultipleLocation');
            Route::post('makeDeal', 'DealController@makeDeal')->name('deals.makeDeal');
            Route::post('makeDealMultipleLocation', 'DealController@makeDealMultipleLocation')->name('deals.makeDealMultipleLocation');


            Route::post('change-language/{code}', 'SettingController@changeLanguage')->name('changeLanguage');

            Route::post('change-language/{code}', 'SettingController@changeLanguage')->name('changeLanguage');
            Route::post('save-google-calendar-config', 'SettingController@saveGoogleCalendarConfig')->name('saveGoogleCalendarConfig');
            Route::post('google-map-api-key', 'SettingController@googleMapApiKey')->name('googleMapApiKey');
            Route::post('role-permission/add-role', 'RolePermissionSettingController@addRole')->name('role-permission.addRole');
            Route::post('role-permission/add-members/{role_id}', 'RolePermissionSettingController@addMembers')->name('role-permission.addMembers');
            Route::get('role-permission/get-members/{role_id}', 'RolePermissionSettingController@getMembers')->name('role-permission.getMembers');
            Route::get('role-permission/get-members-to-add/{id}', 'RolePermissionSettingController@getMembersToAdd')->name('role-permission.getMembersToAdd');
            Route::delete('role-permission/remove-member', 'RolePermissionSettingController@removeMember')->name('role-permission.removeMember');
            Route::get('role-permission/data', 'RolePermissionSettingController@data')->name('role-permission.data');
            Route::post('role-permission/toggleAllPermissions', 'RolePermissionSettingController@toggleAllPermissions')->name('role-permission.toggleAllPermissions');
            Route::resource('role-permission', 'RolePermissionSettingController');

            Route::put('change-language-status/{id}', 'LanguageSettingController@changeStatus')->name('language-settings.changeStatus');
            Route::get('smtp-settings/sent-test-email/modal', ['uses' => 'SmtpSettingController@sendTestEmailModal'])->name('email-settings.sendTestEmailModal');
            Route::get('smtp-settings/sent-test-email', ['uses' => 'SmtpSettingController@sendTestEmail'])->name('email-settings.sendTestEmail');
            Route::get('reports/earningTable', ['uses' => 'ReportController@earningTable'])->name('reports.earningTable');
            Route::post('reports/earningChart', ['uses' => 'ReportController@earningReportChart'])->name('reports.earningReportChart');
            Route::get('reports/customerTable', ['uses' => 'ReportController@customerTable'])->name('reports.customerTable');
            Route::get('reports', ['uses' => 'ReportController@index'])->name('reports.index');

            Route::get('reports/salesTable', ['uses' => 'ReportController@salesTable'])->name('reports.salesTable');
            Route::get('reports/tabularTable', ['uses' => 'ReportController@tabularTable'])->name('reports.tabularTable');
            Route::post('reports/salesChart', ['uses' => 'ReportController@salesReportChart'])->name('reports.salesReportChart');

            /* Graphical reporting section  */
            Route::get('reports/userTypeChart', ['uses' => 'ReportController@userTypeChart'])->name('reports.userTypeChart');
            Route::get('reports/serviceTypeChart', ['uses' => 'ReportController@serviceTypeChart'])->name('reports.serviceTypeChart');
            Route::get('reports/bookingSourceChart', ['uses' => 'ReportController@bookingSourceChart'])->name('reports.bookingSourceChart');
            Route::post('reports/bookingPerDayChart', ['uses' => 'ReportController@bookingPerDayChart'])->name('reports.bookingPerDayChart');
            Route::post('reports/paymentPerDayChart', ['uses' => 'ReportController@paymentPerDayChart'])->name('reports.paymentPerDayChart');
            Route::post('reports/bookingPerMonthChart', ['uses' => 'ReportController@bookingPerMonthChart'])->name('reports.bookingPerMonthChart');
            Route::post('reports/paymentPerMonthChart', ['uses' => 'ReportController@paymentPerMonthChart'])->name('reports.paymentPerMonthChart');
            Route::post('reports/bookingPerYearChart', ['uses' => 'ReportController@bookingPerYearChart'])->name('reports.bookingPerYearChart');
            Route::post('reports/bookingPerYearChart', ['uses' => 'ReportController@bookingPerYearChart'])->name('reports.bookingPerYearChart');
            Route::post('reports/paymentPerYearChart', ['uses' => 'ReportController@paymentPerYearChart'])->name('reports.paymentPerYearChart');

            Route::get('reports/customer', ['uses' => 'ReportController@customer'])->name('reports.customer');
            Route::get('pos/select-customer', ['uses' => 'POSController@selectCustomer'])->name('pos.select-customer');
            Route::post('/check-user-availability', ['uses' => 'POSController@checkAvailability'])->name('pos.check-user-availability');
            Route::get('pos/show-checkout-modal/{amount}', ['uses' => 'POSController@showCheckoutModal'])->name('pos.show-checkout-modal');
            Route::get('booking/show-payment-modal/{bookingId?}/{amount?}/{amount_remaining?}', ['uses' => 'POSController@showPaymentModal'])->name('pos.show-payment-modal');
            Route::get('pos/search-customer', ['uses' => 'POSController@searchCustomer'])->name('pos.search-customer');
            Route::get('pos/filter-services', ['uses' => 'POSController@filterServices'])->name('pos.filter-services');
            Route::get('pos/filter-products', ['uses' => 'POSController@filterProducts'])->name('pos.filter-products');
            Route::get('pos/addCart', ['uses' => 'POSController@addCart'])->name('pos.addCart');
            Route::post('pos/apply-coupon', ['uses' => 'POSController@applyCoupon'])->name('pos.apply-coupon');
            Route::post('pos/update-coupon', ['uses' => 'POSController@updateCoupon'])->name('pos.update-coupon');
            Route::resource('pos', 'POSController');

            Route::post('employee/changeRole', 'EmployeeController@changeRole')->name('employee.changeRole');
            Route::resource('employee', 'EmployeeController');
            Route::resource('employee-group', 'EmployeeGroupController');

            // Manage employee leaves
            Route::get('employeeLeaves', ['uses' => 'LeaveSettingController@view'])->name('employeeLeaves');
            Route::get('changeStatus/{id}', ['uses' => 'LeaveSettingController@updateStatus'])->name('changeStatus');
            Route::resource('employee-leaves', 'LeaveSettingController');

            Route::post('products/delete-image/{id}', 'ProductsController@deleteImage')->name('products.deleteImage');
            Route::post('products/store-images', 'ProductsController@storeImages')->name('products.storeImages');
            Route::post('products/update-images', 'ProductsController@updateImages')->name('products.updateImages');
            Route::resource('products', 'ProductsController');

            Route::resource('update-application', 'UpdateApplicationController');
            Route::resource('search', 'SearchController');

            Route::get('dashboard/role-login', 'ShowDashboard@roleLogin')->name('dashboard.role-login');
            Route::get('dashboard/employee-login', 'ShowDashboard@employeeLogin')->name('dashboard.employee-login');

            Route::get('dashboard', 'ShowDashboard')->name('dashboard');

            Route::post('bookings/update-coupon', ['uses' => 'BookingController@updateCoupon'])->name('bookings.update-coupon');
            Route::post('multiStatusUpdate', ['uses' => 'BookingController@multiStatusUpdate'])->name('bookings.multiStatusUpdate');
            Route::post('sendReminder', ['uses' => 'BookingController@sendReminder'])->name('bookings.sendReminder');
            Route::post('bookings/{status?}', ['uses' => 'BookingController@index'])->name('bookings.index');
            Route::post('bookings/requestCancel/{id}', ['uses' => 'BookingController@requestCancel'])->name('bookings.requestCancel');
            Route::get('bookings/download/{id}', ['uses' => 'BookingController@download'])->name('bookings.download');
            Route::get('bookings/get-invoce-pdf/{id}', ['uses' => 'BookingController@invocePdf'])->name('bookings.invocePdf');
            Route::get('bookings/print/{id}', ['uses' => 'BookingController@print'])->name('bookings.print');
            Route::get('calendar', ['uses' => 'BookingController@calendar'])->name('calendar');
            Route::get('give-feedback{id}', ['uses' => 'BookingController@showFeedbackModal'])->name('give-feedback');
            Route::post('give-us-feedback{id}', ['uses' => 'BookingController@giveUsFeedback'])->name('give-us-feedback');
            Route::put('bookings/update-booking-date/{id}', ['uses' => 'BookingController@updateBookingDate'])->name('bookings.update_booking_date');
            Route::get('bookings/add-payment', ['uses' => 'BookingController@addPayment'])->name('bookings.add_payment');

            Route::resources([
            'bookings' => 'BookingController',
            'profile' => 'ProfileController'
            ]);
            Route::post('google-notification', ['uses' => 'BookingNotifactionController@store'])->name('google.notification.store');
            Route::delete('google-notification/{id}', ['uses' => 'BookingNotifactionController@destroy'])->name('google.notification.destroy');
            Route::get('add-location', ['uses' => 'BusinessServiceController@addLocation'])->name('add-location');
            Route::get('add-category', ['uses' => 'CategoryController@addCategory'])->name('add-category');
            Route::get('add-employee-group', ['uses' => 'EmployeeGroupController@addEmployeeGroup'])->name('add-employee-group');
            Route::get('timezones', 'LocationController@getCountryTimezone')->name('timezone');
        });

    Route::get('change-mobile', 'VerifyMobileController@changeMobile')->name('changeMobile');
    Route::post('/send-otp-code', 'VerifyMobileController@sendVerificationCode')->name('sendOtpCode');
    Route::post('/send-otp-code/account', 'VerifyMobileController@sendVerificationCode')->name('sendOtpCode.account');
    Route::post('/verify-otp-phone', 'VerifyMobileController@verifyOtpCode')->name('verifyOtpCode');
    Route::post('/verify-otp-phone/account', 'VerifyMobileController@verifyOtpCode')->name('verifyOtpCode.account');
    Route::get('/remove-session', 'VerifyMobileController@removeSession')->name('removeSession');

    Route::get('/google-auth', 'GoogleAuthController@index')->name('googleAuth');
    Route::delete('/google-auth/{id}', 'GoogleAuthController@destroy')->name('googleAuth.destroy');
});

Route::group(
    ['namespace' => 'Front', 'as' => 'front.'], function () {
        Route::get('/', ['uses' => 'FrontController@index'])->name('index');
        Route::get('get-location', ['uses' => 'FrontController@getLocation'])->name('get-location');

        Route::group(['middleware' => 'cookieRedirect'], function () {
            Route::get('/booking', ['uses' => 'FrontController@bookingPage'])->name('bookingPage');
            Route::get('/checkout', ['uses' => 'FrontController@checkoutPage'])->name('checkoutPage');
        });

        Route::get('/manage-booking', ['uses' => 'FrontController@manageBooking'])->name('manageBooking');

        // get services of any category
        Route::get('{category_id?}/services', ['uses' => 'FrontController@allServices'])->name('services');

        Route::get('/cart/{url?}', ['uses' => 'FrontController@cartPage'])->name('cartPage');
        Route::get('/apply-coupon', ['uses' => 'FrontController@applyCoupon'])->name('apply-coupon');
        Route::get('/update-coupon', ['uses' => 'FrontController@updateCoupon'])->name('update-coupon');
        Route::get('/remove-coupon', ['uses' => 'FrontController@removeCoupon'])->name('remove-coupon');
        Route::get('/search', ['uses' => 'FrontController@searchServices'])->name('searchServices');
        Route::post('/add-or-update-product', ['uses' => 'FrontController@addOrUpdateProduct'])->name('addOrUpdateProduct');
        Route::post('/add-booking-details', ['uses' => 'FrontController@addBookingDetails'])->name('addBookingDetails');
        Route::post('/delete-product/{id}', ['uses' => 'FrontController@deleteProduct'])->name('deleteProduct');
        Route::post('/clear-cart-product', ['uses' => 'FrontController@clearCartProduct'])->name('clearProduct');
        Route::post('/delete-front-product/{id}', ['uses' => 'FrontController@deleteProduct'])->name('deleteFrontProduct');
        Route::post('/update-cart', ['uses' => 'FrontController@updateCart'])->name('updateCart');
        Route::post('/check-user-availability', ['uses' => 'FrontController@checkUserAvailability'])->name('checkUserAvailability');

        Route::post('/save-booking', ['uses' => 'FrontController@saveBooking'])->name('saveBooking');
        Route::group(['middleware' => 'mobileVerifyRedirect'], function () {
            Route::get('payment-gateway', array('as' => 'payment-gateway','uses' => 'FrontController@paymentGateway',));
            Route::get('offline-payment/{bookingId?}', array('as' => 'offline-payment','uses' => 'FrontController@offlinePayment',));
            Route::get('/payment-success/{paymentID?}', ['uses' => 'FrontController@paymentSuccess'])->name('payment.success');
            Route::get('/payment-fail/{paymentID?}', ['uses' => 'FrontController@paymentFail'])->name('payment.fail');
        });
        Route::post('/booking-slots', ['uses' => 'FrontController@bookingSlots'])->name('bookingSlots');
        Route::post('contact', ['uses' => 'FrontController@contact'])->name('contact');

        // Paystack payment route
        Route::get('/paystack/{bookingId?}', 'PaystackController@paymentWithPaystack')->name('paystackCallback');

        Route::get('paypal-recurring', array('as' => 'paypal-recurring','uses' => 'PaypalController@payWithPaypalRecurrring',));

        // route for view/blade file
        Route::get('paywithpaypal', array('as' => 'paywithpaypal','uses' => 'PaypalController@payWithPaypal',));
        // route for post request
        Route::get('paypal/{bookingId?}', array('as' => 'paypal','uses' => 'PaypalController@paymentWithpaypal',));
        // route for check status responce
        Route::get('paypal-status/{status?}', array('as' => 'status','uses' => 'PaypalController@getPaymentStatus',));

        Route::post('stripe/{bookingId?}', array('as' => 'stripe','uses' => 'StripeController@paymentWithStripe',));

        Route::post('razorpay', 'RazorPayController@paymentWithRazorpay')->name('razorpay');

        Route::post('change-language/{code}', 'FrontController@changeLanguage')->name('changeLanguage');

        Route::get('/{categorySlug}/{serviceSlug}', ['uses' => 'FrontController@serviceDetail'])->name('serviceDetail');

        Route::get('/deal/{dealId}/{dealSlug}', ['uses' => 'FrontController@dealDetail'])->name('dealDetail');

        Route::get('get-all-locations', ['uses' => 'FrontController@getAllLocations'])->name('get-all-locations');
        Route::post('match-locations', ['uses' => 'FrontController@matchLocations'])->name('match-locations');
        Route::get('location-name', ['uses' => 'FrontController@getLocationName'])->name('location-name');
        Route::get('/{slug}', ['uses' => 'FrontController@page'])->name('page');
    });
