<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

<!-- Add this to your modal.blade.php -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Password has been reset to:</p>
                <input type="text" id="passwordInput" class="form-control" value="{{ $randomPassword }}" readonly>
                <button id="copyButton" class="btn btn-primary" data-clipboard-target="#passwordInput">Copy to Clipboard</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize Clipboard.js
    new ClipboardJS('#copyButton');

    // Show the modal
    $(document).ready(function () {
        $('#resetPasswordModal').modal('show');
    });
</script>
