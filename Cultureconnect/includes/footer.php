        </div> <!-- Close container-fluid -->
    </div> <!-- Close main-content -->
</div> <!-- Close dashboard-wrapper -->

<!-- GLOBAL CONFIRM DELETE MODAL -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body p-5 text-center">
                <div class="icon-box bg-danger-soft text-danger mx-auto mb-4" style="width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h4 class="fw-800 mb-2">Are you sure?</h4>
                <p class="text-muted smaller mb-4">This action is permanent and cannot be undone. All associated data will be removed.</p>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light px-4 py-2 fw-bold border flex-grow-1" data-bs-dismiss="modal">Cancel</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger px-4 py-2 fw-bold shadow-sm flex-grow-1">Delete Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function confirmDelete(url) {
    document.getElementById('confirmDeleteBtn').setAttribute('href', url);
    var myModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    myModal.show();
}
</script>
</body>
</html>
