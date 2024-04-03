<script src="js/sweetalert.min.js"></script>
<?php
if (isset($_SESSION['status'])) {
?>
<script>
swal({
    title: "<?php echo $_SESSION['status']; ?>",
    text: "<?php echo $_SESSION['status_text']; ?>",
    icon: "<?php echo $_SESSION['status_code']; ?>",
    button: "<?php echo $_SESSION['status_btn']; ?>",
});
</script>

<?php
    unset($_SESSION['status']);
}
?>

<script src="js/sweetalert2.all.min.js"></script>

<?php
if (isset($_SESSION['alert'])) {
?>
<script>
Swal.fire({
    position: "center",
    icon: "<?php echo $_SESSION['alert']; ?>",
    title: "<?php echo $_SESSION['alert_text']; ?>",
    showConfirmButton: false,
    timer: 1500
});
</script>
<?php
    unset($_SESSION['alert']);
}
?>