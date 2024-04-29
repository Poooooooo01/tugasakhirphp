<!-- Modal -->
<div class="modal modal-lg fade" id="detailFormModal" aria-labelledby="detailFormModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailFormModalLabel">Detail Modal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="overflow:hidden;">
                <form method="post" action="detail-receipt-post-process.php">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="modal_receipt_id" value="<?= $id; ?>">
                            <input type="hidden" name="modal_id">

                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Menu</label>
                                <select class="form-select" name="modal_menu_id" id="select2-modal"
                                    data-placeholder="Choose one">
                                    <?php
                                while ($menu = mysqli_fetch_array($menus)) {
                                    ?>
                                    <option value="<?= $menu['id']; ?>"><?= $menu['name']; ?>
                                        (<?= number_format($menu['price'], 0, '.', '.'); ?>)
                                    </option>
                                    <?php
                                }
                            ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label">Note</label>
                                <input type="text" class="form-control" name="modal_note">
                            </div>
                            <button type=" submit" name="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                        <div class="col-md-6">
                            <div class=" mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" class="form-control" name="modal_amount" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>