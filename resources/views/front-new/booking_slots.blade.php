@if($bookingTime->status == 'enabled')
    @if ($bookingTime->multiple_booking === 'yes' && $bookingTime->max_booking != 0 && $bookings->count() >= $bookingTime->max_booking)
        <div class="bg-secondary p-4 pb-0 available-time text-center">
            @lang('front.maxBookingLimitReached')
        </div>
    @else
        <div class="bg-secondary p-4 pb-0 available-time text-center">
            <h6 class="font-weight-bold">Available Time</h6>
            <ul class="mb-0">
                @php $slot_count = 1; $check_remaining_booking_slots = 0; @endphp
                @for($d = $startTime;$d < $endTime;$d->addMinutes($bookingTime->slot_duration))
                    @php 
                        $slotAvailable = 1; 
                        $newDate = $d ? Carbon\Carbon::parse($d)->format($settings->time_format) : '';
                    @endphp
                    @if($bookingTime->multiple_booking === 'no' && $bookings->count() > 0)
                        @foreach($bookings as $booking)
                            @if($bookingDate && Carbon\Carbon::parse($booking->date_time)->format($settings->time_format) == $newDate)
                                @php $slotAvailable = 0; @endphp
                            @endif
                        @endforeach
                    @endif

                    @if($slotAvailable == 1)
                        @php 
                            $check_remaining_booking_slots++; 
                            $otherDate = $d ? Carbon\Carbon::parse($d)->format('H:i:s') : '';
                        @endphp
                        <li>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input id="radio{{$slot_count}}" onclick="checkUserAvailability('{{$d}}', {{$slot_count}}, '{{$newDate}}')" type="radio" value="{{ $otherDate }}" class="form-check-input me-1" name="booking_time">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">{{ $newDate }}</span>
                                </label>
                            </div>
                        </li>
                    @endif
                    @php $slot_count++; @endphp
                @endfor
            </ul>

            <!-- If time slots not available -->
            @if($slot_count==1 || $check_remaining_booking_slots==0)
                <div class="alert alert-custom text-center" style="margin-top: 108px; margin-bottom: 108px">
                    @lang('front.bookingSlotNotAvailable')
                </div>
            @endif

            <!-- select employee div -->
            <div class="text-center alert alert-custom mt-3" id="select_user_div" style="display: none;">
                <span>@lang('messages.booking.selectEmployeeMSG')</span>
                <span id="select_user"></span>
            </div>

            <div class="alert alert-custom mt-3 text-center" id="show_emp_name_div" style="display: none"></div>

            <div class="alert alert-custom mt-3" id="no_emp_avl_msg" style="display: none">
                @lang('front.noEmployeeAvailableAt') <span id="timeSpan"><span>.
            </div>

        </div>

    @endif
@else
    <div class="bg-secondary p-4 pb-0 available-time text-center">
        @lang('front.bookingSlotNotAvailable')
    </div>
@endif
