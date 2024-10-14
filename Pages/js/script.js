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

          if (row.status === 'Published') {
            return `<span class="badge bg-primary">Published</span>
            <br>
            <span">${last_update}</span>`;
          } else {
            return `<span class="badge bg-secondary">Draft</span>
            <br>
            <span">${last_update}</span>`;;
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

  const quill = new Quill("#postContentContainer", {
    theme: "snow",
    modules: {
      toolbar: [
        [{ header: [1, 2, 3, false] }],
        ["bold", "italic", "underline", "strike"],
        [{ list: "ordered" }, { list: "bullet" }],
        ["blockquote", "code-block"],
        [{ script: "sub" }, { script: "super" }], // Superscript / subscript
        [{ indent: "-1" }, { indent: "+1" }], // Indent
        [{ direction: "rtl" }], // Text direction
        [{ color: [] }, { background: [] }], // Dropdown with default and custom colors
        [{ align: [] }],
        ["link", "image", "video"], // Insert links, images, and videos
        ["clean"], // Remove formatting
      ],
    },
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
