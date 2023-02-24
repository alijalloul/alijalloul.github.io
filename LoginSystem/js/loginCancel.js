const logincancelbtn = document.getElementById('logincancelbtn');

logincancelbtn.addEventListener('click', () => {

    document.getElementsByName('mailuid')[0].value = "";
    document.getElementsByName('login-pwd')[0].value = "";
});