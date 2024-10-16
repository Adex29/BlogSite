<div class="navbar bg-base-300">
  <div class="flex-1">
    <!-- Add href to link to respective PHP files -->
    <a href="HomePage.php" class="btn btn-ghost text-xl">Home</a>
    <a href="AboutUs.php" class="btn btn-ghost text-xl">About</a>
    <a href="Contact.php" class="btn btn-ghost text-xl">Contact</a>
  </div>

  <div class="flex-none">
    <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img
            alt="Tailwind CSS Navbar component"
            src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
        </div>
      </div>
      <ul
        tabindex="0"
        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
        <li>
          <a class="justify-between">
            Profile
            <span class="badge">New</span>
          </a>
        </li>
        <li><a>Settings</a></li>
        <li><a>Logout</a></li>
      </ul>
    </div>
  </div>
</div>