

document.addEventListener('DOMContentLoaded', function() {
  const  messages = document.querySelectorAll('#message article');
  messages.forEach((msg)=>{
    setTimeout(() => {
      msg.remove();
    }, 3000);
  });
});


// This will highlight current page automatically in the aside bar (NOT WORKING CURRENTLY SEE WHY LATER)

const asideLinks = document.querySelectorAll('#contentNav .nav-link');
const curPath = window.location.pathname;

asideLinks.forEach((link)=>{
  if (link.getAttribute('href') === curPath) {
    link.classList.add('active');
  }
  else{
    link.classList.remove('active');
  }
});

