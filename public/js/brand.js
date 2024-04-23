document.addEventListener("DOMContentLoaded", function() {
  const sort = document.getElementById("sort");
  const currentUrl = new URL(window.location.href);

  if (currentUrl.searchParams.has('sort')) {
    const selectedSort = currentUrl.searchParams.get('sort');

    for (let i = 0; i < sort.options.length; i++) {
      if (sort.options[i].value === selectedSort) {
        sort.options[i].selected = true;
        break;
      }
    }
  }

  sort.addEventListener("change", function() {
    const sortBy = this.value;

    const newUrl = new URL(currentUrl);
    newUrl.searchParams.set('sort', sortBy);

    window.location.href = newUrl.toString();
  });
});