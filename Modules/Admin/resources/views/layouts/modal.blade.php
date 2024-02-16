<div class="modal fade" id="modalGlobal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="btn-close" data-modal="#modalGlobal"
                    onclick="common.hideModal(this)"></button>
            </div>
            <div class="modal-body">
                <div id="content">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-modal="#modalGlobal"
                        onclick="common.hideModal(this)">Close</button>
                    <div id="additionalButtons">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
