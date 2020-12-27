<div class="acc-sidebar">
    <?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>
    <ul class="acc-list">
        <li class="<?= ($activePage == 'orders') ? 'active':''; ?>"><a href="orders.php">Orders</a></li>
        <li class="<?= ($activePage == 'acc-info') ? 'active':''; ?>"><a href="acc-info.php">Account Info</a></li>
        <li class="<?= ($activePage == 'change-pass') ? 'active':''; ?>"><a href="change-pass.php">Change Password</a></li>
        <li class="<?= ($activePage == 'addresses') ? 'active':''; ?>"><a href="addresses.php">Addresses</a></li>
        <li class="<?= ($activePage == 'newsletter') ? 'active':''; ?>"><a href="newsletter.php">Newsletter Preferences</a></li>
    </ul>
</div>