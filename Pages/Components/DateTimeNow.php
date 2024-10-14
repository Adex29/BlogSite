<h4 id="datetime"></h4>
<script>
    var dateElement = document.getElementById("datetime");
    function updateDateTime() {
        var d = new Date();
        dateElement.innerHTML = d.toLocaleString();
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

</script>