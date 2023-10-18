<?php

namespace App\Http\Middleware;

use Closure;
use App\SmsSetting;
use App\Helper\Reply;

class MobileVerifyRedirect
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $smsSetting = SmsSetting::first();

        if ($smsSetting->nexmo_status == 'active') {
            if (!auth()->user()->mobile_verified) {
                if ($request->ajax()) {
                    return response(Reply::error(__('messages.front.errors.verifyMobile')));
                }

                return redirect()->back();
            }

            return $next($request);
        }

        return $next($request);
    }

}
