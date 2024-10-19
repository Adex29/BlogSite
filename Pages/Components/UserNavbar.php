<?php 

if(!isset($_SESSION)){
  session_start();
}
?>

<div class="navbar bg-base-300">
  <div class="flex-1">
    <a href="HomePage.php" class="btn btn-ghost text-xl">Home</a>
    <a href="AboutUs.php" class="btn btn-ghost text-xl">About</a>
    <a href="Contact.php" class="btn btn-ghost text-xl">Contact</a>
  </div>

  <div class="flex-none">
    <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img
            alt="User Avatar"
            src="../images/noaim.jpg" />
        </div>
      </div>
      <ul
        tabindex="0"
        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
        
        <?php if (isset($_SESSION['isLoggedIn'])): ?>
          <li><a href="../Components/logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="Login.php">Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</div>
