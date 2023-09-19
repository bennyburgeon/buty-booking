<div>
    <br>
    <h4>@lang('app.edit') @lang('app.currency_setting_format')</h4>

    <form class="form-horizontal ajax-form" id="currency-settings-formats" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mr-1">@lang('app.currency')
                                @lang('app.position')</label><span data-toggle="tooltip" data-placement="top" title="@lang('app.currency_position_tooltip')"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
                            <select name="currency_position" id="currency_position"
                                class="form-control form-control-lg">
                                <option
                                    {{ $currency_settings_formats->currency_position == 'left' ? 'selected' : '' }}
                                    value="left">@lang('app.left') </option>
                                <option
                                    {{ $currency_settings_formats->currency_position == 'right' ? 'selected' : '' }}
                                    value="right">@lang('app.right') </option>
                                <option
                                    {{ $currency_settings_formats->currency_position == 'left_with_space' ? 'selected' : '' }}
                                    value="left_with_space">@lang('app.leftWithSpace') </option>
                                <option
                                    {{ $currency_settings_formats->currency_position == 'right_with_space' ? 'selected' : '' }}
                                    value="right_with_space">@lang('app.rightWithSpace') </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mr-1">@lang('app.thousand_seperator')</label><span data-toggle="tooltip" data-placement="top" title="@lang('app.thousand_seperator_tooltip')"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
                            <input type="text" class="form-control form-control-lg" id="thousand_separator"
                                name="thousand_separator"
                                value="{{ $currency_settings_formats->thousand_separator }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mr-1">@lang('app.decimal_seperator')</label><span data-toggle="tooltip" data-placement="top" title="@lang('app.decimal_seperator_tooltip')"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
                            <input type="text" class="form-control form-control-lg" id="decimal_separator"
                                name="decimal_separator" value="{{ $currency_settings_formats->decimal_separator }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mr-1">@lang('app.no_of_decimal')</label><span data-toggle="tooltip" data-placement="top" title="@lang('app.no_of_decimal_tooltip')"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
                            <input type="text" class="form-control form-control-lg" id="no_of_decimal"
                                name="no_of_decimal" value="{{ $currency_settings_formats->no_of_decimal }}">
                        </div>
                    </div>
                </div>
                <div class="row border-top border-bottom m-2 pt-3 pb-3">
                    @lang('app.sample') - &nbsp; <sapn id="formatted_currency">
                        {{ currencyFormatter(1234567.89) }}</sapn>
                </div>

                <div class="form-group">
                    <button id="save-currency-settings-format" type="button" class="btn btn-success"><i
                            class="fa fa-check"></i> @lang('app.save')</button>
                </div>
            </div>
        </div>
    </form>

</div>

