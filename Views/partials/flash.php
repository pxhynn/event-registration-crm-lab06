<?php
$success_msg = get_flash('success');
$error_msg   = get_flash('error');
?>

<script>
if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_RELOAD) {
    document.addEventListener("DOMContentLoaded", function() {
        const flashAlerts = document.querySelectorAll('.alert');
        flashAlerts.forEach(function(alert) {
            alert.remove();
        });
    });
}
</script>
<?php if ($success_msg): ?>
    <div class="alert alert-success">
        <?= e($success_msg) ?>
    </div>
<?php endif; ?>

<?php if ($error_msg): ?>
    <div class="alert alert-danger">
        <?= e($error_msg) ?>
    </div>
<?php endif; ?>