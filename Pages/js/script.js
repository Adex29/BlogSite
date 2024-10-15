$(document).ready(function () {
  $("#usersTable").DataTable({
    searching: false,
    paging: false,
    scrollY: "400px", // Set the fixed height for the scrollable area
    scrollCollapse: true, // Allow the table to shrink when there's less content
    ajax: {
      url: "../Actions/dashBoard.php",
      type: "POST",
      data: { action: "getUsers" },
      dataType: "json",
      dataSrc: function (json) {
        console.log(json);
        return json;
      },
      error: function (xhr, error, thrown) {
        console.log(xhr.responseText);
      },
    },
    columns: [
      {
        data: null,
        title: "Name",
        render: function (data, type, row) {
          return `${row.first_name} ${row.last_name}`;
        },
      },
      { data: "email", title: "Email" },
      { data: "role", title: "Role" },
      {
        data: null,
        title: "Actions",
        render: function (data, type, row) {
          return `
            <button class="btn btn-secondary mr-2 editUserBtn" data-user-id="${row.id}">Edit</button>
            <button class="btn btn-danger ml-2 deleteUserBtn" data-user-id="${row.id}">Delete</button>
          `;
        },
      },
    ],
  });

  $("#commentsTable").DataTable({
    columns: [
      { title: "Author" },
      { title: "Commnent" },
      { title: "Status" },
      { title: "Actions" },
    ],
    searching: false,
    paging: false,
  });

  // Initialize the posts DataTable
  $("#postsTable").DataTable({
    searching: false,
    paging: false,
    scrollY: "400px",
    scrollCollapse: true,
    ajax: {
      url: "../Actions/posts.php",
      type: "POST",
      data: { action: "getPosts" },
      dataType: "json",
      dataSrc: function (json) {
        console.log(json);
        return json;
      },
      error: function (xhr, error, thrown) {
        console.log(xhr.responseText);
      },
    },
    columns: [
      { data: "title", title: "Title" },
      { data: "category", title: "Category" },
      {
        data: null,
        title: "Status",
        render: function (data, type, row) {
          let last_update;
          if(row.updated_at){
            last_update = row.updated_at;
          }else{
            last_update = row.created_at;
          }

          if (row.status === 'published') {
            return `
              <span class="badge bg-primary">Published</span>
              <span>Jay-ar Baniqued</span>
              <br>
              <span">${last_update}</span>
            `;
          } else {
            return `
              <span class="badge bg-secondary">Draft</span>
              <span>Jay-ar Baniqued</span>
              <br>
              <span">${last_update}</span>
            `;
          }
        },
      },
      

      {
        data: null,
        title: "Actions",
        render: function (data, type, row) {
          return `
          <button class="btn btn-secondary mr-2 editPostBtn" data-post-id="${row.id}">Edit</button>
          <button class="btn btn-danger ml-2 deletePostBtn" data-post-id="${row.id}">Delete</button>
        `;
        },
      },
    ],
  });

  $("#mediaTable").DataTable({
    columns: [{ title: "Title" }, { title: "Type" }, { title: "Actions" }],
    searching: false,
    paging: false,
  });

  const $carousel = $("#carouselExampleSlidesOnly");
  const $nextBtn = $("#nextBtn");
  const $prevBtn = $("#prevBtn");
  const $savePostBtn = $("#savePostBtn");
  const $carouselItems = $(".carousel-item");

  let currentIndex = 0;
  const totalItems = $carouselItems.length;

  // Initialize the carousel with interval set to false to stop auto sliding
  $carousel.carousel({
    interval: false, // Disable auto-slide
  });

  // Add event listener to track the active item after a manual slide
  $carousel.on("slid.bs.carousel", function () {
    currentIndex = $carouselItems.index($carouselItems.filter(".active"));
    updateButtons();
  });

  // Click event for "Next" button
  $nextBtn.on("click", function () {
    $carousel.carousel("next");
  });

  // Click event for "Prev" button
  $prevBtn.on("click", function () {
    $carousel.carousel("prev");
  });

  // Function to update buttons based on the current index
  function updateButtons() {
    if (currentIndex === totalItems - 1) {
      $nextBtn.addClass("d-none"); // Hide "Next" button on the last slide
      $savePostBtn.removeClass("d-none"); // Show "Save Post" button
    } else {
      $nextBtn.removeClass("d-none"); // Show "Next" button
      $savePostBtn.addClass("d-none"); // Hide "Save Post" button
    }

    if (currentIndex === 0) {
      $prevBtn.addClass("d-none"); // Hide "Prev" button on the first slide
    } else {
      $prevBtn.removeClass("d-none"); // Show "Prev" button
    }
  }

  // Initialize the button states on page load
  updateButtons();
});
