document.addEventListener("DOMContentLoaded", function() {
  const sort = document.querySelectorAll(".sort");
  const currentUrl = new URL(window.location.href);

  if (currentUrl.searchParams.has('sort')) {
      const selectedSort = currentUrl.searchParams.get('sort');

      for (let i = 0; i < sort.length; i++) {
        if (sort[i].getAttribute("data") == selectedSort) {
          sort[i].classList.add('active');
        } else {
          sort[i].classList.remove('active');
        }
      }
  }
  for (let i = 0; i < sort.length; i++) {
      sort[i].addEventListener("click", function() {
      const sortBy = sort[i].getAttribute("data");
  
      const newUrl = new URL(currentUrl);
      newUrl.searchParams.set('sort', sortBy);
  
      window.location.href = newUrl.toString();
      });
  }

  const rateList = document.querySelectorAll('.rate-list');

  rateList.forEach((list) => {
    list.onclick = function(e) {
      let rateItem = list.querySelectorAll('.rate-item')
      let fillIcon = list.querySelectorAll('.fill')
      let unfillIcon = list.querySelectorAll('.unfill')
      
      rateItem.forEach((item, index) => {
        if (e.target.parentElement === item) {
          for (let i = 0; i <= index; i++) {
            fillIcon[i].classList.remove('hidden');
            unfillIcon[i].classList.add('hidden');
          }
          for (let i = 4; i > index ; i--) { 
            fillIcon[i].classList.add('hidden');
            unfillIcon[i].classList.remove('hidden');
          }
          let input = list.querySelector('input');
          input.value = index + 1;
        }
      })

    }
  })



});