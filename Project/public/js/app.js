

document.addEventListener('DOMContentLoaded', function() {
  const  messages = document.querySelectorAll('#message article');
  messages.forEach((msg)=>{
    setTimeout(() => {
      msg.remove();
    }, 3000);
  });
});