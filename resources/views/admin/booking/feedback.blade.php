<div class="modal-header">
    <h4>@lang('menu.writeYourFeedback')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <section class="mt-3 mb-3">
        <form class="form-horizontal ajax-form" id="feedbackForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <h6 class="col-md-12 text-primary">@lang('app.message')</h6>
                    <div class="form-group">
                        <textarea name="customer_feedback" id="customer_feedback" cols="30" class="form-control-lg form-control"
                            rows="5"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button id="save-feedback-form" type="button" class="btn btn-success">
                            <i class="fa fa-check"></i> @lang('app.submit')</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>

<script>

$('#save-feedback-form').click(function () {
        const form = $('#feedbackForm');
        $.easyAjax({
            url: '{{ route('admin.give-us-feedback', $booking->id)}}',
            container: '#feedbackForm',
            type: "POST",
            file:true,
            redirect: true,
            data: form.serialize(),
            success: function (response) {
                if (response.status == "success") {
                    $('.custFeedback').addClass('d-none');
                    $('.custFeedbackSmileys').addClass('d-none');
                    $('.cust_feedback_msg_title').removeClass('d-none');
                    $('.cust_feedback_msg').removeClass('d-none').html(response.view).fadeIn('slow');
                    $('#coupon-detail-modal').modal('hide');
                }
            }
        })
    });

</script>
