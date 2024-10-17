<?php include_once("../Components/userHeader.php"); ?>
<?php include_once("../Components/userNavbar.php"); ?>

<?php
  // Define student details
  $students = [
    [
      'name' => 'Jay-ar O. Baniqued',
      'course' => 'BS Information Technology',
      'year' => '4th Year',
      'image' => "../images/jay-ar.jpg"
    ],
    [
      'name' => 'Eidriel Trinidad',
      'course' => 'BS Information Technology',
      'year' => '4th Year',
      'image' => "../images/eidriel.jpg"
    ],
    [
      'name' => 'Noaim U. Piti-ilan',
      'course' => 'BS Information Technology',
      'year' => '4th Year',
      'image' => "../images/noaim.jpg"
    ]
  ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
  <div class="container mx-auto my-12 p-8 bg-white shadow-lg rounded-lg">
    <h1 class="text-4xl font-bold text-center mb-8 text-gray-800">About Us</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Loop through students array -->
      <?php foreach ($students as $student): ?>
        <div class="text-center">
          <img src="<?= $student['image'] ?>" alt="<?= $student['name'] ?> Photo" class="mx-auto rounded-full w-32 h-32 object-cover">
          <h2 class="text-2xl font-semibold mt-4 text-gray-700"><?= $student['name'] ?></h2>
          <p class="text-gray-500"><?= $student['course'] ?></p>
          <p class="text-gray-500"><?= $student['year'] ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="mt-8 text-center">
      <p class="text-gray-600 leading-relaxed">
        We are a group of passionate students from Central Luzon State University (CLSU), currently pursuing our Bachelor of Science in Information Technology. Our goal is to apply the skills we have learned to solve real-world problems, develop creative solutions, and become leaders in the tech industry.
      </p>
    </div>
  </div>
</body>
</html>

<?php include_once("../Components/userFooter.php"); ?>