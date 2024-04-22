document.addEventListener("DOMContentLoaded", function() {
  const sort = document.getElementById("sort");
  const currentUrl = new URL(window.location.href);
  const pages = document.querySelectorAll('.page');
  const formFilter = document.getElementById('form-filter');

  formFilter.onsubmit = function(event) {
    event.preventDefault();
    let route = document.querySelector('#route');

    let value = null;
    let key = null;

    switch (true) {
      case currentUrl.searchParams.has('banner'):
        value = currentUrl.searchParams.get('banner')
        key = 'banner';
        break;
      case currentUrl.searchParams.has('brand-name'):
        value = currentUrl.searchParams.get('brand-name')
        key = 'brand-name';
        break;
      case currentUrl.searchParams.has('category-name'):
        value = currentUrl.searchParams.get('category-name')
        key = 'category-name';
        break;
      case currentUrl.searchParams.has('q'):
        value = currentUrl.searchParams.get('q')
        key = 'q';
        break;
      
    }

    route.name = key;
    route.value = value;

    this.submit();
    
  }

  switch (true) {
    case currentUrl.searchParams.has('sort'):
      selectedSort = currentUrl.searchParams.get('sort');

      for (let i = 0; i < sort.options.length; i++) {
        if (sort.options[i].value === selectedSort) {
          sort.options[i].selected = true;
          break;
        }
      }

    case currentUrl.searchParams.has('discount'):
      selectedSort = currentUrl.searchParams.get('discount');
      const discount = document.querySelectorAll('input[name="discount"]');

      for (let i = 0; i < discount.length; i++) {
        if (discount[i].value === selectedSort) {
          discount[i].checked = true;
          document.querySelector('#filter-discount .open-filter').classList.add('hidden')
          document.querySelector('#filter-discount .close-filter').classList.remove('hidden')
          document.querySelector('#filter-discount ul').classList.remove('hidden')
          break;
        }
      }

    case currentUrl.searchParams.has('brand[]'):
      const brand = document.querySelectorAll('input[name="brand[]"]');
      selectedSort = currentUrl.searchParams.getAll('brand[]');
      let select = false;
      
      for (var i = 0; i < brand.length; i++) {
        for (var j = 0; j < selectedSort.length; j++) {
          if (brand[i].value === selectedSort[j]) {
            brand[i].checked = true;
            select = true;
          }
        }
      }

      if (select) {
        document.querySelector('#filter-brand .open-filter').classList.add('hidden')
        document.querySelector('#filter-brand .close-filter').classList.remove('hidden')
        filter = document.querySelector('#filter-brand ul').classList.remove('hidden')
      }
    
    case currentUrl.searchParams.has('minprice'):
      const minInput = document.querySelector('#minprice');
      const maxInput = document.querySelector('#maxprice');
      minInput.value = currentUrl.searchParams.get('minprice');
      maxInput.value = currentUrl.searchParams.get('maxprice');
      if (currentUrl.searchParams.has('minprice')) {
        document.querySelector('#filter-price .open-filter').classList.add('hidden')
        document.querySelector('#filter-price .close-filter').classList.remove('hidden')
        document.querySelector('#filter-price ul').classList.remove('hidden')
      }
  }

  sort.addEventListener("change", function() {
    let sortBy = this.value;

    let newUrl = new URL(currentUrl);
    newUrl.searchParams.set('sort', sortBy);

    window.location.href = newUrl.toString();
  });


  pages.forEach((page) => {
    page.addEventListener("click", function() {
      const pageBy = this.getAttribute("data");
  
      let newUrl = new URL(currentUrl);
      newUrl.searchParams.set('page', pageBy);
  
      window.location.href = newUrl.toString();
    });
  })


});