<!-- header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kilimo Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Additional styles for the sidebar */
        @media (min-width: 640px) {
            .nav-sidebar {
                display: flex;
            }
            .nav-mobile {
                display: none;
            }
        }
        @media (max-width: 639px) {
            .nav-sidebar {
                display: none;
            }
            .nav-mobile {
                display: flex;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">

    <!-- Sidebar Navigation -->
    <div class="nav-sidebar fixed top-1/10 left-0 h-4/5 w-64 bg-gray-800 text-white flex flex-col items-center py-8 space-y-4">
        <a href="home.php" class="w-full text-center py-2 px-4 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'bg-green-500 font-bold' : ''; ?>">Home</a>
        <a href="/login" class="w-full text-center py-2 px-4 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'bg-green-500 font-bold' : ''; ?>">Login/Signup</a>
        <a href="/profile" class="w-full text-center py-2 px-4 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'bg-green-500 font-bold' : ''; ?>">Profile</a>
        <a href="/about" class="w-full text-center py-2 px-4 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'bg-green-500 font-bold' : ''; ?>">About Us</a>
        <a href="/contact" class="w-full text-center py-2 px-4 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'bg-green-500 font-bold' : ''; ?>">Contact Us</a>
    </div>

    <!-- Mobile Navigation (Hamburger Menu) -->
    <div class="nav-mobile fixed top-0 left-0 w-full bg-gray-800 text-white flex items-center justify-between p-4">
        <div class="text-xl font-bold">Kilimo Forum</div>
        <button id="menu-toggle" class="text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
        </button>
    </div>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="fixed inset-0 bg-gray-800 text-white flex flex-col items-center space-y-4 pt-16 pb-8 hidden">
        <a href="home.php" class="w-full text-center py-2 px-4 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'bg-green-500 font-bold' : ''; ?>">Home</a>
        <a href="/login" class="w-full text-center py-2 px-4 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'bg-green-500 font-bold' : ''; ?>">Login/Signup</a>
        <a href="/profile" class="w-full text-center py-2 px-4 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'bg-green-500 font-bold' : ''; ?>">Profile</a>
        <a href="/about" class="w-full text-center py-2 px-4 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'bg-green-500 font-bold' : ''; ?>">About Us</a>
        <a href="/contact" class="w-full text-center py-2 px-4 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'bg-green-500 font-bold' : ''; ?>">Contact Us</a>
    </div>
