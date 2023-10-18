@if ($newDeals !== null)
    <div class="modal fade" id="newDealModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="closebtn" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <a href="{{ $newDeals->link }}"> <img style="width:1000px;"
                        src="{{ $newDeals->new_deal_image_url }}" /></a>

            </div>
        </div>
    </div>
@endif
