<script>
    function setSlug() {
        var theTitle = document.getElementById("inputTitle").value.toLowerCase().trim();

        var theSlug = theTitle.replace(/&/g, '-and-')
            .replace(/[^a-z0-9-]+/g, '-')
            .replace(/\-\-+/g, '-')
            .replace(/^-+|-+$/g, '');

        document.getElementById("inputSlug").value = theSlug;
    }
</script>