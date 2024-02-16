

  <div class="modal fade" id="modal-{{ $orderHistory['order_history_id'] }}" tabindex="-1" role="dialog"
        aria-labelledby="size-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel">You sure you want to cancel this order?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    Cancel this order
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-danger" data-bs-dismiss="modal"
                        onclick="orderHistory.cancelOrder({{ $orderHistory['order_history_id'] }})"
                        id="cancelOrder-{{ $orderHistory['order_history_id'] }}">
                        Request Cancellation
                    </button>
                </div>
            </div>
        </div>
    </div>
