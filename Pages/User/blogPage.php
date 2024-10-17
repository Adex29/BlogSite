<?php include_once("../Components/userHeader.php"); ?>
<?php include_once("../Components/userNavbar.php"); ?>
<?php include_once("../Actions/blogPage.php"); ?>

<div>
    <div class="text-center my-10">
        <!-- Title -->
        <h1 class="md:text-5xl text-3xl font-bold ml-3">
            <?php echo isset($postContent[0]['title']) ? ($postContent[0]['title']) : 'Post Title Not Available'; ?>
        </h1>

        <!-- Centered Image -->
        <img 
            src="<?php echo isset($postContent[0]['img']) ? ($postContent[0]['img']) : 'default-image.jpg'; ?>" 
            class="w-1/2 block mx-auto mt-10" 
            alt="<?php echo isset($postContent[0]['title']) ? ($postContent[0]['title']) : 'Image'; ?>"
        />

        <!-- News tag -->
        <p class="md:text-lg mt-5 text-teal-900"><?php echo isset($postContent[0]['category']) && !empty($postContent[0]['category']) ? ($postContent[0]['category']) : 'Unknown Cetegory'; ?></p>

        <!-- Author and Date -->
        <div class="flex justify-center mt-3">
            <p class="px-2">
                <i class="fa fa-user" aria-hidden="true"></i> 
                <?php echo isset($postContent[0]['author']) && !empty($postContent[0]['author']) ? ($postContent[0]['author']) : 'Unknown Author'; ?>
            </p>
            <p class="px-2">
                <i class="fa fa-calendar" aria-hidden="true"></i> 
                <?php echo isset($postContent[0]['created_at']) ? date("F j, Y", strtotime($postContent[0]['created_at'])) : 'Unknown Date'; ?>
            </p>
        </div>

        <!-- Content Section -->
        <div class="prose w-3/4 mx-auto mt-5 text-left">
            <?php if (isset($postContent[0]['content'])): ?>
            <?php echo ($postContent[0]['content']); ?>
            <?php else: ?>
                <p>Content not available for this post.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once("../Components/userFooter.php"); ?>

<?php
include_once("../database/DB.class.php");

$postContent = null; // Initialize variable to hold post data

// Check if postId is passed
if (isset($_GET['postId'])) {
    $id = $_GET['postId'];
    try {
        // Create DB instance
        $db = new DB();

        // Fetch post data from 'posts' table based on postId from URL
        $postContent = $db->getRows('posts', ['id' => $id]);

    } catch (Exception $e) {
        // Handle exception if there's an issue fetching the post
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Post ID not provided!";
}
?>
