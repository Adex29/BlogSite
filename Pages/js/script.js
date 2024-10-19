$(document).ready(function () {
const usersTable = $("#usersTable").DataTable({
  paging: false,
  scrollY: "400px", 
  scrollCollapse: true,
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


$('#searchInputUser').on('keyup', function () {
  usersTable.search(this.value).draw();
});


  $("#commentsTable").DataTable({
    columns: [
      { title: "Author" },
      { title: "Commnent" },
      { title: "Status" },
      { title: "Actions" },
    ],
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

    paging: false,
  });

  const $carousel = $("#carouselExampleSlidesOnly");
  const $nextBtn = $("#nextBtn");
  const $prevBtn = $("#prevBtn");
  const $savePostBtn = $("#savePostBtn");
  const $carouselItems = $(".carousel-item");

  let currentIndex = 0;
  const totalItems = $carouselItems.length;


  $carousel.carousel({
    interval: false,
  });

 
  $carousel.on("slid.bs.carousel", function () {
    currentIndex = $carouselItems.index($carouselItems.filter(".active"));
    updateButtons();
  });


  $nextBtn.on("click", function () {
    $carousel.carousel("next");
  });

  $prevBtn.on("click", function () {
    $carousel.carousel("prev");
  });

  
  function updateButtons() {
    if (currentIndex === totalItems - 1) {
      $nextBtn.addClass("d-none"); 
      $savePostBtn.removeClass("d-none");
    } else {
      $nextBtn.removeClass("d-none");
      $savePostBtn.addClass("d-none");
    }

    if (currentIndex === 0) {
      $prevBtn.addClass("d-none"); 
    } else {
      $prevBtn.removeClass("d-none");
    }
  }

  updateButtons();
});
