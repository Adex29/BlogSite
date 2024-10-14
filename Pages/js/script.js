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

  $("#postsTable").DataTable({
    columns: [
      { title: "Title" },
      { title: "Category" },
      { title: "Status" },
      { title: "Actions" },
    ],
    searching: false,
    paging: false,
  });

  $("#mediaTable").DataTable({
    columns: [{ title: "Title" }, { title: "Type" }, { title: "Actions" }],
    searching: false,
    paging: false,
  });

  const quill = new Quill("#postContentContainer", {
    theme: "snow",
  });

  const $carousel = $("#carouselExampleSlidesOnly");
  const $nextBtn = $("#nextBtn");
  const $prevBtn = $("#prevBtn");
  const $savePostBtn = $("#savePostBtn");
  const $carouselItems = $(".carousel-item");

  let currentIndex = 0;
  const totalItems = $carouselItems.length;

  // Add event listener to the carousel to track the active item
  $carousel.on("slid.bs.carousel", function () {
    currentIndex = $carouselItems.index($carouselItems.filter(".active"));
    updateButtons();
  });

  function updateButtons() {
    // Show or hide buttons based on the active slide
    if (currentIndex === totalItems - 1) {
      $nextBtn.addClass("d-none"); // Hide "Next" button
      $savePostBtn.removeClass("d-none"); // Show "Save Post" button
    } else {
      $nextBtn.removeClass("d-none"); // Show "Next" button
      $savePostBtn.addClass("d-none"); // Hide "Save Post" button
    }

    // Show "Prev" button only if we're not on the first slide
    if (currentIndex === 0) {
      $prevBtn.addClass("d-none"); // Hide "Prev" button on the first slide
    } else {
      $prevBtn.removeClass("d-none"); // Show "Prev" button
    }
  }

  updateButtons();
});
