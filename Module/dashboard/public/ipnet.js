var data = "";

var xhr = new XMLHttpRequest();
xhr.withCredentials = true;

xhr.addEventListener("readystatechange", function() {
    if (this.readyState === 4) {
        console.log(this.responseText);
    }
});

xhr.open("GET", "http://14.241.224.232:8282/UserAuthentication/FreeUserList.shtml");
xhr.setRequestHeader("Cookie", "language=English; adm=admin; admpwd=e19d5cd5af0378da05f63f891c7467af; first_login_home_page=home.shtml");
xhr.send(data);
