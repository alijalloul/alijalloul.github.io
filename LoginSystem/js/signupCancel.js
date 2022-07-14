const cancelBtn = document.getElementById('signupcancelbtn');

cancelBtn.addEventListener('click', () => {

    document.getElementsByName('firstname')[0].value = "";
    document.getElementsByName('lastname')[0].value = "";
    document.getElementsByName('mail')[0].value = "";
    document.getElementsByName('username')[0].value = "";
    document.getElementsByName('pwd')[0].value = "";
    document.getElementsByName('pwd-repeat')[0].value = "";
});